<?php

/**
 * Abstract Class Pendaftaran
 *
 * Kelas abstrak yang merepresentasikan pendaftaran mahasiswa baru.
 * Kelas ini menjadi blueprint untuk berbagai jalur pendaftaran
 * (Reguler, Prestasi, Kedinasan).
 *
 * @author  Rifki Pramudya Pangestu
 */
abstract class Pendaftaran
{
    /**
     * ID unik pendaftaran.
     */
    protected int $id_pendaftaran;

    /**
     * Nama lengkap calon mahasiswa.
     */
    protected string $nama_calon;

    /**
     * Asal sekolah calon mahasiswa.
     */
    protected string $asal_sekolah;

    /**
     * Nilai ujian masuk calon mahasiswa.
     */
    protected float $nilai_ujian;

    /**
     * Biaya pendaftaran dasar (sebelum penyesuaian jalur).
     */
    protected int $biaya_pendaftaran_dasar;

    /**
     * Constructor untuk inisialisasi properti dasar pendaftaran.
     *
     * @param int    $id_pendaftaran         ID pendaftaran
     * @param string $nama_calon             Nama calon mahasiswa
     * @param string $asal_sekolah           Asal sekolah
     * @param float  $nilai_ujian            Nilai ujian masuk
     * @param int    $biaya_pendaftaran_dasar Biaya pendaftaran dasar
     */
    public function __construct(
        int $id_pendaftaran,
        string $nama_calon,
        string $asal_sekolah,
        float $nilai_ujian,
        int $biaya_pendaftaran_dasar
    ) {
        $this->id_pendaftaran         = $id_pendaftaran;
        $this->nama_calon             = $nama_calon;
        $this->asal_sekolah           = $asal_sekolah;
        $this->nilai_ujian            = $nilai_ujian;
        $this->biaya_pendaftaran_dasar = $biaya_pendaftaran_dasar;
    }

    /**
     * Menghitung total biaya pendaftaran berdasarkan jalur.
     *
     * Setiap jalur pendaftaran memiliki formula perhitungan
     * biaya yang berbeda-beda.
     *
     * @return int Total biaya pendaftaran
     */
    abstract public function hitungTotalBiaya(): int;

    /**
     * Menampilkan informasi spesifik jalur pendaftaran.
     *
     * Setiap jalur pendaftaran memiliki informasi tambahan
     * yang berbeda (prodi, prestasi, ikatan dinas, dsb.).
     *
     * @return string Informasi jalur pendaftaran
     */
    abstract public function tampilkanInfoJalur(): string;
}
