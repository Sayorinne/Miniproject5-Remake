
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
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- JQuery -->

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>
    <script src="JS/texteditor.js" defer></script>


</head>
<body>
    <div class="layout expanded home-page">
    <?php
        session_start();
        // เชื่อมต่อกับฐานข้อมูล
        include "database.php";
        // ตรวจสอบว่ามี GET parameter id ถูกส่งมาหรือไม่
        if(isset($_GET['id'])){
            // ดึงค่า id จาก GET parameter
            $id = $_GET['id'];

            $sql = "SELECT * FROM product_type WHERE Category_ID = '$id'" ;
            $result = mysqli_query($conn, $sql);

            // ตรวจสอบว่ามีข้อมูลที่สอดคล้องกับ id ที่ระบุหรือไม่
            if(mysqli_num_rows($result)> 0){
                // ดึงข้อมูลรีวิวออกมา
                $topicID = mysqli_fetch_assoc($result);
            }else{
                // หากไม่พบข้อมูลรีวิวที่ตรงกับ id ที่ระบุ สามารถให้ระบบทำการ redirect ไปยังหน้าที่ต้องการได้
                // ในที่นี้เราจะให้กลับไปยังหน้า AdminPage.php
                header("Location: AdminTagPage.php");
                exit; // ออกจากสคริปต์
            }
        }else{
            // หากไม่มี GET parameter id ที่ถูกส่งมา ก็ให้ redirect ไปยังหน้า AdminPage.php เช่นกัน
            header("Location: AdminTagPage.php");
            exit; // ออกจากสคริปต์
        } 
    ?>

        <!-- Right Main -->
        <div class="right-main">
        <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                        <!-- Account validate -->
                        <?php if(isset($_SESSION['Employee_ID'])): ?>
                            <div class="profile-button">
                            <p class =" fa fa-user" style= "margin: 10px" onclick="toggloeMenu()"> <?php echo $_SESSION['Username_employee']; ?> </p>
                            </div>
                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">
                                        <img src="Picture/Sihba_07.jpg" >
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
                        <a class href="AdminArtPage.php">
                            <span class="nav-link"><span>จัดการ "ภาพศิลป์"</span></span>
                        </a>
                        <a aria-current="page"  class href="AdminTagPage.php">
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
                    <div class ="content">
                        <h2 class="page-title">แก้ไขหมวดหมู่</h2>
                        <form action="EditTag.php" method ="post">
                            <div>
                                <label>ชื่อหมวดหมู่</label>
                                <input type="text" name="tagname" id=""  class="text-input" value="<?php echo $topicID['Category_name']; ?>" >
                            </div>
                            <input type ="hidden" name="id" value="<?php echo $topicID['Category_ID']  ?> "> 
                            <div>
                                <label>รายละเอียดหมวดหมู่</label>
                                <textarea name="detail" id="description"><?php echo $topicID['Category_detail']; ?> </textarea>
                            </div>
                            <div>
                                <button type="submit" name= "edit-tag" class="btn btn-big"->แก้หมวดหมู่</button>
                            </div>
                    </div>
                        </from>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
