<?php
session_start();
require_once('config.php');

$update_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Escape user inputs to prevent SQL injection
    $current_password = $conn->real_escape_string($current_password);
    $new_password = $conn->real_escape_string($new_password);

    // Check current password validity
    $sql_check = "SELECT * FROM users WHERE user_id='$user_id' AND user_pwd='$current_password'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 1) {
        // Update password
        $sql_update = "UPDATE users SET user_pwd='$new_password' WHERE user_id='$user_id'";
        if ($conn->query($sql_update) === TRUE) {
            $update_message = "Password updated successfully.";
        } else {
            $update_message = "Error updating password: " . $conn->error;
        }
    } else {
        $update_message = "Incorrect current password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #3D4E67, #A2A9B7, #879FC4, #56A3A6);
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            z-index: 1;
        }

        .left-side, .right-side {
            flex: 1;
            padding: 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left-side {
            background-color: #A2A9B7;
            text-align: center;
        }

        .left-side .header-text {
            font-size: 3.8em;
            font-family: 'Pacifico', cursive;
            color: #3D4E67;
            margin-bottom: 20px;
        }

        .left-side .slogan {
            font-size: 1.8em;
            color: #3D4E67;
        }

        .right-side {
            background-color: #ffffff;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
        }

        .change-password-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .change-password-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-family: 'Georgia', cursive;
            color: #3D4E67;
        }

        .change-password-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .change-password-container form label {
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
            text-align: left;
            width: 100%;
        }

        .change-password-container form input {
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #879FC4;
            border-radius: 25px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .change-password-container form input:focus {
            border-color: #3D4E67;
        }

        .change-password-container form button {
            padding: 12px 20px;
            background-color: #3D4E67;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .change-password-container form button:hover {
            background-color: #879FC4;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: left;
            width: 100%;
        }

        .login-link {
            margin-top: 15px;
            margin-left: 145px;
            text-align: center;
            font-size: 17px;
            color: #3D4E67;
            text-decoration: none;
            display: inline-block;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        @keyframes float {
            0% {
                transform: translatey(0px);
            }
            50% {
                transform: translatey(-10px);
            }
            100% {
                transform: translatey(0px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left-side">
        <div class="header-text floating">𝙁𝙡𝙮𝙬𝙞𝙩𝙝𝙐𝙨</div>
        <div class="slogan">Your journey, Our wings</div>
    </div>
    <div class="right-side">
        <div class="change-password-container">
            <h2>CHANGE PASSWORD</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="submit">Update Password</button>
            </form>
            <?php if (!empty($update_message)) echo "<p class='error-message'>$update_message</p>"; ?>
            <a href="login.php" class="login-link">Back to login</a>
        </div>
    </div>
</div>
</body>
</html>


