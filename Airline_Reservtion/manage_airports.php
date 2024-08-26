<?php
include 'header.php';
session_start();
require_once('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle adding, updating, and deleting airports
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_airport'])) {
        $name = $_POST['name'];
        $city = $_POST['city'];

        if (!empty($name) && !empty($city)) {
            $sql = "INSERT INTO airport (Airport_name, City) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $name, $city);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($_POST['update_airport'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $city = $_POST['city'];

        if (!empty($name) && !empty($city)) {
            $sql = "UPDATE airport SET Airport_name=?, City=? WHERE Airport_ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $city, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($_POST['delete_airport'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM airport WHERE Airport_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch airports data ordered by ID
$airports_result = $conn->query("SELECT * FROM airport ORDER BY Airport_ID");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Airports</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Rhino */
            color: #495057; /* Mischka */
        }

        h2, h3 {
            color: #798D99;
            font-style: italic;
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            font-family: 'Georgia', serif;
        }



        form {
            margin-bottom: 20px;
            background-color: #ffffff; /* White */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%; /* Same width as table */
            display: flex;
            align-items: center;

        }

        form h3 {
            font-size: 1.5em; /* Smaller heading size */
            font-weight: bold;
            color: #3D4E67; /* Ship Cove */
        }

        form label {
            font-weight: bold;
            color: #3D4E67; /* Ship Cove */
        }

        form input[type=text] {
            max-width: 400px; /* Adjust max-width as needed */
            width: 100%; /* Make the input box expand to fill its container */
            padding: 10px; /* Adjust padding for spacing */
            border: 1px solid #ced4da;
            border-radius: 10px;
            box-sizing: border-box;
        }

        form .action-buttons {
            display: flex;
            align-items: center;
            margin-top: 10px;
            color: #ced1da;
        }

        form .action-buttons button {
            padding: 8px 15px;
            cursor: pointer;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            color: #fff;
        }

        form .action-buttons button.update-btn {
            background-color:  #56b4be; /* Fountain Blue */
            margin-top: -24px;
            margin-left: 10px;
        }

        form .action-buttons button.delete-btn {
            background-color: #dc3545; /* Red */
            margin-top: -24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff; /* White */
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        table th {
            background-color: #3D4E67; /* Rhino */
            color: #fff; /* Dark gray */
        }

        table tbody tr:hover {
            background-color: #f1f1f1; /* Light gray */
        }

        .btn-custom {
            padding-left: 34px;
            background-color:  #56b4be;
            border-color:  #56b4be;
            color: white;
        }

        .btn-custom:hover {
            background-color: #3D4E67;
            border-color: #3D4E67;
            color: white;
        }

        .img-fluid {
            max-width: 400px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
            position: absolute;
            right: 230px; /* Adjust the right positioning as needed */
            top: 180px; /* Adjust the top positioning as needed */
        }


        .ms-3 {
            margin-left: 30px; /* Increase margin for more space */
        }

        .d-flex {
            display: flex;
            align-items: center; /* Center align items vertically */
        }

        .align-items-center {
            align-items: center;
        }

        .flex-grow-1 {
            flex-grow: 1;
        }


    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">MANAGE AIRPORTS</h2>

    <!-- Add Form -->
    <form method="post" class="bg-light p-4 rounded shadow-sm d-flex align-items-center">
        <img src="../images/img_11.png" alt="Airport Image" class="img-fluid ms-3">

        <div class="flex-grow-1">
            <h3>Add Airport</h3>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" class="form-control" required>
            </div>
            <div class="action-buttons">
                <button type="submit" name="add_airport" class="btn btn-custom">Add Airport</button>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="admin_dashboard.php" class="btn btn-custom">Back to Admin Dashboard</a>
            </div>
        </div>
    </form>

    <!-- Airports Table -->
    <h3>Airports list</h3>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $airports_result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Airport_ID']); ?></td>
                <td><?php echo htmlspecialchars($row['Airport_name']); ?></td>
                <td><?php echo htmlspecialchars($row['City']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $row['Airport_ID']; ?>">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="New name" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="city" placeholder="New city" class="form-control">
                        </div>
                        <div class="action-buttons">
                            <button type="submit" name="update_airport" class="btn btn-primary update-btn">Update</button>
                            <button type="submit" name="delete_airport" class="btn btn-danger delete-btn">Delete</button>
                        </div>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


