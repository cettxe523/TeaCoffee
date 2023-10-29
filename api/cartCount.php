<?php
$env = parse_ini_file('../.env');
$count = $_POST['count'];
$cart_id = $_POST['id'];

$mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

$result = $mysqli->query("UPDATE carts SET count = '$count' WHERE id = $cart_id;");

if($result){
    echo json_encode(true);
}

$mysqli->close();