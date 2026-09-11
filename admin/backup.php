<?php
session_start();

// Kiểm tra quyền đăng nhập bắt buộc
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

try {
    $pdo->exec("SET NAMES 'utf8mb4'");
    
    $sqlContent = "-- IRAAB Full Database Backup\n";
    $sqlContent .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
    $sqlContent .= "SET FOREIGN_KEY_CHECKS=0;\n";
    $sqlContent .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n\n";
    
    // Lấy danh sách tất cả các bảng trong database
    $stmtTables = $pdo->query("SHOW TABLES");
    $tables = $stmtTables->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        // Lấy cấu trúc bảng (CREATE TABLE)
        $stmtCreate = $pdo->query("SHOW CREATE TABLE `$table`");
        $rowCreate = $stmtCreate->fetch(PDO::FETCH_NUM);
        
        $sqlContent .= "-- --------------------------------------------------------\n\n";
        $sqlContent .= "-- Cấu trúc bảng cho `$table`\n\n";
        $sqlContent .= "DROP TABLE IF EXISTS `$table`;\n";
        $sqlContent .= $rowCreate[1] . ";\n\n";
        
        // Lấy dữ liệu của bảng
        $stmtData = $pdo->query("SELECT * FROM `$table`");
        $rows = $stmtData->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) > 0) {
            $sqlContent .= "-- Dữ liệu cho bảng `$table`\n\n";
            
            foreach ($rows as $row) {
                $fields = array_keys($row);
                $values = array_values($row);
                
                $escapedValues = array_map(function($val) use ($pdo) {
                    if ($val === null) return "NULL";
                    return $pdo->quote($val);
                }, $values);
                
                $sqlContent .= "INSERT INTO `$table` (`" . implode("`, `", $fields) . "`) VALUES (" . implode(", ", $escapedValues) . ");\n";
            }
            $sqlContent .= "\n";
        }
    }
    
    $sqlContent .= "SET FOREIGN_KEY_CHECKS=1;\n";
    
    $filename = "full_database_backup_" . date('Y-m-d_H-i-s') . ".sql";
    header('Content-Type: application/sql; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo $sqlContent;
    exit;

} catch (Exception $e) {
    die("Lỗi backup toàn bộ database: " . $e->getMessage());
}
?>