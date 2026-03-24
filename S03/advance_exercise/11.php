<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = $_POST['password'] ?? '';

    if (!preg_match('/[A-Z]/', $password)) {
        $error = "Missing uppercase";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error = "Missing lowercase";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "Missing number";
    } elseif (!preg_match('/[\W]/', $password)) {
        $error = "Missing symbol";
    } else {
        $error = "Password valid";
    }
}
?>
<form method="POST">
    <input type="password" name="password">
    <button>Check</button>
</form>
<p><?= htmlspecialchars($error) ?></p>