<?php
$title = 'Detail Slip Gaji';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4>Slip Gaji</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Nama Karyawan</h6>
                        <p><?= htmlspecialchars($slipGaji['Nama_Lengkap']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Periode</h6>
                        <p><?= date('F Y', mktime(0, 0, 0, $slipGaji['Bulan'], 1, $slipGaji['Tahun'])) ?></p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Gaji Pokok</strong></div>
                    <div class="col-md-6 text-end">Rp <?= number_format($slipGaji['Gaji_Pokok'], 0, ',', '.') ?></div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Tunjangan Transportasi</strong></div>
                    <div class="col-md-6 text-end">Rp <?= number_format($slipGaji['Tunjangan_Transportasi'], 0, ',', '.') ?></div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Tunjangan Kesehatan</strong></div>
                    <div class="col-md-6 text-end">Rp <?= number_format($slipGaji['Tunjangan_Kesehatan'], 0, ',', '.') ?></div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Tunjangan Lainnya</strong></div>
                    <div class="col-md-6 text-end">Rp <?= number_format($slipGaji['Tunjangan_Lainnya'], 0, ',', '.') ?></div>
                </div>
                
                <div class="row mb-2" style="background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
                    <div class="col-md-6"><strong>Total Penerimaan</strong></div>
                    <div class="col-md-6 text-end"><strong>Rp <?= number_format($slipGaji['Total_Penerimaan'], 0, ',', '.') ?></strong></div>
                </div>
                
                <hr>
                
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Potongan Tetap</strong></div>
                    <div class="col-md-6 text-end">Rp <?= number_format($slipGaji['Potongan_Tetap'], 0, ',', '.') ?></div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Potongan Lainnya</strong></div>
                    <div class="col-md-6 text-end">Rp <?= number_format($slipGaji['Potongan_Lainnya'], 0, ',', '.') ?></div>
                </div>
                
                <div class="row mb-2" style="background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
                    <div class="col-md-6"><strong>Total Potongan</strong></div>
                    <div class="col-md-6 text-end"><strong>Rp <?= number_format($slipGaji['Total_Potongan'], 0, ',', '.') ?></strong></div>
                </div>
                
                <hr>
                
                <div class="row mb-2" style="background-color: #e8f5e9; padding: 15px; border-radius: 5px; font-size: 1.1em;">
                    <div class="col-md-6"><strong>Gaji Bersih</strong></div>
                    <div class="col-md-6 text-end"><strong style="color: green;">Rp <?= number_format($slipGaji['Gaji_Bersih'], 0, ',', '.') ?></strong></div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="/Kepegawaian/slipgaji" class="btn btn-secondary">Kembali</a>
                    <button onclick="window.print()" class="btn btn-primary">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/base.php';
?>

