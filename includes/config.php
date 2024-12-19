<?php

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "resident_hotel_db"; 

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]);
    exit();
}

// echo "Connected successfully";
?>
