<?php
session_start();
include "database.php";
$sql = "SELECT * FROM employee";
$result = mysqli_query($conn, $sql);
// ตรวจสอบว่ามีพารามิเตอร์ Employee_ID หรือไม่
if (isset($_GET['Employee_ID'])) {
    $employee_id = $_GET['Employee_ID'];

    // ป้องกัน SQL Injection
    $employee_id = mysqli_real_escape_string($conn, $employee_id);

    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM employee WHERE Employee_ID = '$employee_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
    } else {
        die("❌ ไม่พบข้อมูลพนักงาน!");
    }
} else {
    die("❌ ไม่มีรหัสพนักงานที่ระบุ!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Employee Management</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/ownerStyle.css">
    <link rel="stylesheet" href="CSS/ownerNavbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="layout expanded home-page">
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                        <?php if(isset($_SESSION['Admin_ID'])): ?>
                            <div class="profile-button">
                                <p class="fa fa-user" style="margin: 10px" onclick="toggloeMenu()"> <?php echo $_SESSION['username_admin']; ?> </p>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="login-button btn btn-primary"><span>Login</span></a>
                            <a href="registration.php" class="login-button btn btn-primary"><span>Register</span></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="admin-wrapper">
                <div class="left-menu">
                    <hr>
                    <div class="left-menu-content">
                        <div class="ms-auto nav">
                            <a href="OwnerPage.php"><span class="nav-link">แดชบอร์ด</span></a>
                            <a href="OwnerEmployeePage.php"><span class="nav-link">จัดการ "พนักงาน"</span></a>
                        </div>
                    <hr>
                    </div>
                </div>
                <div class="admin-content">
                    <div class="button-group">
                        <a href="AddEmployee.php" class="btn btn-big">เพิ่มพนักงาน</a>
                    </div>
                    <div class="content">
                        <h2 class="page-title">แก้ไขข้อมูลพนักงาน</h2>
                      
                        <form action="editEmp.php" method ="post" enctype="multipart/form-data">
                            <div>
                                <label>Username:</label>
                                <input type="text" name="Username_employee" id="" class="text-input" value="<?php echo $employee['Username_employee']  ?> ">
                            </div>
                            <div>
                                <label>Password</label>
                                <input type="password" name="password" class="text-input" placeholder="ใส่รหัสผ่านใหม่ (ถ้าเปลี่ยน)">
                                </div>
                                <div>
                                <label>Email:</label>
                                <input type="text" name="email" id="" class="text-input" value="<?php echo $employee['email']  ?> ">
                            </div>
                                <input type ="hidden" name="Employee_ID" value="<?php echo $employee['Employee_ID']  ?> "> 
                                <button type="submit" class="btn btn-big" name="addeditemp">แก้ไขข้อมูลพนักงาน</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>