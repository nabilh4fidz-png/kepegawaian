<?php

require_once __DIR__ . '/../core/Database.php';

class Auth {
    
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function login($username, $password) {
        self::startSession();
        
        $db = Database::getInstance();
        $sql = "SELECT u.*, k.Nama_Lengkap, k.Email_Kantor, k.ID_Departemen 
                FROM user u 
                LEFT JOIN karyawan k ON u.ID_Karyawan = k.ID_Karyawan 
                WHERE u.Username = :username AND u.Status_Login = 'Aktif'";
        
        $stmt = $db->query($sql, ['username' => $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['ID_User'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['karyawan_id'] = $user['ID_Karyawan'];
            $_SESSION['nama'] = $user['Nama_Lengkap'];
            $_SESSION['email'] = $user['Email_Kantor'];
            
            return true;
        }
        
        return false;
    }
    
    public static function logout() {
        self::startSession();
        session_destroy();
    }
    
    public static function check() {
        self::startSession();
        return isset($_SESSION['user_id']);
    }
    
    public static function user() {
        self::startSession();
        if (!self::check()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'],
            'karyawan_id' => $_SESSION['karyawan_id'] ?? null,
            'nama' => $_SESSION['nama'] ?? null,
            'email' => $_SESSION['email'] ?? null
        ];
    }
    
    public static function hasRole($role) {
        $user = self::user();
        return $user && $user['role'] === $role;
    }
    
    public static function requireAuth() {
        if (!self::check()) {
            header('Location: /Kepegawaian/login');
            exit();
        }
    }
    
    public static function requireRole($roles) {
        self::requireAuth();
        
        $user = self::user();
        if (!in_array($user['role'], (array)$roles)) {
            header('Location: /Kepegawaian/dashboard');
            exit();
        }
    }
}


