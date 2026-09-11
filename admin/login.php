<?php
session_start();
require_once '../db.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Tài khoản hoặc mật khẩu không chính xác!";
        }
    } else {
        $error = "Vui lòng nhập đầy đủ tài khoản và mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin - IRAAB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md border border-slate-200">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Đăng Nhập Quản Trị</h1>
            <p class="text-sm text-slate-500 mt-1">Hệ thống Quản lý IRAAB</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-200 text-red-700 p-3 rounded mb-4 text-sm font-semibold">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tài khoản</label>
                <input type="text" name="username" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Mật khẩu</label>
                <input type="password" name="password" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2.5 rounded hover:bg-green-700 transition">
                Đăng nhập
            </button>
        </form>
    </div>
</body>
</html>