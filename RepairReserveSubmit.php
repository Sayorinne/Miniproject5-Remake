<?php
include 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; 
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $detail = $_POST['detail'];
    $phone = $_POST['phone'];


    $reservation_date = "$year-$month-$day";


    $sql = "INSERT INTO repair_reservations (User_ID, reservation_date, reservation_time, name, surname, detail, phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssss', $user_id, $reservation_date, $time, $name, $surname, $detail, $phone); // Changed from customer_id to user_id

    if ($stmt->execute()) {
        echo "Repair reservation saved successfully!";
        header('Location: successPage.php'); // Redirect to a success page
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>