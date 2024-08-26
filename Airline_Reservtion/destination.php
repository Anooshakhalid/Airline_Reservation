<?php include('header.php'); ?>

<main>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            height: 100%;
            width: 100%;
            overflow-x: hidden;
            background-color: #d1dce5; /* Rhino */
            color: #2e3b4e; /* Rhino */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #2e3b4e; /* Rhino */
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .grid-item {
            background-color: #ffffff; /* White */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: calc(33.33% - 20px); /* Three columns with gap */
            min-width: 250px;
            text-align: left; /* Align text to left */
            transition: transform 0.3s ease;
        }

        .grid-item:hover {
            transform: translateY(-10px);
        }

        .grid-item img {
            width: 100%;
            height: auto;
            display: block;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .grid-item .content {
            padding: 20px;
        }

        .grid-item h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #2e3b4e; /* Rhino */
            text-align: center;
        }

        .grid-item p {
            font-size: 1em;
            line-height: 1.6;
            color: #6b7380; /* Mischka */
        }

        .back-button {
            margin-top: 20px;
            margin-left: 700px;
            margin-bottom: -80px;
            padding: 10px 20px;
            background-color: #2e3b4e; /* Rhino */
            color: #ffffff; /* White */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #1c2733; /* Darker Rhino shade */
        }

    </style>

    <div class="container">
        <h1>Discover Pakistan's Destinations</h1>
        <div class="grid">
            <div class="grid-item">
                <img src="../images/img_30.png" alt="Karachi">
                <div class="content">
                    <h3>Karachi</h3>
                    <p>Experience the bustling economic hub of Pakistan, where the warm coastal breeze meets vibrant city life, perfect for sunny beach days and seafood lovers.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_33.png" alt="Islamabad">
                <div class="content">
                    <h3>Islamabad</h3>
                    <p>Nestled amidst lush greenery and serene hills, Islamabad offers a peaceful retreat with pleasant weather, ideal for nature lovers and those seeking tranquility.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_31.png" alt="Lahore">
                <div class="content">
                    <h3>Lahore</h3>
                    <p>Dive into Lahore's rich cultural heritage and vibrant markets, where every corner narrates stories of Mughal splendor, best enjoyed in cool winters with festivals and hearty cuisine.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_37.png" alt="Peshawar">
                <div class="content">
                    <h3>Peshawar</h3>
                    <p>Immerse yourself in Peshawar's ancient bazaars and rich history, ideal for exploring during mild spring days when the city blooms with colors and traditions.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_36.png" alt="Quetta">
                <div class="content">
                    <h3>Quetta</h3>
                    <p>Discover Quetta's picturesque landscapes and fruit orchards, perfect for summer escapes with cool evenings and breathtaking mountain views.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_32.png" alt="Skardu">
                <div class="content">
                    <h3>Skardu</h3>
                    <p>Gateway to the majestic Karakorams, Skardu beckons adventurers with its high-altitude treks and serene lakes, best visited in summer for clear skies and mild temperatures.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_28.png" alt="Gilgit Baltistan">
                <div class="content">
                    <h3>Gilgit Baltistan</h3>
                    <p>Lose yourself in the rugged beauty of Gilgit Baltistan, home to towering peaks and turquoise lakes, offering blissful summers and golden autumn hues.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_29.png" alt="Multan">
                <div class="content">
                    <h3>Multan</h3>
                    <p>Known as the city of saints and shrines, Multan's spiritual aura and architectural marvels shine brightest during mild winters and cool evenings.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_34.png" alt="Balochistan">
                <div class="content">
                    <h3>Balochistan</h3>
                    <p>Explore the vast wilderness of Balochistan, where ancient history meets vast deserts and rugged mountains, best experienced in spring and fall for pleasant weather.</p>
                </div>
            </div>
            <div class="grid-item">
                <img src="../images/img_35.png" alt="Chitral">
                <div class="content">
                    <h3>Chitral</h3>
                    <p>A hidden gem in Pakistan's north, Chitral captivates with its serene valleys and unique culture, perfect for summer escapes and autumn foliage.</p>
                </div>
            </div>
        </div>

    </div>
    <a href="../index.php" class="back-button">Back to Home</a>
</main>
