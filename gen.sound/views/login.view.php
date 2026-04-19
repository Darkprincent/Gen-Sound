<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - Gen Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #2e1065 0%, #0f051d 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .auth-card {
            background: rgba(20, 10, 40, 0.8);
            border: 1px solid #6a4bc2;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 30px rgba(106, 75, 194, 0.3);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #4a308d;
            color: white;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: #d1b3ff;
            box-shadow: none;
        }
    </style>
</head>
<body>
<div class="auth-card">
    <h2 class="text-center mb-4" style="color: #d1b3ff;">Вход</h2>
    <form action="../processing/login.process.php" method="post">
        <div class="mb-3">
            <label class="form-label" style="color: #d1b3ff;">Имя пользователя</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label" style="color: #d1b3ff;">Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn w-100 fw-bold" style="background: #6a4bc2; color: white;">ВОЙТИ</button>
        <div class="mt-3 text-center">
            <a href="register.view.php" class="text-info small">Нет аккаунта? Зарегистрироваться</a>
        </div>
        <a href="../index.php" class="d-block text-center mt-2 text-white-50 small">На главную</a>
    </form>
</div>
</body>
</html>