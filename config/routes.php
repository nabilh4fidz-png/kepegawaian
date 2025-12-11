<?php

return [
    'GET' => [
        '/' => ['AuthController', 'login'],
        '/login' => ['AuthController', 'login'],
        '/logout' => ['AuthController', 'logout'],
        '/dashboard' => ['AuthController', 'dashboard'],
        '/dashboard/hrd' => ['AuthController', 'hrdDashboard'],
        '/dashboard/supervisor' => ['AuthController', 'supervisorDashboard'],
        '/dashboard/karyawan' => ['AuthController', 'karyawanDashboard'],
        
        // Department routes
        '/department' => ['DepartmentController', 'index'],
        '/department/create' => ['DepartmentController', 'create'],
        '/department/edit/{id}' => ['DepartmentController', 'edit'],
        '/department/delete/{id}' => ['DepartmentController', 'delete'],
        
        // Karyawan routes
        '/karyawan' => ['KaryawanController', 'index'],
        '/karyawan/create' => ['KaryawanController', 'create'],
        '/karyawan/edit/{id}' => ['KaryawanController', 'edit'],
        '/karyawan/delete/{id}' => ['KaryawanController', 'delete'],
        '/karyawan/show/{id}' => ['KaryawanController', 'show'],
        
        // Master Cuti routes
        '/mastercuti' => ['MasterCutiController', 'index'],
        '/mastercuti/create' => ['MasterCutiController', 'create'],
        '/mastercuti/edit/{id}' => ['MasterCutiController', 'edit'],
        '/mastercuti/delete/{id}' => ['MasterCutiController', 'delete'],
        
        // Pengajuan Cuti routes
        '/pengajuancuti' => ['PengajuanCutiController', 'index'],
        '/pengajuancuti/create' => ['PengajuanCutiController', 'create'],
        '/pengajuancuti/edit/{id}' => ['PengajuanCutiController', 'edit'],
        '/pengajuancuti/delete/{id}' => ['PengajuanCutiController', 'delete'],
        '/pengajuancuti/approve/{id}' => ['PengajuanCutiController', 'approve'],
        '/pengajuancuti/reject/{id}' => ['PengajuanCutiController', 'reject'],
        
        // Slip Gaji routes
        '/slipgaji' => ['SlipGajiController', 'index'],
        '/slipgaji/create' => ['SlipGajiController', 'create'],
        '/slipgaji/edit/{id}' => ['SlipGajiController', 'edit'],
        '/slipgaji/delete/{id}' => ['SlipGajiController', 'delete'],
        '/slipgaji/show/{id}' => ['SlipGajiController', 'show'],
    ],
    'POST' => [
        '/login' => ['AuthController', 'login'],
        '/logout' => ['AuthController', 'logout'],
        
        // Department routes
        '/department/create' => ['DepartmentController', 'create'],
        '/department/edit/{id}' => ['DepartmentController', 'edit'],
        '/department/delete/{id}' => ['DepartmentController', 'delete'],
        
        // Karyawan routes
        '/karyawan/create' => ['KaryawanController', 'create'],
        '/karyawan/edit/{id}' => ['KaryawanController', 'edit'],
        '/karyawan/delete/{id}' => ['KaryawanController', 'delete'],
        
        // Master Cuti routes
        '/mastercuti/create' => ['MasterCutiController', 'create'],
        '/mastercuti/edit/{id}' => ['MasterCutiController', 'edit'],
        '/mastercuti/delete/{id}' => ['MasterCutiController', 'delete'],
        
        // Pengajuan Cuti routes
        '/pengajuancuti/create' => ['PengajuanCutiController', 'create'],
        '/pengajuancuti/edit/{id}' => ['PengajuanCutiController', 'edit'],
        '/pengajuancuti/delete/{id}' => ['PengajuanCutiController', 'delete'],
        
        // Slip Gaji routes
        '/slipgaji/create' => ['SlipGajiController', 'create'],
        '/slipgaji/edit/{id}' => ['SlipGajiController', 'edit'],
        '/slipgaji/delete/{id}' => ['SlipGajiController', 'delete'],
    ]
];

