-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 07:06 PM
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
-- Database: `feedback_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback_forms`
--

CREATE TABLE `feedback_forms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `viewed_count` int(11) DEFAULT 0,
  `submission_count` int(11) DEFAULT 0,
  `logic` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_forms`
--

INSERT INTO `feedback_forms` (`id`, `name`, `created_at`, `viewed_count`, `submission_count`, `logic`) VALUES
(1, 'Product Feedback Form', '2024-08-27 16:37:30', 0, 0, '{\"pages\": [\"home\", \"product\"], \"display\": \"once\"}'),
(2, 'Service Feedback Form', '2024-08-27 16:37:30', 0, 0, '{\"pages\": [\"services\"], \"display\": \"timed\", \"duration\": \"30s\"}'),
(3, 'General Feedback Form', '2024-08-27 16:37:30', 0, 0, '{\"pages\": [\"about\", \"contact\"], \"display\": \"date_range\", \"start_date\": \"2024-09-01\", \"end_date\": \"2024-09-30\"}');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `label` varchar(255) NOT NULL,
  `required` tinyint(1) DEFAULT 0,
  `error_message` varchar(255) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `form_id`, `field_type`, `label`, `required`, `error_message`, `options`, `order`) VALUES
(1, 1, 'star_rating', 'Rate our Product', 1, 'Please provide a rating.', NULL, 1),
(2, 1, 'text_area', 'What do you like about the product?', 0, NULL, NULL, 2),
(3, 1, 'radio_buttons', 'Would you recommend this product?', 1, 'Please select an option.', '[\"Yes\", \"No\", \"Maybe\"]', 3),
(4, 2, 'numeric_rating', 'Rate our Service', 1, 'Please rate our service.', NULL, 1),
(5, 2, 'text_area', 'How can we improve our service?', 0, NULL, NULL, 2),
(6, 2, 'categories', 'Select the services you used', 0, NULL, '[\"Consulting\", \"Development\", \"Support\"]', 3),
(7, 3, 'smile_rating', 'How was your overall experience?', 1, 'Please provide a rating.', NULL, 1),
(8, 3, 'single_line_input', 'Your Name', 1, 'Name is required.', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE `form_submissions` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `submission_data` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_submissions`
--

INSERT INTO `form_submissions` (`id`, `form_id`, `submission_data`, `submitted_at`) VALUES
(1, 1, '{\"Rate our Product\": \"4\", \"What do you like about the product?\": \"The design and build quality.\", \"Would you recommend this product?\": \"Yes\"}', '2024-08-27 16:38:09'),
(2, 1, '{\"Rate our Product\": \"5\", \"What do you like about the product?\": \"Excellent performance and value for money.\", \"Would you recommend this product?\": \"Yes\"}', '2024-08-27 16:38:09'),
(3, 2, '{\"Rate our Service\": \"3\", \"How can we improve our service?\": \"Faster response times.\", \"Select the services you used\": [\"Consulting\", \"Support\"]}', '2024-08-27 16:38:09'),
(4, 2, '{\"Rate our Service\": \"4\", \"How can we improve our service?\": \"More detailed documentation.\", \"Select the services you used\": [\"Development\"]}', '2024-08-27 16:38:09'),
(5, 3, '{\"How was your overall experience?\": \"3\", \"Your Name\": \"John Doe\"}', '2024-08-27 16:38:09'),
(6, 3, '{\"How was your overall experience?\": \"5\", \"Your Name\": \"Jane Smith\"}', '2024-08-27 16:38:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback_forms`
--
ALTER TABLE `feedback_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback_forms`
--
ALTER TABLE `feedback_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `feedback_forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD CONSTRAINT `form_submissions_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `feedback_forms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
