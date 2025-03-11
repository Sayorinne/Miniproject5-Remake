<?php
session_start();
include "database.php";

if (isset($_POST['add'])) {
  // รับข้อมูลจากฟอร์ม
  $art_name = $_POST['name'];
  $price = $_POST['price'];
  $color = $_POST['color'];
  $size = $_POST['size'];
  $detail = $_POST['detail'];

  
  // ตรวจสอบไฟล์ภาพ
  if (!empty($_FILES["image"]["name"])) {
    $target_filename = basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], "Picture/" . $target_filename);
  } else {
    $target_filename = ""; // ถ้าไม่มีอัปโหลด ให้ใช้รูป default
  }

  // INSERT ข้อมูลลงฐานข้อมูล
  $sql = "INSERT INTO artproduct (Art_ID,Art_name, Art_price,Art_color,Art_size, detail, Art_image) 
          VALUES (NULL, '$art_name', '$price', '$color', '$size', '$detail', '$target_filename')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php">';
  } else {
    echo "<script>alert('มีข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php">';
  }

  $conn->close();
}
?>