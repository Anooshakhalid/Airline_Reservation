<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOUR JOURNEY, OUR WINGS</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            width: 100%;
            overflow: hidden;
            background-image: url("images/img_20.png");
        }
        .container {
            display: flex;
            height: 100vh;
            width: 100vw;

            position: relative;
        }
        .image-container {
            position: relative;
            width: 60%;
            height: 100%;
            clip-path: path('M 100 100 200 200 Q 400 400 260 400 T 200 500 T 3000 1800 T 240 3600 Q 0 3000 0 4200 L 0 0 z'); /* Adjusted path for more coverage */
            overflow: hidden;
        }
        .image-container img {
            height: 100%;
            width: auto;
            position: absolute;
            top: 0;
            left: 0;
        }
        .content {
            width: 40%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }
        .logo {
            position: absolute;
            top: 25px;
            left: 38px;
            font-size: 1.15em;
            color:  #3D4E67;
        }
        .buttons {
            position: absolute;
            top: 20px;
            right: 580px;
            display: flex;
            gap: 10px;
            font-size: 1.3em;
        }
        .buttons a {
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border: none;
            background-color: transparent;
            color: blueviolet;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .buttons a:hover {
            background-color: transparent;
            text-decoration: underline;
        }
        .content h1 {
            color: #3D4E67;
            font-style: italic;
            font-size: 6.3em;
            font-weight: bold;
            text-align: center;
            font-family: 'Montserrat ', serif;
            margin-right: 250px;
        }
        .content p {
            font-size: 1.8em;
            margin-right: 240px;
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-style: italic;
            margin-top: -45px;
            color: #2B3A42;

        }

        .sign-up {
            position: absolute;
            top: 20px;
            left: 85%;
            transform: translateX(-50%);
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-color: black;
            border-radius: 10px;
            background-color: #A7A9AC;
            color: black;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sign-up:hover {
            background-color: #7289A4;
        }

        .sign-in {
            position: absolute;
            top: 20px;
            left: 92%;
            transform: translateX(-50%);
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-color: black;
            background-color: #A7A9AC;
            color: black;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sign-in:hover {
            background-color: #7289A4;
        }



        .additional-image {
            position: absolute;
            bottom: -108px;
            right: 795px;
            width: 630px;
            height: auto;
        }

        .text {
            position: absolute;
            top: 13px;
            font-weight: bold;
            right: 19%;
            font-size: 1.1em;
            color: #3D4E67;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            margin-top: 20px;
        }

        .text1 {
            position: absolute;
            top: 63px;
            font-weight: bold;
            right: 19%;
            font-size: 1.1em;
            color: #3D4E67;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            margin-top: 20px;
        }


    </style>
</head>
<body>
<div class="container">
    <div class="image-container">
        <img src="images/img_17.png" alt="Airplane Image">
    </div>
    <div class="content">
        <div class="logo">YOUR JOURNEY, OUR WINGS</div>
        <div class="buttons">
            <a href="about.php" class="button">About</a>
            <a href="admin/experience.php" class="button">Feedback</a>
            <a href="admin/destination.php" class="button">Destinations</a>
        </div>
        <div class="text">ADMIN</div>
        <a href="register.php" class="sign-up">Sign Up</a>
        <a href="login.php" class="sign-in">Sign Up</a>
        <div class="text1">USER</div>
        <a href="admin_register.php" class="sign-in">Sign Up</a>
        <a href="admin_login.php" class="sign-in">Sign In</a>
        <h1>FlywithUs</h1>
        <p>Find your flight and discover the heart of PAKISTAN</p>


    </div>
</div>
<img class="additional-image" src="images/img_18.png" alt="Additional Image">
</body>
</html>
