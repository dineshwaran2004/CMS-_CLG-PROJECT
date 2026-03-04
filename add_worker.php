<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'worker_add');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $place = $_POST['place'];
    $contact = $_POST['contact'];
    $worker_type = $_POST['worker_type'];  // Added worker type

    // Server-side validation: Check if age is 18 or older
    if ($age < 18) {
        echo "<script>alert('Age must be 18 or older');</script>";
    } else {
        // Insert worker into the database
        $sql = "INSERT INTO workers (name, gender, age, place, contact, worker_type) VALUES ('$name', '$gender', '$age', '$place', '$contact', '$worker_type')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Worker added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Worker - Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f9f9f9;
            color: #333;
        }
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
        main {
            margin-left: 250px;
            padding: 40px;
            width: calc(100% - 250px);
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f1f1f1;
        }
        .form-container {
            max-width: 600px;
            width: 100%;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            color: #3f3d56;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin: 10px 0 5px;
            display: block;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #ffcc00;
        }
        button {
            background-color: #ffcc00;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }
        button:hover {
            background-color: #e6b800;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #292b2c;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .logo {
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 1000;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
<!-- Logo on the right corner below -->
<div class="logo">
  <a href="index.html" ><img src=" alt="DinesH Catering Logo"></a> 
</div>
<!-- Sidebar -->
<div class="sidebar">
    <a href="index.html">Home</a>

</div>
<main>
    <div class="form-container">
        <h1>WORKER REGISTRATION</h1>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="18" required>

            <label for="place">Place:</label>
            <select id="place" name="place" required>
                <option value="">SELECT</option>
                <option value="OLD BUS TAND">OLD BUS TAND</option>
                <option value="NEW BUS TAND">NEW BUS TAND</option>
                <option value="AVINASI">AVINASI</option>
                <option value="PERUMANALLUR">PERUMANALLUR</option>
                <option value="UTHUKULI">UTHUKULI</option>
                <option value="SENGAPALLI">SENGAPALLI</option>
                <option value="KANGEYAM">KANGEYAM</option>
                <option value="PALLADAM">PALLADAM</option>
                <option value="VANJIPALAYAM">VANJIPALAYAM</option>
                <option value="PUSHPHA">PUSHPHA</option>
            </select>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>

            <!-- Added Worker Type selection -->
            <label for="worker_type">Worker Type:</label>
            <select id="worker_type" name="worker_type" required>
                <option value="serving">serving</option>
                <option value="cefe">cefe</option>
                <option value="cleaner">cleaner</option>
                <option value="Watchman">Watchman</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</main>
</body>
</html>
