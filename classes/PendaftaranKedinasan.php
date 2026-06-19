<?php

require_once __DIR__ . '/Pendaftaran.php';

/**
 * Class PendaftaranKedinasan
 *
 * Kelas turunan dari Pendaftaran yang merepresentasikan
 * jalur pendaftaran Kedinasan. Jalur ini memiliki properti
 * tambahan berupa nomor SK ikatan dinas dan instansi sponsor,
 * serta dikenakan biaya tambahan 25% dari biaya dasar.
 *
 * Tahap 4 (Inheritance): extends Pendaftaran
 * Tahap 5 (Polymorphism): override hitungTotalBiaya() & tampilkanInfoJalur()
 *
 * @author  Rifki Pramudya Pangestu
 */
class PendaftaranKedinasan extends Pendaftaran
{
    /**
     * Nomor SK ikatan dinas.
     */
    protected string $sk_ikatan_dinas;

    /**
     * Nama instansi yang menjadi sponsor.
     */
    protected string $instansi_sponsor;

    /**
     * Constructor untuk PendaftaranKedinasan.
     *
     * Memanggil parent::__construct untuk inisialisasi properti dasar,
     * kemudian menambahkan properti khusus jalur Kedinasan.
     *
     * @param int    $id_pendaftaran         ID pendaftaran
     * @param string $nama_calon             Nama calon mahasiswa
     * @param string $asal_sekolah           Asal sekolah
     * @param float  $nilai_ujian            Nilai ujian masuk
     * @param int    $biaya_pendaftaran_dasar Biaya pendaftaran dasar
     * @param string $sk_ikatan_dinas        Nomor SK ikatan dinas
     * @param string $instansi_sponsor       Nama instansi sponsor
     */
    public function __construct(
        int $id_pendaftaran,
        string $nama_calon,
        string $asal_sekolah,
        float $nilai_ujian,
        int $biaya_pendaftaran_dasar,
        string $sk_ikatan_dinas,
        string $instansi_sponsor
    ) {
        // Memanggil constructor parent (Pendaftaran)
        parent::__construct(
            $id_pendaftaran,
            $nama_calon,
            $asal_sekolah,
            $nilai_ujian,
            $biaya_pendaftaran_dasar
        );

        $this->sk_ikatan_dinas  = $sk_ikatan_dinas;
        $this->instansi_sponsor = $instansi_sponsor;
    }

    /**
     * Override: Menghitung total biaya pendaftaran jalur Kedinasan.
     *
     * Jalur Kedinasan dikenakan biaya tambahan 25% dari biaya dasar
     * karena mencakup biaya administrasi ikatan dinas.
     * Formula: biaya_pendaftaran_dasar * 1.25
     *
     * @return int Total biaya pendaftaran
     */
    public function hitungTotalBiaya(): int
    {
        return (int) ($this->biaya_pendaftaran_dasar * 1.25);
    }

    /**
     * Override: Menampilkan informasi spesifik jalur Kedinasan.
     *
     * Mengembalikan string yang berisi detail jalur pendaftaran
     * beserta nomor SK ikatan dinas dan instansi sponsor.
     *
     * @return string Informasi jalur pendaftaran
     */
    public function tampilkanInfoJalur(): string
    {
        return "=== Jalur Pendaftaran: KEDINASAN ===" . PHP_EOL
             . "Nama             : {$this->nama_calon}" . PHP_EOL
             . "Asal Sekolah     : {$this->asal_sekolah}" . PHP_EOL
             . "Nilai Ujian      : {$this->nilai_ujian}" . PHP_EOL
             . "SK Ikatan Dinas  : {$this->sk_ikatan_dinas}" . PHP_EOL
             . "Instansi Sponsor : {$this->instansi_sponsor}" . PHP_EOL
             . "Total Biaya      : Rp " . number_format($this->hitungTotalBiaya(), 0, ',', '.');
    }

    /**
     * Query database untuk mendapatkan semua data pendaftaran jalur Kedinasan.
     *
     * Metode statis ini mengambil data dari tabel_pendaftaran
     * dengan filter jalur_pendaftaran = 'Kedinasan', lalu mengembalikan
     * array berisi objek PendaftaranKedinasan.
     *
     * @param  PDO   $pdo Koneksi PDO ke database
     * @return array Array of PendaftaranKedinasan
     */
    public static function getDaftarJalur(PDO $pdo): array
    {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = :jalur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':jalur' => 'Kedinasan']);

        $daftar = [];

        while ($row = $stmt->fetch()) {
            $daftar[] = new self(
                (int)    $row['id_pendaftaran'],
                (string) $row['nama_calon'],
                (string) $row['asal_sekolah'],
                (float)  $row['nilai_ujian'],
                (int)    $row['biaya_pendaftaran_dasar'],
                (string) $row['sk_ikatan_dinas'],
                (string) $row['instansi_sponsor']
            );
        }

        return $daftar;
    }
}
