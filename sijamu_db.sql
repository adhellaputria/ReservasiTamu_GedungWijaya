-- -------------------------------------------------------------
-- TablePlus 6.8.2(656)
--
-- https://tableplus.com/
--
-- Database: sijamu_db
-- Generation Time: 2026-03-12 09:59:46.7570
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `opd_id` int unsigned DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`),
  KEY `admins_opd_id_foreign` (`opd_id`),
  CONSTRAINT `admins_opd_id_foreign` FOREIGN KEY (`opd_id`) REFERENCES `opd` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `opd`;
CREATE TABLE `opd` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lantai` tinyint NOT NULL DEFAULT '1',
  `email_opd` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepala` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `opd_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `reservasi`;
CREATE TABLE `reservasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tamu` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_tamu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opd_id` int unsigned NOT NULL,
  `petugas_dituju` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tanggal` date NOT NULL,
  `jam_kunjungan` time DEFAULT NULL,
  `dokumen_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen_nama_asli` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak','Hadir','Tidak Hadir') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_tolak` text COLLATE utf8mb4_unicode_ci,
  `diproses_oleh` int unsigned DEFAULT NULL,
  `waktu_diproses` timestamp NULL DEFAULT NULL,
  `waktu_hadir` timestamp NULL DEFAULT NULL,
  `diverifikasi_oleh` int unsigned DEFAULT NULL,
  `email_konfirmasi_terkirim` tinyint(1) NOT NULL DEFAULT '0',
  `email_notif_opd_terkirim` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `jam_hadir` time DEFAULT NULL,
  `status_kehadiran` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reservasi_kode_unique` (`kode`),
  KEY `reservasi_opd_id_foreign` (`opd_id`),
  KEY `reservasi_diproses_oleh_foreign` (`diproses_oleh`),
  KEY `reservasi_diverifikasi_oleh_foreign` (`diverifikasi_oleh`),
  KEY `reservasi_kode_index` (`kode`),
  KEY `reservasi_status_index` (`status`),
  KEY `reservasi_tanggal_index` (`tanggal`),
  CONSTRAINT `reservasi_diproses_oleh_foreign` FOREIGN KEY (`diproses_oleh`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reservasi_diverifikasi_oleh_foreign` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reservasi_opd_id_foreign` FOREIGN KEY (`opd_id`) REFERENCES `opd` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `riwayat_status`;
CREATE TABLE `riwayat_status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reservasi_id` bigint unsigned NOT NULL,
  `status_lama` enum('Menunggu','Disetujui','Ditolak','Hadir','Tidak Hadir') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_baru` enum('Menunggu','Disetujui','Ditolak','Hadir','Tidak Hadir') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `oleh_admin` int unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `riwayat_status_reservasi_id_foreign` (`reservasi_id`),
  KEY `riwayat_status_oleh_admin_foreign` (`oleh_admin`),
  CONSTRAINT `riwayat_status_oleh_admin_foreign` FOREIGN KEY (`oleh_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `riwayat_status_reservasi_id_foreign` FOREIGN KEY (`reservasi_id`) REFERENCES `reservasi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `opd_id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `is_aktif`, `last_login`, `created_at`, `updated_at`) VALUES
(1, NULL, 'adminutama', '$2y$12$hoyLZBx7./E7Jrh7FjZwzOWKSaHXIXlnSubs0nEEbpITpMsZ7xInW', 'Admin Utama SIJAMU', 'adminutama@sijamu.go.id', 'admin_utama', 1, '2026-03-09 10:48:52', '2026-03-03 09:14:24', '2026-03-09 10:48:52'),
(2, 1, 'admin.bangda', '$2y$12$Pr7qrcOgU0uFaulDy54MK.ePONxHvBC4orj.Cac4ur9oQkmmc8iYe', 'Admin Bagian Pembangunan Daerah', 'admin.bangda@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(3, 2, 'admin.disdagkop', '$2y$12$NBHMY1EqBS1yZfNCE6tN1OUloyN65G/L0i2iOzkpfNdqR1TlRgYbm', 'Admin Disdagkop UKM', 'admin.disdagkop@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(4, 3, 'admin.pmd', '$2y$12$IjsS2mEk4XsUuRpWxs2Ko.QLp9Dr6JYzDsc.hK3AbVMmXWuPwDp.C', 'Admin Dinas PMD', 'admin.pmd@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(5, 4, 'admin.ppkb', '$2y$12$FZIVBjLpHctqpojySvbmSOMYn1YiCZqQjG3PunPV1DyO/VKP7.ESy', 'Admin Dinas PPKB & P3A', 'admin.ppkb@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:25', '2026-03-03 09:14:25'),
(6, 5, 'admin.dlh', '$2y$12$G/jNktX4K09W3u2mGjNq1ePS/XLGzquA98gT9nBER0psVxNYpPiYK', 'Admin Dinas Lingkungan Hidup', 'admin.dlh@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:25', '2026-03-03 09:14:25'),
(7, 6, 'admin.dispernaker', '$2y$12$mRgWTFHHmDAcW0RaCbhT.epmJpnr4qbcZU1L3z5xp6IEMmmR/4xk2', 'Admin Dispernaker', 'admin.dispernaker@sijamu.go.id', 'admin_opd', 1, '2026-03-09 10:47:14', '2026-03-03 09:14:25', '2026-03-09 10:47:14'),
(8, 7, 'admin.pangan', '$2y$12$ySsfvcnrBXFgxVVxLW93dOsyUc0oY8Rzp6neimiC89TOPPbNl.vdq', 'Admin Dinas Pangan', 'admin.pangan@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:25', '2026-03-03 09:14:25'),
(9, 8, 'admin.kominfo', '$2y$12$kq4a//XEJdO2iW3Mq0mLKe0fduXK9RQByAPrwQVDe85liejPllku6', 'Admin Dinas Kominfo', 'admin.kominfo@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:25', '2026-03-03 09:14:25'),
(10, 9, 'admin.perumahan', '$2y$12$upkn9/RW51GDylOMQDgTlO/QMfgxfM38yJ6zOfBcLNwmOjGPfbH9i', 'Admin Dinas Perumahan dan KP', 'admin.perumahan@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:26', '2026-03-03 09:14:26'),
(12, 11, 'admin.pora', '$2y$12$L7v.4iut5Apbh5.uB6JG.uKAjGGx/YefJEzNi6NHQyofHYDO/9crS', 'Admin Dinas Pemuda dan Olahraga', 'admin.pora@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:26', '2026-03-03 09:14:26'),
(13, 12, 'admin.inspektorat', '$2y$12$j5JS1Q7G5.eSDvCjnl4zr.Xi7RF8eOce.U60X/yYclqbLG2j9YOny', 'Admin Inspektorat', 'admin.inspektorat@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:26', '2026-03-03 09:14:26'),
(14, 13, 'admin.kesbangpol', '$2y$12$3XHpfL8.wC6uLzE11XBCBOz6mFA2JN7yO7yakVK6Ah7K8K5d9EZga', 'Admin Kesbangpol', 'admin.kesbangpol@sijamu.go.id', 'admin_opd', 1, NULL, '2026-03-03 09:14:27', '2026-03-03 09:14:27'),
(15, 10, 'admin.bkpp', '$2y$12$4H4oGEzuau5jz7byTwZAk.S55VwZ1RmJTmTdiHnRyX3kcbvJbNSP.', 'Admin BKPP', 'admin.bkpp@sijamu.go.id', 'admin_opd', 1, '2026-03-03 11:56:06', '2026-03-03 10:02:48', '2026-03-03 11:56:06');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000001_create_opd_table', 1),
(2, '2024_01_01_000002_create_admins_table', 1),
(3, '2024_01_01_000003_create_reservasi_table', 1),
(4, '2024_01_01_000004_create_riwayat_status_table', 1),
(5, '2024_01_01_000005_create_sesi_jam_table', 1),
(6, '2024_01_01_000006_add_tidak_hadir_status', 1),
(7, '2024_01_01_000007_add_admin_utama_role', 1),
(8, '2024_01_01_000008_fix_admin_role_enum', 2),
(9, '2026_02_20_112006_create_cache_table', 2),
(10, '2026_02_25_135652_make_opd_nullable_on_admins', 2),
(11, '2026_02_26_000001_replace_sesi_jam_with_jam_kunjungan', 2);

INSERT INTO `opd` (`id`, `kode`, `nama`, `lantai`, `email_opd`, `telepon`, `kepala`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'BANGDA', 'Bagian Pembangunan Daerah', 2, 'bangda@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(2, 'DISDAGKOP', 'Disdagkop UKM', 2, 'disdagkop@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(3, 'PMD', 'Dinas PMD', 3, 'pmd@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 11:52:39'),
(4, 'PPKB', 'Dinas PPKB & P3A', 3, 'ppkb@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(5, 'DLH', 'Dinas Lingkungan Hidup', 4, 'dlh@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(6, 'DISPERNAKER', 'Dispernaker', 4, 'dispernaker@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(7, 'PANGAN', 'Dinas Pangan', 5, 'pangan@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(8, 'KOMINFO', 'Dinas Kominfo', 5, 'kominfo@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(9, 'PERUMAHAN', 'Dinas Perumahan dan KP', 6, 'perumahan@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(10, 'BKPP', 'BKPP', 6, 'bkpp@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(11, 'PORA', 'Dinas Pemuda dan Olahraga', 7, 'pora@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(12, 'INSPEKTORAT', 'Inspektorat', 7, 'inspektorat@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24'),
(13, 'KESBANGPOL', 'Kesbangpol', 7, 'kesbangpol@sijamu.go.id', '-', '-', 1, '2026-03-03 09:14:24', '2026-03-03 09:14:24');

INSERT INTO `reservasi` (`id`, `kode`, `nama_tamu`, `no_hp`, `email_tamu`, `instansi`, `opd_id`, `petugas_dituju`, `tujuan`, `keterangan`, `tanggal`, `jam_kunjungan`, `dokumen_path`, `dokumen_nama_asli`, `status`, `alasan_tolak`, `diproses_oleh`, `waktu_diproses`, `waktu_hadir`, `diverifikasi_oleh`, `email_konfirmasi_terkirim`, `email_notif_opd_terkirim`, `created_at`, `updated_at`, `deleted_at`, `jam_hadir`, `status_kehadiran`) VALUES
(1, 'WJY-494TQM', 'Bella Aprillia', '0388363383', 'bellaapriliap@gmail.com', NULL, 6, NULL, 'konsultasi kesehatan', NULL, '2026-03-03', '09:18:00', NULL, NULL, 'Hadir', NULL, 7, '2026-03-03 09:22:02', '2026-03-03 09:22:10', 7, 0, 0, '2026-03-03 09:18:44', '2026-03-03 09:22:10', NULL, NULL, NULL),
(2, 'WJY-79XDKN', 'Reza', '03883633834', 'rz@gmail.com', NULL, 6, NULL, 'ssddd', NULL, '2026-03-03', '09:23:00', 'dokumen/WJY-79XDKN_04-bella-x5-besok.pdf', '04_BELLA_X5_BESOK.pdf', 'Tidak Hadir', NULL, 7, '2026-03-03 09:25:25', NULL, NULL, 0, 0, '2026-03-03 09:23:37', '2026-03-05 12:22:58', NULL, NULL, NULL),
(3, 'WJY-EP42J3', 'clay', '038836338334', 'clay@gmail.com', NULL, 6, NULL, 'konsultasi kesehatan', NULL, '2026-03-03', '09:24:00', NULL, NULL, 'Ditolak', 'sorry', 7, '2026-03-03 09:25:44', NULL, NULL, 0, 0, '2026-03-03 09:24:20', '2026-03-03 09:25:44', NULL, NULL, NULL),
(4, 'WJY-QD2PFE', 'rey', '038836338334', 'reyy@gmail.com', NULL, 5, NULL, 'konsultasi kesehatan', NULL, '2026-03-04', '09:24:00', NULL, NULL, 'Menunggu', NULL, NULL, NULL, NULL, NULL, 0, 0, '2026-03-03 09:25:06', '2026-03-03 09:25:06', NULL, NULL, NULL),
(5, 'WJY-B5SBCT', 'renald', '08912757133', 'rnd@gmail.com', NULL, 8, NULL, 'info  magang', NULL, '2026-03-04', '12:04:00', NULL, NULL, 'Menunggu', NULL, NULL, NULL, NULL, NULL, 0, 0, '2026-03-03 11:55:37', '2026-03-03 11:55:37', NULL, NULL, NULL),
(6, 'WJY-A572BA', 'resyinta', '0893161582913', 'rsnta021@gmail.com', NULL, 6, NULL, 'Konsultasi Magang', NULL, '2026-03-04', '12:20:00', NULL, NULL, 'Tidak Hadir', NULL, 7, '2026-03-05 12:20:01', NULL, NULL, 0, 0, '2026-03-05 12:19:02', '2026-03-05 12:26:06', NULL, NULL, NULL),
(7, 'WJY-R2FDW2', 'rania', '089764575436', 'rania@gmail.com', NULL, 6, NULL, 'kepoo', NULL, '2026-03-05', '12:33:00', NULL, NULL, 'Tidak Hadir', NULL, 7, '2026-03-05 12:49:50', NULL, NULL, 0, 0, '2026-03-05 12:33:25', '2026-03-06 10:39:11', NULL, NULL, NULL),
(8, 'WJY-Q8VYT9', 'ketyana surtia', '08975812816', 'ketyana@gmail.com', NULL, 6, NULL, 'minta ttd', NULL, '2026-03-05', '12:49:00', NULL, NULL, 'Ditolak', 'coba ganti hari lain', 7, '2026-03-05 12:50:11', NULL, NULL, 0, 0, '2026-03-05 12:49:18', '2026-03-05 12:50:11', NULL, NULL, NULL),
(9, 'WJY-PTCZT7', 'Bella Aprillia', '0388363383', 'bellaapriliap@gmail.com', NULL, 6, NULL, 'info  magang', NULL, '2026-03-05', '13:28:00', NULL, NULL, 'Hadir', NULL, 7, '2026-03-05 13:27:18', '2026-03-05 13:35:56', 7, 0, 0, '2026-03-05 13:26:59', '2026-03-05 13:35:56', NULL, NULL, NULL),
(10, 'WJY-UPBWX4', 'rey', '038836338334', 'reyy@gmail.com', NULL, 6, NULL, 'dcs wsss', NULL, '2026-03-05', '13:41:00', NULL, NULL, 'Hadir', NULL, 7, '2026-03-05 13:41:30', '2026-03-05 13:42:25', 7, 0, 0, '2026-03-05 13:41:13', '2026-03-05 13:42:25', NULL, NULL, NULL),
(11, 'WJY-L2JF8A', 'Reza', '08912757133', 'rz@gmail.com', NULL, 6, NULL, 'konsultasi kesehatan', NULL, '2026-03-05', '13:56:00', NULL, NULL, 'Hadir', NULL, 7, '2026-03-05 13:57:02', NULL, 7, 0, 0, '2026-03-05 13:56:50', '2026-03-05 13:57:17', NULL, '13:57:00', 'Tepat Waktu'),
(12, 'WJY-93NACN', 'kety', '0893161582913', 'ketyana@gmail.com', NULL, 6, NULL, 'izin konsultasi', NULL, '2026-03-06', '10:17:00', NULL, NULL, 'Tidak Hadir', NULL, 7, '2026-03-06 10:19:31', NULL, NULL, 0, 0, '2026-03-06 10:17:36', '2026-03-09 09:09:57', NULL, NULL, NULL),
(13, 'WJY-M3A6JB', 'rania', '089764575436', 'rania@gmail.com', NULL, 6, NULL, 'konsultasi kesehatan', NULL, '2026-03-06', '10:18:00', NULL, NULL, 'Hadir', NULL, 7, '2026-03-06 10:19:29', NULL, 7, 0, 0, '2026-03-06 10:18:48', '2026-03-06 10:57:18', NULL, '10:57:00', 'Terlambat 39 menit'),
(14, 'WJY-TWEJXU', 'adella', '03883633834', 'adll123@gmail.com', NULL, 6, NULL, 'konsultasi kesehatan', NULL, '2026-03-06', '10:22:00', NULL, NULL, 'Hadir', NULL, 7, '2026-03-06 10:23:01', NULL, 7, 0, 0, '2026-03-06 10:22:21', '2026-03-06 10:23:58', NULL, '10:23:00', 'Tepat Waktu'),
(15, 'WJY-F3PC8S', 'Bella Aprillia', '038836338334', 'bellaapriliap@gmail.com', NULL, 6, NULL, 'konsultasi kesehatan', NULL, '2026-03-09', '10:46:00', NULL, NULL, 'Disetujui', NULL, 7, '2026-03-09 10:47:59', NULL, NULL, 0, 0, '2026-03-09 10:46:43', '2026-03-09 10:47:59', NULL, NULL, NULL);

INSERT INTO `riwayat_status` (`id`, `reservasi_id`, `status_lama`, `status_baru`, `keterangan`, `oleh_admin`, `created_at`) VALUES
(1, 1, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-03 09:22:02'),
(2, 1, 'Disetujui', 'Hadir', 'Verifikasi kehadiran oleh petugas.', 7, '2026-03-03 09:22:10'),
(3, 2, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-03 09:25:25'),
(4, 3, 'Menunggu', 'Ditolak', 'sorry', 7, '2026-03-03 09:25:44'),
(5, 6, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-05 12:20:01'),
(6, 6, 'Disetujui', 'Tidak Hadir', 'Otomatis: Tamu tidak hadir hingga tanggal reservasi terlewati.', NULL, '2026-03-05 12:26:06'),
(7, 7, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-05 12:49:50'),
(8, 8, 'Menunggu', 'Ditolak', 'coba ganti hari lain', 7, '2026-03-05 12:50:11'),
(9, 9, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-05 13:27:18'),
(10, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.53931855 menit)', 7, '2026-03-05 13:27:32'),
(11, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.56588258333 menit)', 7, '2026-03-05 13:27:33'),
(12, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.57229633333 menit)', 7, '2026-03-05 13:27:34'),
(13, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.57532311667 menit)', 7, '2026-03-05 13:27:34'),
(14, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.57837006667 menit)', 7, '2026-03-05 13:27:34'),
(15, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.62644666667 menit)', 7, '2026-03-05 13:27:37'),
(16, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.63669663333 menit)', 7, '2026-03-05 13:27:38'),
(17, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.64029071667 menit)', 7, '2026-03-05 13:27:38'),
(18, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 807.64428141667 menit)', 7, '2026-03-05 13:27:38'),
(19, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 812.36156891667 menit)', 7, '2026-03-05 13:32:21'),
(20, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 812.38391381667 menit)', 7, '2026-03-05 13:32:23'),
(21, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 812.38985511667 menit)', 7, '2026-03-05 13:32:23'),
(22, 9, 'Disetujui', 'Hadir', 'Tamu hadir (Tepat Waktu)', 7, '2026-03-05 13:35:56'),
(23, 10, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-05 13:41:30'),
(24, 10, 'Disetujui', 'Hadir', 'Tamu hadir (Tepat Waktu)', 7, '2026-03-05 13:42:25'),
(25, 11, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-05 13:57:02'),
(26, 11, 'Disetujui', 'Hadir', 'Tamu hadir (Tepat Waktu)', 7, '2026-03-05 13:57:17'),
(27, 13, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-06 10:19:29'),
(28, 12, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-06 10:19:31'),
(29, 14, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-06 10:23:01'),
(30, 14, 'Disetujui', 'Hadir', 'Tamu hadir (Tepat Waktu)', 7, '2026-03-06 10:23:58'),
(31, 7, 'Disetujui', 'Tidak Hadir', 'Otomatis: Tamu tidak hadir hingga tanggal reservasi terlewati.', NULL, '2026-03-06 10:39:11'),
(32, 13, 'Disetujui', 'Hadir', 'Tamu hadir (Terlambat 39 menit)', 7, '2026-03-06 10:57:18'),
(33, 12, 'Disetujui', 'Tidak Hadir', 'Otomatis: Tamu tidak hadir hingga tanggal reservasi terlewati.', NULL, '2026-03-09 09:09:57'),
(34, 15, 'Menunggu', 'Disetujui', NULL, 7, '2026-03-09 10:47:59');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;