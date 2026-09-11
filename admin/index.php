<?php
session_start();

// Kiểm tra quyền đăng nhập bắt buộc
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

$message = '';
$error = '';

// Nhận thông báo từ các thao tác chuyển hướng (nếu có)
if (isset($_GET['msg']) && $_GET['msg'] === 'restore_success') {
    $message = "Khôi phục dữ liệu thành công!";
}
if (isset($_GET['err'])) {
    $error = $_GET['err'];
}

try {
    $pdo->exec("SET NAMES 'utf8mb4'");
    
    // Xử lý Xóa tin tức
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        
        // Lấy tên ảnh cũ để xóa file
        $stmtImg = $pdo->prepare("SELECT image FROM news WHERE id = ?");
        $stmtImg->execute([$id]);
        $item = $stmtImg->fetch();
        if ($item && $item['image'] && file_exists('../uploads/' . $item['image'])) {
            unlink('../uploads/' . $item['image']);
        }

        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php");
        exit;
    }

    $stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $news = [];
    $error = "Lỗi hệ thống: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tin tức - IRAAB Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            font-weight: 300;
        }
        h1, h2, h3, h4, h5, h6, strong, b {
            font-weight: 600;
        }
        .bg-gradient-iraab {
            background: linear-gradient(135deg, #0284c7 0%, #16a34a 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-green-500 selection:text-white">

    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6">
        
        <!-- Thông báo Trạng thái -->
        <?php if (!empty($message)): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Header Quản trị Cao cấp & Gọn gàng -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 text-green-700 rounded-2xl flex items-center justify-center text-xl border border-green-200/60 shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Quản Lý Tin Tức & Sự Kiện</h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal mt-0.5">Xin chào, <strong class="text-slate-700 font-semibold"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></strong></p>
                </div>
            </div>
            
            <!-- Nhóm nút thao tác hệ thống -->
            <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto justify-start md:justify-end">
                <a href="add-news.php" class="bg-gradient-iraab text-white px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold shadow-md hover:shadow-lg hover:opacity-95 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Thêm tin tức
                </a>
                <a href="backup.php" class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-emerald-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-download text-xs"></i> Sao lưu
                </a>
                <button onclick="document.getElementById('restoreModal').classList.remove('hidden')" class="bg-amber-50 text-amber-700 hover:bg-amber-100 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-amber-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-upload text-xs"></i> Khôi phục
                </button>
                <a href="change-password.php" class="bg-slate-100 text-slate-700 hover:bg-slate-200 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-key text-xs"></i> Đổi mật khẩu
                </a>
                <a href="logout.php" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-red-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i> Đăng xuất
                </a>
            </div>
        </div>

        <!-- Modal Restore Database (Đã tích hợp xác nhận mật khẩu) -->
        <div id="restoreModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 border border-slate-200 shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Khôi phục dữ liệu</h3>
                    <button onclick="document.getElementById('restoreModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <form action="restore.php" method="POST" enctype="multipart/form-data">
                    <p class="text-xs text-slate-500 mb-4">Lưu ý: Thao tác này sẽ ghi đè toàn bộ cơ sở dữ liệu hiện tại. Vui lòng nhập mật khẩu tài khoản của bạn để xác nhận.</p>
                    
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Chọn file sao lưu (.sql)</label>
                        <input type="file" name="backup_file" accept=".sql" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-slate-200 rounded-xl p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Mật khẩu xác nhận của bạn</label>
                        <input type="password" name="admin_password" placeholder="Nhập mật khẩu Admin..." required class="w-full text-xs border border-slate-200 rounded-xl p-2.5 focus:outline-none focus:border-green-500">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('restoreModal').classList.add('hidden')" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-xs font-semibold">Hủy</button>
                        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn khôi phục cơ sở dữ liệu?');" class="bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-green-700">Xác nhận khôi phục</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bảng danh sách bài viết -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/70 text-slate-600 text-xs uppercase tracking-wider border-b border-slate-200/60">
                            <th class="p-4.5 font-semibold">ID</th>
                            <th class="p-4.5 font-semibold">Hình ảnh</th>
                            <th class="p-4.5 font-semibold">Tiêu đề bài viết</th>
                            <th class="p-4.5 font-semibold">Ngày đăng</th>
                            <th class="p-4.5 font-semibold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-normal">
                        <?php if (count($news) > 0): ?>
                            <?php foreach ($news as $item): ?>
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-4.5 font-semibold text-slate-500">#<?= (int)$item['id'] ?></td>
                                    <td class="p-4.5">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="../uploads/<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-sm">
                                        <?php else: ?>
                                            <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-400 rounded-lg text-xs font-medium">Không ảnh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4.5 font-semibold text-slate-900 max-w-md leading-snug">
                                        <?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="p-4.5 text-slate-500 text-xs">
                                        <i class="fa-regular fa-calendar mr-1 text-green-600"></i> <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                                    </td>
                                    <td class="p-4.5 text-center whitespace-nowrap space-x-2">
                                        <a href="edit-news.php?id=<?= (int)$item['id'] ?>" class="inline-flex items-center gap-1 bg-sky-50 text-sky-600 hover:bg-sky-100 px-3 py-1.5 rounded-xl text-xs font-semibold border border-sky-200/60 transition">
                                            <i class="fa-solid fa-pen-to-square"></i> Sửa
                                        </a>
                                        <a href="index.php?delete=<?= (int)$item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');" class="inline-flex items-center gap-1 bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-xl text-xs font-semibold border border-red-200/60 transition">
                                            <i class="fa-solid fa-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400 font-normal">
                                    <i class="fa-regular fa-newspaper text-4xl mb-3 text-slate-300"></i>
                                    <p>Chưa có bài viết nào trong hệ thống.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>