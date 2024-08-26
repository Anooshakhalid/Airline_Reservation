<?php
include 'header.php'; // Assuming header.php contains necessary includes and session_start()
session_start();
require_once('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle user deletion if action is 'delete' and user_id is provided via GET
$delete_message = '';
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare SQL statement to delete user
    $sql_delete = "DELETE FROM users WHERE user_id = ?";

    // Using prepared statement to prevent SQL injection
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $user_id);

    // Execute the statement
    if ($stmt_delete->execute()) {
        // Set delete success message
        $delete_message = "User ID {$user_id} deleted successfully!";
    } else {
        // Error occurred while deleting user
        $delete_message = "Error occurred while deleting the user: " . $conn->error;
    }

    // Close the statement
    $stmt_delete->close();
}

// Fetch users based on search query or all users if no search query is present
$sql_select = "SELECT user_id, user_name, email FROM users";
$search_term = '';

if (isset($_POST['search']) && !empty($_POST['user_name'])) {
    $search_term = $_POST['user_name'];
    $sql_select .= " WHERE user_name LIKE '%" . $conn->real_escape_string($search_term) . "%'";
}

$result = $conn->query($sql_select);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
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
    <title>Manage Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            color: #2c3e50;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            color: #798D99;
            font-style: italic;
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            font-family: 'Georgia', serif;
        }

        .table th {
            background-color: #3D4E67;
            color: #fff;
        }

        .table td {
            color: #3D4E67;
        }

        .table tbody tr:hover {
            background-color: #A7A9AC;
            color: #fff;
        }

        .btn-primary {
            background-color: #56B4D3;
            border-color: #56B4D3;
        }

        .btn-primary:hover {
            background-color: #3D4E67;
            border-color: #3D4E67;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }

        .search-form .form-control {
            border-radius: 20px;
            padding-left: 25px;
            font-style: italic;
            background-color: #F2F2F2;
            border-color: #7A869A;
        }

        .search-form .btn-primary {
            border-radius: 20px;
        }

        .alert-success {
            background-color: #DFF2BF;
            color: #4F8A10;
        }

        .alert-info {
            background-color: #BDE5F8;
            color: #00529B;
        }

        .button-row {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Align items with space between them */
            margin-bottom: 20px;
        }

        .button-row .btn {
            margin-right: 10px;
        }

        .search-form-wrapper {
            display: flex;
            align-items: center;
        }

        .search-form-wrapper .form-control {
            border-radius: 20px;
            padding-left: 25px;
            font-style: italic;
            background-color: #F2F2F2;
            border-color: #7A869A;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Manage Users</h2>

    <div class="button-row">
        <div>
            <?php if (empty($search_term)): ?>
                <a href="admin_dashboard.php" class="btn btn-primary">Back to Admin Dashboard</a>
            <?php endif; ?>
        </div>

        <div class="ml-auto">
            <?php if (!isset($_POST['search']) || empty($_POST['user_name'])): ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="search-form-wrapper">
                    <input type="text" class="form-control" placeholder="Search by User Name" name="user_name" value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary" name="search">Search</button>
                </form>
            <?php endif; ?>
        </div>


        <?php if (isset($_POST['search'])): ?>
            <a href="manage_users.php" class="btn btn-primary">Back to Manage Users</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($delete_message)): ?>
        <div class="alert alert-success"><?php echo $delete_message; ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <?php if (count($users) > 0): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['user_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td>
                                <a href="manage_users.php?action=delete&id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No users found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
