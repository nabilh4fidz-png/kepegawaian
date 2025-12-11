<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../helpers/Auth.php';
require_once __DIR__ . '/../models/slipgaji.php';
require_once __DIR__ . '/../models/karyawan.php';

class SlipGajiController extends Controller {
    
    public function index() {
        Auth::requireAuth();
        $user = Auth::user();
        
        $slipGajiModel = new SlipGaji();
        
        if ($user['role'] === 'Karyawan') {
            $slipGajis = $slipGajiModel->getByKaryawan($user['karyawan_id']);
        } else {
            // HRD melihat semua
            Auth::requireRole('HRD');
            $slipGajis = $slipGajiModel->getAllWithDetails();
        }
        
        $this->view('slipgaji/index', [
            'slipGajis' => $slipGajis,
            'user' => $user
        ]);
    }
    
    public function create() {
        Auth::requireRole('HRD');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ID_Karyawan' => $this->input('ID_Karyawan'),
                'Bulan' => $this->input('Bulan'),
                'Tahun' => $this->input('Tahun'),
                'Tanggal_Dibuat' => $this->input('Tanggal_Dibuat'),
                'Gaji_Pokok' => $this->input('Gaji_Pokok', 0),
                'Tunjangan_Transportasi' => $this->input('Tunjangan_Transportasi', 0),
                'Tunjangan_Kesehatan' => $this->input('Tunjangan_Kesehatan', 0),
                'Tunjangan_Lainnya' => $this->input('Tunjangan_Lainnya', 0),
                'Potongan_Tetap' => $this->input('Potongan_Tetap', 0),
                'Potongan_Lainnya' => $this->input('Potongan_Lainnya', 0)
            ];
            
            $slipGajiModel = new SlipGaji();
            $totals = $slipGajiModel->calculateTotal($data);
            
            $data = array_merge($data, $totals);
            
            $slipGajiModel->create($data);
            
            $this->redirect('/Kepegawaian/slipgaji');
        }
        
        $karyawanModel = new Karyawan();
        $karyawans = $karyawanModel->getAllWithDepartment();
        
        $this->view('slipgaji/create', [
            'karyawans' => $karyawans,
            'user' => Auth::user()
        ]);
    }
    
    public function edit($id) {
        Auth::requireRole('HRD');
        
        $slipGajiModel = new SlipGaji();
        $slipGaji = $slipGajiModel->findWithDetails($id);
        
        if (!$slipGaji) {
            $this->redirect('/Kepegawaian/slipgaji');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ID_Karyawan' => $this->input('ID_Karyawan'),
                'Bulan' => $this->input('Bulan'),
                'Tahun' => $this->input('Tahun'),
                'Tanggal_Dibuat' => $this->input('Tanggal_Dibuat'),
                'Gaji_Pokok' => $this->input('Gaji_Pokok', 0),
                'Tunjangan_Transportasi' => $this->input('Tunjangan_Transportasi', 0),
                'Tunjangan_Kesehatan' => $this->input('Tunjangan_Kesehatan', 0),
                'Tunjangan_Lainnya' => $this->input('Tunjangan_Lainnya', 0),
                'Potongan_Tetap' => $this->input('Potongan_Tetap', 0),
                'Potongan_Lainnya' => $this->input('Potongan_Lainnya', 0)
            ];
            
            $totals = $slipGajiModel->calculateTotal($data);
            $data = array_merge($data, $totals);
            
            $slipGajiModel->update($id, $data);
            
            $this->redirect('/Kepegawaian/slipgaji');
        }
        
        $karyawanModel = new Karyawan();
        $karyawans = $karyawanModel->getAllWithDepartment();
        
        $this->view('slipgaji/edit', [
            'slipGaji' => $slipGaji,
            'karyawans' => $karyawans,
            'user' => Auth::user()
        ]);
    }
    
    public function delete($id) {
        Auth::requireRole('HRD');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slipGajiModel = new SlipGaji();
            $slipGajiModel->delete($id);
            
            $this->redirect('/Kepegawaian/slipgaji');
        }
        
        $slipGajiModel = new SlipGaji();
        $slipGaji = $slipGajiModel->findWithDetails($id);
        
        $this->view('slipgaji/delete', [
            'slipGaji' => $slipGaji,
            'user' => Auth::user()
        ]);
    }
    
    public function show($id) {
        Auth::requireAuth();
        
        $slipGajiModel = new SlipGaji();
        $slipGaji = $slipGajiModel->findWithDetails($id);
        
        if (!$slipGaji) {
            $this->redirect('/Kepegawaian/slipgaji');
        }
        
        $user = Auth::user();
        
        // Karyawan hanya bisa melihat slip gaji mereka sendiri
        if ($user['role'] === 'Karyawan' && $slipGaji['ID_Karyawan'] != $user['karyawan_id']) {
            $this->redirect('/Kepegawaian/slipgaji');
        }
        
        $this->view('slipgaji/show', [
            'slipGaji' => $slipGaji,
            'user' => $user
        ]);
    }
}

