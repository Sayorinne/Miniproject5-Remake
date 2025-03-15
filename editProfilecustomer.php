<?php
session_start();
include "database.php";

if (isset($_POST['addeditemp'])) {
    if (isset($_POST['User_ID'])) {
        $User_id = $_POST['User_ID'];
        $username = $_POST['Username'];
        $email = $_POST['email'];

        // ดึงข้อมูลลูกค้าจากฐานข้อมูล
        $sql = "SELECT * FROM customer WHERE User_ID = '$User_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $password = $row['password']; // ใช้รหัสผ่านเดิมโดยค่าเริ่มต้น
            $target_filename = $row['customer_image']; // ใช้รูปภาพเดิม
        } else {
            die("❌ ไม่พบข้อมูล!");
        }

        // ตรวจสอบรหัสผ่านใหม่
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        // ตรวจสอบว่ามีการอัปโหลดภาพใหม่หรือไม่
        if (!empty($_FILES["image"]["name"])) {
            $target_filename = basename($_FILES["image"]["name"]);
            $target_filepath = "Picture/" . $target_filename;
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_filepath)) {
                $target_filename = $row['customer_image']; // ถ้าอัปโหลดล้มเหลว ใช้ภาพเดิม
            }
        }

        // อัปเดตข้อมูลพนักงาน
        $sql_update = "UPDATE customer SET 
                Username = '$username',
                email = '$email',
                password = '$password',
                customer_image = '$target_filename'
                WHERE User_ID = '$User_id'";

        if (mysqli_query($conn, $sql_update)) {
            echo "✅ บันทึกข้อมูลสำเร็จ!";
            header("Location: CustomerProfile.php");
            exit();
        } else {
            echo "❌ มีข้อผิดพลาด: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        echo "❌ ไม่พบค่า User_ID!";
    }
}
?>