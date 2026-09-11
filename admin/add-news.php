<?php
session_start();

// Kiểm tra quyền đăng nhập bắt buộc
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

$error_msg = '';

// Tự động tạo thư mục uploads ở ngoài nếu chưa tồn tại
$upload_dir = '../uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image_name = NULL;

    if (empty($title) || empty($content)) {
        $error_msg = "Vui lòng nhập đầy đủ tiêu đề và nội dung bài viết!";
    } else {
        // Xử lý tải lên hình ảnh có kèm bắt lỗi dung lượng
        if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array(strtolower($ext), $allowed_exts)) {
                    $image_name = time() . '_' . uniqid() . '.' . $ext;
                    $target_file = $upload_dir . $image_name;

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        $error_msg = "Không thể lưu hình ảnh vào thư mục uploads! Kiểm tra lại phân quyền thư mục.";
                    }
                } else {
                    $error_msg = "Định dạng ảnh không hợp lệ (Chỉ chấp nhận JPG, PNG, GIF, WEBP).";
                }
            } else {
                $error_msg = "Lỗi: Ảnh tải lên bị lỗi hoặc dung lượng quá lớn (vượt giới hạn cấu hình của server).";
            }
        }

        // Lưu dữ liệu vào CSDL nếu không có lỗi nào phía trên
        if (empty($error_msg)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO news (title, summary, content, image, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$title, $summary, $content, $image_name]);

                header("Location: index.php");
                exit;
            } catch (PDOException $e) {
                $error_msg = "Lỗi cơ sở dữ liệu: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Tin Tức Mới - IRAAB Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto py-8 px-4">
        <a href="index.php" class="text-sm text-blue-600 font-semibold hover:underline flex items-center gap-1 mb-4">
            <i class="fa-solid fa-arrow-left text-xs"></i> Quay lại danh sách
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mb-6">Thêm Tin Tức / Sự Kiện Mới</h1>

        <?php if ($error_msg): ?>
            <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded mb-6 text-sm font-semibold">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <label class="block font-semibold text-sm mb-1">Tiêu đề bài viết (*)</label>
                <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block font-semibold text-sm mb-1">Tóm tắt ngắn</label>
                <textarea name="summary" rows="3" class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($_POST['summary'] ?? '') ?></textarea>
            </div>

            <!-- Khu vực tải ảnh và Xem trước (Live Preview) -->
            <div>
                <label class="block font-semibold text-sm mb-1">Hình ảnh đính kèm</label>
                
                <div class="mb-2">
                    <img id="image-preview" src="" class="h-32 object-cover rounded border hidden" alt="Xem trước ảnh">
                </div>

                <input type="file" name="image" id="image-input" accept="image/*" class="w-full border border-slate-300 px-3 py-2 rounded text-sm">
            </div>

            <div>
                <label class="block font-semibold text-sm mb-1">Nội dung chi tiết (*)</label>
                <textarea name="content" rows="10" required class="w-full border border-slate-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded font-bold hover:bg-green-700 text-sm">
                    Lưu & Đăng bài
                </button>
                <a href="index.php" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded font-bold hover:bg-gray-300 text-sm">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Script tạo hiệu ứng Live Preview ảnh giống với trang Edit -->
    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
                preview.src = '';
            }
        });
    </script>
</body>
</html>