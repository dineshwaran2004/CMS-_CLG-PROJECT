<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Event Places</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
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
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 1200px;
            margin: 50px auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            margin-left: 300px; /* Push container to the right */
        }
        h2 {
            text-align: center;
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

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
            
        }
        .btn-reply {
            background-color: #25D366; /* WhatsApp green color */
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
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

    <div class="container">
      

        <?php
        // Handle Delete Request via AJAX
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
            $delete_id = intval($_POST['delete_id']);

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "nem";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                echo json_encode(['success' => false, 'message' => 'Database connection failed']);
                exit;
            }

            $sql = "DELETE FROM event_places WHERE id = $delete_id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete event']);
            }
            $conn->close();
            exit; // Exit after handling AJAX
        }

        // Display Event Places
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "nem";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("<div style='color: red; text-align: center;'>Connection failed: " . $conn->connect_error . "</div>");
        }

        $sql = "SELECT * FROM event_places";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Place Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Capacity</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Event Types</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                $contactNumber = preg_replace('/\D/', '', $row["contact_number"]); 
                $countryCode = '91';
                $fullNumber = $countryCode . $contactNumber;
                $message = urlencode("Hello " . $row["contact_person"] . ", regarding your event place registration at " . $row["place_name"] . ".");

                echo "<tr id='row_" . $row["id"] . "'>
                        <td>" . $row["id"] . "</td>
                        <td>" . htmlspecialchars($row["place_name"]) . "</td>
                        <td>" . htmlspecialchars($row["city"]) . "</td>
                        <td>" . htmlspecialchars($row["state"]) . "</td>
                        <td>" . $row["capacity"] . "</td>
                        <td>" . htmlspecialchars($row["contact_person"]) . "</td>
                        <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                        <td>" . htmlspecialchars($row["event_types"]) . "</td>
                        <td>" . $row["registration_date"] . "</td>
                        <td>
                            <a class='btn btn-reply' target='_blank' href='https://wa.me/$fullNumber?text=$message'>Reply</a>
                            <button class='btn btn-delete' onclick='deleteEvent(" . $row["id"] . ")'>Delete</button>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align: center;'>No event places registered yet.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- AJAX Script for Live Deletion -->
    <script>
        function deleteEvent(id) {
            if (confirm('Are you sure you want to delete this event place?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);  // Same file handles deletion
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            document.getElementById('row_' + id).remove();
                        } else {
                            alert('Failed to delete the event place.');
                        }
                    }
                };
                xhr.send('delete_id=' + id);
            }
        }
    </script>
</body>
</html>
