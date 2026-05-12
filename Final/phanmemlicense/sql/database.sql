-- Xóa bảng nếu tồn tại
DROP TABLE IF EXISTS usage_stats, revocation_logs, expiry_notifications, activation_logs, license_allocations, allocation_rules, license_pools, software_titles, users;

-- 1. Bảng Users (Rút gọn)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role VARCHAR(20) NOT NULL, -- 'STUDENT' hoặc 'TEACHER'
    department_id VARCHAR(50)
);

-- 2. Bảng Danh mục phần mềm (Rút gọn)
CREATE TABLE software_titles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    vendor VARCHAR(100) NOT NULL
);

-- 3. Bảng Kho License (Chỉ giữ lại số lượng và hạn)
CREATE TABLE license_pools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    software_id INT NOT NULL,
    total_quantity INT NOT NULL,
    available_quantity INT NOT NULL,
    expiry_date DATETIME NOT NULL,
    FOREIGN KEY (software_id) REFERENCES software_titles(id)
);

-- 4. Bảng Quy tắc cấp phát (Rút gọn logic)
CREATE TABLE allocation_rules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    software_id INT NOT NULL,
    target_role VARCHAR(20) NOT NULL, -- Ai được cấp?
    duration_days INT NOT NULL,       -- Được dùng trong bao nhiêu ngày?
    FOREIGN KEY (software_id) REFERENCES software_titles(id)
);

-- 5. Bảng Cấp phát thực tế (Trọng tâm của Allocation Engine)
CREATE TABLE license_allocations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pool_id INT NOT NULL,
    user_id INT NOT NULL,
    valid_until DATETIME NOT NULL,
    status VARCHAR(20) DEFAULT 'ACTIVE', -- 'ACTIVE', 'EXPIRED', 'REVOKED'
    FOREIGN KEY (pool_id) REFERENCES license_pools(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 6. Bảng Ghi nhận kích hoạt (Chỉ lưu thời gian)
CREATE TABLE activation_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    allocation_id INT NOT NULL,
    activated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (allocation_id) REFERENCES license_allocations(id)
);

-- 7. Bảng Lịch sử gửi Email nhắc hạn (Phục vụ Expiry Notification)
CREATE TABLE expiry_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    allocation_id INT NOT NULL,
    notification_type VARCHAR(20) NOT NULL, -- '7_DAYS', '1_DAY'
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (allocation_id) REFERENCES license_allocations(id)
);

-- 8. Bảng Lịch sử thu hồi
CREATE TABLE revocation_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    allocation_id INT NOT NULL,
    reason VARCHAR(100) NOT NULL, -- Ghi chú lý do thu hồi
    revoked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (allocation_id) REFERENCES license_allocations(id)
);

-- 9. Bảng Thống kê (Phục vụ Usage Analytics)
CREATE TABLE usage_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    software_id INT NOT NULL,
    term_name VARCHAR(50) NOT NULL, -- Tên học kỳ (VD: 'HK1_2026')
    total_allocated INT DEFAULT 0,
    total_activated INT DEFAULT 0,
    activation_rate DECIMAL(5, 2) DEFAULT 0.00, -- Tính tỉ lệ %
    FOREIGN KEY (software_id) REFERENCES software_titles(id)
);