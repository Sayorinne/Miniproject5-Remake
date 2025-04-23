<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
include "database.php";

$user_id = $_SESSION['User_ID'];
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
       <?php
       // Get the purchase ID from the query parameter
$purchase_id = isset($_GET['purchase_id']) ? intval($_GET['purchase_id']) : 0;

// Fetch purchase details
$sql_purchase = "
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
    WHERE p.purchase_id = $purchase_id
";
$result_purchase = mysqli_query($conn, $sql_purchase);
$purchase = mysqli_fetch_assoc($result_purchase);

// Fetch purchase items (from both artproduct and product tables)
$sql_items = "
    SELECT 
        pi.Quantity, 
        ap.Art_name AS item_name, 
        ap.Art_price AS item_price, 
        ap.Art_image AS item_image 
    FROM purchase_items pi
    LEFT JOIN artproduct ap ON pi.Art_ID = ap.Art_ID
    WHERE pi.Purchase_ID = $purchase_id AND pi.Art_ID IS NOT NULL

    UNION

    SELECT 
        pi.Quantity, 
        p.product_name AS item_name, 
        p.product_price AS item_price, 
        p.product_image AS item_image 
    FROM purchase_items pi
    LEFT JOIN product p ON pi.product_ID = p.product_ID
    WHERE pi.Purchase_ID = $purchase_id AND pi.product_ID IS NOT NULL
";
$result_items = mysqli_query($conn, $sql_items);
?>
      <div class="order-detail-container">
        <h2 class="section-title"><i class="fas fa-file-invoice"></i> รายละเอียดคำสั่งซื้อ
          #<?php echo $purchase['purchase_id']; ?></h2>

        <div class="order-summary">
          <div><strong>วันที่สั่งซื้อ:</strong> <?php echo date("d M Y", strtotime($purchase['purchase_date'])); ?>
          </div>
          <div><strong>สถานะ:</strong> <span
              class="status <?php echo $purchase['status'] === 'paid' ? 'completed' : 'pending'; ?>">
              <?php echo $purchase['status'] === 'paid' ? 'สำเร็จ' : 'รอดำเนินการ'; ?>
            </span></div>
          <div><strong>ที่อยู่จัดส่ง:</strong> <?php echo $purchase['Shipping_Address']; ?></div>
          <div><strong>เบอร์โทร:</strong> <?php echo $purchase['Shipping_Phone']; ?></div>
        </div>

        <div class="product-list">
          <div class="product-header">
            <div>รูปภาพ</div>
            <div>สินค้า</div>
            <div>จำนวน</div>
            <div>ราคาต่อหน่วย</div>
            <div>รวม</div>
          </div>

          <?php while ($item = mysqli_fetch_assoc($result_items)) { ?>
            <div class="product-row">
              <div>
                <img src="Picture/<?php echo !empty($item['item_image']) ? $item['item_image'] : 'default-image.png'; ?>"
                  alt="<?php echo $item['item_name']; ?>" class="product-img">
              </div>
              <div><?php echo $item['item_name']; ?></div>
              <div><?php echo $item['Quantity']; ?></div>
              <div><?php echo number_format($item['item_price'], 2); ?> บาท</div>
              <div><?php echo number_format($item['Quantity'] * $item['item_price'], 2); ?> บาท</div>
            </div>
          <?php } ?>
        </div>

        <div class="total-section">
          <div><strong>ราคารวมทั้งหมด:</strong> <span
              class="total-price"><?php echo number_format($purchase['total_amount'], 2); ?> บาท</span></div>
        </div>

        <div class="action-buttons">
          <a href="CustomerOrderHistory.php" class="btn-back"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>