<?php
session_start();

// Kiểm tra quyền đăng nhập bắt buộc
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin bài viết hiện tại
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: index.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $summary = trim($_POST['summary']);
    $content = trim($_POST['content']);
    $image_name = $article['image']; // Mặc định giữ nguyên ảnh cũ

    // Nếu người dùng chọn tải lên ảnh mới
    if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array(strtolower($ext), $allowed_exts)) {
                $new_image_name = time() . '_' . uniqid() . '.' . $ext;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $new_image_name)) {
                    // Xóa file ảnh cũ nếu có
                    if ($article['image'] && file_exists('../uploads/' . $article['image'])) {
                        unlink('../uploads/' . $article['image']);
                    }
                    $image_name = $new_image_name;
                } else {
                    $message = "Không thể lưu hình ảnh vào thư mục uploads! Vui lòng kiểm tra phân quyền.";
                }
            } else {
                $message = "Định dạng ảnh không hợp lệ (Chỉ chấp nhận JPG, PNG, GIF, WEBP).";
            }
        } else {
            $message = "Lỗi: Ảnh tải lên bị lỗi hoặc dung lượng quá lớn (vượt giới hạn server).";
        }
    }

    // Chỉ cập nhật nếu không có thông báo lỗi từ phần tải ảnh
    if (empty($message)) {
        if (!empty($title) && !empty($content)) {
            $stmt = $pdo->prepare("UPDATE news SET title = ?, summary = ?, content = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $summary, $content, $image_name, $id]);
            header("Location: index.php");
            exit;
        } else {
            $message = "Vui lòng nhập đầy đủ tiêu đề và nội dung bài viết!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa bài viết - IRAAB Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto py-8 px-4">
        <a href="index.php" class="text-sm text-blue-600 font-semibold hover:underline flex items-center gap-1 mb-4">
            <i class="fa-solid fa-arrow-left text-xs"></i> Quay lại danh sách
        </a>
        
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Chỉnh Sửa Tin Tức / Sự Kiện</h1>

        <?php if ($message): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm font-semibold"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <label class="block font-semibold text-sm mb-1">Tiêu đề bài viết (*)</label>
                <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold text-sm mb-1">Tóm tắt ngắn</label>
                <textarea name="summary" rows="3" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($article['summary']) ?></textarea>
            </div>

            <!-- Khu vực tải ảnh và Xem trước (Live Preview) đã được chỉnh sửa -->
            <div>
                <label class="block font-semibold text-sm mb-1">Hình ảnh đính kèm hiện tại / Xem trước</label>
                
                <div class="mb-2">
                    <img id="image-preview" 
                         src="<?= $article['image'] ? '../uploads/' . htmlspecialchars($article['image']) : '' ?>" 
                         class="h-32 object-cover rounded border <?= $article['image'] ? '' : 'hidden' ?>" 
                         alt="Xem trước ảnh">
                         
                    <p id="no-image-text" class="text-xs text-gray-400 mb-2 <?= $article['image'] ? 'hidden' : '' ?>">
                        Chưa có ảnh đính kèm
                    </p>
                </div>

                <label class="block font-semibold text-xs text-gray-600 mb-1">Thay đổi ảnh mới (để trống nếu giữ ảnh cũ):</label>
                <input type="file" name="image" id="image-input" accept="image/*" class="w-full border px-3 py-2 rounded text-sm">
            </div>

            <div>
                <label class="block font-semibold text-sm mb-1">Nội dung chi tiết (*)</label>
                <textarea name="content" rows="10" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($article['content']) ?></textarea>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2.5 rounded font-bold hover:bg-blue-800 text-sm">
                    Lưu thay đổi
                </button>
                <a href="index.php" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded font-bold hover:bg-gray-300 text-sm">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Script tạo hiệu ứng Live Preview ảnh -->
    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            const noImageText = document.getElementById('no-image-text');

            if (file) {
                // Tạo link tạm thời để xem trước ảnh
                preview.src = URL.createObjectURL(file);
                
                // Hiển thị thẻ img, ẩn dòng chữ "Chưa có ảnh"
                preview.classList.remove('hidden');
                if (noImageText) noImageText.classList.add('hidden');
            } else {
                // Nếu người dùng hủy chọn file, khôi phục lại trạng thái cũ
                <?php if ($article['image']): ?>
                    preview.src = "../uploads/<?= htmlspecialchars($article['image']) ?>";
                <?php else: ?>
                    preview.classList.add('hidden');
                    preview.src = '';
                    if (noImageText) noImageText.classList.remove('hidden');
                <?php endif; ?>
            }
        });
    </script>
</body>
</html>