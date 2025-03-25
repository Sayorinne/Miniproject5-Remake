<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $detail = $_POST['detail'];
    $phone = $_POST['phone'];

    $reservation_date = "$year-$month-$day";

    $sql = "INSERT INTO custom_reservations (customer_id, reservation_date, reservation_time, name, surname, detail, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssss', $customer_id, $reservation_date, $time, $name, $surname, $detail, $phone);

    if ($stmt->execute()) {
        echo "Custom reservation saved successfully!";
        header('Location: successPage.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>