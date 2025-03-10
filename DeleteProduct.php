<?php
include "database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $type = $_POST['type'];

    if ($type == 'frame') {
        $sql = "DELETE FROM product WHERE product_ID = ?";
    } elseif ($type == 'artwork') {
        $sql = "DELETE FROM artproduct WHERE Art_ID = ?";
    } else {
        echo "<script>alert('สินค้าที่เลือกไม่สามารถระบุได้');</script>";
        echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('กรอบรูปถูกลบแล้ว');</script>";
        if ($type == 'frame') {
            echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
        } elseif ($type == 'artwork') {
            echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php"> ';
        }
    } else {
        echo "<script>alert('ไม่สามารถลบได้');</script>";
        if ($type == 'frame') {
            echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
        } elseif ($type == 'artwork') {
            echo '<meta http-equiv="refresh" content="0;url=AdminArtPage.php"> ';
        }
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('ไม่มี ID ที่กำหนด');</script>";
    echo '<meta http-equiv="refresh" content="0;url=AdminPage.php"> ';
}
?>