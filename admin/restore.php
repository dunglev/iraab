<?php
session_start();

// Kiểm tra quyền đăng nhập
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$adminPassword = $_POST['admin_password'] ?? '';
$username = $_SESSION['username'] ?? '';

if (empty($adminPassword)) {
    header("Location: index.php?err=" . urlencode("Vui lòng nhập mật khẩu xác nhận để thực hiện restore!"));
    exit;
}

// 1. Xác thực lại mật khẩu Admin (Khớp với bảng 'users' trong CSDL của bạn)
try {
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($adminPassword, $admin['password'])) {
        header("Location: index.php?err=" . urlencode("Mật khẩu xác nhận không chính xác!"));
        exit;
    }
} catch (Exception $e) {
    header("Location: index.php?err=" . urlencode("Lỗi xác thực tài khoản: " . $e->getMessage()));
    exit;
}

// 2. Kiểm tra file upload
if (!isset($_FILES['backup_file']) || $_FILES['backup_file']['error'] !== UPLOAD_ERR_OK) {
    header("Location: index.php?err=" . urlencode("Vui lòng chọn file backup hợp lệ!"));
    exit;
}

$fileTmpPath = $_FILES['backup_file']['tmp_name'];
$fileName = $_FILES['backup_file']['name'];
$fileSize = $_FILES['backup_file']['size'];

if ($fileSize > 20 * 1024 * 1024) {
    header("Location: index.php?err=" . urlencode("File quá lớn! Dung lượng tối đa là 20MB."));
    exit;
}

if (strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) !== 'sql') {
    header("Location: index.php?err=" . urlencode("Chỉ chấp nhận file định dạng .sql!"));
    exit;
}

try {
    $sqlContent = file_get_contents($fileTmpPath);
    
    // 3. Bảo mật: Chặn từ khóa độc hại
    $dangerousKeywords = ['INTO OUTFILE', 'INTO DUMPFILE', 'LOAD_FILE', 'DROP DATABASE', 'SHUTDOWN', 'GRANT', 'REVOKE'];
    foreach ($dangerousKeywords as $keyword) {
        if (stripos($sqlContent, $keyword) !== false) {
            if (file_exists($fileTmpPath)) @unlink($fileTmpPath);
            header("Location: index.php?err=" . urlencode("Phát hiện từ khóa nguy hiểm ($keyword). Từ chối thực thi!"));
            exit;
        }
    }

    $pdo->exec("SET NAMES 'utf8mb4'");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");

    // 4. Chuẩn hóa xuống dòng Windows (\r\n -> \n) để tránh lỗi đúp dòng
    $sqlContent = str_replace(["\r\n", "\r"], "\n", $sqlContent);
    $lines = explode("\n", $sqlContent);
    
    $query = '';
    foreach ($lines as $line) {
        $trimmedLine = trim($line);
        
        // Bỏ qua dòng trống hoặc câu lệnh ghi chú (comment)
        if ($trimmedLine === '' || strpos($trimmedLine, '--') === 0 || strpos($trimmedLine, '/*') === 0 || strpos($trimmedLine, '#') === 0) {
            continue;
        }
        
        $query .= $line . "\n";
        
        // Thực thi khi gặp dấu chấm phẩy ở cuối câu
        if (substr(rtrim($trimmedLine), -1) === ';') {
            $pdo->exec($query);
            $query = ''; // Reset câu lệnh cho vòng lặp tiếp theo
        }
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
    
    if (file_exists($fileTmpPath)) @unlink($fileTmpPath);
    
    header("Location: index.php?msg=restore_success");
    exit;

} catch (Exception $e) {
    if (isset($pdo)) {
        try { $pdo->exec("SET FOREIGN_KEY_CHECKS=1;"); } catch (Exception $ex) {}
    }
    if (file_exists($fileTmpPath)) @unlink($fileTmpPath);
    
    header("Location: index.php?err=" . urlencode("Lỗi khôi phục cơ sở dữ liệu: " . $e->getMessage()));
    exit;
}
?>