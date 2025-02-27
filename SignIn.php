<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['first'];
    $password = $_POST['password'];

    // ตรวจสอบว่าเป็นลูกค้าหรือไม่
    $user = getCustomerByUsername($conn, $username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['User_ID'];
        $_SESSION['username'] = $user['Username'];
        header('Location: Homepage.php');
        exit();
    }

    // ตรวจสอบว่าเป็นพนักงานหรือไม่
    $employee = getEmployeeByUsername_employee($conn, $username);

    if ($employee && password_verify($password, $employee['password'])) {
        $_SESSION['Employee_ID'] = $employee['Employee_ID']; 
        $_SESSION['Username_employee'] = $employee['Username_employee'];
        header('Location: AdminPage.php');
        exit();
    }

    $owner = getOwnerByUsername_Owner($conn, $username);

    if ($owner && password_verify($password, $owner['password'])) {
        $_SESSION['Owner_ID'] = $owner['Owner_ID']; 
        $_SESSION['Username_Owner'] = $owner['Username_Owner'];
        header('Location: OwnerPage.php');
        exit();
    }


    echo 'Invalid username or password';
}

// ใช้สำหรับดึงข้อมูลของลูกค้า (customer)
function getCustomerByUsername($conn, $username) {
    $stmt = $conn->prepare('SELECT * FROM `customer` WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// ใช้สำหรับดึงข้อมูลของพนักงาน (employee) 
function getEmployeeByUsername_employee($conn, $username) {
    // ตรวจสอบใน employee ก่อน
    $stmt = $conn->prepare('SELECT * FROM `employee` WHERE Username_employee = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getOwnerByUsername_Owner($conn, $username) {
    $stmt = $conn->prepare('SELECT * FROM `owner` WHERE Username_Owner = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
