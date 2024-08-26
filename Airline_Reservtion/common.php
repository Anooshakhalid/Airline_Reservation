<?php
include 'config.php';

function getFlightSourcesAndDestinations($conn) {
    $sql = "SELECT DISTINCT source, Destination FROM flight";
    $result = $conn->query($sql);

    $sources = [];
    $destinations = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sources[$row['source']] = true;
            $destinations[$row['Destination']] = true;
        }
    }

    return [$sources, $destinations];
}

function getAirlineDetails($conn, $airline_id) {
    $sql = "SELECT Airline_name, airline_logo FROM Airline WHERE Airline_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $airline_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAirportDetails($conn, $airport_id) {
    $sql = "SELECT Airport_name, City FROM Airport WHERE Airport_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $airport_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
