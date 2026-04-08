-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 06, 2026 lúc 09:27 AM
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
-- Cơ sở dữ liệu: `lms_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `assignments`
--

INSERT INTO `assignments` (`id`, `course_id`, `title`, `description`, `due_date`, `created_at`, `deadline`) VALUES
(1, 4, 'Assignment1', '', NULL, '2026-02-06 08:36:45', '2026-02-20 15:36:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Information Technology', 'it', 'Programming, Network, Security courses'),
(2, 'Business Management', 'business', 'Leadership, Marketing, Finance'),
(3, 'Graphic Design', 'design', 'Photoshop, UI/UX, Illustrator'),
(4, 'Languages', 'languages', 'English, Japanese, French');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `thumbnail` varchar(255) DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` enum('draft','published','hidden') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `price`, `thumbnail`, `instructor_id`, `category_id`, `status`, `created_at`) VALUES
(1, 'Web PHP and SDLC', 'web-php-and-sdlc-1771323195', '', 0.00, '1769755393_php.png', 2, 1, 'published', '2026-01-30 06:43:13'),
(4, 'Business Process Support', 'business-process-support-1770366723', 'Learning about Business Process', 0.00, '1770358080_6985854039519.jpg', 4, 2, 'published', '2026-02-06 06:08:00'),
(20, 'Master UI/UX Design with Figma', 'master-uiux-design-with-figma-1770799464', 'Learn how to design beautiful interfaces and user experiences using Figma from scratch.', 59.99, '1770799464_698c416855f4f.webp', 20, 3, 'published', '2026-02-11 08:36:42'),
(21, 'English Communication for Beginners', 'english-communication-for-beginners-1770799536', 'Improve your daily English conversation skills with practical lessons.', 29.99, '1770799536_698c41b0519a9.jpg', 21, 4, 'published', '2026-02-11 08:36:42'),
(22, 'JavaScript Zero to Hero', 'javascript-zero-to-hero-1770799255', 'The complete guide to modern JavaScript (ES6+) for aspiring web developers.', 49.99, '1770799255_698c409787632.jpg', 2, 1, 'published', '2026-02-11 08:36:42'),
(23, 'Digital Marketing Strategy 2026', 'digital-marketing-strategy-2026-1770799577', 'Learn SEO, Social Media Marketing, and Content Strategy to grow your business.', 39.99, '1770799577_698c41d985f15.jpg', 22, 2, 'published', '2026-02-11 08:36:42'),
(24, 'Python for Data Science', 'python-for-data-science-1770799301', 'Analyze data and build machine learning models using Python.', 0.00, '1770799301_698c40c5e6b16.jpg', 2, 1, 'published', '2026-02-11 08:36:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `enrolled_date`) VALUES
(1, 6, 1, '2026-01-30 07:33:00'),
(3, 1, 1, '2026-02-06 08:34:40'),
(4, 1, 4, '2026-02-06 08:37:24'),
(6, 6, 4, '2026-02-10 08:25:41'),
(7, 23, 20, '2026-02-11 08:36:42'),
(8, 23, 22, '2026-02-11 08:36:42'),
(9, 24, 21, '2026-02-11 08:36:42'),
(10, 24, 23, '2026-02-11 08:36:42'),
(11, 25, 20, '2026-02-11 08:36:42'),
(12, 25, 24, '2026-02-11 08:36:42'),
(13, 26, 22, '2026-02-11 08:36:42'),
(14, 26, 20, '2026-02-11 08:36:42'),
(15, 26, 21, '2026-02-11 08:36:42'),
(16, 6, 20, '2026-02-11 08:36:42'),
(17, 6, 22, '2026-02-11 08:36:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `video_url`, `order_index`, `created_at`) VALUES
(4, 20, 'Introduction to UI/UX Design', NULL, 'https://www.youtube.com/embed/c9Wg6Cb_YlU', 1, '2026-02-11 08:36:42'),
(5, 20, 'Getting Started with Figma', NULL, 'https://www.youtube.com/embed/jw66XaUXtqE', 2, '2026-02-11 08:36:42'),
(6, 20, 'Typography and Colors', NULL, 'https://www.youtube.com/embed/DarwD1M0wSs', 3, '2026-02-11 08:36:42'),
(7, 20, 'Prototyping Basics', NULL, 'https://www.youtube.com/embed/5x3m1h3a1yE', 4, '2026-02-11 08:36:42'),
(8, 21, 'Lesson 1: Greetings & Introductions', NULL, 'https://www.youtube.com/embed/juKd26qkNAw', 1, '2026-02-11 08:36:42'),
(9, 21, 'Lesson 2: Talking about Daily Routine', NULL, 'https://www.youtube.com/embed/4I80F2S1Mzk', 2, '2026-02-11 08:36:42'),
(10, 21, 'Lesson 3: Ordering Food at Restaurant', NULL, 'https://www.youtube.com/embed/M2Zd7N9E7aM', 3, '2026-02-11 08:36:42'),
(11, 22, 'JS Basics: Variables & Data Types', NULL, 'https://www.youtube.com/embed/W6NZfCO5SIk', 1, '2026-02-11 08:36:42'),
(12, 22, 'Functions and Scope', NULL, 'https://www.youtube.com/embed/N8ap4k_1QEQ', 2, '2026-02-11 08:36:42'),
(13, 22, 'DOM Manipulation', NULL, 'https://www.youtube.com/embed/y17RuWkWDN8', 3, '2026-02-11 08:36:42'),
(14, 22, 'Async/Await Explained', NULL, 'https://www.youtube.com/embed/spvYqO_KS98', 4, '2026-02-11 08:36:42'),
(15, 23, 'What is Digital Marketing?', NULL, 'https://www.youtube.com/embed/bixR-KIJKYM', 1, '2026-02-11 08:36:42'),
(16, 23, 'SEO Fundamentals', NULL, 'https://www.youtube.com/embed/DvwS7cV9GmQ', 2, '2026-02-11 08:36:42'),
(17, 24, 'Python Installation & Setup', NULL, 'https://www.youtube.com/embed/LHBE6Q9XlzI', 1, '2026-02-11 08:36:42'),
(18, 24, 'Python Lists & Dictionaries', NULL, 'https://www.youtube.com/embed/kqtD5dpn9C8', 2, '2026-02-11 08:36:42'),
(19, 1, 'PHP Intro & Installation', NULL, 'https://www.youtube.com/embed/OK_JCtrrv-c', 1, '2026-02-11 08:36:42'),
(20, 1, 'PHP Syntax & Variables', NULL, 'https://www.youtube.com/embed/2eebptXfEvw', 2, '2026-02-11 08:36:42'),
(21, 1, 'Control Structures', NULL, 'https://www.youtube.com/embed/7fJ4sH_L0co', 3, '2026-02-11 08:36:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 1, 'Test Subject', 'Hello', 1, '2026-02-10 03:27:35'),
(2, 2, 6, 'Chào mừng em', 'Học tốt nhé em!', 1, '2026-02-10 04:31:11'),
(3, 20, 6, 'Welcome to UI/UX Class', 'Hi there! Excited to have you in my design course. Let me know if you need help with Figma.', 0, '2026-02-11 08:36:42'),
(4, 22, 6, 'Course Update', 'I just added a new module about SEO trends in 2026. Check it out!', 0, '2026-02-11 08:36:42'),
(5, 6, 20, 'Question about Assignment 1', 'Hi Sarah, could you clarify the requirements for the wireframe task?', 1, '2026-02-11 08:36:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `link`, `is_read`, `created_at`) VALUES
(1, 1, 'Test thong bao moi', NULL, 1, '2026-02-10 03:27:35'),
(2, 6, 'Bạn có bài tập mới', '#', 1, '2026-02-10 04:31:11'),
(3, 6, 'Test thong bao moi nhat', '#', 1, '2026-02-10 04:34:31'),
(4, 6, 'Instructor Sarah posted a new announcement', '/course/detail/20', 0, '2026-02-11 08:36:42'),
(5, 6, 'Your assignment \"Web Layout\" was graded: 9/10', '/profile/grades', 0, '2026-02-11 08:36:42'),
(6, 6, 'New course \"Python for Data Science\" is now available for free!', '/course/detail/24', 0, '2026-02-11 08:36:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `is_correct`) VALUES
(1, 1, 'fdhdgd', 1),
(2, 1, 'sgehe', 0),
(3, 1, '5j5t', 0),
(4, 1, '44tyh', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `created_at`) VALUES
(1, 1, 'Howwwww', '2026-02-06 09:01:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `title`, `description`, `created_at`) VALUES
(1, 4, 'ethsd', '', '2026-02-06 09:01:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `quiz_id`, `user_id`, `score`, `completed_at`) VALUES
(1, 1, 1, 100, '2026-02-08 02:39:53'),
(2, 1, 1, 0, '2026-02-10 03:19:50'),
(3, 1, 1, 100, '2026-02-11 04:31:10'),
(4, 1, 1, 100, '2026-03-20 08:02:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `submissions`
--

INSERT INTO `submissions` (`id`, `assignment_id`, `student_id`, `file_path`, `grade`, `feedback`, `submitted_at`) VALUES
(1, 1, 1, '1770367121_Business Process.jpg', NULL, NULL, '2026-02-06 08:38:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 1, 'Forgot Password', 'I fortgot my password', 'resolved', '2026-02-06 07:58:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','instructor','student') DEFAULT 'student',
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `avatar`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'Nguyen Van A', 'a@test.com', '$2y$10$9owGeAPScG.RnmkV9mXnXu8wjOQgHe4j3o/L2J9rRKDXBvG2RNStW', 'student', NULL, NULL, '2026-01-30 06:24:44', '2026-02-06 07:02:42'),
(2, 'Daniel ', 'dev@test.com', '$2y$10$HH7cumNxfRogUxO6ezpvjuetNFcNPtDjYOHdDVWDcG2WWoeMSA4aa', 'instructor', NULL, NULL, '2026-01-30 06:30:54', '2026-02-11 08:43:22'),
(4, 'Biller', 'thayb@test.com', '$2y$10$q01fUp7jt67knEvaMdzlhuDm3v6PUxdFpEVYEqNs1NBdoAQeXoTqG', 'instructor', NULL, NULL, '2026-02-06 06:03:52', '2026-02-11 08:43:43'),
(5, 'Admin', 'admin@gmail.com', '$2y$10$EfLIJzvxloYaa3xl1F0KPed7ih3OLXlmnZTGFFk67uSVT46YmYaaG', 'admin', NULL, NULL, '2026-02-06 06:24:10', '2026-02-06 06:24:23'),
(6, 'Test Student', 'new@gmail.com', '$2y$10$CBynbe9rNajKbogIXO0pneUbwbAnUMdi7qKQFTStYJnIEbuh5aNdK', 'student', NULL, NULL, '2026-02-10 04:44:09', '2026-02-10 04:44:09'),
(20, 'Sarah Jenkins', 'sarah@lms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', 'https://ui-avatars.com/api/?name=Sarah+Jenkins&background=e91e63&color=fff', 'Expert in UI/UX Design with 10 years of experience.', '2026-02-11 08:36:42', '2026-02-11 08:36:42'),
(21, 'Michael Wong', 'michael@lms.com', '$2y$10$fcKtyLFzuDA8faRftIIjsOdNKdZe.cT8GNc6NASm3bSVG7mHge8.q', 'instructor', 'https://ui-avatars.com/api/?name=Michael+Wong&background=2196f3&color=fff', 'IELTS 8.5 Instructor & Native Speaker.', '2026-02-11 08:36:42', '2026-02-11 08:42:45'),
(22, 'David Miller', 'david@lms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', 'https://ui-avatars.com/api/?name=David+Miller&background=ff9800&color=fff', 'Digital Marketing Specialist.', '2026-02-11 08:36:42', '2026-02-11 08:36:42'),
(23, 'Alice Nguyen', 'alice@lms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'https://ui-avatars.com/api/?name=Alice+Nguyen&background=random', NULL, '2026-02-11 08:36:42', '2026-02-11 08:36:42'),
(24, 'Bob Tran', 'bob@lms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'https://ui-avatars.com/api/?name=Bob+Tran&background=random', NULL, '2026-02-11 08:36:42', '2026-02-11 08:36:42'),
(25, 'Charlie Pham', 'charlie@lms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'https://ui-avatars.com/api/?name=Charlie+Pham&background=random', NULL, '2026-02-11 08:36:42', '2026-02-11 08:36:42'),
(26, 'Diana Le', 'diana@lms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'https://ui-avatars.com/api/?name=Diana+Le&background=random', NULL, '2026-02-11 08:36:42', '2026-02-11 08:36:42');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Chỉ mục cho bảng `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Chỉ mục cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
