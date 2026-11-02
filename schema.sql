-- SEN 305 Group 6: Student Biodata Management System
-- Database Schema for MySQL / MariaDB (XAMPP)

CREATE DATABASE IF NOT EXISTS `sen305-group6` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sen305-group6`;

-- Table 1: Users (Authentication)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table 2: Biodata (Student Records)
CREATE TABLE IF NOT EXISTS `biodata` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `fullname` VARCHAR(150) NOT NULL,
    `matric_no` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `dob` DATE NOT NULL,
    `level` VARCHAR(10) NOT NULL,
    `gender` VARCHAR(10) NOT NULL,
    `department` VARCHAR(100) NOT NULL,
    `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_biodata_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;
