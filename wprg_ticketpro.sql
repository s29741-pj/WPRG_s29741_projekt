-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 13, 2025 at 08:52 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wprg_ticketpro`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attachments`
--

CREATE TABLE `attachments` (
  `attachment_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`attachment_id`, `ticket_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(11, 1, 'img test2.jpg', 'http://localhost/ticketpro_app/Attachments/upload/img%20test2.jpg', '2025-05-29 01:32:58'),
(20, 2, 'IMG_0297.jpeg', 'http://localhost/ticketpro_app/Attachments/upload/IMG_0297.jpeg', '2025-06-11 02:45:33'),
(21, 1, 'IMG_0297.jpeg', 'http://localhost/ticketpro_app/Attachments/upload/IMG_0297.jpeg', '2025-06-11 10:00:01'),
(22, 10, 'IMG_0297.jpeg', 'http://localhost/ticketpro_app/Attachments/upload/IMG_0297.jpeg', '2025-06-11 10:00:21'),
(23, 9, 'IMG_0297.jpeg', 'http://localhost/ticketpro_app/Attachments/upload/IMG_0297.jpeg', '2025-06-11 10:32:49'),
(24, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 10:38:35'),
(25, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 10:38:46'),
(26, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 10:39:05'),
(27, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 11:52:25'),
(28, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 11:52:35'),
(29, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 11:52:47'),
(30, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:01:50'),
(31, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:02:12'),
(32, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:02:53'),
(33, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:02:58'),
(34, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:03:03'),
(35, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:09:40'),
(36, 2, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:09:53'),
(37, 2, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:10:03'),
(38, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 12:26:27'),
(39, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 23:01:10'),
(40, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 23:01:17'),
(41, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 23:01:32'),
(42, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 23:31:44'),
(43, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-11 23:31:51'),
(48, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-13 01:29:21'),
(49, 1, '', 'http://localhost/ticketpro_app/Attachments/upload/', '2025-06-13 01:29:41');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `added` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `author` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `ticket_id`, `added`, `modified`, `content`, `author`) VALUES
(1, 1, '2025-04-01', '2025-04-02', 'Issue confirmed.\r\n', 2),
(2, 2, '2025-04-02', '2025-04-03', 'Welcome package sent.', 8),
(3, 3, '2025-04-03', '2025-04-03', 'Awaiting final numbers.', 4),
(4, 4, '2025-04-04', '2025-04-05', 'Finance team notified.', 5),
(5, 5, '2025-04-05', '2025-04-06', 'Initial forecast ready.', 1),
(6, 6, '2025-04-06', '2025-04-06', 'Complaint resolved.', 6),
(7, 7, '2025-04-07', '2025-04-08', 'Legal reviewed the contract.', 7),
(8, 8, '2025-04-08', '2025-04-08', 'Delivery delayed by 2 days.', 9),
(9, 9, '2025-04-09', '2025-04-10', 'Automation tools evaluated.', 10),
(10, 10, '2025-04-10', '2025-04-11', 'Testing phase ongoing.', 3),
(11, 1, '2025-05-23', '2025-05-23', 'Issue fixed.', 5),
(14, 1, '2025-06-08', NULL, 'test', 1),
(15, 1, '2025-06-08', NULL, 'test2', 1),
(16, 1, '2025-06-08', NULL, 'test3', 1),
(17, 1, '2025-06-08', NULL, 'test4', 1),
(18, 1, '2025-06-08', NULL, 'test5', 1),
(19, 6, '2025-06-09', NULL, 'Ok', 1),
(20, 2, '2025-06-09', NULL, 'Ok', 1),
(22, 1, '2025-06-10', NULL, 'test6', 1),
(23, 1, '2025-06-10', NULL, 'test6', 1),
(24, 1, '2025-06-11', NULL, 'test7\r\n', 1),
(25, 1, '2025-06-11', NULL, 'test8', 1),
(26, 1, '2025-06-11', NULL, 'test9', 1),
(29, 1, '2025-06-13', NULL, 'test10', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(250) DEFAULT NULL,
  `department_head` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `department_head`) VALUES
(1, 'IT', 1),
(2, 'HR', 2),
(3, 'Marketing', 3),
(4, 'Finance', 4),
(5, 'Sales', 5),
(6, 'Support', 6),
(7, 'Legal', 7),
(8, 'Logistics', 8),
(9, 'Operations', 9),
(10, 'R&D', 10),
(11, 'Ministry of Silly Walks', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'Admin'),
(2, 'Department Head'),
(3, 'User'),
(4, 'Guest');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `priority` varchar(20) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `date_deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `department_id`, `user_id`, `title`, `priority`, `date_added`, `date_closed`, `date_deadline`) VALUES
(1, 1, 1, 'System crash on login', 'High', '2025-04-01', '2025-06-13', '2025-06-17'),
(2, 2, 3, 'New employee onboarding', 'Medium', '2025-04-02', '2025-06-11', '2025-04-05'),
(3, 3, 4, 'Campaign performance report', 'Low', '2025-04-03', NULL, '2025-04-12'),
(4, 4, 5, 'Missing financial data', 'High', '2025-04-04', NULL, '2025-04-10'),
(5, 5, 6, 'Quarterly sales forecast', 'Medium', '2025-04-05', NULL, '2025-04-15'),
(6, 6, 7, 'Customer complaint follow-up', 'Medium', '2025-04-06', '2025-04-08', '2025-04-07'),
(7, 7, 8, 'Contract review', 'Low', '2025-04-07', NULL, '2025-04-20'),
(8, 8, 9, 'Warehouse delay', 'High', '2025-04-08', NULL, '2025-04-18'),
(9, 9, 10, 'Process automation request', 'Low', '2025-04-09', NULL, '2025-04-30'),
(10, 10, 1, 'Prototype testing', 'Medium', '2025-04-10', NULL, '2025-04-25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `surname` varchar(150) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `activation_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `name`, `surname`, `email`, `password`, `department_id`, `is_active`, `activation_token`, `reset_token`, `reset_token_expiry`) VALUES
(1, 1, 'Anna', 'Kowalska', 'anna.kowalska@example.com', '$2y$10$ErGvBO3/sSZb7J9j7CoVAeI4CfCEKt26sB07XIQK9py//0wKuRYRS', 1, 1, NULL, 'dddbda4234b99001360feb3f4c7e3593f3d3bdbe89e8abecd3a61038b661376c', '2025-06-13 20:58:23'),
(2, 2, 'Jan', 'Nowak', 'jan.nowak@example.com', '$2y$10$1fQBg/QHeLpwfP6yU7KfyOsSeo6.hYb7Gju7xW8xtseX6.Xagl4qm', 2, 1, NULL, NULL, NULL),
(3, 3, 'Ewa', 'Wiśniewska', 'ewa.wisniewska@example.com', '$2y$10$cPJvv4by2RkaYUQR64/h/etzcgi92GxvSoncAuoqbz4vNPxhhJ4s.', 3, 1, NULL, NULL, NULL),
(4, 2, 'Tomasz', 'Wójcik', 'tomasz.wojcik@example.com', '$2y$10$9jcknDC09MYSCcjEB4jMEuhVezkx6KmyiHSzV/iN6527GO/MYkrem', 4, 1, NULL, NULL, NULL),
(5, 2, 'Karolina', 'Krawczyk', 'karolina.krawczyk@example.com', '$2y$10$OZeOPBXj/yu3lmA0JLdGMe10M4p9NfQxYef2lqP8RZ/L1VKZ4VIte', 5, 1, NULL, NULL, NULL),
(6, 2, 'Michał', 'Mazur', 'michal.mazur@example.com', '$2y$10$P.aaa9b59tQzAy4JSycpletn3tAD5qTd/4mwABfbyUTQ3KQR4708e', 6, 1, NULL, NULL, NULL),
(7, 2, 'Zofia', 'Lewandowska', 'zofia.lewandowska@example.com', '$2y$10$kmoo3i19oq5CCxieF8dUhuthYkVVKyp0AVOzivdWTzXbsIkAT4VvC', 7, 1, NULL, NULL, NULL),
(8, 3, 'Paweł', 'Zieliński', 'pawel.zielinski@example.com', '$2y$10$ai6NuuiNIq2QEUUNpIUZ9OiJnh.63r5e/eOhnq8Y0oYs/FiKVZ..O', 8, 1, NULL, NULL, NULL),
(9, 3, 'Natalia', 'Szymańska', 'natalia.szymanska@example.com', '$2y$10$/pwkYIefF6kne418Q/YJpO9uvh/1UGGvEwHmr6VIgaaiDdA40f5o2', 9, 1, NULL, NULL, NULL),
(10, 3, 'Mateusz', 'Dąbrowski', 'mateusz.dabrowski@example.com', '$2y$10$arBdlWBOWt11JRh5SZ8Ge.1E68y4DrGYRsWj95NuK1JRAxvz.59mO', 10, 1, NULL, NULL, NULL),
(15, 3, 'Jan', 'Dzban', 'jb@mail.com', '$2y$10$Vq16AQViYknKBy.ipr0cHuj5gjAv2pIw8/VRd7osLdl2jJ4HTd/Fy', NULL, 0, '2498c88c3b3fd4dba2fe75a6dd32d1d7dff9908f14e9466b4e5ea1100d9a1117', NULL, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `fk_comments_author` (`author`);

--
-- Indeksy dla tabeli `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `fk_user_id` (`department_head`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeksy dla tabeli `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `ticket_id` (`ticket_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `account_type` (`role_id`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_author` FOREIGN KEY (`author`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`department_head`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
