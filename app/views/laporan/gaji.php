<?php
$title = 'Laporan Slip Gaji';
ob_start();
?>

<div class="mb-3">
    <a href="/Kepegawaian/laporan" class="btn btn-secondary btn-sm">← Kembali ke Laporan</a>
</div>

<div class="card">
    <div class="card-header bg-warning text-dark">
        <h4>📊 Laporan Slip Gaji</h4>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="/Kepegawaian/laporan/gaji" class="row g-3 mb-4">
            <div class="col-md-4">
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
            
            <div class="col-md-4">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <?php for ($y = 2023; $y <= 2027; $y++): ?>
                        <option value="<?= $y ?>" <?= $filterTahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="/Kepegawaian/laporan/gaji" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        
        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Karyawan</h6>
                        <h4><?= $stats['total_karyawan'] ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Total Gaji Pokok</h6>
                        <h5>Rp <?= number_format($stats['total_gaji_pokok'], 0, ',', '.') ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Tunjangan</h6>
                        <h5>Rp <?= number_format($stats['total_tunjangan'], 0, ',', '.') ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6>Total Potongan</h6>
                        <h5>Rp <?= number_format($stats['total_potongan'], 0, ',', '.') ?></h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert alert-success">
            <h5><strong>Total Gaji Bersih:</strong> Rp <?= number_format($stats['total_gaji_bersih'], 0, ',', '.') ?></h5>
        </div>
        
        <!-- Tabel Slip Gaji -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Departemen</th>
                        <th>Gaji Pokok</th>
                        <th>Total Tunjangan</th>
                        <th>Total Potongan</th>
                        <th>Gaji Bersih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($slipGajis)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data slip gaji</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($slipGajis as $sg): ?>
                            <?php
                            $totalTunjangan = $sg['Tunjangan_Transportasi'] + $sg['Tunjangan_Kesehatan'] + $sg['Tunjangan_Lainnya'];
                            $totalPotongan = $sg['Potongan_Tetap'] + $sg['Potongan_Lainnya'];
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($sg['Nama_Lengkap']) ?></td>
                                <td><?= htmlspecialchars($sg['Nama_Departemen'] ?? '-') ?></td>
                                <td>Rp <?= number_format($sg['Gaji_Pokok'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($totalTunjangan, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($totalPotongan, 0, ',', '.') ?></td>
                                <td><strong>Rp <?= number_format($sg['Gaji_Bersih'], 0, ',', '.') ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="3" class="text-end">TOTAL:</th>
                        <th>Rp <?= number_format($stats['total_gaji_pokok'], 0, ',', '.') ?></th>
                        <th>Rp <?= number_format($stats['total_tunjangan'], 0, ',', '.') ?></th>
                        <th>Rp <?= number_format($stats['total_potongan'], 0, ',', '.') ?></th>
                        <th>Rp <?= number_format($stats['total_gaji_bersih'], 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/base.php';
?>