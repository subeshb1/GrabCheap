-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2017 at 03:21 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Firstname` varchar(15) NOT NULL,
  `Lastname` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Birthday` datetime NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Country` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Username`, `Password`, `Firstname`, `Lastname`, `Email`, `Birthday`, `Gender`, `Country`) VALUES
(1, 'admin', 'admin', '', '', '', '0000-00-00 00:00:00', '', ''),
(2, 'admin', 'admin', '', '', '', '0000-00-00 00:00:00', '', ''),
(3, 'ashmin', 'ashmin', 'ashmin', 'karki', 'ashmin@gmail.com', '1996-09-30 00:00:00', 'male', ''),
(4, 'ragh', 'ragh', 'rag', 'shres', 'ragh@gmail.com', '2000-01-12 00:00:00', 'male', ''),
(5, 'dee', 'dee', 'dee', 'pak', 'dee@gmail.com', '2001-01-30 00:00:00', 'male', ''),
(6, 'adminasd', 'adminasd', 'asd', 'asd', 'asd@gmail.com', '2003-12-12 00:00:00', 'female', 'india'),
(7, 'maestro', 'maestro', 'maestro', 'ashmin', 'maestro@gmail.com', '1996-09-09 00:00:00', 'male', 'nepal'),
(8, 'admindf', 'admindf', 'fd', 'df', 'df', '2000-02-20 00:00:00', 'female', 'china'),
(9, 'try', 'try', 'try', 'try', 'try@gmail.com', '2005-12-30 00:00:00', 'male', 'india'),
(11, 'nilish', 'nilish', 'nilish', 'shakya', 'nilish@gmail.com', '1997-06-01 00:00:00', 'male', 'nepal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
