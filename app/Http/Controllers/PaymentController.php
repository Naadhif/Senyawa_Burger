<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Mail;
use App\Mail\StrukMail;
use App\Jobs\HapusPesananBelumLunas;

class PaymentController extends Controller
{
    private $merchantCode;
    private $apiKey;
    private $env;

    public function __construct()
    {
        $this->merchantCode = env('DUITKU_MERCHANT_CODE');
        $this->apiKey = env('DUITKU_API_KEY');
        $this->env = env('DUITKU_ENV', 'sandbox');
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(\+62|08)[0-9]{8,13}$/'],
            'email' => 'required|email:rfc,dns',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus format Indonesia (08xxxxxxxxx atau +62xxxxxxxxx, 10-15 digit).',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $method = $request->input('paymentMethod');
        $cart = $request->input('cart', []);
        $nama = $request->input('nama');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $orderType = $request->input('orderType', 'dine_in');
        $amount = $request->input('amount');
        $catatan = $request->input('catatan');

        $tipeOrderDb = 'dine_in';
        if (str_contains(strtolower($orderType), 'bawa pulang') || str_contains(strtolower($orderType), 'take')) {
            $tipeOrderDb = 'take_away';
        }

        if (empty($cart) || !$amount) {
            return response()->json(['success' => false, 'message' => 'Data pesanan tidak lengkap'], 400);
        }

        $totalPesanan = 0;
        foreach ($cart as $item) {
            $totalPesanan += (int) $item['qty'];
        }

        // Jika metode Bayar di Kasir, TETAP langsung masuk ke Database (karena tidak perlu QRIS)
        if ($method === 'kasir') {
            $pesanan = new Pesanan();
            $pesanan->nama = $nama;
            $pesanan->no_telepon = $phone;
            $pesanan->email = $email;
            $pesanan->total_harga = $amount;
            $pesanan->total_pesanan = $totalPesanan;
            $pesanan->tipe_order = $tipeOrderDb;
            $pesanan->catatan = $catatan;
            $pesanan->status_pembayaran = 'Belum Lunas';
            $pesanan->save();

            Mail::to($pesanan->email)->send(new StrukMail($pesanan));

            foreach ($cart as $item) {
                $detail = new DetailPesanan();
                $detail->id_pesanan = $pesanan->id_pesanan;
                $detail->id_menu = $item['id'];
                $detail->jumlah = $item['qty'];
                $detail->harga_satuan = $item['price'] / $item['qty'];
                $detail->kustomisasi = $item['notes'] ?? $item['note'] ?? null;
                $detail->save();
            }

            session(['menunggu_kasir_id' => $pesanan->id_pesanan]);
            return response()->json([
                'success' => true, 
                'message' => 'Pesanan berhasil disimpan', 
                'method' => 'kasir',
                'id_pesanan' => $pesanan->id_pesanan
            ]);

            //HapusPesananBelumLunas::dispatch($pesanan->id_pesanan)->delay(now()->addSeconds(60));
            HapusPesananBelumLunas::dispatch($pesanan->id_pesanan)->delay(now()->addMinutes(20));
            return response()->json([
                'success' => true,
                'method' => 'online',
                'qrString' => $response['qrString'],
                'reference' => $response['reference']
            ]);
        }

        if ($method === 'online') {
            // Generate Order ID sementara untuk Duitku
            $tempOrderId = 'TEMP-' . time();
        }

        // --- Duitku Online QRIS ---
        $merchantOrderId = 'TRX-' . time() . '-' . Str::random(5);

        $productDetails = 'Pembayaran Pesanan ' . $merchantOrderId;
        $paymentMethod = 'SP'; 
        $returnUrl = url('/keranjang');
        $callbackUrl = url('/api/duitku/callback');

        $signature = md5($this->merchantCode . $merchantOrderId . $amount . $this->apiKey);

        $params = array(
            'merchantcode' => $this->merchantCode,
            'merchantOrderId' => $merchantOrderId,
            'paymentAmount' => $amount,
            'paymentMethod' => $paymentMethod,
            'productDetails' => $productDetails,
            'email' => $email ?: 'customer@example.com',
            'customerVaName' => $nama,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => 15
        );

        $url = "https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry";
        $response = Http::post($url, $params);

        if ($response->successful() && isset($response['qrString'])) {
            // Simpan pesanan ke Database dengan status Belum Lunas
            $pesanan = new Pesanan();
            $pesanan->nama = $nama;
            $pesanan->no_telepon = $phone;
            $pesanan->email = $email;
            $pesanan->total_harga = $amount;
            $pesanan->total_pesanan = $totalPesanan;
            $pesanan->tipe_order = $tipeOrderDb;
            $pesanan->catatan = $catatan;
            $pesanan->status_pembayaran = 'Belum Lunas';
            $pesanan->payment_reference = $response['reference'];
            $pesanan->save();

            foreach ($cart as $item) {
                $detail = new DetailPesanan();
                $detail->id_pesanan = $pesanan->id_pesanan;
                $detail->id_menu = $item['id'];
                $detail->jumlah = $item['qty'];
                $detail->harga_satuan = $item['price'] / $item['qty'];
                $detail->kustomisasi = $item['notes'] ?? $item['note'] ?? null;
                $detail->save();
            }

            session([
                'menunggu_qris_id' => $pesanan->id_pesanan,
                'menunggu_qris_qr' => $response['qrString'],
                'menunggu_qris_reference' => $response['reference']
            ]);

            //HapusPesananBelumLunas::dispatch($pesanan->id_pesanan)->delay(now()->addSeconds(60));
            HapusPesananBelumLunas::dispatch($pesanan->id_pesanan)->delay(now()->addMinutes(20));
            return response()->json([
                'success' => true,
                'method' => 'online',
                'qrString' => $response['qrString'],
                'reference' => $response['reference']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal memanggil API Duitku',
            'api_response' => $response->json()
        ], 400);
    }

    public function checkStatus($reference)
    {
        $signature = md5($this->merchantCode . $reference . $this->apiKey);

        $params = [
            'merchantCode' => $this->merchantCode,
            'reference' => $reference,
            'signature' => $signature
        ];

        $url = "https://sandbox.duitku.com/webapi/api/merchant/transactionStatus";
        $response = Http::post($url, $params);

        if ($response->successful()) {
            $statusCode = $response['statusCode'];
            if ($statusCode === "00") {
                // Payment success, update Pesanan!
                $pesanan = Pesanan::where('payment_reference', $reference)->first();
                if ($pesanan) {
                    $pesanan->status_pembayaran = 'Lunas';
                    $pesanan->save();
                }
            }

            return response()->json([
                'success' => true,
                'statusCode' => $statusCode,
                'statusMessage' => $response['statusMessage']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to check status'
        ], 400);
    }

    public function menungguKasir()
    {
        $id = session('menunggu_kasir_id');
        if (!$id) {
            return redirect('/');
        }
        $pesanan = Pesanan::with('detailPesanan.menu')->find($id);
        if (!$pesanan) {
            return redirect('/');
        }
        return view('MenungguKasir', compact('pesanan'));
    }

    public function menungguQris()
    {
        $id = session('menunggu_qris_id');
        $qrString = session('menunggu_qris_qr');
        $reference = session('menunggu_qris_reference');

        if (!$id || !$qrString || !$reference) {
            return redirect('/');
        }

        $pesanan = Pesanan::with('detailPesanan.menu')->find($id);
        if (!$pesanan) {
            return redirect('/');
        }

        //return view('MenungguQrisSimulasi', compact('pesanan', 'qrString', 'reference'));
        return view('MenungguQris', compact('pesanan', 'qrString', 'reference'));
    }

    public function checkLocalStatus($id)
    {
        $pesanan = Pesanan::find($id);
        if ($pesanan) {
            return response()->json([
                'success' => true,
                'status_pembayaran' => $pesanan->status_pembayaran
            ]);
        }
        return response()->json(['success' => false], 404);
    }

    public function callback(Request $request)
    {
        $amount = $request->input('amount');
        $merchantOrderId = $request->input('merchantOrderId');
        $resultCode = $request->input('resultCode');
        $reference = $request->input('reference');
        $signature = $request->input('signature');

        // Kalkulasi signature untuk keamanan (sesuai standar Duitku)
        $calcSignature = md5($this->merchantCode . $amount . $merchantOrderId . $this->apiKey);

        if ($signature == $calcSignature) {
            // Cari data pesanan berdasarkan reference Duitku
            $pesanan = Pesanan::where('payment_reference', $reference)->first();

            if ($pesanan) {
                if ($resultCode == "00") {
                    // Pembayaran Berhasil
                    $pesanan->status_pembayaran = 'Lunas';
                    $pesanan->save();
                    //Mail::to($pesanan->email)->send(new StrukMail($pesanan));
                    return response()->json([
                        'success' => true,
                        'message' => 'Pembayaran dikonfirmasi dan status diperbarui.',
                        'id_pesanan' => $pesanan->id_pesanan
                    ]);
                } else if ($resultCode == "01") {
                    // Pembayaran Gagal / Expired
                    $pesanan->status_pembayaran = 'Gagal';
                    $pesanan->save();
                }
            }
            
            // Duitku membutuhkan response HTTP 200 OK
            return response()->json(['success' => true]);
        } else {
            // Jika signature tidak cocok, tolak request
            return response()->json(['success' => false, 'message' => 'Bad Signature'], 400);
        }
    }

}


