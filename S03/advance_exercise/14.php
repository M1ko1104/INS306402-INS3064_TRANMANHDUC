<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$page = $_GET['page'] ?? 'home';

function render(string $content): void {
    echo "<h1>$content</h1>";
}

switch ($page) {
    case 'home':
        render('Home Page');
        break;
    case 'about':
        render('About Page');
        break;
    default:
        http_response_code(404);
        render('404 Not Found');
}
?>
<a href="?page=home">Home</a> |
<a href="?page=about">About</a>