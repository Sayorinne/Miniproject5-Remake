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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

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
                        <a aria-current="page" href="CustomerWorkart.php">
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
            <main>
                <div class="w3-container content-container">
                    <div class="content-flex">
                        <?php
                        include "database.php";
                        $sql = "SELECT * From artproduct";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="image-card">';
                                echo '<a href="CustomerDetailWorkart.php?id=' . $row['Art_ID'] . '">';
                                echo '<img src="Picture/' . $row['Art_image'] . '" class="w3-image w3-card-4" alt="product Image">';
                                echo '<h5>' . $row['Art_name'] . '</h5>';
                                echo '<p><strong>Price:</strong> ฿' . number_format($row['Art_price'], 2) . '</p>';
                                echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>ไม่พบสินค้า</p>';
                        }
                        mysqli_close($conn);
                        ?>
                    </div>
            </div>
        </main>
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