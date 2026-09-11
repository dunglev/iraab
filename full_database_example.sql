-- IRAAB Full Database Backup
-- Generated: 2026-09-11 05:49:27

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

-- Cấu trúc bảng cho `news`

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu cho bảng `news`

INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('1', 'Ứng dụng công nghệ sinh học trong lai tạo giống lúa chịu mặn', 'Các nhà khoa học vừa thử nghiệm thành công giống lúa mới chịu mặn cao nhờ ứng dụng công nghệ chỉnh sửa gen CRISPR.', 'Dự án nghiên cứu nhằm giúp nông dân Đồng bằng sông Cửu Long ứng phó với tình trạng xâm nhập mặn ngày càng gia tăng. Giống lúa mới không chỉ chịu được độ mặn cao mà còn duy trì năng suất vượt trội và chất lượng gạo đạt tiêu chuẩn xuất khẩu.', '1789095266_6aa36d625a2fa.jpg', '2026-08-10 09:15:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('2', 'Đột phá mới trong công nghệ chăn nuôi lợn an toàn sinh học', 'Giải pháp sử dụng chế phẩm vi sinh trong thức ăn giúp tăng sức đề kháng và giảm 90% dịch bệnh ở đàn lợn.', 'Việc bổ sung các chủng vi khuẩn có lợi vào khẩu phần ăn hàng ngày giúp cải thiện hệ tiêu hóa của vật nuôi, giảm thiểu việc sử dụng kháng sinh và xử lý triệt để mùi hôi chuồng trại, hướng tới ngành chăn nuôi xanh bền vững.', '1789095256_6aa36d5881a63.jpg', '2026-08-12 14:30:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('3', 'Phát hiện loài động vật hoang dã hiếm xuất hiện tại rừng quốc gia', 'Camera bẫy ảnh đã ghi lại hình ảnh của loài Saola quý hiếm tại Vườn quốc gia Vũ Quang.', 'Đây là tín hiệu rất khả quan cho công tác bảo tồn đa dạng sinh học tại Việt Nam. Ban quản lý rừng đang tăng cường các biện pháp tuần tra, gỡ bỏ bẫy thú để bảo vệ môi trường sống tự nhiên cho các loài động vật nguy cấp.', '1789095246_6aa36d4e2069e.avif', '2026-08-15 10:20:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('4', 'Ứng dụng công nghệ sinh học cải thiện chất lượng giống tôm thẻ chân trắng', 'Quy trình chọn giống phân tử giúp tăng trưởng nhanh và kháng vi-rút gây bệnh đốm trắng trên tôm.', 'Nhờ áp dụng chỉ thị phân tử trong chọn giống, các trang trại nuôi tôm công nghệ cao đã nâng tỉ lệ sống của tôm tít lên trên 85%, rút ngắn thời gian nuôi và gia tăng lợi nhuận đáng kể cho bà con ngư dân.', '1789095238_6aa36d462a184.jpg', '2026-08-18 16:45:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('5', 'Mô hình nuôi cá tầm công nghệ cao tại vùng núi phía Bắc', 'Ứng dụng hệ thống tuần hoàn nước RAS giúp nuôi cá tầm đạt năng suất cao và bảo vệ môi trường.', 'Mô hình nuôi cá tầm trong bể xi măng kết hợp hệ thống lọc sinh học tuần hoàn giúp duy trì nhiệt độ và chất lượng nước ổn định quanh năm, mở ra hướng đi phát triển kinh tế mới cho các tỉnh miền núi.', '1789095230_6aa36d3e4166f.jpg', '2026-08-20 08:00:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('6', 'Giải mã bản đồ gen của các giống vật nuôi bản địa Việt Nam', 'Viện Chăn nuôi hoàn thành nghiên cứu bản đồ gen nhằm bảo tồn các giống gà, lợn quý hiếm.', 'Việc giải mã thành công bản đồ gen giúp lưu trữ nguồn gen quý của các giống vật nuôi đặc sản như gà H\'Mong, lợn Ỉ, đồng thời tạo tiền đề để nhân giống và nâng cao giá trị thương phẩm trên thị trường.', '1789095221_6aa36d353ad50.avif', '2026-08-22 11:10:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('7', 'Sản xuất vắc-xin sinh học thế hệ mới phòng bệnh cho gia cầm', 'Loại vắc-xin tái tổ hợp ADN giúp bảo vệ đàn gà khỏi các biến chủng cúm gia cầm nguy hiểm.', 'Vắc-xin thế hệ mới có thời gian miễn dịch kéo dài và độ an toàn cao. Việc chủ động sản xuất vắc-xin trong nước giúp giảm chi phí nhập khẩu và hỗ trợ người chăn nuôi chủ động phòng chống dịch bệnh.', '1789095211_6aa36d2bef9a0.png', '2026-08-25 15:00:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('8', 'Bảo tồn và phát triển đàn voi rừng tại Tây Nguyên', 'Các dự án gắn thiết bị định vị vệ tinh giúp theo dõi và bảo vệ an toàn cho đàn voi rừng.', 'Bằng việc ứng dụng công nghệ giám sát GPS kết hợp với sự tham gia của cộng đồng địa phương, xung đột giữa người và voi đã giảm đáng kể, tạo hành lang di chuyển an toàn cho các đàn voi tự nhiên.', '1789095201_6aa36d21dd917.avif', '2026-08-28 09:30:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('9', 'Ứng dụng enzyme sinh học trong xử lý môi trường nuôi trồng thủy sản', 'Sử dụng enzyme tự nhiên để phân hủy chất thải hữu cơ dưới đáy ao nuôi cá, tôm.', 'Phương pháp sinh học này giúp phân hủy nhanh bùn đáy ao, giảm khí độc NH3, H2S mà không làm thay đổi pH của nước, hạn chế việc thay nước liên tục và bảo vệ hệ sinh thái xung quanh.', '1789095180_6aa36d0c4fbe6.jpg', '2026-08-30 13:20:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('10', 'Kỹ thuật nuôi bò sữa công nghệ cao đạt tiêu chuẩn quốc tế', 'Áp dụng chip sinh học theo dõi sức khỏe và chế độ dinh dưỡng tự động cho từng cá thể bò.', 'Các chip cảm biến giúp phát hiện sớm các dấu hiệu bệnh lý, chu kỳ sinh sản và mức độ vận động của bò sữa. Nhờ đó, chất lượng và sản lượng sữa tươi luôn giữ ở mức ổn định vượt trội.', '1789095170_6aa36d02e6c5c.jpg', '2026-09-01 07:45:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('11', 'Phát triển các dòng nấm dược liệu bằng công nghệ nuôi cấy mô', 'Nhân giống thành công các loài nấm quý như Đông trùng hạ thảo bằng phương pháp vi sinh hiện đại.', 'Quy trình nuôi cấy trong điều kiện phòng sạch vô trùng giúp tạo ra sản phẩm nấm dược liệu có hàm lượng hoạt chất sinh học cao, đáp ứng nhu cầu sản xuất thực phẩm bảo vệ sức khỏe.', '1789095159_6aa36cf7777b9.jpg', '2026-09-03 10:15:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('12', 'Nghiên cứu hành vi và tập tính của chim trĩ trong môi trường bán tự nhiên', 'Dự án nhân giống và thả về tự nhiên loài chim trĩ đỏ quý hiếm đạt nhiều kết quả khả quan.', 'Các nhà nghiên cứu đã ghi nhận sự thích nghi tốt của chim trĩ trong điều kiện bán tự nhiên. Dự án không chỉ giúp khôi phục quần thể chim hoang dã mà còn hỗ trợ phát triển mô hình chăn nuôi sinh thái.', '1789095146_6aa36cea97d0c.avif', '2026-09-05 14:00:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('13', 'Nhân giống cây dược liệu bằng kỹ thuật sinh học tế bào', 'Các loài cây thuốc quý như Sâm Ngọc Linh, Đinh lăng được nhân giống hàng loạt thành công.', 'Phương pháp nhân giống in-vitro giúp tạo ra lượng lớn cây giống đồng đều, sạch bệnh, giữ nguyên đặc tính di truyền tốt từ cây mẹ, phục vụ cho các vùng trồng dược liệu tập trung.', '1789095113_6aa36cc95abd2.avif', '2026-09-07 16:30:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('14', 'Mô hình nuôi trai lấy ngọc ứng dụng tảo sinh học làm thức ăn', 'Phương pháp nhân nuôi tảo chuyên biệt giúp rút ngắn thời gian tạo ngọc và tăng độ bóng đẹp.', 'Kỹ thuật nuôi cấy ngọc trai kết hợp bổ sung tảo vi sinh chất lượng cao giúp tỉ lệ phủ ngọc đẹp đạt trên 70%, nâng cao giá trị sản phẩm xuất khẩu của ngành thủy sản.', '1789095102_6aa36cbe93095.jpg', '2026-09-09 11:00:00');
INSERT INTO `news` (`id`, `title`, `summary`, `content`, `image`, `created_at`) VALUES ('15', 'Hội thảo quốc tế về ứng dụng sinh học trong phát triển nông nghiệp bền vững', 'Quy tụ hàng trăm chuyên gia bàn về giải pháp chăn nuôi, nuôi trồng thích ứng biến đổi khí hậu.', 'Tại hội thảo, nhiều thành tựu mới nhất về vắc-xin sinh học, chế phẩm vi sinh nông nghiệp và giải pháp bảo tồn động vật hoang dã đã được chia sẻ nhằm hướng tới một nền nông nghiệp tuần hoàn và an   toàn.', '1789095086_6aa36cae76b1e.png', '2026-09-10 09:00:00');

-- --------------------------------------------------------

-- Cấu trúc bảng cho `users`

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dữ liệu cho bảng `users`

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES ('1', 'admin', '$2y$10$2f/SXsbnVNFiR3Cf/lwiSuxfVtahGAPOnARlfbr8BkHVgHyNWQvrO', '2026-09-10 13:41:26');

SET FOREIGN_KEY_CHECKS=1;
