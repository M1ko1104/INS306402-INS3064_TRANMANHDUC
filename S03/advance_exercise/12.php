<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$data = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
?>
<form method="GET">
    <input name="name" placeholder="GET name">
    <button>Send GET</button>
</form>

<form method="POST">
    <input name="name" placeholder="POST name">
    <button>Send POST</button>
</form>

<pre><?php print_r($data); ?></pre>