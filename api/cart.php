<?php

$env = parse_ini_file('../.env');
$user = $_POST['user'];
$catalog_item = $_POST['catalog_id'];

$mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

$user = $mysqli->query("SELECT * FROM users WHERE login = '$user' LIMIT 1;");

if($user->num_rows === 1){
    while ($row = $user->fetch_assoc()) {
        $user_id = $row['id'];
        $result = $mysqli->query("INSERT INTO carts(catalog_id, user_id) VALUES($catalog_item, $user_id);");

        if($result){
            echo json_encode(true);
        }
    }
}

$mysqli->close();