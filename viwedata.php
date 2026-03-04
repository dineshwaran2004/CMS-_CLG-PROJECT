<?php
// Connection to database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "foodadd";  // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all bookings from the database
$sql = "SELECT * FROM catering_requests";
$result = $conn->query($sql);

// Check if a success message is set in the URL
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Catering Bookings</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .container {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            width: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .confirmation-message {
            color: green;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        .logo {
        position: fixed;
        bottom: 10px;  /* Moves the logo down */
        right: 10px;   /* Moves the logo to the right side */
        z-index: 1000;
    }

    .logo img {
        width: 100px;
        height: auto;
    }
    </style>
</head>
<body>
<div class="logo">
  <a href="index.html" ><img src="LOGO.png" alt="DinesH Catering Logo"></a> 
  </div>

    <!-- Back button -->
    <button class="back-btn" onclick="window.history.back();">Back</button>

    <header>
        <h2>All Catering Bookings</h2>
    </header>

    <div class="container">
        <!-- Display confirmation message if set -->
        <?php
        if ($msg === 'success') {
            echo "<p class='confirmation-message'>Booking submitted successfully! <a href='view_details.php'>View All Bookings</a></p>";
        }
        ?>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Food Type</th>
                        <th>Time Slot</th>
                        <th>Function Type</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["food_type"] . "</td>
                        <td>" . $row["time_slot"] . "</td>
                        <td>" . $row["function_type"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["created_at"] . "</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No bookings found.</p>";
        }

        // Close the connection
        $conn->close();
        ?>

        <br><br>
        <a href="submit.php">Back to Booking Form</a>
    </div>
</body>
</html>
