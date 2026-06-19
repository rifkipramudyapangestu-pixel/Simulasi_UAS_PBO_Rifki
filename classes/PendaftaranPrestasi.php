<?php

require_once __DIR__ . '/Pendaftaran.php';

/**
 * Class PendaftaranPrestasi
 *
 * Kelas turunan dari Pendaftaran yang merepresentasikan
 * jalur pendaftaran Prestasi. Jalur ini memiliki properti
 * tambahan berupa jenis prestasi dan tingkat prestasi,
 * serta mendapat potongan biaya pendaftaran.
 *
 * Tahap 4 (Inheritance): extends Pendaftaran
 * Tahap 5 (Polymorphism): override hitungTotalBiaya() & tampilkanInfoJalur()
 *
 * @author  Rifki Pramudya Pangestu
 */
class PendaftaranPrestasi extends Pendaftaran
{
    /**
     * Jenis prestasi yang dimiliki (misal: Olimpiade Matematika).
     */
    protected string $jenis_prestasi;

    /**
     * Tingkat prestasi (Kabupaten, Provinsi, Nasional, Internasional).
     */
    protected string $tingkat_prestasi;

    /**
     * Constructor untuk PendaftaranPrestasi.
     *
     * Memanggil parent::__construct untuk inisialisasi properti dasar,
     * kemudian menambahkan properti khusus jalur Prestasi.
     *
     * @param int    $id_pendaftaran         ID pendaftaran
     * @param string $nama_calon             Nama calon mahasiswa
     * @param string $asal_sekolah           Asal sekolah
     * @param float  $nilai_ujian            Nilai ujian masuk
     * @param int    $biaya_pendaftaran_dasar Biaya pendaftaran dasar
     * @param string $jenis_prestasi         Jenis prestasi
     * @param string $tingkat_prestasi       Tingkat prestasi
     */
    public function __construct(
        int $id_pendaftaran,
        string $nama_calon,
        string $asal_sekolah,
        float $nilai_ujian,
        int $biaya_pendaftaran_dasar,
        string $jenis_prestasi,
        string $tingkat_prestasi
    ) {
        // Memanggil constructor parent (Pendaftaran)
        parent::__construct(
            $id_pendaftaran,
            $nama_calon,
            $asal_sekolah,
            $nilai_ujian,
            $biaya_pendaftaran_dasar
        );

        $this->jenis_prestasi  = $jenis_prestasi;
        $this->tingkat_prestasi = $tingkat_prestasi;
    }

    /**
     * Override: Menghitung total biaya pendaftaran jalur Prestasi.
     *
     * Jalur Prestasi mendapat potongan Rp 50.000 dari biaya dasar
     * sebagai bentuk apresiasi atas prestasi calon mahasiswa.
     *
     * @return int Total biaya pendaftaran
     */
    public function hitungTotalBiaya(): int
    {
        return $this->biaya_pendaftaran_dasar - 50000;
    }

    /**
     * Override: Menampilkan informasi spesifik jalur Prestasi.
     *
     * Mengembalikan string yang berisi detail jalur pendaftaran
     * beserta jenis dan tingkat prestasi.
     *
     * @return string Informasi jalur pendaftaran
     */
    public function tampilkanInfoJalur(): string
    {
        return "=== Jalur Pendaftaran: PRESTASI ===" . PHP_EOL
             . "Nama            : {$this->nama_calon}" . PHP_EOL
             . "Asal Sekolah    : {$this->asal_sekolah}" . PHP_EOL
             . "Nilai Ujian     : {$this->nilai_ujian}" . PHP_EOL
             . "Jenis Prestasi  : {$this->jenis_prestasi}" . PHP_EOL
             . "Tingkat Prestasi: {$this->tingkat_prestasi}" . PHP_EOL
             . "Total Biaya     : Rp " . number_format($this->hitungTotalBiaya(), 0, ',', '.');
    }

    /**
     * Query database untuk mendapatkan semua data pendaftaran jalur Prestasi.
     *
     * Metode statis ini mengambil data dari tabel_pendaftaran
     * dengan filter jalur_pendaftaran = 'Prestasi', lalu mengembalikan
     * array berisi objek PendaftaranPrestasi.
     *
     * @param  PDO   $pdo Koneksi PDO ke database
     * @return array Array of PendaftaranPrestasi
     */
    public static function getDaftarJalur(PDO $pdo): array
    {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = :jalur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':jalur' => 'Prestasi']);

        $daftar = [];

        while ($row = $stmt->fetch()) {
            $daftar[] = new self(
                (int)    $row['id_pendaftaran'],
                (string) $row['nama_calon'],
                (string) $row['asal_sekolah'],
                (float)  $row['nilai_ujian'],
                (int)    $row['biaya_pendaftaran_dasar'],
                (string) $row['jenis_prestasi'],
                (string) $row['tingkat_prestasi']
            );
        }

        return $daftar;
    }
}
