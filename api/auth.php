<?php

$env = parse_ini_file('../.env');

$login = trim($_POST['login']);
$password = sha1(trim($_POST['password']));

$mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

$result = $mysqli->query("SELECT * FROM users WHERE login = '$login' AND password = '$password';");

if($result->num_rows === 1){
    setcookie('user', $login, time()+3600, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else{
    setcookie('error_auth', 'Пользователь не найден или пароль неверный', time()+3600, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$mysqli->close();