<?php
include 'includes/config.php';
header("Content-Type: application/json");
// Function to generate a unique file name for the uploaded image
function generateImageName($file) {
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $uniqueName = uniqid('food_', true) . '.' . $extension;
    return $uniqueName;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get JSON data from the request body
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $response = [];
        // Loop through the food items and save them to the database
        foreach ($data['data'] as $food_item) {
            $id = $food_item['id'];
            $name = $food_item['name'];
            $price = $food_item['price'];
            $type = $food_item['type'];
            $status = $food_item['status'];

            // Process image upload
            if (isset($food_item['image']) && !empty($food_item['image'])) {
                // Assuming the image is base64 encoded
                $imageData = base64_decode($food_item['image']);
                $imageName = generateImageName($_FILES['image']); // Use a unique name
                $imagePath = 'Uploaded/' . $imageName; // Save in the "Uploaded" folder

                // Create the "Uploaded" directory if it doesn't exist
                if (!file_exists('Uploaded')) {
                    mkdir('Uploaded', 0777, true); // Create the folder with write permissions
                }

                // Save the image to the "Uploaded" folder
                file_put_contents($imagePath, $imageData);

                // Save the image path in the database
                $image = $imagePath;
            } else {
                $image = ''; // If no image is provided, leave it empty
            }

            // Insert query
            $query = "INSERT INTO food_and_beverages (name, price, type, image, status) 
                      VALUES ('$id', '$name', '$price', '$type', '$image', '$status')";

            if (mysqli_query($con, $query)) {
                $response[] = [
                    'success' => true,
                    'message' => 'Food item saved successfully.'
                ];
            } else {
                $response[] = [
                    'success' => false,
                    'message' => 'Failed to save food item.'
                ];
            }
        }

        // Return response in JSON format
        echo json_encode(['response' => $response]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid data.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>
