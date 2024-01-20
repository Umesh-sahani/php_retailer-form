<?php
header('Content-Type: application/json');
// Database connection
require("../database/dbcon.php");

// Retrieve the JSON data from the AJAX request
$data = json_decode($_POST['data'], true);

if ($data) {
    // Assuming your formData contains fields like 'user_name', 'width', 'color', 'design_name', and 'quantity'
    // Adjust the column names accordingly based on your database structure

    $columns = [];
    $values = [];
    $types = "";

    // Loop through the array and prepare data for the query
    foreach ($data as $item) {
        $rowValues = [];
        foreach ($item as $name => $value) {
            $columns[$name] = mysqli_real_escape_string($con, $name);
            $rowValues[] = mysqli_real_escape_string($con, $value);

            // Assuming 'quantity' is an integer, adjust the condition as needed
            if ($name == "quantity") {
                $types .= "i";
            } else {
                $types .= "s";
            }
        }
        $values[] = $rowValues;
    }

    // Build the dynamic query
    $query = "INSERT INTO `response` (" . implode(', ', $columns) . ") VALUES ";

    // Add placeholders for each row
    $query .= implode(', ', array_fill(0, count($values), '(' . implode(', ', array_fill(0, count($columns), '?')) . ')'));

    // Flatten the values array for binding parameters
    $flatValues = array_merge(...$values);

    // Create a prepared statement
    $stmt = $con->prepare($query);

    // Bind parameters
    $stmt->bind_param($types, ...$flatValues);

    // Execute the statement
    if ($stmt->execute()) {
        // Continue processing if needed
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save data: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data received']);
}
?>
