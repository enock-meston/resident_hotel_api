<?php
include 'includes/config.php';
header("Content-Type: application/json");

$sql = "SELECT * FROM client_table ORDER BY client_id DESC";
$result = mysqli_query($con, $sql);

$response = []; 

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user = [
            "client_id" => $row['client_id'],
            "names" => $row['names'],
            "phoneNumber" => $row['phoneNumber'],
            "email" => $row['email'],
            "addedOn" => $row['addedOn'],
            "status" => $row['status'],
        ];
        $response[] = $user; 
    }

    // Return success response with user data
    echo json_encode([
        "status" => "success",
        "message" => "Clients retrieved successfully",
        "data" => $response // Include the user data in the response
    ]);
} else {
    // No client found or query error
    echo json_encode([
        "status" => "error",
        "message" => "No Room found or error in query"
    ]);
}

// Close the database connection
mysqli_close($con);
