<?php
session_start();
include'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Card Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-group {
            margin-bottom: 10px; /* Space between form groups */
           
        }
        .custom-background {
            background-color:#A2A9B7 ; /* Set your desired background color here */
        }
    
    </style>
</head>
<body >
    <div class="container mt-5">
        <h1 class="mb-4">💳 Card Details</h1>
        <form method="post" action="payment_confirm.php">
            <input type="hidden" name="outbound_flight_id" value="<?php echo $_SESSION['outbound_flight_id']; ?>">
            <input type="hidden" name="return_flight_id" value="<?php echo isset($_SESSION['return_flight_id']) ? $_SESSION['return_flight_id'] : ''; ?>">
            <input type="hidden" name="travelers" value="<?php echo $_SESSION['travelers']; ?>">
            <input type="hidden" name="seat_class" value="<?php echo $_SESSION['seat_class']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="passenger_first_name" value="<?php echo implode(',', $_POST['passenger_first_name']); ?>">
            <input type="hidden" name="passenger_last_name" value="<?php echo implode(',', $_POST['passenger_last_name']); ?>">
            <input type="hidden" name="passenger_mobile" value="<?php echo implode(',', $_POST['passenger_mobile']); ?>">
            <input type="hidden" name="passenger_cnic" value="<?php echo implode(',', $_POST['passenger_cnic']); ?>">

            <div class="form-group">
                <label for="cardholder_name">Cardholder Name:</label>
                <input type="text" class="form-control rounded" name="cardholder_name" id="cardholder_name" required>
            </div>
            <div class="form-group">
                <label for="card_type">Card Type:</label>
                <select class="form-control rounded" name="card_type" id="card_type" required>
                    <option value="visa">Visa</option>
                    <option value="mastercard">MasterCard</option>
                    <option value="amex">American Express</option>
                </select>
            </div>
            <div class="form-group">
                <label for="card_no">Card Number:</label>
                <input type="text" class="form-control rounded" name="card_no" id="card_no" required>
            </div>
            <div class="form-group">
                <label for="cvv_no">CVV:</label>
                <input type="text" class="form-control rounded" name="cvv_no" id="cvv_no" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block rounded-pill">Confirm Booking</button>
        </form>
    </div>

    <!-- Bootstrap JS and custom scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
