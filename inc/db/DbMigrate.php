<?php

$db = (new MyDB())->db;

//Пользователи
$sql = "CREATE TABLE IF NOT EXISTS `users` (
	`id` int NOT NULL AUTO_INCREMENT UNIQUE,
	`first_name` VARCHAR(255),
	`last_name` VARCHAR(255),
	`birthday` DATE,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`)
) CHARACTER SET utf8;";

mysqli_query($db, $sql);

//Товары
$sql = "CREATE TABLE IF NOT EXISTS `products` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`title` VARCHAR(255) NOT NULL,
	`price` DECIMAL,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`)
) CHARACTER SET utf8;";

mysqli_query($db, $sql);

//Заказы
$sql = "CREATE TABLE IF NOT EXISTS `orders` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`user_id` INTEGER NOT NULL,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`),
    FOREIGN KEY(`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) CHARACTER SET utf8;";

mysqli_query($db, $sql);

//Товары в заказах
$sql = "CREATE TABLE IF NOT EXISTS `order_products` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`order_id` INTEGER NOT NULL,
	`product_id` INTEGER NOT NULL,
	`quantity` INTEGER DEFAULT 0,
	PRIMARY KEY(`id`),
    FOREIGN KEY(`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY(`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
) CHARACTER SET utf8;";

mysqli_query($db, $sql);

mysqli_close($db);