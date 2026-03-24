CREATE DATABASE student_management_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE student_management_db;

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    department VARCHAR(100)
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_code VARCHAR(50) UNIQUE,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    class_id INT,
    FOREIGN KEY (class_id) REFERENCES classes(id)
);