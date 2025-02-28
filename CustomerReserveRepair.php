    <?php
    session_start();
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
        <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- JavaScript -->
        <script src="JS/profile.js" defer></script>
        <script src="JS/schedule.js" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <div class="layout expanded home-page">
            <!-- Left Menu -->
            <div class="left-menu">
                <div class="logo">
                    <a href="#"> 
                        <img src="Picture/logoframeart.png" style="width: 200px;"> 
                    </a>
                    <hr>
                    <div class="left-menu-content">
                        <div class="ms-auto nav">
                            <a href="CustomerHomepage.php">
                                <span class="nav-link"><span>หน้าหลัก</span></span>
                            </a>
                            <a href="CustomerArtFrame.php">
                                <span class="nav-link"><span>กรอบรูป</span></span>
                            </a>
                            <a href="CustomerWorkart.php">
                                <span class="nav-link"><span>งานศิลป์</span></span>
                            </a>
                            <a aria-current="page" href="CustomerReservation.php">
                                <span class="nav-link"><span>จองคิว</span></span>
                            </a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            
            <!-- Right Main -->
            <div class="right-main">
            <div class="top-nav">
    <div class="inside">
        <div class="left-section">
            <h1>หน้าหลัก</h1>
        </div>
        <div class="right-section">
            <div class="shopping-cart-icon">
                <h5>คำสั่งซื้อทั้งหมด</h5>
            </div>
            <div class="profile-icon">
                <!-- Account validate -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="profile-image">
                        <img src="Picture/sayo.png" onclick="toggloeMenu()">
                    </div>
                    <div class="sub-menu-wrap" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img src="Picture/sayo.png">
                                <h2><?php echo $_SESSION['username']; ?></h2>
                                <h3>ID:<?php echo $_SESSION['user_id']; ?></h3>
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
        for ($y = $currentYear; $y <= $currentYear + 5; $y++) {
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
    <div class="time-grid">
        <?php
        $start = new DateTime('08:00');
        $end = new DateTime('18:00');
        $interval = new DateInterval('PT30M');
        $times = new DatePeriod($start, $interval, $end);

        foreach ($times as $time) {
            echo '<button class="time-btn">' . $time->format('H:i') . '</button>';
        }
        ?>
    </div>
    </div>
    </div>
    <div class="service-container">
    <a href="CustomerReservation.php" class="service-btn return">       
        ย้อนกลับ

    </a>
    <a href="CustomerReserveDetailForm.php" class="service-btn accept"> 
        ยืนยัน
    </a>
    </div>
    </main>

            </div>
        </div>
    </body>
</html>