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
        '/pengajuancuti/delete-all' => ['PengajuanCutiController', 'deleteAll'],
        '/pengajuancuti/approve/{id}' => ['PengajuanCutiController', 'approve'],
        '/pengajuancuti/reject/{id}' => ['PengajuanCutiController', 'reject'],
        '/pengajuancuti/history' => ['PengajuanCutiController', 'history'],
        
        // Slip Gaji routes
        '/slipgaji' => ['SlipGajiController', 'index'],
        '/slipgaji/create' => ['SlipGajiController', 'create'],
        '/slipgaji/edit/{id}' => ['SlipGajiController', 'edit'],
        '/slipgaji/delete/{id}' => ['SlipGajiController', 'delete'],
        '/slipgaji/show/{id}' => ['SlipGajiController', 'show'],

        // ⭐ LAPORAN ROUTES - TAMBAHAN INI YANG PENTING! ⭐
        '/laporan' => ['LaporanController', 'index'],  // <-- INI YANG KURANG DI SCREENSHOT ANDA!
        '/laporan/karyawan' => ['LaporanController', 'karyawan'],
        '/laporan/cuti' => ['LaporanController', 'cuti'],
        '/laporan/gaji' => ['LaporanController', 'gaji'],
        '/laporan/export/karyawan-csv' => ['LaporanController', 'exportKaryawanCSV'],
        '/laporan/export/cuti-csv' => ['LaporanController', 'exportCutiCSV'],
        '/laporan/print/karyawan' => ['LaporanController', 'printKaryawan'],
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