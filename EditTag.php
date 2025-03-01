
<?php session_start();
include "database.php";

$sql = "SELECT * FROM product_type";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result); 
if(isset($_POST['edit-tag'])) {
  // รับข้อมูลจากฟอร์ม
  if(isset($_POST['id'])){
    $topicname = $_POST['tagname'];
    $topicdetail = $_POST['detail'];
    $topic_ID = $_POST['id'];
    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql="UPDATE product_type
          SET   Category_name ='$topicname',
                Category_detail = '$topicdetail'
          WHERE Category_ID = '$topic_ID'";
  
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Edit complete');</script>";
      echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
    } else {
      echo "<script>alert('มีข้อผิดพลาดในการบันทึกข้อมูล');</script>";
      echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
    }
    $conn->close();
  }
 
}

?>