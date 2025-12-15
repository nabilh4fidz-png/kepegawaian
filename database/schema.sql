-- =====================================================
-- SISTEM MANAJEMEN KEPEGAWAIAN - DATABASE SCHEMA
-- =====================================================

-- Tabel Departemen
CREATE TABLE IF NOT EXISTS `departemen` (
    `ID_Departemen` INT PRIMARY KEY AUTO_INCREMENT,
    `Jabatan` VARCHAR(100) NOT NULL UNIQUE,
    `Keterangan` TEXT,
    `Jumlah_Karyawan` INT DEFAULT 0,
    `Tgl_Berdiri` DATE,
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Karyawan
CREATE TABLE IF NOT EXISTS `karyawan` (
    `ID_Karyawan` INT PRIMARY KEY AUTO_INCREMENT,
    `ID_Departemen` INT NOT NULL,
    `Nama_Lengkap` VARCHAR(150) NOT NULL,
    `Tgl_Lahir` DATE NOT NULL,
    `Tgl_Masuk` DATE NOT NULL,
    `Email_Kantor` VARCHAR(100) UNIQUE NOT NULL,
    `Alamat` TEXT NOT NULL,
    `Status_Kerja` ENUM('Aktif', 'Cuti', 'Non-Aktif') DEFAULT 'Aktif',
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`ID_Departemen`) REFERENCES `departemen`(`ID_Departemen`) ON DELETE RESTRICT,
    INDEX `idx_departemen` (`ID_Departemen`),
    INDEX `idx_email` (`Email_Kantor`),
    INDEX `idx_status` (`Status_Kerja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel User (Login)
CREATE TABLE IF NOT EXISTS `user` (
    `ID_User` INT PRIMARY KEY AUTO_INCREMENT,
    `ID_Karyawan` INT,
    `Username` VARCHAR(50) UNIQUE NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `Role` ENUM('HRD', 'Supervisor', 'Karyawan') DEFAULT 'Karyawan',
    `Status_Login` ENUM('Aktif', 'Non-Aktif') DEFAULT 'Aktif',
    `Last_Login` DATETIME,
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`ID_Karyawan`) REFERENCES `karyawan`(`ID_Karyawan`) ON DELETE SET NULL,
    INDEX `idx_username` (`Username`),
    INDEX `idx_role` (`Role`),
    UNIQUE KEY `unique_karyawan_user` (`ID_Karyawan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Master Cuti
CREATE TABLE IF NOT EXISTS `master_cuti` (
    `ID_Master_Cuti` INT PRIMARY KEY AUTO_INCREMENT,
    `Nama_Cuti` VARCHAR(100) NOT NULL,
    `Tipe_Cuti` VARCHAR(50) NOT NULL,
    `Jumlah_Hari` INT NOT NULL,
    `Keterangan` TEXT,
    `Status` ENUM('Aktif', 'Non-Aktif') DEFAULT 'Aktif',
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Libur Nasional
CREATE TABLE IF NOT EXISTS `libur_nasional` (
    `ID_Libur` INT PRIMARY KEY AUTO_INCREMENT,
    `Nama_Libur` VARCHAR(100) NOT NULL,
    `Tanggal_Libur` DATE NOT NULL UNIQUE,
    `Keterangan` TEXT,
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_tanggal` (`Tanggal_Libur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pengajuan Cuti
CREATE TABLE IF NOT EXISTS `pengajuan_cuti` (
    `ID_Cuti` INT PRIMARY KEY AUTO_INCREMENT,
    `ID_Karyawan` INT NOT NULL,
    `ID_Master_Cuti` INT NOT NULL,
    `Tgl_Awal` DATE NOT NULL,
    `Tgl_Akhir` DATE NOT NULL,
    `Jumlah_Hari` INT NOT NULL,
    `Alasan` TEXT,
    `Status_Pengajuan` ENUM('Pending', 'Disetujui', 'Ditolak') DEFAULT 'Pending',
    `Keterangan_Penolakan` TEXT,
    `Tgl_Pengajuan` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tgl_Persetujuan` DATETIME,
    `Approved_By` INT,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`ID_Karyawan`) REFERENCES `karyawan`(`ID_Karyawan`) ON DELETE CASCADE,
    FOREIGN KEY (`ID_Master_Cuti`) REFERENCES `master_cuti`(`ID_Master_Cuti`) ON DELETE RESTRICT,
    FOREIGN KEY (`Approved_By`) REFERENCES `karyawan`(`ID_Karyawan`) ON DELETE SET NULL,
    INDEX `idx_karyawan` (`ID_Karyawan`),
    INDEX `idx_status` (`Status_Pengajuan`),
    INDEX `idx_tanggal` (`Tgl_Awal`, `Tgl_Akhir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Master Gaji
CREATE TABLE IF NOT EXISTS `master_gaji` (
    `ID_Gaji_Config` INT PRIMARY KEY AUTO_INCREMENT,
    `ID_Departemen` INT NOT NULL,
    `Gaji_Pokok` DECIMAL(15,2) NOT NULL,
    `Tunjangan_Transportasi` DECIMAL(15,2) DEFAULT 0,
    `Tunjangan_Kesehatan` DECIMAL(15,2) DEFAULT 0,
    `Tunjangan_Lainnya` DECIMAL(15,2) DEFAULT 0,
    `Potongan_Tetap` DECIMAL(15,2) DEFAULT 0,
    `Keterangan` TEXT,
    `Status` ENUM('Aktif', 'Non-Aktif') DEFAULT 'Aktif',
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`ID_Departemen`) REFERENCES `departemen`(`ID_Departemen`) ON DELETE RESTRICT,
    INDEX `idx_departemen` (`ID_Departemen`),
    INDEX `idx_status` (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Slip Gaji
CREATE TABLE IF NOT EXISTS `slip_gaji` (
    `ID_Slip` INT PRIMARY KEY AUTO_INCREMENT,
    `ID_Karyawan` INT NOT NULL,
    `Bulan` INT NOT NULL,
    `Tahun` INT NOT NULL,
    `Gaji_Pokok` DECIMAL(15,2) NOT NULL,
    `Tunjangan_Transportasi` DECIMAL(15,2) DEFAULT 0,
    `Tunjangan_Kesehatan` DECIMAL(15,2) DEFAULT 0,
    `Tunjangan_Lainnya` DECIMAL(15,2) DEFAULT 0,
    `Potongan_Tetap` DECIMAL(15,2) DEFAULT 0,
    `Potongan_Lainnya` DECIMAL(15,2) DEFAULT 0,
    `Total_Penerimaan` DECIMAL(15,2) NOT NULL,
    `Total_Potongan` DECIMAL(15,2) NOT NULL,
    `Gaji_Bersih` DECIMAL(15,2) NOT NULL,
    `Keterangan` TEXT,
    `Tanggal_Dibuat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Tanggal_Diupdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`ID_Karyawan`) REFERENCES `karyawan`(`ID_Karyawan`) ON DELETE CASCADE,
    UNIQUE KEY `unique_slip` (`ID_Karyawan`, `Bulan`, `Tahun`),
    INDEX `idx_karyawan` (`ID_Karyawan`),
    INDEX `idx_periode` (`Bulan`, `Tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATA DUMMY
-- =====================================================

-- Insert Departemen
INSERT INTO `departemen` (`Jabatan`, `Keterangan`, `Jumlah_Karyawan`) VALUES
('Backend Developer', 'Tim pengembangan backend aplikasi', 3),
('Frontend Developer', 'Tim pengembangan frontend dan UI/UX', 3),
('Database Administrator', 'Tim pengelolaan database dan server', 2),
('Project Manager', 'Tim manajemen proyek', 2),
('Quality Assurance', 'Tim testing dan quality control', 2),
('Human Resources', 'Tim sumber daya manusia', 1);

-- Insert Karyawan
INSERT INTO `karyawan` (`ID_Departemen`, `Nama_Lengkap`, `Tgl_Lahir`, `Tgl_Masuk`, `Email_Kantor`, `Alamat`, `Status_Kerja`) VALUES
(1, 'Budi Santoso', '1990-05-15', '2020-01-10', 'budi.santoso@company.com', 'Jl. Merdeka No. 123, Jakarta', 'Aktif'),
(1, 'Rina Kusuma', '1992-08-22', '2021-03-15', 'rina.kusuma@company.com', 'Jl. Sudirman No. 456, Jakarta', 'Aktif'),
(1, 'Agus Wijaya', '1989-12-03', '2019-06-20', 'agus.wijaya@company.com', 'Jl. Ahmad Yani No. 789, Bandung', 'Aktif'),
(2, 'Siti Nurhaliza', '1994-02-14', '2021-09-01', 'siti.nurhaliza@company.com', 'Jl. Gatot Subroto No. 234, Jakarta', 'Aktif'),
(2, 'Hendra Gunawan', '1991-07-08', '2020-11-15', 'hendra.gunawan@company.com', 'Jl. Diponegoro No. 567, Bekasi', 'Aktif'),
(2, 'Lisa Wijaya', '1995-04-19', '2022-02-01', 'lisa.wijaya@company.com', 'Jl. Hayam Wuruk No. 890, Jakarta', 'Aktif'),
(3, 'Bambang Irawan', '1988-11-25', '2018-08-10', 'bambang.irawan@company.com', 'Jl. Thamrin No. 112, Jakarta', 'Aktif'),
(3, 'Dewi Lestari', '1993-06-30', '2021-05-12', 'dewi.lestari@company.com', 'Jl. Fatmawati No. 334, Jakarta', 'Aktif'),
(4, 'Cahyo Setiawan', '1987-09-12', '2019-01-15', 'cahyo.setiawan@company.com', 'Jl. Menteng No. 556, Jakarta', 'Aktif'),
(4, 'Putri Handayani', '1993-10-05', '2022-03-20', 'putri.handayani@company.com', 'Jl. Blok M No. 778, Jakarta', 'Aktif'),
(5, 'Yudha Pratama', '1990-03-17', '2020-07-08', 'yudha.pratama@company.com', 'Jl. Kebon Sirih No. 901, Jakarta', 'Aktif'),
(5, 'Maya Kusuma', '1994-12-22', '2021-10-25', 'maya.kusuma@company.com', 'Jl. Raden Saleh No. 123, Jakarta', 'Aktif'),
(6, 'Siska Handoko', '1992-01-11', '2020-02-17', 'siska.handoko@company.com', 'Jl. Sahari No. 245, Jakarta', 'Aktif');

-- Insert User (Login)
-- Password: semua password di-hash menggunakan password_hash('password123')
INSERT INTO `user` (`ID_Karyawan`, `Username`, `Password`, `Role`, `Status_Login`) VALUES
(1, 'budi_santoso', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'HRD', 'Aktif'),
(2, 'rina_kusuma', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Supervisor', 'Aktif'),
(3, 'agus_wijaya', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Karyawan', 'Aktif'),
(4, 'siti_nurhaliza', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Supervisor', 'Aktif'),
(5, 'hendra_gunawan', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Karyawan', 'Aktif'),
(6, 'lisa_wijaya', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Karyawan', 'Aktif'),
(7, 'bambang_irawan', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Supervisor', 'Aktif'),
(8, 'dewi_lestari', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Karyawan', 'Aktif'),
(9, 'cahyo_setiawan', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Supervisor', 'Aktif'),
(10, 'putri_handayani', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Karyawan', 'Aktif'),
(11, 'yudha_pratama', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Supervisor', 'Aktif'),
(12, 'maya_kusuma', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'Karyawan', 'Aktif'),
(13, 'siska_handoko', '$2y$10$N9qo8uLOickgx2ZMRZoHyuA8r8xM8P8vK9P8u9YvQxKw5sZ8Zq4R6', 'HRD', 'Aktif');

-- Insert Master Cuti
INSERT INTO `master_cuti` (`Nama_Cuti`, `Tipe_Cuti`, `Jumlah_Hari`, `Keterangan`, `Status`) VALUES
('Cuti Tahunan', 'Cuti Reguler', 12, 'Cuti tahunan yang diberikan setiap tahun', 'Aktif'),
('Cuti Sakit', 'Cuti Kesehatan', 999, 'Cuti untuk keperluan kesehatan dengan surat dokter', 'Aktif'),
('Cuti Khusus', 'Cuti Keperluan', 3, 'Cuti untuk keperluan mendesak keluarga', 'Aktif'),
('Cuti Haji', 'Cuti Keagamaan', 40, 'Cuti untuk menunaikan ibadah haji', 'Aktif'),
('Cuti Liburan Bersama', 'Cuti Libur', 5, 'Cuti liburan bersama yang ditetapkan perusahaan', 'Aktif'),
('Cuti Melahirkan', 'Cuti Khusus', 90, 'Cuti melahirkan untuk karyawan wanita', 'Aktif');

-- Insert Libur Nasional
INSERT INTO `libur_nasional` (`Nama_Libur`, `Tanggal_Libur`, `Keterangan`) VALUES
('Tahun Baru', '2025-01-01', 'Hari Tahun Baru Masehi'),
('Hari Kemerdekaan', '2025-08-17', 'Hari Kemerdekaan Indonesia'),
('Hari Raya Idul Fitri', '2025-04-10', 'Hari Raya Idul Fitri'),
('Hari Raya Idul Adha', '2025-06-07', 'Hari Raya Idul Adha'),
('Tahun Baru Imlek', '2025-01-29', 'Tahun Baru Imlek'),
('Hari Raya Nyepi', '2025-03-29', 'Hari Raya Nyepi'),
('Hari Kenaikan Isa', '2025-05-29', 'Hari Kenaikan Isa Almasih'),
('Natal', '2025-12-25', 'Hari Natal Kristus');

-- Insert Pengajuan Cuti
INSERT INTO `pengajuan_cuti` (`ID_Karyawan`, `ID_Master_Cuti`, `Tgl_Awal`, `Tgl_Akhir`, `Jumlah_Hari`, `Alasan`, `Status_Pengajuan`, `Tgl_Persetujuan`, `Approved_By`) VALUES
(3, 1, '2025-01-20', '2025-01-24', 5, 'Liburan keluarga', 'Disetujui', '2025-01-18 10:30:00', 2),
(5, 1, '2025-02-03', '2025-02-05', 3, 'Mengurus keperluan pribadi', 'Disetujui', '2025-01-31 14:15:00', 4),
(6, 2, '2025-01-22', '2025-01-23', 2, 'Sakit demam dengan surat dokter', 'Disetujui', '2025-01-22 09:00:00', 4),
(8, 3, '2025-02-10', '2025-02-12', 3, 'Keadaan keluarga mendesak', 'Pending', NULL, NULL),
(10, 1, '2025-02-17', '2025-02-21', 5, 'Liburan dengan keluarga', 'Pending', NULL, NULL),
(12, 1, '2025-03-03', '2025-03-07', 5, 'Istirahat dan liburan', 'Disetujui', '2025-02-28 11:00:00', 11);

-- Insert Master Gaji
INSERT INTO `master_gaji` (`ID_Departemen`, `Gaji_Pokok`, `Tunjangan_Transportasi`, `Tunjangan_Kesehatan`, `Tunjangan_Lainnya`, `Potongan_Tetap`, `Keterangan`, `Status`) VALUES
(1, 6000000, 500000, 400000, 300000, 500000, 'Gaji Backend Developer', 'Aktif'),
(2, 5500000, 500000, 400000, 250000, 500000, 'Gaji Frontend Developer', 'Aktif'),
(3, 7000000, 500000, 400000, 400000, 600000, 'Gaji DBA', 'Aktif'),
(4, 8000000, 600000, 500000, 500000, 700000, 'Gaji Project Manager', 'Aktif'),
(5, 5000000, 400000, 350000, 200000, 400000, 'Gaji QA', 'Aktif'),
(6, 5500000, 400000, 350000, 250000, 450000, 'Gaji HR', 'Aktif');

-- Insert Slip Gaji
INSERT INTO `slip_gaji` (`ID_Karyawan`, `Bulan`, `Tahun`, `Gaji_Pokok`, `Tunjangan_Transportasi`, `Tunjangan_Kesehatan`, `Tunjangan_Lainnya`, `Potongan_Tetap`, `Potongan_Lainnya`, `Total_Penerimaan`, `Total_Potongan`, `Gaji_Bersih`, `Keterangan`) VALUES
(1, 1, 2025, 6000000, 500000, 400000, 300000, 500000, 100000, 7200000, 600000, 6600000, 'Slip gaji Januari 2025'),
(1, 2, 2025, 6000000, 500000, 400000, 300000, 500000, 100000, 7200000, 600000, 6600000, 'Slip gaji Februari 2025'),
(2, 1, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Januari 2025'),
(2, 2, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Februari 2025'),
(3, 1, 2025, 6000000, 500000, 400000, 300000, 500000, 100000, 7200000, 600000, 6600000, 'Slip gaji Januari 2025'),
(3, 2, 2025, 6000000, 500000, 400000, 300000, 500000, 100000, 7200000, 600000, 6600000, 'Slip gaji Februari 2025'),
(4, 1, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Januari 2025'),
(4, 2, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Februari 2025'),
(5, 1, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Januari 2025'),
(5, 2, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Februari 2025'),
(6, 1, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Januari 2025'),
(6, 2, 2025, 5500000, 500000, 400000, 250000, 500000, 0, 6650000, 500000, 6150000, 'Slip gaji Februari 2025'),
(7, 1, 2025, 7000000, 500000, 400000, 400000, 600000, 200000, 8300000, 800000, 7500000, 'Slip gaji Januari 2025'),
(7, 2, 2025, 7000000, 500000, 400000, 400000, 600000, 200000, 8300000, 800000, 7500000, 'Slip gaji Februari 2025'),
(8, 1, 2025, 7000000, 500000, 400000, 400000, 600000, 0, 8300000, 600000, 7700000, 'Slip gaji Januari 2025'),
(8, 2, 2025, 7000000, 500000, 400000, 400000, 600000, 0, 8300000, 600000, 7700000, 'Slip gaji Februari 2025'),
(9, 1, 2025, 8000000, 600000, 500000, 500000, 700000, 0, 9600000, 700000, 8900000, 'Slip gaji Januari 2025'),
(9, 2, 2025, 8000000, 600000, 500000, 500000, 700000, 0, 9600000, 700000, 8900000, 'Slip gaji Februari 2025'),
(10, 1, 2025, 8000000, 600000, 500000, 500000, 700000, 0, 9600000, 700000, 8900000, 'Slip gaji Januari 2025'),
(10, 2, 2025, 8000000, 600000, 500000, 500000, 700000, 0, 9600000, 700000, 8900000, 'Slip gaji Februari 2025'),
(11, 1, 2025, 5000000, 400000, 350000, 200000, 400000, 0, 5950000, 400000, 5550000, 'Slip gaji Januari 2025'),
(11, 2, 2025, 5000000, 400000, 350000, 200000, 400000, 0, 5950000, 400000, 5550000, 'Slip gaji Februari 2025'),
(12, 1, 2025, 5000000, 400000, 350000, 200000, 400000, 0, 5950000, 400000, 5550000, 'Slip gaji Januari 2025'),
(12, 2, 2025, 5000000, 400000, 350000, 200000, 400000, 0, 5950000, 400000, 5550000, 'Slip gaji Februari 2025'),
(13, 1, 2025, 5500000, 400000, 350000, 250000, 450000, 0, 6500000, 450000, 6050000, 'Slip gaji Januari 2025'),
(13, 2, 2025, 5500000, 400000, 350000, 250000, 450000, 0, 6500000, 450000, 6050000, 'Slip gaji Februari 2025');
