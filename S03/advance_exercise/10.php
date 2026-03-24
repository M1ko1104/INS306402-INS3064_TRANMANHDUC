<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

$_SESSION['token'] ??= bin2hex(random_bytes(32));
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token = $_POST['token'] ?? '';

    if (!hash_equals($_SESSION['token'], $token)) {
        http_response_code(403);
        die("Forbidden");
    }

    $message = "CSRF verified";
}
?>
<form method="POST">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
    <button>Submit</button>
</form>
<p><?= htmlspecialchars($message) ?></p>