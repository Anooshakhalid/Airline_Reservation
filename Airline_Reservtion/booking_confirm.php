<?php
session_start();
include 'config.php';
include'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color:white ;
        
        }

        .container {
            width: 1200px;
            margin-top: 20px; /* Space from the top */
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/2/23/Wikimania2023_Animated_Sticker_Airplane.gif'); /* Background GIF */
    
            border-radius: 60px;
            
        }

        .card {
            color: black;
            margin-bottom: 20px; /* Margin between cards */
            border: 3px solid white;
            border-radius: 50px; /* Remove card border */
            box-shadow: 5px 5px 10px gray; 
        }

        .card-header {
            background-color:white; /* Light gray background for card header */
            padding: 10px; 
            border-radius: 40px;/* Padding for card header */
        }

        .card-body {
            padding: 15px; /* Padding for card body */
            
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="text-center ">✈️Booking Details</h1>
                <form method="post" action="card_details.php">
                    <!-- Include necessary hidden fields -->
                    <input type="hidden" name="outbound_flight_id" value="<?php echo $_SESSION['outbound_flight_id']; ?>">
                    <input type="hidden" name="return_flight_id" value="<?php echo isset($_SESSION['return_flight_id']) ? $_SESSION['return_flight_id'] : ''; ?>">
                    <input type="hidden" name="travelers" value="<?php echo $_SESSION['travelers']; ?>">
                    <input type="hidden" name="seat_class" value="<?php echo $_SESSION['seat_class']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <!-- Display the total amount -->
                    <div class="form-group p-2 text-center" style="border: 2px solid black; background: whitesmoke; width: 200px; margin: 0 auto;">
                        <label><strong></strong>Total Amount:</strong></label>
                        <span><strong><?php echo $_SESSION['total_amount']; ?></strong></span>
                    </div>
                    <br><br>

                    <!-- Passenger Details -->
                    <?php
                    $travelers = $_SESSION['travelers'];
                    for ($i = 0; $i < $travelers; $i++): ?>
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mb-0">👤 Passenger <?php echo $i + 1; ?></h2>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-2">
                                    <label for="passenger_first_name_<?php echo $i; ?>">First Name:</label>
                                    <input type="text" class="form-control" name="passenger_first_name[]" id="passenger_first_name_<?php echo $i; ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="passenger_last_name_<?php echo $i; ?>">Last Name:</label>
                                    <input type="text" class="form-control" name="passenger_last_name[]" id="passenger_last_name_<?php echo $i; ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="passenger_mobile_<?php echo $i; ?>">Mobile Number:</label>
                                    <input type="text" class="form-control" name="passenger_mobile[]" id="passenger_mobile_<?php echo $i; ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="passenger_cnic_<?php echo $i; ?>">CNIC Number:</label>
                                    <input type="text" class="form-control" name="passenger_cnic[]" id="passenger_cnic_<?php echo $i; ?>" required>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <button type="submit" class="btn btn-primary btn-block">Next</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
