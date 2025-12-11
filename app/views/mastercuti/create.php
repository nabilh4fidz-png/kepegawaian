<?php
$title = 'Tambah Master Cuti';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Halaman Tambah Master Cuti</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/Kepegawaian/mastercuti/create">
                    <div class="mb-3">
                        <label for="Nama_Cuti" class="form-label">Nama Cuti <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="Nama_Cuti" name="Nama_Cuti" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Tipe_Cuti" class="form-label">Tipe Cuti <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="Tipe_Cuti" name="Tipe_Cuti" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Jumlah_Hari" class="form-label">Jumlah Hari <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="Jumlah_Hari" name="Jumlah_Hari" min="0" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="Keterangan" name="Keterangan" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-control" id="Status" name="Status">
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/Kepegawaian/mastercuti" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
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

