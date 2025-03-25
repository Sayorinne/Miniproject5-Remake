<?php
include 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // Ensure this is set
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $detail = $_POST['detail'];
    $phone = $_POST['phone'];

    // Validate User_ID
    if (empty($user_id)) {
        echo "Error: User_ID is missing.";
        exit;
    }

    // Validate that User_ID exists in the customer table
    $checkUserQuery = "SELECT User_ID FROM customer WHERE User_ID = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param('s', $user_id); // Use 's' for string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Error: User_ID does not exist in the customer table.";
        exit;
    }

    $reservation_date = "$year-$month-$day";

    $sql = "INSERT INTO repair_reservations (User_ID, reservation_date, reservation_time, name, surname, detail, phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $user_id, $reservation_date, $time, $name, $surname, $detail, $phone); // Use 's' for all strings

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