<?php 
include "database.php"; 
if(isset($_POST["DelFrame"])) {
    $id = $_POST["id"]; 
    $sql = "DELETE FROM `product` WHERE `product_ID`= '$id'"; 
    $result = mysqli_query($conn, $sql); 

    if($result) {
        echo "<script>alert('Delete complete');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> '; 
    } else {
        echo "<script>alert('Cannot delete');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> '; 
    }
} else {
    echo "<script>alert('No ID provided');</script>"; 
    echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> '; 
}
?>

<?php 
include "database.php"; 
if(isset($_POST["Delart"])) {
    $id = $_POST["id"]; 
    $sql = "DELETE FROM `artproduct` WHERE `Art_ID`= '$id'"; 
    $result = mysqli_query($conn, $sql); 

    if($result) {
        echo "<script>alert('Delete complete');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php"> '; 
    } else {
        echo "<script>alert('Cannot delete');</script>"; 
        echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php"> '; 
    }
} else {
    
    echo "<script>alert('No ID provided');</script>"; 
    echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php"> '; 
}
?>