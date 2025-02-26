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
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    
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
                        <a  class href="Homepage.php">
                            <span class="nav-link"><span>หน้าหลัก</span></span>
                        </a>
                        <a aria-current="page" href="ArtFrame.php">
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
                    <h1 style="padding-right: 70%;">กรอบรูป</h1>
                    <div class="shopping-cart-icon">
                        <h5 style="padding-right: 10% ;">คำสั่งซื้อทั้งหมด</h5>
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
            
 <!-- Main Content Row -->
<div class="row">
<div class="item-for-sale">
<div class="w3-container content-container">
    <div class="w3-row w3-margin-bottom">
        <!-- Image 1 -->
        <div class="w3-third w3-card w3-padding small-card">
            <div class="w3-row">
                <div class="w3-col m6">
                    <img src="Picture/3gok.jpg" class="w3-image w3-card-4" style="width: 100px; border-radius: 10px;">
                </div>
                <div class="w3-col m6 w3-padding">
                    <h5>Image 1 Name</h5>
                    <p><strong>Price:</strong> $20</p>
                </div>
            </div>
        </div>

        <!-- Image 2 -->
        <div class="w3-third w3-card w3-padding small-card">
            <div class="w3-row">
                <div class="w3-col m6">
                    <img src="Picture/3gok.jpg" class="w3-image w3-card-4" style="width: 100px; border-radius: 10px;">
                </div>
                <div class="w3-col m6 w3-padding">
                    <h5>Image 2 Name</h5>
                    <p><strong>Price:</strong> $25</p>
                </div>
            </div>
        </div>

        <!-- Image 3 -->
        <div class="w3-third w3-card w3-padding small-card">
            <div class="w3-row">
                <div class="w3-col m6">
                    <img src="Picture/3gok.jpg" class="w3-image w3-card-4" style="width: 100px; border-radius: 10px;">
                </div>
                <div class="w3-col m6 w3-padding">
                    <h5>Image 3 Name</h5>
                    <p><strong>Price:</strong> $30</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    </div>
    </div>
    </div>
</body>
</html>
