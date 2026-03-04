<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eventrequst"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];

    // Insert data into the database
    $sql = "INSERT INTO events (event_name, event_description) VALUES ('$event_name', '$event_description')";

    if ($conn->query($sql) === TRUE) {
        $message = "Event requested successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Request Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            margin: 0;
            height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #dcdcdc;
            color: #333;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            border-bottom: 1px solid #bbb;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #ffcc00;
            color: #fff;
        }

        /* Wrapper to Center Content */
        .wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 250px; /* Prevent content from being under the sidebar */
            width: calc(100% - 250px);
        }
        :root {
    --form-height: 550px; /* Change this to adjust the height */
}

.form-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    text-align: center;
    height: var(--form-height); /* Apply variable height */
    display: flex;
    flex-direction: column;
    justify-content: center;
}

        /* Form Container */
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
        }

        input, textarea {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            background-color:rgb(222, 183, 29);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
      
        <a href="index.html">Home</a>
    </div>

    <!-- Centered Form -->
    <div class="wrapper">
        <div class="form-container">
            <h2>Request an Event</h2>
            <form method="POST">
                <label for="event-name">Event Name:</label>
                <input type="text" id="event-name" name="event_name" required>

                <label for="event-description">Event Description:</label>
                <textarea id="event-description" name="event_description" required></textarea>

                <button type="submit">Submit Request</button>
            </form>

            <?php if (isset($message)): ?>
                <div class="message <?php echo (strpos($message, 'Error') === false) ? '' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
