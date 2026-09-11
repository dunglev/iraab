<?php
require_once 'db.php';

// Chỉ lấy 3 bài viết tin tức & sự kiện mới nhất từ MySQL
try {
    // Ép kiểu kết nối MySQL sang mã hóa utf8mb4 để đọc đúng tiếng Việt
    $pdo->exec("SET NAMES 'utf8mb4'");
    
    $stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 3");
    $latest_news = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $latest_news = [];
}
?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viện Nghiên cứu và Ứng dụng Sinh học Công nghệ cao - IRAAB</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Quicksand (Font chữ tròn và mảnh mai, hiện đại) -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            font-weight: 300; /* Thiết lập mặc định nét mảnh tinh tế */
        }
        /* Đảm bảo các thẻ tiêu đề và chữ đậm vẫn giữ độ nét vừa vặn, không quá thô */
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

    <!-- 1. Header / Navigation Bar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo IRAAB -->
            <a href="#hero" class="flex items-center gap-3 focus:outline-none">
                <img src="assets/images/logo.jpg" alt="IRAAB Logo" class="h-12 w-auto object-contain rounded-lg shadow-sm">
            </a>

            <!-- CTA Button -->
            <div>
                <a href="#contact" class="bg-gradient-iraab text-white px-5.5 py-2.5 rounded-full text-sm font-medium shadow-md hover:shadow-lg hover:opacity-95 transition-all duration-200 inline-flex items-center">
                    <i class="fa-solid fa-phone mr-2 text-xs"></i>Liên hệ trực tiếp
                </a>
            </div>
        </div>
    </header>

    <!-- 2. Hero Section -->
    <section id="hero" class="pt-32 pb-20 md:pt-44 md:pb-32 bg-gradient-to-b from-blue-50/60 via-green-50/30 to-slate-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full pointer-events-none overflow-hidden z-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-400/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-80 h-80 bg-green-400/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-green-50 border border-green-200 text-green-700 text-xs font-semibold uppercase tracking-wider mb-6 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-green-600 animate-pulse"></span>
                    Khoa học & Công nghệ Tiên phong
                </div>
                
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-slate-900 tracking-tight leading-[1.35] mb-6">
                    Viện Nghiên Cứu & Ứng Dụng <br class="hidden sm:inline"/>
                    <span class="text-gradient">Sinh Học Công Nghệ Cao</span>
                </h1>
                
                <p class="text-base md:text-xl text-slate-600 font-normal mb-10 leading-relaxed max-w-3xl mx-auto">
                    <span class="font-semibold text-slate-700">Institute of Research and Application of Advanced Biotechnology (IRAAB)</span> 
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a href="#about" class="w-full sm:w-auto bg-gradient-iraab text-white px-8 py-4 rounded-xl text-base font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 text-center">
                        Giới thiệu về Viện IRAAB
                    </a>
                    <a href="#news" class="w-full sm:w-auto bg-white text-slate-700 border border-slate-200 px-8 py-4 rounded-xl text-base font-semibold shadow-sm hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 text-center">
                        Tin tức & Sự kiện
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. About Section (Giới thiệu) -->
    <section id="about" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <span class="text-xs font-semibold text-green-700 uppercase tracking-widest block mb-3 bg-green-50 w-max px-3 py-1 rounded-md">About us</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight mb-6 leading-snug">
                        Viện Nghiên cứu và Ứng dụng Sinh học Công nghệ cao (IRAAB)
                    </h2>
                    <div class="space-y-4 text-slate-600 font-normal leading-relaxed text-base">
                        <p>
                            Thành lập từ năm 2014, là thành viên chính thức của <strong>Liên hiệp các Hội Khoa học và Kỹ thuật Việt Nam (VUSTA)</strong>, IRAAB là tổ chức khoa học công nghệ tư nhân chuyên sâu trong các mảng y dược, nông nghiệp, khoa học sự sống và môi trường.
                        </p>
                        <p>
                            Chúng tôi tập trung đẩy mạnh các hoạt động nghiên cứu khoa học cốt lõi, thúc đẩy chuyển giao công nghệ hiện đại, nhân rộng mô hình sản xuất tiên tiến và tham gia tư vấn chính sách về phúc lợi xã hội & động vật.
                        </p>
                    </div>
                    
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fa-solid fa-circle-check text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-sm font-semibold text-slate-800">Nghiên cứu khoa học chuyên sâu</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fa-solid fa-circle-check text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-sm font-semibold text-slate-800">Chuyển giao công nghệ tiên tiến</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fa-solid fa-circle-check text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-sm font-semibold text-slate-800">Mô hình sản xuất hiện đại</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fa-solid fa-circle-check text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-sm font-semibold text-slate-800">Tư vấn chính sách & Phúc lợi</span>
                        </div>
                    </div>
                </div>

                <!-- Diagram Image -->
                <div class="relative">
                    <div class="absolute -inset-3 bg-gradient-iraab rounded-3xl opacity-15 blur-2xl"></div>
                    <div class="relative bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xl">
                        <img src="assets/images/diagram.png" alt="Sơ đồ 5 Lĩnh vực IRAAB" class="w-full h-auto rounded-xl object-contain mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. News & Events Section (Hiển thị 3 tin tức mới nhất) -->
    <section id="news" class="py-24 bg-slate-100/70 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12 gap-4">
                <div>
                    <span class="text-xs font-semibold text-green-700 uppercase tracking-widest block mb-2 bg-green-50 w-max px-3 py-1 rounded-md">Latest News & Events</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Tin Tức & Sự Kiện Mới Nhất</h2>
                </div>
                <a href="news.php" class="text-green-700 font-semibold hover:text-green-800 transition inline-flex items-center gap-2 group text-sm bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                    Xem tất cả tin tức <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <?php if (!empty($latest_news)): ?>
                <div class="grid md:grid-cols-3 gap-8">
                    <?php foreach ($latest_news as $news_item): ?>
                        <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                            <div class="h-52 bg-slate-100 overflow-hidden relative">
                                <?php if (!empty($news_item['image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($news_item['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($news_item['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                        <i class="fa-solid fa-newspaper text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-md text-xs font-semibold px-3 py-1 rounded-full text-slate-700 shadow-sm border border-slate-100">
                                    <i class="fa-regular fa-calendar mr-1 text-green-600"></i> <?= date('d/m/Y', strtotime($news_item['created_at'])) ?>
                                </span>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg text-slate-900 mb-3 line-clamp-2 group-hover:text-green-700 transition-colors leading-snug">
                                        <a href="news-detail.php?id=<?= (int)$news_item['id'] ?>"><?= htmlspecialchars($news_item['title'], ENT_QUOTES, 'UTF-8') ?></a>
                                    </h3>
                                    <p class="text-slate-600 font-normal text-sm line-clamp-3 mb-6 leading-relaxed">
                                        <?= htmlspecialchars($news_item['summary'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                </div>
                                <a href="news-detail.php?id=<?= (int)$news_item['id'] ?>" class="text-sm font-semibold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5 group/link w-max">
                                    Xem chi tiết <i class="fa-solid fa-chevron-right text-xs transition-transform group-hover/link:translate-x-1"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center text-slate-500 font-normal">
                    <i class="fa-regular fa-newspaper text-4xl mb-3 text-slate-400"></i>
                    <p>Hiện chưa có tin tức nào được đăng tải.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- 5. Contact Section (Thông tin liên hệ trực tiếp) -->
    <section id="contact" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <!-- Ambient lighting background -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-green-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <span class="text-xs font-semibold text-green-400 uppercase tracking-widest block mb-2 bg-green-950/60 border border-green-500/20 w-max mx-auto px-3 py-1 rounded-md">Contact Us</span>
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Liên Hệ Với Chúng Tôi</h2>
                <p class="text-slate-300 font-normal leading-relaxed text-base">
                    Mọi yêu cầu hợp tác nghiên cứu, chuyển giao công nghệ hoặc tư vấn dự án, xin vui lòng liên hệ trực tiếp qua các kênh thông tin chính thức dưới đây.
                </p>
            </div>

            <!-- Contact Info Grid (Đưa cả 4 item nằm trên 1 hàng ngang trên màn hình lớn) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 border-t border-white/10 pt-14">
                
                <!-- Item 1: Address -->
                <div class="flex gap-4 group w-full">
                    <div class="w-12 h-12 bg-white/5 border border-white/10 text-green-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-green-500/10 group-hover:border-green-500/30 transition-all duration-300">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Địa chỉ trụ sở</h4>
                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                            Số 314 Minh Khai, P. Tương Mai, Q. Hoàng Mai, TP. Hà Nội, Việt Nam
                        </p>
                    </div>
                </div>

                <!-- Item 2: Phone -->
                <div class="flex gap-4 group w-full">
                    <div class="w-12 h-12 bg-white/5 border border-white/10 text-green-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-green-500/10 group-hover:border-green-500/30 transition-all duration-300">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Điện thoại liên hệ</h4>
                        <div class="text-xs sm:text-sm text-slate-200 space-y-1 font-normal">
                            <p>Tel: <a href="tel:+842432216158" class="hover:text-green-400 transition">+84 243 221 6158</a></p>
                            <p>Hotline: <a href="tel:+84915156878" class="text-green-400 font-semibold hover:underline">+84 915 156 878</a></p>
                        </div>
                    </div>
                </div>

                <!-- Item 3: Website -->
                <div class="flex gap-4 group w-full">
                    <div class="w-12 h-12 bg-white/5 border border-white/10 text-green-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-green-500/10 group-hover:border-green-500/30 transition-all duration-300">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Cổng thông tin</h4>
                        <a href="http://iraab.id.vn" target="_blank" class="text-xs sm:text-sm text-green-400 font-semibold hover:underline inline-flex items-center gap-1.5 mt-0.5">
                            iraab.id.vn <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 4: Tax Code & Legal -->
                <div class="flex gap-4 group w-full">
                    <div class="w-12 h-12 bg-white/5 border border-white/10 text-green-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-green-500/10 group-hover:border-green-500/30 transition-all duration-300">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Thông tin pháp lý</h4>
                        <p class="text-sm sm:text-base text-slate-200 font-mono tracking-wider font-semibold mt-0.5">
                            MST: 0107019571
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
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