<?php
include 'header.php';
session_start();
require_once('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Initialize variables
$flight_id = $_GET['id'] ?? null;
$flight = null;
$airlines = [];

// Fetch flight data
if ($flight_id) {
    $sql = "SELECT * FROM flight WHERE flight_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $flight = $result->fetch_assoc();
    } else {
        echo "Flight not found.";
        exit();
    }
} else {
    echo "Invalid flight ID.";
    exit();
}

// Fetch airlines for the update flight form
$sql = "SELECT * FROM airline";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $airlines[] = $row;
    }
} else {
    echo "Error fetching airlines.";
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];
    $total_business_seats = $_POST['total_business_seats'];
    $total_economy_seats = $_POST['total_economy_seats'];
    $available_business_seats = $_POST['available_business_seats'];
    $available_economy_seats = $_POST['available_economy_seats'];
    $price_business_seat = $_POST['price_business_seat'];
    $price_economy_seat = $_POST['price_economy_seat'];
    $status = $_POST['status'];
    $airline_id = $_POST['airline_id'];
    $aircraft_name = $_POST['aircraft_name'];
    $duration = $_POST['duration'];

    // Update the flight data
    $sql = "UPDATE flight SET 
            source = ?, 
            Destination = ?, 
            Departure = ?, 
            Arrival = ?, 
            Total_business_seats = ?, 
            Total_economy_seats = ?, 
            Available_business_seats = ?, 
            Available_Economy_seats = ?, 
            price_business_seat = ?, 
            price_economy_seat = ?, 
            status = ?, 
            Airline_id = ?, 
            aircraft_name = ?, 
            Duration = ?
            WHERE flight_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiiiiissssi",
        $source, $destination, $departure, $arrival,
        $total_business_seats, $total_economy_seats, $available_business_seats,
        $available_economy_seats, $price_business_seat, $price_economy_seat,
        $status, $airline_id, $aircraft_name, $duration, $flight_id);

    if ($stmt->execute()) {
        echo "Flight updated successfully.";
        header("Location: manage_flights.php");
        exit();
    } else {
        echo "Error updating flight: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light grey background */
         }

        h2 {
            color: #798D99;
            font-style: italic;
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            font-family: 'Georgia', serif;
        }


    </style>
</head>
<body>

<div class="container">
    <h2 class="mt-4 mb-4">Update Flight</h2>
    <?php if ($flight): ?>
        <form method="post" action="update_flight.php?id=<?php echo $flight['flight_id']; ?>">
            <div class="form-group">
                <label for="source">Source:</label>
                <input type="text" id="source" name="source" class="form-control" value="<?php echo htmlspecialchars($flight['source']); ?>" required>
            </div>
            <div class="form-group">
                <label for="destination">Destination:</label>
                <input type="text" id="destination" name="destination" class="form-control" value="<?php echo htmlspecialchars($flight['Destination']); ?>" required>
            </div>
            <div class="form-group">
                <label for="departure">Departure:</label>
                <input type="datetime-local" id="departure" name="departure" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($flight['Departure'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="arrival">Arrival:</label>
                <input type="datetime-local" id="arrival" name="arrival" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($flight['Arrival'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="total_business_seats">Total business Seats:</label>
                <input type="number" id="total_business_seats" name="total_business_seats" class="form-control" value="<?php echo $flight['Total_business_seats']; ?>" required>
            </div>
            <div class="form-group">
                <label for="total_economy_seats">Total Economy Seats:</label>
                <input type="number" id="total_economy_seats" name="total_economy_seats" class="form-control" value="<?php echo $flight['Total_economy_seats']; ?>" required>
            </div>
            <div class="form-group">
                <label for="available_business_seats">Available business Seats:</label>
                <input type="number" id="available_business_seats" name="available_business_seats" class="form-control" value="<?php echo $flight['Available_business_seats']; ?>" required>
            </div>
            <div class="form-group">
                <label for="available_economy_seats">Available Economy Seats:</label>
                <input type="number" id="available_economy_seats" name="available_economy_seats" class="form-control" value="<?php echo $flight['Available_Economy_seats']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price_business_seat">Price per business Seat:</label>
                <input type="number" step="0.01" id="price_business_seat" name="price_business_seat" class="form-control" value="<?php echo $flight['price_business_seat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price_economy_seat">Price per Economy Seat:</label>
                <input type="number" step="0.01" id="price_economy_seat" name="price_economy_seat" class="form-control" value="<?php echo $flight['price_economy_seat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Scheduled" <?php if ($flight['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                    <option value="Delayed" <?php if ($flight['status'] == 'Delayed') echo 'selected'; ?>>Delayed</option>
                    <option value="On-time" <?php if ($flight['status'] == 'On-time') echo 'selected'; ?>>On-time</option>
                </select>
            </div>
            <div class="form-group">
                <label for="airline_id">Airline:</label>
                <select id="airline_id" name="airline_id" class="form-control" required>
                    <?php foreach ($airlines as $airline): ?>
                        <option value="<?php echo $airline['Airline_id']; ?>" <?php if ($airline['Airline_id'] == $flight['Airline_id']) echo 'selected'; ?>><?php echo htmlspecialchars($airline['Airline_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="aircraft_name">Aircraft Name:</label>
                <input type="text" id="aircraft_name" name="aircraft_name" class="form-control" value="<?php echo htmlspecialchars($flight['aircraft_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration (HH:MM:SS):</label>
                <input type="text" id="duration" name="duration" class="form-control" value="<?php echo $flight['Duration']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Flight</button>
            <a href="manage_flights.php" class="btn btn-primary">Back</a>
        </form>
    <?php endif; ?>
</div>

<!-- Optional: JavaScript and dependencies for Bootstrap (e.g., jQuery, Popper.js) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
