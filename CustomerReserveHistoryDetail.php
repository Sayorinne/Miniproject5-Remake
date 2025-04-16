<?php
session_start();
include "database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FrameArt</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- External CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/post.css" />
  <link rel="stylesheet" href="CSS/navbar.css" />
  <link rel="stylesheet" href="CSS/CustomerDetailHistoryReserve.css" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet" />

  

  <!-- JavaScript -->
  <script src="JS/profile.js" defer></script>
</head>

<body>
  <div class="layout expanded home-page">
    <!-- Left Menu -->
    <?php include './Template/LeftNavBar/LeftNav.php'; ?>

    <div class="right-main">
      <div class="top-nav">
        <div class="inside">
          <div class="left-section"></div>
          <div class="right-section">
            <?php include './Template/Header/CustomerHeaderContent.php'; ?>
          </div>
        </div>
      </div>

      <!-- Booking Detail Section -->
      <div class="booking-detail">
  <h2>รายละเอียดการจอง</h2>
  <div class="detail-card">
    <div class="detail-row">
      <span class="label">รหัสการจอง:</span>
      <span class="value">#B00123</span>
    </div>
    <div class="detail-row">
      <span class="label">วันที่จอง:</span>
      <span class="value">08/04/2025</span>
    </div>
    <div class="detail-row">
      <span class="label">เวลา:</span>
      <span class="value">13:00</span>
    </div>
    <div class="detail-row">
      <span class="label">บริการ:</span>
      <span class="value">ใส่กรอบภาพ</span>
    </div>
    <div class="detail-row">
      <span class="label">สถานะ:</span>
      <span class="value"><span class="status pending">รอดำเนินการ</span></span>
    </div>
    <div class="detail-row">
      <span class="label">หมายเหตุ:</span>
      <span class="value">ลูกค้าต้องการกรอบไม้สีเข้ม ขนาด 16x20 นิ้ว</span>
    </div>

    <div class="button-group">
      <button class="btn-back" onclick="history.back()">ย้อนกลับ</button>
      <button class="btn-cancel">ยกเลิกการจอง</button>
    </div>
  </div>
</div>



</body>
</html>