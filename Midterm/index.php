<?php

$host = 'localhost'; $dbname = 'library_db'; $user = 'root'; $pass = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}


$msg = "";

// (Delete)
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: index.php?msg=deleted"); exit;
}

//  (Create/Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $data = [
        ':isbn'   => $_POST['isbn'],
        ':title'  => $_POST['title'],
        ':author' => $_POST['author'],
        ':copies' => $_POST['copies']
    ];

    if ($id) { 
        $sql = "UPDATE books SET isbn=:isbn, title=:title, author=:author, available_copies=:copies WHERE id=:id";
        $data[':id'] = $id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $msg = "Cập nhật thành công!";
    } else { 
        $sql = "INSERT INTO books (isbn, title, author, available_copies) VALUES (:isbn, :title, :author, :copies)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $msg = "Thêm sách mới thành công!";
    }
}

// (Read One)
$editBook = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $editBook = $stmt->fetch();
}

// (Read All)
$books = $pdo->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Library Dashboard - Exam 3</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        .form-section { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; color: white; border: none; cursor: pointer; }
        .btn-add { background: #28a745; }
        .btn-edit { background: #ffc107; color: #000; }
        .btn-delete { background: #dc3545; }
        .msg { color: green; font-weight: bold; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h2>QUẢN LÝ SÁCH THƯ VIỆN</h2>
    
    <?php if ($msg || isset($_GET['msg'])): ?>
        <p class="msg"><?= $msg ?: "Thao tác thành công!" ?></p>
    <?php endif; ?>

    <div class="form-section">
        <h3><?= $editBook ? "Sửa Sách: ID " . $editBook['id'] : "Thêm Sách Mới" ?></h3>
        <form method="POST" action="index.php">
            <input type="hidden" name="id" value="<?= $editBook['id'] ?? '' ?>">
            <input type="text" name="isbn" placeholder="Mã ISBN" value="<?= $editBook['isbn'] ?? '' ?>" required>
            <input type="text" name="title" placeholder="Tiêu đề sách" value="<?= $editBook['title'] ?? '' ?>" required>
            <input type="text" name="author" placeholder="Tác giả" value="<?= $editBook['author'] ?? '' ?>" required>
            <input type="number" name="copies" placeholder="Số lượng" value="<?= $editBook['available_copies'] ?? '' ?>" required>
            <button type="submit" class="btn btn-add"><?= $editBook ? "Cập nhật" : "Lưu sách" ?></button>
            <?php if ($editBook): ?> <a href="index.php">Hủy</a> <?php endif; ?>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>ISBN</th><th>Tiêu đề</th><th>Tác giả</th><th>Sẵn có</th><th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= htmlspecialchars($b['isbn']) ?></td>
                <td><?= htmlspecialchars($b['title']) ?></td>
                <td><?= htmlspecialchars($b['author']) ?></td>
                <td><?= $b['available_copies'] ?></td>
                <td>
                    <a href="index.php?edit_id=<?= $b['id'] ?>" class="btn btn-edit">Sửa</a>
                    <a href="index.php?delete_id=<?= $b['id'] ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>