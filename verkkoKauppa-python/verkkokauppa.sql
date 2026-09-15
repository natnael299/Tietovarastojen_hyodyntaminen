-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2026 at 11:50 AM
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
-- Database: `verkkokauppa`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `address`) VALUES
(1, 'John', 'Smith', '10 Main Street, Helsinki'),
(2, 'Emma', 'Johnson', '25 Oak Road, Espoo'),
(3, 'Michael', 'Brown', '8 Park Avenue, Vantaa'),
(4, 'Sofia', 'Williams', '14 Lake Street, Turku'),
(5, 'Daniel', 'Jones', '32 River Road, Tampere'),
(6, 'Olivia', 'Garcia', '7 Forest Avenue, Oulu'),
(7, 'James', 'Miller', '19 Hill Street, Lahti'),
(8, 'Ava', 'Davis', '44 Central Road, Pori'),
(9, 'William', 'Wilson', '3 Market Street, Kuopio'),
(10, 'Mia', 'Anderson', '21 Garden Road, Jyväskylä'),
(11, 'Alexander', 'Taylor', '6 Station Street, Vaasa'),
(12, 'Ella', 'Thomas', '15 Beach Road, Helsinki'),
(13, 'Benjamin', 'Moore', '28 School Street, Espoo'),
(14, 'Isabella', 'Martin', '11 Church Road, Turku'),
(15, 'Lucas', 'Jackson', '39 Sports Avenue, Tampere');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `customer_id`, `order_date`) VALUES
(1, 1, 1, '2026-09-01'),
(2, 2, 2, '2026-09-02'),
(3, 3, 3, '2026-09-03'),
(4, 4, 4, '2026-09-04'),
(5, 5, 5, '2026-09-05'),
(6, 6, 6, '2026-09-06'),
(7, 7, 7, '2026-09-07'),
(8, 8, 8, '2026-09-08'),
(9, 9, 9, '2026-09-09'),
(10, 10, 10, '2026-09-10'),
(11, 11, 11, '2026-09-11'),
(12, 12, 12, '2026-09-12'),
(13, 13, 13, '2026-09-13'),
(14, 14, 14, '2026-09-14'),
(15, 15, 15, '2026-09-14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'Laptop', 899.99),
(2, 'Wireless Mouse', 24.99),
(3, 'Mechanical Keyboard', 79.99),
(4, '27 inch Monitor', 249.99),
(5, 'USB-C Cable', 12.99),
(6, 'Webcam', 59.99),
(7, 'Headphones', 89.99),
(8, 'Laptop Stand', 39.99),
(9, 'External SSD 1TB', 109.99),
(10, 'USB Hub', 29.99),
(11, 'Gaming Chair', 199.99),
(12, 'Bluetooth Speaker', 69.99),
(13, 'Wireless Charger', 34.99),
(14, 'Tablet', 399.99),
(15, 'Smartphone', 699.99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`,`customer_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
