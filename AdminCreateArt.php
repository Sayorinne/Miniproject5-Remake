<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Backdoor - Add Post</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminForm.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JQuery -->

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>
    <script src="JS/texteditor.js" defer></script>
    <script src="JS/previewImage.js" defer></script>


</head>

<body>
    <div class="layout expanded home-page">
        <?php
        // เชื่อมต่อกับฐานข้อมูล
        include "database.php";

        $sql = "SELECT * FROM product_type";
        $result = mysqli_query($conn, $sql);
        ?>
        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <!-- <input type="text" name="search" placeholder="Search.."> -->
                    <div class="left-icon">
                        <!-- Account validate -->
                        <?php if (isset($_SESSION['Employee_ID'])): ?>
                            <div class="profile-button">
                                <p class=" fa fa-user" style="margin: 10px" onclick="toggloeMenu()">
                                    <?php echo $_SESSION['Username_employee']; ?> </p>
                            </div>
                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">
                                        <img src="Picture/Sihba_07.jpg">
                                        <h2><?php echo $_SESSION['Username_employee']; ?></h2>
                                        <h3>ID:<?php echo $_SESSION['Employee_ID']; ?></h3>
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
            <div class="admin-wrapper">
                <div class="left-menu">

                    <hr>
                    <div class="left-menu-content">
                        <div class="ms-auto nav">
                            <a class href="AdminPage.php">
                                <span class="nav-link"><span>จัดการ "สินค้ากรอบรูป"</span></span>
                            </a>
                            <a aria-current="page" class href="AdminArtPage.php">
                                <span class="nav-link"><span>จัดการ "ภาพศิลป์"</span></span>
                            </a>
                            <a class href="AdminTagPage.php">
                                <span class="nav-link"><span>จัดการ "หมวดหมู่"</span></span>
                            </a>
                        </div>
                        <hr>
                    </div>
                </div>



                <div class="admin-content">
                    <div class="button-group">
                        <a href="AdminCreateArt.php" class="btn btn-big">สร้างสินค้าภาพศิลป์</a>
                        <a href="AdminArtPage.php" class="btn btn-big">จัดการภาพศิลป์</a>
                    </div>

                    <div class="content">

                        <h2 class="page-title">ข้อมูลงานศิลป์</h2>

                        <form action="CheckArt.php" method="post" enctype="multipart/form-data">
                            <div>
                                <label>ชื่อผลงาน</label>
                                <input type="text" name="name" id="" class="text-input">
                            </div>
                            <div>
                                <label>ราคาสินค้า</label>
                                <input type="number" name="price" class="text-input" min="0" step="0.25" required>
                            </div>
                            <div>
                                <label>สี</label>
                                <input type="text" name="color" id="" class="text-input">
                            </div>
                            <div>
                                <label>ขนาด</label>
                                <input type="text" name="size" id="" class="text-input">
                            </div>

                            <div>
                                <label>เนื้อหา</label>
                                <textarea name="detail" id="description"> </textarea>
                            </div>

                            
                            <?php
                            // ปิดการเชื่อมต่อกับฐานข้อมูล
                            mysqli_close($conn);
                            ?>
                            <div>
                                <label>รูปประกอบ</label><br>
                                <img src="" id="image-preview" style="max-width: 200px; margin-bottom: 10px;">
                                <input type="file" name="image" id="picture" class="text-input"
                                    onchange="previewImage(event)">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-big" name="add">เพิ่มสินค้า</button>
                            </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>