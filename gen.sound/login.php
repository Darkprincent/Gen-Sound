<?php
session_start();
$host = '127.0.0.1';
$db   = 'gen.sound';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Ищем автора по имени
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE name = ?");
    $stmt->execute([$name]);
    $user = $stmt->fetch();

    // Простая проверка (в идеале здесь должно быть password_verify)
    if ($user && $user['password'] == $password) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role'] // Поле role мы добавили ранее через ALTER TABLE
        ];
        header("Location: index.php");
        exit;
    } else {
        $error = "Неверное имя или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в Gen Sound</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.8em; }
    </style>
</head>
<body>
<div class="login-card">
    <h2>Вход</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Имя (напр. Darprincent)" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <p style="font-size: 0.8em; text-align: center;"><a href="index.php">Вернуться на главную</a></p>
</div>
</body>
</html>