<?php

require_once __DIR__ . '/Pendaftaran.php';

/**
 * Class PendaftaranReguler
 *
 * Kelas turunan dari Pendaftaran yang merepresentasikan
 * jalur pendaftaran Reguler. Jalur ini memiliki properti
 * tambahan berupa pilihan program studi dan lokasi kampus.
 *
 * Tahap 4 (Inheritance): extends Pendaftaran
 * Tahap 5 (Polymorphism): override hitungTotalBiaya() & tampilkanInfoJalur()
 *
 * @author  Rifki Pramudya Pangestu
 */
class PendaftaranReguler extends Pendaftaran
{
    /**
     * Program studi yang dipilih calon mahasiswa.
     */
    protected string $pilihan_prodi;

    /**
     * Lokasi kampus yang dituju.
     */
    protected string $lokasi_kampus;

    /**
     * Constructor untuk PendaftaranReguler.
     *
     * Memanggil parent::__construct untuk inisialisasi properti dasar,
     * kemudian menambahkan properti khusus jalur Reguler.
     *
     * @param int    $id_pendaftaran         ID pendaftaran
     * @param string $nama_calon             Nama calon mahasiswa
     * @param string $asal_sekolah           Asal sekolah
     * @param float  $nilai_ujian            Nilai ujian masuk
     * @param int    $biaya_pendaftaran_dasar Biaya pendaftaran dasar
     * @param string $pilihan_prodi          Program studi yang dipilih
     * @param string $lokasi_kampus          Lokasi kampus
     */
    public function __construct(
        int $id_pendaftaran,
        string $nama_calon,
        string $asal_sekolah,
        float $nilai_ujian,
        int $biaya_pendaftaran_dasar,
        string $pilihan_prodi,
        string $lokasi_kampus
    ) {
        // Memanggil constructor parent (Pendaftaran)
        parent::__construct(
            $id_pendaftaran,
            $nama_calon,
            $asal_sekolah,
            $nilai_ujian,
            $biaya_pendaftaran_dasar
        );

        $this->pilihan_prodi = $pilihan_prodi;
        $this->lokasi_kampus = $lokasi_kampus;
    }

    /**
     * Override: Menghitung total biaya pendaftaran jalur Reguler.
     *
     * Jalur Reguler tidak mendapat potongan maupun tambahan biaya,
     * sehingga total biaya sama dengan biaya pendaftaran dasar.
     *
     * @return int Total biaya pendaftaran
     */
    public function hitungTotalBiaya(): int
    {
        return $this->biaya_pendaftaran_dasar;
    }

    /**
     * Override: Menampilkan informasi spesifik jalur Reguler.
     *
     * Mengembalikan string yang berisi detail jalur pendaftaran
     * beserta program studi dan lokasi kampus.
     *
     * @return string Informasi jalur pendaftaran
     */
    public function tampilkanInfoJalur(): string
    {
        return "=== Jalur Pendaftaran: REGULER ===" . PHP_EOL
             . "Nama         : {$this->nama_calon}" . PHP_EOL
             . "Asal Sekolah : {$this->asal_sekolah}" . PHP_EOL
             . "Nilai Ujian  : {$this->nilai_ujian}" . PHP_EOL
             . "Pilihan Prodi: {$this->pilihan_prodi}" . PHP_EOL
             . "Lokasi Kampus: {$this->lokasi_kampus}" . PHP_EOL
             . "Total Biaya  : Rp " . number_format($this->hitungTotalBiaya(), 0, ',', '.');
    }

    /**
     * Query database untuk mendapatkan semua data pendaftaran jalur Reguler.
     *
     * Metode statis ini mengambil data dari tabel_pendaftaran
     * dengan filter jalur_pendaftaran = 'Reguler', lalu mengembalikan
     * array berisi objek PendaftaranReguler.
     *
     * @param  PDO   $pdo Koneksi PDO ke database
     * @return array Array of PendaftaranReguler
     */
    public static function getDaftarJalur(PDO $pdo): array
    {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = :jalur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':jalur' => 'Reguler']);

        $daftar = [];

        while ($row = $stmt->fetch()) {
            $daftar[] = new self(
                (int)    $row['id_pendaftaran'],
                (string) $row['nama_calon'],
                (string) $row['asal_sekolah'],
                (float)  $row['nilai_ujian'],
                (int)    $row['biaya_pendaftaran_dasar'],
                (string) $row['pilihan_prodi'],
                (string) $row['lokasi_kampus']
            );
        }

        return $daftar;
    }
}
