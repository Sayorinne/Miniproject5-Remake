<?php
session_start();
include "database.php";
$sql = "SELECT * FROM employee";
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
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JQuery -->

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>
    <script src="JS/texteditor.js" defer></script>
</head>

<body>
    <div class="layout expanded home-page">
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                        <!-- Account validate -->
                        <?php if (isset($_SESSION['Owner_ID'])): ?>
                            <div class="profile-button">
                                <p class=" fa fa-user" style="margin: 10px" onclick="toggloeMenu()">
                                    <?php echo $_SESSION['Username_Owner']; ?> </p>
                            </div>
                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">
                                        <img src="Picture/Sihba_07.jpg">
                                        <h2><?php echo $_SESSION['Username_Owner']; ?></h2>
                                        <h3>ID:<?php echo $_SESSION['Owner_ID']; ?></h3>
                                    </div>

                                    <hr>
                                    <a href="#" class="sub-menu-link">
                                        <img src="images/profile.png">
                                        <p>Edit Profile</p>
                                        <span></span>
                                    </a>

                                    <a href="logout.php" class="sub-menu-link">
                                        <img src="images/profile.png">
                                        <p>Logout</p>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <a role="button" tabindex="0" href="login.php" class="login-button btn btn-primary">
                                <span>Login</span>
                            </a>
                            <a role="button" tabindex="0" href="registration.php" class="login-button btn btn-primary">
                                <span>Register</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="admin-wrapper">
                <div class="left-menu">
                    <hr>
                    <div class="left-menu-content">
                        <div class="ms-auto nav">
                            <a class href="OwnerPage.php">
                                <span class="nav-link"><span>แดชบอร์ด</span></span>
                            </a>

                            <a href="OwnerHistory.php">
                                <span class="nav-link"><span>ประวัติการทำรายการ</span></span>
                            </a>

                            <a aria-current="page" href="OwnerEmployeePage.php">
                                <span class="nav-link"><span>จัดการ "พนักงาน"</span></span>
                            </a>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="admin-content">
                    <div class="button-group">
                        <a href="OwnerAddEmployee.php" class="btn btn-big">เพิ่มพนักงาน</a>
                    </div>
                    <div class="content">
                        <h2 class="page-title">รายชื่อพนักงาน</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ชื่อ</th>
                                    <th>อีเมล</th>
                                    <th>กระบวนการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['Employee_ID'] . "</td>";
                                    echo "<td>" . $row['Username_employee'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td><a href='OwnerEditEmployee.php?Employee_ID=" . $row['Employee_ID'] . "' class='edit'>แก้ไข</a> | ";
                                    echo "<form method='post' action='DeleteEmployee.php' style='display:inline;'>";
                                    echo "<input type='hidden' name='Employee_ID' value='" . $row['Employee_ID'] . "'>";
                                    echo "<input type='submit' name='DelEmp' value='ลบ' class='delete' onclick='return confirm(\"คุณแน่ใจหรือไม่?\")'>";
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