<?php
session_start();

// Kiểm tra quyền đăng nhập bắt buộc
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $username = $_SESSION['username'] ?? 'admin';

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Vui lòng điền đầy đủ tất cả các trường!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Mật khẩu mới và xác nhận mật khẩu không trùng khớp!";
    } elseif (strlen($new_password) < 6) {
        $error = "Mật khẩu mới phải có ít nhất 6 ký tự!";
    } else {
        // Lấy thông tin tài khoản hiện tại từ DB
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($old_password, $user['password'])) {
            // Cập nhật mật khẩu băm mới
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$new_hash, $user['id']]);
            $success = "Đổi mật khẩu thành công!";
        } else {
            $error = "Mật khẩu hiện tại không chính xác!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi Mật Khẩu - IRAAB Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md p-6 border border-slate-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-slate-800">Đổi Mật Khẩu Admin</h1>
            <a href="index.php" class="text-xs text-blue-600 font-semibold hover:underline flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-200 text-red-700 p-3 rounded mb-4 text-sm font-semibold">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded mb-4 text-sm font-semibold">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Mật khẩu hiện tại</label>
                <input type="password" name="old_password" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Mật khẩu mới</label>
                <input type="password" name="new_password" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-700 text-white font-bold py-2.5 rounded hover:bg-blue-800 transition text-sm">
                Cập nhật mật khẩu
            </button>
        </form>
    </div>
</body>
</html>