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
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/ProfilePage.css">

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
        <!-- Left Menu -->
        <div class="left-menu">
            <div class="logo">
                <a href="#">
                    <img src="Picture/logoframeart.png" style="width: 200px;">
                </a>
                <hr>
                <div class="left-menu-content">
                    <div class="ms-auto nav">
                        <a aria-current="page" href="CustomerHomepage.php">
                            <span class="nav-link"><span>หน้าหลัก</span></span>
                        </a>
                        <a href="CustomerArtFrame.php">
                            <span class="nav-link"><span>กรอบรูป</span></span>
                        </a>
                        <a href="CustomerWorkart.php">
                            <span class="nav-link"><span>งานศิลป์</span></span>
                        </a>
                        <a href="CustomerReservation.php">
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
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <h5>คำสั่งซื้อทั้งหมด</h5>
                            <?php endif; ?>
                        </div>
                        <div class="profile-icon">
                            <!-- Account validate -->
                            <?php if (isset($_SESSION['user_id'])): ?>
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

            <!-- Main Content Row -->
            <div class="profile-container">
        <img src="https://via.placeholder.com/80" alt="Profile Image" class="profile-img">
        <h2>Profile Information</h2>

        <div class="form-group">
            <label for="username">Username</label>
            <p><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <p><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Not available'; ?></p>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <p><?php echo isset($_SESSION['address']) ? $_SESSION['address'] : 'Not available'; ?></p>
        </div>

        <button class="edit-profile-btn" onclick="window.location.href='edit_profile.php'">แก้ไขโปรไฟล์</button>
    </div>
</body>

</html>







