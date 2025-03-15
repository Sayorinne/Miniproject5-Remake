<?php
session_start();

include "database.php";
                $User_ID = $_SESSION['user_id'];
                $sql = "SELECT * From customer WHERE User_ID = '$User_ID'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                } else {
                    die(" ไม่พบข้อมูลลูกค้า!");
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
    <link rel="stylesheet" href="CSS/CustomerProfilePage.css">

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
                <a href="CustomerHomepage.php">
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
                        <h1>โปรไฟล์</h1>
                    </div>
                    <div class="right-section">
                    <?php include './Template/Header/CustomerHeaderContent.php'; ?>
                    </div>
                </div>
            </div>


            <!-- Main Content Row -->
            <div class="admin-wrapper">
                

                <div class="admin-content">
    

                <div class="profile-container">
                <form action="editProfilecustomer.php" method="post" enctype="multipart/form-data">
                    <label>Username:</label>
                    <input type="text" name="Username" class="text-input"
                        value="<?php echo htmlspecialchars($user['Username']); ?>">

                    <label>Password:</label>
                    <input type="password" name="password" class="text-input" placeholder="ใส่รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)">

                    <label>Email:</label>
                    <input type="text" name="email" class="text-input"
                        value="<?php echo htmlspecialchars($user['email']); ?>">

                    <label>รูปภาพโปรไฟล์:</label><br>
                    <img src="Picture/<?php echo htmlspecialchars($user['customer_image']); ?>" id="image-preview" style="max-width: 200px;">
                    <input type="file" name="image" id="picture" class="text-input" onchange="previewImage(event)">

                    <input type="hidden" name="User_ID" value="<?php echo $user['User_ID']; ?>">
                    <button type="submit" class="btn btn-big" name="addeditemp">อัปเดตข้อมูล</button>
                </form>

                </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>