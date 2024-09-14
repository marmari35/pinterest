<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

$access_token = $_SESSION['access_token'];

// Запрос списка досок
$url = 'https://api.pinterest.com/v5/boards';

$options = [
    'http' => [
        'header' => [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ],
        'method' => 'GET'
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo "Ошибка получения списка досок!";
    exit();
}

$data = json_decode($response, true);

// Создаем CSV файл
$csv_file = 'boards.csv';
$fp = fopen($csv_file, 'w');

// Заголовки CSV
fputcsv($fp, ['ID', 'Название', 'Описание', 'Пин-код', 'Количество подписчиков']);

foreach ($data['items'] as $board) {
    fputcsv($fp, [
        $board['id'],
        $board['name'],
        $board['description'],
        $board['pin_count'],
        $board['follower_count']
    ]);
}

fclose($fp);
echo "Список досок успешно записан в $csv_file";
?>
