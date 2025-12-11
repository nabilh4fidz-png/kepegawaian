<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../helpers/Auth.php';
require_once __DIR__ . '/../models/department.php';

class DepartmentController extends Controller {
    
    public function index() {
        Auth::requireAuth();
        $user = Auth::user();
        
        // Supervisor hanya bisa melihat, HRD bisa CRUD
        $departmentModel = new Department();
        $departments = $departmentModel->getAllWithCount();
        
        if ($user['role'] === 'Supervisor') {
            $this->view('department/index_supervisor', [
                'departments' => $departments,
                'user' => $user
            ]);
        } else {
            Auth::requireRole('HRD');
            $this->view('department/index', [
                'departments' => $departments,
                'user' => $user
            ]);
        }
    }
    
    public function create() {
        Auth::requireRole('HRD');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Jabatan' => $this->input('Jabatan'),
                'Keterangan' => $this->input('Keterangan'),
                'Jumlah_Karyawan' => 0
            ];
            
            $departmentModel = new Department();
            $departmentModel->create($data);
            
            $this->redirect('/Kepegawaian/department');
        }
        
        $this->view('department/create', ['user' => Auth::user()]);
    }
    
    public function edit($id) {
        Auth::requireRole('HRD');
        
        $departmentModel = new Department();
        $department = $departmentModel->find($id);
        
        if (!$department) {
            $this->redirect('/Kepegawaian/department');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Jabatan' => $this->input('Jabatan'),
                'Keterangan' => $this->input('Keterangan')
            ];
            
            $departmentModel->update($id, $data);
            
            $this->redirect('/Kepegawaian/department');
        }
        
        $this->view('department/edit', [
            'department' => $department,
            'user' => Auth::user()
        ]);
    }
    
    public function delete($id) {
        Auth::requireRole('HRD');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $departmentModel = new Department();
            $departmentModel->delete($id);
            
            $this->redirect('/Kepegawaian/department');
        }
        
        $departmentModel = new Department();
        $department = $departmentModel->find($id);
        
        $this->view('department/delete', [
            'department' => $department,
            'user' => Auth::user()
        ]);
    }
}


