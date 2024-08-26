<?php
include 'header.php';
include 'common.php';

list($sources, $destinations) = getFlightSourcesAndDestinations($conn);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>𝐁𝐨𝐨𝐤 𝐚 𝐅𝐥𝐢𝐠𝐡𝐭 🛫</h1>
        <form method="post" action="search_flights.php" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="flight_type" class="form-label">Flight Type:</label>
                <select name="flight_type" id="flight_type" class="form-select" required>
                    <option value="">Choose...</option>
                    <option value="one_way">One Way</option>
                    <option value="return">Return</option>
                </select>
                <div class="invalid-feedback">
                    Please select a flight type.
                </div>
            </div>
            <div class="col-md-6">
                <label for="source" class="form-label">From:</label>
                <select name="source" id="source" class="form-select" required>
                    <option value="">Choose...</option>
                    <?php foreach (array_keys($sources) as $source): ?>
                        <option value="<?= $source ?>"><?= $source ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Please select a source.
                </div>
            </div>
            <div class="col-md-6">
                <label for="destination" class="form-label">To:</label>
                <select name="destination" id="destination" class="form-select" required>
                    <option value="">Choose...</option>
                    <?php foreach (array_keys($destinations) as $destination): ?>
                        <option value="<?= $destination ?>"><?= $destination ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Please select a destination.
                </div>
            </div>
            <div class="col-md-6">
                <label for="departure_date" class="form-label">Departure Date:</label>
                <input type="date" name="departure_date" id="departure_date" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter a valid departure date.
                </div>
            </div>
            <div class="col-md-6">
                <label for="travelers" class="form-label">Number of Travelers:</label>
                <input type="number" name="travelers" id="travelers" class="form-control" min="1" value="1" required>
                <div class="invalid-feedback">
                    Please enter the number of travelers.
                </div>
            </div>
            <div class="col-md-6">
                <label for="seat_class" class="form-label">Seat Class:</label>
                <select name="seat_class" id="seat_class" class="form-select" required>
                    <option value="">Choose...</option>
                    <option value="economy">Economy</option>
                    <option value="business">Business</option>
                </select>
                <div class="invalid-feedback">
                    Please select a seat class.
                </div>
            </div>
            <div class="col-md-6 return-date" style="display: none;">
                <label for="return_date" class="form-label">Return Date:</label>
                <input type="date" name="return_date" id="return_date" class="form-control">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                        Agree to terms and conditions
                    </label>
                    <div class="invalid-feedback">
                        You must agree before submitting.
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Search Flights</button>
                <a href="user_dashboard.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('flight_type').addEventListener('change', function() {
            var returnDateField = document.querySelector('.return-date');
            if (this.value === 'return') {
                returnDateField.style.display = 'block';
            } else {
                returnDateField.style.display = 'none';
            }
        });
    </script>
</body>
</html>
