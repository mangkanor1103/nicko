-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 12:29 AM
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
-- Database: `mangyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(11) NOT NULL,
  `tagalog_word` varchar(255) NOT NULL,
  `mangyan_word` varchar(255) NOT NULL,
  `dialect` enum('Hanunuo','Buhid','Tawbuid','Iraya') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `tagalog_word`, `mangyan_word`, `dialect`) VALUES
(1, 'tubig', 'danum', 'Hanunuo'),
(2, 'bahay', 'balay', 'Hanunuo'),
(3, 'tao', 'tawu', 'Buhid'),
(4, 'araw', 'aldaw', 'Tawbuid'),
(5, 'gabi', 'rabii', 'Iraya'),
(6, 'salamat', 'madakul salamat', 'Hanunuo'),
(7, 'pagkain', 'kanin', 'Buhid'),
(8, 'ilaw', 'suga', 'Tawbuid'),
(9, 'babae', 'bayi', 'Iraya'),
(10, 'lalaki', 'lalake', 'Hanunuo'),
(11, 'Araw', 'Adlaw', 'Hanunuo'),
(12, 'Buwan', 'Buwan', 'Hanunuo'),
(14, 'Pamilya', 'Pamilya', 'Hanunuo'),
(15, 'Kaibigan', 'Kaibigan', 'Hanunuo'),
(16, 'Pag-ibig', 'Pag-ibig', 'Hanunuo'),
(17, 'Kumusta', 'Kumusta', 'Hanunuo'),
(18, 'Salamat', 'Salamat', 'Hanunuo'),
(19, 'Sinigang', 'Sinigang', 'Hanunuo'),
(20, 'Laban', 'Laban', 'Hanunuo'),
(21, 'Tao', 'Tao', 'Hanunuo'),
(22, 'Bata', 'Bata', 'Hanunuo'),
(23, 'Matanda', 'Matanda', 'Hanunuo'),
(24, 'Guro', 'Guro', 'Hanunuo'),
(25, 'Siyensya', 'Siyensya', 'Hanunuo'),
(26, 'Kultura', 'Kultura', 'Hanunuo'),
(27, 'Wika', 'Wika', 'Hanunuo'),
(28, 'Lupa', 'Lupa', 'Hanunuo'),
(29, 'Dagat', 'Dagat', 'Hanunuo'),
(30, 'Bundok', 'Bundok', 'Hanunuo'),
(31, 'Puno', 'Puno', 'Hanunuo'),
(32, 'Saging', 'Saging', 'Hanunuo'),
(33, 'Mangga', 'Mangga', 'Hanunuo'),
(34, 'Buko', 'Buko', 'Hanunuo'),
(35, 'Kape', 'Kape', 'Hanunuo'),
(36, 'Timpla', 'Timpla', 'Hanunuo'),
(37, 'Sariwa', 'Sariwa', 'Hanunuo'),
(38, 'Pagsasaka', 'Pagsasaka', 'Hanunuo'),
(39, 'Buhay', 'Buhay', 'Hanunuo'),
(40, 'Kain', 'Kain', 'Hanunuo'),
(41, 'Uminom', 'Uminom', 'Hanunuo'),
(42, 'Matamis', 'Matamis', 'Hanunuo'),
(43, 'Maasim', 'Maasim', 'Hanunuo'),
(44, 'Malasa', 'Malasa', 'Hanunuo'),
(45, 'Malambot', 'Malambot', 'Hanunuo'),
(46, 'Mabilis', 'Mabilis', 'Hanunuo'),
(47, 'Mabagal', 'Mabagal', 'Hanunuo'),
(48, 'Malinis', 'Malinis', 'Hanunuo'),
(49, 'Marumi', 'Marumi', 'Hanunuo'),
(50, 'Masaya', 'Masaya', 'Hanunuo'),
(51, 'Malungkot', 'Malungkot', 'Hanunuo'),
(52, 'Puno ng pag-asa', 'Puno ng pag-asa', 'Hanunuo'),
(53, 'Puno ng takot', 'Puno ng takot', 'Hanunuo'),
(54, 'Puno ng galit', 'Puno ng galit', 'Hanunuo'),
(55, 'Puno ng saya', 'Puno ng saya', 'Hanunuo'),
(56, 'Puno ng lungkot', 'Puno ng lungkot', 'Hanunuo'),
(57, 'Puno ng pagmamahal', 'Puno ng pagmamahal', 'Hanunuo'),
(58, 'Puno ng pagkakaibigan', 'Puno ng pagkakaibigan', 'Hanunuo'),
(59, 'Puno ng pagkakaunawaan', 'Puno ng pagkakaunawaan', 'Hanunuo'),
(60, 'Puno ng pagkakaiba', 'Puno ng pagkakaiba', 'Hanunuo'),
(61, 'Puno ng pagkakaisa', 'Puno ng pagkakaisa', 'Hanunuo'),
(62, 'ang', 'su', 'Hanunuo'),
(63, 'ay', 'ga', 'Hanunuo'),
(64, 'ako', 'ak', 'Hanunuo'),
(65, 'ikaw', 'ka', 'Hanunuo'),
(66, 'siya', 'si', 'Hanunuo'),
(67, 'kami', 'kami', 'Hanunuo'),
(68, 'tayo', 'tamo', 'Hanunuo'),
(69, 'sila', 'sera', 'Hanunuo'),
(70, 'ito', 'sani', 'Hanunuo'),
(71, 'iyan', 'sana', 'Hanunuo'),
(72, 'oo', 'u', 'Hanunuo'),
(73, 'hindi', 'ew', 'Hanunuo'),
(74, 'gusto', 'gana', 'Hanunuo'),
(75, 'ayaw', 'ani', 'Hanunuo'),
(76, 'bahay', 'balay', 'Hanunuo'),
(77, 'guro', 'magtutudlo', 'Hanunuo'),
(78, 'pagkain', 'kan-on', 'Hanunuo'),
(79, 'tubig', 'danum', 'Hanunuo'),
(80, 'araw', 'adlaw', 'Hanunuo'),
(81, 'gabi', 'gab-i', 'Hanunuo'),
(82, 'bundok', 'bukid', 'Hanunuo'),
(83, 'kaibigan', 'kaayupanan', 'Hanunuo'),
(84, 'pamilya', 'pamilya', 'Hanunuo'),
(85, 'salamat', 'mabud', 'Hanunuo'),
(86, 'paalam', 'bay-bay', 'Hanunuo'),
(87, 'anong', 'ano', 'Hanunuo'),
(88, 'bakit', 'uy', 'Hanunuo'),
(89, 'saan', 'ayep', 'Hanunuo'),
(90, 'kailan', 'kena', 'Hanunuo'),
(91, 'paano', 'panuy', 'Hanunuo'),
(92, 'maganda', 'magan', 'Hanunuo'),
(93, 'pangit', 'marayaw', 'Hanunuo'),
(94, 'malaki', 'dakula', 'Hanunuo'),
(95, 'maliit', 'gamay', 'Hanunuo'),
(96, 'malakas', 'makusug', 'Hanunuo'),
(97, 'mahina', 'huyang', 'Hanunuo'),
(98, 'mabilis', 'mapud', 'Hanunuo'),
(99, 'mabagal', 'madugay', 'Hanunuo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
