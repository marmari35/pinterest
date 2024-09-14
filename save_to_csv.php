<?php
// save_to_csv.php

// Читаем список досок из файла
$boards = json_decode(file_get_contents('boards.json'), true);

// Открываем CSV файл для записи
$csv_file = fopen('boards.csv', 'w');

// Заголовки CSV
fputcsv($csv_file, array('ID', 'Name', 'Description', 'Pin Count', 'Follower Count', 'Privacy', 'Image URL'));

// Записываем данные в CSV файл
foreach ($boards as $board) {
    fputcsv($csv_file, array(
        $board['id'],
        $board['name'],
        $board['description'],
        $board['pin_count'],
        $board['follower_count'],
        $board['privacy'],
        $board['media']['image_cover_url']
    ));
}

fclose($csv_file);

echo "Список досок успешно сохранен в boards.csv!";
?>
