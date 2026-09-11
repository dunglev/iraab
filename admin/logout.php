<?php
session_start();

// Giải phóng toàn bộ biến session
$_SESSION = array();

// Xóa cookie chứa Session ID trên trình duyệt (nếu có)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit;