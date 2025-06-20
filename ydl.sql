-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 06:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ydl`
--

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `deskripsi_kegiatan` text DEFAULT NULL,
  `foto_kegiatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `tanggal_kegiatan`, `deskripsi_kegiatan`, `foto_kegiatan`) VALUES
(2, '2025-06-11', 'Gotong royong membersihkan lingkungan sekitar balai d[[', 'uploads/aura_bg.png'),
(3, '2025-06-11', 'ini tes kegiatan', 'uploads/aura_bg.png');

-- --------------------------------------------------------

--
-- Table structure for table `pencapaian`
--

CREATE TABLE `pencapaian` (
  `id_pencapaian` int(11) NOT NULL,
  `judul_pencapaian` varchar(100) DEFAULT NULL,
  `deskripsi_pencapaian` text DEFAULT NULL,
  `foto_pencapaian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pencapaian`
--

INSERT INTO `pencapaian` (`id_pencapaian`, `judul_pencapaian`, `deskripsi_pencapaian`, `foto_pencapaian`) VALUES
(1, 'Juara 1 Lomba Sains Nasional', 'Berhasil membawa siswa meraih juara 1 lomba sains tingkat nasional. udah sy edit wkkwkwk', 'uploads_pencapaian/aura_bg.png'),
(2, 'menang tournament', 'kemarin saya menang yeyyyyy', 'uploads_pencapaian/aura_bg.png');

-- --------------------------------------------------------

--
-- Table structure for table `pendidik`
--

CREATE TABLE `pendidik` (
  `id_pendidik` int(11) NOT NULL,
  `nama_pendidik` varchar(100) DEFAULT NULL,
  `jabatan_pendidik` varchar(100) DEFAULT NULL,
  `deskripsi_pendidik` text DEFAULT NULL,
  `foto_pendidik` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendidik`
--

INSERT INTO `pendidik` (`id_pendidik`, `nama_pendidik`, `jabatan_pendidik`, `deskripsi_pendidik`, `foto_pendidik`) VALUES
(1, 'Siti Aminah', 'Guru Bahasa', 'Mengajar Bahasa Indonesia untuk siswa kelas atas. aww;;fja e', 'uploads_pendidik/Screenshot 2023-11-09 135936.png'),
(2, 'guts', 'jungle', 'harus on point', 'uploads_pendidik/b5f15aae-2993-4ac9-b5cf-faea1431ae4d.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id_pengurus` int(11) NOT NULL,
  `nama_pengurus` varchar(100) DEFAULT NULL,
  `jabatan_pengurus` varchar(100) DEFAULT NULL,
  `deskripsi_pengurus` text DEFAULT NULL,
  `foto_pengurus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id_pengurus`, `nama_pengurus`, `jabatan_pengurus`, `deskripsi_pengurus`, `foto_pengurus`) VALUES
(1, 'Budi Santosi', 'Ketua Umum', 'Bertanggung jawab atas seluruh kegiatan organisasi.', 'uploads_pengurus/Screenshot 2023-11-09 135936.png'),
(2, 'Aryakrs', 'Presiden', 'Aryakrs dengan nama asli Made Arya Ganteng bgt', 'uploads_pengurus/Screenshot 2023-11-09 135936.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `pencapaian`
--
ALTER TABLE `pencapaian`
  ADD PRIMARY KEY (`id_pencapaian`);

--
-- Indexes for table `pendidik`
--
ALTER TABLE `pendidik`
  ADD PRIMARY KEY (`id_pendidik`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id_pengurus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pencapaian`
--
ALTER TABLE `pencapaian`
  MODIFY `id_pencapaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pendidik`
--
ALTER TABLE `pendidik`
  MODIFY `id_pendidik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id_pengurus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
