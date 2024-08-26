<?php
include 'header.php';

 session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
     header("Location: login.php");
     exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .w2{
            background-image: url('https://media3.giphy.com/media/l2Sq87bt4GOdAnlGo/giphy.gif?cid=6c09b952r5ty5ekopma2q99vzjq1uhotc4zpabodekqlwc07&ep=v1_internal_gif_by_id&rid=giphy.gif&ct=g'); /* Replace with your GIF URL */
            background-size: cover;
            background-repeat: no-repeat;
            height: 700px;
          
        }
        .card {
            border-radius: 20px;
            margin: 20px;
            width: 300px;
            height: 400px;
            display: inline-block;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            margin: 80px;
            border: 2px solid black;
            box-shadow: 2px 2px 2px blue;
        }
        .card img {
            border-radius: 10px 10px 0 0;
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container-fluid text-center w2">
        
        <h1 class="text-white">&ensp;&ensp;&ensp;&ensp;&ensp;𝕎𝕖𝕝𝕔𝕠𝕞𝕖 𝕥𝕠 𝕌𝕤𝕖𝕣 𝔻𝕒𝕤𝕙𝕓𝕠𝕒𝕣𝕕&ensp;&ensp;&ensp;&ensp;&ensp;<span><a href="logout.php" class="btn btn-danger">Logout</a></span>
        </h1>
        
        <!-- Book a Flight Card -->
        <div class="card">
            <img src="data:image/jpeg;base64,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" alt="Book Flight Image"> <!-- Replace with your image URL -->
            <div class="card-body">
                <h2 class="card-title">Book a Flight</h2>
                <p class="card-text">Click the button below to book a flight.</p>
                <form method="get" action="book_flight.php">
                    <button type="submit" class="btn btn-primary">Book Flight</button>
                </form>
            </div>
        </div>
        <div class="card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsSh9zdVeGeFBtHPpdgUczDn3kxAnKEWrnZg&s" alt="Book Flight Image"> <!-- Replace with your image URL -->
            <div class="card-body">
                <h2 class="card-title">View your Flight</h2>
                <p class="card-text">Click the button below to view flight.</p>
                <form method="get" action="view_ticket.php">
                    <button type="submit" class="btn btn-primary">View Flight</button>
                </form>
            </div>
        </div>
        
        
        <br><br>
        
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
