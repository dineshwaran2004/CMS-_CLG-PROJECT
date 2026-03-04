<?php
$servername = "localhost";  // Your server name
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "eplacerequst";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from form
    $place_name = $_POST['place_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO event_places (place_name, address, contact_number, email) 
            VALUES ('$place_name', '$address', '$contact_number', '$email')";

    // Check if insertion is successful
    if ($conn->query($sql) === TRUE) {
        echo "New request submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Place Request</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>Event Place Request Form</h2>
    <form action="index.php" method="POST">
        <label for="place_name">Place Name:</label>
        <input type="text" id="place_name" name="place_name" required><br><br>

        <label for="address">Address (Tiruppur):</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Submit Request">
    </form>
</body>
</html>
