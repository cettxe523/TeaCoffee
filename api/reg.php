<?php
$env = parse_ini_file('../.env');

$login = trim($_POST['login']);
$password = sha1(trim($_POST['password']));
$password_confirm = sha1(trim($_POST['password_confirm']));

if($password == $password_confirm){
    $mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

    $result = $mysqli->query("INSERT INTO users (login, password) VALUES('$login', '$password');");
    
    if(isset($result)){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        $mysqli->error;
    }

    setcookie('user', $login, time() + 3600 * 6, '/');
}
else{
    setcookie('error', 'Пароли не совпадают', time() + 3600, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$mysqli->close();