<?php  
session_start();
header("Content-Type: text/html; charset=UTF-8");
include "database.php";



$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FrameArt | ประวัติการสั่งซื้อ</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- External CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/navbar.css" />
  <link rel="stylesheet" href="CSS/CustomerOrderHistory.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>

<body>
  <div class="layout expanded home-page">
    <?php include './Template/LeftNavBar/LeftNav.php'; ?>

    <div class="right-main">
      <!-- Top Navbar -->
      <div class="top-nav">
        <div class="inside">
          <div class="left-section"></div>
          <div class="right-section">
            <?php include './Template/Header/CustomerHeaderContent.php'; ?>
          </div>
        </div>
      </div>

      <!-- Purchase History Section -->
      <div class="order-history-container">
        <h2 class="section-title"><i class="fas fa-box-open"></i> ประวัติการสั่งซื้อ</h2>

        <?php
        // Fetch purchase data with customer details
        $sql = "
          SELECT 
            p.purchase_id, 
            p.purchase_date, 
            p.total_amount, 
            p.status, 
            p.Shipping_Phone,
            p.Shipping_Address,
            c.Username AS customer_name 
          FROM purchases p
          LEFT JOIN customer c ON p.User_ID = c.User_ID
          WHERE p.User_ID = '$user_id'
          ORDER BY p.purchase_id DESC
        ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($order = mysqli_fetch_assoc($result)) {
                echo '<div class="order-card">';
                echo '<div class="order-header">';
                echo '<div>';
                echo '<p class="order-id"><i class="fas fa-receipt"></i> คำสั่งซื้อ #' . $order['purchase_id'] . '</p>';
                echo '<p class="order-date"><i class="fa-regular fa-calendar-days"></i> ' . date("d M Y", strtotime($order['purchase_date'])) . '</p>';
                echo '</div>';
                echo '<div class="order-status ' . ($order['status'] === 'paid' ? 'completed' : 'pending') . '">' . ($order['status'] === 'paid' ? 'ชำระเงินแล้ว' : 'รอดำเนินการ') . '</div>';
                echo '</div>';

                echo '<div class="order-details">';
                echo '<p><strong>ชื่อผู้ซื้อ:</strong> ' . $order['customer_name'] . '</p>';
                echo '<p><strong>เบอร์โทร:</strong> ' . $order['Shipping_Phone'] . '</p>';
                echo '<p><strong>ที่อยู่:</strong> ' . $order['Shipping_Address'] . '</p>';
                echo '<p><strong>ราคารวม:</strong> ' . number_format($order['total_amount'], 2) . ' บาท</p>';
                echo '</div>';

                echo '<div class="order-footer">';
                echo '<a href="CustomerOrderHistoryDetail.php?purchase_id=' . $order['purchase_id'] . '" class="btn-detail">';
                echo '<i class="fas fa-eye"></i> ดูรายละเอียด';
                echo '</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-orders">ไม่มีประวัติการสั่งซื้อ</p>';
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>