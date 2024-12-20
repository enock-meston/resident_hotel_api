<?php
// Database connection
include '../includes/config.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $clientId = $_POST['clientId'] ?? null;
    $roomId = $_POST['roomId'] ?? null;

    // Validate input
    if (!$clientId || !$roomId) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // Default status
    $status = "Pending";
    // Check if the client id exists in room_res_tbl
    $query = "SELECT * FROM room_res_tbl WHERE clientId = '$clientId' AND status = 'Pending'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["success" => false, "message" => "You already have a pending order"]);
        exit;
    } else {
        // Insert data into the database
        $query = "INSERT INTO room_res_tbl (`roomId`, `clientId`, `status`) VALUES ('$roomId', '$clientId', '$status')";

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
