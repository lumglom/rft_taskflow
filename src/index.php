<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('MYSQL_DATABASE') ?: 'taskflow';
$user = getenv('MYSQL_USER') ?: 'taskflow_user';
$pass = getenv('MYSQL_PASSWORD') ?: '';

$dbStatus = "Kapcsolódás folyamatban...";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $dbStatus = "Sikeres kapcsolat a MySQL 8.4 adatbázissal!";
} catch (PDOException $e) {
    $dbStatus = "Adatbázis hiba: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow - Docker Stack</title>
</head>
<body>
    <h1>TaskFlow Webszerver</h1>
    <p><strong>Készítette:</strong> Bartha Krisztián</p>
    <p><strong>Adatbázis állapot:</strong> <?= htmlspecialchars($dbStatus) ?></p>
</body>
</html>