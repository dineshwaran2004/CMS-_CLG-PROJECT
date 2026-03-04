<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root"; // Default MySQL username
        $password = ""; // Default MySQL password
        $dbname = "cms";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Prepare SQL query to find user
        $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
        $result = $conn->query($sql);

        // If user exists, redirect to dashboard
        if ($result->num_rows > 0) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.html");
            exit;  // Prevent further script execution
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <style>
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
        width: 200px;
        height: auto;
    }
    </style>
</head>
<body>
     <!-- Logo -->
 <div class="logo">
  <a href="index.html"><img src=" alt="Dinesh Catering Logo"></a>
</div>

<a href="index.html">
        <button class="back-button">Back</button>
    </a>
    <div class="container">
        <div class="signin">
            <h1>A Smart Event Management </h1><br><br>

        </div>

        <div class="signup">
           
            </form>
<br><br><br><br>
            <h2>Admin Login</h2>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">LOG IN</button>
            </form>
        </div>
    </div>
</body>
</html>
