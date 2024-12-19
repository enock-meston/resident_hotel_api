<?php
include 'includes/config.php';
header("Content-Type: application/json");

// Check if 'user_id' is present in the query string
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']); // Sanitize user input

    // Execute the DELETE query
    $result = mysqli_query($con, "DELETE FROM users_tbl WHERE user_id = '$user_id'");

    if ($result) {
        // Check if any rows were affected by the deletion
        if (mysqli_affected_rows($con) > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "User deleted successfully"
            ]);
        } else {
            // If no rows were affected, the user may not have existed
            echo json_encode([
                "status" => "error",
                "message" => "No user found to delete"
            ]);
        }
    } else {
        // Error in query execution
        echo json_encode([
            "status" => "error",
            "message" => "Error deleting user: " . mysqli_error($con) // Added error detail
        ]);
    }
} else {
    // 'user_id' parameter is missing
    echo json_encode([
        "status" => "error",
        "message" => "User ID is required"
    ]);
}

// Close the database connection
mysqli_close($con);
