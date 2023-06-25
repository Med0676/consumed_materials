
<?php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'material_monitoring_db');

// Establish a database connection
$connection = mysqli_connect('localhost', 'root', '', 'material_monitoring_db');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

