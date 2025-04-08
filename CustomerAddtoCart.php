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
  <link rel="stylesheet" href="CSS/CustomerAddtoCart.css" />

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

      <!-- Main Content Section -->
      <main class="content">
  <div class="cart-layout">
    <!-- ส่วนแสดงสินค้า -->
    <div class="cart-items">
      <h2>Shopping Cart</h2>
      <div class="cart-item">
        <img src="Picture/framecustomreserve.jpg" alt="กรอบรูปมินิมอล" />
        <div class="item-details">
          <h4>กรอบรูปมินิมอล</h4>
          <p>฿299</p>
          <div class="qty-edit">
          </div>
          <p class="item-total">รวม: ฿598</p>
          <button class="remove-btn"><i class="fas fa-trash-alt"></i> ลบ</button>
        </div>
      </div>

      <div class="cart-item">
        <img src="Picture/framecustomreserve.jpg" alt="กรอบรูปวินเทจ" />
        <div class="item-details">
          <h4>กรอบรูปวินเทจ</h4>
          <p>฿450</p>
          <div class="qty-edit">
          </div>
          <p class="item-total">รวม: ฿450</p>
          <button class="remove-btn"><i class="fas fa-trash-alt"></i> ลบ</button>
        </div>
      </div>
    </div>

    <!-- สรุปคำสั่งซื้อ -->
    <div class="order-summary">
      <h2>Order Summary</h2>
      <div class="summary-detail">
        <p>Items <span>2</span></p>
        <p>Shipping <span>Standard Delivery - ฿5.00</span></p>
      </div>


      <div class="total-summary">
        <p>Total Cost <span>฿1,048</span></p>
      </div>
      <a href="#" class="checkout-button">Checkout</a>
    </div>
  </div>
</main>

</body>
</html>

