<?php
include 'header.php';
session_start();
require_once('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$errors = [];
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $source = $_POST['source'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $departure = $_POST['departure'] ?? '';
    $arrival = $_POST['arrival'] ?? '';
    $total_business_seats = $_POST['total_business_seats'] ?? 0;
    $total_economy_seats = $_POST['total_economy_seats'] ?? 0;
    $available_business_seats = $_POST['available_business_seats'] ?? 0;
    $available_economy_seats = $_POST['available_economy_seats'] ?? 0;
    $price_business_seat = $_POST['price_business_seat'] ?? 0.0;
    $price_economy_seat = $_POST['price_economy_seat'] ?? 0.0;
    $status = $_POST['status'] ?? ''; // Default value if not provided
    $airline_id = $_POST['airline_id'] ?? 0;
    $aircraft_name = $_POST['aircraft_name'] ?? '';
    $duration = $_POST['duration'] ?? '';

    // Basic validation
    if (empty($source)) {
        $errors[] = "Source is required";
    }
    if (empty($destination)) {
        $errors[] = "Destination is required";
    }
    // Validate departure and arrival times (example validation)
    if (strtotime($arrival) <= strtotime($departure)) {
        $errors[] = "Arrival time must be after departure time";
    }

    // If no errors, proceed to insert into database
    if (empty($errors)) {
        // Prepare SQL statement to insert into `flight` table
        $sql = "INSERT INTO flight (source, Destination, Departure, Arrival, Total_business_seats, Total_economy_seats, Available_business_seats, Available_Economy_seats, price_business_seat, price_economy_seat, status, Airline_id, aircraft_name, Duration)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiiiidisss",
            $source, $destination, $departure, $arrival,
            $total_business_seats, $total_economy_seats, $available_business_seats,
            $available_economy_seats, $price_business_seat, $price_economy_seat,
            $status, $airline_id, $aircraft_name, $duration);

        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Flight added successfully!";
            // Redirect to manage flights page after a short delay
            echo '<script>';
            echo 'setTimeout(function(){ window.location.href = "manage_flights.php"; }, 3000);';
            echo '</script>';
        } else {
            $errors[] = "Error occurred while adding the flight: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Fetch airlines for the add flight form
$sql = "SELECT Airline_id, Airline_name FROM airline";
$result = $conn->query($sql);

$airlines = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $airlines[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Flight</title>
    <!-- Bootstrap CSS - Replace with your preferred version or local file -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>


        body {
            font-family: Arial, sans-serif;
        }
        .form-group {
            margin-bottom: 20px;
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
    <h2 class="mt-4 mb-4">Add New Flight</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="source">Source:</label>
            <input type="text" id="source" name="source" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="departure">Departure:</label>
            <input type="datetime-local" id="departure" name="departure" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="arrival">Arrival:</label>
            <input type="datetime-local" id="arrival" name="arrival" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="total_business_seats">Total business Seats:</label>
            <input type="number" id="total_business_seats" name="total_business_seats" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="total_economy_seats">Total Economy Seats:</label>
            <input type="number" id="total_economy_seats" name="total_economy_seats" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="available_business_seats">Available business Seats:</label>
            <input type="number" id="available_business_seats" name="available_business_seats" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="available_economy_seats">Available Economy Seats:</label>
            <input type="number" id="available_economy_seats" name="available_economy_seats" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price_business_seat">Price per business Seat:</label>
            <input type="number" step="0.01" id="price_business_seat" name="price_business_seat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price_economy_seat">Price per Economy Seat:</label>
            <input type="number" step="0.01" id="price_economy_seat" name="price_economy_seat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="Scheduled">Scheduled</option>
                <option value="Delayed">Delayed</option>
                <option value="On-time">On-time</option>
            </select>
        </div>
        <div class="form-group">
            <label for="airline_id">Airline:</label>
            <select id="airline_id" name="airline_id" class="form-control" required>
                <?php foreach ($airlines as $airline): ?>
                    <option value="<?php echo $airline['Airline_id']; ?>"><?php echo $airline['Airline_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="aircraft_name">Aircraft Name:</label>
            <input type="text" id="aircraft_name" name="aircraft_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration (HH:MM:SS):</label>
            <input type="text" id="duration" name="duration" class="form-control" placeholder="HH:MM:SS" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Flight</button>
        <a href="manage_flights.php" class="btn btn-primary">Back</a>
    </form>
</div>

<!-- Optional: JavaScript and dependencies for Bootstrap (e.g., jQuery, Popper.js) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function calculateDuration() {
        var departure = document.getElementById('departure').value;
        var arrival = document.getElementById('arrival').value;

        // Convert to Date objects
        var departureTime = new Date(departure);
        var arrivalTime = new Date(arrival);

        // Calculate difference in milliseconds
        var durationMs = arrivalTime.getTime() - departureTime.getTime();

        // Convert milliseconds to HH:MM:SS format
        var duration = new Date(durationMs);

        var hours = duration.getUTCHours().toString().padStart(2, '0');
        var minutes = duration.getUTCMinutes().toString().padStart(2, '0');
        var seconds = duration.getUTCSeconds().toString().padStart(2, '0');

        // Update the duration input field
        document.getElementById('duration').value = hours + ':' + minutes + ':' + seconds;
    }

    // Attach event listener to calculate duration on change of departure or arrival inputs
    document.getElementById('departure').addEventListener('change', calculateDuration);
    document.getElementById('arrival').addEventListener('change', calculateDuration);
</script>

</body>
</html>

