<?php
session_start();
include "database.php";

if (isset($_POST['addeditemp'])) {
    if (isset($_POST['Employee_ID'])) {
        $employee_id = $_POST['Employee_ID'];
        $username = $_POST['Username_employee'];
        $email = $_POST['email'];

        // ตรวจสอบว่ามีการกรอกรหัสผ่านใหม่หรือไม่
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            // ถ้าไม่ได้กรอกรหัสผ่านใหม่ ให้ใช้รหัสผ่านเดิมจากฐานข้อมูล
            $sql_password = "SELECT password FROM employee WHERE Employee_ID = '$employee_id'";
            $result_password = mysqli_query($conn, $sql_password);
            if ($result_password && mysqli_num_rows($result_password) > 0) {
                $row = mysqli_fetch_assoc($result_password);
                $password = $row['password'];
            } else {
                die("❌ ไม่พบรหัสผ่านเก่าในฐานข้อมูล");
            }
        }

        // ✅ อัปเดตข้อมูลพนักงาน
        $sql_update = "UPDATE employee SET 
                Username_employee = '$username',
                email = '$email',
                password = '$password'
                WHERE Employee_ID = '$employee_id'";

        if (mysqli_query($conn, $sql_update)) {
            echo "✅ บันทึกข้อมูลสำเร็จ!";
            header("Location: OwnerEmployeePage.php"); // กลับไปหน้าแสดงพนักงาน
            exit();
        } else {
            echo "❌ มีข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "❌ ไม่พบค่า Employee_ID!";
    }
}
?>