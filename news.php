<?php
require_once 'db.php';

// Ép kiểu kết nối MySQL sang mã hóa utf8mb4 để đọc đúng tiếng Việt
try {
    $pdo->exec("SET NAMES 'utf8mb4'");
    $stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
    $all_news = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $all_news = [];
}
?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức & Sự kiện - Viện IRAAB</title>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3 focus:outline-none">
                <img src="assets/images/logo.jpg" alt="IRAAB Logo" class="h-12 w-auto object-contain rounded-lg shadow-sm">
                <span class="font-bold text-lg sm:text-xl text-slate-900 hidden sm:inline">Tin tức & Sự kiện</span>
            </a>
            <a href="index.php" class="text-sm font-semibold text-slate-600 hover:text-green-700 transition flex items-center gap-2 bg-slate-100 hover:bg-slate-200/70 px-4 py-2 rounded-xl">
                <i class="fa-solid fa-arrow-left text-xs"></i> Quay lại trang chủ
            </a>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="pt-32 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Title Header -->
            <div class="mb-12 text-center sm:text-left">
                <span class="text-xs font-semibold text-green-700 uppercase tracking-widest block mb-2 bg-green-50 w-max px-3 py-1 rounded-md mx-auto sm:mx-0">Archives</span>
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Tất cả Hoạt động & Sự kiện</h1>
                <p class="text-slate-600 font-normal mt-2">Cập nhật toàn bộ các tin tức nghiên cứu khoa học, chuyển giao công nghệ và thông tin hoạt động của Viện IRAAB.</p>
            </div>

            <?php if (!empty($all_news)): ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($all_news as $item): ?>
                        <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                            <div class="h-52 bg-slate-100 overflow-hidden relative">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                        <i class="fa-solid fa-newspaper text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-md text-xs font-semibold px-3 py-1 rounded-full text-slate-700 shadow-sm border border-slate-100">
                                    <i class="fa-regular fa-calendar mr-1 text-green-600"></i> <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                                </span>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg text-slate-900 mb-3 line-clamp-2 group-hover:text-green-700 transition-colors leading-snug">
                                        <a href="news-detail.php?id=<?= (int)$item['id'] ?>"><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?></a>
                                    </h3>
                                    <p class="text-slate-600 font-normal text-sm line-clamp-3 mb-6 leading-relaxed">
                                        <?= htmlspecialchars($item['summary'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                </div>
                                <a href="news-detail.php?id=<?= (int)$item['id'] ?>" class="text-sm font-semibold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5 group/link w-max">
                                    Xem chi tiết <i class="fa-solid fa-chevron-right text-xs transition-transform group-hover/link:translate-x-1"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center text-slate-500 font-normal shadow-sm">
                    <i class="fa-regular fa-newspaper text-4xl mb-3 text-slate-400"></i>
                    <p>Hiện chưa có tin tức nào được đăng tải.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 font-normal py-6 border-t border-slate-800/80 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <p>© <?= date('Y') ?> Viện Nghiên cứu và Ứng dụng Sinh học Công nghệ cao (IRAAB). Tất cả quyền được bảo lưu.</p>
            <a href="admin/login.php" class="hover:text-white transition flex items-center gap-1.5 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                <i class="fa-solid fa-lock text-[10px]"></i> Hệ thống Quản trị (Admin)
            </a>
        </div>
    </footer>

</body>
</html>