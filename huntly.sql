-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 14, 2025 lúc 12:39 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `huntly`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `headquarters_address` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `website` varchar(255) DEFAULT NULL,
  `company_size` varchar(50) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `companies`
--

INSERT INTO `companies` (`company_id`, `employer_id`, `company_name`, `headquarters_address`, `description`, `logo_path`, `created_at`, `updated_at`, `website`, `company_size`, `industry`) VALUES
(1, 2, 'Tiki', 'Tòa nhà Viettel, 285 Cách Mạng Tháng 8, P.12, Q.10, HCMC', 'Tiki là một công ty thương mại điện tử hàng đầu Việt Nam', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, NULL),
(2, 3, 'MoMo', 'Tòa nhà VNPT, 57 Huỳnh Thúc Kháng, Đống Đa, Hà Nội', 'MoMo là ví điện tử hàng đầu Việt Nam', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, NULL),
(3, 4, 'Sendo', 'Tòa nhà Sendo, 123 Nguyễn Thị Minh Khai, Q.1, HCMC', 'Sendo là sàn thương mại điện tử lớn tại Việt Nam', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, NULL),
(4, 5, 'VNG', 'Tòa nhà VNG Campus, Quận 7, HCMC', 'VNG là công ty công nghệ hàng đầu Việt Nam', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, NULL),
(5, 6, 'FPT Software', 'FPT Complex, Đà Nẵng', 'FPT Software là công ty phần mềm hàng đầu Việt Nam', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, NULL),
(6, 7, 'Shopee', 'Tòa nhà Lim Tower, Quận 1, HCMC', 'Shopee là nền tảng thương mại điện tử hàng đầu Đông Nam Á', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `experience_levels`
--

CREATE TABLE `experience_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `experience_levels`
--

INSERT INTO `experience_levels` (`id`, `name`, `slug`) VALUES
(1, 'Entry Level', 'entry'),
(2, 'Mid Level', 'mid'),
(3, 'Senior Level', 'senior'),
(4, 'Executive', 'executive');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_applications`
--

CREATE TABLE `job_applications` (
  `application_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `seeker_id` int(11) NOT NULL,
  `applicant_email` varchar(255) DEFAULT NULL,
  `applicant_phone` varchar(20) DEFAULT NULL,
  `status` enum('pending','reviewing','shortlisted','hired','rejected') DEFAULT 'pending',
  `resume_path` varchar(255) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `employer_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `interview_date` datetime DEFAULT NULL,
  `interview_location` varchar(255) DEFAULT NULL,
  `source` varchar(50) DEFAULT 'direct' COMMENT 'How the candidate found the job'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `job_applications`
--

INSERT INTO `job_applications` (`application_id`, `job_id`, `seeker_id`, `applicant_email`, `applicant_phone`, `status`, `resume_path`, `cover_letter`, `employer_notes`, `created_at`, `updated_at`, `interview_date`, `interview_location`, `source`) VALUES
(2, 2, 8, 'applicant1@example.com', '0987123456', 'pending', 'uploads/resumes/applicant1_cv.pdf', 'Tôi có kinh nghiệm làm việc với Laravel và các framework PHP...', NULL, '2025-04-11 17:25:25', '2025-04-13 21:12:07', NULL, NULL, 'direct'),
(3, 3, 9, 'applicant2@example.com', '0987123457', '', 'uploads/resumes/applicant2_cv.pdf', 'Tôi đam mê phát triển ứng dụng di động và mong muốn được học hỏi tại MoMo...', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, 'direct'),
(4, 4, 9, 'applicant2@example.com', '0987123457', 'rejected', 'uploads/resumes/applicant2_cv.pdf', 'Tôi mong muốn được tham gia vào đội ngũ phát triển của MoMo...', NULL, '2025-04-11 17:25:25', NULL, NULL, NULL, 'direct');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_categories`
--

CREATE TABLE `job_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `job_categories`
--

INSERT INTO `job_categories` (`category_id`, `name`, `slug`, `description`) VALUES
(1, 'Information Technology', 'it', 'Software development, IT infrastructure, and technical roles'),
(2, 'Finance', 'finance', 'Accounting, banking, financial analysis, and related roles'),
(3, 'Marketing', 'marketing', 'Digital marketing, advertising, brand management, and related roles'),
(4, 'Human Resources', 'hr', 'Recruitment, HR management, training, and related roles'),
(5, 'Design', 'design', 'Graphic design, UX/UI design, and creative roles'),
(6, 'Sales', 'sales', 'Sales, business development, and customer acquisition roles'),
(7, 'Engineering', 'engineering', 'Engineering, technical roles outside of IT');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_posts`
--

CREATE TABLE `job_posts` (
  `job_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `job_type` enum('Full-time','Part-time','Contract','Internship') NOT NULL,
  `work_model` enum('remote','hybrid','onsite') DEFAULT NULL,
  `experience_level` enum('entry','mid','senior','executive') DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `salary_min` decimal(12,2) DEFAULT NULL,
  `salary_max` decimal(12,2) DEFAULT NULL,
  `hide_salary` tinyint(1) DEFAULT 0,
  `pdf_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','closed','draft') DEFAULT 'pending',
  `application_deadline` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `job_posts`
--

INSERT INTO `job_posts` (`job_id`, `company_id`, `employer_id`, `title`, `description`, `requirements`, `benefits`, `job_type`, `work_model`, `experience_level`, `location`, `salary_min`, `salary_max`, `hide_salary`, `pdf_path`, `status`, `application_deadline`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'Backend Developer', 'Phát triển API và xử lý logic backend', 'PHP, MySQL, Laravel', 'skill', 'Full-time', 'hybrid', 'mid', 'Ho Chi Minh City', 1500.00, 2500.00, 0, 'uploads/job_pdfs/1744512810_chabong_shop.pdf', 'active', '2025-05-30', '2025-04-11 17:25:25', '2025-04-13 20:46:18'),
(3, 2, 3, 'Mobile Developer', 'Phát triển ứng dụng di động cho MoMo', 'Android, iOS, Flutter', NULL, 'Full-time', NULL, NULL, 'Ha Noi', 1800.00, 2800.00, 0, NULL, 'active', NULL, '2025-04-11 17:25:25', NULL),
(4, 2, 3, 'QA Engineer', 'Kiểm thử chất lượng ứng dụng', 'Manual Testing, Automation Testing, Selenium', NULL, 'Full-time', NULL, NULL, 'Ha Noi', 1200.00, 2000.00, 0, NULL, 'active', NULL, '2025-04-11 17:25:25', NULL),
(5, 3, 4, 'Data Analyst', 'Phân tích dữ liệu người dùng', 'SQL, Python, Data Visualization', NULL, 'Full-time', NULL, NULL, 'Ho Chi Minh City', 1600.00, 2600.00, 0, NULL, 'active', NULL, '2025-04-11 17:25:25', NULL),
(6, 4, 5, 'Game Developer', 'Phát triển game mobile cho VNG', 'Unity, C#, Gaming', NULL, 'Full-time', NULL, NULL, 'Ho Chi Minh City', 2000.00, 3500.00, 0, NULL, 'active', NULL, '2025-04-11 17:25:25', NULL),
(7, 5, 6, 'DevOps Engineer', 'Quản lý hệ thống CI/CD', 'Docker, Kubernetes, AWS', NULL, 'Full-time', NULL, NULL, 'Da Nang', 1800.00, 3000.00, 0, NULL, 'active', NULL, '2025-04-11 17:25:25', NULL),
(8, 6, 7, 'UI/UX Designer', 'Thiết kế giao diện cho Shopee', 'Figma, Adobe XD, UX Research', NULL, 'Full-time', NULL, NULL, 'Ho Chi Minh City', 1500.00, 2400.00, 0, NULL, 'active', NULL, '2025-04-11 17:25:25', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_post_categories`
--

CREATE TABLE `job_post_categories` (
  `job_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `job_post_categories`
--

INSERT INTO `job_post_categories` (`job_id`, `category_id`) VALUES
(2, 2),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(6, 1),
(7, 1),
(8, 1),
(8, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_seekers`
--

CREATE TABLE `job_seekers` (
  `seeker_id` int(11) NOT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `education` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `job_seekers`
--

INSERT INTO `job_seekers` (`seeker_id`, `resume_path`, `cover_letter`, `skills`, `experience_years`, `education`, `created_at`, `updated_at`) VALUES
(8, NULL, NULL, 'JavaScript, React, Vue, HTML, CSS', 3, NULL, '2025-04-11 17:25:25', NULL),
(9, NULL, NULL, 'Java, Python, SQL, Data Analysis', 2, NULL, '2025-04-11 17:25:25', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('application','approval','message','system') NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `type`, `reference_id`, `is_read`, `created_at`) VALUES
(1, 2, 'New Application', 'John Applicant has applied for Frontend Developer position', 'application', 1, 0, '2025-04-11 17:25:25'),
(2, 2, 'New Application', 'John Applicant has applied for Backend Developer position', 'application', 2, 0, '2025-04-11 17:25:25'),
(3, 3, 'New Application', 'Jane Applicant has applied for Mobile Developer position', 'application', 3, 1, '2025-04-11 17:25:25'),
(4, 3, 'New Application', 'Jane Applicant has applied for QA Engineer position', 'application', 4, 1, '2025-04-11 17:25:25'),
(5, 2, 'Job Post Approved', 'Your job posting \"Frontend Developer\" has been approved', 'approval', 1, 0, '2025-04-11 17:25:25'),
(6, 3, 'Job Post Approved', 'Your job posting \"Mobile Developer\" has been approved', 'approval', 3, 1, '2025-04-11 17:25:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('admin','company_admin','job_seeker') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `full_name`, `role`, `phone`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin@huntly.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Admin User', 'admin', '1234567890', 1, '2025-04-11 17:25:25', NULL),
(2, 'tiki@example.com', '$2y$10$Tn/0xi2s.OElsEgYTieQX.mcyzYyuBcGYHB8f3eQKkaBH8JRvhh8e', 'Tiki Employer', 'company_admin', '0987654321', 1, '2025-04-11 17:25:25', NULL),
(3, 'momo@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'MoMo Employer', 'company_admin', '0987654322', 1, '2025-04-11 17:25:25', NULL),
(4, 'sendo@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Sendo Employer', 'company_admin', '0987654323', 1, '2025-04-11 17:25:25', NULL),
(5, 'vng@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'VNG Employer', 'company_admin', '0987654324', 1, '2025-04-11 17:25:25', NULL),
(6, 'fpt@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'FPT Employer', 'company_admin', '0987654325', 1, '2025-04-11 17:25:25', NULL),
(7, 'shopee@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Shopee Employer', 'company_admin', '0987654326', 1, '2025-04-11 17:25:25', NULL),
(8, 'applicant1@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'John Applicant', 'job_seeker', '0987123456', 1, '2025-04-11 17:25:25', NULL),
(9, 'applicant2@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Jane Applicant', 'job_seeker', '0987123457', 1, '2025-04-11 17:25:25', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `work_models`
--

CREATE TABLE `work_models` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `work_models`
--

INSERT INTO `work_models` (`id`, `name`, `slug`) VALUES
(1, 'Remote', 'remote'),
(2, 'Hybrid', 'hybrid'),
(3, 'On-site', 'onsite');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `fk_companies_employer` (`employer_id`);

--
-- Chỉ mục cho bảng `experience_levels`
--
ALTER TABLE `experience_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Chỉ mục cho bảng `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Chỉ mục cho bảng `job_post_categories`
--
ALTER TABLE `job_post_categories`
  ADD PRIMARY KEY (`job_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD PRIMARY KEY (`seeker_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `work_models`
--
ALTER TABLE `work_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `experience_levels`
--
ALTER TABLE `experience_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `work_models`
--
ALTER TABLE `work_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_companies_employer` FOREIGN KEY (`employer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`job_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`seeker_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `job_posts`
--
ALTER TABLE `job_posts`
  ADD CONSTRAINT `job_posts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_posts_ibfk_2` FOREIGN KEY (`employer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `job_post_categories`
--
ALTER TABLE `job_post_categories`
  ADD CONSTRAINT `job_post_categories_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`job_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`category_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD CONSTRAINT `job_seekers_ibfk_1` FOREIGN KEY (`seeker_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
