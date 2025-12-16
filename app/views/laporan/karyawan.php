<?php
$title = 'Laporan Karyawan';
ob_start();
?>

<div class="mb-3">
    <a href="/Kepegawaian/laporan" class="btn btn-secondary btn-sm">← Kembali ke Laporan</a>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>📊 Laporan Data Karyawan</h4>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="/Kepegawaian/laporan/karyawan" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Departemen</label>
                <select name="departemen" class="form-select">
                    <option value="all" <?= $filterDepartemen === 'all' ? 'selected' : '' ?>>Semua Departemen</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['ID_Departemen'] ?>" <?= $filterDepartemen == $dept['ID_Departemen'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['Jabatan']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Status Kerja</label>
                <select name="status" class="form-select">
                    <option value="all" <?= $filterStatus === 'all' ? 'selected' : '' ?>>Semua Status</option>
                    <option value="Aktif" <?= $filterStatus === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Non-Aktif" <?= $filterStatus === 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    <option value="Cuti" <?= $filterStatus === 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                </select>
            </div>
            
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="/Kepegawaian/laporan/karyawan" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        
        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h6>Total Karyawan</h6>
                        <h2><?= $stats['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h6>Aktif</h6>
                        <h2><?= $stats['aktif'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h6>Non-Aktif</h6>
                        <h2><?= $stats['non_aktif'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h6>Cuti</h6>
                        <h2><?= $stats['cuti'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mb-3">
            <a href="/Kepegawaian/laporan/export/karyawan-csv" class="btn btn-success">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
            </a>
            <a href="/Kepegawaian/laporan/print/karyawan" class="btn btn-info" target="_blank">
                <i class="bi bi-printer"></i> Print
            </a>
        </div>
        
        <!-- Tabel Karyawan -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Departemen</th>
                        <th>Email</th>
                        <th>Tanggal Lahir</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($karyawans)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data karyawan</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($karyawans as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($k['Nama_Lengkap']) ?></td>
                                <td><?= htmlspecialchars($k['Nama_Departemen'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($k['Email_Kantor']) ?></td>
                                <td><?= date('d/m/Y', strtotime($k['Tgl_Lahir'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($k['Tgl_Masuk'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $k['Status_Kerja'] === 'Aktif' ? 'success' : ($k['Status_Kerja'] === 'Cuti' ? 'warning' : 'danger') ?>">
                                        <?= htmlspecialchars($k['Status_Kerja']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars(substr($k['Alamat'], 0, 50)) ?>...</td>
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