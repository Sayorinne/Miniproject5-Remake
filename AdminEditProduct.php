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
        session_start();
        // เชื่อมต่อกับฐานข้อมูล
        include "database.php";
        // ตรวจสอบว่ามี GET parameter id ถูกส่งมาหรือไม่
        if (isset($_GET['id'])) {
            // ดึงค่า id จาก GET parameter
            $id = $_GET['id'];

            // คำสั่ง SQL เพื่อดึงข้อมูลรีวิวตาม id ที่ระบุ
            $sql = "SELECT * FROM product WHERE product_ID = '$id'";
            $result = mysqli_query($conn, $sql);


            // ตรวจสอบว่ามีข้อมูลที่สอดคล้องกับ id ที่ระบุหรือไม่
            if (mysqli_num_rows($result) > 0) {
                // ดึงข้อมูลรีวิวออกมา
                $product_ID = mysqli_fetch_assoc($result);
            } else {
                // หากไม่พบข้อมูลรีวิวที่ตรงกับ id ที่ระบุ สามารถให้ระบบทำการ redirect ไปยังหน้าที่ต้องการได้
                // ในที่นี้เราจะให้กลับไปยังหน้า AdminPage.php
                header("Location: AdminPage.php");
                exit; // ออกจากสคริปต์
            }
        } else {
            // หากไม่มี GET parameter id ที่ถูกส่งมา ก็ให้ redirect ไปยังหน้า AdminPage.php เช่นกัน
            header("Location: AdminPage.php");
            exit; // ออกจากสคริปต์
        }
        ?>
        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <!-- <input type="text" name="search" placeholder="Search.."> -->
                    <div class="left-icon">
                        <?php include './Template/Header/AdminHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="admin-wrapper">
                
            <div class="left-menu">
                    <?php include './Template/LeftNavBar/AdminLeftNav.php'; ?>
                </div>



                <div class="admin-content">
                    <div class="button-group">
                        <a href="AdminCreateProduct.php" class="btn btn-big">สร้างสินค้า</a>
                        <a href="AdminPage.php" class="btn btn-big">จัดการสินค้ากรอบรูป</a>
                    </div>

                    <div class="content">

                        <h2 class="page-title">แก้ไขข้อมูลกรอบรูป</h2>

                        <form action="editProduct.php" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="name">ชื่อกรอบรูป</label>
                                <input type="text" name="name" id="name" class="text-input"
                                    value="<?php echo $product_ID['product_name']; ?>">
                            </div>

                            <input type="hidden" name="id" value="<?php echo $product_ID['product_ID']; ?>">

                            <div class="form-group">
                                <label for="price">ราคาสินค้า</label>
                                <input type="number" name="price" id="price" class="text-input" min="0" step="0.25"
                                    required value="<?php echo $product_ID['product_price']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="color">สี</label>
                                <input type="text" name="color" id="color" class="text-input"
                                    value="<?php echo $product_ID['product_color']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="size">ขนาด</label>
                                <input type="text" name="size" id="size" class="text-input"
                                    value="<?php echo $product_ID['product_size']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="description">เนื้อหา</label>
                                <textarea name="detail" id="description"><?php echo $product_ID['detail']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="tagname">หมวดหมู่</label>
                                <select name="tagname" id="tagname">
                                    <?php
                                    // ดึงข้อมูลหมวดหมู่ทั้งหมดจากฐานข้อมูล
                                    $sql = "SELECT * FROM product_type";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<option disabled>เลือกหมวดหมู่</option>";
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // ตรวจสอบว่าเป็นหมวดหมู่ที่เลือกอยู่หรือไม่
                                            $selected = ($row['Category_ID'] == $product_ID['Category_ID']) ? "selected" : "";
                                            echo "<option value='" . $row['Category_ID'] . "' $selected>" . $row['Category_name'] . "</option>";
                                        }
                                    } else {
                                        echo "<option disabled selected>ไม่สามารถใส่ข้อมูลได้</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="picture">รูปประกอบ</label><br>
                                <img src="Picture/<?php echo $product_ID['product_image']; ?>" id="image-preview"
                                    style="max-width: 200px; margin-bottom: 10px;">
                                <input type="file" name="image" id="picture" class="text-input"
                                    onchange="previewImage(event)">

                                <p id="file-name"><?php echo "ภาพที่เลือก : " . $product_ID['product_image']; ?></p>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-big" name="edit-product">แก้ไขสินค้า</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>