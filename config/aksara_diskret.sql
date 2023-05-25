-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 12:53 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@aksaradiskret.cloud', '$2y$10$Nsrx2qbphr2FcoCOYQ4oJuX304IikDfQjUZhbr1pLPz2O/tI/Te2O');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `cover` varchar(99) NOT NULL,
  `book` varchar(99) NOT NULL,
  `isbn` bigint(13) NOT NULL,
  `title` varchar(99) NOT NULL,
  `author` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`cover`, `book`, `isbn`, `title`, `author`) VALUES
('1685004756-deepmind-mWztzk66I7Q-unsplash.jpg', '1685004756-AD-Secret-Book.pdf', 9780258222782, 'Singularity Paradox', 'Olivia Chen'),
('1685004817-deepmind-3VSgApkySLA-unsplash.jpg', '1685004817-AD-Secret-Book.pdf', 9782335341133, 'AI Rebellion', 'Ethan Zhang'),
('1685004872-wilhelm-gunkel-aEECAd2HuUE-unsplash.jpg', '1685004872-AD-Secret-Book.pdf', 9782463696112, 'The Glass House', 'Jane Sanchez'),
('1685005475-erol-ahmed-5nFU8l0RDiY-unsplash.jpg', '1685005475-AD-Secret-Book.pdf', 9783127757644, 'The Hidden City', 'Carlos Rodriguez'),
('1685004914-mk-s-_j0Wjh0Ya8I-unsplash.jpg', '1685004914-AD-Secret-Book.pdf', 9785240080548, 'Designing Realities', 'Kevin Chen'),
('1685004946-ivan-aleksic-FoYLV60_eHY-unsplash.jpg', '1685004946-AD-Secret-Book.pdf', 9785862813142, 'Blueprint for Chaos', 'Matthew Davis'),
('1685004689-deepmind-X5CSjHTjlgw-unsplash.jpg', '1685004689-AD-Secret-Book.pdf', 9786011789073, 'Neural Network', 'Andrew Kim'),
('1685004600-deepmind-esyG2Jt_uIc-unsplash.jpg', '1685004600-AD-Secret-Book.pdf', 9787825426666, 'Learning Algorithm', 'Karen Liu');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`isbn`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
