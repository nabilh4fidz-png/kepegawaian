<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../helpers/Auth.php';
require_once __DIR__ . '/../models/mastercuti.php';

class MasterCutiController extends Controller {
    
    public function index() {
        Auth::requireRole('HRD');
        
        $masterCutiModel = new MasterCuti();
        $masterCutis = $masterCutiModel->getAllActive();
        
        $this->view('mastercuti/index', [
            'masterCutis' => $masterCutis,
            'user' => Auth::user()
        ]);
    }
    
    public function create() {
        Auth::requireRole('HRD');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Nama_Cuti' => $this->input('Nama_Cuti'),
                'Tipe_Cuti' => $this->input('Tipe_Cuti'),
                'Jumlah_Hari' => $this->input('Jumlah_Hari', 0),
                'Keterangan' => $this->input('Keterangan'),
                'Status' => $this->input('Status', 'Aktif')
            ];
            
            $masterCutiModel = new MasterCuti();
            $masterCutiModel->create($data);
            
            $this->redirect('/Kepegawaian/mastercuti');
        }
        
        $this->view('mastercuti/create', ['user' => Auth::user()]);
    }
    
    public function edit($id) {
        Auth::requireRole('HRD');
        
        $masterCutiModel = new MasterCuti();
        $masterCuti = $masterCutiModel->find($id);
        
        if (!$masterCuti) {
            $this->redirect('/Kepegawaian/mastercuti');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Nama_Cuti' => $this->input('Nama_Cuti'),
                'Tipe_Cuti' => $this->input('Tipe_Cuti'),
                'Jumlah_Hari' => $this->input('Jumlah_Hari', 0),
                'Keterangan' => $this->input('Keterangan'),
                'Status' => $this->input('Status', 'Aktif')
            ];
            
            $masterCutiModel->update($id, $data);
            
            $this->redirect('/Kepegawaian/mastercuti');
        }
        
        $this->view('mastercuti/edit', [
            'masterCuti' => $masterCuti,
            'user' => Auth::user()
        ]);
    }
    
    public function delete($id) {
        Auth::requireRole('HRD');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $masterCutiModel = new MasterCuti();
            $masterCutiModel->delete($id);
            
            $this->redirect('/Kepegawaian/mastercuti');
        }
        
        $masterCutiModel = new MasterCuti();
        $masterCuti = $masterCutiModel->find($id);
        
        $this->view('mastercuti/delete', [
            'masterCuti' => $masterCuti,
            'user' => Auth::user()
        ]);
    }
}

