<?php 
include "database.php"; 
if(isset($_POST["DelTag"])) {
    $id = $_POST["id"]; 
    $sql = "DELETE FROM `topic` WHERE `topic_ID`= '$id'"; 
    $result = mysqli_query($conn, $sql); 

    if($result) {
        echo "<script>alert('Delete complete');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
    } else {
        echo "<script>alert('Cannot delete');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
    }
} else {
    
    echo "<script>alert('No ID provided');</script>"; 
    echo '<meta http-equiv="refresh" content="0;url=AdminTagPage.php"> '; 
}
?>