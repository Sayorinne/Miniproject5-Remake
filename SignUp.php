<?php
session_start();

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['Username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $Tel = $_POST['Tel'];

    // Check if email already exists
    $check_stmt = $conn->prepare('SELECT * FROM customer WHERE email = ?');
    $check_stmt->bind_param('s', $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo 'Email already exists';
        exit();
    }

    // สร้าง User_ID อัตโนมัติ
    $result = $conn->query("SELECT User_ID FROM customer ORDER BY User_ID DESC LIMIT 1");
    $row = $result->fetch_assoc();
    if ($row) {
        $lastId = intval(substr($row['User_ID'], 1)) + 1;
        $userId = 'C' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    } else {
        $userId = 'C0001';
    }

    $stmt = $conn->prepare('INSERT INTO customer (User_ID,Username, email, password, Tel) VALUES (?, ?, ?, ?,?)');
    $stmt->bind_param('sssss',$userId, $username, $email, $password, $Tel);

    if ($stmt->execute()) {
        header('Location: Login.php');
    } else {
        echo 'Error: Unable to register';
    }
}
?>
