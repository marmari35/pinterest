<?php
require_once 'config.php'; // Подключение файла с настройками Pinterest API

// 1. Получение последнего товара из фида
$feed_url = 'https://soviet-box.com/feeds/facebook.xml';
$xml = simplexml_load_file($feed_url);
$last_item = $xml->item[count($xml->item) - 1];
$item_title = (string) $last_item->title;
$image_url = (string) $last_item->image_link;

// 2. Получение списка досок Pinterest
// Используем get_boards.php для получения списка досок
// Предполагается, что get_boards.php возвращает массив с названиями досок
require_once 'get_boards.php';
$boards = get_boards();

// 3. Сопоставление товара с доской
$selected_board = null;
foreach ($boards as $board) {
    // Простая логика сопоставления: если название товара содержится в названии доски
    if (stripos($board, $item_title) !== false) {
        $selected_board = $board;
        break;
    }
}

if (!$selected_board) {
    die("Подходящая доска не найдена!");
}

// 4. Создание пина на выбранной доске
// Используем Pinterest API для создания пина
// Предполагается, что у вас есть функция create_pin, которая принимает название доски, заголовок пина и URL изображения
// и возвращает true в случае успеха или false в случае ошибки
// (Реализация create_pin зависит от используемой вами библиотеки Pinterest API)
require_once 'pinterest_api.php'; // Подключение файла с функциями Pinterest API

if (create_pin($selected_board, $item_title, $image_url)) {
    echo "Пин успешно создан!";
} else {
    echo "Ошибка при создании пина!";
}