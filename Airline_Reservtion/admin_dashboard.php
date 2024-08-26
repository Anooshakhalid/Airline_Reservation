<?php
session_start();
require_once('config.php');

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Logout handling
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index page (replace 'index.php' with your actual index page)
    header("Location: index.php");
    exit();
}

// Function to count total bookings
function countBookings() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total_bookings FROM ticket";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_bookings'];
    }
    return 0;
}

// Function to fetch counts from various tables
function fetchCounts($tableName) {
    global $conn;
    $sql = "SELECT COUNT(*) AS total_count FROM $tableName";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_count'];
    }
    return 0;
}

// Fetch counts from respective tables
$totalAirlines = fetchCounts('airline');
$totalAirports = fetchCounts('airport');
$totalUsers = fetchCounts('users');
$totalAdmins = fetchCounts('admin');
$totalPayments = fetchCounts('payment');
$totalBookings = countBookings();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            flex-direction: column;
            color: #2c3e50;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px;
            background-color: #3D4E67;
            padding-top: 70px; /* Adjust padding to clear the header */
            z-index: 90;
            color: white;
            overflow-y: auto;
        }

        .sidebar a {
            padding: 7px 20px;
            text-align: left;
            display: block;
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background-color: #677A9B;
        }

        .sidebar-img-7 {
            height: 170px;
            margin: 30px 0px;
        }

        .sub-header-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .sub-header-img-6 {
            height: 40px;
            margin-left: 10px;
        }

        .sub-header-text {
            font-family: 'Roboto', sans-serif;
            font-size: 1.3em;
            font-weight: bold;
            color: #798D99;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-back {
            display: flex;
            align-items: center;
            color: #2c3e50;
            font-size: 0.9em;
        }

        .sub-widgets {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .widget {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            flex: 1;
            margin: 10px;
            min-width: 200px;
        }

        .widget h3 {
            margin: 0;
            font-size: 24px;
            color: #56b4be;
        }

        .widget p {
            font-size: 18px;
            color: #2c3e50;
        }

        .btn-danger {
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-danger:hover {
            opacity: 0.8;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #56b4be;
            color: white;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="admin_details.php">Admin's</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_airlines.php">Manage Airlines</a>
    <a href="manage_airports.php">Manage Airports</a>
    <a href="manage_flights.php">Manage Flights</a>
    <a href="manage_pass_tickets.php">Manage Tickets</a>
    <a href="index.php" class="btn btn-danger mt-3">Logout</a>
    <img src="images/img_8.png" alt="Image 7" class="sidebar-img-7">
</div>

<div class="sub-header-content">
    <div class="sub-header-text">
        Admin Dashboard
        <div class="welcome-back">
            WELCOME BACK!
            <img src="images/img_6.png" alt="Image 6" class="sub-header-img-6">
        </div>
    </div>

    <div class="sub-widgets">
        <div class="widget">
            <h3>Total Users</h3>
            <div class="card">
                <div class="card-header">
                    Total Users
                </div>
                <div class="card-body">
                    <p><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>

        <div class="widget">
            <h3>Total Airlines</h3>
            <div class="card">
                <div class="card-header">
                    Total Airlines
                </div>
                <div class="card-body">
                    <p><?php echo $totalAirlines; ?></p>
                </div>
            </div>
        </div>

        <div class="widget">
            <h3>Total Airports</h3>
            <div class="card">
                <div class="card-header">
                    Total Airports
                </div>
                <div class="card-body">
                    <p><?php echo $totalAirports; ?></p>
                </div>
            </div>
        </div>

        <div class="widget">
            <h3>Total Payments</h3>
            <div class="card">
                <div class="card-header">
                    Total Payments
                </div>
                <div class="card-body">
                    <p><?php echo $totalPayments; ?></p>
                </div>
            </div>
        </div>

        <div class="widget">
            <h3>Total Bookings</h3>
            <div class="card">
                <div class="card-header">
                    Total Bookings
                </div>
                <div class="card-body">
                    <p><?php echo $totalBookings; ?></p>
                </div>
            </div>
        </div>

        <!-- Removed "Bookings by Month" widget -->

        <div class="widget">
            <h3>Current Date and Time</h3>
            <div class="card">
                <div class="card-body">
                    <p>Date: <?php echo date('Y-m-d'); ?></p>
                    <p>Day: <?php echo date('l'); ?></p>
                    <p>Time: <?php echo date('H:i:s'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: JavaScript and dependencies for Bootstrap (e.g., jQuery, Popper.js) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
