<?php
include 'db.php';

$sql = "SELECT * FROM workers";
$result = $conn->query($sql);

$workers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $workers[] = $row;
    }
}

echo json_encode($workers);
?>
