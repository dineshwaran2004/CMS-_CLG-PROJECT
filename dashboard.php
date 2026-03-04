<?php
// Start session
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$loggedUser = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Worker Details - Table View</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
    }
    body {
      display: flex;
      background-color: #f8f9fa;
      color: #333;
      font-size: 16px;
    }
    .sidebar {
      width: 220px;
      height: 100vh;
      background-color: #2c2c2c;
      padding-top: 20px;
      position: fixed;
      text-align: center;
    }
    .sidebar a {
      font-size: 16px;
      display: block;
      padding: 12px;
      color: #ffcc00;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background-color: #ffcc00;
      color: #2c2c2c;
    }
    .main-content {
      margin-left: 240px;
      padding: 20px;
      text-align: center;
    }
    h2 {
      color: #555;
      font-size: 22px;
      margin-bottom: 15px;
    }
    .welcome {
      font-size: 18px;
      font-weight: bold;
      background-color: #ffcc00;
      padding: 10px;
      border-radius: 8px;
      display: inline-block;
      color: #2c2c2c;
      margin-bottom: 15px;
    }
    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
    }
    .card {
      background-color: #fff;
      width: 330px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      border-left: 4px solid #ffcc00;
      transition: all 0.3s ease;
      text-align: left;
      padding: 12px;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card-header {
      background-color: #ffcc00;
      color: #2c2c2c;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
    }
    .card-body {
      padding: 10px;
      color: #444;
      font-size: 16px;
      font-weight: bold;
    }
    .card-table {
      width: 100%;
      border-collapse: collapse;
    }
    .card-table td {
      padding: 6px;
      font-size: 16px;
      border-bottom: 1px solid #ddd;
    }
    .card-table td:first-child {
      font-weight: bold;
      width: 40%;
    }
    .card-actions {
      display: flex;
      justify-content: center;
      padding: 10px;
      background-color: #f8f9fa;
      border-top: 2px solid #ddd;
    }
    .whatsapp-btn {
      padding: 10px 15px;
      font-size: 14px;
      text-decoration: none;
      color: white;
      background-color: #25D366;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    .whatsapp-btn:hover {
      background-color: #1EBE55;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <a href="index.html">Home</a>
</div>

<div class="main-content">
  <h2>Worker Details</h2>
  <div class="welcome">Logged in as: <?php echo htmlspecialchars($loggedUser); ?></div>

  <div class="card-container">
    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "addwrk");
    if ($conn->connect_error) {
        die("<p style='color:red;'>Database Connection Failed: " . $conn->connect_error . "</p>");
    }

    $sql = "SELECT id, worker_name, age, gender, address, contact_number, email, worker_type FROM addingworker";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $workerName = $row['worker_name'];
            $workerType = $row['worker_type'];
            $phone = preg_replace('/[^0-9]/', '', $row['contact_number']); // Remove non-numeric characters
            if (strlen($phone) == 10) { // Ensure it's a 10-digit number
                $phone = "91" . $phone; // Add country code for India
            }

            // WhatsApp Message Template
            $message = "Hello, this is $loggedUser. I would like to know if the following worker is available to work:\n\n";
            $message .= "Name: $workerName\n";
            $message .= "Worker Type: $workerType\n";
            $message .= "Event Date: [Enter Date]\n\n";
            $message .= "Kindly let me know if you are available now. Reply YES or NO.";

            // Encode message for URL
            $whatsappMessage = urlencode($message);

            // WhatsApp API URL
            $whatsappURL = "https://api.whatsapp.com/send?phone=$phone&text=$whatsappMessage";

            echo "
            <div class='card'>
                <div class='card-header'>$workerName</div>
                <div class='card-body'>
                    <table class='card-table'>
                        <tr><td>ID:</td><td>{$row['id']}</td></tr>
                        <tr><td>Age:</td><td>{$row['age']}</td></tr>
                        <tr><td>Gender:</td><td>{$row['gender']}</td></tr>
                        <tr><td>Address:</td><td>{$row['address']}</td></tr>
                        <tr><td>Contact:</td><td>{$row['contact_number']}</td></tr>
                        <tr><td>Email:</td><td>{$row['email']}</td></tr>
                        <tr><td>Type:</td><td>{$row['worker_type']}</td></tr>
                    </table>
                </div>
                <div class='card-actions'>
                    <a href='$whatsappURL' class='whatsapp-btn' target='_blank'>Send WhatsApp</a>
                </div>
            </div>";
        }
    } else {
        echo "<p style='color:#777;'>No workers found.</p>";
    }
    $conn->close();
    ?>
  </div>
</div>

</body>
</html>
