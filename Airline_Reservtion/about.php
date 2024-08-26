<?php
include 'header.php';?>

<main>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            height: 100%;
            width: 100%;
            overflow-x: hidden; /* Prevent horizontal scrolling */
            background-image: url('../images/img_22.png');
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;

            /* Background image */
            background-size: cover;
            background-position: center;
            padding: 20px;
            box-sizing: border-box;
        }
        .about-us {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            width: 100%;
            text-align: center;
        }
        .about-us h1, .about-us h2, .about-us h3 {
            font-family: 'Playfair Display', serif;
        }
        .about-us h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .about-us h2 {
            font-size: 2em;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .about-us h3 {
            font-size: 1.5em;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .about-us p {
            font-size: 1.1em;
            line-height: 1.6;
        }
        .about-us ul {
            list-style: none;
            padding: 0;
        }
        .about-us ul li {
            margin: 10px 0;
        }
        #targeting-contact address {
            font-style: normal;
            line-height: 1.6;
        }
        .social-media {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .social-media a {
            margin: 0 10px;
        }
        .social-media img {
            width: 40px;
            height: 40px;
        }

        .social-media p {
            margin: 0 10px;
        }
        .social-media1 img {
            width: 120px;
            height: 40px;
        }
        .additional-images {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .additional-images img {
            width: 150px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            margin-top: 20px;
            margin-left: 30px;
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
        <div class="about-us">
            <h1>About Us</h1>
            <p>Welcome to FlywithUs - Your Trusted Travel Partner Within Pakistan</p>
            <p>At FlywithUs, we're passionate about connecting you to the heart of Pakistan. With our commitment to excellence and a customer-centric approach, we have become the preferred choice for travelers seeking seamless and affordable airline solutions within the country.</p>

            <h2>Who We Are</h2>
            <p>FlywithUs is a leading domestic airline service provider, specializing in offering a wide range of options from various airline companies. Our dedicated team of travel experts works tirelessly to provide you with the best travel experience possible within Pakistan.</p>

            <h2>Our Mission</h2>
            <p>To make domestic air travel accessible, convenient, and enjoyable for everyone in Pakistan.</p>

            <h2>Our Vision</h2>
            <p>To become the go-to platform for hassle-free and cost-effective domestic air travel.</p>

            <h2>Why Choose FlywithUs?</h2>
            <ul>
                <li>Extensive Network within Pakistan</li>
                <li>Competitive Pricing</li>
                <li>Customer-Centric Approach</li>
                <li>24/7 Support</li>
            </ul>

            <h2>Our Team</h2>
            <p>Our success is driven by a team of aviation enthusiasts who are committed to innovation and excellence.</p>

            <h3>Get in Touch</h3>

            <section id="targeting-contact">
                <address>
                    FlywithUs Headquarters<br>
                    123 FlywithUs Avenue,<br>
                    Ned University of Eng & Tech, Karachi, 75330<br>
                    Phone: +1-123-456-7890<br>
                    Email: info@flywithus.com<br><br>CONNECT WITH US:
                </address>
            </section>

            <div class="social-media">
                <a href="#"><img src="../images/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="../images/twitter.png" alt="Twitter"></a>
                <a href="#"><img src="../images/instagram.png" alt="Instagram"></a>
                <a href="#"><img src="../images/linkedin.png" alt="LinkedIn"></a>
            </div>
            <div class="social-media1">
                <p href="#"><img src="../images/img_23.png" alt="playstore"></p>
            </div>

            <div class="additional-images">
                <img src="../images/img_26.png" alt="Additional Image 1">
                <img src="../images/img_24.png" alt="Additional Image 2">
                <img src="../images/img_27.png" alt="Additional Image 3">
                <img src="../images/img_25.png" alt="Additional Image 4">
            </div>



        </div>
        <a href="../index.php" class="back-button">Back to Home</a>
    </div>
</main>
