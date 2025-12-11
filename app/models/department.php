<?php

require_once __DIR__ . '/../../core/Model.php';

class Department extends Model {
    protected $table = 'departemen';
    protected $primaryKey = 'ID_Departemen';
    
    public function getAllWithCount() {
        $db = Database::getInstance();
        $sql = "SELECT d.*, COUNT(k.ID_Karyawan) as Jumlah_Karyawan 
                FROM departemen d 
                LEFT JOIN karyawan k ON d.ID_Departemen = k.ID_Departemen 
                GROUP BY d.ID_Departemen 
                ORDER BY d.ID_Departemen";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function updateJumlahKaryawan($id) {
        $db = Database::getInstance();
        $sql = "UPDATE departemen SET Jumlah_Karyawan = (
                    SELECT COUNT(*) FROM karyawan WHERE ID_Departemen = :id1
                ) WHERE ID_Departemen = :id2";
        return $db->query($sql, ['id1' => $id, 'id2' => $id]);
    }
}


