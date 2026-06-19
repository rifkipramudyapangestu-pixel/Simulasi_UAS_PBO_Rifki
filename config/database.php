<?php

/**
 * Konfigurasi Koneksi Database
 *
 * File ini menyediakan koneksi PDO ke database MySQL
 * untuk Sistem Manajemen Pendaftaran Mahasiswa Baru (PMB).
 *
 * @author  Rifki Pramudya Pangestu
 */

$host     = 'localhost';
$port     = '3306';
$dbName   = 'db_simulasi_pbo_trpl1a_rifkipramudyapangestu';
$username = 'root';
$password = '';
$charset  = 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $koneksi = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
