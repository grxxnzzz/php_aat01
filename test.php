<?php
/**
 * Страница прохождения теста.
 * Загружает вопросы из файла и отображает их с соответствующими элементами формы.
 */
require_once 'functions.php';
$questions = loadQuestions();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Тестирование</h1>
    <form action="result.php" method="post">
        <!-- Ввод имени пользователя -->
        <div>
            <label for="username">Введите ваше имя:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <!-- Вывод вопросов -->
        <?php foreach ($questions as $index => $question): ?>
            <fieldset>
                <legend><?php echo ($index + 1) . ". " . htmlspecialchars($question['text']); ?></legend>
                <?php if ($question['type'] === 'single'): ?>
                    <?php foreach ($question['options'] as $optionKey => $optionValue): ?>
                        <div>
                            <input type="radio" name="answer[<?php echo $index; ?>]" value="<?php echo $optionKey; ?>" required>
                            <label><?php echo htmlspecialchars($optionValue); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($question['type'] === 'multiple'): ?>
                    <?php foreach ($question['options'] as $optionKey => $optionValue): ?>
                        <div>
                            <input type="checkbox" name="answer[<?php echo $index; ?>][]" value="<?php echo $optionKey; ?>">
                            <label><?php echo htmlspecialchars($optionValue); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </fieldset>
        <?php endforeach; ?>
        <button type="submit">Отправить</button>
    </form>
    <a href="index.php"><button id="backbtn">Вернуться на главную</button></a>
</body>
</html>
