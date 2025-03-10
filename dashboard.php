<?php
/**
 * Административная панель для просмотра результатов тестов.
 * Доступ разрешён только после успешной аутентификации.
 */
require_once 'functions.php';
session_start();

// Пример простой аутентификации
$adminUser = 'admin';
$adminPass = 'password'; // В реальном проекте рекомендуется хранить хеши паролей

if (!isset($_SESSION['is_admin'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] === $adminUser && $_POST['password'] === $adminPass) {
            $_SESSION['is_admin'] = true;
        } else {
            $error = "Неверные учетные данные.";
        }
    }
}

if (!isset($_SESSION['is_admin'])) {
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Админ панель</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Вход в административную панель</h1>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post" action="dashboard.php">
            <div>
                <label for="username">Логин:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Войти</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}

$results = loadResults();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты тестов</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Результаты тестов</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Имя пользователя</th>
                <th>Правильных ответов</th>
                <th>Всего вопросов</th>
                <th>Процент</th>
                <th>Дата прохождения</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
            <tr>
                <td><?php echo htmlspecialchars($result['username']); ?></td>
                <td><?php echo htmlspecialchars($result['correct']); ?></td>
                <td><?php echo htmlspecialchars($result['total']); ?></td>
                <td><?php echo htmlspecialchars($result['percentage']); ?>%</td>
                <td><?php echo htmlspecialchars($result['date']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php"><button>Вернуться на главную</button></a>
</body>
</html>
