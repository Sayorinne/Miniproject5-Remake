<?php
session_start();
require 'database.php';

// เช็คว่าเป็นเจ้าของร้านหรือไม่
if (!isset($_SESSION['Owner_ID'])) {
    die("Access Denied: Only the owner can add employees.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['Username_employee'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน

    // ตรวจสอบว่ามีอีเมลซ้ำหรือไม่
    $check_stmt = $conn->prepare('SELECT * FROM employee WHERE email = ?');
    $check_stmt->bind_param('s', $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo 'Email already exists';
        exit();
    }

    // สร้าง Employee_ID อัตโนมัติ (E001, E002, ...)
    $result = $conn->query("SELECT Employee_ID FROM employee ORDER BY Employee_ID DESC LIMIT 1");
    $row = $result->fetch_assoc();

    if ($row) {
        $lastId = intval(substr($row['Employee_ID'], 1)) + 1; // ดึงเลขตัวสุดท้าย +1
        $employeeId = 'E' . str_pad($lastId, 3, '0', STR_PAD_LEFT); // แปลงให้เป็น E001, E002
    } else {
        $employeeId = 'E001'; // ถ้าไม่มีข้อมูล ให้เริ่มที่ E001
    }

    // บันทึกข้อมูลลงตาราง employee
    $stmt = $conn->prepare('INSERT INTO employee (Employee_ID, Username_employee, email, password) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $employeeId, $username, $email, $password);

    if ($stmt->execute()) {
        echo "Employee added successfully!";
        header('Location: OwnerEmployeePage.php'); // กลับไปหน้าจัดการพนักงาน
        exit();
    } else {
        echo 'Error: Unable to register employee';
    }
}
?>
