CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    department ENUM('HR','Engineering','Sales','Marketing','Finance'),
    hire_date DATE,
    salary DECIMAL(15,2)
);