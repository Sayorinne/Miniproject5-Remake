<?php session_start();
include "database.php";

$sql = "SELECT * FROM review";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (isset($_POST['addedit'])) {
  // รับข้อมูลจากฟอร์ม
  if (isset($_POST['id'])) {
    $title = $_POST['Title'];
    $Content = $_POST['Content'];
    $topicname = $_POST['tagname'];
    $Admin_ID = $_SESSION['Admin_ID'];
    $Review_ID = $_POST['id'];
    $Check_Image = $_FILES['image']['name'];


    // อัปโหลดไฟล์รูปภาพ
    $target_filename = basename($_FILES["image"]["name"]);

    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "UPDATE review 
          SET Totallikes = 0,
              topic_ID ='$topicname',
              Title = '$title',
              Content = '$Content',
              Admin_ID = '$Admin_ID',
              Image_rv = '$target_filename'
          WHERE Review_ID = '$Review_ID'";

    if ($conn->query($sql) === TRUE) {
      echo "บันทึกข้อมูลสำเร็จ";
    } else {
      echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
    $conn->close();
  }

}

?>