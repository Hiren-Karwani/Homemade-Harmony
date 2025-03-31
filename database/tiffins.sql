-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 02:29 PM
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
-- Database: `tiffins`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'Hiren', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('COD','UPI','Card') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `schedule_id`, `order_date`, `status`, `total_amount`, `payment_method`) VALUES
(1, 1, 2, '2024-03-25 05:00:00', 'completed', 170.00, 'Card'),
(2, 2, 1, '2024-03-26 07:15:00', 'completed', 170.00, 'UPI'),
(3, 3, 4, '2024-03-27 09:30:00', 'cancelled', 170.00, 'COD'),
(4, 4, 3, '2024-03-20 03:50:00', 'completed', 170.00, 'UPI'),
(5, 5, 5, '2024-03-22 08:45:00', 'cancelled', 170.00, 'COD');

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
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `meal` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `day`, `meal`, `price`) VALUES
(1, 'Monday', 'Paneer Butter Masala, Roti, Dal, Rice', 120.00),
(2, 'Tuesday', 'Aloo Paratha with Curd and Pickle', 90.00),
(3, 'Wednesday', 'Rajma Chawal with Salad', 110.00),
(4, 'Thursday', 'Chole Bhature with Raita', 100.00),
(5, 'Friday', 'Mixed Veg, Roti, Dal Tadka, Rice', 115.00),
(6, 'Saturday', 'Pav Bhaji with Butter Pav', 105.00),
(7, 'Sunday', 'Special Thali (Paneer, Roti, Rice, Sweet)', 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`) VALUES
(1, 'Hiren', '2021.hiren.karwani@ves.ac.in', '202cb962ac59075b964b07152d234b70', 'kurla'),
(2, 'jane_smith', 'jane@example.com', 'hashed_password_2', 'Bandra East, Mumbai'),
(3, 'alice_wonder', 'alice@example.com', 'hashed_password_3', 'Dadar, Mumbai'),
(4, 'bob_marley', 'bob@example.com', 'hashed_password_4', 'Colaba, Mumbai'),
(5, 'charlie_brown', 'charlie@example.com', 'hashed_password_5', 'Goregaon East, Mumbai'),
(6, 'john_doe', 'john@example.com', 'hashed_password_1', 'Andheri West, Mumbai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
