<?php
include 'includes/config.php';
// Send JSON response
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get fields from the request
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $price = isset($_POST['price']) ? (float)$_POST['price'] : null;
        $type = isset($_POST['type']) ? $_POST['type'] : null;

        // Validate required fields
        if (empty($name) || empty($price) || empty($type)) {
            // error message in json response
            $response['message'] = "Please fill all the fields";
        }

        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'Uploaded/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imagePath = $uploadDir . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $response['message'] = "Failed to upload image";
            }
        }
        $status = "available";
        // Insert data into the database
        $insertData = mysqli_query($con, "INSERT INTO `food_and_beverages`(`name`, `price`, `type`, `image`, `status`) 
        VALUES ('$name','$price','$type','$imagePath','$status')");
        // Check if data is inserted
        if ($insertData) {
            $response['success'] = true;
            $response['message'] = "Food and Beverage added successfully";
        } else {
            $response['message'] = "Failed to add Food and Beverage";
        }

    } else {
        $response['message'] = "Invalid request";
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}


echo json_encode($response);
?>
