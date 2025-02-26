<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['first'];
    $password = $_POST['password'];

    // Check user login
    $user = getUserByUsername($conn, $username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: Homepage.php');
        exit();
    }

    // Check admin login
    $admin = getAdminByUsername($conn, $username);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['Admin_ID'] = $admin['Admin_ID'];
        $_SESSION['username_admin'] = $admin['username_admin'];
        header('Location: AdminPage.php');
        exit();


    }
    echo 'Invalid username or password';
}

function getUserByUsername($conn, $username) {
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAdminByUsername($conn, $username) {
    $stmt = $conn->prepare('SELECT * FROM `admin` WHERE username_admin = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
