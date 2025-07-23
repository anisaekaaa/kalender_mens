-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 08:24 AM
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
-- Database: `kalender_mens`
--

-- --------------------------------------------------------

--
-- Table structure for table `gejala_harian`
--

CREATE TABLE `gejala_harian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `mood` varchar(50) DEFAULT NULL,
  `nyeri` varchar(50) DEFAULT NULL,
  `energi` varchar(50) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gejala_harian`
--

INSERT INTO `gejala_harian` (`id`, `user_id`, `tanggal`, `mood`, `nyeri`, `energi`, `catatan`, `created_at`) VALUES
(1, 1, '2025-06-30', '😞', '4', '1', 'sakit bngt busettt', '2025-07-10 16:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `proses_kehamilan`
--

CREATE TABLE `proses_kehamilan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `usia_kehamilan_minggu` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kondisi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rencana_kehamilan`
--

CREATE TABLE `rencana_kehamilan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('aktif','tidak') DEFAULT 'tidak',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siklus`
--

CREATE TABLE `siklus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siklus`
--

INSERT INTO `siklus` (`id`, `user_id`, `tanggal_mulai`, `durasi`, `catatan`, `tanggal_input`) VALUES
(1, 1, '2025-06-30', 8, '', '2025-07-10 16:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `nama_lengkap`, `foto_profil`, `created_at`) VALUES
(1, 'nsslndrii', '$2y$10$FFDuRpXDtKa9NOuZA9jDleQAc35J93T3oD9QXGyqJpQJGVmpKRozm', '1202307006@students.itspku.ac.id', 'anisa', NULL, '2025-07-10 15:17:36'),
(2, 'ketrin', '$2y$10$uOGxgN5ahbMA29A57ktbA.Rqh9ofAR5wKCk5V6TT9y4cOPU6Lgjlu', 'ketblublu@gmail.com', 'ketrin', NULL, '2025-07-11 02:08:52'),
(3, 'wlndr', '$2y$10$ekXHVVAW1DP2s8DoBL2cH.ac2ZbxaZZoyAo1s.6sESnhMLp1jUyaq', '1202307006@students.itspku.ac.id', 'wulandari', NULL, '2025-07-23 04:39:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala_harian`
--
ALTER TABLE `gejala_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `proses_kehamilan`
--
ALTER TABLE `proses_kehamilan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rencana_kehamilan`
--
ALTER TABLE `rencana_kehamilan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `siklus`
--
ALTER TABLE `siklus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gejala_harian`
--
ALTER TABLE `gejala_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proses_kehamilan`
--
ALTER TABLE `proses_kehamilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rencana_kehamilan`
--
ALTER TABLE `rencana_kehamilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siklus`
--
ALTER TABLE `siklus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gejala_harian`
--
ALTER TABLE `gejala_harian`
  ADD CONSTRAINT `gejala_harian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `proses_kehamilan`
--
ALTER TABLE `proses_kehamilan`
  ADD CONSTRAINT `proses_kehamilan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rencana_kehamilan`
--
ALTER TABLE `rencana_kehamilan`
  ADD CONSTRAINT `rencana_kehamilan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siklus`
--
ALTER TABLE `siklus`
  ADD CONSTRAINT `siklus_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
