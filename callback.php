<?php
session_start();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Данные приложения
    $client_id = '1504118';
    $client_secret = 'e9fd965767a667ede783f7602d3afeab8ed96c17';
    $redirect_uri = 'https://soviet-box.com/pinterest/callback.php';

    // Запрос на получение токена
    $url = 'https://api.pinterest.com/v5/oauth/token';

    // Кодируем данные для Basic Auth
    $credentials = base64_encode($client_id . ':' . $client_secret);

    $post_fields = http_build_query([
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri
    ]);

    // Параметры запроса
    $options = [
        'http' => [
            'header' => [
                'Authorization: Basic ' . $credentials,
                'Content-Type: application/x-www-form-urlencoded'
            ],
            'method' => 'POST',
            'content' => $post_fields
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        echo "Ошибка получения токена доступа!";
    } else {
        $data = json_decode($response, true);
        $_SESSION['access_token'] = $data['access_token'];
        header('Location: get_boards.php'); // Перенаправляем после успешного получения токена
    }
} else {
    echo "Ошибка: код авторизации не получен!";
}
