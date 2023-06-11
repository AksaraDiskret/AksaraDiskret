-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2023 at 06:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aksara_diskret`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `cover` varchar(99) NOT NULL,
  `book` varchar(99) NOT NULL,
  `isbn` bigint(13) NOT NULL,
  `id` int(11) NOT NULL,
  `title` varchar(99) NOT NULL,
  `author` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`cover`, `book`, `isbn`, `id`, `title`, `author`) VALUES
('1686412656-6.png', '1686412656-id-dummy-book.pdf', 9780351460081, 1, 'blockchain developers', 'dummy'),
('1686413910-3.png', '1686413910-id-dummy-book.pdf', 9782220789972, 3, 'USB fundamentals', 'dummy'),
('1686412275-9.png', '1686412275-id-dummy-book.pdf', 9783523560596, 2, 'networking technique', 'dummy'),
('1686412601-2.png', '1686412601-id-dummy-book.pdf', 9783551445513, 1, 'GPT optimization', 'dummy'),
('1686412191-5.png', '1686412191-id-dummy-book.pdf', 9784559451575, 2, 'speed of light', 'dummy'),
('1686412731-10.png', '1686412731-id-dummy-book.pdf', 9785745848759, 1, 'privacy vulnerability', 'dummy'),
('1686412388-11.png', '1686412388-id-dummy-book.pdf', 9787010940588, 2, 'assembly language for beginners', 'dummy'),
('1686412119-8.png', '1686412119-id-dummy-book.pdf', 9787696703965, 3, 'intro to code', 'dummy'),
('1686412026-4.png', '1686412026-id-dummy-book.pdf', 9788197150272, 3, 'digitalization', 'dummy'),
('1686413752-12.png', '1686413752-id-dummy-book.pdf', 9788334062437, 3, 'rocket automation', 'dummy'),
('1686413693-7.png', '1686413693-id-dummy-book.pdf', 9788457299048, 2, 'droneware', 'dummy'),
('1686412909-1.png', '1686412909-id-dummy-book.pdf', 9788798738022, 1, 'aksara diskret secret', 'AD Team');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `picture` varchar(99) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `picture`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, '1686413481-r.png', 'rezky', 'wahyudi m', 'rezky@mail.com', '$2y$10$KvUeDwSmKHBwDyoCgnh/7.pAKm6zBAbIV68pU3zPzT1k4bMMULxtO'),
(2, 'default.png', 'm rizky', 'saria', 'rizky@mail.com', '$2y$10$ZBsaE5DMjh19FVkUECwIIuZ9dPoqkIx49QfWs5mJ/0hVKReoL5xAq'),
(3, 'default.png', 'daniel', 'rompas', 'daniel@mail.com', '$2y$10$o8/RzEm1K5NIcNWkU2F8GOvHDPfMQff9TSb.7UA8QWPk2Zk4DPmO6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`isbn`),
  ADD KEY `fk_users` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
