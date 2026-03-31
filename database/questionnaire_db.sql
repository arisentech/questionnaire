-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 12:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `questionnaire_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `assignment_id`, `question_id`, `answer_text`) VALUES
(1, 1, 1, 'testing'),
(2, 1, 2, 'testing'),
(3, 1, 3, 'testing'),
(4, 3, 3, 'testing file '),
(5, 3, 4, 'testing multi file '),
(6, 2, 6, 'Testing file upload  '),
(7, 2, 7, 'testing no file '),
(8, 2, 8, 'testing multiple files ');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `customer_id`, `vendor_id`, `created_at`) VALUES
(1, NULL, 3, '2026-03-30 14:02:43'),
(2, NULL, 4, '2026-03-30 14:59:54'),
(3, NULL, 3, '2026-03-30 16:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_questions`
--

CREATE TABLE `assignment_questions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_questions`
--

INSERT INTO `assignment_questions` (`id`, `assignment_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 6),
(5, 2, 7),
(6, 2, 8),
(7, 3, 3),
(8, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Physical Security');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `file_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `answer_id`, `file_path`) VALUES
(1, 4, '../../uploads/1774947486_7005_Physical Security.xlsx'),
(2, 4, '../../uploads/1774947486_3315_Physical Security-Only (1).xlsx'),
(3, 5, '../../uploads/1774947486_6455_Physical Security.xlsx'),
(4, 6, '../../uploads/1774948638_4940_1774947486_7005_Physical Security.xlsx'),
(5, 8, '../../uploads/1774948638_8255_1774947486_7005_Physical Security.xlsx'),
(6, 8, '../../uploads/1774948638_8564_Physical Security.xlsx'),
(7, 8, '../../uploads/1774948638_1242_Physical Security-Only (1).xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `what_to_see` text DEFAULT NULL,
  `answer_type` enum('paragraph') DEFAULT 'paragraph'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `category_id`, `what_to_see`, `answer_type`) VALUES
(1, 'Explain in brief your physical environment.', 1, 'The assessor should evaluate and examine the robustness of physical infrastructure, including building security, access controls, and environmental protections.', 'paragraph'),
(2, 'Are physical security perimeters established to protect areas that contain information and information processing facilities?', 1, 'Take a look at the scope statement to determine the boundaries and ensure that security controls are defined and implemented within those perimeters.', 'paragraph'),
(3, 'Are physical entry controls implemented to restrict unauthorized access?', 1, 'Access logs, visitor records, system configurations, and authentication mechanisms should be reviewed.', 'paragraph'),
(4, 'Are offices, rooms, and facilities secured to prevent unauthorized access?', 1, 'Surveillance logs, security system records, visitor logs, and access restrictions should be verified.', 'paragraph'),
(5, 'Is protection against external and environmental threats implemented?', 1, 'Check for fire protection systems, flood controls, climate control systems, and disaster preparedness measures.', 'paragraph'),
(6, 'Are working areas secured?', 1, 'Observe physical barriers, clean desk policies, and restrictions on sensitive information exposure.', 'paragraph'),
(7, 'Are equipment and assets protected?', 1, 'Verify asset registers, equipment placement, and physical protection mechanisms.', 'paragraph'),
(8, 'Is secure disposal or reuse of equipment ensured?', 1, 'Check disposal policies, data wiping procedures, and asset disposal logs.', 'paragraph');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer','vendor') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@test.com', '$2y$10$8z8jRh1lJfJtLS2zWfN9nuedFH5O3xIbtXZi2XLB6PdHvu9kY0xVm', 'admin'),
(2, 'Customer', 'customer@test.com', '$2y$10$8z8jRh1lJfJtLS2zWfN9nuedFH5O3xIbtXZi2XLB6PdHvu9kY0xVm', 'customer'),
(3, 'Vendor 1', 'vendor1@test.com', '$2y$10$Ka/.IQbmlxVqs0eUY6rbLuPfGGYpDi7UHcKY34KO/C16rGBd8.k6C', 'vendor'),
(4, 'Vendor 2', 'vendor2@test.com', '$2y$10$8z8jRh1lJfJtLS2zWfN9nuedFH5O3xIbtXZi2XLB6PdHvu9kY0xVm', 'vendor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assignment_questions`
--
ALTER TABLE `assignment_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
