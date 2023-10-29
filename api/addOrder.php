<?php
$env = parse_ini_file('../.env');

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$patronymic = $_POST['patronymic'];
$address = $_POST['address'];
$user = $_POST['user'];

$sum = 0;

$mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

$mysqli->query("UPDATE users SET fio = '$lastname $firstname $patronymic', address = '$address' WHERE login = '$user';");

$carts = $mysqli->query("SELECT * FROM carts INNER JOIN catalog ON carts.catalog_id = catalog.id INNER JOIN users ON carts.user_id = users.id WHERE users.login = '$user';");

if($carts->num_rows > 0){
    while ($row = $carts->fetch_assoc()) {
        $user_id = $row['user_id'];
        $order_list .= $row['catalog_id'] . ", ";
        $sum += ($row['price'] * $row['count']);
    }

    $mysqli->query("INSERT INTO orders(user_id, articles, sum) VALUES('$user_id', '$order_list', '$sum');");
    $mysqli->query("DELETE FROM carts WHERE user_id = '$user_id'");
}


$mysqli->close();

header('Location: ' . $_SERVER['HTTP_REFERER']);