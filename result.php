<?php
/**
 * Обработка результатов теста.
 * Валидирует данные, вычисляет количество правильных ответов и сохраняет результат.
 */
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
if (empty($username)) {
    die("Имя не может быть пустым.");
}

$submittedAnswers = $_POST['answer'] ?? [];
$questions = loadQuestions();
$totalQuestions = count($questions);
$correctCount = 0;

// Проход по всем вопросам для проверки ответов
foreach ($questions as $index => $question) {
    $correctAnswer = $question['correct'];
    if ($question['type'] === 'single') {
        if (isset($submittedAnswers[$index]) && $submittedAnswers[$index] === $correctAnswer) {
            $correctCount++;
        }
    } elseif ($question['type'] === 'multiple') {
        $userAnswer = isset($submittedAnswers[$index]) ? $submittedAnswers[$index] : [];
        if (is_array($userAnswer)) {
            sort($userAnswer);
            $expected = $correctAnswer;
            sort($expected);
            if ($userAnswer === $expected) {
                $correctCount++;
            }
        }
    }
}
$percentage = round(($correctCount / $totalQuestions) * 100);
saveResult($username, $correctCount, $totalQuestions);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты теста</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Результаты теста</h1>
    <p>Количество правильных ответов: <?php echo $correctCount; ?> из <?php echo $totalQuestions; ?></p>
    <p>Набрано баллов: <?php echo $percentage; ?>%</p>
    <a href="index.php"><button>Вернуться на главную</button></a>
</body>
</html>
