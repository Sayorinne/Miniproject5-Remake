<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmunity</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/mockup.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/slideshow.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- JavaScript -->
    <script src="JS/slideshow.js" defer></script>
    <script src="JS/popular.js" defer></script>
    <script src="JS/profile.js" defer></script>
</head>
<body>

    <div class="layout expanded home-page">
        <!-- Left Menu -->
        <div class="left-menu">
            <div class="logo">
                <a href="#"> 
                    <img src="Picture/LOGO.png" style="width: 200px;"> 
                </a>
                <hr>
                <div class="left-menu-content">
                    <div class="ms-auto nav">
                        <a aria-current="page" class href="Homepage.php">
                            <span class="nav-link"><span>หน้าหลัก</span></span>
                        </a>
                        <a href="ArtFrame.php">
                            <span class="nav-link"><span>กรอบรูป</span></span>
                        </a>
                        <a href="#">
                            <span class="nav-link"><span>งานศิลป์</span></span>
                        </a>
                        <a href="#">
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
                    <h1>หน้าหลัก</h1>
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
            
 <!-- Main Content Row -->
<div class="row">
    <!-- Left Column -->
    <div class="leftcolumn">   
    <div class="w3-container w3-padding">
    <div class="w3-card w3-round w3-white w3-padding">
        <h2 class="w3-center">About Me</h2>
        <div class="w3-center">
            <img src="Picture/frameartlogo.jpg" class="w3-circle" style="width: 150px;">
        </div>
        <h4 class="w3-center">Frameart</h4>
        <p class="w3-center">
            สวัสดี!  
            ยินดีต้อนรับสู่ frameart! ที่นี่เรารวบรวมงานศิลป์ กรอบรูป และการจองคิวไว้ให้คุณ
        </p>
        <hr>
        <h5>ข้อมูลเพิ่มเติม</h5>
        <ul>
        <li><b>ประวัติ:</b>ร้าน "เฟรมอาร์ต" บนถนนสุขุมวิท 71 มีจำกัด จากข้อมูลที่มีอยู่ ร้านนี้ตั้งอยู่ที่ 144/36 ซอยสุขุมวิท 71 ถนนสุขุมวิท แขวงพระโขนงเหนือ เขตวัฒนา กรุงเทพมหานคร 10110 โดยเปิดให้บริการตั้งแต่วันจันทร์ถึงวันศุกร์ เวลา 08:00 น. ถึง 17:00 น. และปิดทำการในวันเสาร์และอาทิตย์ </li>                

            <li><b>Email:</b> frame.art@hotmail.com</li>
            

            <li><b>ความสนใจ:</b> ศิลปะ, กรอบรูป, งานวาด</li>
            <li><b>ถูกสร้างเมื่อ:</b> มกราคม 2025</li>
        </ul>
    </div>
</div>                 

    </div>
    </div>
</body>
</html>
