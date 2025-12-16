<?php
$title = 'Laporan Pengajuan Cuti';
ob_start();
?>

<div class="mb-3">
    <a href="/Kepegawaian/laporan" class="btn btn-secondary btn-sm">← Kembali ke Laporan</a>
</div>

<div class="card">
    <div class="card-header bg-success text-white">
        <h4>📊 Laporan Pengajuan Cuti</h4>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="/Kepegawaian/laporan/cuti" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    <?php 
                    $bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    for ($i = 1; $i <= 12; $i++): 
                    ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $filterBulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                            <?= $bulanNames[$i] ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <?php for ($y = 2023; $y <= 2027; $y++): ?>
                        <option value="<?= $y ?>" <?= $filterTahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" <?= $filterStatus === 'all' ? 'selected' : '' ?>>Semua Status</option>
                    <option value="Pending" <?= $filterStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Disetujui" <?= $filterStatus === 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="Ditolak" <?= $filterStatus === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="/Kepegawaian/laporan/cuti" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        
        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h6>Total Pengajuan</h6>
                        <h2><?= $stats['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h6>Pending</h6>
                        <h2><?= $stats['pending'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h6>Disetujui</h6>
                        <h2><?= $stats['disetujui'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h6>Ditolak</h6>
                        <h2><?= $stats['ditolak'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info">
            <strong>Total Hari Cuti:</strong> <?= $stats['total_hari'] ?> hari
        </div>
        
        <!-- Action Buttons -->
        <div class="mb-3">
            <a href="/Kepegawaian/laporan/export/cuti-csv" class="btn btn-success">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
            </a>
        </div>
        
        <!-- Tabel Pengajuan Cuti -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Jumlah Hari</th>
                        <th>Status</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengajuans)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pengajuan cuti</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($pengajuans as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($p['Nama_Lengkap']) ?></td>
                                <td><?= htmlspecialchars($p['Nama_Cuti']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['Tgl_Awal'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['Tgl_Akhir'])) ?></td>
                                <td><?= $p['Jumlah_Hari'] ?> hari</td>
                                <td>
                                    <?php
                                    $badgeClass = 'secondary';
                                    if ($p['Status_Pengajuan'] === 'Disetujui') $badgeClass = 'success';
                                    if ($p['Status_Pengajuan'] === 'Ditolak') $badgeClass = 'danger';
                                    if ($p['Status_Pengajuan'] === 'Pending') $badgeClass = 'warning';
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= htmlspecialchars($p['Status_Pengajuan']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars(substr($p['Alasan'] ?? '-', 0, 50)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/base.php';
?>