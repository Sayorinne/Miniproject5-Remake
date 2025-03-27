<?php
session_start();
include "database.php";
require 'vendor/autoload.php';

$id = $_GET['id'] ?? null; 
if (!$id) {
    die("Error: No product ID provided.");
}


$sql = "SELECT * FROM artproduct WHERE Art_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Error: Product not found.");
}


\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');


$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'thb',
                'product_data' => [
                    'name' => htmlspecialchars($row['Art_name']), 
                ],
                'unit_amount' => intval(floatval($row['Art_price']) * 100),
            ],
            'quantity' => 1,
        ]
    ],
    'mode' => 'payment',
    'success_url' => 'http://localhost/MiniProject5/success.php',
    'cancel_url' => 'http://localhost/MiniProject5/cancel.php',
]);


$stripeSessionId = $session->id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrameArt</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/CustomerProductDetail.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->
    <script 
    src="JS/profile.js" defer>
    </script>
    
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>


<div class="layout expanded home-page">
        <!-- Left Menu -->
        <?php include './Template/LeftNavBar/LeftNav.php'; ?>

        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-section">
                    </div>
                    <div class="right-section">
                        <?php include './Template/Header/CustomerHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <main class="content-container">
                <div class="product-detail-container">

                    <div class="left-box">
                        <div class="product-image">
                            <img src="Picture/<?php echo htmlspecialchars($row['Art_image']); ?>" 
                                alt="<?php echo htmlspecialchars($row['Art_name']); ?>">
                        </div>
                    </div>

    
                    <div class="right-box">
                        <div class="product-info">
                            <h2 class="product-title"><?php echo htmlspecialchars($row['Art_name']); ?></h2>
                            <p class="product-description">รายละเอียดสินค้า: <?php echo $row['detail']; // ALLOW HTML ?></p>
                            <p class="product-specs">
                                <?php echo "ขนาด : " . htmlspecialchars($row['Art_size']) . 
                                          " | สี : " . htmlspecialchars($row['Art_color']); ?>
                            </p>
                        </div>

                        <div class="product-pricing">
                            <div class="price"><?php echo number_format($row['Art_price'], 2); ?> ฿</div>
                        </div>


                        <div class="action-buttons">
                            <button class="add-to-cart">เพิ่มตะกร้า</button>
                            <button id="checkout-button" class="buy-now">ซื้อสินค้า</button>
                        </div>
                    </div>
                </div>


                <?php
                $related_sql = "SELECT Art_ID, Art_name, Art_price, Art_image 
                                FROM artproduct 
                                WHERE Art_ID != ? 
                                ORDER BY RAND() 
                                LIMIT 4";
                $stmt = $conn->prepare($related_sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $related_result = $stmt->get_result();

                if ($related_result->num_rows > 0): ?>
                    <div class="below-box">
                        <h3>สินค้าแนะนำ</h3>
                        <div class="recommended-products">
                            <?php while ($related_row = $related_result->fetch_assoc()): ?>
                                <a href="CustomerDetailworkart.php?id=<?php echo $related_row['Art_ID']; ?>"
                                    class="product-card">
                                    <img src="Picture/<?php echo htmlspecialchars($related_row['Art_image']); ?>"
                                        alt="<?php echo htmlspecialchars($related_row['Art_name']); ?>">
                                    <h4 class="product-name"><?php echo htmlspecialchars($related_row['Art_name']); ?></h4>
                                    <p class="product-price"><?php echo number_format($related_row['Art_price'], 2); ?>฿</p>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p>ไม่มีสินค้าอื่นๆ</p>
                <?php endif; ?>
            </main>

        </div>
    </div>

    <script>
        var stripe = Stripe('pk_test_51QomvwR3rIyanQnHkPyYWIyo5FnRCpgpenwgL03fcXqaPxeQLhkGgBu6zf0d0NqDUWwVLJ1utdFWI3nN943s16zX00OgH5GqTv');
        var checkoutButton = document.getElementById('checkout-button');

        checkoutButton.addEventListener('click', function () {
            stripe.redirectToCheckout({ sessionId: '<?php echo $stripeSessionId; ?>' })
                .then(function (result) {
                    if (result.error) {
                        alert(result.error.message);
                    }
                });
        });
    </script>
</body>

</html>