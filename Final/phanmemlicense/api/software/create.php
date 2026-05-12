<?php
require_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Giả sử lấy dữ liệu từ POST (Form hoặc Postman)
$name = $_POST['name'] ?? 'Microsoft Office 365';
$vendor = $_POST['vendor'] ?? 'Microsoft';

// BUSINESS RULE 1: Không được để trống
if(empty($name) || empty($vendor)) {
    die("Lỗi: Tên phần mềm và nhà cung cấp không được để trống!");
}

// BUSINESS RULE 2: Chặn trùng lặp tên phần mềm (Yêu cầu của giáo viên)
$check_query = "SELECT id FROM software_titles WHERE name = :name LIMIT 1";
$check_stmt = $db->prepare($check_query);
$check_stmt->bindParam(":name", $name);
$check_stmt->execute();

if($check_stmt->rowCount() > 0) {
    die("Lỗi: Phần mềm '$name' đã tồn tại trong hệ thống. Không thể thêm trùng!");
}

// Nếu qua được các bước trên thì mới thực hiện Insert (Create)
$insert_query = "INSERT INTO software_titles (name, vendor) VALUES (:name, :vendor)";
$insert_stmt = $db->prepare($insert_query);
$insert_stmt->bindParam(":name", $name);
$insert_stmt->bindParam(":vendor", $vendor);

if($insert_stmt->execute()) {
    echo "Thêm phần mềm mới thành công!";
} else {
    echo "Lỗi hệ thống khi thêm phần mềm.";
}
?>