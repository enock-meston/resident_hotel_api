<?php
include '../includes/config.php';
header("Content-Type: application/json");

if (isset($_POST['email'])) {
    # code...

$username = $_POST['email'];
$password = $_POST['password'];

// $username ="alice@gmail.com";
// $password = 123;


$sql = "SELECT * FROM client_table WHERE (email = '$username' OR phoneNumber = '$username')";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    // verify password
    if (password_verify($password, $row['password'])) {
        // password correct

        $response["client_id"] = $row['client_id'];
        $response["names"] = $row['names'];
        $response["email"] = $row['email'];
        $response["password"] = $row['password'];
        $response["phoneNumber"] = $row['phoneNumber'];
        $response["client_status"] = $row['status'];

        $response["status"] = "success";
        $response["message"] = "Login Successful";
        echo json_encode($response);
        exit();
    } else {
        // password incorrect
        $response["status"] = "error";
        $response["message"] = "Password is incorrect";
        echo json_encode($response);
        exit();
    }

}else {
    $response["status"] = "error";
        $response["message"] = "Account not found try to create a new account";
        echo json_encode($response);
        exit();
}
}