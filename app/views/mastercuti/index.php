<?php
$title = 'Master Cuti';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Halaman Master Cuti</h3>
    <a href="/Kepegawaian/mastercuti/create" class="btn btn-primary">Tambah Master Cuti</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Cuti</th>
                        <th>Tipe Cuti</th>
                        <th>Jumlah Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($masterCutis)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data master cuti</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($masterCutis as $mc): ?>
                            <tr>
                                <td><?= htmlspecialchars($mc['ID_Master_Cuti']) ?></td>
                                <td><?= htmlspecialchars($mc['Nama_Cuti']) ?></td>
                                <td><?= htmlspecialchars($mc['Tipe_Cuti']) ?></td>
                                <td><?= htmlspecialchars($mc['Jumlah_Hari'] ?? '-') ?> hari</td>
                                <td>
                                    <span class="badge <?= ($mc['Status'] ?? 'Aktif') === 'Aktif' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= htmlspecialchars($mc['Status'] ?? 'Aktif') ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/Kepegawaian/mastercuti/edit/<?= $mc['ID_Master_Cuti'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/Kepegawaian/mastercuti/delete/<?= $mc['ID_Master_Cuti'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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

