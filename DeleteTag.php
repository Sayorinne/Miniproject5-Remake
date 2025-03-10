<?php 
include "database.php"; 
if(isset($_POST["DelTag"])) {
    $id = $_POST["id"]; 
    $sql = "DELETE FROM `product_type` WHERE `Category_ID`= '$id'"; 
    $result = mysqli_query($conn, $sql); 

    if($result) {
        echo "<script>alert('ทำการลบเสร็จสิ้น');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
    } else {
        echo "<script>alert('ไม่สามารถลบได้);</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
    }
} else {
    
    echo "<script>alert('ไม่มี ID ที่กำหนด');</script>"; 
    echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
}
?>