<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodrequst";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM food_requests WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit;
}

// Fetch food requests
$sql = "SELECT * FROM food_requests ORDER BY request_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Requests - View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
        }

        .sidebar {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 100vh;
            background-color: #dcdcdc;
            color: #333;
            display: flex;
            flex-direction: column;
            padding: 20px;
            z-index: 1000;
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
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
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

<div class="sidebar">
    <a href="dashboard.html">Back</a>
</div>

<div class="content">

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Food Name</th>
                    <th>Selection</th>
                    <th>Description</th>
                    <th>Request Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr id="row-<?php echo $row['id']; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['foodname']); ?></td>
                        <td><?php echo ucfirst($row['selection']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo $row['request_date']; ?></td>
                        <td><button class="delete-btn" onclick="deleteRequest(<?php echo $row['id']; ?>)">Delete</button></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="empty-message">No food requests found.</p>
    <?php endif; ?>
</div>

<script>
    function deleteRequest(id) {
        if (confirm("Are you sure you want to delete this request?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        document.getElementById('row-' + id).remove();
                        alert("Request deleted successfully!");
                    } else {
                        alert("Error deleting request: " + response.message);
                    }
                }
            };
            xhr.send("delete_id=" + id);
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
