<?php
session_start();
require_once('config.php');

if (isset($_SESSION['user_id']) && isset($_SESSION['outbound_flight_id']) && isset($_SESSION['travelers']) && isset($_SESSION['seat_class'])) {
    $user_id = $_SESSION['user_id'];
    $outbound_flight_id = $_SESSION['outbound_flight_id'];
    $travelers = $_SESSION['travelers'];
    $seat_class = $_SESSION['seat_class'];
    $total_amount = $_SESSION['total_amount'];

    // Retrieve passenger details from POST data as arrays
    $passenger_first_names = explode(',', $_POST['passenger_first_name']);
    $passenger_last_names = explode(',', $_POST['passenger_last_name']);
    $passenger_mobiles = explode(',', $_POST['passenger_mobile']);
    $passenger_cnic = explode(',', $_POST['passenger_cnic']);
    $cardholder_name = $_POST['cardholder_name'];
    $card_type = $_POST['card_type'];
    $card_no = $_POST['card_no'];
    $cvv_no = $_POST['cvv_no'];

    // Check if passenger details are correctly received as arrays
    if (is_array($passenger_first_names) && is_array($passenger_last_names) && is_array($passenger_mobiles) && is_array($passenger_cnic)) {
        $conn->begin_transaction();

        try {
            // Insert card details
            $stmt_card = $conn->prepare("INSERT INTO Card (cardholder_name, CardNo, user_id, expire_date, card_type, cvv_no) VALUES (?, ?, ?, ?, ?, ?)");
            $expire_date = '2025-12-31';
            $stmt_card->bind_param('siissi', $cardholder_name, $card_no, $user_id, $expire_date, $card_type, $cvv_no);
            $stmt_card->execute();
            $card_id = $conn->insert_id;

            // Insert payment details for outbound flight
            $stmt_payment_outbound = $conn->prepare("INSERT INTO Payment (card_id, flight_id, pay_date, pay_amount) VALUES (?, ?, ?, ?)");
            $pay_date = date('Y-m-d');
            $stmt_payment_outbound->bind_param('iisi', $card_id, $outbound_flight_id, $pay_date, $total_amount);
            $stmt_payment_outbound->execute();

            // Insert passenger details and create tickets
            $passenger_ids = [];
            $ticket_ids = [];
            for ($i = 0; $i < count($passenger_first_names); $i++) {
                // Insert passenger for outbound flight
                $stmt_passenger_outbound = $conn->prepare("INSERT INTO Passenger (user_id, flight_id, psg_Fname, psg_Lname, psg_mobile, psg_CNIC, psg_DOB) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $dob = '1990-01-01';  // Example DOB
                $stmt_passenger_outbound->bind_param('iisssss', $user_id, $outbound_flight_id, $passenger_first_names[$i], $passenger_last_names[$i], $passenger_mobiles[$i], $passenger_cnic[$i], $dob);
                $stmt_passenger_outbound->execute();
                $passenger_id = $conn->insert_id;
                $passenger_ids[] = $passenger_id;

                // Create ticket for outbound flight
                $stmt_ticket_outbound = $conn->prepare("INSERT INTO Ticket (flight_id, psg_id, user_id, seat_no, Payment_status) VALUES (?, ?, ?, ?, 'Paid')");
                $seat_no = $i + 1;  // Example seat number assignment
                $stmt_ticket_outbound->bind_param('iiii', $outbound_flight_id, $passenger_id, $user_id, $seat_no);
                $stmt_ticket_outbound->execute();
                $ticket_ids[] = $stmt_ticket_outbound->insert_id;
            }

            // Commit transaction
            $conn->commit();

            // Store ticket and passenger information in session
            $_SESSION['passenger_ids'] = $passenger_ids;
            $_SESSION['ticket_ids'] = $ticket_ids;

            // Redirect to view ticket page
            header("Location: display_ticket.php");
            exit();
        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            echo "Failed to process payment and booking: " . $exception->getMessage();
        }
    } else {
        echo "Invalid passenger details!";
    }
} else {
    echo "Invalid session data!";
}


$conn->close();
?>
