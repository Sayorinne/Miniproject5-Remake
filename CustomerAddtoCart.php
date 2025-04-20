<?php
session_start();
include "database.php";
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey(
  'sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v'
);

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือยัง
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FrameArt - Shopping Cart</title>
  <!-- ใส่ลิงก์ CSS ที่เกี่ยวข้อง -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/post.css" />
  <link rel="stylesheet" href="CSS/navbar.css" />
  <link rel="stylesheet" href="CSS/CustomerAddtoCart.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <script src="JS/profile.js" defer></script>
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

      <main class="content">
        <div class="cart-layout">
          <!-- รายการสินค้า -->
          <div class="cart-items">
            <h2>Shopping Cart</h2>

            <?php
            $total = 0;
            $item_count = 0;

            if (isset($_SESSION['add_to_cart_msg'])) {
              echo "<script>alert('" . $_SESSION['add_to_cart_msg'] . "');</script>";
              unset($_SESSION['add_to_cart_msg']);
            }

            $user_id = $_SESSION['user_id'];

            // ดึงสินค้าทั้งจาก product และ artproduct ที่อยู่ในตะกร้าของ user
            $sql = "
            SELECT ci.Item_ID, ci.Cart_ID, ci.Quantity, sc.User_ID, ci.Product_ID, NULL AS Art_ID,
                   p.product_name, p.product_price, p.product_image
            FROM cart_item ci
            JOIN shopping_cart sc ON ci.Cart_ID = sc.Cart_ID
            LEFT JOIN product p ON ci.Product_ID = p.product_ID
            WHERE sc.User_ID = ? AND sc.Status = 'pending' AND ci.Product_ID IS NOT NULL
            
            UNION
            
            SELECT ci.Item_ID, ci.Cart_ID, ci.Quantity, sc.User_ID, NULL AS Product_ID, ci.Art_ID,
                   a.art_name AS product_name, a.art_price AS product_price, a.art_image AS product_image
            FROM cart_item ci
            JOIN shopping_cart sc ON ci.Cart_ID = sc.Cart_ID
            LEFT JOIN artproduct a ON ci.Art_ID = a.Art_ID
            WHERE sc.User_ID = ? AND sc.Status = 'pending' AND ci.Art_ID IS NOT NULL
            ";


            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $user_id, $user_id); // ใช้ bind_param เพื่อป้องกัน SQL Injection
            $stmt->execute();
            $result = $stmt->get_result(); // ใช้ get_result() เพื่อดึงผลลัพธ์
            
            // วนลูปแสดงรายการสินค้าทั้งจาก product และ artproduct
            while ($row = mysqli_fetch_assoc($result)):
              $subtotal = $row['product_price'] * $row['Quantity'];
              $total += $subtotal;
              $item_count++;

              $line_items[] = [
                'price_data' => [
                  'currency' => 'thb',
                  'unit_amount' => intval($row['product_price'] * 100), // Convert to cents and ensure it's an integer
                  'product_data' => [
                    'name' => $row['product_name'],
                    'images' => ["Picture/" . $row['product_image']],
                  ],
                ],
                'quantity' => $row['Quantity'],
              ];
              ?>


              <div class="cart-item">
                <img src="Picture/<?php echo htmlspecialchars($row['product_image']); ?>"
                  alt="<?php echo htmlspecialchars($row['product_name']); ?>" />
                <div class="item-details">
                  <h4><?php echo htmlspecialchars($row['product_name']); ?></h4>
                  <p>฿<?php echo number_format($row['product_price'], 2); ?></p>
                  <p class="item-total">รวม: ฿<?php echo number_format($subtotal, 2); ?></p>

                  <form method="POST" action="RemoveFromCart.php" onsubmit="return confirm('ยืนยันลบสินค้า?');">
                    <input type="hidden" name="item_id" value="<?php echo $row['Item_ID']; ?>">
                    <button class="remove-btn" type="submit"><i class="fas fa-trash-alt"></i> ลบ</button>
                  </form>

                </div>
              </div>
            <?php endwhile; ?>

            <?php if ($item_count === 0): ?>
              <p>ไม่มีสินค้าในตะกร้า</p>
            <?php endif; ?>
          </div>

          <!-- สรุปคำสั่งซื้อ -->
          <div class="order-summary">
            <h2>Order Summary</h2>
            <div class="summary-detail">
              <p>Items <span><?php echo $item_count; ?></span></p>
              <p>Shipping <span>Standard Delivery - ฿5.00</span></p>
            </div>

            <div class="total-summary">
              <p>Total Cost <span>฿<?php echo number_format($total + 5, 2); ?></span></p>
            </div>

                       <?php if ($item_count > 0): ?>
              <button id="checkout-button" class="checkout-button">Checkout</button>
            
              <script src="https://js.stripe.com/v3/"></script>
              <script>
                var stripe = Stripe('pk_test_51QomvwR3rIyanQnHkPyYWIyo5FnRCpgpenwgL03fcXqaPxeQLhkGgBu6zf0d0NqDUWwVLJ1utdFWI3nN943s16zX00OgH5GqTv');
                var checkoutButton = document.getElementById('checkout-button');
            
                checkoutButton.addEventListener('click', function() {
                  // Create an array of product IDs and quantities
                  var items = [
                    <?php
                    mysqli_data_seek($result, 0); // Reset the result pointer
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "{id: '" . $row['Product_ID'] . "', quantity: " . $row['Quantity'] . "},";
                    }
                    ?>
                  ];
            
                  // Send the cart data to create-checkout-session.php
                  fetch('create-checkout-session.php', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ items: items })
                  })
                  .then(function(response) {
                    return response.json();
                  })
                  .then(function(session) {
                    return stripe.redirectToCheckout({ sessionId: session.id });
                  })
                  .then(function(result) {
                    if (result.error) {
                      alert(result.error.message);
                    }
                  })
                  .catch(function(error) {
                    console.error('Error:', error);
                  });
                });
              </script>
            <?php endif; ?>
          </div>
        </div>

        <?php
        $stripeSessionId = '';
        if (isset($_POST['checkout']) && !empty($line_items)) {
          try {
            $session = \Stripe\Checkout\Session::create([
              'payment_method_types' => ['card'],
              'line_items' => $line_items,
              'mode' => 'payment',
              'success_url' => 'http://localhost/MiniProject5/payment-success.php',
              'cancel_url' => 'http://localhost/MiniProject5/payment-cancel.php',
              'shipping_address_collection' => [
                'allowed_countries' => ['TH'],
              ],
              'phone_number_collection' => [
                'enabled' => true,
              ],
            ]);
            $stripeSessionId = $session->id;
          } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error
            echo 'Error: ' . $e->getMessage();
          }
        }
        ?>


      </main>
    </div>
  </div>
</body>

</html>