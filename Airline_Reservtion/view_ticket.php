<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$current_date = date('Y-m-d H:i:s');

// Retrieve upcoming tickets
$sql_upcoming = "SELECT t.ticket_id, f.Arrival, f.Departure, f.Destination, f.source, f.Duration, t.seat_no, t.Payment_status, p.psg_Fname, p.psg_Lname
                 FROM Ticket t
                 JOIN Passenger p ON t.psg_id = p.psg_id
                 JOIN Flight f ON t.flight_id = f.flight_id
                 WHERE p.user_id = ? AND f.Departure >= ?";
$stmt_upcoming = $conn->prepare($sql_upcoming);
$stmt_upcoming->bind_param("is", $user_id, $current_date);
$stmt_upcoming->execute();
$result_upcoming = $stmt_upcoming->get_result();

// Retrieve past tickets
$sql_past = "SELECT t.ticket_id, f.Arrival, f.Departure, f.Destination, f.source, f.Duration, t.seat_no, t.Payment_status, p.psg_Fname, p.psg_Lname
             FROM Ticket t
             JOIN Passenger p ON t.psg_id = p.psg_id
             JOIN Flight f ON t.flight_id = f.flight_id
             WHERE p.user_id = ? AND f.Departure < ?";
$stmt_past = $conn->prepare($sql_past);
$stmt_past->bind_param("is", $user_id, $current_date);
$stmt_past->execute();
$result_past = $stmt_past->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td {
            background-color: #fff;
        }

        .no-tickets {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            color: #999;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View All Tickets</h1>

        <h2>Upcoming Flights</h2>
        <?php if ($result_upcoming->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Passenger Name</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th>Seat No.</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_upcoming->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['ticket_id']; ?></td>
                            <td><?php echo $row['psg_Fname'] . ' ' . $row['psg_Lname']; ?></td>
                            <td><?php echo $row['Arrival']; ?></td>
                            <td><?php echo $row['Departure']; ?></td>
                            <td><?php echo $row['Destination']; ?></td>
                            <td><?php echo $row['source']; ?></td>
                            <td><?php echo $row['Duration']; ?></td>
                            <td><?php echo $row['seat_no']; ?></td>
                            <td><?php echo $row['Payment_status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="no-tickets">No upcoming flights found.</p>
        <?php endif; ?>

        <h2>Past Flights</h2>
        <?php if ($result_past->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Passenger Name</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Source</th>
                        <th>Duration</th>
                        <th>Seat No.</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_past->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['ticket_id']; ?></td>
                            <td><?php echo $row['psg_Fname'] . ' ' . $row['psg_Lname']; ?></td>
                            <td><?php echo $row['Arrival']; ?></td>
                            <td><?php echo $row['Departure']; ?></td>
                            <td><?php echo $row['Destination']; ?></td>
                            <td><?php echo $row['source']; ?></td>
                            <td><?php echo $row['Duration']; ?></td>
                            <td><?php echo $row['seat_no']; ?></td>
                            <td><?php echo $row['Payment_status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="no-tickets">No past flights found.</p>
        <?php endif; ?>

        <a class="back-link" href="user_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$stmt_upcoming->close();
$stmt_past->close();
$conn->close();
?>
