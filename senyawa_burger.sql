-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Apr 2026 pada 17.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `senyawa_burger`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `harga_satuan` decimal(10,2) NOT NULL,
  `kustomisasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id_laporan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipe_periode` enum('harian','mingguan','bulanan','tahunan') NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `total_pendapatan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_transaksi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_pesanan` int(11) NOT NULL DEFAULT 0,
  `total_terjual` int(11) NOT NULL DEFAULT 0,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `foto` blob DEFAULT NULL,
  `Kategori` varchar(255) NOT NULL,
  `status_tersedia` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `foto`, `Kategori`, `status_tersedia`) VALUES
(1, 'Americano', 11000.00, NULL, 'Coffee', 1),
(2, 'Butterscotch', 13100.00, NULL, 'Coffee', 1),
(3, 'Coffee aren', 13100.00, NULL, 'Coffee', 1),
(4, 'Ice machiatto', 13100.00, NULL, 'Coffee', 1),
(5, 'Cappuccino', 13100.00, NULL, 'Coffee', 1),
(6, 'Red Velvet', 10000.00, NULL, 'Milkshake', 1),
(7, 'Taro', 10000.00, NULL, 'Milkshake', 1),
(8, 'Vanilla', 10000.00, NULL, 'Milkshake', 1),
(9, 'Cappuccino', 10000.00, NULL, 'Milkshake', 1),
(10, 'Coklat', 10000.00, NULL, 'Milkshake', 1),
(11, 'Dark Choco', 11000.00, NULL, 'Milkshake', 1),
(12, 'CHOCO Cheese', 13000.00, NULL, 'Milkshake', 1),
(13, 'Milo', 12000.00, NULL, 'Milkshake', 1),
(14, 'Cheese Milo', 15000.00, NULL, 'Milkshake', 1),
(15, 'Ovaltine', 12000.00, NULL, 'Milkshake', 1),
(16, 'Chakies & Cream', 13000.00, NULL, 'Milk & Cream', 1),
(17, 'Lotus Milk & Cream', 13000.00, NULL, 'Milk & Cream', 1),
(18, 'Brown sugar', 10000.00, NULL, 'Milk & Cream', 1),
(19, 'Thai tea', 10000.00, NULL, 'Teh', 1),
(20, 'Green tea', 10000.00, NULL, 'Teh', 1),
(21, 'Lemon tea', 10000.00, NULL, 'Teh', 1),
(22, 'Green tea lemon', 10000.00, NULL, 'Teh', 1),
(23, 'Lachy tea', 10000.00, NULL, 'Teh', 1),
(24, 'Coffee Matcha', 13000.00, NULL, 'Series', 1),
(25, 'Strawberry Matcha', 13000.00, NULL, 'Series', 1),
(26, 'Cheese Matcha Fruit', 13000.00, NULL, 'Series', 1),
(27, 'Strawberry milk', 13000.00, NULL, 'Series', 1),
(28, 'Strawberry Cheese milk', 13000.00, NULL, 'Series', 1),
(29, 'Manggo Yakult / soda', 12000.00, NULL, 'Series', 1),
(30, 'Orange Yakult / soda', 12000.00, NULL, 'Series', 1),
(31, 'Chicken Burger', 15100.00, NULL, 'Burger', 1),
(32, 'Chicken Cheese', 17100.00, NULL, 'Burger', 1),
(33, 'Chicken Egg', 18100.00, NULL, 'Burger', 1),
(34, 'Beef Burger', 18100.00, NULL, 'Burger', 1),
(35, 'Beef Cheese', 20100.00, NULL, 'Burger', 1),
(36, 'Beef Egg', 21100.00, NULL, 'Burger', 1),
(37, 'Kebab Chicken', 15100.00, NULL, 'Kebab', 1),
(38, 'Kebab Chicken Cheese', 17100.00, NULL, 'Kebab', 1),
(39, 'Kebab Chicken Egg', 18100.00, NULL, 'Kebab', 1),
(40, 'Kebab Beef', 18100.00, NULL, 'Kebab', 1),
(41, 'Kebab Beef Cheese', 20100.00, NULL, 'Kebab', 1),
(42, 'Kebab Beef Egg', 21100.00, NULL, 'Kebab', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_bahan`
--

CREATE TABLE `menu_bahan` (
  `id_menu` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `jumlah_digunakan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu_bahan`
--

INSERT INTO `menu_bahan` (`id_menu`, `id_bahan`, `jumlah_digunakan`) VALUES
(1, 1, 15.00),
(1, 3, 20.00),
(1, 4, 150.00),
(2, 1, 15.00),
(2, 2, 200.00),
(2, 3, 20.00),
(2, 4, 150.00),
(3, 1, 15.00),
(3, 2, 200.00),
(3, 3, 20.00),
(3, 4, 150.00),
(4, 1, 15.00),
(4, 2, 200.00),
(4, 3, 20.00),
(4, 4, 150.00),
(5, 1, 15.00),
(5, 2, 200.00),
(5, 3, 20.00),
(5, 4, 150.00),
(6, 2, 200.00),
(6, 4, 150.00),
(6, 11, 30.00),
(7, 2, 200.00),
(7, 4, 150.00),
(7, 12, 30.00),
(8, 2, 200.00),
(8, 4, 150.00),
(8, 13, 30.00),
(9, 2, 200.00),
(9, 4, 150.00),
(9, 14, 30.00),
(10, 2, 200.00),
(10, 4, 150.00),
(10, 15, 30.00),
(11, 2, 200.00),
(11, 4, 150.00),
(11, 16, 30.00),
(12, 2, 200.00),
(12, 4, 150.00),
(12, 9, 20.00),
(12, 17, 30.00),
(13, 2, 200.00),
(13, 4, 150.00),
(13, 7, 30.00),
(14, 2, 200.00),
(14, 4, 150.00),
(14, 7, 30.00),
(14, 9, 20.00),
(14, 18, 30.00),
(15, 2, 200.00),
(15, 4, 150.00),
(15, 8, 30.00),
(16, 2, 200.00),
(16, 4, 150.00),
(16, 19, 30.00),
(17, 2, 200.00),
(17, 4, 150.00),
(17, 20, 30.00),
(18, 2, 200.00),
(18, 4, 150.00),
(18, 21, 30.00),
(19, 3, 20.00),
(19, 4, 150.00),
(19, 22, 10.00),
(20, 3, 20.00),
(20, 4, 150.00),
(20, 23, 10.00),
(21, 3, 20.00),
(21, 4, 150.00),
(21, 24, 30.00),
(22, 3, 20.00),
(22, 4, 150.00),
(22, 23, 10.00),
(22, 24, 30.00),
(23, 3, 20.00),
(23, 4, 150.00),
(23, 25, 10.00),
(24, 1, 15.00),
(24, 2, 200.00),
(24, 3, 20.00),
(24, 4, 150.00),
(24, 5, 10.00),
(25, 2, 200.00),
(25, 3, 20.00),
(25, 4, 150.00),
(25, 5, 10.00),
(25, 28, 30.00),
(26, 2, 200.00),
(26, 3, 20.00),
(26, 4, 150.00),
(26, 5, 10.00),
(26, 9, 20.00),
(27, 2, 200.00),
(27, 3, 20.00),
(27, 4, 150.00),
(27, 28, 30.00),
(28, 2, 200.00),
(28, 3, 20.00),
(28, 4, 150.00),
(28, 9, 20.00),
(28, 28, 30.00),
(29, 3, 20.00),
(29, 4, 150.00),
(29, 26, 1.00),
(29, 29, 30.00),
(30, 3, 20.00),
(30, 4, 150.00),
(30, 27, 100.00),
(30, 30, 30.00),
(31, 31, 1.00),
(31, 33, 150.00),
(31, 37, 20.00),
(31, 38, 20.00),
(31, 39, 20.00),
(31, 41, 10.00),
(31, 42, 10.00),
(31, 43, 10.00),
(32, 31, 1.00),
(32, 33, 150.00),
(32, 35, 1.00),
(32, 37, 20.00),
(32, 38, 20.00),
(32, 39, 20.00),
(32, 41, 10.00),
(32, 42, 10.00),
(32, 43, 10.00),
(33, 31, 1.00),
(33, 33, 150.00),
(33, 36, 1.00),
(33, 37, 20.00),
(33, 38, 20.00),
(33, 39, 20.00),
(33, 41, 10.00),
(33, 42, 10.00),
(33, 43, 10.00),
(34, 31, 1.00),
(34, 34, 150.00),
(34, 37, 20.00),
(34, 38, 20.00),
(34, 39, 20.00),
(34, 41, 10.00),
(34, 42, 10.00),
(34, 43, 10.00),
(35, 31, 1.00),
(35, 34, 150.00),
(35, 35, 1.00),
(35, 37, 20.00),
(35, 38, 20.00),
(35, 39, 20.00),
(35, 41, 10.00),
(35, 42, 10.00),
(35, 43, 10.00),
(36, 31, 1.00),
(36, 34, 150.00),
(36, 36, 1.00),
(36, 37, 20.00),
(36, 38, 20.00),
(36, 39, 20.00),
(36, 41, 10.00),
(36, 42, 10.00),
(36, 43, 10.00),
(37, 32, 1.00),
(37, 33, 150.00),
(37, 37, 20.00),
(37, 38, 20.00),
(37, 39, 20.00),
(37, 41, 10.00),
(37, 42, 10.00),
(37, 43, 10.00),
(38, 32, 1.00),
(38, 33, 150.00),
(38, 35, 1.00),
(38, 37, 20.00),
(38, 38, 20.00),
(38, 39, 20.00),
(38, 41, 10.00),
(38, 42, 10.00),
(38, 43, 10.00),
(39, 32, 1.00),
(39, 33, 150.00),
(39, 36, 1.00),
(39, 37, 20.00),
(39, 38, 20.00),
(39, 39, 20.00),
(39, 41, 10.00),
(39, 42, 10.00),
(39, 43, 10.00),
(40, 32, 1.00),
(40, 34, 150.00),
(40, 37, 20.00),
(40, 38, 20.00),
(40, 39, 20.00),
(40, 41, 10.00),
(40, 42, 10.00),
(40, 43, 10.00),
(41, 32, 1.00),
(41, 34, 150.00),
(41, 35, 1.00),
(41, 37, 20.00),
(41, 38, 20.00),
(41, 39, 20.00),
(41, 41, 10.00),
(41, 42, 10.00),
(41, 43, 10.00),
(42, 32, 1.00),
(42, 34, 150.00),
(42, 36, 1.00),
(42, 37, 20.00),
(42, 38, 20.00),
(42, 39, 20.00),
(42, 41, 10.00),
(42, 42, 10.00),
(42, 43, 10.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_04_13_082741_create_cache_locks_table', 1),
(2, '2026_04_13_082741_create_cache_table', 1),
(3, '2026_04_13_082741_create_detail_pesanan_table', 1),
(4, '2026_04_13_082741_create_failed_jobs_table', 1),
(5, '2026_04_13_082741_create_job_batches_table', 1),
(6, '2026_04_13_082741_create_jobs_table', 1),
(7, '2026_04_13_082741_create_laporan_keuangan_table', 1),
(8, '2026_04_13_082741_create_menu_bahan_table', 1),
(9, '2026_04_13_082741_create_menu_table', 1),
(10, '2026_04_13_082741_create_password_reset_tokens_table', 1),
(11, '2026_04_13_082741_create_pesanan_table', 1),
(12, '2026_04_13_082741_create_sessions_table', 1),
(13, '2026_04_13_082741_create_stok_bahan_table', 1),
(14, '2026_04_13_082741_create_user_table', 1),
(15, '2026_04_13_082741_create_users_table', 1),
(16, '2026_04_13_082744_add_foreign_keys_to_detail_pesanan_table', 1),
(17, '2026_04_13_082744_add_foreign_keys_to_laporan_keuangan_table', 1),
(18, '2026_04_13_082744_add_foreign_keys_to_menu_bahan_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `total_pesanan` int(11) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `tipe_order` enum('dine_in','take_away','delivery') NOT NULL DEFAULT 'dine_in',
  `catatan` text DEFAULT NULL,
  `status_pembayaran` enum('Lunas','Belum Lunas') NOT NULL,
  `status_pesanan` varchar(255) NOT NULL DEFAULT 'Proses',
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('N1HMbl2xsHUw0nwokzIiYPl3mJX8IozKFBT32GW3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGc1MlRHdGtXNnlneG1FZjdwUTBrRjF1ZURwOXljRzVPNlU2alJxMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776491634);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_bahan`
--

CREATE TABLE `stok_bahan` (
  `id_bahan` int(11) NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `jumlah_stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stok_bahan`
--

INSERT INTO `stok_bahan` (`id_bahan`, `nama_bahan`, `jumlah_stok`, `satuan`) VALUES
(1, 'Kopi Bubuk', 5000.00, 'gram'),
(2, 'Susu Cair', 20000.00, 'ml'),
(3, 'Gula', 10000.00, 'gram'),
(4, 'Es Batu', 50000.00, 'gram'),
(5, 'Matcha Powder', 2000.00, 'gram'),
(6, 'Coklat Bubuk', 3000.00, 'gram'),
(7, 'Milo Powder', 3000.00, 'gram'),
(8, 'Ovaltine Powder', 3000.00, 'gram'),
(9, 'Keju Cream Cheese', 2000.00, 'gram'),
(10, 'Susu Kental Manis', 5000.00, 'ml'),
(11, 'Sirup Red Velvet', 2000.00, 'ml'),
(12, 'Sirup Taro', 2000.00, 'ml'),
(13, 'Sirup Vanilla', 2000.00, 'ml'),
(14, 'Sirup Cappuccino', 2000.00, 'ml'),
(15, 'Sirup Coklat', 2000.00, 'ml'),
(16, 'Sirup Dark Choco', 2000.00, 'ml'),
(17, 'Sirup Choco Cheese', 2000.00, 'ml'),
(18, 'Sirup Cheese Milo', 2000.00, 'ml'),
(19, 'Sirup Chakies & Cream', 2000.00, 'ml'),
(20, 'Sirup Lotus Milk & Cream', 2000.00, 'ml'),
(21, 'Sirup Brown Sugar', 2000.00, 'ml'),
(22, 'Teh Thai', 2000.00, 'gram'),
(23, 'Teh Hijau', 2000.00, 'gram'),
(24, 'Teh Lemon', 2000.00, 'ml'),
(25, 'Teh Lachy', 2000.00, 'gram'),
(26, 'Yakult', 100.00, 'botol'),
(27, 'Soda', 5000.00, 'ml'),
(28, 'Strawberry Puree', 2000.00, 'ml'),
(29, 'Manggo Puree', 2000.00, 'ml'),
(30, 'Orange Puree', 2000.00, 'ml'),
(31, 'Roti Burger', 100.00, 'pcs'),
(32, 'Roti Kebab', 100.00, 'pcs'),
(33, 'Daging Ayam', 5000.00, 'gram'),
(34, 'Daging Sapi', 5000.00, 'gram'),
(35, 'Keju Slice', 200.00, 'lembar'),
(36, 'Telur', 200.00, 'butir'),
(37, 'Selada', 2000.00, 'gram'),
(38, 'Tomat', 2000.00, 'gram'),
(39, 'Timun', 2000.00, 'gram'),
(40, 'Bawang Bombay', 2000.00, 'gram'),
(41, 'Saus Tomat', 5000.00, 'ml'),
(42, 'Saus Sambal', 5000.00, 'ml'),
(43, 'Mayonaise', 5000.00, 'ml');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('owner','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Kasir', 'Kasir', 'Kasir123', 'kasir'),
(2, 'Owner', 'Owner', 'Owner123', 'owner');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `idx_detail_pesanan` (`id_pesanan`),
  ADD KEY `idx_detail_menu` (`id_menu`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `idx_laporan_periode` (`tanggal_mulai`,`tanggal_selesai`),
  ADD KEY `idx_laporan_user` (`id_user`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `menu_bahan`
--
ALTER TABLE `menu_bahan`
  ADD PRIMARY KEY (`id_menu`,`id_bahan`),
  ADD KEY `fk_menubahan_bahan` (`id_bahan`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `idx_pesanan_created` (`created_at`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `stok_bahan`
--
ALTER TABLE `stok_bahan`
  ADD PRIMARY KEY (`id_bahan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `stok_bahan`
--
ALTER TABLE `stok_bahan`
  MODIFY `id_bahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `fk_detail_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD CONSTRAINT `fk_laporan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `menu_bahan`
--
ALTER TABLE `menu_bahan`
  ADD CONSTRAINT `fk_menubahan_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `stok_bahan` (`id_bahan`),
  ADD CONSTRAINT `fk_menubahan_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
