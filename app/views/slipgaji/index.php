<?php
$title = 'Slip Gaji';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Halaman Slip Gaji</h3>
    <?php if ($user['role'] === 'HRD'): ?>
        <a href="/Kepegawaian/slipgaji/create" class="btn btn-primary">Tambah Slip Gaji</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <?php if ($user['role'] === 'HRD'): ?>
                            <th>Nama Karyawan</th>
                        <?php endif; ?>
                        <th>Periode</th>
                        <th>Gaji Pokok</th>
                        <th>Gaji Bersih</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($slipGajis)): ?>
                        <tr>
                            <td colspan="<?= $user['role'] === 'HRD' ? '6' : '5' ?>" class="text-center">Tidak ada data slip gaji</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($slipGajis as $sg): ?>
                            <tr>
                                <td><?= htmlspecialchars($sg['ID_Slip']) ?></td>
                                <?php if ($user['role'] === 'HRD'): ?>
                                    <td><?= htmlspecialchars($sg['Nama_Lengkap']) ?></td>
                                <?php endif; ?>
                                <td><?= date('F Y', mktime(0, 0, 0, $sg['Bulan'], 1, $sg['Tahun'])) ?></td>
                                <td>Rp <?= number_format($sg['Gaji_Pokok'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($sg['Gaji_Bersih'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="/Kepegawaian/slipgaji/show/<?= $sg['ID_Slip'] ?>" class="btn btn-sm btn-info">Lihat</a>
                                    <?php if ($user['role'] === 'HRD'): ?>
                                        <a href="/Kepegawaian/slipgaji/edit/<?= $sg['ID_Slip'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="/Kepegawaian/slipgaji/delete/<?= $sg['ID_Slip'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    <?php endif; ?>
                                </td>
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

