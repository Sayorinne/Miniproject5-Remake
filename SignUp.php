<?php
session_start();

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];

    // Check if email already exists
    $check_stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $check_stmt->bind_param('s', $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo 'Email already exists';
        exit();
    }

    $stmt = $conn->prepare('INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $username, $email, $password, $gender);

    if ($stmt->execute()) {
        header('Location: Login.php');
    } else {
        echo 'Error: Unable to register';
    }
}
?>
