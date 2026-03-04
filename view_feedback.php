<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "feedback_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action via AJAX
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); // Sanitize input
    $delete_sql = "DELETE FROM feedback WHERE id = $delete_id";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    exit; // End the script after handling the AJAX request
}

// Query to fetch feedback data
$sql = "SELECT id, name, email, feedback, submitted_at FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #333;
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
        .feedback-table td a {
            color: red;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #ffcccc;
        }

        .feedback-table td a:hover {
            background-color: #ff6666;
            color: white;
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
 <!-- Logo -->
 <div class="logo">
  <a href="index.html"><img src="LOGO.png" alt="Dinesh Catering Logo"></a>
</div>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this feedback?')) {
                // Create a new XMLHttpRequest object
                var xhr = new XMLHttpRequest();
                
                // Set up the request
                xhr.open('GET', '?delete=' + id, true);

                // Set a callback function for when the request is complete
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        if (xhr.responseText == "success") {
                            // On success, remove the deleted row from the table
                            var row = document.getElementById('feedback-row-' + id);
                            row.remove();
                        } else {
                            alert('Error deleting feedback');
                        }
                    } else {
                        alert('Error deleting feedback');
                    }
                };

                // Send the request
                xhr.send();
            }
        }
    </script>
</head>
<body>

<div class="sidebar">
    <a href="dashboard.html">Back</a>
</div>

<div class="container">
   
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='feedback-table'>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Feedback</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr id='feedback-row-" . $row['id'] . "'>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['feedback']) . "</td>
                    <td>" . $row['submitted_at'] . "</td>
                    <td><a href='#' onclick='confirmDelete(" . $row['id'] . ")'>Delete</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No feedback available.</p>";
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
