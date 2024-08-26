<!DOCTYPE html>
<html>
<head>
    <title>Flight Search Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        /* Your CSS styles here */
        body {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            background-color: blanchedalmond;
            margin: 0;
            padding: 10;
            display: flex;
            flex-direction: column; /* Stack content vertically */
            min-height: 600vh; /* Ensure full height of viewport */
            align-items: center; /* Center content horizontally */
        }
        .header {
            width: 100%; /* Full width header */
            padding: 0px 0; /* Example padding */
        }
        .ticket {
            background-color:white;
            border-radius: 10px;
            box-shadow: 0 0 70px white;
            padding: 30px;
            margin: 20px;
            animation: ticket 5s infinite;
            width: 1200px;
        }
        /* Your other styles here */
    </style>
</head>
<body style="background-color:#A2A9B7;"></body>

<div class="header">
    <?php include 'header.php'; ?>
</div>
<br><br>
<br><br>
<br><br>
<div class="ticket">
    <?php
    // PHP code to retrieve flight data and display tickets
    require_once('config.php');

    // Retrieve form data
    $flight_type = isset($_POST['flight_type']) ? $_POST['flight_type'] : '';
    $source = isset($_POST['source']) ? $_POST['source'] : '';
    $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
    $departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $return_date = isset($_POST['return_date']) ? $_POST['return_date'] : null;
    $travelers = isset($_POST['travelers']) ? $_POST['travelers'] : '';
    $seat_class = isset($_POST['seat_class']) ? $_POST['seat_class'] : '';

    $stmt_outbound = $conn->prepare("SELECT * FROM flight WHERE source = ? AND destination = ? AND departure >= ?");
    $stmt_outbound->bind_param('sss', $source, $destination, $departure_date);
    $stmt_outbound->execute();
    $result_outbound = $stmt_outbound->get_result();

    if ($flight_type === 'return' && $return_date) {
        $stmt_return = $conn->prepare("SELECT * FROM flight WHERE source = ? AND destination = ? AND departure >= ?");
        $stmt_return->bind_param('sss', $destination, $source, $return_date);
        $stmt_return->execute();
        $result_return = $stmt_return->get_result();
    }

    if ($result_outbound->num_rows > 0) {
        echo "<h2>✈️ Available Outbound Flights ✈️</h2>";
        echo "<form method='post' action='payment_process.php'>";
        echo "<table class='table table-hover'>";
        echo "<thead class='thead-light'><tr><th class='narrow'>Select</th><th class='narrow'><i class='fa fa-plane'></i> Airline</th><th class='narrow'><i class='fa fa-clock'></i> Departure</th><th class='narrow'><i class='fa fa-clock'></i> Arrival</th><th class='wide'><i class='fa fa-plane'></i> Aircraft name</th><th class='narrow'><i class='fa fa-hourglass-half'></i> Duration</th><th class='narrow'><i class='fa fa-dollar-sign'></i> Price (business)</th><th class='narrow'><i class='fa fa-dollar-sign'></i> Price (Economy)</th></tr></thead><tbody>";
        while ($row = $result_outbound->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='radio' name='outbound_flight_id' value='" . $row['flight_id'] . "' required></td>";
            echo "<td class='wide'><i class='fa fa-plane'></i> " . $row['Airline_id'] . "</td>";
            echo "<td class='wide'><i class='fa fa-clock'></i> " . $row['Departure'] . "</td>";
            echo "<td class='wide'><i class='fa fa-clock'></i> " . $row['Arrival'] . "</td>";
            echo "<td class='wide'><i class='fa fa-plane'></i> " . $row['aircraft_name'] . "</td>";
            echo "<td class='wide'><i class='fa fa-hourglass-half'></i> " . $row['Duration'] . "</td>";
            echo "<td class='wide'><i class='fa fa-dollar-sign'></i> " . $row['price_business_seat'] . "</td>";
            echo "<td class='wide'><i class='fa fa-dollar-sign'></i> " . $row['price_economy_seat'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";

        if ($flight_type === 'return' && isset($result_return) && $result_return->num_rows > 0) {
            echo "<h2>Available Return Flights ✈️</h2>";
            echo "<table class='table table-hover'>";
            echo "<thead class='thead-light'><tr><th class='narrow'>Select</th><th class='wide'><i class='fa fa-plane'></i> Airline</th><th class='wide'><i class='fa fa-clock'></i> Departure</th><th class='wide'><i class='fa fa-clock'></i> Arrival</th><th class='wide'><i class='fa fa-plane'></i> Aircraft</th><th class='narrow'><i class='fa fa-hourglass-half'></i> Duration</th><th class='narrow'><i class='fa fa-dollar-sign'></i> Price (business)</th><th class='narrow'><i class='fa fa-dollar-sign'></i> Price (Economy)</th></tr></thead><tbody>";
            while ($row = $result_return->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='radio' name='return_flight_id' value='" . $row['flight_id'] . "' required></td>";
                echo "<td class='wide'><i class='fa fa-plane'></i> " . $row['Airline_id'] . "</td>";
                echo "<td class='wide'><i class='fa fa-clock'></i> " . $row['Departure'] . "</td>";
                echo "<td class='wide'><i class='fa fa-clock'></i> " . $row['Arrival'] . "</td>";
                echo "<td class='wide'><i class='fa fa-plane'></i> " . $row['aircraft_name'] . "</td>";
                echo "<td class='wide'><i class='fa fa-hourglass-half'></i> " . $row['Duration'] . "</td>";
                echo "<td class='wide'><i class='fa fa-dollar-sign'></i> " . $row['price_business_seat'] . "</td>";
                echo "<td class='wide'><i class='fa fa-dollar-sign'></i> " . $row['price_economy_seat'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        }

        echo "<input type='hidden' name='travelers' value='$travelers'>";
        echo "<input type='hidden' name='seat_class' value='$seat_class'>";
        echo "<button type='submit' class='btn btn-dark'>Proceed to payment</button>";
        echo "</form>";
    } else {
        echo "<p>No flights found for the selected criteria.</p>";
    }

    $conn->close();
    ?>
    
</div>

<a href="book_flight.php" class="btn btn-dark">BACK</a>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
