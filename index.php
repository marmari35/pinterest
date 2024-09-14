<?php
// Перенаправление на Pinterest для авторизации
$client_id = '1504118';
$redirect_uri = 'https://soviet-box.com/pinterest/callback.php';
$scopes = 'boards:read';

$authorization_url = "https://www.pinterest.com/oauth/?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scopes";

echo "<a href='$authorization_url'>Авторизоваться через Pinterest</a>";
?>
