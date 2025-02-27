<?php 
include "database.php"; 

if(isset($_POST["DelEmp"])) { // ✅ เช็คว่ามีปุ่มถูกกด
    if(isset($_POST["Employee_ID"])) {  // ✅ เช็คว่ามีค่า Employee_ID ถูกส่งมา
        $id = $_POST["Employee_ID"]; // ✅ รับค่า Employee_ID
        
        $sql = "DELETE FROM employee WHERE Employee_ID = '$id'"; 
        $result = mysqli_query($conn, $sql); 

        if($result) {
            echo "<script>alert('✅ ลบข้อมูลสำเร็จ!');</script>"; 
            echo '<meta http-equiv="refresh" content="0;url=OwnerEmployeePage.php"> '; 
        } else {
            echo "<script>alert('❌ ไม่สามารถลบข้อมูลได้!');</script>"; 
            echo '<meta http-equiv="refresh" content="0;url=OwnerEmployeePage.php"> '; 
        }
    } else {
        echo "<script>alert('❌ ไม่พบค่า Employee_ID!');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=OwnerEmployeePage.php"> '; 
    }
} else {
    echo "<script>alert('❌ ไม่มีคำขอลบพนักงาน!');</script>"; 
    echo '<meta http-equiv="refresh" content="0;url=OwnerEmployeePage.php"> '; 
}
?>
