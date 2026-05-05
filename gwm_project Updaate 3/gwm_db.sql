-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 05:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gwm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `export_log`
--

CREATE TABLE `export_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tipe_export` enum('pdf','excel') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `export_log`
--

INSERT INTO `export_log` (`id`, `user_id`, `tipe_export`, `created_at`) VALUES
(1, 1, 'pdf', '2026-04-15 15:46:52'),
(2, 1, 'excel', '2026-04-15 15:46:52'),
(3, 2, 'pdf', '2026-04-15 15:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama_kecamatan`, `created_at`, `updated_at`) VALUES
(1, 'Purwosari', '2026-04-15 15:42:23', '2026-04-15 15:42:23'),
(2, 'Panggang', '2026-04-15 15:42:23', '2026-04-15 15:42:23'),
(3, 'Saptosari', '2026-04-15 15:42:23', '2026-04-15 15:42:23'),
(4, 'Tanjungsari', '2026-04-15 15:42:23', '2026-04-15 15:42:23'),
(5, 'Tepus', '2026-04-15 15:42:23', '2026-04-15 15:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `nama_kelurahan` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `kecamatan_id`, `nama_kelurahan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Giriasih', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(2, 1, 'Giricahyo', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(3, 1, 'Girijati', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(4, 2, 'Giriharjo', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(5, 2, 'Girijati Panggang', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(6, 3, 'Jetis', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(7, 3, 'Planjan', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(8, 4, 'Kemadang', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(9, 4, 'Banjarejo', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(10, 5, 'Tepus', '2026-04-15 15:43:25', '2026-04-15 15:43:25'),
(11, 5, 'Purwodadi', '2026-04-15 15:43:25', '2026-04-15 15:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `kelurahan_id` int(11) NOT NULL,
  `kondisi_air` enum('aman','waspada','siaga','kritis') NOT NULL,
  `jumlah_terdampak` int(11) NOT NULL,
  `durasi_hari` int(11) NOT NULL,
  `status` enum('draft','diajukan','divalidasi','ditolak','diproses','selesai') DEFAULT 'draft',
  `level` enum('green','yellow','orange','red') NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `user_id`, `kecamatan_id`, `kelurahan_id`, `kondisi_air`, `jumlah_terdampak`, `durasi_hari`, `status`, `level`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'waspada', 120, 5, 'draft', 'yellow', 'Masih pengamatan awal', '2026-04-15 15:43:58', '2026-04-15 15:43:58'),
(2, 2, 1, 2, 'siaga', 250, 10, 'diajukan', 'orange', 'Sumur mulai mengering', '2026-04-15 15:43:58', '2026-04-15 15:43:58'),
(3, 2, 1, 3, 'kritis', 400, 15, 'divalidasi', 'red', 'Krisis air parah', '2026-04-15 15:43:58', '2026-04-15 15:43:58'),
(4, 3, 2, 4, 'aman', 50, 2, 'ditolak', 'green', 'Data tidak valid', '2026-04-15 15:43:58', '2026-04-15 15:43:58'),
(5, 3, 2, 5, 'siaga', 300, 7, 'diproses', 'orange', 'Sedang ditangani', '2026-04-15 15:43:58', '2026-04-15 15:43:58'),
(6, 2, 1, 1, 'kritis', 500, 20, 'selesai', 'red', 'Sudah distribusi air', '2026-04-15 15:43:58', '2026-04-15 15:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_foto`
--

CREATE TABLE `laporan_foto` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `path_foto` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_foto`
--

INSERT INTO `laporan_foto` (`id`, `laporan_id`, `path_foto`, `created_at`) VALUES
(1, 2, 'foto/laporan2_1.jpg', '2026-04-15 15:44:10'),
(2, 2, 'foto/laporan2_2.jpg', '2026-04-15 15:44:10'),
(3, 3, 'foto/laporan3.jpg', '2026-04-15 15:44:10'),
(4, 6, 'foto/laporan6.jpg', '2026-04-15 15:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `laporan_id` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user_id`, `laporan_id`, `aktivitas`, `deskripsi`, `created_at`) VALUES
(1, 2, 1, 'Membuat Draft', 'Membuat laporan awal', '2026-04-15 15:46:39'),
(2, 2, 2, 'Submit Laporan', 'Mengirim laporan untuk validasi', '2026-04-15 15:46:39'),
(3, 1, 2, 'Validasi Laporan', 'Menyetujui laporan', '2026-04-15 15:46:39'),
(4, 1, 3, 'Validasi Laporan', 'Laporan disetujui', '2026-04-15 15:46:39'),
(5, 1, 3, 'Tambah Tindak Lanjut', 'Distribusi air dilakukan', '2026-04-15 15:46:39'),
(6, 1, 4, 'Tolak Laporan', 'Data tidak valid', '2026-04-15 15:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `laporan_id` int(11) DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `laporan_id`, `judul`, `pesan`, `is_read`, `created_at`) VALUES
(1, 2, 2, 'Laporan Divalidasi', 'Laporan Anda telah divalidasi admin', 0, '2026-04-15 15:45:38'),
(2, 2, 3, 'Laporan Diproses', 'Laporan sedang dalam proses', 1, '2026-04-15 15:45:38'),
(3, 3, 4, 'Laporan Ditolak', 'Periksa kembali data laporan Anda', 0, '2026-04-15 15:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `prioritas`
--

CREATE TABLE `prioritas` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `skor_prioritas` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prioritas`
--

INSERT INTO `prioritas` (`id`, `laporan_id`, `skor_prioritas`, `created_at`) VALUES
(1, 3, 95, '2026-04-15 15:46:02'),
(2, 5, 80, '2026-04-15 15:46:02'),
(3, 6, 100, '2026-04-15 15:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `tindak_lanjut`
--

CREATE TABLE `tindak_lanjut` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `jenis_tindakan` enum('distribusi_air','perbaikan','lainnya') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_tindakan` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tindak_lanjut`
--

INSERT INTO `tindak_lanjut` (`id`, `laporan_id`, `admin_id`, `jenis_tindakan`, `deskripsi`, `tanggal_tindakan`, `created_at`) VALUES
(1, 3, 1, 'distribusi_air', 'Pengiriman 5 tangki air bersih', '2026-04-10', '2026-04-15 15:46:29'),
(2, 5, 1, 'perbaikan', 'Perbaikan pompa air', '2026-04-12', '2026-04-15 15:46:29'),
(3, 6, 1, 'distribusi_air', 'Distribusi rutin harian', '2026-04-14', '2026-04-15 15:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('petugas','admin') NOT NULL,
  `kecamatan_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `kecamatan_id`, `created_at`, `updated_at`) VALUES
(1, 'Admin GWM', 'admin@gwm.com', 'hashed_password', 'admin', NULL, '2026-04-15 15:43:42', '2026-04-15 15:43:42'),
(2, 'Petugas Purwosari', 'purwosari@gwm.com', 'hashed_password', 'petugas', 1, '2026-04-15 15:43:42', '2026-04-15 15:43:42'),
(3, 'Petugas Panggang', 'panggang@gwm.com', 'hashed_password', 'petugas', 2, '2026-04-15 15:43:42', '2026-04-15 15:43:42');

-- --------------------------------------------------------

--
-- Table structure for table `validasi`
--

CREATE TABLE `validasi` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `status_validasi` enum('approve','reject') NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `validasi`
--

INSERT INTO `validasi` (`id`, `laporan_id`, `admin_id`, `status_validasi`, `catatan`, `created_at`) VALUES
(1, 2, 1, 'approve', 'Data valid', '2026-04-15 15:45:54'),
(2, 3, 1, 'approve', 'Perlu segera ditindak', '2026-04-15 15:45:54'),
(3, 4, 1, 'reject', 'Data tidak sesuai', '2026-04-15 15:45:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `export_log`
--
ALTER TABLE `export_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kelurahan_kecamatan` (`kecamatan_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kelurahan_id` (`kelurahan_id`),
  ADD KEY `idx_laporan_status` (`status`),
  ADD KEY `idx_laporan_level` (`level`),
  ADD KEY `idx_laporan_kecamatan` (`kecamatan_id`);

--
-- Indexes for table `laporan_foto`
--
ALTER TABLE `laporan_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `prioritas`
--
ALTER TABLE `prioritas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `tindak_lanjut`
--
ALTER TABLE `tindak_lanjut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `kecamatan_id` (`kecamatan_id`);

--
-- Indexes for table `validasi`
--
ALTER TABLE `validasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `export_log`
--
ALTER TABLE `export_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laporan_foto`
--
ALTER TABLE `laporan_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prioritas`
--
ALTER TABLE `prioritas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tindak_lanjut`
--
ALTER TABLE `tindak_lanjut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `validasi`
--
ALTER TABLE `validasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `export_log`
--
ALTER TABLE `export_log`
  ADD CONSTRAINT `export_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_3` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_foto`
--
ALTER TABLE `laporan_foto`
  ADD CONSTRAINT `laporan_foto_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `log_aktivitas_ibfk_2` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `prioritas`
--
ALTER TABLE `prioritas`
  ADD CONSTRAINT `prioritas_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tindak_lanjut`
--
ALTER TABLE `tindak_lanjut`
  ADD CONSTRAINT `tindak_lanjut_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tindak_lanjut_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `validasi`
--
ALTER TABLE `validasi`
  ADD CONSTRAINT `validasi_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `validasi_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
