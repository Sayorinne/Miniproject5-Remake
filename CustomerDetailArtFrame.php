<?php
session_start();
include "database.php";
require 'vendor/autoload.php';

$user_id = $_SESSION['user_id'];

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    // Corrected SQL Query with JOIN to fetch Category_name
    $sql = "SELECT product.*, product_type.Category_name 
            FROM product
            JOIN product_type ON product.Category_ID = product_type.Category_ID
            WHERE product.product_ID = '$id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "No Product";
        exit();
    }
} else {
    echo "No product_ID";
    exit();
}

// Debugging: Check fetched data
// echo "<pre>"; print_r($row); echo "</pre>"; exit();

\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'thb',
                'product_data' => [
                    'name' => htmlspecialchars($row['product_name']),
                ],
                'unit_amount' => intval(floatval($row['product_price']) * 100),
            ],
            'quantity' => 1,
        ]
    ],
    'mode' => 'payment',
    'success_url' => 'https://2837-134-236-161-121.ngrok-free.app/MiniProject5/payment-success.php',  // Update this URL for production or ngrok
    'cancel_url' => 'https://2837-134-236-161-121.ngrok-free.app/MiniProject5/payment-failed.php',
    'payment_intent_data' => [
        'metadata' => [
            'user_id' => $user_id,
            'from_cart' => 'no',
            'product_id' => $row['product_ID'], 
            'product_type' => 'product', // or 'artproduct'
            'quantity' => 1
        ]

    ],
    'shipping_address_collection' => [
        'allowed_countries' => ['TH'], // Add other country codes as needed
    ],
    'phone_number_collection' => [
        'enabled' => true,
    ],
    'customer_creation' => 'always',
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
    <script src="JS/profile.js" defer></script>
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
                            <img src="Picture/<?php echo htmlspecialchars($row['product_image']); ?>"
                                alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                        </div>
                    </div>


                    <div class="right-box">
                        <div class="product-info">
                            <h2 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h2>
                            <p class="product-description">รายละเอียดสินค้า: <?php echo $row['detail']; ?></p>
                            <p class="product-specs">
                                <?php echo "ขนาด : " . htmlspecialchars($row['product_size']) .
                                    " | สี : " . htmlspecialchars($row['product_color']) .
                                    " | ประเภท : " . htmlspecialchars($row['Category_name']); ?>
                            </p>
                        </div>


                        <div class="product-pricing">
                            <div class="price"><?php echo number_format($row['product_price'], 2); ?> ฿</div>
                        </div>


                        <div class="action-buttons">
                            <form method="POST" action="AddToCart.php">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_ID']; ?>">
                                <input type="hidden" name="product_type" value="product">
                                <button type="submit" class="add-to-cart">เพิ่มตะกร้า</button>
                            </form>
                            <button id="checkout-button" class="buy-now">ซื้อสินค้า</button>
                        </div>
                    </div>
                </div>

                <?php
                $related_sql = "SELECT product_ID, product_name, product_price, product_image 
                                FROM product 
                                WHERE product_ID != '$id' 
                                ORDER BY RAND() 
                                LIMIT 4";
                $related_result = mysqli_query($conn, $related_sql);

                if ($related_result && mysqli_num_rows($related_result) > 0): ?>
                    <div class="below-box">
                        <h3>สินค้าแนะนำ</h3>
                        <div class="recommended-products">
                            <?php while ($related_row = mysqli_fetch_assoc($related_result)): ?>
                                <a href="CustomerDetailArtFrame.php?id=<?php echo $related_row['product_ID']; ?>"
                                    class="product-card">
                                    <img src="Picture/<?php echo htmlspecialchars($related_row['product_image']); ?>"
                                        alt="<?php echo htmlspecialchars($related_row['product_name']); ?>">
                                    <h4 class="product-name"><?php echo htmlspecialchars($related_row['product_name']); ?></h4>
                                    <p class="product-price"><?php echo number_format($related_row['product_price'], 2); ?>฿</p>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No recommended products found.</p>
                <?php endif; ?>
            </main>

        </div>
    </div>

    <script>
        var stripe = Stripe('pk_test_51QomvwR3rIyanQnHkPyYWIyo5FnRCpgpenwgL03fcXqaPxeQLhkGgBu6zf0d0NqDUWwVLJ1utdFWI3nN943s16zX00OgH5GqTv');
        var checkoutButton = document.getElementById('checkout-button');

        checkoutButton.addEventListener('click', function () {
            stripe.redirectToCheckout({
                sessionId: '<?php echo $stripeSessionId; ?>'
            })
                .then(function (result) {
                    if (result.error) {
                        alert(result.error.message);
                    }
                });
        });
    </script>
</body>

</html>