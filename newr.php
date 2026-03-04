<?php
// Initialize a message variable
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'newmahal rigistration');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO mahal_registration (name, address, contact, email) VALUES ('$name', '$address', '$contact', '$email')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
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
    <title>New Mahal & Mandapam Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 150px;
            height: 100vh;
            background-color: #dcdcdc; /* Light grey sidebar */
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
            border-bottom: 1px solid #bbb; /* Light grey border */
        }
        .sidebar a:hover {
            background-color: #ffcc00; /* Yellow on hover */
            color: #fff;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
        form {
            max-width: 400px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color:rgb(200, 177, 28);
            color: white;
            border: none;
        }
        button:hover {
            background-color:rgb(228, 203, 38);
        }
        .message {
            text-align: center;
            color: green;
            font-size: 16px;
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
    <!-- Sidebar -->
    <div class="sidebar">
      
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="m&mabout.html">About</a></li>
            
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 style="text-align: center;">New Mahal & Mandapam Registration</h1>

        <!-- Display Success or Error Message -->
        <?php if (!empty($message)) : ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="" method="POST">
            <label for="name">Mahal & Mandapam Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
