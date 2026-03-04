<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Place Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #dcdcdc;
            color: #333;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            border-bottom: 1px solid #bbb;
        }

        .sidebar a:hover {
            background-color: #ffcc00;
            color: #fff;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 160px;
            width: calc(100% - 260px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        /* Form Container Styling */
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 150%;
            max-width: 1000px; /* Make the form wider */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-group {
            width: 48%; /* Align inputs side by side */
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color:rgb(228, 196, 34);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button:hover {
            background-color:rgb(209, 184, 46);
        }

        .message, .error {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        .message {
            color: green;
        }

        .error {
            color: red;
        }

        @media (max-width: 768px) {
            .form-group {
                width: 100%; /* Stack fields on smaller screens */
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
       
        <a href="index.html">Home</a>
        
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container">
            <h2>New Event Place Registration</h2>

            <!-- PHP Logic for Database Creation and Form Submission -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "nem";

                $conn = new mysqli($servername, $username, $password);

                if ($conn->connect_error) {
                    die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
                }

                $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
                if ($conn->query($sql_create_db) !== TRUE) {
                    die("<div class='error'>Error creating database: " . $conn->error . "</div>");
                }

                $conn->select_db($dbname);

                $sql_create_table = "
                CREATE TABLE IF NOT EXISTS event_places (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    place_name VARCHAR(255) NOT NULL,
                    address TEXT NOT NULL,
                    city VARCHAR(100) NOT NULL,
                    state VARCHAR(100) NOT NULL,
                    zip VARCHAR(10) NOT NULL,
                    capacity INT NOT NULL,
                    contact_person VARCHAR(255) NOT NULL,
                    contact_number VARCHAR(15) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    event_types VARCHAR(255) NOT NULL,
                    description TEXT,
                    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

                if ($conn->query($sql_create_table) !== TRUE) {
                    die("<div class='error'>Error creating table: " . $conn->error . "</div>");
                }

                $place_name = $_POST['place_name'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];
                $capacity = $_POST['capacity'];
                $contact_person = $_POST['contact_person'];
                $contact_number = $_POST['contact_number'];
                $email = $_POST['email'];
                $event_types = implode(", ", $_POST['event_types']);
                $description = $_POST['description'];

                $sql_insert = "INSERT INTO event_places 
                    (place_name, address, city, state, zip, capacity, contact_person, contact_number, email, event_types, description)
                    VALUES 
                    ('$place_name', '$address', '$city', '$state', '$zip', $capacity, '$contact_person', '$contact_number', '$email', '$event_types', '$description')";

                if ($conn->query($sql_insert) === TRUE) {
                    echo "<div class='message'>New event place registered successfully!</div>";
                } else {
                    echo "<div class='error'>Error: " . $sql_insert . "<br>" . $conn->error . "</div>";
                }

                $conn->close();
            }
            ?>

            <!-- Event Place Registration Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="place_name">Event Place Name:</label>
                    <input type="text" id="place_name" name="place_name" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" required>
                </div>

                <div class="form-group">
                    <label for="state">State:</label>
                    <input type="text" id="state" name="state" required>
                </div>

                <div class="form-group">
                    <label for="zip">ZIP Code:</label>
                    <input type="text" id="zip" name="zip" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity:</label>
                    <input type="number" id="capacity" name="capacity" min="1" required>
                </div>

                <div class="form-group">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" id="contact_person" name="contact_person" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="tel" id="contact_number" name="contact_number" pattern="[0-9]{10}" placeholder="1234567890" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="event_types">Types of Events Supported:</label>
                    <select id="event_types" name="event_types[]" multiple required>
                        <option value="wedding">Wedding</option>
                        <option value="conference">Conference</option>
                        <option value="party">Party</option>
                        <option value="concert">Concert</option>
                        <option value="All">All</option>
                    </select>
                </div>

                <div class="form-group" style="width: 100%;">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>

                <button type="submit">Register Event Place</button>
            </form>
        </div>
    </div>

</body>
</html>
