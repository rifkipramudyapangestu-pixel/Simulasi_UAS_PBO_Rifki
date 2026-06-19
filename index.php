<?php

/**
 * Index.php - Halaman Utama Sistem PMB
 *
 * Tahap 6 (Tahap Akhir): Antarmuka yang menampilkan daftar
 * pendaftaran mahasiswa baru dengan layout sidebar + main content.
 * Mendemonstrasikan Polymorphism melalui pemanggilan
 * hitungTotalBiaya() dan tampilkanInfoJalur() pada setiap objek.
 *
 * @author  Rifki Pramudya Pangestu
 */

// ================================================================
// 1. REQUIRE SEMUA FILE KELAS (Tahap 3 & 4)
// ================================================================
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/classes/Pendaftaran.php';
require_once __DIR__ . '/classes/PendaftaranReguler.php';
require_once __DIR__ . '/classes/PendaftaranPrestasi.php';
require_once __DIR__ . '/classes/PendaftaranKedinasan.php';

// ================================================================
// 2. AMBIL HALAMAN AKTIF DARI PARAMETER URL
// ================================================================
$page = $_GET['page'] ?? 'dashboard';
$allowedPages = ['dashboard', 'reguler', 'prestasi', 'kedinasan'];

// Validasi halaman agar aman
if (!in_array($page, $allowedPages, true)) {
    $page = 'dashboard';
}

// ================================================================
// 3. AMBIL DATA DARI DATABASE MENGGUNAKAN getDaftarJalur()
// ================================================================
$dataReguler   = PendaftaranReguler::getDaftarJalur($koneksi);
$dataPrestasi  = PendaftaranPrestasi::getDaftarJalur($koneksi);
$dataKedinasan = PendaftaranKedinasan::getDaftarJalur($koneksi);

// Hitung jumlah per jalur untuk statistik dashboard
$jumlahReguler   = count($dataReguler);
$jumlahPrestasi  = count($dataPrestasi);
$jumlahKedinasan = count($dataKedinasan);
$jumlahTotal     = $jumlahReguler + $jumlahPrestasi + $jumlahKedinasan;

// ================================================================
// 4. AMBIL DATA MENTAH DARI DATABASE UNTUK KOLOM TABEL
//    Raw data digunakan untuk menampilkan kolom individual
//    (nama, asal_sekolah, dll.) secara rapi di tabel.
// ================================================================
$sqlAll = "SELECT * FROM tabel_pendaftaran ORDER BY id_pendaftaran ASC";
$stmtAll = $koneksi->query($sqlAll);
$semuaRawData = $stmtAll->fetchAll();

// ================================================================
// 5. INSTANSIASI OBJEK + DATA MENTAH (IF/ELSE Polymorphism)
//    Looping data dari database, lalu buat objek sesuai jalur.
//    Setiap entry menyimpan ['row' => raw data, 'objek' => Pendaftaran]
// ================================================================
$semuaEntri = [];

foreach ($semuaRawData as $row) {
    $objek = null;

    // Kondisi IF/ELSE untuk instansiasi kelas sesuai jalur
    if ($row['jalur_pendaftaran'] === 'Reguler') {
        $objek = new PendaftaranReguler(
            (int)    $row['id_pendaftaran'],
            (string) $row['nama_calon'],
            (string) $row['asal_sekolah'],
            (float)  $row['nilai_ujian'],
            (int)    $row['biaya_pendaftaran_dasar'],
            (string) $row['pilihan_prodi'],
            (string) $row['lokasi_kampus']
        );
    } elseif ($row['jalur_pendaftaran'] === 'Prestasi') {
        $objek = new PendaftaranPrestasi(
            (int)    $row['id_pendaftaran'],
            (string) $row['nama_calon'],
            (string) $row['asal_sekolah'],
            (float)  $row['nilai_ujian'],
            (int)    $row['biaya_pendaftaran_dasar'],
            (string) $row['jenis_prestasi'],
            (string) $row['tingkat_prestasi']
        );
    } elseif ($row['jalur_pendaftaran'] === 'Kedinasan') {
        $objek = new PendaftaranKedinasan(
            (int)    $row['id_pendaftaran'],
            (string) $row['nama_calon'],
            (string) $row['asal_sekolah'],
            (float)  $row['nilai_ujian'],
            (int)    $row['biaya_pendaftaran_dasar'],
            (string) $row['sk_ikatan_dinas'],
            (string) $row['instansi_sponsor']
        );
    }

    if ($objek !== null) {
        $semuaEntri[] = [
            'row'   => $row,    // Data mentah untuk kolom tabel
            'objek' => $objek,  // Objek untuk method polymorphic
        ];
    }
}

