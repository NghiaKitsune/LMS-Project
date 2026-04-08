-- Seed Data for Quizzes, Questions, Options, Assignments, Submissions, Support Tickets, Notifications

USE lms_db;

-- 1. Insert Quizzes
INSERT INTO quizzes (id, course_id, title, description, created_at) VALUES 
(100, 20, 'Figma Prototyping Basics', 'Test your knowledge on Figma components and auto layout.', NOW()),
(101, 20, 'Color Theory & Typography', 'Assess your understanding of basic UI/UX visual principles.', NOW()),
(102, 22, 'JavaScript Async Fundamentals', 'A quick test on Callbacks, Promises, and Async/Await.', NOW());

-- 2. Insert Questions
INSERT INTO questions (id, quiz_id, question_text, created_at) VALUES
(1001, 100, 'What is the primary function of Auto Layout in Figma?', NOW()),
(1002, 100, 'Which shortcut creates a component in Figma?', NOW()),
(1003, 101, 'Which color model is best used for digital screens?', NOW()),
(1004, 102, 'What keyword is used to pause the execution of an async function until a Promise is resolved?', NOW());

-- 3. Insert Options
INSERT INTO options (question_id, option_text, is_correct) VALUES
(1001, 'To automatically export images', 0),
(1001, 'To create responsive dynamic layouts', 1),
(1001, 'To apply colors automatically', 0),
(1001, 'To write CSS code', 0),

(1002, 'Cmd + C', 0),
(1002, 'Cmd + Option + K', 1),
(1002, 'Cmd + G', 0),
(1002, 'Cmd + Shift + K', 0),

(1003, 'CMYK', 0),
(1003, 'RGB', 1),
(1003, 'Pantone', 0),
(1003, 'Grayscale', 0),

(1004, 'yield', 0),
(1004, 'await', 1),
(1004, 'wait', 0),
(1004, 'halt', 0);

-- 4. Insert Assignments
INSERT INTO assignments (id, course_id, title, description, due_date, deadline, created_at) VALUES
(200, 20, 'Design a Login Page', 'Use Figma to create a clean login interface and submit the link.', NULL, DATE_ADD(NOW(), INTERVAL 7 DAY), NOW()),
(201, 22, 'Build a To-Do List', 'Using Vanilla JS, fetch tasks from an API and render them.', NULL, DATE_ADD(NOW(), INTERVAL 5 DAY), NOW());

-- 5. Insert Submissions
INSERT INTO submissions (id, assignment_id, student_id, file_path, grade, feedback, submitted_at) VALUES
(300, 200, 6, 'figma_link_project.txt', 9.5, 'Great use of negative space!', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(301, 200, 23, 'alice_login.zip', 8.0, 'Good effort, but check alignment.', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(302, 201, 24, 'todo_app.zip', 10.0, 'Perfectly executed DOM manipulations.', DATE_SUB(NOW(), INTERVAL 1 DAY));

-- 6. Insert Support Tickets
INSERT INTO support_tickets (user_id, subject, message, status, created_at) VALUES
(6, 'Video Not Loading', 'The video on lesson 3 of Figma course keeps buffering.', 'pending', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(23, 'Billing Error', 'I was charged twice for the SEO course.', 'resolved', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(24, 'Certificate Not Generated', 'I finished the JS course but did not get my certificate.', 'pending', DATE_SUB(NOW(), INTERVAL 12 HOUR)),
(25, 'Login Issue', 'Sometimes my session expires instantly.', 'pending', NOW());

-- 7. Insert Notifications
INSERT INTO notifications (user_id, message, link, is_read, created_at) VALUES
(6, 'Your submission for "Design a Login Page" has been graded!', '/LMS_Project/public/assignment/detail/200', 0, NOW()),
(24, 'Your submission for "Build a To-Do List" scored 10.0!', '/LMS_Project/public/assignment/detail/201', 0, NOW()),
(20, 'New student enrolled in your UI/UX Course!', '/LMS_Project/public/course/my_courses', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(5, 'New support ticket #2 received from Bob Tran.', '/LMS_Project/public/admin/tickets', 0, NOW());

-- 8. Insert Messages
INSERT INTO messages (sender_id, receiver_id, subject, message, is_read, created_at) VALUES
(20, 6, 'Feedback on Assignment', 'Hi Test Student, you did a great job on the auto-layout part. Keep it up!', 0, NOW()),
(6, 20, 'Thank you!', 'Thanks Sarah, really enjoying the course so far.', 1, DATE_SUB(NOW(), INTERVAL 2 DAY));

