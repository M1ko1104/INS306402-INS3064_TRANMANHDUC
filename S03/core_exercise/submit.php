<?php
// Kiểm tra xem dữ liệu có được gửi qua POST không [cite: 37]
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Lấy dữ liệu và sử dụng snake_case cho biến [cite: 105]
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    // Kiểm tra các trường trống (Error Handling) [cite: 115]
    if (empty($full_name) || empty($email) || empty($phone) || empty($message)) {
        echo "<h1>Error: Missing Data</h1>";
        echo "<p>Please go back and fill in all fields.</p>";
    } else {
        // Hiển thị dữ liệu dưới dạng danh sách cấu trúc HTML [cite: 114]
        echo "<h1>Received Information</h1>";
        echo "<ul>";
        // Sử dụng htmlspecialchars để ngăn chặn XSS 
        echo "<li><strong>Full Name:</strong> " . htmlspecialchars($full_name) . "</li>";
        echo "<li><strong>Email:</strong> " . htmlspecialchars($email) . "</li>";
        echo "<li><strong>Phone:</strong> " . htmlspecialchars($phone) . "</li>";
        echo "<li><strong>Message:</strong> " . htmlspecialchars($message) . "</li>";
        echo "</ul>";
    }
} else {
    echo "Invalid Request Method.";
}
?>