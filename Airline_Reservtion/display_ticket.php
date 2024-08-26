// display_ticket.php
<?php
session_start();
require_once('config.php');
require_once('common.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['ticket_ids'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$ticket_ids = $_SESSION['ticket_ids'];

$sql = "SELECT t.ticket_id, f.Arrival, f.Departure, f.Destination, f.source, f.Duration, t.seat_no, t.Payment_status, p.psg_Fname, p.psg_Lname, a.Airline_name, a.airline_logo, sa.Airport_name AS source_airport, da.Airport_name AS destination_airport
        FROM Ticket t
        JOIN Passenger p ON t.psg_id = p.psg_id
        JOIN Flight f ON t.flight_id = f.flight_id
        JOIN Airline a ON f.Airline_id = a.Airline_id
        JOIN Airport sa ON f.Source_Airport_ID = sa.Airport_ID
        JOIN Airport da ON f.Destination_Airport_ID = da.Airport_ID
        WHERE t.ticket_id IN (" . implode(',', $ticket_ids) . ")";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket</title>
    <link rel="stylesheet" href="ticket_display.css"> <!-- Include external CSS file -->
</head>
<body>
<h1>View Ticket</h1>

<?php if ($result->num_rows > 0) : ?>
    <div id="tickets-container">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="ticket" id="ticket-<?php echo $row['ticket_id']; ?>">
                <div class="ticket-header">
                    <span>Ticket ID: <?php echo $row['ticket_id']; ?></span>
                    <img src="<?php echo $row['airline_logo']; ?>" alt="<?php echo $row['Airline_name']; ?>">
                </div>
                <div class="ticket-body">
                    <p>Passenger Name: <?php echo $row['psg_Fname'] . ' ' . $row['psg_Lname']; ?></p>
                    <p>Source Airport: <?php echo $row['source_airport']; ?></p>
                    <p>Destination Airport: <?php echo $row['destination_airport']; ?></p>
                    <p>Arrival: <?php echo $row['Arrival']; ?></p>
                    <p>Departure: <?php echo $row['Departure']; ?></p>
                    <p>Duration: <?php echo $row['Duration']; ?></p>
                    <p>Seat No.: <?php echo $row['seat_no']; ?></p>
                </div>
                <div class="ticket-footer">
                    <p>Payment Status: <?php echo $row['Payment_status']; ?></p>
                </div>
                <button class="download-btn" onclick="downloadPDF('<?php echo $row['ticket_id']; ?>')">Download PDF</button>
            </div>

            <?php if (isset($_SESSION['return_flight_id'])) : ?>
                <div class="ticket" id="ticket-return-<?php echo $row['ticket_id']; ?>">
                    <div class="ticket-header">
                        <span>Return Ticket ID: <?php echo $row['ticket_id']; ?></span>
                        <img src="<?php echo $row['airline_logo']; ?>" alt="<?php echo $row['Airline_name']; ?>">
                    </div>
                    <div class="ticket-body">
                        <p>Passenger Name: <?php echo $row['psg_Fname'] . ' ' . $row['psg_Lname']; ?></p>
                        <p>Source Airport: <?php echo $row['destination_airport']; ?></p>
                        <p>Destination Airport: <?php echo $row['source_airport']; ?></p>
                        <p>Arrival: <?php echo $row['Arrival']; ?></p>
                        <p>Departure: <?php echo $row['Departure']; ?></p>
                        <p>Duration: <?php echo $row['Duration']; ?></p>
                        <p>Seat No.: <?php echo $row['seat_no'] + 1; ?></p> <!-- Adjust seat number for return flight -->
                    </div>
                    <div class="ticket-footer">
                        <p>Payment Status: <?php echo $row['Payment_status']; ?></p>
                    </div>
                    <button class="download-btn" onclick="downloadPDF('<?php echo $row['ticket_id']; ?>')">Download PDF</button>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
<?php else : ?>
    <p>No tickets found.</p>
<?php endif; ?>

<a href="user_dashboard.php">Back to Dashboard</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<script>
    async function downloadPDF(ticketId) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const ticketRow = document.getElementById(`ticket-${ticketId}`);
        if (!ticketRow) {
            console.error('Ticket row not found for ID:', ticketId);
            return;
        }
        try {
            const canvas = await html2canvas(ticketRow, { scale: 2, useCORS: true });
            const imgData = canvas.toDataURL('image/png');
            const imgProps = doc.getImageProperties(imgData);
            const pdfWidth = doc.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            doc.save(`ticket-${ticketId}.pdf`);
        } catch (error) {
            console.error('Error generating PDF:', error);
        }
    }
</script>
</body>
</html>


