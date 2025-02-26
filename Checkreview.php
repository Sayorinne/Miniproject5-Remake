
<?php session_start();
include "database.php";

if(isset($_POST['add'])) {
  // รับข้อมูลจากฟอร์ม
  $title = $_POST['Title'];
  $Content = $_POST['Content'];
  $topicname = isset($_POST['tagname']) ? $_POST['tagname'] : null;
  $Admin_ID = $_SESSION['Admin_ID'];
  
  

  // อัปโหลดไฟล์รูปภาพ
  $target_filename = basename($_FILES["image"]["name"]);
  // เพิ่มข้อมูลลงในฐานข้อมูล
  $sql="INSERT INTO review (Review_ID, Totallikes, topic_ID, Title, Content, Admin_ID, Image_rv) 
        VALUES (NULL, 0, '$topicname', '$title', '$Content', '$Admin_ID', '$target_filename')";

  if ($conn->query($sql) === TRUE) {
    echo "บันทึกข้อมูลสำเร็จ";
  } else {
    echo "มีข้อผิดพลาดในการบันทึกข้อมูล: ".$conn->error;
  }
  $conn->close();
}

?>