<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$errors = [];
$name = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $errors[] = "Name is required";
    }

    if (strlen($name) < 3 && $name !== '') {
        $errors[] = "Name must be at least 3 characters";
    }
}
?>
<?php if ($errors): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST">
    <input name="name" value="<?= htmlspecialchars($name) ?>">
    <button>Submit</button>
</form>