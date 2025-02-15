-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 08:31 PM
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
-- Database: `tiffin_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Dal Tadka', 'Lentil curry with ghee', 120.00, 'https://i0.wp.com/aartimadan.com/wp-content/uploads/2020/12/Dal-Tadka.jpg?fit=1000%2C561&ssl=1'),
(2, 'Paneer Butter Masala', 'Creamy tomato paneer curry', 180.00, 'https://www.mygingergarlickitchen.com/wp-content/rich-markup-images/1x1/1x1-restaurant-style-paneer-butter-masala-paneer-makhani-video-recipe.jpg'),
(3, 'Aloo Paratha', 'Stuffed flatbread with potatoes', 90.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLG8YwQ92R5IoTE2ltluk0KkusNZ-HuZLQtw&s'),
(4, 'Chole Bhature', 'Spicy chickpeas with fried bread', 150.00, 'https://static.tnn.in/thumb/msid-117580681,thumbsize-1788517,width-448,height-252,resizemode-75/117580681.jpg'),
(5, 'Vegetable Pulao', 'Rice with mixed vegetables', 130.00, 'https://cdn1.foodviva.com/static-content/food-images/rice-recipes/vegetable-pulav-recipe/vegetable-pulav-recipe.jpg'),
(6, 'Rajma Chawal', 'Kidney beans curry with rice', 140.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrY-YDbNH_JLFnMOh26A1l7WKFgORHz6C3uQ&s'),
(7, 'Masala Dosa', 'Crispy rice crepe with potatoes', 110.00, 'https://palatesdesire.com/wp-content/uploads/2022/09/Mysore-masala-dosa-recipe@palates-desire.jpg'),
(8, 'Baingan Bharta', 'Smoky mashed eggplant curry', 125.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV8Bh_iKbLPCjH-SUm-51UgdF4YZQvuckv6w&s'),
(9, 'Gajar Ka Halwa', 'Carrot pudding with nuts', 100.00, 'https://www.livofy.com/health/wp-content/uploads/2023/05/Untitled-design-21-1-1024x576.png'),
(10, 'Roti with Sabzi', 'Roti with vegetable curry', 80.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Roti_sabji_salad.jpg/1200px-Roti_sabji_salad.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Hiren', '2021.hiren.karwani@ves.ac.in', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
