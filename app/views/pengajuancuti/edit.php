<?php
$title = 'Edit Pengajuan Cuti';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4>Halaman Edit Pengajuan Cuti</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/Kepegawaian/pengajuancuti/edit/<?= $pengajuan['ID_Cuti'] ?>">
                    <?php if ($user['role'] === 'HRD'): ?>
                        <div class="mb-3">
                            <label for="ID_Karyawan" class="form-label">Karyawan <span class="text-danger">*</span></label>
                            <select class="form-control" id="ID_Karyawan" name="ID_Karyawan" required>
                                <option value="">Pilih Karyawan</option>
                                <?php foreach ($karyawans as $k): ?>
                                    <option value="<?= $k['ID_Karyawan'] ?>" 
                                        <?= $pengajuan['ID_Karyawan'] == $k['ID_Karyawan'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['Nama_Lengkap']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Status_Pengajuan" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="Status_Pengajuan" name="Status_Pengajuan" required>
                                <option value="Pending" <?= $pengajuan['Status_Pengajuan'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Disetujui" <?= $pengajuan['Status_Pengajuan'] === 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="Ditolak" <?= $pengajuan['Status_Pengajuan'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="ID_Master_Cuti" class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                        <select class="form-control" id="ID_Master_Cuti" name="ID_Master_Cuti" required>
                            <option value="">Pilih Jenis Cuti</option>
                            <?php foreach ($masterCutis as $mc): ?>
                                <option value="<?= $mc['ID_Master_Cuti'] ?>" 
                                    <?= $pengajuan['ID_Master_Cuti'] == $mc['ID_Master_Cuti'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($mc['Nama_Cuti']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Tgl_Mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="Tgl_Mulai" name="Tgl_Mulai" 
                                       value="<?= !empty($pengajuan['Tgl_Awal']) ? date('Y-m-d', strtotime($pengajuan['Tgl_Awal'])) : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Tgl_Selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="Tgl_Selesai" name="Tgl_Selesai" 
                                       value="<?= !empty($pengajuan['Tgl_Akhir']) ? date('Y-m-d', strtotime($pengajuan['Tgl_Akhir'])) : '' ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="Keterangan" name="Keterangan" rows="3"><?= htmlspecialchars($pengajuan['Keterangan'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/Kepegawaian/pengajuancuti" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Edit</button>
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

