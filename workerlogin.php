<?php
// Start the session
session_start();

// Database connection setup
$servername = "localhost";
$username = "root";  // MySQL username
$password = "";      // MySQL password
$dbname = "mahall";  // The correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query to check the credentials in the database
    $sql = "SELECT * FROM admin WHERE username = ? AND password = MD5(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful, set session and redirect to the dashboard
        $_SESSION['admin'] = $user;
        echo "<script>alert('Login Successful!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        // Login failed
        echo "<script>alert('Invalid Username or Password');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg,rgb(255, 255, 255),rgb(255, 255, 255));
        }

        .container {
            display: flex;
            width: 800px;
            height: 500px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .signin, .signup {
            flex: 1;
            padding: 50px;
        }

        .signin {
            background: linear-gradient(135deg,rgb(50, 48, 48),rgb(255, 219, 77));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .signin h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .signin p {
            font-size: 14px;
            margin-bottom: 30px;
            text-align: center;
        }

        .signup h2 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .signup p {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }

        .signup input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .signup button {
            width: 100%;
            padding: 12px;
            background:rgb(222, 195, 41);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .signup button:hover {
            background:rgb(214, 198, 77);
        }

        /* Back button style */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: yellow;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        /* Hover effect for back button */
        .back-button:hover {
            background-color: #ffcc00; /* Darker yellow on hover */
            transform: scale(1.1); /* Slightly enlarge the button */
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
 
</div>

    <a href="index.html">
        <button class="back-button">Back</button>
    </a>
    <div class="container">
        <div class="signin">
            <h1>A Smart Event Management</h1>
        </div>

        <div class="signup">
            <h2>Mahal&Mandapam Login</h2>
            <br><br><br>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">LOG IN</button>
            </form>
        </div>
    </div>
</body>
</html>
