<?php
$title = 'Tambah Departemen';
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Halaman Tambah Departemen</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/Kepegawaian/department/create">
                    <div class="mb-3">
                        <label for="Jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="Jabatan" name="Jabatan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="Keterangan" name="Keterangan" rows="3"></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/Kepegawaian/department" class="btn btn-secondary">Kembali</a>
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

