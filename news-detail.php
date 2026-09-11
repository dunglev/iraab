<?php
require_once 'db.php';

// Ép kiểu kết nối MySQL sang mã hóa utf8mb4 để đọc đúng tiếng Việt
try {
    $pdo->exec("SET NAMES 'utf8mb4'");
    
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        $error_message = "Bài viết bạn đang tìm kiếm không tồn tại hoặc đã bị gỡ bỏ.";
    }
} catch (Exception $e) {
    $article = false;
    $error_message = "Đã xảy ra lỗi kết nối cơ sở dữ liệu.";
}
?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article ? htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') . ' - Viện IRAAB' : 'Không tìm thấy bài viết' ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Quicksand (Font chữ tròn và mảnh mai, hiện đại) -->
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
        .text-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #16a34a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-green-500 selection:text-white">

    <!-- Header / Navigation Bar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3 focus:outline-none">
                <img src="assets/images/logo.jpg" alt="IRAAB Logo" class="h-10 w-auto object-contain rounded-lg shadow-sm">
                <span class="font-bold text-lg text-slate-900">Viện IRAAB</span>
            </a>
            <a href="news.php" class="text-sm font-semibold text-slate-600 hover:text-green-700 transition flex items-center gap-2 bg-slate-100 hover:bg-slate-200/70 px-4 py-2 rounded-xl">
                <i class="fa-solid fa-arrow-left text-xs"></i> Danh sách tin tức
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="pt-32 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <?php if ($article): ?>
                <article class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm">
                    <!-- Title -->
                    <h1 class="text-2xl sm:text-4xl font-bold text-slate-900 mb-4 leading-snug">
                        <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                    </h1>
                    
                    <!-- Date Meta -->
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-8 pb-6 border-b border-slate-100">
                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full border border-green-200/60 inline-flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-green-600"></i> <?= date('d/m/Y - H:i', strtotime($article['created_at'])) ?>
                        </span>
                    </div>
                    
                    <!-- Featured Image -->
                    <?php if (!empty($article['image'])): ?>
                        <div class="mb-8 rounded-2xl overflow-hidden border border-slate-100 shadow-sm max-h-[450px] bg-slate-100">
                            <img src="uploads/<?= htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>

                    <!-- Summary Box -->
                    <?php if (!empty($article['summary'])): ?>
                        <div class="text-slate-700 font-medium text-base sm:text-lg mb-8 p-6 bg-slate-50 rounded-2xl border-l-4 border-green-600 border border-slate-200/60 leading-relaxed shadow-sm">
                            <?= nl2br(htmlspecialchars($article['summary'], ENT_QUOTES, 'UTF-8')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Main Article Body -->
                    <div class="text-slate-700 font-normal text-base sm:text-lg leading-relaxed space-y-6">
                        <?= nl2br(htmlspecialchars($article['content'], ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                </article>
            <?php else: ?>
                <div class="bg-white border border-dashed border-slate-300 rounded-3xl p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Không tìm thấy bài viết</h2>
                    <p class="text-slate-600 font-normal mb-6"><?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?></p>
                    <a href="news.php" class="inline-flex items-center gap-2 bg-gradient-iraab text-white px-6 py-3 rounded-xl font-semibold text-sm shadow-md hover:opacity-95 transition">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Quay lại trang danh sách tin tức
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 font-normal py-6 border-t border-slate-800/80 text-xs">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <p>© <?= date('Y') ?> Viện Nghiên cứu và Ứng dụng Sinh học Công nghệ cao (IRAAB). Tất cả quyền được bảo lưu.</p>
            <a href="admin/login.php" class="hover:text-white transition flex items-center gap-1.5 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                <i class="fa-solid fa-lock text-[10px]"></i> Hệ thống Quản trị (Admin)
            </a>
        </div>
    </footer>

</body>
</html>