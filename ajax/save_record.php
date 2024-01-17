<?php
header('Content-Type: application/json');
// Database connection
require("../database/dbcon.php");

// Retrieve the JSON data from the AJAX request
$data = json_decode($_POST['data'], true);

if ($data) {
    // Assuming your formData contains fields like 'name' and 'value'
    // Adjust the column names accordingly based on your database structure

    $columns = [];
    $values = [];
    $types = "";

    // Loop through the array and prepare data for the query
    foreach ($data as $item) {
        $name = mysqli_real_escape_string($con, $item['name']);
        $value = mysqli_real_escape_string($con, $item['value']);

        $columns[] = $name;
        $values[] = $value;
        if($name == "quantity"){
            $types .= "i";
        }else{
            $types .= "s";
        }
        
    }

    // Build the dynamic query
    $query = "INSERT INTO `response` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', array_fill(0, count($values), '?')) . ")";
    // Create a prepared statement
    $stmt = $con->prepare($query);

    // Bind parameters
    $stmt->bind_param($types, ...$values);

    // Execute the statement
    if ($stmt->execute()) {
        // Continue processing if needed
        echo json_encode(['status' => 'success', 'message' => $query]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save data: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data received']);
}
?>
