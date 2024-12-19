<?php
include 'includes/config.php';
header("Content-Type: application/json");

if (isset($_POST['email'])) {
    # code...

$username = $_POST['email'];
$password = $_POST['password'];

// $username ="johndoe";
// $password = 123;


$sql = "SELECT * FROM users_tbl WHERE (email = '$username' OR username = '$username')";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    // verify password
    if (password_verify($password, $row['password'])) {
        // password correct

        $response["user_id"] = $row['user_id'];
        $response["names"] = $row['names'];
        $response["email"] = $row['email'];
        $response["password"] = $row['password'];
        $response["username"] = $row['username'];
        $response["userType"] = $row['userType'];
        $response["status"] = $row['status'];

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