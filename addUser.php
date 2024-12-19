<?php
include 'includes/config.php';
header("Content-Type: application/json");


$names = $_POST['name'];
$email = $_POST['email'];
$userType = $_POST['userType'];

// $names = "John1 Doe1";
// $email = "johndoe1@example.com";
// $userType = "waiter";

// Check if the user already exists

$response = [];

$sql = mysqli_query($con,"SELECT * FROM users_tbl WHERE email = '$email'");


if (mysqli_num_rows($sql) > 0) {
    $response["status"] = "error";
    $response["message"] = "User already exists";
    echo json_encode($response);
    exit();
}

// default status
$status = "active";
// Generate a unique username
$username = strtolower(substr($names, 0, 5)). rand(1000, 9999);
// default password
$password = "password";
// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database
$sql = mysqli_query($con,"INSERT INTO users_tbl (names, email, password, username, userType,status) 
        VALUES ('$names', '$email', '$hashedPassword', '$username', '$userType', '$status')");

if ($sql) {
    $response["status"] = "success";
    $response["message"] = "Account created successfully";
} else {
    $response["status"] = "error";
    $response["message"] = "Error: " . mysqli_error($con);
}

// Output JSON response
echo json_encode($response);