<?php
$title = 'Hapus Slip Gaji';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4>Hapus Slip Gaji</h4>
            </div>
            <div class="card-body">
                <p>Apakah Anda yakin ingin menghapus slip gaji berikut?</p>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td><?= htmlspecialchars($slipGaji['ID_Slip']) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Karyawan</th>
                        <td><?= htmlspecialchars($slipGaji['Nama_Lengkap']) ?></td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td><?= date('F Y', mktime(0, 0, 0, $slipGaji['Bulan'], 1, $slipGaji['Tahun'])) ?></td>
                    </tr>
                </table>
                
                <form method="POST" action="/Kepegawaian/slipgaji/delete/<?= $slipGaji['ID_Slip'] ?>">
                    <div class="d-flex justify-content-between">
                        <a href="/Kepegawaian/slipgaji" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/base.php';
?>

