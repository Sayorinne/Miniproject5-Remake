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
    <script src="JS/schedule.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <div class="service-container">
                    <h1>จองคิว "ซ่อมแซมกรอบรูป"</h1>
                </div>

                <div class="schedule-container">
                    <div class="schedule-box">
                        <h2>เลือกเดือน</h2>
                        <div class="month-selection">
                            <?php
                            for ($m = 1; $m <= 12; $m++) {
                                $monthName = date('F', mktime(0, 0, 0, $m, 10));
                                echo "<button class='month-btn' data-month='$m'>$monthName</button>";
                            }
                            ?>
                        </div>
                        <div class="year-selection">
                            <h3>เลือกปี</h3>
                            <?php
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y <= $currentYear + 2; $y++) {
                                echo "<button class='year-btn' data-year='$y'>$y</button>";
                            }
                            ?>
                        </div>
                        <h3>เลือกวัน</h3>
                        <div class="schedule-grid" id="days-container">



                        </div>
                    </div>
                    <div class="time-box">
                        <h2>เลือกเวลา</h2>
                        <div class="time-grid" id="time-container">

                        </div>
                    </div>
                </div>
                <div class="service-container">
                    <a href="CustomerReservation.php" class="service-btn return">
                        ย้อนกลับ

                    </a>
                    <form action="CustomerReserveRepairDetailForm.php" method="post">
                        <input type="hidden" name="year" id="selected-year">
                        <input type="hidden" name="month" id="selected-month">
                        <input type="hidden" name="day" id="selected-day">
                        <input type="hidden" name="time" id="selected-time">
                        <button type="submit" class="service-btn accept">ยืนยัน</button>
                    </form>
                </div>
            </main>

        </div>
    </div>
</body>

</html>