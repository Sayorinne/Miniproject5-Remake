<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Manage Tag</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="CSS/adminTableinfo.css">
    <!-- JQuery -->

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>
    <script src="JS/texteditor.js" defer></script>


</head>

<body>
    <div class="layout expanded home-page">
        
        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                    <?php include './Template/Header/AdminHeaderContent.php'; ?>
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

                            <a class href="AdminArtPage.php">
                                <span class="nav-link"><span>จัดการ "ภาพศิลป์"</span></span>
                            </a>

                            <a aria-current="page" class href="AdminTagPage.php">
                                <span class="nav-link"><span>จัดการ "หมวดหมู่"</span></span>
                            </a>
                        </div>
                        <hr>
                    </div>
                </div>





                <div class="admin-content">
                    <div class="button-group">
                        <a href="AdminCreateTag.php" class="btn btn-big">สร้างหมวดหมู่</a>
                        <a href="AdminTagPage.php" class="btn btn-big">จัดการหมวดหมู่</a>
                    </div>

                    <div class="content">

                        <h2 class="page-title">จัดการหมวดหมู่</h2>

                        <table>
                            <thead>
                                <th>Tag_ID</th>
                                <th>ชื่อหมวดหมู่</th>
                                <th>รายละเอียดหมวดหมู่</th>
                                <th colspan="2">กระบวนการ</th>
                            </thead>
                            <tbody>
                                <?php
                                // เชื่อมต่อกับฐานข้อมูล
                                include "database.php";
                                // คำสั่ง SQL SELECT เพื่อดึงข้อมูลจากตาราง "topic"
                                $sql = "SELECT * FROM product_type";
                                $result = mysqli_query($conn, $sql);
                                ?>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $category_id = isset($row['Category_ID']) ? $row['Category_ID'] : 'N/A';
                                    $category_name = isset($row['Category_name']) ? $row['Category_name'] : 'N/A';
                                    $category_detail = isset($row['Category_detail']) ? substr($row['Category_detail'], 0, 347) : 'N/A';
                                
                                    echo "<tr>";
                                    echo "<td>$category_id</td>";
                                    echo "<td>$category_name</td>";
                                    echo "<td>$category_detail</td>";
                                    echo "<td><a href='AdminEditTag.php?id=$category_id' class='edit'>แก้ไข</a></td>";
                                    echo "<td><form method='post' action='DeleteTag.php'>
                                            <input type='hidden' name='id' value='$category_id'> 
                                            <input type='submit' value='ลบ' class='delete' name='DelTag' onclick=\"return confirm('คุณแน่ใจหรือไม่ที่ต้องการลบ?')\">
                                          </form></td>";
                                    echo "</tr>";
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