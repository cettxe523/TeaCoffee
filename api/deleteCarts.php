<?php
$env = parse_ini_file('../.env');
$user = $_POST['user'];

$mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

$user = $mysqli->query("SELECT * FROM users WHERE login = '$user' LIMIT 1;");

if($user->num_rows === 1){
    while($row = $user->fetch_assoc()){
        $user_id = $row['id'];
        $result = $mysqli->query("DELETE FROM carts WHERE user_id = '$user_id'");
    
        if($result){
            echo json_encode(true);
        }
    }
}

$mysqli->close();