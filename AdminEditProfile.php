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
    <title>FrameArt</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Internal CSS -->

    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminProfilePage.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->
    <script src="JS/slideshow.js" defer></script>
    <script src="JS/popular.js" defer></script>
    <script src="JS/profile.js" defer></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/loginNotify.js"></script>
</head>

<body>

    <div class="layout expanded home-page">
        
    <div class="left-menu">
                    <?php include './Template/LeftNavBar/AdminLeftNav.php'; ?>
                </div>

        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                    <?php include './Template/Header/AdminHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="admin-wrapper">
                <div class="left-menu">


                    <div class="left-menu-content">
                        <hr>
                        <div class="ms-auto nav">
                            <a  class href="AdminPage.php">
                                <span class="nav-link"><span>จัดการ "สินค้ากรอบรูป"</span></span>
                            </a>

                            <a class href="AdminArtPage.php">
                                <span class="nav-link"><span>จัดการ "ภาพศิลป์"</span></span>
                            </a>

                            <a class href="AdminTagPage.php">
                                <span class="nav-link"><span>จัดการ "หมวดหมู่"</span></span>
                            </a>
                        </div>
                        <hr>
                    </div>
                </div>


                <div class="admin-content">
    

                <div class="profile-container">
                <form action="editProfileadmin.php" method="post" enctype="multipart/form-data">
                    <label>Username:</label>
                    <input type="text" name="Username_employee" class="text-input"
                        value="<?php echo htmlspecialchars($employee['Username_employee']); ?>">

                    <label>Password:</label>
                    <input type="password" name="password" class="text-input" placeholder="ใส่รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)">

                    <label>Email:</label>
                    <input type="text" name="email" class="text-input"
                        value="<?php echo htmlspecialchars($employee['email']); ?>">

                    <label>รูปภาพพนักงาน:</label><br>
                    <img src="Picture/<?php echo htmlspecialchars($employee['employee_image']); ?>" id="image-preview" style="max-width: 200px;">
                    <input type="file" name="image" id="picture" class="text-input" onchange="previewImage(event)">

                    <input type="hidden" name="Employee_ID" value="<?php echo $employee['Employee_ID']; ?>">
                    <button type="submit" class="btn btn-big" name="addeditemp">อัปเดตข้อมูล</button>
                </form>

                </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>