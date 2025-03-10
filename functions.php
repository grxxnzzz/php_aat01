<?php
/**
 * Функции для работы с данными теста.
 * Содержит методы для загрузки вопросов, сохранения и получения результатов.
 */

/**
 * Загружает вопросы теста из файла questions.json.
 *
 * @return array Массив вопросов.
 */
function loadQuestions() {
    $file = __DIR__ . '/questions.json';
    if (!file_exists($file)) {
        die("Файл с вопросами не найден.");
    }
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    return $data;
}

/**
 * Сохраняет результат теста в файл results.json.
 *
 * @param string $username Имя пользователя.
 * @param int $correct Количество правильных ответов.
 * @param int $total Общее количество вопросов.
 * @return void
 */
function saveResult($username, $correct, $total) {
    $file = __DIR__ . '/results.json';
    $results = [];
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $results = json_decode($json, true) ?: [];
    }
    $percentage = round(($correct / $total) * 100);
    $results[] = [
        'username'   => htmlspecialchars($username),
        'correct'    => $correct,
        'total'      => $total,
        'percentage' => $percentage,
        'date'       => date('Y-m-d H:i:s')
    ];
    file_put_contents($file, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Загружает результаты тестов из файла results.json.
 *
 * @return array Массив результатов.
 */
function loadResults() {
    $file = __DIR__ . '/results.json';
    if (!file_exists($file)) {
        return [];
    }
    $json = file_get_contents($file);
    $results = json_decode($json, true) ?: [];
    return $results;
}
