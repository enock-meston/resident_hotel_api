<?php
// Database connection
include '../includes/config.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $clientId = $_POST['clientId'] ?? null;
    $foodId = $_POST['foodId'] ?? null;

    // Validate input
    if (!$clientId || !$foodId) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // Default status
    $status = "Pending";
    // Check if the client id exists in food_res_tbl
    $query = "SELECT * FROM food_res_tbl WHERE clientId = '$clientId' AND status = 'Pending'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["success" => false, "message" => "You already have a pending order"]);
        exit;
    } else {
        // Insert data into the database
        $query = "INSERT INTO food_res_tbl (clientId, f_b_Id, status) VALUES ('$clientId', '$foodId', '$status')";

        if (mysqli_query($con, $query)) {
            echo json_encode(["success" => true, "message" => "Order placed successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to place order: " . mysqli_error($con)]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}


mysqli_close($con);
