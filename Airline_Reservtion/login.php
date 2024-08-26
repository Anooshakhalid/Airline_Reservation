<?php
session_start();
include('config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['user_pwd'])) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: user_dashboard.php");
            exit();
        } else {
            $login_error = "Invalid email or password.";
        }
    } else {
        $login_error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-family: 'Georgia', cursive;
            color: #3D4E67;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-container form label {
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
            text-align: left;
            width: 100%;
        }

        .login-container form input {
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #879FC4;
            border-radius: 25px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .login-container form input:focus {
            border-color: #3D4E67;
        }

        .login-container form button {
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

        .login-container form button:hover {
            background-color: #879FC4;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: left;
            width: 100%;
        }



        .register-link,
        .forgot-password-link {
            margin-top: 15px;
            margin-left: 60px;
            font-size: 17px;
            color: #3D4E67;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .register-link:hover,
        .forgot-password-link:hover {
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
        <div class="login-container">
            <h2>USER LOGIN</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <?php if (!empty($login_error)) echo "<p class='error-message'>$login_error</p>"; ?>
            <a href="register.php" class="register-link">Don't have an account? Register here</a>
            <a href="change_psw_user.php" class="forgot-password-link">Oops forgot your password?Click here</a>
        </div>
    </div>
</div>
</body>
</html>

