-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Agu 2024 pada 12.33
-- Versi server: 8.0.30
-- Versi PHP: 7.4.30

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
(67, 15, 59, 228032),
(68, 15, 60, 3137),
(83, 16, 60, 3657),
(84, 16, 59, 228900);

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
(20, '2025');

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
(1, 2024, 25679);

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
  `hasil_prediksi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_es`
--

INSERT INTO `hasil_es` (`id_rl`, `periode`, `nilai_alpha`, `var_dependen`, `hasil_prediksi`, `created_at`, `updated_at`) VALUES
(1, 2024, '0.1', 'jumlah_penduduk', '222949', '2024-05-08 09:21:36', '2024-07-18 07:30:30'),
(2, 2024, '0.1', 'jumlah_migrasi', '2373', '2024-05-08 09:21:36', '2024-07-18 07:30:30'),
(3, 2025, '0.1', 'jumlah_penduduk', '200654', '2024-05-08 09:21:57', '2024-07-23 07:49:42'),
(4, 2025, '0.1', 'jumlah_migrasi', '2136', '2024-05-08 09:21:57', '2024-07-23 07:49:42'),
(5, 2027, '0.1', 'jumlah_penduduk', '162530', '2024-05-08 09:35:32', '2024-07-23 07:49:42'),
(6, 2027, '0.1', 'jumlah_migrasi', '1730', '2024-05-08 09:35:32', '2024-07-23 07:49:43'),
(7, 2026, '0.1', 'jumlah_penduduk', '180589', '2024-05-08 09:42:38', '2024-07-23 07:49:42'),
(8, 2026, '0.1', 'jumlah_migrasi', '1922', '2024-05-08 09:42:38', '2024-07-23 07:49:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_rl`
--

CREATE TABLE `hasil_rl` (
  `id_rl` int NOT NULL,
  `periode` int DEFAULT NULL,
  `var_dependen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aktual` float NOT NULL,
  `hasil_prediksi` float DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_rl`
--

INSERT INTO `hasil_rl` (`id_rl`, `periode`, `var_dependen`, `aktual`, `hasil_prediksi`, `created_at`, `updated_at`) VALUES
(3170, 2015, 'jumlah_penduduk', 218669, 219634, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3171, 2016, 'jumlah_penduduk', 220043, 220923, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3172, 2017, 'jumlah_penduduk', 222521, 222212, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3173, 2018, 'jumlah_penduduk', 224409, 223501, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3174, 2019, 'jumlah_penduduk', 226039, 224790, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3175, 2020, 'jumlah_penduduk', 227097, 226079, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3176, 2021, 'jumlah_penduduk', 227397, 227367, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3177, 2022, 'jumlah_penduduk', 228032, 228656, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3178, 2023, 'jumlah_penduduk', 228900, 229945, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3179, 2024, 'jumlah_penduduk', 0, 231234, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3180, 2025, 'jumlah_penduduk', 0, 232523, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3181, 2026, 'jumlah_penduduk', 0, 233812, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3182, 2027, 'jumlah_penduduk', 0, 235100, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3183, 2015, 'jumlah_migrasi', 1499, 1834, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3184, 2016, 'jumlah_migrasi', 2132, 2068, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3185, 2017, 'jumlah_migrasi', 1885, 2302, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3186, 2018, 'jumlah_migrasi', 3145, 2536, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3187, 2019, 'jumlah_migrasi', 3297, 2770, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3188, 2020, 'jumlah_migrasi', 3043, 3004, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3189, 2021, 'jumlah_migrasi', 3137, 3239, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3190, 2022, 'jumlah_migrasi', 3137, 3473, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3191, 2023, 'jumlah_migrasi', 3657, 3707, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3192, 2024, 'jumlah_migrasi', 0, 3941, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3193, 2025, 'jumlah_migrasi', 0, 4175, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3194, 2026, 'jumlah_migrasi', 0, 4409, '2024-07-26 11:20:19', '2024-07-26 11:20:19'),
(3195, 2027, 'jumlah_migrasi', 0, 4643, '2024-07-26 11:20:19', '2024-07-26 11:20:19');

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
(2, 4, 1, '2y10wUb7HRjatRViQQ5KA4z9FeFP3dwalJtxdxJdayTjVVQ7og4AipLh', '558883', 'irenpasu@gmail.com', 'default.svg', 'irenpasu@gmail.com', '$2y$10$73gicwgLk/S4ScUi0bFxPObPL72YCpQhEKGc4CNEeuDSQkmBJmlWm', '2024-03-20 09:47:09', '2024-03-20 09:47:49'),
(3, 4, 2, '2y10Pdfw2qlLCGUsHKS2z3kEeUV78i8xdSvHyKIoZ6pYSnwiWZzWK6KW', '314863', 'Nathalina Dasilva', 'default.svg', 'nenidasilva02@gmail.com', '$2y$10$n9W.jFyiy0RDRTYCfq0cguNJRopa9d2d0K8mz9pcaKV7gz96j7kKm', '2024-04-04 12:52:22', '2024-04-04 12:53:15');

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
  MODIFY `id_dataset` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT untuk tabel `data_periode`
--
ALTER TABLE `data_periode`
  MODIFY `id_periode` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `data_uji`
--
ALTER TABLE `data_uji`
  MODIFY `id_uji` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `data_variabel`
--
ALTER TABLE `data_variabel`
  MODIFY `id_variabel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `hasil_es`
--
ALTER TABLE `hasil_es`
  MODIFY `id_rl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `hasil_rl`
--
ALTER TABLE `hasil_rl`
  MODIFY `id_rl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3196;

--
-- AUTO_INCREMENT untuk tabel `tentang`
--
ALTER TABLE `tentang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
