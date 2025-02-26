<?php
session_start();
include "database.php";
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);
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
                        <h2 class="page-title">รายชื่อพนักงาน</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ชื่อ</th>
                                    <th>ตำแหน่ง</th>
                                    <th>อีเมล</th>
                                    <th>กระบวนการ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['employee_ID'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['position'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td><a href='EditEmployee.php?id=" . $row['employee_ID'] . "' class='edit'>แก้ไข</a> | ";
                                    echo "<form method='post' action='DeleteEmployee.php' style='display:inline;'>";
                                    echo "<input type='hidden' name='id' value='" . $row['employee_ID'] . "'>";
                                    echo "<input type='submit' value='ลบ' class='delete' onclick='return confirm(\"คุณแน่ใจหรือไม่?\")'>";
                                    echo "</form></td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
