<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Page</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminTableinfo.css">

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
      <!-- SweetAlert2 JS -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/loginNotify.js"></script>

</head>

<body>
    <div class="layout expanded home-page">


        <?php
        // เชื่อมต่อกับฐานข้อมูล
        include "database.php";
        // คำสั่ง SQL SELECT เพื่อดึงข้อมูลจากตาราง "topic"
        $sql = "SELECT * FROM product";
        $result = mysqli_query($conn, $sql);
        ?>


        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
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


                    <div class="left-menu-content">
                        <hr>
                        <div class="ms-auto nav">
                            <a aria-current="page" class href="AdminPage.php">
                                <span class="nav-link"><span>จัดการ "สินค้ากรอบรูป"</span></span>
                            </a>

                            <a class href="AdminArtPage.php">
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
                        <a href="AdminCreateProduct.php" class="btn btn-big">สร้างสินค้า</a>
                        <a href="AdminPage.php" class="btn btn-big">จัดการสินค้ากรอบรูป</a>
                    </div>

                    <div class="content">

                        <h2 class="page-title">รายการกรอบรูป</h2>

                        <table>
                            <thead>
                                <th>Frame_ID</th>
                                <th>ชื่อกรอบรูป</th>
                                <th>ราคา</th>
                                <th>สี</th>
                                <th>ขนาด</th>
                                <th colspan="2">กระบวนการ</th>
                            </thead>
                            <tr>
                                <?php
                                include "database.php";
                                $sql = "SELECT * From product";
                                $result = mysqli_query($conn, $sql);
                                ?>
                                <?php $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if (isset($row['product_ID'])) {
                                            echo '<td>' . $row['product_ID'] . '</td>';
                                            echo '<td>' . $row['product_name'] . '</td>';
                                            echo '<td>' . $row['product_price'] . '</td>';
                                            echo '<td>' . $row['product_color'] . '</td>';
                                            echo '<td>' . $row['product_size'] . '</td>';
                                            echo "<td><a href='AdminEditProduct.php?id=" . $row['product_ID'] . "' class='edit'>แก้ไข</a></td>"; // Pass Tag_ID as parameter to the edit page
                                            echo '<td><form method="post" action="DeleteProduct.php">
                                                <input type="hidden" name="id" value="' . $row['product_ID'] . '"> 
                                                <input type="hidden" name="type" value="frame"> 
                                                <input type="submit" value="ลบ" style= "border:none; background:none;"  class="delete" name="DelFrame" onclick="return confirm(\'คุณแน่ใจหรือไม่ที่ต้องการลบ?\')"></form></td>';
                                            echo '</tr>';
                                        }
                                    }
                                } else {
                                    echo "ไม่พบข้อมูล";
                                }
                                ?>



                        </table>

                    </div>



                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>