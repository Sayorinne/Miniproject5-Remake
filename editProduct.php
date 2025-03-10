<?php
session_start();
include "database.php";

if (isset($_POST['edit-product'])) {
    if (isset($_POST['id'])) {
        $product_ID = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $detail = $_POST['detail'];
        $tagname = isset($_POST['tagname']) && $_POST['tagname'] !== "" ? $_POST['tagname'] : null;

        // Fetch current product details
        $sql = "SELECT * FROM product WHERE product_ID = '$product_ID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $target_filename = $row['product_image']; // Default to existing image

        // Check if a new image is uploaded
        if (!empty($_FILES["image"]["name"])) {
            $target_filename = basename($_FILES["image"]["name"]);
            $target_filepath = "Picture/" . $target_filename;
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_filepath)) {
                // If upload fails, keep the old image
                $target_filename = $row['product_image'];
            }
        }

        // Update product details in the database
        $sql = "UPDATE product
                SET product_name = '$name',
                    product_price = '$price',
                    product_color = '$color',
                    product_size = '$size',
                    detail = '$detail',
                    Category_ID = COALESCE('$tagname', Category_ID),
                    product_image = '$target_filename'
                WHERE product_ID = '$product_ID'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('แก้ไขข้อมูลเสร็จสิ้น');</script>";
            echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
        } else {
            echo "<script>alert('มีข้อผิดพลาดในการบันทึกข้อมูล');</script>";
            echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
        }
        $conn->close();
    }
}
?>
