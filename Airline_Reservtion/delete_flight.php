<?php
session_start();
require_once('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Initialize error message variable
$error_message = '';

// Check if flight_id is provided via GET
if (isset($_GET['flight_id']) && is_numeric($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];

    // Prepare SQL statement to delete flight
    $sql = "DELETE FROM flight WHERE Flight_id = ?";

    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Flight deleted successfully
        header("Location: manage_flights.php?deleted=true");
        exit();
    } else {
        // Error occurred while deleting flight
        $error_message = "Error occurred while deleting the flight: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Invalid flight_id parameter
    $error_message = "Invalid flight ID";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Flight</title>
    <!-- Bootstrap CSS - Replace with your preferred version or local file -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Delete Flight</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Optional: Link back to manage_flights.php -->
    <a href="manage_flights.php" class="btn btn-primary">Back to Manage Flights</a>
</div>

<!-- Optional: JavaScript and dependencies for Bootstrap (e.g., jQuery, Popper.js) -->
<!-- Ensure these scripts are included before the closing </body> tag -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
