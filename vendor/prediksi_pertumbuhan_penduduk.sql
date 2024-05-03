-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Bulan Mei 2024 pada 00.13
-- Versi server: 8.3.0
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prediksi_pertumbuhan_penduduk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

CREATE TABLE `auth` (
  `id` int NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bg` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth`
--

INSERT INTO `auth` (`id`, `image`, `bg`) VALUES
(1, 'auth.jpg', '#f07b26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dataset`
--

CREATE TABLE `dataset` (
  `id_dataset` int NOT NULL,
  `id_periode` int NOT NULL,
  `id_variabel` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dataset`
--

INSERT INTO `dataset` (`id_dataset`, `id_periode`, `id_variabel`, `jumlah`) VALUES
(53, 8, 59, 218669),
(54, 8, 60, 1499),
(55, 9, 59, 220043),
(56, 9, 60, 2132),
(57, 10, 59, 222521),
(58, 10, 60, 1885),
(59, 11, 59, 224409),
(60, 11, 60, 3145),
(61, 12, 59, 226039),
(62, 12, 60, 3297),
(63, 13, 59, 227097),
(64, 13, 60, 3043),
(65, 14, 59, 227397),
(66, 14, 60, 3137),
(67, 15, 59, 228023),
(68, 15, 60, 3137);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_periode`
--

CREATE TABLE `data_periode` (
  `id_periode` int NOT NULL,
  `periode` varchar(15) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_periode`
--

INSERT INTO `data_periode` (`id_periode`, `periode`) VALUES
(8, '2015'),
(9, '2016'),
(10, '2017'),
(11, '2018'),
(12, '2019'),
(13, '2020'),
(14, '2021'),
(15, '2022'),
(16, '2023'),
(18, '2024'),
(19, '2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_uji`
--

CREATE TABLE `data_uji` (
  `id_uji` int NOT NULL,
  `periode` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_uji`
--

INSERT INTO `data_uji` (`id_uji`, `periode`, `jumlah`) VALUES
(3, 2024, 4226),
(4, 2025, 4636);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_variabel`
--

CREATE TABLE `data_variabel` (
  `id_variabel` int NOT NULL,
  `nama_variabel` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_variabel`
--

INSERT INTO `data_variabel` (`id_variabel`, `nama_variabel`) VALUES
(59, 'jumlah_penduduk'),
(60, 'jumlah_migrasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_es`
--

CREATE TABLE `hasil_es` (
  `id_rl` int NOT NULL,
  `periode` int DEFAULT NULL,
  `nilai_alpha` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `var_dependen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hasil_prediksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_es`
--

INSERT INTO `hasil_es` (`id_rl`, `periode`, `nilai_alpha`, `var_dependen`, `hasil_prediksi`, `created_at`, `updated_at`) VALUES
(1, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-11 20:30:16', '2024-03-11 20:30:16'),
(2, 2025, '0.2', 'jumlah_penduduk', '224564.454', '2024-04-18 21:04:02', '2024-03-12 02:33:40'),
(3, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-18 03:34:25', '2024-03-18 03:34:25'),
(4, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-18 03:34:25', '2024-03-18 03:34:25'),
(5, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-18 03:34:43', '2024-03-18 03:34:43'),
(6, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-18 03:34:43', '2024-03-18 03:34:43'),
(7, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-18 03:35:36', '2024-03-18 03:35:36'),
(8, 2023, '0.2', 'jumlah_penduduk', '224564.454', '2024-03-18 03:35:36', '2024-03-18 03:35:36'),
(9, 2024, '0.1', 'jumlah_migrasi', '2230.78538', '2024-04-23 17:04:27', '2024-04-23 17:04:27'),
(10, 2024, '0.2', 'jumlah_migrasi', '2663.75184', '2024-04-24 14:40:12', '2024-04-24 14:40:12'),
(11, 2024, '0.2', 'jumlah_migrasi', '2663.75184', '2024-04-24 14:40:32', '2024-04-24 14:40:32'),
(12, 2024, '0.2', 'jumlah_migrasi', '2663.75184', '2024-04-24 14:41:00', '2024-04-24 14:41:00'),
(13, 2024, '0.2', 'jumlah_migrasi', '2663.75184', '2024-04-24 14:41:14', '2024-04-24 14:41:14'),
(14, 2024, '0.2', 'jumlah_migrasi', '2663.75184', '2024-04-24 14:51:35', '2024-04-24 14:51:35'),
(15, 2024, '0.2', 'jumlah_migrasi', '2663.75184', '2024-04-24 14:52:51', '2024-04-24 14:52:51'),
(16, 2025, '0.1', 'jumlah_migrasi', '2230.7853893', '2024-05-03 07:21:27', '2024-05-03 07:21:27'),
(17, 2025, '0.1', 'jumlah_migrasi', '2230.7853893', '2024-05-03 07:21:59', '2024-05-03 07:21:59'),
(18, 2025, '0.1', 'jumlah_migrasi', '2230.7853893', '2024-05-03 07:23:01', '2024-05-03 07:23:01'),
(19, 2025, '0.1', 'jumlah_migrasi', '2230.7853893', '2024-05-03 07:30:57', '2024-05-03 07:30:57'),
(20, 2025, '0.1', 'jumlah_migrasi', '2230.7853893', '2024-05-03 07:31:13', '2024-05-03 07:31:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_rl`
--

CREATE TABLE `hasil_rl` (
  `id_rl` int NOT NULL,
  `periode` int DEFAULT NULL,
  `jumlah_migrasi` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `var_independen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `var_dependen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hasil_prediksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_rl`
--

INSERT INTO `hasil_rl` (`id_rl`, `periode`, `jumlah_migrasi`, `var_independen`, `var_dependen`, `hasil_prediksi`, `created_at`, `updated_at`) VALUES
(1, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:17:32', '2024-05-03 07:17:32'),
(2, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:19:40', '2024-05-03 07:19:40'),
(3, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:20:35', '2024-05-03 07:20:35'),
(4, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:26:40', '2024-05-03 07:26:40'),
(5, 2025, '2500', 'jumlah_penduduk', 'jumlah_migrasi', '-37094.071089426', '2024-05-03 07:27:10', '2024-05-03 07:27:10'),
(6, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:29:47', '2024-05-03 07:29:47'),
(7, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:30:39', '2024-05-03 07:30:39'),
(8, 2025, '1500', 'jumlah_penduduk', 'jumlah_migrasi', '-37273.322542034', '2024-05-03 07:30:49', '2024-05-03 07:30:49'),
(9, 2025, '2500', 'jumlah_penduduk', 'jumlah_migrasi', '-37094.071089426', '2024-05-03 07:31:20', '2024-05-03 07:31:20'),
(10, 2025, '2500', 'jumlah_penduduk', 'jumlah_migrasi', '-37094.071089426', '2024-05-03 07:32:02', '2024-05-03 07:32:02'),
(11, 2025, '2500', 'jumlah_penduduk', 'jumlah_migrasi', '-37094.071089426', '2024-05-03 07:32:39', '2024-05-03 07:32:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int NOT NULL,
  `nama` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` char(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tentang`
--

CREATE TABLE `tentang` (
  `id` int NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tentang`
--

INSERT INTO `tentang` (`id`, `deskripsi`) VALUES
(1, '<p><strong>Kabupaten Belu</strong> merupakan salah satu kabupaten yang berada di Nusa Tenggara Timur dimana kabupaten ini merupakan kabupaten yang berbatasan langsung dengan Negara Republic Democratica de Timor Leste yang dimana tiap tahunnya pertumbuhan penduduk terus bertambah pada kabupaten ini. Salah satu Kecamatan yang terletak di wilayah ini adalah Kecamatan Tasifeto Barat. Kecamatan ini menawarkan potensi yang menarik, termasuk perkembangan penduduk yang signifikan dalam beberapa tahun terakhir.</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `id_role` int DEFAULT NULL,
  `id_active` int DEFAULT '2',
  `en_user` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` char(6) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'default.svg',
  `email` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `id_active`, `en_user`, `token`, `name`, `image`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 'admin', 'default.svg', 'admin@gmail.com', '$2y$10$//KMATh3ibPoI3nHFp7x/u7vnAbo2WyUgmI4x0CVVrH8ajFhMvbjG', '2023-12-11 12:44:17', '2023-12-11 12:44:17'),
(2, 4, 2, '2y10zTwts8P9rytW7Gvydm73uu7O89qAYx4uy7rTgo5rbdeZeeL1PWu', '451512', 'Netmedia Framecode', 'default.svg', 'netmediaframecode@gmail.com', '$2y$10$Eeo5RAPIi9ZTR3BV/YW7U./OL632X8v9nRTV6TxE6nRGpiZ/s2Mjy', '2024-04-04 13:40:37', '2024-04-04 13:40:37');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `insert_users` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    SET NEW.id_role = (
        SELECT id_role
        FROM `user_role`
        ORDER BY id_role DESC
        LIMIT 1
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id_access_menu` int NOT NULL,
  `id_role` int DEFAULT NULL,
  `id_menu` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id_access_menu`, `id_role`, `id_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(9, 1, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_sub_menu`
--

CREATE TABLE `user_access_sub_menu` (
  `id_access_sub_menu` int NOT NULL,
  `id_role` int DEFAULT NULL,
  `id_sub_menu` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_sub_menu`
--

INSERT INTO `user_access_sub_menu` (`id_access_sub_menu`, `id_role`, `id_sub_menu`) VALUES
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(44, 1, 19),
(45, 1, 17),
(51, 1, 73),
(53, 1, 75),
(57, 1, 15),
(58, 1, 78),
(59, 1, 79),
(61, 1, 80);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id_menu` int NOT NULL,
  `menu` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id_menu`, `menu`) VALUES
(1, 'User Management'),
(2, 'Menu Management'),
(3, 'Kelola Data'),
(4, 'Laporan'),
(5, 'Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int NOT NULL,
  `role` varchar(35) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id_role`, `role`) VALUES
(1, 'Administrator'),
(4, 'Pengguna');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_status`
--

CREATE TABLE `user_status` (
  `id_status` int NOT NULL,
  `status` varchar(35) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_status`
--

INSERT INTO `user_status` (`id_status`, `status`) VALUES
(1, 'Active'),
(2, 'No Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id_sub_menu` int NOT NULL,
  `id_menu` int DEFAULT NULL,
  `id_active` int DEFAULT '2',
  `title` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id_sub_menu`, `id_menu`, `id_active`, `title`, `url`, `icon`) VALUES
(1, 1, 1, 'Users', 'users', 'fas fa-users'),
(2, 1, 1, 'Role', 'role', 'fas fa-user-cog'),
(3, 2, 1, 'Menu', 'menu', 'fas fa-fw fa-folder'),
(4, 2, 1, 'Sub Menu', 'sub-menu', 'fas fa-fw fa-folder-open'),
(5, 2, 1, 'Menu Access', 'menu-access', 'fas fa-user-lock'),
(6, 2, 1, 'Sub Menu Access', 'sub-menu-access', 'fas fa-user-lock'),
(15, 4, 1, 'Ringkasan Hasil', 'ringkasan-hasil', 'fas fa-sticky-note'),
(17, 3, 1, 'Variabel', 'variabel', 'fas fa-list-ol'),
(19, 3, 1, 'Periode', 'periode', 'fas fa-list-ol'),
(73, 3, 1, 'Dataset', 'dataset', 'fas fa-list-ol'),
(75, 3, 1, 'Data Uji', 'data-uji', 'fas fa-list'),
(78, 5, 1, 'Tentang', 'tentang', 'fas fa-list-ul'),
(79, 5, 1, 'Kontak', 'kontak', 'fas fa-comments'),
(80, 3, 1, 'Prediksi', 'prediksi', 'fas fa-calculator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id_dataset`),
  ADD KEY `id_periode` (`id_periode`),
  ADD KEY `id_variabel` (`id_variabel`);

--
-- Indeks untuk tabel `data_periode`
--
ALTER TABLE `data_periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indeks untuk tabel `data_uji`
--
ALTER TABLE `data_uji`
  ADD PRIMARY KEY (`id_uji`);

--
-- Indeks untuk tabel `data_variabel`
--
ALTER TABLE `data_variabel`
  ADD PRIMARY KEY (`id_variabel`);

--
-- Indeks untuk tabel `hasil_es`
--
ALTER TABLE `hasil_es`
  ADD PRIMARY KEY (`id_rl`);

--
-- Indeks untuk tabel `hasil_rl`
--
ALTER TABLE `hasil_rl`
  ADD PRIMARY KEY (`id_rl`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `tentang`
--
ALTER TABLE `tentang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_active` (`id_active`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id_access_menu`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  ADD PRIMARY KEY (`id_access_sub_menu`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_sub_menu` (`id_sub_menu`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_active` (`id_active`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id_dataset` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `data_periode`
--
ALTER TABLE `data_periode`
  MODIFY `id_periode` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `data_uji`
--
ALTER TABLE `data_uji`
  MODIFY `id_uji` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `data_variabel`
--
ALTER TABLE `data_variabel`
  MODIFY `id_variabel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `hasil_es`
--
ALTER TABLE `hasil_es`
  MODIFY `id_rl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `hasil_rl`
--
ALTER TABLE `hasil_rl`
  MODIFY `id_rl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tentang`
--
ALTER TABLE `tentang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id_access_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  MODIFY `id_access_sub_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id_status` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id_sub_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dataset`
--
ALTER TABLE `dataset`
  ADD CONSTRAINT `dataset_ibfk_1` FOREIGN KEY (`id_periode`) REFERENCES `data_periode` (`id_periode`),
  ADD CONSTRAINT `dataset_ibfk_2` FOREIGN KEY (`id_variabel`) REFERENCES `data_variabel` (`id_variabel`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_active`) REFERENCES `user_status` (`id_status`);

--
-- Ketidakleluasaan untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `user_access_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  ADD CONSTRAINT `user_access_sub_menu_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `user_access_sub_menu_ibfk_2` FOREIGN KEY (`id_sub_menu`) REFERENCES `user_sub_menu` (`id_sub_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD CONSTRAINT `user_sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sub_menu_ibfk_2` FOREIGN KEY (`id_active`) REFERENCES `user_status` (`id_status`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
