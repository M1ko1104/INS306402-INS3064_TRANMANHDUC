<?php
// Nhúng file kết nối
require_once './config/database.php';

$database = new Database();
$db = $database->getConnection();

if($db){
    echo "Tuyệt vời! Đã kết nối Database thành công. Bắt đầu code CRUD thôi!";
} else {
    echo "Opps! Kết nối thất bại. Hãy kiểm tra lại thông tin trong database.php.";
}
?>