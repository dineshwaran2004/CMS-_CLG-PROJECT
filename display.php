<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Change to your MySQL username
$password = "";  // Change to your MySQL password
$dbname = "event_booking";  // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete record if 'id' is passed in the URL (AJAX call)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // SQL query to delete the record
    $sql = "DELETE FROM bookings WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    exit;
}

// SQL query to fetch all records from the 'bookings' table
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

// Start the table and style
echo "<style>
        
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
        .action-btns {
            display: flex;
            flex-direction: column; /* Stack the buttons vertically */
            align-items: flex-start; /* Align them to the left */
        }
        .action-btns a {
            text-decoration: none;
            color: white;
            padding: 3px 10px; /* Adjusted padding */
            border-radius: 3px;
            margin-bottom: 10px; /* Add space between buttons */
        }
        .action-btns a.delete {
            background-color: #dc3545;
        }
        .action-btns a.reply {
            background-color: #28a745;
            align-self: flex-end; /* Align the reply button to the right */
        }
        /* Sidebar styles */
        .sidebar {
            width: 200px;
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
      </style>";

echo "<div class='sidebar'>
        <h2>Dinesh(cms)</h2>
        <a href='dashboard.html'>back</a>
       
      </div>";

echo "<table id='booking-table' style='margin-left: 260px; overflow-y: auto;'>
        <tr>
            <th>ID</th>
            <th>Place</th>
            <th>Event</th>
            <th>Date</th>
            <th>Food</th>
            <th>Food Type</th>
            <th>Decoration</th>
            <th>Makeup</th>
            <th>Orchestra</th>
            <th>Photography</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Actions</th> <!-- Re-added Actions column -->
        </tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr id='row-" . $row["id"] . "'>
                <td>" . $row["id"] . "</td>
                <td>" . $row["place"] . "</td>
                <td>" . $row["event"] . "</td>
                <td>" . $row["event_date"] . "</td>
                <td>" . $row["food"] . "</td>
                <td>" . $row["food_type"] . "</td>
                <td>" . $row["decoration"] . "</td>
                <td>" . $row["makeup"] . "</td>
                <td>" . $row["orchestra"] . "</td>
                <td>" . $row["photography"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["contact"] . "</td>
                <td>" . $row["email"] . "</td>
                <td class='action-btns'>
                    <a href='#' class='delete' data-id='" . $row["id"] . "' onclick='deleteRow(" . $row["id"] . ")'>Delete</a>
                    <a href='mailto:" . $row["email"] . "?subject=Reply%20to%20Your%20Event%20Booking' class='reply'>Reply</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='14'>No records found.</td></tr>";
}

echo "</table>";

$conn->close();
?>
 <!-- Logo -->
 <div class="logo">
  <a href="index.html"><img src="LOGO.png" alt="Dinesh Catering Logo"></a>
</div>

<script>
// Function to handle the deletion via AJAX
function deleteRow(id) {
    if (confirm('Are you sure you want to delete this booking?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?delete_id=' + id, true); // Send delete request
        xhr.onload = function() {
            if (xhr.status == 200) {
                // If the request is successful, remove the row from the table
                document.getElementById('row-' + id).remove();
            } else {
                alert('Error deleting the booking.');
            }
        };
        xhr.send();
    }
}
</script>
