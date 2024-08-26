<?php
session_start();
require_once('config.php'); // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch previous trips (flights) with payment details for the logged-in user from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT f.flight_id, f.Arrival, f.Departure, f.Destination, f.price_business_seat, f.price_economy_seat,
                 p.cardno, p.expiry_date, p.Payment_status
          FROM flight f
          INNER JOIN ticket t ON f.flight_id = t.flight_id
          INNER JOIN payment p ON t.ticket_id = p.ticket_id
          WHERE t.user_id = $user_id";

$result = mysqli_query($conn, $query);

$previous_trips = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $previous_trips[] = $row;
    }
} else {
    $not_found_message = "No previous trips found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Trips</title>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>View Trips</h1>

<!-- Previous Trips Card -->
    <?php if (!empty($previous_trips)): ?>
        <ul style="list-style-type: none; padding: 0;">
            <?php foreach ($previous_trips as $trip): ?>
                <li>
                    <strong>Flight ID:</strong> <?php echo $trip['flight_id']; ?><br>
                    <strong>Arrival:</strong> <?php echo $trip['Arrival']; ?><br>
                    <strong>Departure:</strong> <?php echo $trip['Departure']; ?><br>
                    <strong>Destination:</strong> <?php echo $trip['Destination']; ?><br>
                    <strong>Price (business Seat):</strong> $<?php echo number_format($trip['price_business_seat'], 2); ?><br>
                    <strong>Price (Economy Seat):</strong> $<?php echo number_format($trip['price_economy_seat'], 2); ?><br>
                    <strong>Payment Card Number:</strong> <?php echo $trip['cardno']; ?><br>
                    <strong>Payment Expiry Date:</strong> <?php echo $trip['expiry_date']; ?><br>
                    <strong>Payment Status:</strong> <?php echo $trip['Payment_status']; ?><br>
                </li>
                <br>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><?php echo isset($not_found_message) ? $not_found_message : "No previous trips found."; ?></p>
    <?php endif; ?>
    <a href="user_dashboard.php">Back to Dashboard</a>

</body>
</html>

<?php
mysqli_close($conn); // Close database connection
?>

