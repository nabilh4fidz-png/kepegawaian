<?php
$title = 'Data Departemen';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Halaman Departemen</h3>
    <a href="/Kepegawaian/department/create" class="btn btn-primary">Tambah Departemen</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jabatan</th>
                        <th>Jumlah Karyawan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($departments)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data departemen</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($departments as $dept): ?>
                            <tr>
                                <td><?= htmlspecialchars($dept['ID_Departemen']) ?></td>
                                <td><?= htmlspecialchars($dept['Jabatan']) ?></td>
                                <td><?= htmlspecialchars($dept['Jumlah_Karyawan']) ?></td>
                                <td>
                                    <a href="/Kepegawaian/department/edit/<?= $dept['ID_Departemen'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/Kepegawaian/department/delete/<?= $dept['ID_Departemen'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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

