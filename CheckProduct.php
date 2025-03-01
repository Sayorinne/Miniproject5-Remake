<?php 
session_start();
include "database.php";

if(isset($_POST['add'])) {
  // รับข้อมูลจากฟอร์ม
  $product_name = $_POST['name'];
  $price = $_POST['price'];
  $color = $_POST['color'];
  $size = $_POST['size'];
  $detail = $_POST['detail'];

  // หาหมวดหมู่แรกที่ยังมีอยู่
  $query = "SELECT Category_ID FROM product_type ORDER BY Category_ID ASC LIMIT 1"; 
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $default_category_id = $row ? $row['Category_ID'] : NULL; // ถ้าไม่มีเลยให้เป็น NULL

  // ตรวจสอบหมวดหมู่ที่ผู้ใช้เลือก
  $tagname = isset($_POST['tagname']) && $_POST['tagname'] !== "" ? $_POST['tagname'] : $default_category_id;

  // ถ้าไม่มีหมวดหมู่เหลือเลย ให้แจ้งเตือนและหยุดการเพิ่มสินค้า
  if ($tagname === NULL) {
    echo "<script>alert('ไม่สามารถเพิ่มสินค้าได้ เพราะไม่มีหมวดหมู่ที่ใช้งานได้');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php">';
    exit();
  }

  // ตรวจสอบไฟล์ภาพ
  if (!empty($_FILES["image"]["name"])) {
    $target_filename = basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], "Picture/" . $target_filename);
  } else {
    $target_filename = "eggRock.jpg"; // ถ้าไม่มีอัปโหลด ให้ใช้รูป default
  }

  // INSERT ข้อมูลลงฐานข้อมูล
  $sql = "INSERT INTO product (product_ID, Category_ID, product_name, product_price, product_color, product_size, detail, product_image) 
          VALUES (NULL, '$tagname', '$product_name', '$price', '$color', '$size', '$detail', '$target_filename')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminPage.php">'; 
  } else {
    echo "<script>alert('มีข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminPage.php">'; 
  }

  $conn->close();
}
?>
