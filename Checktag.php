
<?php session_start();
include "database.php";

if(isset($_POST['add-tag'])) {
  // รับข้อมูลจากฟอร์ม
  $topicname = $_POST['tagname'];
  $topicdetail = $_POST['detail'];


  // เพิ่มข้อมูลลงในฐานข้อมูล
  $sql="INSERT INTO topic (topic_ID, topic_name, topic_description) 
        VALUES (NULL, '$topicname', '$topicdetail')";

  if ($conn->query($sql) === TRUE) {
    echo "บันทึกข้อมูลสำเร็จ";
  } else {
    echo "มีข้อผิดพลาดในการบันทึกข้อมูล: ".$conn->error;
  }
  $conn->close();
}

?>