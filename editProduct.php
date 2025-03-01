<?php session_start();
include "database.php";

$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (isset($_POST['edit-product'])) {
  // รับข้อมูลจากฟอร์ม
  if (isset($_POST['id'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $detail = $_POST['detail'];
    $tagname = isset($_POST['tagname']) && $_POST['tagname'] !== "" ? $_POST['tagname'] : $row['Category_ID'];
    $product_ID = $_POST['id'];

    if (!empty($_FILES["image"]["name"])) {
      $target_filename = basename($_FILES["image"]["name"]);
      move_uploaded_file($_FILES["image"]["tmp_name"], "Picture/" . $target_filename); // ย้ายไฟล์ไปที่โฟลเดอร์
    } else {
      $target_filename = $row['product_image']; // ถ้าไม่มีการอัปโหลดใหม่ ใช้ไฟล์เดิม
    }


    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "UPDATE product
          SET   product_name ='$name',
                product_price = '$price',
                product_color = '$color',
                product_size = '$size',
                detail = '$detail',
                Category_ID = '$tagname',
                product_image = '$target_filename'
          WHERE product_ID = '$product_ID'";

    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Edit complete');</script>";
      echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
    } else {
      echo "<script>alert('มีข้อผิดพลาดในการบันทึกข้อมูล');</script>";
      echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
    }
    $conn->close();
  }
}
?>