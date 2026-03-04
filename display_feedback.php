<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Update with your DB password
$dbname = "feedbackdisplay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch feedback
$sql = "SELECT id, name, email, message, submitted_at FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Display</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light grey background */
            color: #333; /* Dark grey text */
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #444; /* Dark grey */
            color: white;
        }

        header a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            background-color: #555; /* Slightly lighter grey */
            padding: 5px 10px;
            border-radius: 5px;
        }

        header a:hover {
            background-color: #666; /* Hover effect */
        }

        /* Table Styles */
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(33, 27, 108, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Light grey for header */
            text-align: center;
        }

        td {
            background-color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternate row color */
        }

        tr:hover {
            background-color: #f1f1f1; /* Hover effect on rows */
        }

        /* Centered Heading */
        h1 {
            text-align: center;
            margin: 20px 0;
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

    <!-- Header with Back Button -->
    <header>
        <a href="dashboard.html">Back</a>
        <span>Feedback Table</span>
    </header>

    <h1>Customer Feedback</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['message']}</td>
                        <td>{$row['submitted_at']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No feedback available</td></tr>";
            }
            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
