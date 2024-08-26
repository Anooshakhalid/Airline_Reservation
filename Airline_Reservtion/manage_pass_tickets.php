<?php
include 'header.php';
session_start();
require_once('config.php'); // Replace with your database configuration file

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Initialize variables
$delete_message = '';
$search_fname = '';
$search_lname = '';

// Handle passenger deletion if psg_id is provided via GET
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['psg_id']) && is_numeric($_GET['psg_id'])) {
    $psg_id = $_GET['psg_id'];

    // Prepare SQL statement to delete passenger
    $sql_delete_passenger = "DELETE FROM passenger WHERE psg_id = ?";
    $stmt_delete_passenger = $conn->prepare($sql_delete_passenger);
    $stmt_delete_passenger->bind_param("i", $psg_id);

    // Execute the statement
    if ($stmt_delete_passenger->execute()) {
        // Passenger deleted successfully
        $delete_message = "Passenger ID {$psg_id} deleted successfully!";
    } else {
        // Error occurred while deleting passenger
        $delete_message = "Error occurred while deleting the passenger: " . $conn->error;
    }

    // Close the statement
    $stmt_delete_passenger->close();
}

// Handle passenger search if form is submitted
if (isset($_POST['search'])) {
    $search_fname = $_POST['fname'];
    $search_lname = $_POST['lname'];

    // Prepare SQL statement for passenger search
    $sql_search_passenger = "SELECT p.*, t.* 
                            FROM passenger p 
                            INNER JOIN ticket t ON p.psg_id = t.psg_id
                            WHERE p.psg_Fname LIKE ? AND p.psg_Lname LIKE ?";
    $stmt_search_passenger = $conn->prepare($sql_search_passenger);
    $search_fname_param = "%{$search_fname}%";
    $search_lname_param = "%{$search_lname}%";
    $stmt_search_passenger->bind_param("ss", $search_fname_param, $search_lname_param);

    // Execute the statement
    $stmt_search_passenger->execute();
    $result_passengers = $stmt_search_passenger->get_result();

    $passengers = [];
    if ($result_passengers->num_rows > 0) {
        while ($row = $result_passengers->fetch_assoc()) {
            $passengers[] = $row;
        }
    }

    // Close the statement
    $stmt_search_passenger->close();
} else {
    // Fetch all passengers with their associated tickets from the database
    $sql_fetch_passengers = "SELECT p.*, t.* 
                            FROM passenger p 
                            INNER JOIN ticket t ON p.psg_id = t.psg_id";
    $result_passengers = $conn->query($sql_fetch_passengers);

    $passengers = [];
    if ($result_passengers->num_rows > 0) {
        while ($row = $result_passengers->fetch_assoc()) {
            $passengers[] = $row;
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
    <title>Ticket's List</title>
    <!-- Bootstrap CSS - Replace with your preferred version or local file -->
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

        .search-img {
            position: absolute;
            max-width: 11.5%;
            margin-left: 920px;
            margin-top: -67px;
            border-radius: 50px;
        }

        .back-btn {
            margin-bottom: 10px;
            border-radius: 20px;
            margin-top: -40px;
        }
        .search-form {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }
        .search-form .form-control {
            border-radius: 20px; /* Rounded corners */
            padding-left: 25px; /* Space for search icon */
        }
        .search-form .form-control::placeholder {
            font-style: italic; /* Italic placeholder text */
        }
        .search-form .btn-primary {
            border-radius: 20px; /* Rounded corners */
            width: 100%; /* Full width for button */
            margin-top: 03px; /* Spacing from inputs */
        }

        /* Ticket card styling */
        .ticket-card {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid darkblue;
            border-radius: 20px; /* Rounded corners */
            background-color: aliceblue; /* White background */
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1); /* Light shadow */
            position: relative;
            display: flex;
            overflow: hidden;
        }

        /* Punch hole effect */
        .ticket-card::before, .ticket-card::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background: hotpink;
        }

        .ticket-card::before {
            top: 10px;
            left: -10px;
        }

        .ticket-card::after {
            top: 10px;
            right: -10px;
        }

        .ticket-card img {
            max-width: 30%;
            margin-left: auto;
            border-radius: 5px;
        }

        .ticket-details {
            flex: 2;
        }

        .ticket-details h5 {
            margin-top: 0;
        }

        .ticket-details p {
            margin-bottom: 5px;
        }


    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">
        TICKET'S LIST
    </h2>
    <?php if (!empty($delete_message)): ?>
        <div class="alert alert-success"><?php echo $delete_message; ?></div>
    <?php endif; ?>

    <!-- Passenger Search Form -->
    <form method="post" class="search-form mb-4">

        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Search by First Name" name="fname" value="<?php echo htmlspecialchars($search_fname); ?>">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Search by Last Name" name="lname" value="<?php echo htmlspecialchars($search_lname); ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary" name="search">Search</button>
            </div>
            <img src="../images/img_14.png" alt="Search Image" class="search-img">

        </div>
    </form>

    <?php if (!isset($_POST['search'])): ?>
        <!-- Back to Dashboard Button -->
        <a href="admin_dashboard.php" class="btn btn-secondary back-btn">Back to Dashboard</a>
    <?php endif; ?>

    <div class="row">
        <?php if (count($passengers) > 0): ?>
            <?php foreach ($passengers as $passenger): ?>
                <div class="col-md-6">
                    <div class="ticket-card">
                        <img src="../images/img_15.png" alt="Passenger Image"> <!-- Placeholder for passenger image -->
                        <div class="ticket-details">
                            <h5><?php echo $passenger['psg_Fname'] . ' ' . $passenger['psg_Lname']; ?></h5>
                            <p><strong>Mobile:</strong> <?php echo $passenger['psg_mobile']; ?></p>
                            <p><strong>CNIC:</strong> <?php echo $passenger['psg_CNIC']; ?></p>
                            <p><strong>Date of Birth:</strong> <?php echo $passenger['psg_DOB']; ?></p>
                            <p><strong>Flight ID:</strong> <?php echo $passenger['flight_id']; ?></p>
                            <p><strong>Seat No:</strong> <?php echo $passenger['seat_no']; ?></p>
                            <p><strong>Payment Status:</strong> <?php echo $passenger['Payment_status']; ?></p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">No passengers found.</div>
                <a href="manage_pass_tickets.php" class="btn btn-secondary back-btn">Back</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Optional: JavaScript and dependencies for Bootstrap (e.g., jQuery, Popper.js) -->
    <!-- Ensure these scripts are included before the closing </body> tag -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
