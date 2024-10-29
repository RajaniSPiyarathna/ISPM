-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 29, 2024 at 03:30 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leco`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_logs`
--

DROP TABLE IF EXISTS `event_logs`;
CREATE TABLE IF NOT EXISTS `event_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_type` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_logs`
--

INSERT INTO `event_logs` (`id`, `event_type`, `user_id`, `ip_address`, `status`, `message`, `created_at`) VALUES
(10, 'successful_login', 25, NULL, 'success', 'User logged in with 2FA.', '2024-09-28 19:50:18'),
(9, 'otp_sent', 25, NULL, 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-28 19:50:02'),
(3, 'successful_login', 24, NULL, 'success', 'User logged in with 2FA.', '2024-09-28 14:21:20'),
(4, 'successful_login', 24, NULL, 'success', 'User logged in with 2FA.', '2024-09-28 14:24:36'),
(5, 'login_attempt', NULL, NULL, 'failure', 'Invalid OTP for email: leco88507@gmail.com', '2024-09-28 14:53:20'),
(6, 'successful_login', 4, NULL, 'success', 'User has logged in Successfully.', '2024-09-28 14:54:28'),
(7, 'login_attempt', NULL, NULL, 'failure', 'Invalid OTP for email: leco88507@gmail.com', '2024-09-28 14:55:45'),
(8, 'login_attempt', NULL, NULL, 'failure', 'Invalid OTP for email: leco88507@gmail.com', '2024-09-28 14:59:16'),
(11, 'otp_sent', 4, NULL, 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-28 19:50:41'),
(12, 'otp_verification_attempt', NULL, NULL, 'failure', 'Invalid OTP for email: leco88507@gmail.com', '2024-09-28 19:50:47'),
(13, 'otp_sent', 25, NULL, 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-28 19:57:27'),
(14, 'otp_verification_attempt', NULL, NULL, 'failure', 'Invalid OTP for email: eforbes520@gmail.com', '2024-09-28 19:57:33'),
(15, 'otp_sent', 25, NULL, 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-28 20:10:36'),
(16, 'successful_login', 25, NULL, 'success', 'User logged in with 2FA.', '2024-09-28 20:10:54'),
(17, 'login_attempt', NULL, NULL, 'failure', 'Invalid password for email: rajanis2001@gmail.com', '2024-09-28 21:05:32'),
(18, 'login_attempt', NULL, NULL, 'failure', 'Invalid password for email: rajanis2001@gmail.com', '2024-09-28 21:05:56'),
(19, 'login_attempt', NULL, NULL, 'failure', 'Invalid password for email: rajanis2001@gmail.com', '2024-09-28 21:06:06'),
(20, 'login_attempt', NULL, NULL, 'failure', 'Invalid password for email: rajanis2001@gmail.com', '2024-09-28 21:06:14'),
(21, 'login_attempt', NULL, NULL, 'failure', 'Invalid password for email: rajanis2001@gmail.com', '2024-09-28 21:06:25'),
(22, 'otp_sent', 4, NULL, 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-28 21:08:38'),
(23, 'otp_verification_attempt', NULL, NULL, 'failure', 'Invalid OTP for email: leco88507@gmail.com', '2024-09-28 21:08:55'),
(24, 'otp_sent', 4, NULL, 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-28 21:09:16'),
(25, 'successful_login', 4, NULL, 'success', 'User logged in successfully.', '2024-09-28 21:09:30'),
(26, 'otp_sent', 25, '::1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-28 21:32:35'),
(27, 'successful_login', 25, '::1', 'success', 'User logged in successfully.', '2024-09-28 21:32:48'),
(28, 'otp_sent', 4, '::1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-28 21:33:22'),
(29, 'successful_login', 4, '::1', 'success', 'User logged in successfully.', '2024-09-28 21:33:35'),
(30, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-28 21:35:12'),
(31, 'otp_verification_attempt', NULL, '127.0.0.1', 'failure', 'Invalid OTP for email: eforbes520@gmail.com', '2024-09-28 21:35:15'),
(32, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-28 21:35:42'),
(33, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-28 21:35:50'),
(34, 'otp_sent', 24, '127.0.0.1', 'success', 'OTP sent to email: chalanaranwala@gmail.com', '2024-09-29 04:59:08'),
(35, 'successful_login', 24, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 05:00:40'),
(36, 'login_attempt', NULL, '127.0.0.1', 'failure', 'Invalid password for email: eforbes520@gmail.com', '2024-09-29 05:28:36'),
(37, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 05:28:49'),
(38, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 05:29:03'),
(39, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 05:39:17'),
(40, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 05:39:26'),
(41, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 05:54:40'),
(42, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 05:54:50'),
(43, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 06:08:14'),
(44, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 06:08:24'),
(45, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 06:16:04'),
(46, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 06:16:51'),
(47, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 06:22:03'),
(48, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 06:22:28'),
(49, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 06:34:53'),
(50, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 06:35:17'),
(51, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 06:36:55'),
(52, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 06:37:07'),
(53, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 07:59:58'),
(54, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:00:08'),
(55, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 08:07:20'),
(56, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:07:33'),
(57, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 08:24:54'),
(58, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:25:04'),
(59, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 08:31:31'),
(60, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:31:49'),
(61, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 08:34:05'),
(62, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:34:13'),
(63, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 08:34:35'),
(64, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:34:46'),
(65, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 08:40:26'),
(66, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:40:41'),
(67, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 08:43:27'),
(68, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 08:43:38'),
(69, 'otp_sent', 26, '127.0.0.1', 'success', 'OTP sent to email: rajanis2001@gmail.com', '2024-09-29 09:00:16'),
(70, 'successful_login', 26, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 09:01:00'),
(71, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 09:14:34'),
(72, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 09:14:54'),
(73, 'otp_sent', 25, '127.0.0.1', 'success', 'OTP sent to email: eforbes520@gmail.com', '2024-09-29 10:24:45'),
(74, 'successful_login', 25, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 10:24:59'),
(75, 'otp_sent', 24, '127.0.0.1', 'success', 'OTP sent to email: chalanaranwala@gmail.com', '2024-09-29 10:43:26'),
(76, 'successful_login', 24, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 10:43:39'),
(77, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 10:47:40'),
(78, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 10:48:15'),
(79, 'otp_sent', 4, '127.0.0.1', 'success', 'OTP sent to email: leco88507@gmail.com', '2024-09-29 10:53:54'),
(80, 'successful_login', 4, '127.0.0.1', 'success', 'User logged in successfully.', '2024-09-29 10:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` enum('training_deadline','incomplete_assessment','policy_change') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'incomplete_assessment', 'A new quiz has been added: ', 1, '2024-09-24 13:43:04'),
(2, 1, 'incomplete_assessment', 'A new quiz has been added: f', 1, '2024-09-24 13:43:55'),
(3, 1, 'incomplete_assessment', 'A new quiz has been added: fgh', 1, '2024-09-24 13:44:13'),
(4, 1, 'incomplete_assessment', 'A new quiz has been added: f44444', 0, '2024-09-24 13:45:37'),
(5, 1, 'policy_change', 'A new policy has been added: eeee', 0, '2024-09-24 13:51:11'),
(6, 1, 'policy_change', 'A new policy has been added: dd', 0, '2024-09-24 14:20:20'),
(7, 1, 'policy_change', 'A new policy has been added: Data Privacy Policy', 0, '2024-09-24 15:02:14'),
(8, 1, 'policy_change', 'A new policy has been added: Workplace Security Policy', 0, '2024-09-24 15:02:31'),
(9, 1, 'policy_change', 'A new policy has been added: Incident Response Policy', 0, '2024-09-24 15:02:44'),
(10, 1, 'policy_change', 'A new policy has been added: Remote Work Policy', 0, '2024-09-24 15:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

DROP TABLE IF EXISTS `policies`;
CREATE TABLE IF NOT EXISTS `policies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `title`, `description`, `file_path`, `upload_date`) VALUES
(15, 'Policy Management and Distribution Policy', 'Defines the procedures for uploading, distributing, and acknowledging security policies within the web application, ensuring all staff are informed of updates and changes.', '../../uploads/policies/Policy 5.pdf', '2024-09-26 13:17:43'),
(14, 'Security Awareness Training Policy', 'Requires IT staff to complete regular cybersecurity training modules, track their progress, and enforce deadlines to ensure staff are knowledgeable about security threats and best practices.', '../../uploads/policies/Policy 4.pdf', '2024-09-26 13:17:15'),
(11, 'Acceptable Use Policy', 'Defines appropriate and prohibited behaviors when using the Security Awareness Web Application, ensuring responsible use and compliance with company policies to protect data and systems.', '../../uploads/policies/Policy 1.pdf', '2024-09-26 13:15:15'),
(12, 'Password Management Policy', 'Ensures secure management of user credentials by enforcing complex passwords, regular changes.', '../../uploads/policies/Policy 2.pdf', '2024-09-26 13:16:16'),
(13, 'Incident Response and Monitoring Policy', 'Establishes guidelines for detecting and responding to security incidents by logging suspicious activities and using real-time monitoring tools for immediate reporting and investigation.', '../../uploads/policies/Policy 3.pdf', '2024-09-26 13:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `policy_acknowledgements`
--

DROP TABLE IF EXISTS `policy_acknowledgements`;
CREATE TABLE IF NOT EXISTS `policy_acknowledgements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `policy_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `acknowledged_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `policy_id` (`policy_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `policy_acknowledgements`
--

INSERT INTO `policy_acknowledgements` (`id`, `policy_id`, `employee_id`, `acknowledged_at`) VALUES
(1, 1, 1, '2024-09-22 17:52:32'),
(2, 7, 1, '2024-09-24 15:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int DEFAULT NULL,
  `question_text` text NOT NULL,
  `option_1` varchar(255) NOT NULL,
  `option_2` varchar(255) NOT NULL,
  `option_3` varchar(255) NOT NULL,
  `option_4` varchar(255) NOT NULL,
  `correct_option` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `correct_option`, `created_at`) VALUES
(3, 9, 'What does ', 'Attempting to guess a password', 'Sending fraudulent emails to obtain sensitive information', 'Hacking a computer system directly', 'Installing malware through physical devices', 2, '2024-09-21 13:56:55'),
(4, 9, 'Which of the following is a strong password?', '12345', 'password', 'P@ssw0rd#123', 'qwerty', 3, '2024-09-21 13:57:21'),
(5, 9, 'What does \"malware\" stand for?', 'Mandatory alerts', 'Malicious software', 'Multiple authentication layers', 'Managed learning systems', 2, '2024-09-21 13:57:45'),
(6, 9, 'What is two-factor authentication?', 'Using a strong password', 'Verifying identity with two separate methods', 'Encrypting your data', 'Using a firewall', 2, '2024-09-21 13:58:05'),
(7, 9, 'Which of the following is a common way malware spreads?', 'Firewalls', 'USB drives', 'Cloud services', 'Virtual Private Networks (VPNs)', 2, '2024-09-21 13:58:23'),
(8, 10, 'What is a firewall?', 'A device that blocks viruses', 'A security system that monitors and controls network traffic', 'Software that encrypts data', 'A tool used to protect physical hardware', 2, '2024-09-21 13:59:07'),
(9, 10, 'Which type of attack involves overwhelming a network with traffic?', 'Phishing', 'Man-in-the-middle attack', 'Denial-of-Service (DoS) attack', 'Keylogging', 3, '2024-09-21 13:59:29'),
(10, 10, 'What does VPN stand for?', 'Virtual Protocol Network', 'Virtual Private Network', 'Verified Personal Network', 'Voluntary Public Network', 2, '2024-09-21 13:59:52'),
(11, 10, 'What is the purpose of encryption in network security?', 'To prevent unauthorized access to physical hardware', 'To convert data into a secure format that cannot be easily read', 'To detect unauthorized access to a network', 'To monitor traffic between network nodes', 2, '2024-09-21 14:00:20'),
(12, 10, 'Which protocol is used for secure communication over the internet?', 'HTTP', 'FTP', 'HTTPS', 'SMTP', 3, '2024-09-21 14:00:38'),
(13, 11, 'What is social engineering in cybersecurity?', 'Manipulating individuals to gain confidential information', 'Hacking into a computer using advanced code', 'Encrypting sensitive data for protection', 'A network vulnerability scanner', 1, '2024-09-21 14:01:42'),
(14, 11, 'Which of the following is an example of a social engineering attack?', 'SQL injection', 'Email phishing', 'Installing malware via USB', 'VPN tunneling', 2, '2024-09-21 14:02:01'),
(15, 11, 'What should you do if you receive a suspicious email asking for your login details?', 'Ignore it', 'Report it to IT and delete it', 'Click the link and change your password', 'Forward it to your colleagues', 2, '2024-09-21 14:02:21'),
(16, 11, 'What is a common tactic used in a phishing email?', 'Offering free gifts or prizes', 'Asking for financial donations', 'Using threats or urgency to prompt action', 'All of the above', 4, '2024-09-21 14:02:41'),
(17, 11, 'How can you best protect yourself from social engineering attacks?', 'By installing antivirus software', 'By keeping your operating system updated', 'By being cautious and verifying requests for sensitive information', 'By changing your passwords frequently', 3, '2024-09-21 14:03:47'),
(18, 12, 'What is the GDPR?', 'General Data Protection Regulation', 'Government Data Privacy Rules', 'Global Data Protection Rights', ' General Digital Privacy Rules', 4, '2024-09-21 14:04:22'),
(19, 12, 'Which of the following is considered personally identifiable information (PII)?', 'Employee ID', 'IP address', 'Social Security number', 'Company name', 3, '2024-09-21 14:04:39'),
(20, 12, ' What is data encryption?', 'A method for securely storing data on a hard drive', 'A technique to transform data into an unreadable format to protect it', 'A tool to detect malware on your system', 'A process for physically locking up important files', 2, '2024-09-21 14:04:57'),
(21, 12, 'What is the best practice for storing sensitive data?', 'In a public cloud', 'In an encrypted format with restricted access', 'On a password-protected spreadsheet', 'In an email to the IT department', 2, '2024-09-21 14:05:34'),
(22, 12, 'What is the purpose of data masking?', 'To prevent malware from accessing sensitive files', 'To obscure sensitive data while maintaining usability', 'To delete sensitive data permanently', 'To block unauthorized users from accessing a system', 2, '2024-09-21 14:05:53'),
(23, 13, 'What is the first step in the incident response process?', 'Eradication', 'Detection and analysis', 'Recovery', 'Containment', 2, '2024-09-21 14:06:18'),
(24, 13, 'What is the primary goal of containment in incident response?', 'To restore normal business operations', 'To isolate the affected systems to prevent further damage', 'To eradicate the malware', 'To contact the incident response team', 2, '2024-09-21 14:06:38'),
(25, 13, 'Which of the following is a critical component of an incident response plan?', 'Regular software updates', 'An organized, well-documented strategy for handling incidents', 'Daily security briefings', 'User training sessions', 2, '2024-09-21 14:06:56'),
(26, 13, 'When should an incident response plan be tested?', 'Annually', 'After a security breach', 'Regularly, through drills or simulations', 'Only after major system updates', 3, '2024-09-21 14:07:14'),
(27, 13, 'What is a post-incident review?', 'A technical analysis of the attack vectors used', 'A meeting to evaluate what went well and what needs improvement after an incident', 'A review of system logs for unusual activity', 'A review of the financial damage caused by the incident', 2, '2024-09-21 14:07:35'),
(28, 23, 'What is a common indicator of a phishing email?', 'Email from a known contact with no attachments', 'Grammatical errors and a sense of urgency', 'Offers from legitimate companies', 'Proper email address from the sender', 2, '2024-09-28 06:55:48'),
(29, 23, 'Which of the following is a red flag for identifying a malicious website?', 'HTTPS in the URL', 'Frequent pop-up ads and redirects', 'Updated privacy policy', 'Contact information on the website', 2, '2024-09-28 06:57:33'),
(30, 23, 'How can you verify the legitimacy of a file before downloading it?', 'Always download files from email attachments', 'Download from any website with HTTPS', 'Check the file extension and download from trusted sources', 'Trust all files shared by friends', 3, '2024-09-28 06:58:19'),
(31, 23, 'Which of the following is NOT a way to avoid unsafe downloads?', 'Download files only from trusted websites', 'Check reviews and ratings of files before downloading', 'Disable antivirus software when downloading files', 'Avoid downloading software from unknown sources', 3, '2024-09-28 06:59:01'),
(32, 23, 'If you receive an unexpected email with an attachment, what should you do?', 'Open the attachment immediately', 'Mark the email as read and ignore it', 'Reply to the email asking for more information', 'Contact the sender to verify if it is legitimate', 4, '2024-09-28 06:59:39'),
(33, 24, 'What is a best practice for securing a workspace?', 'Leaving your computer unlocked when away', 'Writing down your password and sticking it on your monitor', 'Sharing your login credentials with colleagues', 'Using a strong password and locking your computer when not in use ', 4, '2024-09-28 07:10:38'),
(34, 24, 'What should you do with sensitive documents in your workspace?', 'Leave them on your desk for easy access', 'Store them in an unsecured drawer', 'Shred them when no longer needed', 'Share them freely with coworkers', 3, '2024-09-28 07:12:50'),
(35, 24, 'How can you secure physical access to network equipment?', 'Lock equipment in a secure room with limited access', 'Keep the equipment in a publicly accessible area', 'Place it near windows for better visibility', ' Allow anyone in the company to access the equipment', 1, '2024-09-28 07:14:04'),
(36, 24, 'Which of the following is NOT a recommended physical security measure?', 'Locking your office door when leaving', 'Installing surveillance cameras', ' Using access cards or biometrics for entry', 'Allowing visitors unsupervised access to workstations', 4, '2024-09-28 07:15:02'),
(37, 24, 'Why is it important to lock your computer when leaving your desk?', 'To ensure unauthorized individuals cannot access your system', ' To prevent coworkers from seeing your work', ' To log out of all accounts', 'To conserve battery life', 1, '2024-09-28 07:16:20'),
(38, 25, 'Which of the following is a best practice for protecting sensitive data?', 'Sharing your password with trusted coworkers', 'Encrypting sensitive files before sending them', ' Storing sensitive data on a public cloud service', 'Keeping sensitive data on a USB without any encryption', 2, '2024-09-28 07:24:29'),
(39, 25, 'What is data encryption?', 'Deleting unnecessary files from your system', ' Storing data in a remote server', 'Converting data into a code to prevent unauthorized access', 'Compressing data to save storage space', 3, '2024-09-28 07:26:36'),
(40, 25, 'Which of the following regulations is focused on data privacy?', 'PCI-DSS', ' ITIL', 'SOX', 'GDPR', 4, '2024-09-28 07:29:12'),
(41, 25, 'How should employees handle personal data under data protection laws?', 'Share it only within the company', 'Store it on personal devices', 'Always encrypt personal data when storing or transmitting it', ' Delete personal data once it’s received', 3, '2024-09-28 07:30:04'),
(42, 25, 'What should you do if you accidentally expose sensitive data?', ' Report the breach immediately to the relevant authority', ' Delete the evidence', 'Send a follow-up email explaining the mistake', 'Ignore it and hope nothing happens', 1, '2024-09-28 07:32:23'),
(43, 26, 'What is the main purpose of an internal security policy?', 'To punish employees for mistakes', ' To outline the rules and procedures for maintaining security', 'To track employee activities', 'To increase productivity', 2, '2024-09-28 07:35:59'),
(44, 26, 'Why is it important to follow LECO’s security policies?', 'To receive rewards', 'To avoid physical harm', 'To avoid additional work', 'To maintain a secure environment and protect company assets ', 4, '2024-09-28 07:36:56'),
(45, 26, 'Which of the following could be a violation of internal security policies?', 'Sharing login credentials with coworkers', ' Regularly updating software', 'Using strong passwords', ' Logging out when leaving the workstation', 1, '2024-09-28 07:38:51'),
(46, 26, 'How can employees ensure they are compliant with data security regulations?', 'Ignoring new security guidelines', 'Leaving compliance matters to the IT department', 'Staying informed and attending regular security training sessions', 'Using outdated software', 3, '2024-09-28 07:39:53'),
(47, 26, 'Which of the following is NOT a type of security compliance regulation?', 'GDPR', 'PCI-DSS', 'HIPAA', 'OSHA ', 4, '2024-09-28 07:40:39'),
(48, 27, 'Why is it important to regularly back up your data?', 'To ensure you have access to your data in case of system failure or cyberattack', 'To save space on your computer', 'To comply with company policies', 'To prevent viruses', 1, '2024-09-28 07:42:39'),
(49, 27, 'How often should backups be performed?', 'Only when there’s a system failure', 'Only when instructed by IT', 'Regularly, based on the organization’s backup schedule', 'Once a year', 3, '2024-09-28 07:43:27'),
(50, 27, 'What is the first step in recovering data after a cyberattack?', 'Contacting law enforcement', 'Restoring from the most recent backup ', 'Trying to rebuild the data manually', 'Informing coworkers about the breach', 2, '2024-09-28 07:44:24'),
(51, 27, 'Which of the following is NOT a reason to perform regular backups?', 'To protect against data loss due to ransomware', 'To comply with legal requirements', 'To recover from accidental data deletion', ' To increase your computer’s speed', 4, '2024-09-28 07:46:50'),
(52, 27, 'What is a best practice for storing backup data?', 'Store backups in a secure, off-site location', 'Keep all backups on the same computer', 'Store backups on an unencrypted external hard drive', 'Perform backups only when data loss occurs', 1, '2024-09-28 07:48:41'),
(53, 28, 'blaa', 'r', 'rr', 'ttehy', '342', 1, '2024-09-28 15:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `duration` int NOT NULL DEFAULT '30',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(26, 'Security Policies and Compliance', 'Follow internal security policies to maintain a secure and compliant environment.', 10, '2024-09-28 07:34:43', '2024-09-28 07:34:43'),
(27, 'Backup and Recovery Procedures', 'Regularly back up data to ensure recovery in case of system failure or attack.', 10, '2024-09-28 07:41:42', '2024-09-28 07:41:42'),
(23, 'Safe Internet and Email Usage', 'Learn to identify and avoid phishing emails and unsafe websites.', 10, '2024-09-28 06:54:45', '2024-09-28 06:54:45'),
(24, 'Physical Security Measures', 'Secure your workspace and equipment to prevent unauthorized access.', 10, '2024-09-28 07:07:34', '2024-09-28 07:07:34'),
(25, 'Data Protection and Privacy', 'Protect sensitive data through encryption and proper handling practices.', 10, '2024-09-28 07:20:00', '2024-09-28 07:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

DROP TABLE IF EXISTS `quiz_attempts`;
CREATE TABLE IF NOT EXISTS `quiz_attempts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `quiz_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `total_marks` int NOT NULL,
  `correct_answers` int NOT NULL,
  `wrong_answers` int NOT NULL,
  `attempted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `quiz_id`, `user_id`, `total_marks`, `correct_answers`, `wrong_answers`, `attempted_at`) VALUES
(17, 9, 1, 4, 4, 1, '2024-09-22 05:59:50'),
(18, 9, 1, 4, 4, 1, '2024-09-22 06:07:18'),
(19, 9, 1, 5, 5, 0, '2024-09-22 06:07:37'),
(20, 10, 1, 5, 5, 0, '2024-09-22 07:36:39'),
(21, 12, 1, 1, 1, 4, '2024-09-22 19:06:02'),
(22, 13, 1, 2, 2, 3, '2024-09-24 14:25:56'),
(23, 26, 24, 2, 2, 3, '2024-09-28 15:34:28'),
(24, 26, 24, 5, 5, 0, '2024-09-28 15:36:08'),
(25, 26, 24, 5, 5, 0, '2024-09-28 16:01:56'),
(26, 27, 24, 4, 4, 1, '2024-09-28 16:05:27'),
(27, 25, 25, 10, 5, 0, '2024-09-29 06:53:32'),
(28, 26, 25, 10, 5, 0, '2024-09-29 07:18:06'),
(29, 27, 25, 8, 4, 1, '2024-09-29 07:19:09'),
(30, 24, 25, 10, 5, 0, '2024-09-29 07:20:17'),
(31, 23, 25, 8, 4, 1, '2024-09-29 07:21:12'),
(32, 25, 25, 10, 5, 0, '2024-09-29 07:22:43'),
(33, 23, 25, 8, 4, 1, '2024-09-29 07:24:03'),
(34, 23, 25, 10, 5, 0, '2024-09-29 07:25:30'),
(35, 27, 25, 10, 5, 0, '2024-09-29 07:28:04'),
(36, 26, 26, 10, 5, 0, '2024-09-29 09:07:50');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

DROP TABLE IF EXISTS `quiz_results`;
CREATE TABLE IF NOT EXISTS `quiz_results` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `attempt_id` int UNSIGNED NOT NULL,
  `question_id` int UNSIGNED NOT NULL,
  `user_answer` int DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `attempt_id` (`attempt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `attempt_id`, `question_id`, `user_answer`, `is_correct`) VALUES
(1, 17, 3, 2, 1),
(2, 17, 4, 3, 1),
(3, 17, 5, 2, 1),
(4, 17, 6, 2, 1),
(5, 17, 7, 4, 0),
(6, 18, 3, 2, 1),
(7, 18, 4, 3, 1),
(8, 18, 5, 2, 1),
(9, 18, 6, 2, 1),
(10, 18, 7, 4, 0),
(11, 19, 3, 2, 1),
(12, 19, 4, 3, 1),
(13, 19, 5, 2, 1),
(14, 19, 6, 2, 1),
(15, 19, 7, 2, 1),
(16, 20, 8, 2, 1),
(17, 20, 9, 3, 1),
(18, 20, 10, 2, 1),
(19, 20, 11, 2, 1),
(20, 20, 12, 3, 1),
(21, 21, 18, 3, 0),
(22, 21, 19, 2, 0),
(23, 21, 20, 4, 0),
(24, 21, 21, 2, 1),
(25, 21, 22, 1, 0),
(26, 22, 23, 2, 1),
(27, 22, 24, 3, 0),
(28, 22, 25, 3, 0),
(29, 22, 26, 3, 1),
(30, 22, 27, 4, 0),
(31, 23, 43, 1, 0),
(32, 23, 44, 2, 0),
(33, 23, 45, 1, 1),
(34, 23, 46, 3, 1),
(35, 23, 47, 1, 0),
(36, 24, 43, 2, 1),
(37, 24, 44, 4, 1),
(38, 24, 45, 1, 1),
(39, 24, 46, 3, 1),
(40, 24, 47, 4, 1),
(41, 25, 43, 2, 1),
(42, 25, 44, 4, 1),
(43, 25, 45, 1, 1),
(44, 25, 46, 3, 1),
(45, 25, 47, 4, 1),
(46, 26, 48, 1, 1),
(47, 26, 49, 3, 1),
(48, 26, 50, 4, 0),
(49, 26, 51, 4, 1),
(50, 26, 52, 1, 1),
(51, 27, 38, 2, 1),
(52, 27, 39, 3, 1),
(53, 27, 40, 4, 1),
(54, 27, 41, 3, 1),
(55, 27, 42, 1, 1),
(56, 28, 43, 2, 1),
(57, 28, 44, 4, 1),
(58, 28, 45, 1, 1),
(59, 28, 46, 3, 1),
(60, 28, 47, 4, 1),
(61, 29, 48, 1, 1),
(62, 29, 49, 3, 1),
(63, 29, 50, 2, 1),
(64, 29, 51, 4, 1),
(65, 29, 52, 3, 0),
(66, 30, 33, 4, 1),
(67, 30, 34, 3, 1),
(68, 30, 35, 1, 1),
(69, 30, 36, 4, 1),
(70, 30, 37, 1, 1),
(71, 31, 28, 2, 1),
(72, 31, 29, 2, 1),
(73, 31, 30, 3, 1),
(74, 31, 31, 3, 1),
(75, 31, 32, 2, 0),
(76, 32, 38, 2, 1),
(77, 32, 39, 3, 1),
(78, 32, 40, 4, 1),
(79, 32, 41, 3, 1),
(80, 32, 42, 1, 1),
(81, 33, 28, 2, 1),
(82, 33, 29, 2, 1),
(83, 33, 30, 3, 1),
(84, 33, 31, 3, 1),
(85, 33, 32, 2, 0),
(86, 34, 28, 2, 1),
(87, 34, 29, 2, 1),
(88, 34, 30, 3, 1),
(89, 34, 31, 3, 1),
(90, 34, 32, 4, 1),
(91, 35, 48, 1, 1),
(92, 35, 49, 3, 1),
(93, 35, 50, 2, 1),
(94, 35, 51, 4, 1),
(95, 35, 52, 1, 1),
(96, 36, 43, 2, 1),
(97, 36, 44, 4, 1),
(98, 36, 45, 1, 1),
(99, 36, 46, 3, 1),
(100, 36, 47, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employee','admin') DEFAULT 'employee',
  `date_of_birth` date DEFAULT NULL,
  `address` text,
  `tel` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `failed_attempts` int DEFAULT '0',
  `last_failed_attempt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `date_of_birth`, `address`, `tel`, `created_at`, `updated_at`, `reset_token_hash`, `reset_token_expires_at`, `failed_attempts`, `last_failed_attempt`) VALUES
(1, 'Eran', 'hweranmadhuka@gmail.com', '$2y$10$KixYIpRMslaAI/Y3KxFrJOcBiWdsJYch8BPq7WtrpM7c6Esa3e01e', 'employee', '2024-09-11', 'Colombo', '07555554', '2024-09-20 19:07:05', '2024-09-29 06:35:41', NULL, NULL, 0, NULL),
(4, 'Admin', 'leco88507@gmail.com', '$2y$10$KWOZfn1gzbHB6BoIcJZJueTHDfKFahMN6zCpUGMl8KuW/ySyaraJ6', 'admin', NULL, NULL, NULL, '2024-09-20 20:20:40', '2024-09-28 13:55:22', NULL, NULL, 0, NULL),
(24, 'Chalana Ranawala', 'chalanaranwala@gmail.com', '$2y$10$huM5NHM5bxJAu2h/VTeQT.iF7Arlu/f1bOqlABGoUBb/hOaJYqEQ.', 'employee', '2001-02-14', '', '07655467990', '2024-09-28 13:19:17', '2024-09-29 10:46:03', NULL, NULL, 0, NULL),
(25, 'Himasha Jayasekera', 'eforbes520@gmail.com', '$2y$10$W92juIWdUJIu6hageAnsK.vchAN1J34ZEQZ5SSgl3u0X2D1YnHYxu', 'employee', '2024-09-11', '', '0714568734', '2024-09-28 16:18:24', '2024-09-29 06:49:15', NULL, NULL, 0, NULL),
(26, 'Rajani', 'rajanis2001@gmail.com', '$2y$10$INHaqYysx/afu5yRdxESOe77eliVnUo5k8ODg3KXzGDRoVJm4Zn7q', 'employee', '0000-00-00', '', '0714568700', '2024-09-28 17:02:45', '2024-09-29 08:59:45', NULL, NULL, 0, NULL),
(27, 'Tharusha Dilshan', 'theazrael29@gmail.com', '$2y$10$H5S6.lp8ivXfEnUn.eGvnOWqgHzfs9B4R7Wik8W4Xy7RILRStrsbC', 'employee', '0000-00-00', '', '', '2024-09-28 18:07:13', '2024-09-28 18:09:25', NULL, NULL, 0, NULL),
(28, 'Dulshi Siriwardhane', 'dulshi.s2001@gmail.com', '$2y$10$41t/WoLqxUn/BAHOfNrd6.t8jO22RPHSwzG8fQUMpuqveXoTg0SNq', 'employee', NULL, NULL, NULL, '2024-09-29 10:50:22', '2024-09-29 10:50:22', NULL, NULL, 0, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
