<?php
$title = 'Laporan';
ob_start();
?>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Menu</h5>
                <ul class="sidebar-menu">
                    <?php if ($user['role'] === 'HRD'): ?>
                        <li><a href="/Kepegawaian/department">Halaman Departemen</a></li>
                        <li><a href="/Kepegawaian/karyawan">Halaman Karyawan</a></li>
                        <li><a href="/Kepegawaian/mastercuti">Halaman Master Cuti</a></li>
                        <li><a href="/Kepegawaian/pengajuancuti">Halaman Pengajuan Cuti</a></li>
                        <li><a href="/Kepegawaian/slipgaji">Halaman Slip Gaji</a></li>
                    <?php else: ?>
                        <li><a href="/Kepegawaian/karyawan">Halaman Karyawan</a></li>
                        <li><a href="/Kepegawaian/pengajuancuti">Halaman Pengajuan Cuti</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>📊 Laporan Sistem Kepegawaian</h4>
            </div>
            <div class="card-body">
                <p class="lead">Pilih jenis laporan yang ingin Anda lihat:</p>
                
                <div class="row mt-4">
                    <!-- Laporan Karyawan -->
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-people-fill" style="font-size: 3rem; color: #0d6efd;"></i>
                                <h5 class="card-title mt-3">Laporan Karyawan</h5>
                                <p class="card-text">Data lengkap karyawan dengan filter departemen dan status</p>
                                <a href="/Kepegawaian/laporan/karyawan" class="btn btn-primary">Lihat Laporan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Laporan Cuti -->
                    <div class="col-md-4 mb-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-check-fill" style="font-size: 3rem; color: #198754;"></i>
                                <h5 class="card-title mt-3">Laporan Cuti</h5>
                                <p class="card-text">Data pengajuan cuti dengan filter periode dan status</p>
                                <a href="/Kepegawaian/laporan/cuti" class="btn btn-success">Lihat Laporan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Laporan Gaji -->
                    <?php if ($user['role'] === 'HRD'): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="bi bi-cash-stack" style="font-size: 3rem; color: #ffc107;"></i>
                                <h5 class="card-title mt-3">Laporan Gaji</h5>
                                <p class="card-text">Data slip gaji karyawan dengan filter periode</p>
                                <a href="/Kepegawaian/laporan/gaji" class="btn btn-warning">Lihat Laporan</a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <hr class="my-4">
                
                <div class="alert alert-info">
                    <h6><i class="bi bi-info-circle-fill"></i> Informasi</h6>
                    <ul class="mb-0">
                        <li>Semua laporan dapat di-export ke format CSV</li>
                        <li>Gunakan filter untuk menyaring data sesuai kebutuhan</li>
                        <li>Laporan dapat dicetak langsung dari browser</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/base.php';
?>