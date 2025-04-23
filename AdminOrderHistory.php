<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Page</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminTableinfo.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="CSS/CustomerOrderHistory.css" />
    <!-- JQuery -->

    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>
    <script src="JS/texteditor.js" defer></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/loginNotify.js"></script>

</head>

<body>
    <div class="layout expanded home-page">


        <?php
        // เชื่อมต่อกับฐานข้อมูล
        include "database.php";
        // คำสั่ง SQL SELECT เพื่อดึงข้อมูลจากตาราง "topic"
        $sql = "SELECT * FROM product";
        $result = mysqli_query($conn, $sql);
        ?>


        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                        <?php include './Template/Header/AdminHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="admin-wrapper">

                <div class="left-menu">
                    <?php include './Template/LeftNavBar/AdminLeftNav.php'; ?>
                </div>





                <div class="admin-content">
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
            p.User_ID,
            c.Username AS customer_name 
          FROM purchases p
          LEFT JOIN customer c ON p.User_ID = c.User_ID
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
                echo '<p><strong>ID :</strong> ' . $order['User_ID'] . '</p>';
                echo '<p><strong>เบอร์โทร:</strong> ' . $order['Shipping_Phone'] . '</p>';
                echo '<p><strong>ที่อยู่:</strong> ' . $order['Shipping_Address'] . '</p>';
                echo '<p><strong>ราคารวม:</strong> ' . number_format($order['total_amount'], 2) . ' บาท</p>';
                echo '</div>';

                echo '<div class="order-footer">';
                echo '<a href="AdminOrderHistoryDetail.php?purchase_id=' . $order['purchase_id'] . '" class="btn-detail">';
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


                    <?php include './Template/popup/notificationPopup.php'; ?>
                </div>

            </div>
        </div>

    </div>
    </div>
</body>

</html>