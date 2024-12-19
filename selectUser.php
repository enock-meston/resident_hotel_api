<?php
include 'includes/config.php';
header("Content-Type: application/json");

// SQL query to select all users from the users_tbl
$sql = "SELECT * FROM users_tbl ORDER BY user_id DESC";
$result = mysqli_query($con, $sql);

$response = []; // Initialize the response array

if ($result && mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Append each user to the response array
        $user = [
            "user_id" => $row['user_id'],
            "names" => $row['names'],
            "email" => $row['email'],
            "username" => $row['username'],
            "userType" => $row['userType'],
            "status" => $row['status'],
        ];
        $response[] = $user; // Add the user to the response array
    }

    // Return success response with user data
    echo json_encode([
        "status" => "success",
        "message" => "Users retrieved successfully",
        "data" => $response // Include the user data in the response
    ]);
} else {
    // No users found or query error
    echo json_encode([
        "status" => "error",
        "message" => "No users found or error in query"
    ]);
}

// Close the database connection
mysqli_close($con);
