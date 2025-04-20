<?php
include "database.php";

if (!isset($_GET['date']) || !isset($_GET['type'])) {
    echo json_encode([]);
    exit();
}
date_default_timezone_set('Asia/Bangkok'); 

$date = $_GET['date'];
$type = $_GET['type'];

// Determine the table to query based on the type
$table = $type === 'custom' ? 'custom_reservations' : 'repair_reservations';

$sql = "SELECT reservation_time FROM $table WHERE reservation_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$reservedTimes = [];
while ($row = $result->fetch_assoc()) {
    $reservedTimes[] = substr($row['reservation_time'], 0, 5); // Format as HH:mm
}

echo json_encode($reservedTimes);
?>