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
                        <h1>หน้าหลัก</h1>
                    </div>
                    <div class="right-section">
                    <?php include './Template/Header/CustomerHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <section class="hero">

        <div class="hero-content">
            <h1>ยินดีต้อนรับสู่ FrameArt</h1>
            <p>เราช่วยให้คุณเลือกซื้อกรอบรูปและงานศิลป์ได้ง่ายขึ้น
            <li><b>ประวัติ:</b>ร้าน "เฟรมอาร์ต" บนถนนสุขุมวิท 71 ร้านนี้ตั้งอยู่ที่ 144/36
                            ซอยสุขุมวิท 71 ถนนสุขุมวิท
                            <br>แขวงพระโขนงเหนือ เขตวัฒนา กรุงเทพมหานคร 10110
                            <br>โดยเปิดให้บริการตั้งแต่วันจันทร์ถึงวันศุกร์ เวลา 08:00 น. ถึง 17:00 น.
                            และปิดทำการในวันเสาร์และอาทิตย์
                        </li>
                        <li><b>Email:</b> frame.art@hotmail.com</li>
                        <li><b>บริการ:</b> ขายงานศิลปะ, ขายกรอบรูป, รับซ่อมกรอบรูป, สั่งทำกรอบรูป</li>
                        <li><b>เบอร์โทร:</b> 121212123</li>
            </p>
            </div>
            </div>


</div>
            <div class="features-container">
    <section class="features">
        <div class="feature">
            <h2>No title</h2>
            <p>Unknow</p>
        </div>
        <div class="feature">
            <h2>No title</h2>
            <p>Unknow</p>
        </div>
        <div class="feature">
            <h2>No title</h2>
            <p>Unknow</p>
        </div>
    </section>
</div>

</body>
</html>