<?php
include 'includes/config.php';
header("Content-Type: application/json");

// Function to retrieve food and beverage data from the database
function getFoodAndBeverages() {
    global $con;
    $query = "SELECT * FROM food_and_beverages";
    $result = mysqli_query($con, $query);
    $foodItems = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Check if image exists and is not empty
            if ($row['image'] && file_exists($row['image'])) {
                $row['image'] = $row['image']; // Return full path
            } else {
                $row['image'] = ''; // No image found, return empty string
            }

            $foodItems[] = $row;
        }
    }

    return $foodItems;
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $foodItems = getFoodAndBeverages();

    if (!empty($foodItems)) {
        echo json_encode([
            'success' => true,
            'data' => $foodItems
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No food and beverages found.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>
