<?php
include 'header.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Experiences</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Shadows+Into+Light&family=Raleway:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background-color: transparent;
            overflow: auto;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("../images/img_38.png") no-repeat center center/cover;
            z-index: -1;
            filter: blur(8px);
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-family: 'Shadows Into Light', cursive;
            font-size: 3em;
            margin-bottom: 20px;
            padding: 10px;
            background-color: lightblue;
            color: black;
            border-radius: 10px;

        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .grid-item {
            background-color: #fff;
            border: 2px dashed #2e3b4e;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: calc(33.33% - 20px);
            min-width: 300px;
            padding: 20px;
            position: relative;
            text-align: left;
            transition: transform 0.3s ease;
            color: #2e3b4e;
            font-family: 'Shadows Into Light', cursive;
        }

        .grid-item:hover {
            transform: translateY(-10px);
        }

        .grid-item img {
            width: 20%;
            height: auto;
            margin-left: 150px;
            border-radius: 10px;
        }

        .grid-item h3 {
            font-family: 'Raleway', sans-serif;
            font-size: 1.8em;
            margin: 10px 0;
            color:  #3D4E67;
            text-align: center;
        }

        .grid-item p {
            font-size: 1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .note {
            position: relative;
            background-color: #fffae6;
            border: 2px dashed #2e3b4e;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .note:before {
            content: "";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            background-color: #ff6347;
            border-radius: 50%;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #2e3b4e;
        }

        .note img {
            width: 80%;
            height: auto;
            display: block;
            margin: 10px auto;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #2e3b4e;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #1b2838;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>User Travel Experiences</h1>
    <div class="grid">
        <div class="grid-item">
            <img src="../images/img_41.png" alt="Areesha's Experience">
            <h3>Areesha Farooq</h3>
            <p>Booking with FlywithUs was an absolute breeze! My trip to Islamabad was unforgettable, thanks to the seamless experience provided by the app. The flight was comfortable, and the customer service was top-notch.</p>
            <div class="note">
                <img src="../images/img_47.png" alt="Areesha's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_45.png" alt="Ahmed Khan's Experience">
            <h3>Ahmed Khan</h3>
            <p>I loved how easy it was to find affordable tickets to Skardu. The scenic beauty was breathtaking, and I owe it all to FlywithUs for making my trip so memorable.</p>
            <div class="note">
                <img src="../images/img_48.png" alt="Ahmed Khan's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_40.png" alt="Anoosha's Experience">
            <h3>Anoosha Khalid</h3>
            <p>My family trip to Lahore was fantastic! The app made it so easy to book tickets and manage our travel plans. FlywithUs's service was impeccable, and we had an amazing time exploring the city.</p>
            <div class="note">
                <img src="../images/img_49.png" alt="Anoosha's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_39.png" alt="laiba's Experience">
            <h3>Laiba Iqrar</h3>
            <p>Travelling to Gilgit Baltistan was a dream come true. Thanks to FlywithUs, the booking process was smooth, and the flight was comfortable. I highly recommend this service!</p>
            <div class="note">
                <img src="../images/img_54.png" alt="laiba's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_46.png" alt="bilal's Experience">
            <h3>Bilal Ahmed</h3>
            <p>I was amazed by the efficiency of FlywithUs. My solo trip to Multan was a breeze, and I had a fantastic time exploring the city's rich heritage and culture.</p>
            <div class="note">
                <img src="../images/img_50.png" alt="bilal's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_43.png" alt="mirha's Experience">
            <h3>Mirha Abdurraheem</h3>
            <p>The app's user-friendly interface made it simple to book my trip to Quetta. The flight was pleasant, and the service was excellent. FlywithUs made my travel hassle-free.</p>
            <div class="note">
                <img src="../images/img_52.png" alt="mirha's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_44.png" alt="kamran's Experience">
            <h3>Kamran Ali</h3>
            <p>Exploring Chitral was a wonderful experience, all thanks to FlywithUs. The booking process was quick and easy, and the flight was comfortable. I had an amazing time!</p>
            <div class="note">
                <img src="../images/img_53.png" alt="kamran's Experience Image 2">
            </div>
        </div>
        <div class="grid-item">
            <img src="../images/img_42.png" alt="=mahnoor's Experience">
            <h3>Mahnoor Zia</h3>
            <p>Booking with FlywithUs made my trip to Peshawar incredibly smooth. The service was great, and the flight was on time. I had a fantastic time exploring the city.</p>
            <div class="note">
                <img src="../images/img_51.png" alt="mahnoor's Experience Image 2">
            </div>
        </div>
    </div>
    <a href="../index.php" class="back-button">Back to Home</a>
</div>
</body>
</html>
