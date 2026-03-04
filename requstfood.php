<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request New Food Item</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar styling */
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

    /* Main content area */
    .main-content {
      margin-left: 250px;
      padding: 20px;
      flex: 1;
    }

    /* Form container styling */
    .form-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    label {
      font-size: 1.1em;
      color: #333;
      margin-top: 15px;
      display: block;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 1em;
    }

    textarea {
      resize: vertical;
      height: 150px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .button-container {
      display: flex;
      justify-content: center;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      font-size: 1.1em;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #45a049;
    }

    .back-button {
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
      color: #4CAF50;
      font-size: 1.1em;
      text-align: center;
      padding: 8px 15px;
      border: 1px solid #4CAF50;
      border-radius: 5px;
    }

    .back-button:hover {
      background-color: #4CAF50;
      color: white;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Menu</h2>
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
  </div>

  <!-- Main content area -->
  <div class="main-content">
    <div class="form-container">
      <h1>Request a New Food Item</h1>
      <form id="food-request-form">
        <div class="form-group">
          <label for="food-name">Food Name</label>
          <input type="text" id="food-name" name="food-name" required placeholder="Enter the food name">

          <label for="food-description">Food Description</label>
          <textarea id="food-description" name="food-description" required placeholder="Enter a brief description of the food item"></textarea>

          <label for="food-image">Food Image</label>
          <input type="file" id="food-image" name="food-image" accept="image/*" required>

          <div class="button-container">
            <button type="submit">Submit Request</button>
          </div>
        </div>
      </form>

      <a href="index.html" class="back-button">Back to Menu</a>
    </div>
  </div>

  <script>
    document.getElementById('food-request-form').addEventListener('submit', function (e) {
      e.preventDefault();
      alert('Your request has been submitted successfully!');
      document.getElementById('food-request-form').reset();
    });
  </script>

</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_name = $_POST['food-name'];
    $food_description = $_POST['food-description'];
    $food_image = file_get_contents($_FILES['food-image']['tmp_name']);

    // Database connection
    $conn = new mysqli('localhost', 'username', 'password', 'USE requestfood;
');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO food_requests (food_name, food_description, food_image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $food_name, $food_description, $food_image);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "Request submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
