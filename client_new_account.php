<?php
include 'includes/config.php';
header("Content-Type: application/json");


$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password= $_POST['password'];
  
// $name ='Default Name';
// $phone = '0000000000'; // Default phone number
// $email = 'default@example.com'; // Default email
// $password ='defaultpassword'; // Default password



$response = [];

$sql = mysqli_query($con,"SELECT * FROM client_table WHERE email = '$email' OR phoneNumber = '$phone'");


if (mysqli_num_rows($sql) > 0) {
    $response["status"] = "error";
    $response["message"] = " Phone number or email is already used.";
    echo json_encode($response);
    exit();
}

// default status
$status = "active";
// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// Insert the new room into the database
$sql = mysqli_query($con,"INSERT INTO `client_table`(`names`, `phoneNumber`,
 `email`, `password`, `status`) VALUES ('$name','$phone','$email','$hashedPassword','$status')");

if ($sql) {
    $response["status"] = "success";
    $response["message"] = "New account created successfully";
} else {
    $response["status"] = "error";
    $response["message"] = "Error: " . mysqli_error($con);
}

// Output JSON response
echo json_encode($response);