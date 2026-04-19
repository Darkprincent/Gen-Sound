<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить трек - Gen Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #2e1065 0%, #0f051d 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .form-card {
            background: rgba(20, 10, 40, 0.8);
            border: 1px solid #6a4bc2;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 30px rgba(106, 75, 194, 0.3);
            backdrop-filter: blur(10px);
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
            box-shadow: 0 0 10px rgba(209, 179, 255, 0.2);
        }
        .label-purple { color: #d1b3ff; font-weight: bold; margin-bottom: 8px; display: block; }
        .btn-purple { background: #6a4bc2; color: white; border: none; transition: 0.3s; }
        .btn-purple:hover { background: #8261e1; transform: translateY(-2px); }
    </style>
</head>
<body>
<div class="form-card">
    <h2 class="text-center mb-4" style="color: #d1b3ff; letter-spacing: 2px;">НОВЫЙ ТРЕК</h2>

    <form action="../processing/store.process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="label-purple">Название трека</label>
            <input type="text" name="title" class="form-control" placeholder="Как называется шедевр?" required>
        </div>

        <div class="mb-3">
            <label class="label-purple">Обложка (выберите файл)</label>
            <input type="file" name="cover" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="label-purple">Ссылка на музыку</label>
            <input type="text" name="link" class="form-control" placeholder="https://soundcloud.com/...">
        </div>

        <div class="mb-3">
            <label class="label-purple">Текст песни</label>
            <textarea name="text" class="form-control" rows="4" placeholder="Введите текст..."></textarea>
        </div>

        <button type="submit" class="btn btn-purple w-100 py-2 fw-bold mt-2">ОПУБЛИКОВАТЬ</button>

        <div class="mt-4 text-center">
            <a href="../index.php" class="text-white-50 small" style="text-decoration: none;">← На главную</a>
        </div>
    </form>
</div>
</body>
</html>