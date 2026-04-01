CREATE DATABASE smart_parkir;

USE smart_parkir;

CREATE TABLE
    users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        password VARCHAR(50),
        role enum ('admin', 'petugas', 'owner') NOT NULL DEFAULT 'petugas' COMMENT 'admin: admin, petugas: petugas, owner: owner'
    );

INSERT INTO
    users (username, password, role)
VALUES
    ('admin', '12345678', 'admin'),
    ('petugas', '12345678', 'petugas'),
    ('owner', '12345678', 'owner');

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Apr 2026 pada 18.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30
SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
    time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_parkir`
--
-- --------------------------------------------------------
--
-- Struktur dari tabel `parkir`
--
CREATE TABLE
    `parkir` (
        `id` int (11) NOT NULL,
        `card_id` varchar(50) NOT NULL,
        `checkin_time` datetime DEFAULT NULL,
        `checkout_time` datetime DEFAULT NULL,
        `status` enum ('IN', 'OUT', 'DONE') NOT NULL,
        `duration` int (11) DEFAULT NULL,
        `fee` int (11) DEFAULT NULL,
        `jenis` varchar(30) DEFAULT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data untuk tabel `parkir`
--
INSERT INTO
    `parkir` (
        `id`,
        `card_id`,
        `checkin_time`,
        `checkout_time`,
        `status`,
        `duration`,
        `fee`,
        `jenis`
    )
VALUES
    (
        1,
        'A4232',
        '2026-03-16 09:06:09',
        '2026-03-16 09:06:24',
        'OUT',
        NULL,
        2000,
        'Motor'
    ),
    (
        2,
        '5435335',
        '2026-03-16 09:33:21',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        3,
        '43242',
        '2026-03-16 09:33:41',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        4,
        '111111111111',
        '2026-03-16 09:34:11',
        NULL,
        'IN',
        NULL,
        NULL,
        'Mobil'
    ),
    (
        5,
        '212123',
        '2026-03-16 09:36:09',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        6,
        '232131',
        '2026-03-16 09:36:17',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        7,
        '23131',
        '2026-03-16 09:36:25',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        8,
        '3213132',
        '2026-03-16 09:36:32',
        '2026-04-01 22:52:17',
        'DONE',
        NULL,
        2000,
        'Motor'
    ),
    (
        9,
        '32131',
        '2026-03-16 14:24:52',
        NULL,
        'IN',
        NULL,
        NULL,
        'Truck'
    ),
    (
        10,
        '32132131',
        '2026-03-16 14:33:55',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        11,
        '321321312',
        '2026-03-16 14:34:02',
        NULL,
        'IN',
        NULL,
        NULL,
        'Motor'
    ),
    (
        12,
        '32132131',
        '2026-04-01 23:04:13',
        NULL,
        'IN',
        NULL,
        NULL,
        NULL
    ),
    (
        13,
        'A233BA',
        '2026-04-01 23:04:46',
        NULL,
        'IN',
        NULL,
        NULL,
        NULL
    ),
    (
        14,
        'A235BA',
        '2026-04-01 23:06:07',
        '2026-04-01 23:06:22',
        'DONE',
        0,
        3000,
        NULL
    );

--
-- Indexes for dumped tables
--
--
-- Indeks untuk tabel `parkir`
--
ALTER TABLE `parkir` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--
--
-- AUTO_INCREMENT untuk tabel `parkir`
--
ALTER TABLE `parkir` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 15;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;