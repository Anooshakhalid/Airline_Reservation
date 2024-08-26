-- Create Users Table
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    user_pwd VARCHAR(255) NOT NULL
);

-- Create Admin Table
CREATE TABLE Admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(255) NOT NULL,
    admin_email VARCHAR(255) UNIQUE NOT NULL,
    admin_pwd VARCHAR(255) NOT NULL
);

-- Create Airport Table
CREATE TABLE Airport (
    Airport_ID INT AUTO_INCREMENT PRIMARY KEY,
    Airport_name VARCHAR(255) NOT NULL,
    City VARCHAR(255) NOT NULL,
    UNIQUE(Airport_name, City)
);
-- Drop and recreate the Airline table with updated fields
DROP TABLE IF EXISTS Airline;
CREATE TABLE Airline (
    Airline_id INT AUTO_INCREMENT PRIMARY KEY,
    Airline_name VARCHAR(255) NOT NULL,
    Airline_contact VARCHAR(20) NOT NULL,
    airline_logo VARCHAR(255) NOT NULL,  -- Add this line for airline logos
    UNIQUE(Airline_name, Airline_contact)
);

-- Drop and recreate the Flight table with updated fields
DROP TABLE IF EXISTS Flight;
CREATE TABLE Flight (
    flight_id INT AUTO_INCREMENT PRIMARY KEY,
    Airline_id INT NOT NULL,
    Available_business_seats INT NOT NULL,
    Available_Economy_seats INT NOT NULL,
    Total_business_seats INT NOT NULL,
    Total_economy_seats INT NOT NULL,
    Arrival DATETIME NOT NULL,
    Departure DATETIME NOT NULL,
    Destination_Airport_ID INT NOT NULL,
    Source_Airport_ID INT NOT NULL,
    Duration TIME NOT NULL,
    status VARCHAR(255) NOT NULL,
    price_business_seat DECIMAL(10, 2) NOT NULL,
    price_economy_seat DECIMAL(10, 2) NOT NULL,
    aircraft_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (Airline_id) REFERENCES Airline(Airline_id),
    FOREIGN KEY (Destination_Airport_ID) REFERENCES Airport(Airport_ID),
    FOREIGN KEY (Source_Airport_ID) REFERENCES Airport(Airport_ID)
);



-- Create Passenger Table
CREATE TABLE Passenger (
    psg_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    psg_Fname VARCHAR(255) NOT NULL,
    psg_Lname VARCHAR(255) NOT NULL,
    psg_mobile VARCHAR(20) NOT NULL,
    psg_CNIC VARCHAR(20) NOT NULL,
    psg_DOB DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (flight_id) REFERENCES Flight(flight_id)
);

-- Create Ticket Table
CREATE TABLE Ticket (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    flight_id INT NOT NULL,
    psg_id INT NOT NULL,
    user_id INT NOT NULL,
    seat_no INT NOT NULL, -- Assume it will be calculated later
    Payment_status VARCHAR(255) NOT NULL,
    FOREIGN KEY (flight_id) REFERENCES Flight(flight_id),
    FOREIGN KEY (psg_id) REFERENCES Passenger(psg_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Create Card Table
CREATE TABLE Card (
    card_id INT AUTO_INCREMENT PRIMARY KEY,
    CardNo BIGINT NOT NULL,
    cardholder_name VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    expire_date DATE NOT NULL,
    card_type VARCHAR(50) NOT NULL,
    cvv_no INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);


-- Create Payment Table with pay_date
CREATE TABLE Payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    card_id INT NOT NULL,
    flight_id INT NOT NULL,
    pay_date DATE NOT NULL,
    pay_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (card_id) REFERENCES Card(card_id),
    FOREIGN KEY (flight_id) REFERENCES Flight(flight_id)
);

-- Insert data into Users table
INSERT INTO Users (user_name, email, user_pwd) VALUES
('John Doe', 'john@example.com', 'password123'),
('Jane Smith', 'jane@example.com', 'password123'),
('Ali Ahmed', 'ali@example.com', 'password123');

-- Insert data into Admin table
INSERT INTO Admin (admin_name, admin_email, admin_pwd) VALUES
('Admin One', 'admin1@example.com', 'adminpassword'),
('Admin Two', 'admin2@example.com', 'adminpassword');

-- Insert data into Airport table
-- Insert data into Airport table
INSERT INTO Airport (Airport_name, City) VALUES
('Jinnah International Airport', 'Karachi'),
('Allama Iqbal International Airport', 'Lahore'),
('Islamabad International Airport', 'Islamabad');


-- Insert updated data into Airline table with logos
INSERT INTO Airline (Airline_name, Airline_contact, airline_logo) VALUES
('Pakistan International Airlines', '123-456-7890', 'image1.png'),
('AirBlue', '098-765-4321', 'image2.png');

-- Insert data into Flight table
INSERT INTO Flight (Airline_id, Available_business_seats, Available_Economy_seats, Total_business_seats, Total_economy_seats, Arrival, Departure, Destination_Airport_ID, Source_Airport_ID, Duration, status, price_business_seat, price_economy_seat, aircraft_name) VALUES
(1, 10, 100, 10, 100, '2024-07-01 18:00:00', '2024-07-01 15:00:00', 2, 1, '03:00:00', 'On Time', 5000.00, 2000.00, 'Shaheen'),
(1, 10, 100, 10, 100, '2024-07-01 20:00:00', '2024-07-01 17:00:00', 3, 1, '03:00:00', 'On Time', 5000.00, 2000.00, 'F16'),
(2, 10, 100, 10, 100, '2024-07-01 18:00:00', '2024-07-01 15:00:00', 1, 2, '03:00:00', 'On Time', 4500.00, 1800.00, 'ABC aircraft'),
(2, 10, 100, 10, 100, '2024-07-01 20:00:00', '2024-07-01 17:00:00', 1, 3, '03:00:00', 'On Time', 4500.00, 1800.00, 'Shaheen');

-- Insert data into Passenger table
INSERT INTO Passenger (user_id, flight_id, psg_Fname, psg_Lname, psg_mobile, psg_CNIC, psg_DOB) VALUES
(1, 1, 'John', 'Doe', '555-555-5555', '12345-6789012-3', '1990-01-01'),
(2, 2, 'Jane', 'Smith', '555-555-5556', '23456-7890123-4', '1985-02-02'),
(3, 3, 'Ali', 'Ahmed', '555-555-5557', '34567-8901234-5', '1992-03-03');

-- Insert data into Ticket table
INSERT INTO Ticket (flight_id, psg_id, user_id, seat_no, Payment_status) VALUES
(1, 1, 1, 1, 'Paid'),
(2, 2, 2, 2, 'Paid'),
(3, 3, 3, 3, 'Paid');

-- Insert data into Card table
INSERT INTO Card (CardNo, cardholder_name, user_id, expire_date, card_type, cvv_no) VALUES
(1234567812345678, 'Owais', 1, '2025-12-31', 'Visa', 123),
(2345678923456789, 'Maryam', 2, '2026-11-30', 'MasterCard', 456),
(3456789034567890, 'Areesha', 3, '2024-10-31', 'American Express', 789);

-- Insert data into Payment table
INSERT INTO Payment (card_id, flight_id, pay_date, pay_amount) VALUES
(1, 1, '2024-06-20', 5000.00),
(2, 2, '2024-06-20', 5000.00),
(3, 3, '2024-06-20', 4500.00);

