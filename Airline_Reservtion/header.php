<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .header-container {
            background-color: #3D4E67; /* Color specific to header container */
            padding: 15px; /* Padding to give some space */

        }

        .header-text {
            font-family: 'Roboto', sans-serif;
            font-size: 1.3em;
            font-weight: bold;
            color: floralwhite;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-left: 105px;
        }

        .image-block {
            position: absolute;
            top: 15px;
            left: 40px; /* Position the image block */
            width: 200px; /* Adjust width of the block */
            height: 200px; /* Adjust height of the block */
            overflow: hidden; /* Hide overflow content (if any) */
            background-color: transparent; /* Semi-transparent background */
            z-index: 10; /* Ensure it appears above other content */
        }

        .image-block img {
            width: auto; /* Maintain aspect ratio */
            height: 48px; /* Adjust height of the image */
            object-fit: cover; /* Maintain aspect ratio and cover entire container */
        }

        .slogan {
            font-family: 'Roboto', sans-serif;
            font-size: 0.8em;
            color: lightblue;
            display: flex;
            align-items: center;
            padding-left: 67px;
        }

        .slogan::before,
        .slogan::after {
            content: '';
            display: inline-block;
            width: 15px;
            height: 2px;
            background-color: gold;
            margin: 0 10px;
            vertical-align: middle;

        }



    </style>
<body>
<div class="image-block">
    <img src="images\img_1.png" alt="Image">
</div>
<div class="header-container">
    <div class="header-text">𝙁𝙡𝙮𝙬𝙞𝙩𝙝𝙐𝙨</div>
    <div class="slogan">Your journey, Our wings</div>
</div>
</body>
</html>
