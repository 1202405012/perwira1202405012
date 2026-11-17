-- Database: `simrs`
CREATE DATABASE IF NOT EXISTS `simrs`;
USE `simrs`;

-- Struktur tabel `users` untuk Login & Register
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default user (Username: admin, Password: admin123)
INSERT INTO `users` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Administrator', 'admin', '$2y$10$zbJm.WW9jS6Of0SEVpSTfuFWCNtCrouDtIIwFY.u7OcOw9EiX7DnW')
ON DUPLICATE KEY UPDATE `password`=VALUES(`password`);

-- Struktur tabel `alat`
CREATE TABLE IF NOT EXISTS `alat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_alat` varchar(255) NOT NULL,
  `tahun` varchar(20) NOT NULL,
  `merek` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data contoh untuk tabel `alat`
INSERT INTO `alat` (`id`, `nama_alat`, `tahun`, `merek`, `lokasi`) VALUES
(1, 'USG 4D', '2023', 'GE Healthcare', 'Poli Kebidanan'),
(2, 'Defibrillator', '2022', 'Philips', 'Ruang ICU'),
(3, 'ECG Machine 12-Lead', '2024', 'Nihon Kohden', 'Poli Jantung')
ON DUPLICATE KEY UPDATE `id`=`id`;
