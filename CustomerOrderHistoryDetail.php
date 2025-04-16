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
  <title>FrameArt | รายละเอียดคำสั่งซื้อ</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- External CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/navbar.css" />
  <link rel="stylesheet" href="CSS/CustomerDetailOrderHistory.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>

<body>
  <div class="layout expanded home-page">
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

      <!-- Order Detail Section -->
      <div class="order-detail-container">
        <h2 class="section-title"><i class="fas fa-file-invoice"></i> รายละเอียดคำสั่งซื้อ #12345</h2>

        <div class="order-summary">
          <div><strong>วันที่สั่งซื้อ:</strong> 10 เม.ย. 2025</div>
          <div><strong>สถานะ:</strong> <span class="status completed">สำเร็จ</span></div>
          <div><strong>วิธีชำระเงิน:</strong> โอนผ่านธนาคาร</div>
          <div><strong>ที่อยู่จัดส่ง:</strong> 123/45 หมู่บ้านสุขใจ เขตเมืองสุข จังหวัดกรุงเทพฯ</div>
        </div>

        <div class="product-list">
         <div class="product-header">
            <div>รูปภาพ</div>
            <div>สินค้า</div>
            <div>จำนวน</div>
            <div>ราคาต่อหน่วย</div>
            <div>รวม</div>
          </div>

  <!-- สินค้า 1 -->
        <div class="product-row">
            <div><img src="Picture/sayo-1.png" alt="กรอบรูป A" class="product-img"></div>
            <div>กรอบรูป A</div>
            <div>1</div>
            <div>350 บาท</div>
            <div>350 บาท</div>
          </div>

  <!-- สินค้า 2 -->
        <div class="product-row">
          <div><img src="Picture/sayo.png" alt="กรอบรูป B" class="product-img"></div>
          <div>กรอบรูป B</div>
          <div>2</div>
          <div>450 บาท</div>
          <div>900 บาท</div>
        </div>
      </div>

        <div class="total-section">
          <div><strong>ราคารวมทั้งหมด:</strong> <span class="total-price">1,250 บาท</span></div>
        </div>

        <div class="action-buttons">
          <a href="CustomerOrderHistory.php" class="btn-back"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
