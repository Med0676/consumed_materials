<?php
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $materialName = $_POST['materialName'];
    $quantity = $_POST['quantity'];
    $dateConsumed = $_POST['dateConsumed'];

    // Connect to the database
    $connection = mysqli_connect('localhost', 'root', '', 'material_monitoring_db');

    // Insert the consumed material into the 'consumed_materials' table
    $query = "INSERT INTO consumed_materials (material_name, quantity, date_consumed) 
              VALUES ('$materialName', $quantity, '$dateConsumed')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Material added successfully.";
    } else {
        echo "Error adding material: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
