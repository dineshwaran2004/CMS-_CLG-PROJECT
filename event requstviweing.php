<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eventrequst";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM events WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit;
}

// Fetch all events from the database
$sql = "SELECT id, event_name, event_description, created_at FROM events ORDER BY created_at DESC";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <style>
     body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        height: 100vh;
        flex-direction: column;
    }

    .wrapper {
        display: flex;
        justify-content: flex-start;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    .sidebar {
        width: 250px;
        background-color: #dcdcdc;
        color: #333;
        padding: 20px;
        height: 100vh;
        box-sizing: border-box;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10;
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

    .container {
        flex: 1;
        margin: 20px;
        margin-left: 1200px; /* Add space to the left for the fixed sidebar */
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
    }

    table {
      width: 80%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 3px 7px rgba(0, 0, 0, 0.15);
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ccc;
    }
    th {
      background-color: #ffcc00;
      color: #333;
      font-size: 16px;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .no-data {
      text-align: center;
      font-size: 18px;
      color: #777;
      padding: 20px;
    }

    .delete-btn {
        background-color: #ff4d4d;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .delete-btn:hover {
        background-color: #cc0000;
    }

    .empty-message {
        font-size: 18px;
        color: #888;
        text-align: center;
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

<div class="wrapper">
    <div class="sidebar">
    
        <a href="http://localhost/final/dashboard.html">Back</a>
    </div>


        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Description</th>
                        <th>Submitted On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr id="row-<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_description']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <button class="delete-btn" onclick="deleteEvent(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">No events found.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function deleteEvent(id) {
        if (confirm("Are you sure you want to delete this event?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        document.getElementById('row-' + id).remove();
                        alert("Event deleted successfully!");
                    } else {
                        alert("Error deleting event: " + response.message);
                    }
                }
            };
            xhr.send("delete_id=" + id);
        }
    }
</script>

</body>
</html>
