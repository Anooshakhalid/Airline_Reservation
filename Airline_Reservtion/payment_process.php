// payment_process.php
<?php
session_start();
require_once('config.php');

if (isset($_POST['outbound_flight_id']) && isset($_POST['travelers']) && isset($_POST['seat_class']) && isset($_SESSION['user_id'])) {
    $outbound_flight_id = $_POST['outbound_flight_id'];
    $return_flight_id = isset($_POST['return_flight_id']) ? $_POST['return_flight_id'] : null;
    $travelers = $_POST['travelers'];
    $seat_class = $_POST['seat_class'];
    $user_id = $_SESSION['user_id'];

    $_SESSION['outbound_flight_id'] = $outbound_flight_id;
    if ($return_flight_id) {
        $_SESSION['return_flight_id'] = $return_flight_id;
    }
    $_SESSION['travelers'] = $travelers;
    $_SESSION['seat_class'] = $seat_class;

    // Fetch the price of the outbound flight
    $stmt_outbound_price = $conn->prepare("SELECT price_{$seat_class}_seat FROM Flight WHERE flight_id = ?");
    $stmt_outbound_price->bind_param('i', $outbound_flight_id);
    $stmt_outbound_price->execute();
    $stmt_outbound_price->bind_result($outbound_price);
    $stmt_outbound_price->fetch();
    $stmt_outbound_price->close();

    $total_amount = $outbound_price * $travelers;

    if ($return_flight_id) {
        // Fetch the price of the return flight
        $stmt_return_price = $conn->prepare("SELECT price_{$seat_class}_seat FROM Flight WHERE flight_id = ?");
        $stmt_return_price->bind_param('i', $return_flight_id);
        $stmt_return_price->execute();
        $stmt_return_price->bind_result($return_price);
        $stmt_return_price->fetch();
        $stmt_return_price->close();

        $total_amount += $return_price * $travelers;
    }

    $_SESSION['total_amount'] = $total_amount;

    header("Location: booking_confirm.php");
    exit();
} else {
    echo "Invalid request!";
}
?>
