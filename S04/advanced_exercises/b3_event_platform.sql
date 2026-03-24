CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(200) NOT NULL,
    start_time DATETIME,
    end_time DATETIME,
    event_details JSON
);