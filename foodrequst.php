<?php
$servername = "localhost"; // Your database host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "foodrequst"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $foodname = $_POST['foodname'];
    $selection = $_POST['selection'];
    $description = $_POST['description'];

    // Insert data into database
    $sql = "INSERT INTO food_requests (foodname, selection, description) VALUES ('$foodname', '$selection', '$description')";

    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>New food request submitted successfully!</p>";
    } else {
        $message = "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Request Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
        }
        
        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #dcdcdc; /* Light grey */
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

        /* Wrapper for Sidebar and Main Content */
        .wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 250px; /* Push content next to sidebar */
        }

        /* Form Container */
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 700%;
            max-width: 700px;
            text-align: center;
        }
        
        h2 {
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-top: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color:rgb(213, 204, 40);
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
            margin-top: 15px;
            width: 100%;
            border-radius: 5px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
       
        <a href="index.html">Home</a>
    </div>

    <!-- Wrapper to Center the Form -->
    <div class="wrapper">
        <div class="container">
            <h2>Food Request Form</h2>
            <?php echo $message; ?>
            <form method="POST" action="">
                <label for="foodname">Food Name:</label>
                <input type="text" id="foodname" name="foodname" required>

                <label for="selection">Selection:</label>
                <select id="selection" name="selection" required>
                    <option value="veg">Veg</option>
                    <option value="nonveg">Non-Veg</option>
                </select>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

</body>
</html>
