<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Worker</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .sidebar {
      width: 220px;
      height: 100vh;
      background-color: #dcdcdc;
      padding: 20px 0;
      position: fixed;
      left: 0;
      top: 0;
      text-align: center;
    }
    .sidebar a {
      display: block;
      padding: 12px;
      text-decoration: none;
      color: #333;
      border-bottom: 1px solid #bbb;
    }
    .sidebar a:hover {
      background-color: #ffcc00;
      color: white;
    }
    form {
      background-color: white;
      padding: 35px;
      border-radius: 10px;
      box-shadow: 0px 3px 7px rgba(0, 0, 0, 0.15);
      width: 450px;
      text-align: center;
    }
    h2 {
      margin-bottom: 25px;
      color: #444;
    }
    input, select, button {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    button {
      background-color: #ffcc00;
      color: #333;
      font-size: 16px;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }
    button:hover {
      background-color: #444;
      color: #ffcc00;
      transform: scale(1.05);
    }
    
/* Logo */
.logo {
        position: fixed;
        bottom: 60px;
        right: 20px;
        z-index: 1000;
    }

    .logo img {
        width: 100px;
        height: auto;
    }
  </style>
</head>
<body>
 <!-- Logo -->
 <div class="logo">
  <a href="index.html"><img src="LOGO.png" alt="Dinesh Catering Logo"></a>
</div>

<?php
// Database Connection
$host = "localhost";
$username = "root";      // Change if you have a different username
$password = "";          // Change if you have a database password
$database = "addwrk";    // Using your database name 'mahall'

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Database Connection Failed: " . $conn->connect_error . "');</script>");
}

// Insert Worker Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_name = $_POST['worker_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $worker_type = $_POST['worker_type'];

    // Prepare SQL Query
    $sql = "INSERT INTO addingworker (worker_name, age, gender, address, contact_number, email, worker_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssss", $worker_name, $age, $gender, $address, $contact_number, $email, $worker_type);

    if ($stmt->execute()) {
        echo "<script>alert('Worker added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

  <div class="sidebar">
    
    <a href="dashboard.html">Dashboard</a>
    <a href="index.html">Home</a>
  </div>

  <form method="POST">
    <h2>Add Worker Form</h2>
    <input type="text" name="worker_name" placeholder="Worker Name" required>
    <input type="number" name="age" placeholder="Age" required>
    <select name="gender" required>
      <option value="">Select Gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select>
    <input type="text" name="address" placeholder="Address" required>
    <input type="tel" name="contact_number" placeholder="Contact Number" required>
    <input type="email" name="email" placeholder="Gmail Address" required>
    <select name="worker_type" required>
      <option value="">Worker Type</option>
      <option value="Cefe">Chefe</option>
      <option value="Serving Work">Serving Work</option>
      <option value="Cleaner">Cleaner</option>
      <option value="Watchman">Watchman</option>
    </select>
    <button type="submit">Add Worker</button>
  </form>

</body>
</html>
