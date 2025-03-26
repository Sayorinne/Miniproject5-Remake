<?php
session_start();
include "database.php";
$User_ID = $_SESSION['user_id'];
$sql = "SELECT * From customer WHERE User_ID = '$User_ID'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    die(" ไม่พบข้อมูลพนักงาน!");
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
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/CustomerHomePage.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/loginNotify.js"></script>
</head>

<body>

    <div class="layout expanded home-page">
        <!-- Left Menu -->
        <?php include './Template/LeftNavBar/LeftNav.php'; ?>


        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-section">
                    </div>
                    <div class="right-section">
                        <?php include './Template/Header/CustomerHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <section class="hero">

                <div class="hero-content">
                    <h1>ให้รูปของคุณ อยู่ในอ้อม"กรอบ"ของเรา</h1>
                    <p>ศิลปะที่ดี ควรมีกรอบที่ดี </p>
                </div>
        </div>


    </div>
    <div class="features-container">
        <section class="features">
            <div class="feature">
                <h2>ตามหากรอบรูปที่ใช่อยู่หรอ?</h2>
                <p>เรามีกรอบรูปให้เลือกหลากหลายชนิด <br> ทุกๆชิ้นประดิษฐ์ด้วยความประณีต</p>
                <div>
                    <img src="Picture/framehomepage.png" alt="Artwork">
                </div>

            </div>

            <div class="feature">
                <h2>อยากได้รูปภาพไว้ครอบครอง?</h2>
                <p>เรามีรูปภาพที่ถูกวาดโดยจิตรกรส่วนตัว <br> ทุกงานศิลปะมีเพียงหนึ่งเดียวเท่านั้น</p>
                <div>
                    <img src="Picture/arthomepage.png" alt="Artwork">
                </div>
            </div>
            <div class="feature">
                <h2>กรอบรูปมีปัญหา?<br>
                    หากรอบรูปที่ถูกใจไม่เจอ?</h2>
                <p>
                    พวกเรามีบริการรับซ่อมและสั่งทำกรอบรูป <br>
                    ไม่ว่าจะเป็นปัญหาใดๆหรืออุดมคติแบบใด <br>
                    เราพร้อมทำเพื่อคุณ </p>
                <div>
                    <img src="Picture/brokenframehomepage.jpg" alt="Artwork">
                </div>

            </div>

        </section>
    </div>

</body>

</html>