// Filter data berdasarkan halaman aktif
$dataTampil = match ($page) {
    'reguler'   => array_filter($semuaEntri, fn($e) => $e['objek'] instanceof PendaftaranReguler),
    'prestasi'  => array_filter($semuaEntri, fn($e) => $e['objek'] instanceof PendaftaranPrestasi),
    'kedinasan' => array_filter($semuaEntri, fn($e) => $e['objek'] instanceof PendaftaranKedinasan),
    default     => $semuaEntri,
};

// Label halaman
$pageLabels = [
    'dashboard' => ['title' => 'Dashboard',       'desc' => 'Ringkasan data seluruh pendaftaran mahasiswa baru'],
    'reguler'   => ['title' => 'Data Reguler',     'desc' => 'Daftar pendaftaran melalui jalur Reguler'],
    'prestasi'  => ['title' => 'Data Prestasi',    'desc' => 'Daftar pendaftaran melalui jalur Prestasi'],
    'kedinasan' => ['title' => 'Data Kedinasan',   'desc' => 'Daftar pendaftaran melalui jalur Kedinasan'],
];

/**
 * Helper: Menentukan kelas badge CSS berdasarkan kelas objek.
 *
 * @param  Pendaftaran $obj Objek pendaftaran
 * @return string      Nama kelas CSS badge
 */
function getBadgeClass(Pendaftaran $obj): string
{
    return match (true) {
        $obj instanceof PendaftaranReguler   => 'badge-reguler',
        $obj instanceof PendaftaranPrestasi  => 'badge-prestasi',
        $obj instanceof PendaftaranKedinasan => 'badge-kedinasan',
        default => '',
    };
}

/**
 * Helper: Menentukan label jalur berdasarkan kelas objek.
 *
 * @param  Pendaftaran $obj Objek pendaftaran
 * @return string      Label jalur
 */
