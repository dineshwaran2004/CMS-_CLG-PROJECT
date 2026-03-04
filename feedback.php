<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex; /* Enable flexbox for centering */
            flex-direction: column; /* Arrange content vertically */
            align-items: center; /* Horizontally center */
            justify-content: flex-start; /* Align to top center */
        }

        .feedback-container {
            width: 100%;
            max-width: 600px;
            margin-top: 50px; /* Add space from the top */
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .feedback-container h2 {
            text-align: center;
            color: #333;
        }

        .feedback-form {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Adds space between form elements */
        }

        .feedback-form label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .feedback-form input,
        .feedback-form textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        .feedback-form textarea {
            resize: vertical;
            height: 150px;
        }

        .submit-btn {
            background-color: #ffa500;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #ffa500;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            color: #888;
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
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Menu</h2>
    <a href="index.html">Home</a>
    
</div>

<div class="feedback-container">
    <h2>Feedback Form</h2>

    <form action="" method="POST" class="feedback-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>

        <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>
</div>

<div class="footer">
    <p>Thank you for your feedback!</p>
</div>

</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "feedback_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Insert data into database
    $sql = "INSERT INTO feedback (name, email, feedback) VALUES ('$name', '$email', '$feedback')";

    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
