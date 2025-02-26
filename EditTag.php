
<?php session_start();
include "database.php";

$sql = "SELECT * FROM topic";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result); 
if(isset($_POST['edit-tag'])) {
  // รับข้อมูลจากฟอร์ม
  if(isset($_POST['id'])){
    $topicname = $_POST['tagname'];
    $topicdetail = $_POST['detail'];
    $topic_ID = $_POST['id'];
    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql="UPDATE topic 
          SET   topic_name ='$topicname',
                topic_description = '$topicdetail'
          WHERE topic_ID = '$topic_ID'";
  
    if ($conn->query($sql) === TRUE) {
      echo "บันทึกข้อมูลสำเร็จ";
    } else {
      echo "มีข้อผิดพลาดในการบันทึกข้อมูล: ".$conn->error;
    }
    $conn->close();
  }
 
}

?>