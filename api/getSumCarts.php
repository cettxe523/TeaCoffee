<?php
$env = parse_ini_file('../.env');
$user = $_POST['user'];

$mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

$sum = $mysqli->query("SELECT SUM(catalog.price*count) as sum FROM carts 
    INNER JOIN catalog ON carts.catalog_id = catalog.id
    INNER JOIN users on carts.user_id = users.id
    WHERE users.login = '$user';");

while($row = $sum->fetch_assoc()){
    echo json_encode($row['sum']);
}

$mysqli->close();