<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'newmahal rigistration
');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the database
$sql = "SELECT * FROM mahal_registration";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Mahals & Mandapams</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Registered Mahals & Mandapams</h1>

    <?php
    // Check if there are any records
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Address</th><th>Contact</th><th>Email</th><th>Registration Date</th></tr>";
        
        // Display records in a table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['contact'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['reg_date'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No registrations found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

</div>

</body>
</html>
