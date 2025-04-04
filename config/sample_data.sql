-- Disable foreign key checks
SET FOREIGN_KEY_CHECKS=0;

-- Drop and recreate tables

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS=1;

-- Temporarily disable auto increment
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE companies AUTO_INCREMENT = 1;
SET FOREIGN_KEY_CHECKS=1;

-- Insert sample data for companies
INSERT INTO companies (company_id, company_name, headquarters_address, company_description, website_url) VALUES
(1, 'Tiki', 'Tòa nhà Viettel, 285 Cách Mạng Tháng 8, P.12, Q.10, HCMC', 'Tiki là một công ty thương mại điện tử hàng đầu Việt Nam', 'https://tiki.vn'),
(2, 'MoMo', 'Tòa nhà VNPT, 57 Huỳnh Thúc Kháng, Đống Đa, Hà Nội', 'MoMo là ví điện tử hàng đầu Việt Nam', 'https://momo.vn'),
(3, 'Sendo', 'Tòa nhà Sendo, 123 Nguyễn Thị Minh Khai, Q.1, HCMC', 'Sendo là sàn thương mại điện tử lớn tại Việt Nam', 'https://sendo.vn'),
(4, 'VNG', 'Tòa nhà VNG Campus, Quận 7, HCMC', 'VNG là công ty công nghệ hàng đầu Việt Nam', 'https://vng.com.vn'),
(5, 'FPT Software', 'FPT Complex, Đà Nẵng', 'FPT Software là công ty phần mềm hàng đầu Việt Nam', 'https://fptsoftware.com'),
(6, 'Shopee', 'Tòa nhà Lim Tower, Quận 1, HCMC', 'Shopee là nền tảng thương mại điện tử hàng đầu Đông Nam Á', 'https://shopee.vn');

-- Reset auto increment after insert
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE companies AUTO_INCREMENT = 7;
SET FOREIGN_KEY_CHECKS=1;

