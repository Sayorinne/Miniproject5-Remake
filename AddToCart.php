<?php
session_start();
ob_start();
include 'database.php';
$user_id = $_SESSION['user_id'];

$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
$product_type = isset($_POST['product_type']) ? $_POST['product_type'] : null;

if (!$product_id || !$product_type) {
    die("ข้อมูลไม่ครบ");
}

// ฟังก์ชันเพิ่มสินค้าลงตะกร้า
function addToCart($user_id, $product_id, $product_type, $conn)
{
    // 1. ตรวจสอบว่าผู้ใช้มีตะกร้าอยู่แล้วหรือไม่
    $sql = "SELECT Cart_ID FROM shopping_cart WHERE User_ID = ? AND Status = 'pending' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id); // ใช้ 's' สำหรับ string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // ถ้ามีตะกร้าอยู่แล้ว
        $cart_id = $row['Cart_ID'];
    } else {
        // ถ้ายังไม่มีตะกร้า สร้างตะกร้าใหม่
        $sql = "INSERT INTO shopping_cart (User_ID, Status) VALUES (?, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $cart_id = $stmt->insert_id; // ได้ Cart_ID ใหม่
    }

    // 2. ตรวจสอบและเพิ่มสินค้าลงใน cart_item
    if ($product_type === 'product') {
        // ตรวจสอบสินค้าจากตาราง product
        $sql = "SELECT product_ID FROM product WHERE product_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // เช็คว่ามีสินค้านี้ในตะกร้าแล้วหรือยัง
            $sql = "SELECT Item_ID FROM cart_item WHERE Cart_ID = ? AND Product_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $cart_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // ถ้ามีสินค้าแล้ว, ไม่เพิ่มจำนวนสินค้า (ไม่ทำอะไร)
                return "สินค้ามีอยู่ในตะกร้าแล้ว";
            } else {
                // ถ้ายังไม่มีสินค้าในตะกร้า, เพิ่มสินค้าใหม่ (1 ชิ้น)
                $sql = "INSERT INTO cart_item (Cart_ID, Product_ID, Quantity, type) VALUES (?, ?, 1, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iis", $cart_id, $product_id, $product_type);
                $stmt->execute();
                return "เพิ่มสินค้าลงในตะกร้าสำเร็จ";
            }
        } else {
            return "ไม่พบสินค้าในระบบ";
        }
    } else if ($product_type === 'artproduct') {
        // ตรวจสอบสินค้าจาก artproduct
        $sql = "SELECT Art_ID FROM artproduct WHERE Art_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // เช็คว่ามีงานศิลปะนี้ในตะกร้าแล้วหรือยัง
            $sql = "SELECT Item_ID FROM cart_item WHERE Cart_ID = ? AND Art_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $cart_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // ถ้ามีงานศิลปะแล้ว, ไม่เพิ่มจำนวนสินค้า (ไม่ทำอะไร)
                return "งานศิลปะนี้มีอยู่ในตะกร้าแล้ว";
            } else {
                // ถ้ายังไม่มีงานศิลปะในตะกร้า, เพิ่มงานศิลปะใหม่ (1 ชิ้น)
                $sql = "INSERT INTO cart_item (Cart_ID, Art_ID, Quantity, type) VALUES (?, ?, 1, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iis", $cart_id, $product_id, $product_type);
                $stmt->execute();
                return "เพิ่มงานศิลปะลงในตะกร้าสำเร็จ";
            }
        } else {
            return "ไม่พบงานศิลปะในระบบ";
        }
    } else {
        return "ประเภทสินค้าผิดพลาด";
    }

    return "เพิ่มสินค้าลงในตะกร้าสำเร็จ";
}

// เช็คว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$product_type = $_POST['product_type'];

// เรียกฟังก์ชันเพื่อเพิ่มสินค้าลงในตะกร้า
$result_message = addToCart($user_id, $product_id, $product_type, $conn);

// แสดงผลลัพธ์ที่ได้จากฟังก์ชัน
$_SESSION['add_to_cart_msg'] = $result_message;

// ปิดการเชื่อมต่อ
$conn->close();

// กลับไปหน้าตะกร้า
header("Location: CustomerAddtoCart.php");
exit();
?>
