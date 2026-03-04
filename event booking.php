<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Change if necessary
$password = "";  // Change if necessary
$dbname = "event_booking";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are set
    if (
        isset($_POST['place'], $_POST['event'], $_POST['date'], $_POST['food'], 
        $_POST['food-type'], $_POST['decoration'], $_POST['makeup'], 
        $_POST['orchestra'], $_POST['photography'], $_POST['name'], 
        $_POST['contact'], $_POST['email'])
    ) {
        // Sanitize input to prevent SQL injection
        $place = $conn->real_escape_string($_POST['place']);
        $event = $conn->real_escape_string($_POST['event']);
        $date = $conn->real_escape_string($_POST['date']);
        $food = $conn->real_escape_string($_POST['food']);
        $food_type = $conn->real_escape_string($_POST['food-type']);
        $decoration = $conn->real_escape_string($_POST['decoration']);
        $makeup = $conn->real_escape_string($_POST['makeup']);
        $orchestra = $conn->real_escape_string($_POST['orchestra']);
        $photography = $conn->real_escape_string($_POST['photography']);
        $name = $conn->real_escape_string($_POST['name']);
        $contact = $conn->real_escape_string($_POST['contact']);
        $email = $conn->real_escape_string($_POST['email']);

        // Debugging - Check if values are being retrieved
        if (empty($place) || empty($event) || empty($date) || empty($food) || empty($name) || empty($contact) || empty($email)) {
            die("Error: One or more required fields are empty. Please check your input.");
        }

        // Check if venue is already booked
        $check_sql = "SELECT * FROM bookings WHERE place = '$place' AND event_date = '$date'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "<script>alert('This venue is already booked on the selected date. Please choose another date or venue.');</script>";
        } else {
            // Insert into the database
            $sql = "INSERT INTO bookings (place, event, event_date, food, food_type, decoration, makeup, orchestra, photography, name, contact, email) 
                    VALUES ('$place', '$event', '$date', '$food', '$food_type', '$decoration', '$makeup', '$orchestra', '$photography', '$name', '$contact', '$email')";

            // Debugging - Check if SQL is formed correctly
            if (!$sql) {
                die("SQL Query Error: Query is empty.");
            }

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    alert('Booking submitted successfully!');
                    window.location.href = 'bookingmsg.html';
                </script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        die("Error: Form fields missing. Please fill in all required fields.");
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
    <title>Event Booking Form</title>
    <style>
        /* Basic styles for form layout */
        body {
            display: flex;
            justify-content: flex-end;  /* Align form to the right */
            align-items: flex-start;  /* Align to the top */
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            width: 80%;
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: absolute; /* Position it in the right corner */
            top: 50px;  /* Adjust to control vertical distance from the top */
            right: 20px;  /* Move the form to the right */
        }

        .form-left, .form-right {
            width: 48%;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .submit-btn {
            padding: 12px 20px;
            background-color:rgb(158, 136, 12);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color:rgb(160, 69, 69);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color: #f1f1f1;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            margin-left: 20px;
        }

        .sidebar h2 {
            text-align: center;
            color: #444;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #444;
            text-decoration: none;
            margin: 15px 0;
            padding: 12px;
            background-color: #e7e7e7;
            border-radius: 6px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #ccc;
        }

        /* Form Title */
        .form-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
        }

    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Event Booking</h2>
    <a href="index.html">Home</a>
    <a href="bookingeventlocation.html">Event Place</a>
    <a href="bookingevent.html">Events</a>
    <a href="eventbookingfoodlist.html">Foodlist</a>
</div>

<!-- Form Container -->
<div class="form-container">
    <!-- Form Title -->
    <div class="form-title">
    
    </div>

    <!-- Left Side of Form -->
    <div class="form-left">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="place">Select Place</label>
            <select id="place" name="place">
                <option value="select"></option>
                <option value="KRISHNA MAHAL">KRISHNA MAHAL (kanakkampalayam,tirupur 641666.)</option>
                <option value="MLR MAHAL">MLR MAHAL (prumanallur,tirupur 641666)</option>
                <option value="SRI MANI MAHAL">SRI MANI MAHAL (kangeyam road nachipalayam.tirupur 641604.)</option>
                <option value="SRINIVASA MAHAL">SRINIVASA MAHAL (VANJIPALAY AM TIRUPUR 641604)</option>
                <option value="SRI CHANDRA THIRUMANA MAHAL">SRI CHANDRA THIRUMANA MAHAL (SIRUPOOLUVAPATTO, TIRUPUR 641603)</option>
                <option value="KAMATCHI AMMAN THIRUMANA MAHAL ">KAMATCHI AMMAN THIRUMANA MAHAL (uthukuli,tirupur 638751)</option>
                <option value="ARUNAMBIKA MAHAL">KARUNAMBIKA MAHAL (avinasi road tirupur 641666)</option>
                <option value="RAMAKRISHNA THIRUMANA MANDAPAM">RAMAKRISHNA THIRUMANA MANDAPAM (AVINASI CIVIL AERODROME.COIMBATORE 6410144.)</option>
                <option value="POTHIGAI MAHAL ">POTHIGAI MAHAL (kamgeyam road, bavani nagar,tirupur 641604)</option>
                <option value="SARAVANA MAHAL">SARAVANA MAHAL (darapuram main rd tirupur 641604.)</option>
                <option value="A GRAND MAHAL ">A GRAND MAHAL (pooluvapatti to poondi road.tirupur 641603)</option>
            </select>

            <label for="event">Select Event</label>
            <select id="event" name="event">
                <option value="selection">Select</option>
                <option value="wedding">Wedding</option>
                <option value="birthday">Birthday party</option>
                <option value="PUBERTY CEREMONY">PUBERTY CEREMONY</option>
                <option value="EAR-PIERCING CEREMONY">EAR-PIERCING CEREMONY</option>
                <option value="BABY SHOWER CEREMONY">BABY SHOWER CEREMONY</option>
                <option value="HOUSEWARMING CEREMONY">HOUSEWARMING CEREMONY</option>
            </select>

            <label for="date">Select Date</label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d', strtotime('+5 months')); ?>" min="<?php echo date('Y-m-d', strtotime('+5 months')); ?>">

            <label for="food">Select Food</label>
            <select id="food" name="food">
                <option value="veg">Veg</option>
                <option value="non-veg">Non-Veg</option>
            </select>

            <label for="food-type">Dessert & Snacks</label>
            <select id="food-type" name="food-type">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label for="decoration">Decoration</label>
            <select id="decoration" name="decoration">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label for="makeup">Makeup</label>
            <select id="makeup" name="makeup">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label for="orchestra">Orchestra</label>
            <select id="orchestra" name="orchestra">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label for="photography">Photography</label>
            <select id="photography" name="photography">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <!-- Right Side of Form -->
        <div class="form-right">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">

            <label for="contact">Contact</label>
            <input type="text" id="contact" name="contact" placeholder="Enter your contact number">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email">

            <button type="submit" class="submit-btn">Submit</button>
        </div>
    </form>
</div>

</body>
</html>
