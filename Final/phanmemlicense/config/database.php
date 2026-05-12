<?php
class Database {
    // Thông tin cấu hình kết nối (Sửa lại theo máy của bạn)
    private $host = "localhost";
    private $db_name = "slt"; // Tên database bạn tạo trong phpMyAdmin
    private $username = "root";              // Mặc định XAMPP là root
    private $password = "";                  // Mặc định XAMPP là rỗng
    public $conn;

    // Hàm lấy kết nối CSDL
    public function getConnection() {
        $this->conn = null;

        try {
            // Sử dụng PDO để kết nối
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            
            // Cấu hình bắt lỗi (Bắt buộc để debug dễ hơn)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            echo "Lỗi kết nối CSDL: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>