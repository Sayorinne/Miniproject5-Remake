<?php session_start();
include "database.php";

if (isset($_POST['add-tag'])) {
  // รับข้อมูลจากฟอร์ม
  $topicname = $_POST['tagname'];
  $topicdetail = $_POST['detail'];


  // เพิ่มข้อมูลลงในฐานข้อมูล
  $sql = "INSERT INTO product_type (Category_ID, Category_name, Category_detail) 
        VALUES (NULL, '$topicname', '$topicdetail')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> ';
  } else {
    echo "<script>alert('มีข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> ';

  }
  $conn->close();
}

?>