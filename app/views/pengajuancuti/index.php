<?php
$title = 'Pengajuan Cuti';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Halaman Pengajuan Cuti</h3>
    <?php if ($user['role'] === 'HRD' || $user['role'] === 'Karyawan'): ?>
        <a href="/Kepegawaian/pengajuancuti/create" class="btn btn-primary">Tambah Pengajuan Cuti</a>
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
                        <th>Nama Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Jumlah Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengajuans)): ?>
                        <tr>
                            <td colspan="<?= $user['role'] === 'HRD' ? '8' : '7' ?>" class="text-center">Tidak ada data pengajuan cuti</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pengajuans as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['ID_Cuti']) ?></td>
                                <?php if ($user['role'] === 'HRD'): ?>
                                    <td><?= htmlspecialchars($p['Nama_Lengkap']) ?></td>
                                <?php endif; ?>
                                <td><?= htmlspecialchars($p['Nama_Cuti']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['Tgl_Awal'] ?? '2000-01-01')) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['Tgl_Akhir'] ?? '2000-01-01')) ?></td>
                                <td><?= htmlspecialchars($p['Jumlah_Hari']) ?> hari</td>
                                <td>
                                    <?php
                                    $badgeClass = 'secondary';
                                    if ($p['Status_Pengajuan'] === 'Disetujui') $badgeClass = 'success';
                                    if ($p['Status_Pengajuan'] === 'Ditolak') $badgeClass = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= htmlspecialchars($p['Status_Pengajuan']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['role'] === 'Supervisor' && $p['Status_Pengajuan'] === 'Pending'): ?>
                                        <a href="/Kepegawaian/pengajuancuti/approve/<?= $p['ID_Cuti'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Setujui pengajuan cuti?')">Setujui</a>
                                        <a href="/Kepegawaian/pengajuancuti/reject/<?= $p['ID_Cuti'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pengajuan cuti?')">Tolak</a>
                                    <?php endif; ?>
                                    
                                    <?php if (($user['role'] === 'HRD' || ($user['role'] === 'Karyawan' && $p['Status_Pengajuan'] === 'Pending'))): ?>
                                        <a href="/Kepegawaian/pengajuancuti/edit/<?= $p['ID_Cuti'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <?php endif; ?>
                                    
                                    <?php if ($user['role'] === 'HRD'): ?>
                                        <a href="/Kepegawaian/pengajuancuti/delete/<?= $p['ID_Cuti'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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

