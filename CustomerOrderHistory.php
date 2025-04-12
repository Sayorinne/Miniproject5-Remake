<?php  
session_start();
header("Content-Type: text/html; charset=UTF-8");
include "database.php";
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

      <!-- Order History Section -->
      <div class="order-history-container">
        <h2 class="section-title"><i class="fas fa-box-open"></i> ประวัติการสั่งซื้อ</h2>

        <!-- ตัวอย่างคำสั่งซื้อ -->
        <div class="order-card">
          <div class="order-header">
            <div>
              <p class="order-id"><i class="fas fa-receipt"></i> คำสั่งซื้อ #12345</p>
              <p class="order-date"><i class="fa-regular fa-calendar-days"></i> 10 เม.ย. 2025</p>
            </div>
            <div class="order-status completed">สำเร็จ</div>
          </div>

          <div class="order-details">
            <p><strong>สินค้า:</strong> กรอบรูป A, B, C</p>
            <p><strong>จำนวน:</strong> 3 ชิ้น</p>
            <p><strong>ราคารวม:</strong> 1,250 บาท</p>
          </div>

          <div class="order-footer">
          <a href="CustomerDetailOrderHistory.php?order_id=12345" class="btn-detail">
      <i class="fas fa-eye"></i> ดูรายละเอียด
    </a>

          </div>
        </div>

        <!-- เพิ่ม order-card ซ้ำได้ในลูป -->

        <!-- คำสั่งซื้อใหม่ -->
        <div class="order-card">
           <div class="order-header">
          <div>
            <p class="order-id"><i class="fas fa-receipt"></i> คำสั่งซื้อ #12346</p>
            <p class="order-date"><i class="fa-regular fa-calendar-days"></i> 12 เม.ย. 2025</p>
          </div>
           <div class="order-status pending">รอดำเนินการ</div>
          </div>

          <div class="order-details">
            <p><strong>สินค้า:</strong> กรอบรูป D, E</p>
            <p><strong>จำนวน:</strong> 2 ชิ้น</p>
            <p><strong>ราคารวม:</strong> 850 บาท</p>
          </div>

    <div class="order-footer">
    <a href="CustomerDetailOrderHistory.php?order_id=12345" class="btn-detail">
      <i class="fas fa-eye"></i> ดูรายละเอียด
    </a>


        </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
