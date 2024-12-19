<?php
include 'includes/config.php';
header("Content-Type: application/json");


$roomNumber = $_POST['room_number'];
$roomType = $_POST['roomType'];
$price = $_POST['price'];

// default room
// $roomNumber = "room001";
// $roomType = "single";
// $price ="122";


// Check if the Room already exists

$response = [];

$sql = mysqli_query($con,"SELECT * FROM room_table WHERE room_number = '$roomNumber'");


if (mysqli_num_rows($sql) > 0) {
    $response["status"] = "error";
    $response["message"] = "room already exists";
    echo json_encode($response);
    exit();
}

// default status
$status = "active";

// Insert the new room into the database
$sql = mysqli_query($con,"INSERT INTO `room_table`(`room_number`, `room_type`, 
`price`, `status`) VALUES ('$roomNumber','$roomType','$price','$status')");

if ($sql) {
    $response["status"] = "success";
    $response["message"] = "Room created successfully";
} else {
    $response["status"] = "error";
    $response["message"] = "Error: " . mysqli_error($con);
}

// Output JSON response
echo json_encode($response);