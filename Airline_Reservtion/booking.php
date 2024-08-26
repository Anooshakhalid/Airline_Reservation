<?php
session_start();
require_once('config.php'); // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure flight_id is passed as a POST parameter
if (!isset($_POST['flight_id'])) {
    die("Flight ID is missing.");
}

$flight_id = mysqli_real_escape_string($conn, $_POST['flight_id']); // Sanitize input

// Fetch flight details including airline name and aircraft type from the database
$query = "SELECT f.*, src_airport.Airport_name AS source_airport, dest_airport.Airport_name AS destination_airport, al.Airline_name, al.aircraft_name
          FROM flight f
          JOIN airport src_airport ON f.source = src_airport.Airport_ID
          JOIN airport dest_airport ON f.Destination = dest_airport.Airport_ID
          JOIN airline al ON f.Airline_id = al.Airline_id
          WHERE f.flight_id = '$flight_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $flight = mysqli_fetch_assoc($result);
} else {
    die("Flight not found.");
}

// Process the booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['psg_Fname'])) {
    $user_id = $_SESSION['user_id'];
    $psg_Fname = mysqli_real_escape_string($conn, $_POST['psg_Fname']);
    $psg_Lname = mysqli_real_escape_string($conn, $_POST['psg_Lname']);
    $psg_mobile = mysqli_real_escape_string($conn, $_POST['psg_mobile']);
    $psg_CNIC = mysqli_real_escape_string($conn, $_POST['psg_CNIC']);
    $psg_DOB = mysqli_real_escape_string($conn, $_POST['psg_DOB']);

    // Insert passenger details into the database
    $insert_query = "INSERT INTO passenger (user_id, flight_id, psg_Fname, psg_Lname, psg_mobile, psg_CNIC, psg_DOB)
                     VALUES ('$user_id', '$flight_id', '$psg_Fname', '$psg_Lname', '$psg_mobile', '$psg_CNIC', '$psg_DOB')";

    if (mysqli_query($conn, $insert_query)) {
        // Store the passenger ID and flight ID in session for use in the payment process
        $_SESSION['passenger_id'] = mysqli_insert_id($conn);
        $_SESSION['flight_id'] = $flight_id;
        header("Location: process_payment.php");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .flight-summary, .important-info, .insurance, .passenger-details {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 10px 0;
        }
        .section-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
            border: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Complete Your Booking</h1>

    <div class="flight-summary">
        <div class="section-title">Flight Summary</div>
        <p><strong><?php echo $flight['source']; ?> → <?php echo $flight['Destination']; ?></strong></p>
        <p><?php echo date('l, M j', strtotime($flight['Departure'])); ?> · Non Stop · <?php echo $flight['Duration']; ?></p>
        <p><strong><?php echo $flight['Airline_name']; ?></strong> <?php echo isset($flight['flight_number']) ? $flight['flight_number'] : ''; ?> · <?php echo isset($flight['aircraft_name']) ? $flight['aircraft_name'] : ''; ?></p>
        <p><?php echo isset($flight['seat_class']) ? $flight['seat_class'] : ''; ?> > <?php echo isset($flight['seat_class']) ? $flight['seat_class'] : ''; ?></p>
        <p><?php echo date('H:i', strtotime($flight['Departure'])); ?> <?php echo isset($flight['source_airport']) ? $flight['source_airport'] : ''; ?></p>
        <p><?php echo date('H:i', strtotime($flight['Arrival'])); ?> <?php echo isset($flight['destination_airport']) ? $flight['destination_airport'] : ''; ?></p>
        <p>Cabin Baggage: <?php echo isset($flight['cabin_baggage']) ? $flight['cabin_baggage'] : ''; ?> / Adult</p>
        <p>Check-In Baggage: <?php echo isset($flight['checkin_baggage']) ? $flight['checkin_baggage'] : ''; ?> / Adult</p>
    </div>

    <div class="passenger-details">
        <div class="section-title">Passenger Details</div>
        <form method="post" action="booking.php">
            <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">
            <input type="hidden" name="airline_id" value="<?php echo $flight['Airline_id']; ?>">
            <input type="hidden" name="departure" value="<?php echo $flight['Departure']; ?>">
            <input type="hidden" name="arrival" value="<?php echo $flight['Arrival']; ?>">
            <input type="hidden" name="source_airport" value="<?php echo $flight['source']; ?>">
            <input type="hidden" name="destination_airport" value="<?php echo $flight['Destination']; ?>">
            <input type="hidden" name="duration" value="<?php echo $flight['Duration']; ?>">
            <input type="hidden" name="aircraft_name" value="<?php echo $flight['aircraft_name']; ?>">
            <input type="hidden" name="price" value="<?php echo $flight['price_economy_seat']; ?>">

            <label for="psg_Fname">First Name:</label>
            <input type="text" id="psg_Fname" name="psg_Fname" required><br><br>
            <label for="psg_Lname">Last Name:</label>
            <input type="text" id="psg_Lname" name="psg_Lname" required><br><br>
            <label for="psg_mobile">Mobile Number:</label>
            <input type="text" id="psg_mobile" name="psg_mobile" required><br><br>
            <label for="psg_CNIC">CNIC:</label>
            <input type="text" id="psg_CNIC" name="psg_CNIC" required><br><br>
            <label for="psg_DOB">Date of Birth:</label>
            <input type="date" id="psg_DOB" name="psg_DOB" required><br><br>

            <button type="submit" class="button">Proceed to Payment</button>
        </form>
    </div>
</div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