function getJalurLabel(Pendaftaran $obj): string
{
    return match (true) {
        $obj instanceof PendaftaranReguler   => 'Reguler',
        $obj instanceof PendaftaranPrestasi  => 'Prestasi',
        $obj instanceof PendaftaranKedinasan => 'Kedinasan',
        default => 'Unknown',
    };
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Pendaftaran Mahasiswa Baru (PMB) - Politeknik">
    <title>Sistem PMB — <?= htmlspecialchars($pageLabels[$page]['title']) ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-wrapper">

    <!-- ================================================================
         SIDEBAR - Navigasi Utama
         ================================================================ -->
    <aside class="sidebar" id="sidebar">

        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="brand-icon">P</div>
            <h2>Sistem PMB</h2>
            <p>Pendaftaran Mahasiswa Baru</p>
        </div>

        <!-- Navigation Links -->
        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>

            <a href="index.php?page=dashboard"
               class="nav-link <?= $page === 'dashboard' ? 'active' : '' ?>"
               id="nav-dashboard">
                <span class="nav-icon">📊</span>
                Dashboard
                <span class="nav-badge"><?= $jumlahTotal ?></span>
            </a>

            <div class="nav-section-label">Jalur Pendaftaran</div>

            <a href="index.php?page=reguler"
               class="nav-link <?= $page === 'reguler' ? 'active' : '' ?>"
               id="nav-reguler">
                <span class="nav-icon">📘</span>
                Data Reguler
                <span class="nav-badge"><?= $jumlahReguler ?></span>
            </a>

            <a href="index.php?page=prestasi"
               class="nav-link <?= $page === 'prestasi' ? 'active' : '' ?>"
               id="nav-prestasi">
                <span class="nav-icon">🏆</span>
                Data Prestasi
                <span class="nav-badge"><?= $jumlahPrestasi ?></span>
            </a>

            <a href="index.php?page=kedinasan"
               class="nav-link <?= $page === 'kedinasan' ? 'active' : '' ?>"
               id="nav-kedinasan">
                <span class="nav-icon">🏛️</span>
                Data Kedinasan
                <span class="nav-badge"><?= $jumlahKedinasan ?></span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <p>&copy; <?= date('Y') ?> — Rifki Pramudya Pangestu</p>
            <p>Simulasi UAS PBO TRPL-1A</p>
        </div>

    </aside>

    <!-- ================================================================
         MAIN CONTENT
         ================================================================ -->
    <main class="main-content" id="main-content">

        <!-- Page Header -->
        <div class="page-header">
            <h1><?= htmlspecialchars($pageLabels[$page]['title']) ?></h1>
            <p class="breadcrumb-text">
                Sistem PMB &raquo; <?= htmlspecialchars($pageLabels[$page]['desc']) ?>
            </p>
        </div>

        <!-- ============================================================
             DASHBOARD: Statistik Cards (hanya tampil di halaman dashboard)
             ============================================================ -->
        <?php if ($page === 'dashboard'): ?>
        <div class="stats-grid">
            <!-- Card: Total Pendaftar -->
            <div class="stat-card card-total" id="card-total">
                <div class="card-label">Total Pendaftar</div>
                <div class="card-value"><?= $jumlahTotal ?></div>
                <div class="card-icon">👥</div>
            </div>

            <!-- Card: Jalur Reguler -->
            <div class="stat-card card-reguler" id="card-reguler">
                <div class="card-label">Jalur Reguler</div>
                <div class="card-value"><?= $jumlahReguler ?></div>
                <div class="card-icon">📘</div>
            </div>

            <!-- Card: Jalur Prestasi -->
            <div class="stat-card card-prestasi" id="card-prestasi">
                <div class="card-label">Jalur Prestasi</div>
                <div class="card-value"><?= $jumlahPrestasi ?></div>
                <div class="card-icon">🏆</div>
            </div>

            <!-- Card: Jalur Kedinasan -->
            <div class="stat-card card-kedinasan" id="card-kedinasan">
                <div class="card-label">Jalur Kedinasan</div>
                <div class="card-value"><?= $jumlahKedinasan ?></div>
                <div class="card-icon">🏛️</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- ============================================================
             TABEL DATA PENDAFTARAN
             ============================================================ -->
        <div class="table-card" id="table-pendaftaran">
            <div class="table-card-header">
                <h3>
                    <?php
                    echo match ($page) {
                        'reguler'   => '📘 Daftar Pendaftaran Jalur Reguler',
                        'prestasi'  => '🏆 Daftar Pendaftaran Jalur Prestasi',
                        'kedinasan' => '🏛️ Daftar Pendaftaran Jalur Kedinasan',
                        default     => '📋 Seluruh Data Pendaftaran',
                    };
                    ?>
                </h3>
            </div>

            <div class="table-responsive">
                <?php if (empty($dataTampil)): ?>
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Belum ada data pendaftaran.</p>
                    </div>
                <?php else: ?>
                    <table class="data-table" id="tabel-data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Nama Calon</th>
                                <th>Asal Sekolah</th>
                                <th>Nilai Ujian</th>
                                <th>Jalur</th>
                                <th>Detail Spesifik Jalur</th>
                                <th>Biaya Dasar</th>
                                <th>Total Biaya</th>
                                <th>Info Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // ======================================================
                        // LOOPING DATA + POLYMORPHISM
                        //
                        // $entry['row']   = data mentah dari DB (untuk kolom tabel)
                        // $entry['objek'] = instance subclass Pendaftaran
                        //
                        // Pemanggilan $objek->hitungTotalBiaya() memanggil
                        // method yang di-OVERRIDE di masing-masing subclass.
                        // Pemanggilan $objek->tampilkanInfoJalur() menampilkan
                        // info unik per jalur. Inilah demonstrasi POLYMORPHISM.
                        // ======================================================
                        $no = 1;
                        foreach ($dataTampil as $entry):
                            $row   = $entry['row'];
                            $objek = $entry['objek'];

                            // Method polymorphic
                            $totalBiaya = $objek->hitungTotalBiaya();    // Override di subclass
                            $infoJalur  = $objek->tampilkanInfoJalur();  // Override di subclass

                            // Tentukan badge & detail spesifik berdasarkan jalur
                            $badgeClass = getBadgeClass($objek);
                            $jalurLabel = getJalurLabel($objek);

                            // Detail spesifik per jalur (kolom ringkas)
                            if ($objek instanceof PendaftaranReguler) {
                                $detailSpesifik = 'Prodi: ' . htmlspecialchars($row['pilihan_prodi'])
                                    . '<br>Kampus: ' . htmlspecialchars($row['lokasi_kampus']);
                            } elseif ($objek instanceof PendaftaranPrestasi) {
                                $detailSpesifik = 'Prestasi: ' . htmlspecialchars($row['jenis_prestasi'])
                                    . '<br>Tingkat: ' . htmlspecialchars($row['tingkat_prestasi']);
                            } elseif ($objek instanceof PendaftaranKedinasan) {
                                $detailSpesifik = 'SK: ' . htmlspecialchars($row['sk_ikatan_dinas'])
                                    . '<br>Instansi: ' . htmlspecialchars($row['instansi_sponsor']);
                            } else {
                                $detailSpesifik = '-';
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['id_pendaftaran']) ?></td>
                                <td><strong><?= htmlspecialchars($row['nama_calon']) ?></strong></td>
                                <td><?= htmlspecialchars($row['asal_sekolah']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['nilai_ujian']) ?></td>
                                <td>
                                    <span class="badge-jalur <?= $badgeClass ?>">
                                        <?= $jalurLabel ?>
                                    </span>
                                </td>
                                <td><span class="detail-spesifik"><?= $detailSpesifik ?></span></td>
                                <td class="text-center">Rp <?= number_format((int)$row['biaya_pendaftaran_dasar'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="biaya">
                                        Rp <?= number_format($totalBiaya, 0, ',', '.') ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn-detail"
                                            onclick="tampilkanDetail(this)"
                                            data-info="<?= htmlspecialchars($infoJalur) ?>">
                                        🔍 Lihat
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        <!-- / Table Card -->

    </main>

</div>

<!-- ================================================================
     MODAL: Detail Info Jalur (tampilkanInfoJalur())
     ================================================================ -->
<div class="modal-overlay" id="modal-overlay" onclick="tutupModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>📄 Detail Info Jalur (tampilkanInfoJalur)</h3>
            <button class="modal-close" onclick="tutupModal()">&times;</button>
        </div>
        <div class="modal-body">
            <pre id="modal-content"></pre>
        </div>
    </div>
</div>

<script>
/**
 * Menampilkan modal popup berisi output dari tampilkanInfoJalur().
 * Demonstrasi bahwa method polymorphic dipanggil dari subclass yang tepat.
 */
function tampilkanDetail(button) {
    const info = button.getAttribute('data-info');
    document.getElementById('modal-content').textContent = info;
    document.getElementById('modal-overlay').classList.add('show');
}

/**
 * Menutup modal popup.
 */
function tutupModal() {
    document.getElementById('modal-overlay').classList.remove('show');
}

// Tutup modal dengan tombol Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupModal();
});
</script>

</body>
</html>
