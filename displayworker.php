<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'worker_add');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch workers from the database
$sql = "SELECT id, name, gender, age, place, contact, worker_type FROM workers";
$result = $conn->query($sql);

// Delete worker action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM workers WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Worker deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting worker!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers List - Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
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
        main {
            margin-left: 250px;
            padding: 40px;
            width: calc(100% - 250px);
            background: #f1f1f1;
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


        footer {
            text-align: center;
            padding: 10px;
            background-color: #292b2c;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .action-btns a {
            padding: 8px 12px;
            margin-right: 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .delete-btn {
            background-color: #ff4d4d;
        }
        .reply-btn {
            background-color: #4d94ff;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
        .reply-btn:hover {
            background-color:rgb(12, 148, 32);
        }
        /* Logo */
.logo {
        position: fixed;
        bottom: 60px;
        right: 10px;
        z-index: 1000;
    }

    .logo img {
        width: 100px;
        height: auto;
    }
    </style>
</head>
<body>
<div class="logo">
  <a href="index.html"><img src="LOGO.png" alt="Dinesh Catering Logo"></a>
</div>
<!-- Sidebar -->
<div class="sidebar">
    <a href="dashboard.html">Back</a>
    <a href="ADDWORKERFORM.PHP">ADD WORKER (CMS)</a>

</div>
<main>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Place</th>
                    <th>Contact</th>
                    <th>Worker Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo $row['place']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['worker_type']; ?></td>
                        <td class="action-btns">
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                            <a href="https://wa.me/<?php echo $row['contact']; ?>?text=You%20successfully%20added%20Dinesh%20Catering%20Management%20System." target="_blank" class="reply-btn">Reply</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No workers found.</p>
    <?php endif; ?>
</main>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
