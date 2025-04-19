<?php
session_start();
include "database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $user_id = $_SESSION['user_id'];

    // ตรวจสอบว่า item นี้เป็นของ user นี้จริงไหม
    $check_sql = "SELECT * FROM cart_item ci
                  JOIN shopping_cart sc ON ci.Cart_ID = sc.Cart_ID
                  WHERE ci.Item_ID = ? AND sc.User_ID = ? AND sc.Status = 'pending'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("is", $item_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // ลบเฉพาะรายการนี้
        $delete_sql = "DELETE FROM cart_item WHERE Item_ID = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $item_id);
        if ($delete_stmt->execute()) {
            $_SESSION['add_to_cart_msg'] = "ลบสินค้าเรียบร้อยแล้ว";
        } else {
            $_SESSION['add_to_cart_msg'] = "เกิดข้อผิดพลาดในการลบสินค้า";
        }
    } else {
        $_SESSION['add_to_cart_msg'] = "ไม่พบสินค้านี้ในตะกร้าของคุณ";
    }
}

header("Location: CustomerAddtoCart.php");
exit();
