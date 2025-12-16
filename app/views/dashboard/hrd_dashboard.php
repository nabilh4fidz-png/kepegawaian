<?php
$title = 'Dashboard HRD';
ob_start();
?>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Menu</h5>
                <ul class="sidebar-menu">
                    <li><a href="/Kepegawaian/department">Halaman Departemen</a></li>
                    <li><a href="/Kepegawaian/karyawan">Halaman Karyawan</a></li>
                    <li><a href="/Kepegawaian/mastercuti">Halaman Master Cuti</a></li>
                    <li><a href="/Kepegawaian/pengajuancuti">Halaman Pengajuan Cuti</a></li>
                    <li><a href="/Kepegawaian/slipgaji">Halaman Slip Gaji</a></li>
                    <li><a href="/Kepegawaian/laporan">📊 Halaman Laporan</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Dashboard HRD</h4>
            </div>
            <div class="card-body">
                <h5>Selamat datang, <?= htmlspecialchars($user['nama'] ?? $user['username']) ?>!</h5>
            </div>
        </div>
        
        <!-- Statistik Section -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h6>Total Karyawan</h6>
                        <h2><?= $stats['total_karyawan'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h6>Total Departemen</h6>
                        <h2><?= $stats['total_departemen'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ringkasan Pengajuan Cuti -->
        <div class="card mt-3">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">Ringkasan Pengajuan Cuti</h6>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h6>Pengajuan Pending</h6>
                        <h2><?= $stats['pengajuan_pending'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h6>Pengajuan Disetujui</h6>
                        <h2><?= $stats['pengajuan_disetujui'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h6>Pengajuan Ditolak</h6>
                        <h2><?= $stats['pengajuan_ditolak'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/base.php';
?>