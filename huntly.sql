-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 28, 2025 lúc 02:56 AM
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
(1, 2, 'TIKI', '52 Ut Tich Street, Ward 4, Tan Binh District, Ho Chi Minh City, Ho Chi Minh 70000, VN', 'TIKI is the leading online retailer in Vietnam, offering seamless end-to-end retail experience.', 'uploads/logo/tiki.jpg', '2025-04-11 17:25:25', '2025-04-15 21:28:53', 'http://tiki.vn/', '1,001-5,000 employees', 'Internet Publishing'),
(2, 3, 'MoMo', 'Phu My Hung Tower - 8 Hoang Van Thai St., Tan Phu Ward, Dist.7, HCMC, Ho Chi Minh City, Ho Chi Minh 70000, VN', 'EMBRACE YOUR SUCCESS', 'uploads/company_logos/company_2_1744736136.png', '2025-04-11 17:25:25', '2025-04-15 21:33:23', 'https://www.momo.vn/', '1,001-5,000 employees', 'Financial Services'),
(3, 4, 'Sendo.vn', 'Block 29B-31B-33B, Tan Thuan Road, Tan Thuan EPZ, Tan Thuan Dong Ward, District 7, Ho Chi Minh city, Ho Chi Minh, Ho Chi Minh 70000, VN', 'Sendo JSC was founded in September 2012, originally an e-commerce project of FPT Online JSC. Currently, Sendo is one of the leading e-commerce platforms in Vietnam and playing as the largest C2C marketplace in local Tier 2 cities, serving millions of customers and hundreds of thousand merchants nationwide.\\n\\n\r\n\r\nHaving invested much in R&D, AI, and Big data to continuously upgrade the technical platform and enhance the customer shopping experience, Sendo has built an ecosystem for buyers, merchants, and third-party logistics providers.', 'uploads/logo/sendo.jpg', '2025-04-11 17:25:25', '2025-04-15 21:37:34', 'https://www.sendo.vn/', '501-1,000 employees', 'Technology, Information and Internet'),
(4, 5, 'VNG Corporation', 'VNG Campus - Number 13 Street, Tan Thuan Export Processing Zone, Ho Chi Minh, Ho Chi Minh City 70000, VN', 'Established in 2004, VNG is the leading homegrown digital ecosystem in Vietnam, with diverse products serving the needs of 100 million customers in Vietnam and many countries worldwide. VNG focuses on four main businesses: online games, communications & media, fintech, and digital business. VNG has developed several digital products that contribute to businesses\' journey of digital transformation and help Vietnamese citizens connect, transact and entertain. At the same time, the company also concentrates on long-term development by researching and exploring further opportunities in Data Centers and AI.\r\n\r\nPeople and Technology are at the core of VNG\'s identity. VNG boasts nearly 4,000 members across 10 cities worldwide. With a shared DNA characterized by the spirit of \"Embracing challenges\", every individual at VNG embodies the qualities of a Starter, always prepared to embark on new endeavors with unwavering enthusiasm. Our passion for leading and being the force of change has driven us to a broader vision - \"Build technologies & Grow people. From Vietnam to the World.\"', 'uploads/logo/vng.jpg', '2025-04-11 17:25:25', '2025-04-22 09:55:07', 'https://vnggames.com/', '1,001-5,000 employees', 'Technology, Information and Internet'),
(5, 6, 'FPT Software', 'FPT Bld., Duy Tan Str., Cau Giay Dist., Hanoi, 10xxx15xx, VN', 'FPT Software, a subsidiary of FPT Corporation, is a global technology and IT services provider headquartered in Vietnam, with USD 1.22 billion in revenue (2024) and over 33,000 employees in 30 countries.\\n\\n\r\n\r\nThe company champions complex business opportunities and challenges with its world-class services in Advanced Analytics, AI, Digital Platforms, Cloud, Hyperautomation, IoT, Low-code, and so on. It has partnered with over 1,100 clients worldwide, more than 130 of which are Fortune Global 500 companies in Aviation, Automotive, Banking, Financial Services and Insurance, Healthcare, Logistics, Manufacturing, Utilities, and more. ', 'uploads/logo/fpt.jpg', '2025-04-11 17:25:25', '2025-04-15 21:45:11', 'http://www.fptsoftware.com/', '10,001+ employees', 'IT Services and IT Consulting'),
(6, 7, 'Shopee', '5 Science Park Dr, Shopee Building, Singapore, Singapore 118265, SG', 'Shopee is the leading e-commerce platform in Southeast Asia and Taiwan. It is a platform tailored for the region, providing customers with an easy, secure and fast online shopping experience through strong payment and logistical support.\r\n\r\nShopee aims to continually enhance its platform and become the region’s e-commerce destination of choice via ongoing product optimisation and localised user-centered strategies. \r\n\r\nShopee, a Sea company, was first launched in Singapore in 2015, and has since expanded its reach to Malaysia, Thailand, Taiwan, Indonesia, Vietnam and the Philippines. Sea is a leader in digital entertainment, e-commerce and digital financial services across Greater Southeast Asia. Sea\'s mission is to better the lives of consumers and small businesses with technology, and is listed on the NYSE under the symbol SE.\\n\\n\r\n\r\nThe Shopee team is rapidly expanding across the region and we are constantly on the lookout for talents who have the passion and drive to become part of a fast-moving and dynamic team.', 'uploads/logo/shopee.jpg', '2025-04-11 17:25:25', '2025-04-15 21:48:06', 'https://shopee.vn/', '5,001-10,000 employees', 'Software Development'),
(9, 10, 'Zalo', 'Lot 3B, Street no. 13, Tân Thuận EPZ, District 7, HCMC, VN', 'At Zalo, we believe Vietnamese engineers can build world-class technology products.\r\n\r\nAs a market leader of a product ecosystem with million users in Vietnam, we build and develop a workplace where responsible, passionate, and dynamic talents thrive. We look forward to working with you to grow vigorously while keep improving your quality of living thanks to working with the best talents, on most successful brands, and in sizable projects that improve millions of Vietnamese lives.', 'uploads/logo/zalo.jpg', '2025-04-15 23:47:46', '2025-04-22 09:56:29', 'https://zalo.me/pc', '1001+', 'Software Development'),
(10, 11, 'Google', 'Mountain View, CA', 'A problem isn\'t truly solved until it\'s solved for all. Googlers build products that help create opportunities for everyone, whether down the street or across the globe. Bring your insight, imagination and a healthy disregard for the impossible. Bring everything that makes you unique. Together, we can build for everyone.', 'uploads/logo/google.jpg', '2025-04-15 23:49:24', '2025-04-22 09:55:55', 'https://about.google/', '1001+', 'Software Development'),
(12, 13, 'Garena', 'Singapore', 'Garena is a leading global online games developer and publisher. Free Fire, its self-developed mobile battle royale title, is the most downloaded mobile game in its genre for six consecutive years, according to Sensor Tower App Performance Insights. The title was also the world’s most downloaded mobile game in 2019, 2021, and again in 2023 and 2024.\r\n\r\nGarena is run by passionate gamers and has a unique understanding of what gamers want. It exclusively licenses and publishes hit titles from global partners – such as Arena of Valor and Call of Duty: Mobile – in selected markets globally. Garena champions social and entertainment experiences through games, enabling its communities to engage and interact. Garena is also a leading esports organiser and hosts some of the world’s biggest esports events.\r\n\r\nGarena is a part of Sea Limited (NYSE:SE), a leading global consumer internet company. In addition to Garena, Sea’s other core businesses include its e-commerce arm, Shopee, and digital financial services arm, SeaMoney. Sea’s mission is to better the lives of consumers and small businesses with technology.', 'uploads/logo/garena.png', '2025-04-16 00:02:05', '2025-04-22 16:34:04', 'http://www.garena.com/', '1001+', 'Entertainment Providers'),
(13, 14, 'Nhân Phan\'s Company', NULL, NULL, 'uploads/logo/defaultlogo.jpg', '2025-04-26 18:14:53', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_applications`
--

CREATE TABLE `job_applications` (
  `application_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `seeker_id` int(11) DEFAULT NULL,
  `applicant_email` varchar(255) DEFAULT NULL,
  `applicant_phone` varchar(20) DEFAULT NULL,
  `status` enum('pending','reviewing','shortlisted','hired','rejected') DEFAULT 'pending',
  `admin_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
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

INSERT INTO `job_applications` (`application_id`, `job_id`, `seeker_id`, `applicant_email`, `applicant_phone`, `status`, `admin_status`, `resume_path`, `cover_letter`, `employer_notes`, `created_at`, `updated_at`, `interview_date`, `interview_location`, `source`) VALUES
(2, 2, 8, 'applicant1@example.com', '0987123456', 'pending', 'approved', 'uploads/resumes/applicant1_cv.pdf', 'Tôi có kinh nghiệm làm việc với Laravel và các framework PHP...', NULL, '2025-04-11 17:25:25', '2025-04-15 11:54:56', NULL, NULL, 'direct'),
(3, 3, 9, 'applicant2@example.com', '0987123457', 'reviewing', 'approved', 'uploads/resumes/applicant2_cv.pdf', 'Tôi đam mê phát triển ứng dụng di động và mong muốn được học hỏi tại MoMo...', NULL, '2025-04-11 17:25:25', '2025-04-15 16:43:16', NULL, NULL, 'direct'),
(4, 4, 9, 'applicant2@example.com', '0987123457', 'pending', 'approved', 'uploads/resumes/applicant2_cv.pdf', 'Tôi mong muốn được tham gia vào đội ngũ phát triển của MoMo...', NULL, '2025-04-11 17:25:25', '2025-04-15 11:55:00', NULL, NULL, 'direct');

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
(7, 'Engineering', 'engineering', 'Engineering, technical roles outside of IT'),
(8, 'Agriculture', '', NULL),
(9, 'Business', 'business', 'Market analysis, financial strategy, and business operations'),
(10, 'HSE', 'hse', 'Occupational health, workplace safety, and environmental protection'),
(11, 'Translation', 'translation', 'Converting written or spoken content between languages, ensuring accuracy and cultural relevance'),
(14, 'Security', 'security', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_posts`
--

CREATE TABLE `job_posts` (
  `job_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
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
  `status` enum('pending','active','closed','draft','rejected') DEFAULT 'pending',
  `admin_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `application_deadline` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `job_posts`
--

INSERT INTO `job_posts` (`job_id`, `company_id`, `employer_id`, `category_id`, `title`, `description`, `requirements`, `benefits`, `job_type`, `work_model`, `experience_level`, `location`, `salary_min`, `salary_max`, `hide_salary`, `pdf_path`, `status`, `admin_status`, `application_deadline`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 2, 'HSE Compliance and SOP', '• Kiểm soát hoạt động tuân thủ tại TNSL. Hỗ trợ, hướng dẫn kịp thời về các sự cố liên quan đến HSSE\r\n\r\n• Ngăn ngừa thất thoát COD & tài sản đối với các hành vi gian lận tại các địa điểm làm việc của TNSL.\r\n\r\n• Phối hợp cùng các phòng ban liên quan nhằm phát triển/xây dựng và cải thiện quy trình trong vận hành (SOP)\r\n\r\n• Thực hiện các hoạt động để nhận diện mối nguy, đánh giá rủi ro,...Đề xuất các biện pháp khắc phục kịp thời nhằm ngăn ngừa sự cố/tai nạn xảy ta tại nơi làm việc\r\n\r\n• Kiểm soát, giám sát các quy trình thủ tục trong công tác ATVSLĐ, Sức khỏe, Môi Trường, an ninh ... tại địa điểm làm việc của TNSL', '• Tốt nghiệp trung cấp trở lên\r\n\r\n• Có khả năng viết được quy trình và giám sát việc thực hiện quy trình tại công ty.\r\n\r\n• Có kinh nghiệm 01 năm trong lĩnh vực HSE', 'Bảo vệ sức khỏe và tính mạng: Góp phần tạo nên môi trường làm việc an toàn, lành mạnh.\r\n\r\nNhu cầu cao trong nhiều lĩnh vực: Cơ hội việc làm ổn định ở xây dựng, sản xuất, dầu khí, v.v.\r\n\r\nỔn định nghề nghiệp: Luôn cần thiết do yêu cầu tuân thủ quy định pháp luật.\r\n\r\nCông việc đa dạng: Tham gia đào tạo, đánh giá rủi ro, ứng phó khẩn cấp, kiểm tra an toàn.\r\n\r\nTạo ra ảnh hưởng thực tế: Giúp ngăn ngừa tai nạn lao động và bảo vệ môi trường.', 'Full-time', 'onsite', 'entry', 'Ha Noi', 1500.00, 2500.00, 0, 'uploads/job_pdfs/1744512810_chabong_shop.pdf', 'active', 'approved', '2025-05-30', '2025-04-11 17:25:25', '2025-04-22 09:43:14'),
(3, 2, 3, 1, 'Software Engineer (Backend Skill)', '- Developing impactful projects using Java technologies (backend, database, microservices);\\n\r\n- Software/Services/Module must able extendable, maintained, scalable;\\n\r\n- Building our backend that can serve at scale;\\n\r\n- Driving technical collaborations with product teams;\\n\r\n- Designing the architecture for our new products and services;\\n\r\n- Delivering at all phases of the software lifecycle;\\n\r\n- Researching and developing new technologies, focus on mobile;\\n\r\n- Providing technical guidance and coaching to junior members in case middle role.', '- Degree in Computer Science or related fields;\\n\r\n- Very strong Java foundation;\\n\r\n- Problem-solving skills;\\n\r\n- Experience with architectures that support scaling;\\n\r\n- Teamwork spirit.', '', 'Full-time', 'hybrid', 'entry', 'Ho Chi Minh City', 1800.00, 2800.00, 0, NULL, 'active', 'approved', NULL, '2025-04-11 17:25:25', '2025-04-22 09:43:17'),
(4, 2, 3, 1, '(Senior) Fullstack Developer, ReactJS & .NET', 'We’re looking for a skilled Fullstack developer to work closely with our design and development teams to build and maintain high-quality MoMo web applications. The ideal candidate will have a strong background in front-end, back-end development, including proficiency in HTML, CSS, JavaScript, and experience with front-end frameworks such as NextJS, React.js.\r\n\r\nWhat you will do:\r\n\r\n- Develop responsive and user-friendly web interfaces using modern frontend frameworks using ReactJS;\r\n- Develop web applications using micro architecture and deploy on AWS architecture;\r\n- Work with back-end developers to integrate UI components with APIs and databases;', '- Minimum 2 years of experience in full stack developerKnowledge .NET Framework, .NET Core C# development;\r\n- Have experience working, designing PostgreSQL databases;\r\n- Experience with Strapi or similar headless CMS for building custom APIs and - managing content;\r\n- Strong knowledge of React.js and Next.js, including adherence to Next.js code conventions;', '', 'Full-time', 'onsite', 'senior', 'Ho Chi Minh City', 1200.00, 2000.00, 0, NULL, 'active', 'approved', NULL, '2025-04-11 17:25:25', '2025-04-22 09:43:19'),
(6, 4, 5, 1, 'DevOps Engineer', '- Deploy and manage on-premise and cloud infrastructure AWS, GCP across development, staging, and production environments.\r\n- Implement infrastructure as code (IaC) and manage cloud resources efficiently.\r\n- Automate deployment and integration pipelines using modern DevOps tools\r\n- Enhance observability by setting up logging, monitoring, and alerting solutions.\r\n- Collaborate with development, security, and operations teams to streamline the software development life cycle (SDLC).\r\n- Troubleshoot and resolve issues during system operation.\r\n- Ensure security best practices are followed in cloud and containerized environments.', '- At least 1-2 years of experience in relevant fields with a strong background in Linux systems.\r\n- Experience with CI/CD, DevOps automation, and monitoring tools (e.g., GitLab, Grafana, Prometheus, Terraform, ArgoCD, ELK).\r\n- Understand basic application performance metrics: Latency, throughput, and the ability to identify the problem\r\n- Understanding of UNIX/ Linux system internals, TCP/ IP networking, load balancers, web servers, and caching.\r\n- Basic Knowledge of modern architecture-related tools, including API gateways, reverse proxies, and service proxies for cloud-native applications.\r\n- Ability to containerize applications, write optimized Dockerfiles, and troubleshoot containerized application issues in local environments or Kubernetes clusters.\r\n- Proficiency in scripting or coding (Bash, Python, Go, etc.).', 'Increased Efficiency and Automation: This role optimizes deployment and infrastructure management processes using automation tools and Infrastructure as Code (IaC), reducing manual effort and deployment time.\r\n\r\nImproved Stability and Security: By setting up monitoring, logging, and alerting solutions, issues can be detected early and resolved quickly, ensuring systems remain secure and compliant.\r\n\r\nScalability and Flexibility: Deploying on cloud platforms like AWS or GCP allows systems to easily scale and adapt to changing organizational needs.', 'Full-time', 'hybrid', 'mid', 'Ho Chi Minh City', 2000.00, 3500.00, 0, NULL, 'active', 'approved', NULL, '2025-04-11 17:25:25', '2025-04-22 09:43:25'),
(7, 5, 6, 11, 'Comtor N3', '• Là Cầu nối ngôn ngữ giữa đội dự án với khách hàng Nhật\r\n\r\n• Phiên dịch (Nhật- Việt, Việt-Nhật) cho các buổi họp cuộc họp nội bộ và các buổi meeting với Khách hàng Nhật của đội dự án\r\n\r\n• Dịch các loại tài liệu đã tiếp nhận theo yêu cầu đảm bảo đúng các nguyên tắc, quy trình dịch thuật của Công ty.\r\n\r\n• Trao đổi thông tin với khách hàng Nhật qua email, điện thoại.\r\n\r\n• Tiếp nhận và quản lý tài liệu, yêu cầu từ Khách hàng Nhật (tiếng Nhật), từ đội dự án (tiếng Việt hoặc tiếng Anh)\r\n\r\n• Dịch các email trao đổi giữa đội dự án và Khách hàng Nhật (Nhật-Việt, Việt/Anh-Nhật)', '• Tiếng Nhật tương đương N2, N1. Thành thạo cả 4 kỹ năng nghe, nói, đọc, viết\r\n\r\n• Tốt nghiệp chuyên ngành tiếng Nhật\r\n\r\n• Ưu tiên ứng viên có kinh nghiệm trong lĩnh vực IT hoặc có am hiểu cơ bản về lĩnh vực\r\n\r\n• Thích học tiếng Nhật và yêu thích văn hóa Nhật Bản, thích giao tiếp với người Nhật\r\n\r\n• Có khả năng xử lý thông tin và nhận biết vấn đề nhanh, đưa ra ý kiến để cải thiện chất lượng công việc cùng với managers\r\n\r\n• Kỹ năng quản lý tốt\r\n\r\n• Năng động, hoạt bát, có tinh thần trách nhiệm cao trong công việc\r\n\r\n• Đã từng đi Nhật là một lợi thế', 'Cơ hội nghề nghiệp: Công việc này giúp bạn mở rộng cơ hội trong các ngành dịch thuật và quản lý dự án quốc tế.\r\n\r\nĐược tham gia vào quy trình dự án: Bạn là cầu nối quan trọng giữa đội ngũ dự án và khách hàng, giúp tăng cường hiệu quả làm việc.\r\n\r\nHọc hỏi và phát triển chuyên môn: Bạn sẽ có cơ hội học hỏi về các kỹ thuật và công cụ dịch thuật, đồng thời nắm bắt các yêu cầu kỹ thuật trong các dự án công nghệ.\r\n\r\nThu nhập hấp dẫn: Với kỹ năng đặc thù và sự quan trọng trong các dự án quốc tế, công việc này thường có mức lương khá hấp dẫn.', 'Contract', 'onsite', 'mid', 'Binh Dinh', 1800.00, 3000.00, 0, NULL, 'active', 'approved', NULL, '2025-04-11 17:25:25', '2025-04-22 09:43:28'),
(8, 6, 7, 2, 'Finance Operations (Bank) - Operations, ShopeePay', '- Daily reconcile data between ShopeePay system and Partner system.\\n\r\n- Monthly make payments for Partners.\\n\r\n- Monitor and cross-check internal reports to ensure their accuracy, consistency, and timely detection of system errors, minimizing loss.\\n\r\n- Coordinate with other departments to check and resolve the problem related to customers’ E–Wallet balances.\\n\r\n- Generate daily, weekly, monthly & other ad-hocs reports.\\n\r\n- Take part in new projects; communicate and collaborate closely with stakeholders to regularly update and understand new features\\n\r\n- Do monthly management reports.\\n\r\n- Other ad-hoc work, and internal reports as needed.', '- Good data processing skills, especially Python, SQL.\\n\r\n- Good number sense, and strong attention to detail.\\n\r\n- Flexibility with changes.\\n\r\n- Experience: at least 2 years of relevant experience.\\n\r\n- Education Background: College/University graduates; Data Science, Accounting, finance and banking are advantages.\\n\r\n- Language skills: Good command of English (4 Skills), Chinese is an advantage.\\n\r\n- Others: Number sense, strong attention to detail, flexibility to changes.', NULL, 'Full-time', 'onsite', 'mid', 'Ha Noi', 1500.00, 2400.00, 0, NULL, 'active', 'approved', NULL, '2025-04-11 17:25:25', '2025-04-22 09:43:30'),
(10, 2, 3, 1, 'Java Developer', '- Develop and enhance large-scale systems using Java technologies: Gift, payments, alert system,… Contribute to all phases of the development lifecycle;\r\n- Maintain existing system and develop new functions as required;\r\n- Discuss with the project team to analyze and understand requirements of the products;\r\n- Assists prepare the proposal on business enhancement as well as potential product development;\r\n- Assists prepare and manage the technical documents.;\r\n- Support the estimation of new projects/enhancements;', ' Bachelor’s Degree of Computer Science, Engineering, or related field;\r\n- 2+ year experience in Backend programming;\r\n- Master in Java language, object-oriented programming;\r\n- Proficient in SQL: Oracle or any other equivalent databases;\r\n- Experience in using message systems: RabbitMQ, Kafka or any other equivalent;\r\n- Passionate for technology, always eager to learn;', '- Hands-on with large-scale systems: Gain experience in building and maintaining enterprise-level platforms like payment, gift, and alert systems.\r\n\r\n- Full SDLC exposure: Involved in all development phases – from requirements to deployment.\r\n\r\n- Stronger analytical & communication skills: Collaborate with teams to understand business needs and propose enhancements.', 'Full-time', 'remote', 'entry', 'Ho Chi Minh', 1000.00, 3000.00, 0, 'uploads/job_pdfs/1744666371_Assignment 3 - Job Portal.pdf', 'pending', 'rejected', '2025-05-30', '2025-04-14 21:32:51', '2025-04-15 22:22:22'),
(11, 2, 3, 9, 'Team Leader - IT Business Analyst, Securities', 'Market & Trend Analysis:\r\n- Conduct in-depth analysis of the securities industry, market dynamics, and customer behaviors to identify new business opportunities.\r\n- Develop comprehensive business cases that outline problems, opportunities, and strategic directions for the company.\r\n\r\nCross-Functional Collaboration:\r\n- Work closely with internal teams and other business units to define and gather business requirements.\r\n- Collaborate with Product and Tech teams to develop and improve securities products, ensuring they meet market needs and align with strategic objectives.\r\n- Support daily operations by providing guidance and solutions to ensure efficient workflow and seamless execution of initiatives.\r\n- Track and monitor the successful implementation of new initiatives, ensuring alignment with company goals and delivering measurable impact.\r\n\r\nPerformance Monitoring:\r\n- Maintain and analyze key performance metrics include business, product, technical metrics.\r\n\r\n- Data Analysis & Recommendations:\r\nRecommend solutions to meet the business requirements based on data.\r\n- Support strategic planning and operational efficiency by offering data-backed solutions and improvement strategies.', '- Bachelor’s degree in Business, Finance, Economics, Data Science, or a related field.\r\n- 5+ years of experience in business analysis, preferably in the securities or financial services industry.\r\n- Strong analytical and problem-solving skills with proficiency in data analysis tools and techniques, design in UML, familiar with at least one among Use-cases diagram, Activity Diagram, State - - Diagram, Sequence Diagram, able to understand and design a Relation Entity Diagram.', '- Industry Insights: Deepen knowledge of market trends, customer behavior, and the securities industry.\r\n- Strategic Impact: Contribute directly to business direction and growth through well-researched proposals.\r\n- Cross-functional exposure: Collaborate with multiple departments—Product, Tech, Operations—for well-rounded experience.\r\n- Data-driven skills: Strengthen your ability to analyze KPIs and make strategic, evidence-based decisions.', 'Full-time', 'onsite', 'senior', 'Ho Chi Minh City', 1000.00, 2000.00, 0, NULL, 'pending', 'rejected', '2025-10-10', '2025-04-14 21:35:13', '2025-04-27 19:02:43'),
(14, 12, 13, 1, 'Intern, Software Engineer', '- Assist in the development, maintenance, and optimization of backend services\r\n\r\n- Work closely with engineers to design, implement, and test scalable APIs and system components\r\n\r\n- Collaborate with cross-functional teams to support feature development, debugging, and performance enhancements\r\n\r\n- Contribute to code reviews, testing, and documentation to ensure high-quality software development', '- Currently pursuing a degree in Computer Science, Information Systems or related science/tech fields\r\n\r\n- Familiarity with the following languages and practice on a regular basis: Go, Python, SQL; Knowledge and experience in Docker and/or Kubernetes (k8s) is preferable\r\n\r\n- Basic knowledge of computer architectures, data structures and algorithms\r\n\r\n- Have an open-minded, agile and proactive mindset with strong willingness to learn\r\n\r\n- Have good team communication and collaboration skills\r\n\r\n- Fluent in English as the main working language\r\n\r\n- Please indicate the internship period and whether it will be on a part-time or full-time basis on your resume', '', 'Internship', 'onsite', 'entry', 'Singapore', 1000.00, 2000.00, 0, NULL, 'active', 'approved', NULL, '2025-04-16 00:06:48', '2025-04-27 17:32:52'),
(15, 12, 13, 5, '[HCM, FC Online] Collaborator, Graphic Design', '- Chịu trách nhiệm thiết kế đồ họa theo yêu cầu của dự án (Website, microsite,…)\r\n\r\n- Phát triển ý tưởng và thực hiện concept cho các dự án marketing, content online và offline… theo yêu cầu của sản phẩm.\r\n\r\n- Hỗ trợ thiết kế giao diện web, ứng dụng (UI/UX) nếu có kinh nghiệm.\r\n\r\n- Phối hợp với team Marketing để triển khai các chiến dịch truyền thông hiệu quả.\r\n\r\n- Đảm bảo tiến độ và chất lượng thiết kế theo yêu cầu của công ty.', '- Sinh viên sắp tốt nghiệp/mới tốt nghiệp từ các trường về đào tạo truyền thông đa phương tiện, đã có ít nhất 6 tháng kinh nghiệm đi làm (thực tập/part-time/freelancer) trong quá trình đi học/sau tốt nghiệp. Có thể làm việc fulltime tại văn phòng.\r\n\r\n- Đam mê bóng đá \r\n\r\n- Có kinh nghiệm thiết kế banner/poster.\r\n\r\n- Có tư duy thẩm mỹ, bố cục, màu sắc, font chữ, phong cách thiết kế phù hợp, vẽ tay tốt là một lợi thế. Có kiến thức chuyên sâu và sử dụng thành thạo các công nghệ, phần mềm mới nhất để sản xuất nội dung theo phong cách hiện đại (Adobe Photoshop, Adobe Illustrator, Figma..)\r\n\r\n- Chăm chỉ, có tinh thần trách nhiệm, có tính cam kết và chịu được áp lực công việc cao.', '', 'Full-time', 'onsite', 'entry', 'Ho Chi Minh City', 400.00, 800.00, 0, NULL, 'active', 'approved', NULL, '2025-04-16 00:09:57', '2025-04-27 17:33:17'),
(16, 9, 10, 14, 'Security Compliance Officer', '- Establish, maintain, monitor and improve Information Security Management System (ISMS) according to international standards.\r\n\r\n- Establish security policies, processes and procedures to ensure compliance with the organization\'s security requirements and applicable government laws.\r\n\r\n- Assess security trends, evolving threats and vulnerabilities; implement a risk assessment and remediation plan; coordinate with related parties to advise on remediation.\r\n\r\n- Establish criteria to develop and train employees to increase security awareness with the best practices and company regulations/policies.\r\n\r\n- Research and develop the security standards and best practices; Implement security improvements by assessing current scenarios, trends, and maintaining security controls.', '- Bachelor’s degree in information security/security, Audit/Information Technology\r\n\r\n- Knowledge of security, computer and network security, authentication, security protocols.\r\n\r\n- Knowledge of IT Security Compliance.\r\n\r\n- Experienced in implementing, managing and operating information security policies in one of the fields of financial/service/telecommunications organizations\r\n\r\n- Knowledge and experience in evaluating internal control activities on IT security platforms.', '', 'Full-time', 'onsite', 'mid', 'Ho Chi Minh City', 2500.00, 4000.00, 0, NULL, 'active', 'approved', NULL, '2025-04-16 00:22:39', '2025-04-27 18:59:02'),
(17, 10, 11, 1, 'Software Engineer II, Full Stack, Google Ads', 'Google\'s software engineers develop the next-generation technologies that change how billions of users connect, explore, and interact with information and one another. Our products need to handle information at massive scale, and extend well beyond web search. We\'re looking for engineers who bring fresh ideas from all areas, including information retrieval, distributed computing, large-scale system design, networking and data storage, security, artificial intelligence, natural language processing, UI design and mobile; the list goes on and is growing every day. As a software engineer, you will work on a specific project critical to Google’s needs with opportunities to switch teams and projects as you and our fast-paced business grow and evolve. We need our engineers to be versatile, display leadership qualities and be enthusiastic to take on new problems across the full-stack as we continue to push technology forward.', '- Bachelor’s degree or equivalent practical experience.\r\n\r\n- 1 year of experience with software development in one or more programming languages (e.g., Python, C, C++, Java, JavaScript).\r\n\r\n- 1 year of experience with data structures or algorithms.\r\n\r\n- 1 year of experience with full stack development, across back-end such as Java, Python, GO, or C++ codebases, and front-end experience including JavaScript or TypeScript, HTML, CSS or equivalent.', '', 'Full-time', 'onsite', 'mid', 'London', 3000.00, 5000.00, 0, NULL, 'active', 'approved', NULL, '2025-04-16 00:29:02', '2025-04-27 17:36:38'),
(18, 10, 11, 9, 'Chuyên gia giải pháp video, Nhóm Giải pháp quảng cáo gTech', 'Bộ phận Quảng cáo gTech chịu trách nhiệm cung cấp tất cả dịch vụ hỗ trợ, truyền thông và kỹ thuật cho khách hàng thuộc mọi quy mô đối với toàn bộ các sản phẩm Quảng cáo của Google. Chúng tôi giúp khách hàng khai thác triệt để các sản phẩm Quảng cáo và sản phẩm dành cho Nhà xuất bản, đồng thời hướng dẫn khách hàng khi họ cần trợ giúp. Chúng tôi cung cấp một loạt các dịch vụ, từ việc giúp khách hàng tự giải quyết vấn đề hiệu quả hơn và hỗ trợ ngay trong sản phẩm, cho đến nâng cao chất lượng hỗ trợ thông qua việc tương tác, thiết lập tài khoản và triển khai chiến dịch quảng cáo, cung cấp giải pháp truyền thông theo nhu cầu kinh doanh và tiếp thị của khách hàng, cũng như giải pháp kỹ thuật và đo lường phức tạp, đồng thời hỗ trợ tư vấn cho các khách hàng lớn. Các giải pháp này có thể được thiết kế riêng và điều chỉnh phù hợp với từng khách hàng, hoặc có thể mở rộng cho hàng triệu khách hàng trên toàn thế giới. Dựa trên nhu cầu ngày càng tăng của khách hàng đối với dịch vụ quảng cáo, chúng tôi hợp tác với nhóm Bán hàng, nhóm Sản phẩm và Kỹ thuật tại Google để phát triển những giải pháp, công cụ và dịch vụ tốt hơn, nhằm cải thiện sản phẩm và nâng cao trải nghiệm cho khách hàng. Là một bộ phận liên ngành và hoạt động trên toàn cầu, chúng tôi đảm bảo khách hàng nhận được lợi tức đầu tư tối ưu khi đồng hành cùng Google và chúng tôi sẽ luôn là một đối tác đáng tin cậy.', '- Bằng cử nhân hoặc kinh nghiệm thực tế tương đương.\r\n\r\n- 2 năm kinh nghiệm làm việc trong lĩnh vực truyền thông kỹ thuật số hoặc đưa ra giải pháp tiếp thị/quảng cáo kỹ thuật số, triển khai và đo lường hiệu quả của các chiến dịch, cũng như cung cấp giải pháp cho khách hàng.\r\n\r\n- Có kinh nghiệm phân tích dữ liệu, diễn giải các tập dữ liệu phức tạp, xác định xu hướng và trình bày kết quả tìm được theo cách lôi cuốn, thuyết phục.\r\n\r\n- Có kinh nghiệm đo lường hiệu quả tiếp thị.\r\n\r\n- Có kiến thức về các sản phẩm video, thị trường quảng cáo dựa trên hiệu suất và thương hiệu hoặc bối cảnh quảng cáo trực tuyến.', '', 'Full-time', 'onsite', 'mid', 'Ho Chi Minh City', 1000.00, 2500.00, 0, NULL, 'active', 'approved', NULL, '2025-04-16 00:31:59', '2025-04-27 17:36:58');

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
(6, 3, 'Job Post Approved', 'Your job posting \"Mobile Developer\" has been approved', 'approval', 3, 1, '2025-04-11 17:25:25'),
(7, 3, 'New Application', 'Jane Applicant has applied for your \"QA Engineer\" position', 'application', 4, 0, '2025-04-14 22:08:40'),
(8, 9, 'Application Not Forwarded', 'Your application for the job \"Mobile Developer\" was not forwarded to the employer.', 'application', 3, 0, '2025-04-14 22:09:09'),
(9, 3, 'Job Post Rejected', 'Your job posting \"Farmer\" has been rejected. Please review and update it.', 'approval', 11, 0, '2025-04-14 22:10:11'),
(10, 3, 'Job Post Approved', 'Your job posting \"Artist\" has been approved and is now visible to job seekers.', 'approval', 12, 0, '2025-04-14 22:31:13'),
(11, 3, 'Job Post Rejected', 'Your job posting \"Designer\" has been rejected. Please review and update it.', 'approval', 10, 0, '2025-04-14 22:31:42'),
(12, 3, 'Job Post Rejected', 'Your job posting \"Artist\" has been rejected. Please review and update it before resubmitting.', '', 12, 0, '2025-04-15 10:57:30'),
(13, 3, 'Job Post Approved', 'Your job posting \"Artist\" has been approved and is now visible to job seekers.', 'approval', 12, 0, '2025-04-15 11:00:45'),
(14, 3, 'Job Post Rejected', 'Your job posting \"Artist\" has been rejected. Please review and update it before resubmitting.', 'approval', 12, 0, '2025-04-15 11:01:19'),
(15, 2, 'New Application', 'John Applicant has applied for your \"Backend Developer\" position', 'application', 2, 0, '2025-04-15 11:12:40'),
(16, 8, 'Application Not Forwarded', 'Your application for the job \"Backend Developer\" was not forwarded to the employer.', 'application', 2, 0, '2025-04-15 11:14:50'),
(17, 9, 'Application Not Forwarded', 'Your application for the job \"QA Engineer\" was not forwarded to the employer.', 'application', 4, 0, '2025-04-15 11:15:35'),
(18, 3, 'New Application', 'Jane Applicant has applied for your \"QA Engineer\" position', 'application', 4, 0, '2025-04-15 11:15:42'),
(19, 8, 'Application Approved', 'Your application for \"Backend Developer\" has been approved by admin.', '', 2, 0, '2025-04-15 11:26:45'),
(20, 2, 'New Application Available', 'A new application from John Applicant for \"Backend Developer\" is available for review.', '', 2, 0, '2025-04-15 11:26:45'),
(21, 9, 'Application Rejected', 'Your application for \"QA Engineer\" has been rejected by admin.', '', 4, 0, '2025-04-15 11:27:19'),
(22, 9, 'Application Approved', 'Your application for \"QA Engineer\" has been approved by admin.', '', 4, 0, '2025-04-15 11:27:26'),
(23, 3, 'New Application Available', 'A new application from Jane Applicant for \"QA Engineer\" is available for review.', '', 4, 0, '2025-04-15 11:27:26'),
(24, 9, 'Application Rejected', 'Your application for \"QA Engineer\" has been rejected by admin.', '', 4, 0, '2025-04-15 11:27:50'),
(25, 9, 'Application Approved', 'Your application for \"QA Engineer\" has been approved by admin.', '', 4, 0, '2025-04-15 11:27:53'),
(26, 3, 'New Application Available', 'A new application from Jane Applicant for \"QA Engineer\" is available for review.', '', 4, 0, '2025-04-15 11:27:53'),
(27, 8, 'Application Rejected', 'Your application for \"Backend Developer\" has been rejected by admin.', '', 2, 0, '2025-04-15 11:35:06'),
(28, 9, 'Application Rejected', 'Your application for \"QA Engineer\" has been rejected by admin.', '', 4, 0, '2025-04-15 11:35:14'),
(29, 8, 'Application Approved', 'Your application for \"Backend Developer\" has been approved by admin.', '', 2, 0, '2025-04-15 11:54:56'),
(30, 2, 'New Application Available', 'A new application from John Applicant for \"Backend Developer\" is available for review.', '', 2, 0, '2025-04-15 11:54:56'),
(31, 9, 'Application Approved', 'Your application for \"Mobile Developer\" has been approved by admin.', '', 3, 0, '2025-04-15 11:54:58'),
(32, 3, 'New Application Available', 'A new application from Jane Applicant for \"Mobile Developer\" is available for review.', '', 3, 0, '2025-04-15 11:54:58'),
(33, 9, 'Application Approved', 'Your application for \"QA Engineer\" has been approved by admin.', '', 4, 0, '2025-04-15 11:55:00'),
(34, 3, 'New Application Available', 'A new application from Jane Applicant for \"QA Engineer\" is available for review.', '', 4, 0, '2025-04-15 11:55:00'),
(35, 11, 'Job Post Approved', 'Your job posting \"Chuyên gia giải pháp video, Nhóm Giải pháp quảng cáo gTech\" has been approved and is now visible to job seekers.', 'approval', 18, 0, '2025-04-22 09:41:55'),
(36, 11, 'Job Post Approved', 'Your job posting \"Software Engineer II, Full Stack, Google Ads\" has been approved and is now visible to job seekers.', 'approval', 17, 0, '2025-04-22 09:41:56'),
(37, 10, 'Job Post Approved', 'Your job posting \"Security Compliance Officer\" has been approved and is now visible to job seekers.', 'approval', 16, 0, '2025-04-22 09:41:58'),
(38, 13, 'Job Post Approved', 'Your job posting \"[HCM, FC Online] Collaborator, Graphic Design\" has been approved and is now visible to job seekers.', 'approval', 15, 0, '2025-04-22 09:42:00'),
(39, 13, 'Job Post Approved', 'Your job posting \"Intern, Software Engineer\" has been approved and is now visible to job seekers.', 'approval', 14, 0, '2025-04-22 09:42:02'),
(40, 2, 'Job Post Approved', 'Your job posting \"HSE Compliance and SOP\" has been approved and is now visible to job seekers.', 'approval', 2, 0, '2025-04-22 09:43:14'),
(41, 3, 'Job Post Approved', 'Your job posting \"Software Engineer (Backend Skill)\" has been approved and is now visible to job seekers.', 'approval', 3, 0, '2025-04-22 09:43:17'),
(42, 3, 'Job Post Approved', 'Your job posting \"(Senior) Fullstack Developer, ReactJS & .NET\" has been approved and is now visible to job seekers.', 'approval', 4, 0, '2025-04-22 09:43:19'),
(43, 5, 'Job Post Approved', 'Your job posting \"DevOps Engineer\" has been approved and is now visible to job seekers.', 'approval', 6, 0, '2025-04-22 09:43:25'),
(44, 6, 'Job Post Approved', 'Your job posting \"Comtor N3\" has been approved and is now visible to job seekers.', 'approval', 7, 0, '2025-04-22 09:43:28'),
(45, 7, 'Job Post Approved', 'Your job posting \"Finance Operations (Bank) - Operations, ShopeePay\" has been approved and is now visible to job seekers.', 'approval', 8, 0, '2025-04-22 09:43:30'),
(46, 11, 'Job Post Approved', 'Your job posting \"Chuyên gia giải pháp video, Nhóm Giải pháp quảng cáo gTech\" has been approved and is now visible to job seekers.', 'approval', 18, 0, '2025-04-22 16:31:40'),
(47, 11, 'Job Post Approved', 'Your job posting \"Software Engineer II, Full Stack, Google Ads\" has been approved and is now visible to job seekers.', 'approval', 17, 0, '2025-04-22 16:31:42'),
(48, 10, 'Job Post Approved', 'Your job posting \"Security Compliance Officer\" has been approved and is now visible to job seekers.', 'approval', 16, 0, '2025-04-22 16:31:44'),
(49, 13, 'Job Post Approved', 'Your job posting \"[HCM, FC Online] Collaborator, Graphic Design\" has been approved and is now visible to job seekers.', 'approval', 15, 0, '2025-04-22 16:31:45'),
(50, 13, 'Job Post Approved', 'Your job posting \"Intern, Software Engineer\" has been approved and is now visible to job seekers.', 'approval', 14, 0, '2025-04-22 16:31:47');

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
  `avatar_path` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `verification_token` varchar(100) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `full_name`, `role`, `phone`, `avatar_path`, `active`, `created_at`, `updated_at`, `verification_token`, `token_expiry`, `email_verified_at`) VALUES
(1, 'admin@huntly.com', '$2y$10$Tn/0xi2s.OElsEgYTieQX.mcyzYyuBcGYHB8f3eQKkaBH8JRvhh8e', 'Admin User', 'admin', '1234567890', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(2, 'tiki@example.com', '$2y$10$Tn/0xi2s.OElsEgYTieQX.mcyzYyuBcGYHB8f3eQKkaBH8JRvhh8e', 'Tiki Employer', 'company_admin', '0987654321', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(3, 'momo@example.com', '$2y$10$Tn/0xi2s.OElsEgYTieQX.mcyzYyuBcGYHB8f3eQKkaBH8JRvhh8e', 'MoMo Employer', 'company_admin', '0987654322', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(4, 'sendo@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Sendo Employer', 'company_admin', '0987654323', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(5, 'vng@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'VNG Employer', 'company_admin', '0987654324', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(6, 'fpt@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'FPT Employer', 'company_admin', '0987654325', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(7, 'shopee@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Shopee Employer', 'company_admin', '0987654326', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(8, 'applicant1@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'John Applicant', 'job_seeker', '0987123456', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(9, 'applicant2@example.com', '$2y$10$IZe/hpLEGpPkjqBnOw5.wON.JqAUD9DjLQEi/OKh0ghjLH6pGYcP6', 'Jane Applicant', 'job_seeker', '0987123457', 'assets/images/defaultavatar.jpg', 1, '2025-04-11 17:25:25', '2025-04-15 16:26:45', NULL, NULL, NULL),
(10, 'zalo@example.com', '$2y$10$qcDT.LEs.bvlthJxooW0tu9.8FrFjypObri7q/Wu8tj97Ym5GwRCq', 'ZaloHR', 'company_admin', '0123456789', 'assets/images/defaultavatar.jpg', 1, '2025-04-15 23:47:46', NULL, NULL, NULL, NULL),
(11, 'google@example.com', '$2y$10$E3A8TTSPUz4fzYZeMucUl.tCpVE9q7zBuocM47Vk4/vzXKxq.gNL.', 'GgHR', 'company_admin', '0213456789', 'assets/images/defaultavatar.jpg', 1, '2025-04-15 23:49:24', NULL, NULL, NULL, NULL),
(13, 'garena@example.com', '$2y$10$xi28XCZI7uf3J5Q/GFBk1OZkY2SYQK82I3F/0s2CibgDCFApriba.', 'GarenaHR', 'company_admin', '0231456789', 'assets/images/defaultavatar.jpg', 1, '2025-04-16 00:02:05', NULL, NULL, NULL, NULL),
(14, 'phankhanhnhan01@gmail.com', '$2y$10$Uc2MENNI07nM0kuYqX4bROM7ClCAKn/KEUdVB.BexAg1OcSNLEDvi', 'Nhân Phan', 'company_admin', NULL, 'uploads/avatars/google_0ecb1fca5c75bdb84931d7d5ebc84cb5_1745691292.jpg', 1, '2025-04-26 18:14:53', '2025-04-26 18:14:53', NULL, NULL, NULL);

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
  ADD KEY `employer_id` (`employer_id`),
  ADD KEY `fk_job_category` (`category_id`);

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
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `fk_job_category` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`category_id`),
  ADD CONSTRAINT `job_posts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_posts_ibfk_2` FOREIGN KEY (`employer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

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
