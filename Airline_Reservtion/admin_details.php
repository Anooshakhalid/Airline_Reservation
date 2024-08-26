<?php
include 'header.php';
session_start();
require_once('config.php');

// Check if user is logged in, otherwise redirect to login page
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

$sql = "SELECT admin_id, admin_name, admin_email, admin_pwd FROM admin ORDER BY admin_id ASC";
$result = $conn->query($sql);

$admins = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F0F4F8; /* Fountainblue */
            color: #2B3A42; /* Rhino */
        }
        .container {
            max-width: 800px;
            margin: 15px auto;
            padding: 20px;
            background-color: #E1E6EC; /* Mischka */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-style: italic;
            color: #7289A4; /* Ship Cove */
        }
        .admin-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .admin-card {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #FFF;
            border-radius: 50px; /* Oval shape */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .admin-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .admin-card div {
            display: flex;
            flex-direction: column;
        }
        .admin-card h2 {
            margin: 0;
            color: #2B3A42; /* Rhino */
        }
        .admin-card p {
            margin: 5px 0 0;
            color: #7289A4; /* Ship Cove */
        }
        .admin-actions {
            margin-left: auto;
            display: flex;
            gap: 10px;
        }
        .admin-actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn {
            background-color: #F44336; /* Red */
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Admin Details</h1>
    <div class="admin-list">
        <?php foreach ($admins as $admin) : ?>
            <div class="admin-card">
                <img src="https://via.placeholder.com/50?text=<?= strtoupper(htmlspecialchars($admin['admin_name'][0])); ?>" alt="<?= htmlspecialchars($admin['admin_name']); ?>">
                <div>
                    <h2><?= htmlspecialchars($admin['admin_name']); ?></h2>
                    <p><?= htmlspecialchars($admin['admin_email']); ?></p>
                </div>
                <div class="admin-actions">
                    <button class="delete-btn">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                alert('Delete functionality to be implemented');
            });
        });
    });
</script>
</body>
</html>
