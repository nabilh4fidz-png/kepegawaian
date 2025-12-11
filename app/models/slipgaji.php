<?php

require_once __DIR__ . '/../../core/Model.php';

class SlipGaji extends Model {
    protected $table = 'slip_gaji';
    protected $primaryKey = 'ID_Slip';
    
    public function getAllWithDetails() {
        $db = Database::getInstance();
        $sql = "SELECT sg.*, k.Nama_Lengkap, k.Email_Kantor, d.Jabatan as Nama_Departemen
                FROM slip_gaji sg
                LEFT JOIN karyawan k ON sg.ID_Karyawan = k.ID_Karyawan
                LEFT JOIN departemen d ON k.ID_Departemen = d.ID_Departemen
                ORDER BY sg.Tahun DESC, sg.Bulan DESC, sg.ID_Slip DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getByKaryawan($karyawanId) {
        $db = Database::getInstance();
        $sql = "SELECT * FROM slip_gaji 
                WHERE ID_Karyawan = :karyawan_id 
                ORDER BY Tahun DESC, Bulan DESC";
        $stmt = $db->query($sql, ['karyawan_id' => $karyawanId]);
        return $stmt->fetchAll();
    }
    
    public function findWithDetails($id) {
        $db = Database::getInstance();
        $sql = "SELECT sg.*, k.Nama_Lengkap, k.Email_Kantor, d.Jabatan as Nama_Departemen
                FROM slip_gaji sg
                LEFT JOIN karyawan k ON sg.ID_Karyawan = k.ID_Karyawan
                LEFT JOIN departemen d ON k.ID_Departemen = d.ID_Departemen
                WHERE sg.ID_Slip = :id";
        $stmt = $db->query($sql, ['id' => $id]);
        return $stmt->fetch();
    }
    
    public function calculateTotal($data) {
        $gajiPokok = floatval($data['Gaji_Pokok'] ?? 0);
        $tunjanganTransportasi = floatval($data['Tunjangan_Transportasi'] ?? 0);
        $tunjanganKesehatan = floatval($data['Tunjangan_Kesehatan'] ?? 0);
        $tunjanganLainnya = floatval($data['Tunjangan_Lainnya'] ?? 0);
        $potonganTetap = floatval($data['Potongan_Tetap'] ?? 0);
        $potonganLainnya = floatval($data['Potongan_Lainnya'] ?? 0);
        
        $totalPenerimaan = $gajiPokok + $tunjanganTransportasi + $tunjanganKesehatan + $tunjanganLainnya;
        $totalPotongan = $potonganTetap + $potonganLainnya;
        $gajiBersih = $totalPenerimaan - $totalPotongan;
        
        return [
            'Total_Penerimaan' => $totalPenerimaan,
            'Total_Potongan' => $totalPotongan,
            'Gaji_Bersih' => $gajiBersih
        ];
    }
}


