<?php
session_start();
include "database.php";
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
    <link rel="stylesheet" href="CSS/CustomerReserveSelection.css">
    <link rel="stylesheet" href="CSS/CustomerReserve.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>

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

            <main>
    <h1 style="text-align: center;">จองบริการ</h1>
    <div class="big-cards-container">
        <a href="CustomerReserveRepair.php" class="big-card repair-card">
        <div class="repair-image">
            <img src="Picture/crackedFrameReserve.jpg" alt="Custom Frame Service">
            </div>
            <div>
            <h2><i class="fa fa-wrench"></i>
             สั่งซ่อมกรอบรูป 
             <i class="fa fa-wrench"></i>
            </h2>
            <p>กรอบรูปเสียหาย จองคิวตรงนี้</p> 
            </div>
        </a>
        <a href="CustomerReserveCustom.php" class="big-card custom-card">
            <div class="custom-image">
            <img src="Picture/framecustomreserve.jpg" alt="Custom Frame Service">
            </div>
            <div>
            <h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
            ทำกรอบแบบสั่งทำ 
            <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
            </h2>
            <p>บริการออกแบบและทำกรอบรูปตามความต้องการ</p>
            </div>
        </a>
    </div>
</main>


        </div>
    </div>
</body>

</html>