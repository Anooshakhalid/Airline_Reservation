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
$search_source = '';
$search_destination = '';
$delete_message = '';

// Handle flight deletion if action is 'delete' and flight_id is provided via GET
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $flight_id = $_GET['id'];

    // Prepare SQL statement to delete flight
    $sql = "DELETE FROM flight WHERE flight_id = ?";

    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Set delete success message
        $delete_message = "Flight ID {$flight_id} deleted successfully!";
    } else {
        // Error occurred while deleting flight
        $delete_message = "Error occurred while deleting the flight: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Handle flight search if form is submitted
if (isset($_POST['search'])) {
    $search_source = $_POST['source'];
    $search_destination = $_POST['destination'];

    // Prepare SQL statement for flight search
    $sql = "SELECT flight.*, airline.Airline_name 
            FROM flight 
            INNER JOIN airline ON flight.Airline_id = airline.Airline_id
            WHERE source LIKE ? AND Destination LIKE ?
            ORDER BY flight.flight_id ASC"; // Sorting by flight_id ASC

    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $search_source_param = "%{$search_source}%";
    $search_destination_param = "%{$search_destination}%";
    $stmt->bind_param("ss", $search_source_param, $search_destination_param);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    $flights = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format datetime fields to display only time (HH:MM)
            $row['Departure'] = date('H:i', strtotime($row['Departure']));
            $row['Arrival'] = date('H:i', strtotime($row['Arrival']));
            $flights[] = $row;
        }
    }

    // Close the statement
    $stmt->close();
} else {
    // Fetch all flights from the database sorted by flight_id
    $sql = "SELECT flight.*, airline.Airline_name 
            FROM flight 
            INNER JOIN airline ON flight.Airline_id = airline.Airline_id
            ORDER BY flight.flight_id ASC"; // Sorting by flight_id ASC
    $result = $conn->query($sql);

    $flights = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format datetime fields to display only time (HH:MM)
            $row['Departure'] = date('H:i', strtotime($row['Departure']));
            $row['Arrival'] = date('H:i', strtotime($row['Arrival']));
            $flights[] = $row;
        }
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
    <title>Manage Flights</title>
    <!-- Bootstrap CSS - Replace with your preferred version or local file -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Rhino */
            color: #333; /* Mischka */
        }

        .flight-card {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        .flight-card h5 {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #16384f; /* Ship Cove */
            text-transform: uppercase;
            border-bottom: 2px solid #56b4be; /* Bright turquoise */
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .flight-card p {
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .back-btn {
            margin-top: 10px;
        }

        .search-form {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #3D4E67; /* Ship Cove */
        }

        .search-form .form-control {
            border-radius: 20px;
            padding-left: 25px;
            background-color: #fff; /* White */
            border: 1px solid #3D4E67 ; /* Ship Cove */
            color: #333; /* Mischka */
        }

        .search-form .form-control::placeholder {
            font-style: italic;
            color: #a7a7a7; /* Mischka */
        }

        .search-form .btn-primary {
            border-radius: 20px;
            background-color: #56b4be; /* Bright turquoise */
            border-color: #56b4be; /* Bright turquoise */
            color: #fff; /* White */
            padding: 10px 20px;
        }

        .search-form .btn-primary:hover {
            background-color: #3D4E67; /* Darker shade of Bright turquoise for hover */
            border-color: #3D4E67; /* Darker shade of Bright turquoise for hover */
        }

        .flight-image {
            width: 280px;
            right: 80px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #56b4be; /* Bright turquoise */
            border-color: #56b4be; /* Bright turquoise */
            color: white;
        }

        .btn-custom:hover {
            background-color: #3D4E67;
            border-color: #3D4E67;
            color: white;
        }

        .btn-primary333 {
            background-color: #56b4be; /* Bright turquoise */
            border-color: #56b4be; /* Bright turquoise */
            color: white;
        }

        .btn-primary333:hover {
            background-color: #3D4E67;
            border-color: #3D4E67;
            color: white;
        }

        h2 {
            color: #3D4E67;
            font-style: italic;
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            font-family: 'Georgia', serif;
            width: 100%;
        }
    </style>
</head>

<body>
<div class="container">
    <h2 class="mt-4 mb-4">MANAGE FLIGHTS</h2>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="add_flight.php" class="btn btn-primary333">Add Flight</a>
        <a href="admin_dashboard.php" class="btn btn-custom">Back to Admin Dashboard</a>
    </div>

    <!-- Flight Search Form -->
    <form method="post" class="search-form mb-4">
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Search by Source" name="source"
                       value="<?php echo htmlspecialchars($search_source); ?>">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Search by Destination" name="destination"
                       value="<?php echo htmlspecialchars($search_destination); ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary" name="search">Search</button>

            </div>
        </div>
    </form>

    <?php if (!empty($delete_message)): ?>
        <div class="alert alert-success"><?php echo $delete_message; ?></div>
    <?php endif; ?>



    <div class="row">
        <?php if (count($flights) > 0): ?>
            <?php foreach ($flights as $flight): ?>
                <div class="col-md-4">
                    <div class="flight-card">
                        <h5>Flight ID: <?php echo $flight['flight_id']; ?></h5>
                        <img src="../images/img_12.png" alt="Flight Image" class="flight-image">
                        <p><strong>Source:</strong> <?php echo $flight['source']; ?></p>
                        <p><strong>Destination:</strong> <?php echo $flight['Destination']; ?></p>
                        <p><strong>Departure:</strong> <?php echo $flight['Departure']; ?></p>
                        <p><strong>Arrival:</strong> <?php echo $flight['Arrival']; ?></p>
                        <p><strong>Total business Seats:</strong> <?php echo $flight['Total_business_seats']; ?></p>
                        <p><strong>Total Economy Seats:</strong> <?php echo $flight['Total_economy_seats']; ?></p>
                        <p><strong>Available business Seats:</strong> <?php echo $flight['Available_business_seats']; ?></p>
                        <p><strong>Available Economy Seats:</strong> <?php echo $flight['Available_Economy_seats']; ?></p>
                        <p><strong>Price per business Seat:</strong> <?php echo $flight['price_business_seat']; ?></p>
                        <p><strong>Price per Economy Seat:</strong> <?php echo $flight['price_economy_seat']; ?></p>
                        <p><strong>Status:</strong> <?php echo $flight['status']; ?></p>
                        <p><strong>Airline:</strong> <?php echo $flight['Airline_name']; ?></p>
                        <p><strong>Aircraft Name:</strong> <?php echo $flight['aircraft_name']; ?></p>
                        <p><strong>Duration:</strong> <?php echo $flight['Duration']; ?></p>

                        <a href="update_flight.php?id=<?php echo $flight['flight_id']; ?>" class="btn btn-sm btn-primary333">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-flight" data-flight-id="<?php echo $flight['flight_id']; ?>" data-toggle="modal" data-target="#deleteModal">Delete</button>


                    </div>
                </div>
            <?php endforeach; ?>


        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">No flights found.</div>
                <a href="manage_flights.php" class="btn btn-secondary back-btn">Back to All flights</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS and dependencies - Replace with your preferred version or local files -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

