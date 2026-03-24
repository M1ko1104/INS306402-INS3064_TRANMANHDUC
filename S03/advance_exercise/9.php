<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        $message = "Upload failed";
    } else {

        $file = $_FILES['avatar'];

        $allowed = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($file['type'], $allowed, true)) {
            $message = "Invalid file type";
        } elseif ($file['size'] > $maxSize) {
            $message = "File too large (max 2MB)";
        } else {

            if (!is_dir('uploads')) {
                mkdir('uploads');
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = 'uploads/' . bin2hex(random_bytes(8)) . '.' . $ext;

            move_uploaded_file($file['tmp_name'], $newName);
            $message = "Upload success";
        }
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="avatar">
    <button>Upload</button>
</form>
<p><?= htmlspecialchars($message) ?></p>