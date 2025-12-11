<?php
/**
 * Script untuk instalasi database
 * Akses melalui browser: http://localhost/Kepegawaian/database/install.php
 */

$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'kepegawaian_baru'
];

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Instalasi Database</title>";
echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;} .container{max-width:800px;margin:0 auto;background:white;padding:20px;border-radius:5px;}</style>";
echo "</head><body><div class='container'>";

echo "<h2>Instalasi Database Sistem Manajemen Kepegawaian</h2>";

try {
    // Koneksi ke MySQL (tanpa database)
    $pdo = new PDO("mysql:host={$config['host']}", $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>✓ Koneksi ke MySQL berhasil</p>";
    
    // Buat database jika belum ada
    try {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$config['dbname']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "<p>✓ Database '{$config['dbname']}' berhasil dibuat</p>";
    } catch (PDOException $e) {
        echo "<p style='color:orange;'>⚠ Database sudah ada atau error: " . $e->getMessage() . "</p>";
    }
    
    // Koneksi ke database yang baru dibuat
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>✓ Koneksi ke database '{$config['dbname']}' berhasil</p>";
    
    // Baca file SQL
    $sqlFile = __DIR__ . '/schema.sql';
    if (!file_exists($sqlFile)) {
        die("<p style='color:red;'>File schema.sql tidak ditemukan di: {$sqlFile}</p></div></body></html>");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Hapus komentar dan baris kosong
    $sql = preg_replace('/--.*$/m', '', $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    
    // Split by semicolon, tapi skip CREATE DATABASE dan USE karena sudah dihandle
    $lines = explode("\n", $sql);
    $statements = [];
    $currentStatement = '';
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip baris kosong dan komentar
        if (empty($line) || preg_match('/^--/', $line)) {
            continue;
        }
        
        // Skip CREATE DATABASE dan USE karena sudah dihandle
        if (preg_match('/^CREATE DATABASE/i', $line) || preg_match('/^USE /i', $line)) {
            continue;
        }
        
        $currentStatement .= $line . "\n";
        
        // Jika ada semicolon, berarti statement selesai
        if (substr(rtrim($line), -1) === ';') {
            $stmt = trim($currentStatement);
            if (!empty($stmt)) {
                $statements[] = $stmt;
            }
            $currentStatement = '';
        }
    }
    
    // Tambahkan statement terakhir jika ada
    if (!empty(trim($currentStatement))) {
        $statements[] = trim($currentStatement);
    }
    
    echo "<p>✓ File schema.sql berhasil dibaca</p>";
    echo "<p>Memulai instalasi tabel dan data...</p>";
    echo "<hr>";
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $index => $statement) {
        $statement = trim($statement);
        if (empty($statement)) continue;
        
        try {
            $pdo->exec($statement);
            echo "<p style='color:green;'>✓ Query " . ($index + 1) . " berhasil dieksekusi</p>";
            $successCount++;
        } catch (PDOException $e) {
            // Skip error jika table/data sudah ada
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, 'already exists') !== false || 
                strpos($errorMsg, 'Duplicate entry') !== false) {
                echo "<p style='color:orange;'>⚠ Query " . ($index + 1) . ": " . $errorMsg . "</p>";
            } else {
                echo "<p style='color:red;'>✗ Query " . ($index + 1) . " Error: " . $errorMsg . "</p>";
                echo "<pre style='background:#f0f0f0;padding:10px;font-size:11px;'>" . htmlspecialchars(substr($statement, 0, 200)) . "...</pre>";
                $errorCount++;
            }
        }
    }
    
    echo "<hr>";
    echo "<h3 style='color:green;'>Instalasi database selesai!</h3>";
    echo "<p><strong>Statistik:</strong></p>";
    echo "<ul>";
    echo "<li>Query berhasil: {$successCount}</li>";
    if ($errorCount > 0) {
        echo "<li>Query error: {$errorCount}</li>";
    }
    echo "</ul>";
    
    echo "<p><strong>Default Login:</strong></p>";
    echo "<ul>";
    echo "<li>Username: <code>hrd</code></li>";
    echo "<li>Password: <code>admin123</code></li>";
    echo "</ul>";
    echo "<p><a href='/Kepegawaian/'>Klik di sini untuk masuk ke aplikasi</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Pastikan:</p>";
    echo "<ul>";
    echo "<li>MySQL service sudah berjalan di XAMPP</li>";
    echo "<li>Username dan password MySQL benar (cek di config/database.php)</li>";
    echo "</ul>";
}

echo "</div></body></html>";
?>