-- Insert sample users with auto-incrementing IDs starting from 1
INSERT INTO users (email, password, full_name, phone, role, company_id) VALUES
('admin@tiki.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Tiki Admin', '0901234567', 'company_admin', 1),
('admin@momo.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MoMo Admin', '0901234568', 'company_admin', 2),
('admin@sendo.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sendo Admin', '0901234569', 'company_admin', 3),
('admin@vng.com.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VNG Admin', '0901234570', 'company_admin', 4),
('admin@fpt.com.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'FPT Admin', '0901234571', 'company_admin', 5),
('admin@shopee.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Shopee Admin', '0901234572', 'company_admin', 6),
('applicant1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', '0901234573', 'applicant', NULL),
('applicant2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị B', '0901234574', 'applicant', NULL);

-- Temporarily disable auto increment for job_posts
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE job_posts AUTO_INCREMENT = 1;
SET FOREIGN_KEY_CHECKS=1;

-- Insert sample job posts
INSERT INTO job_posts (job_id, company_id, title, description, requirements, job_type, location, salary_min, salary_max, status, created_at) VALUES
-- Tiki
(1, 1, 'Frontend Developer', 'Phát triển giao diện người dùng cho website Tiki', 'HTML, CSS, JavaScript, React', 'Full-time', 'Ho Chi Minh City', 1000, 2000, 'active', NOW()),
(2, 1, 'Backend Developer', 'Phát triển API và xử lý logic backend', 'PHP, MySQL, Laravel', 'Full-time', 'Ho Chi Minh City', 1500, 2500, 'active', NOW()),
(3, 1, 'Mobile Developer', 'Phát triển ứng dụng di động Tiki', 'Java, Kotlin, Android', 'Full-time', 'Ho Chi Minh City', 1800, 3000, 'active', NOW()),

-- MoMo
(4, 2, 'Mobile Developer', 'Phát triển ứng dụng di động MoMo', 'Java, Kotlin, Android', 'Full-time', 'Ha Noi', 2000, 3000, 'active', NOW()),
(5, 2, 'Backend Engineer', 'Phát triển hệ thống backend cho MoMo', 'Java, Spring Boot, Microservices', 'Full-time', 'Ha Noi', 2500, 4000, 'active', NOW()),
(6, 2, 'DevOps Engineer', 'Quản lý và tối ưu hóa hệ thống', 'Docker, Kubernetes, AWS', 'Full-time', 'Ha Noi', 2200, 3500, 'active', NOW()),

-- Sendo
(7, 3, 'Product Manager', 'Quản lý và phát triển sản phẩm', 'Agile, Scrum, Product Development', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(8, 3, 'UX/UI Designer', 'Thiết kế trải nghiệm người dùng', 'Figma, Adobe XD, User Research', 'Full-time', 'Ho Chi Minh City', 1500, 2500, 'active', NOW()),
(9, 3, 'QA Engineer', 'Đảm bảo chất lượng phần mềm', 'Manual Testing, Automation Testing', 'Full-time', 'Ho Chi Minh City', 1000, 2000, 'active', NOW()),

-- VNG
(10, 4, 'Game Developer', 'Phát triển game cho VNG', 'Unity, C#, Game Design', 'Full-time', 'Ho Chi Minh City', 2000, 3500, 'active', NOW()),
(11, 4, 'Data Scientist', 'Phân tích dữ liệu người dùng', 'Python, Machine Learning, SQL', 'Full-time', 'Ho Chi Minh City', 2500, 4000, 'active', NOW()),
(12, 4, 'Cloud Engineer', 'Quản lý hạ tầng đám mây', 'AWS, Azure, GCP', 'Full-time', 'Ho Chi Minh City', 2200, 3800, 'active', NOW()),

-- FPT Software
(13, 5, 'Java Developer', 'Phát triển phần mềm Java Enterprise', 'Java, Spring, Hibernate', 'Full-time', 'Da Nang', 1500, 2500, 'active', NOW()),
(14, 5, '.NET Developer', 'Phát triển ứng dụng .NET', 'C#, ASP.NET, SQL Server', 'Full-time', 'Da Nang', 1500, 2500, 'active', NOW()),
(15, 5, 'Business Analyst', 'Phân tích yêu cầu khách hàng', 'Agile, SDLC, UML', 'Full-time', 'Da Nang', 1200, 2000, 'active', NOW()),

-- Shopee
(16, 6, 'Frontend Developer', 'Phát triển giao diện Shopee', 'React, TypeScript, Redux', 'Full-time', 'Ho Chi Minh City', 2000, 3500, 'active', NOW()),
(17, 6, 'Backend Developer', 'Phát triển microservices', 'Go, PostgreSQL, Redis', 'Full-time', 'Ho Chi Minh City', 2500, 4000, 'active', NOW()),
(18, 6, 'Data Engineer', 'Xây dựng pipeline dữ liệu', 'Python, Spark, Airflow', 'Full-time', 'Ho Chi Minh City', 2200, 3800, 'active', NOW()),

-- Part-time và Internship positions
(19, 1, 'Marketing Intern', 'Hỗ trợ team marketing', 'MS Office, Social Media', 'Internship', 'Ho Chi Minh City', 300, 500, 'active', NOW()),
(20, 2, 'Customer Service', 'Hỗ trợ khách hàng', 'Tiếng Anh, Kỹ năng giao tiếp', 'Part-time', 'Ha Noi', 500, 800, 'active', NOW()),
(21, 3, 'Content Writer', 'Viết nội dung cho website', 'SEO, Content Marketing', 'Part-time', 'Ho Chi Minh City', 600, 1000, 'active', NOW()),
(22, 4, 'Game Testing Intern', 'Kiểm thử game', 'Basic Testing, Game Knowledge', 'Internship', 'Ho Chi Minh City', 400, 600, 'active', NOW()),
(23, 5, 'IT Support', 'Hỗ trợ kỹ thuật', 'Hardware, Networking', 'Part-time', 'Da Nang', 500, 800, 'active', NOW()),
(24, 6, 'Social Media Manager', 'Quản lý mạng xã hội', 'Facebook, Instagram, TikTok', 'Part-time', 'Ho Chi Minh City', 700, 1200, 'active', NOW());

-- Reset auto increment after insert
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE job_posts AUTO_INCREMENT = 25;
SET FOREIGN_KEY_CHECKS=1;

-- Insert sample job applications for the two applicants (user_id 7 and 8)
-- Note: Applicant 1 has user_id 7, Applicant 2 has user_id 8 based on the insertion order above
INSERT INTO job_applications (job_id, user_id, status, resume_path, cover_letter, created_at) VALUES
(1, 7, 'pending', 'resumes/applicant1_cv.pdf', 'Tôi rất quan tâm đến vị trí này và mong muốn được đóng góp cho Tiki...', NOW()),
(2, 7, 'reviewed', 'resumes/applicant1_cv.pdf', 'Tôi có kinh nghiệm làm việc với Laravel và các framework PHP...', NOW()),
(3, 8, 'accepted', 'resumes/applicant2_cv.pdf', 'Tôi đam mê phát triển ứng dụng di động và mong muốn được học hỏi tại Tiki...', NOW()),
(4, 8, 'rejected', 'resumes/applicant2_cv.pdf', 'Tôi mong muốn được tham gia vào đội ngũ phát triển của MoMo...', NOW());

-- Temporarily disable auto increment for new job posts
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE job_posts AUTO_INCREMENT = 25;
SET FOREIGN_KEY_CHECKS=1;

-- Insert more jobs for first 5 companies
INSERT INTO job_posts (job_id, company_id, title, description, requirements, job_type, location, salary_min, salary_max, status, created_at) VALUES
-- Thêm jobs cho Tiki (company_id: 1)
(25, 1, 'Senior Product Manager', 'Quản lý và phát triển các sản phẩm mới của Tiki', 'Kinh nghiệm 5 năm trong quản lý sản phẩm, Agile/Scrum, Phân tích dữ liệu', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(26, 1, 'UX/UI Designer', 'Thiết kế trải nghiệm người dùng cho website và ứng dụng Tiki', 'Figma, Adobe XD, Design Systems, User Research', 'Full-time', 'Ho Chi Minh City', 1500, 2500, 'active', NOW()),
(27, 1, 'Data Engineer', 'Xây dựng và quản lý hệ thống dữ liệu của Tiki', 'Python, Spark, Hadoop, SQL', 'Full-time', 'Ho Chi Minh City', 2000, 3500, 'active', NOW()),

-- Thêm jobs cho MoMo (company_id: 2)
(28, 2, 'Security Engineer', 'Đảm bảo an ninh cho hệ thống thanh toán', 'Penetration Testing, Security Protocols, Cryptography', 'Full-time', 'Ha Noi', 2500, 4500, 'active', NOW()),
(29, 2, 'Product Analytics Manager', 'Phân tích dữ liệu sản phẩm và đưa ra các quyết định chiến lược', 'SQL, Python, Data Visualization, Product Analytics', 'Full-time', 'Ha Noi', 3000, 5000, 'active', NOW()),
(30, 2, 'Technical Project Manager', 'Quản lý các dự án kỹ thuật của MoMo', 'Agile, JIRA, Technical Background, Communication Skills', 'Full-time', 'Ha Noi', 2800, 4500, 'active', NOW()),

-- Thêm jobs cho Sendo (company_id: 3)
(31, 3, 'Machine Learning Engineer', 'Phát triển các mô hình ML cho recommendation system', 'Python, TensorFlow, Machine Learning, Deep Learning', 'Full-time', 'Ho Chi Minh City', 2500, 4000, 'active', NOW()),
(32, 3, 'Technical Lead', 'Lãnh đạo team phát triển backend', 'System Design, Microservices, Team Management', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(33, 3, 'Mobile Team Lead', 'Quản lý team phát triển ứng dụng di động', 'iOS/Android Development, Team Leadership', 'Full-time', 'Ho Chi Minh City', 3000, 5500, 'active', NOW()),

-- Thêm jobs cho VNG (company_id: 4)
(34, 4, 'Blockchain Developer', 'Phát triển các ứng dụng blockchain', 'Solidity, Web3, Smart Contracts', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(35, 4, 'AI Research Scientist', 'Nghiên cứu và phát triển các giải pháp AI', 'Ph.D. in AI/ML, Research Experience, Publications', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(36, 4, 'Game Art Director', 'Chỉ đạo nghệ thuật cho các dự án game', '3D Modeling, Animation, Art Direction', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),

-- Thêm jobs cho FPT Software (company_id: 5)
(37, 5, 'Solutions Architect', 'Thiết kế giải pháp phần mềm cho khách hàng enterprise', 'System Architecture, Cloud Platforms, Enterprise Solutions', 'Full-time', 'Da Nang', 3000, 5000, 'active', NOW()),
(38, 5, 'DevOps Lead', 'Lãnh đạo team DevOps và xây dựng quy trình CI/CD', 'AWS, Kubernetes, Jenkins, Team Leadership', 'Full-time', 'Da Nang', 2500, 4500, 'active', NOW()),
(39, 5, 'Embedded Systems Engineer', 'Phát triển phần mềm cho hệ thống nhúng', 'C/C++, Embedded Systems, RTOS', 'Full-time', 'Da Nang', 2000, 3500, 'active', NOW());

-- Reset auto increment after insert
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE job_posts AUTO_INCREMENT = 40;
SET FOREIGN_KEY_CHECKS=1;

-- Insert more jobs for top 5 companies (10+ jobs each)
INSERT INTO job_posts (job_id, company_id, title, description, requirements, job_type, location, salary_min, salary_max, status, created_at) VALUES
-- Thêm jobs cho Tiki (company_id: 1)
(40, 1, 'Technical Architect', 'Thiết kế và phát triển kiến trúc hệ thống của Tiki', 'System Design, Microservices, Cloud Architecture', 'Full-time', 'Ho Chi Minh City', 4000, 7000, 'active', NOW()),
(41, 1, 'DevOps Engineer', 'Quản lý và tối ưu hóa hệ thống', 'AWS, Docker, Kubernetes, CI/CD', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(42, 1, 'Security Engineer', 'Đảm bảo an ninh cho hệ thống', 'Security Protocols, Penetration Testing', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(43, 1, 'Machine Learning Engineer', 'Phát triển các mô hình ML', 'Python, TensorFlow, Machine Learning', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(44, 1, 'QA Automation Lead', 'Lãnh đạo team QA tự động', 'Selenium, TestNG, CI/CD Testing', 'Full-time', 'Ho Chi Minh City', 2000, 4000, 'active', NOW()),
(45, 1, 'Technical Product Manager', 'Quản lý sản phẩm kỹ thuật', 'Agile, Technical Background, Product Management', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(46, 1, 'Data Scientist', 'Phân tích dữ liệu và xây dựng mô hình', 'Python, R, Machine Learning, Statistics', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(47, 1, 'iOS Developer', 'Phát triển ứng dụng iOS', 'Swift, iOS SDK, Mobile Development', 'Full-time', 'Ho Chi Minh City', 2000, 4000, 'active', NOW()),
(48, 1, 'Android Developer', 'Phát triển ứng dụng Android', 'Kotlin, Android SDK, Mobile Development', 'Full-time', 'Ho Chi Minh City', 2000, 4000, 'active', NOW()),
(49, 1, 'Fullstack Developer', 'Phát triển full stack', 'React, Node.js, MongoDB', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),

-- Thêm jobs cho MoMo (company_id: 2)
(50, 2, 'Blockchain Developer', 'Phát triển giải pháp blockchain', 'Solidity, Web3, Smart Contracts', 'Full-time', 'Ha Noi', 3000, 5000, 'active', NOW()),
(51, 2, 'AI Engineer', 'Phát triển các giải pháp AI', 'Python, Deep Learning, NLP', 'Full-time', 'Ha Noi', 3000, 5000, 'active', NOW()),
(52, 2, 'System Architect', 'Thiết kế hệ thống thanh toán', 'System Design, Payment Systems', 'Full-time', 'Ha Noi', 4000, 7000, 'active', NOW()),
(53, 2, 'Frontend Tech Lead', 'Lãnh đạo team frontend', 'React, Vue.js, Team Management', 'Full-time', 'Ha Noi', 3000, 5000, 'active', NOW()),
(54, 2, 'Backend Tech Lead', 'Lãnh đạo team backend', 'Java, Microservices, Team Management', 'Full-time', 'Ha Noi', 3000, 5000, 'active', NOW()),
(55, 2, 'Data Engineer', 'Xây dựng pipeline dữ liệu', 'Python, Spark, Big Data', 'Full-time', 'Ha Noi', 2500, 4500, 'active', NOW()),
(56, 2, 'QA Manager', 'Quản lý đội ngũ QA', 'Test Management, Team Leadership', 'Full-time', 'Ha Noi', 2500, 4500, 'active', NOW()),
(57, 2, 'UX Research Lead', 'Nghiên cứu trải nghiệm người dùng', 'User Research, Analytics, UX Design', 'Full-time', 'Ha Noi', 2500, 4500, 'active', NOW()),
(58, 2, 'Infrastructure Engineer', 'Quản lý hạ tầng kỹ thuật', 'Linux, Networking, Cloud', 'Full-time', 'Ha Noi', 2500, 4500, 'active', NOW()),
(59, 2, 'Mobile Architect', 'Thiết kế kiến trúc ứng dụng di động', 'iOS, Android, Mobile Architecture', 'Full-time', 'Ha Noi', 3500, 6000, 'active', NOW()),

-- Thêm jobs cho Sendo (company_id: 3)
(60, 3, 'Data Architect', 'Thiết kế kiến trúc dữ liệu', 'Big Data, Data Modeling, ETL', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(61, 3, 'Cloud Architect', 'Thiết kế giải pháp cloud', 'AWS, Azure, Cloud Solutions', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(62, 3, 'Frontend Tech Lead', 'Lãnh đạo team frontend', 'React, Angular, Team Management', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(63, 3, 'Backend Tech Lead', 'Lãnh đạo team backend', 'Java, Microservices, Team Management', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(64, 3, 'DevOps Manager', 'Quản lý team DevOps', 'AWS, Kubernetes, Team Leadership', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(65, 3, 'Security Manager', 'Quản lý bảo mật hệ thống', 'Security, Risk Management', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(66, 3, 'Mobile Development Manager', 'Quản lý phát triển ứng dụng di động', 'iOS, Android, Team Management', 'Full-time', 'Ho Chi Minh City', 3000, 5500, 'active', NOW()),
(67, 3, 'Data Science Manager', 'Quản lý team Data Science', 'Machine Learning, Team Leadership', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(68, 3, 'Technical Program Manager', 'Quản lý các dự án kỹ thuật', 'Program Management, Agile', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(69, 3, 'Quality Engineering Manager', 'Quản lý chất lượng kỹ thuật', 'QA Automation, Team Leadership', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),

-- Thêm jobs cho VNG (company_id: 4)
(70, 4, 'Game Backend Lead', 'Lãnh đạo phát triển backend game', 'C++, Game Servers, Team Management', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(71, 4, 'Game Client Lead', 'Lãnh đạo phát triển game client', 'Unity, Unreal Engine, Team Management', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(72, 4, 'Technical Director', 'Chỉ đạo kỹ thuật cho game studio', 'Game Development, Team Leadership', 'Full-time', 'Ho Chi Minh City', 5000, 8000, 'active', NOW()),
(73, 4, 'Game Producer', 'Quản lý sản xuất game', 'Game Production, Project Management', 'Full-time', 'Ho Chi Minh City', 3500, 6000, 'active', NOW()),
(74, 4, 'Gameplay Programmer', 'Lập trình gameplay', 'Unity, C#, Game Mechanics', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(75, 4, 'Graphics Engineer', 'Phát triển đồ họa game', 'Computer Graphics, Shaders, OpenGL', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(76, 4, 'Network Engineer', 'Phát triển hệ thống mạng game', 'Networking, Game Servers', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(77, 4, 'Tools Engineer', 'Phát triển công cụ game', 'C++, Python, Game Tools', 'Full-time', 'Ho Chi Minh City', 2500, 4500, 'active', NOW()),
(78, 4, 'Game Analytics Lead', 'Phân tích dữ liệu game', 'Game Analytics, Data Science', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),
(79, 4, 'Game Security Engineer', 'Bảo mật game', 'Game Security, Anti-cheat', 'Full-time', 'Ho Chi Minh City', 3000, 5000, 'active', NOW()),

-- Thêm jobs cho FPT Software (company_id: 5)
(80, 5, 'Project Director', 'Chỉ đạo các dự án phần mềm', 'Project Management, Team Leadership', 'Full-time', 'Da Nang', 4000, 7000, 'active', NOW()),
(81, 5, 'Technical Director', 'Chỉ đạo kỹ thuật', 'System Architecture, Team Leadership', 'Full-time', 'Da Nang', 4000, 7000, 'active', NOW()),
(82, 5, 'AI Solution Architect', 'Thiết kế giải pháp AI', 'AI, Machine Learning, Solution Design', 'Full-time', 'Da Nang', 3500, 6000, 'active', NOW()),
(83, 5, 'Cloud Solution Architect', 'Thiết kế giải pháp cloud', 'AWS, Azure, Cloud Architecture', 'Full-time', 'Da Nang', 3500, 6000, 'active', NOW()),
(84, 5, 'Delivery Manager', 'Quản lý việc delivery dự án', 'Project Delivery, Team Management', 'Full-time', 'Da Nang', 3500, 6000, 'active', NOW()),
(85, 5, 'Software Engineering Manager', 'Quản lý đội ngũ kỹ sư', 'Team Management, Software Development', 'Full-time', 'Da Nang', 3500, 6000, 'active', NOW()),
(86, 5, 'Quality Manager', 'Quản lý chất lượng', 'Quality Assurance, Team Leadership', 'Full-time', 'Da Nang', 3000, 5000, 'active', NOW()),
(87, 5, 'Technical Lead Java', 'Lãnh đạo kỹ thuật Java', 'Java, Spring, Team Management', 'Full-time', 'Da Nang', 2500, 4500, 'active', NOW()),
(88, 5, 'Technical Lead .NET', 'Lãnh đạo kỹ thuật .NET', '.NET, C#, Team Management', 'Full-time', 'Da Nang', 2500, 4500, 'active', NOW()),
(89, 5, 'Mobile Development Manager', 'Quản lý phát triển mobile', 'iOS, Android, Team Management', 'Full-time', 'Da Nang', 3000, 5000, 'active', NOW());

-- Reset auto increment after insert
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE job_posts AUTO_INCREMENT = 90;
SET FOREIGN_KEY_CHECKS=1;
