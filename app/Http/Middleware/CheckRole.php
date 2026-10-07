<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in via our custom session
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $userRole = strtolower(Session::get('user.role'));

        // If specific roles are required, check them
        if (!empty($roles) && !in_array($userRole, $roles)) {
            // Redirect based on user role to their proper dashboard
            $redirectPath = match ($userRole) {
                'kasir' => '/kasir/antrian',
                'owner', 'manajer', 'admin' => '/owner/menu',
                default => '/login'
            };
            
            return redirect($redirectPath)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
