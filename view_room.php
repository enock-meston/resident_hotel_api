<?php
include 'includes/config.php';
header("Content-Type: application/json");

$sql = "SELECT * FROM room_table ORDER BY r_id DESC";
$result = mysqli_query($con, $sql);

$response = []; 

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user = [
            "r_id" => $row['r_id'],
            "room_number" => $row['room_number'],
            "room_type" => $row['room_type'],
            "price" => $row['price'],
            "status" => $row['status'],
        ];
        $response[] = $user; 
    }

    // Return success response with user data
    echo json_encode([
        "status" => "success",
        "message" => "Room retrieved successfully",
        "data" => $response // Include the user data in the response
    ]);
} else {
    // No room found or query error
    echo json_encode([
        "status" => "error",
        "message" => "No Room found or error in query"
    ]);
}

// Close the database connection
mysqli_close($con);
