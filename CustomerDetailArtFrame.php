<?php
session_start();
include "database.php";
require 'vendor/autoload.php';

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

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


\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'thb',
                'product_data' => [
                    'name' => $row['product_name'],
                ],
                'unit_amount' => $row['product_price'] * 100,
            ],
            'quantity' => 1,
        ]
    ],
    'mode' => 'payment',
    'success_url' => 'http://localhost/success.php',
    'cancel_url' => 'http://localhost/cancel.php',
]);

echo json_encode(['id' => $session->id]);

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
        <div class="left-menu">
            <div class="logo">
                <a href="#">
                    <img src="Picture/logoframeart.png" style="width: 200px;">
                </a>
                <hr>
                <div class="left-menu-content">
                    <div class="ms-auto nav">
                        <a href="CustomerHomepage.php">
                            <span class="nav-link"><span>หน้าหลัก</span></span>
                        </a>
                        <a aria-current="page" href="CustomerArtFrame.php">
                            <span class="nav-link"><span>กรอบรูป</span></span>
                        </a>
                        <a href="CustomerWorkart.php">
                            <span class="nav-link"><span>งานศิลป์</span></span>
                        </a>
                        <a href="CustomerReservation.php">
                            <span class="nav-link"><span>จองคิว</span></span>
                        </a>
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-section">
                        <h1>กรอบรูป "<?php echo $row['product_name']; ?>"</h1>
                    </div>
                    <div class="right-section">
                        <div class="shopping-cart-icon">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <h5>คำสั่งซื้อทั้งหมด</h5>
                            <?php endif; ?>
                        </div>
                        <div class="profile-icon">
                            <!-- Account validate -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <div class="profile-image">
                                    <img src="Picture/sayo.png" onclick="toggloeMenu()">
                                </div>
                                <div class="sub-menu-wrap" id="subMenu">
                                    <div class="sub-menu">
                                        <div class="user-info">
                                            <img src="Picture/sayo.png">
                                            <h2><?php echo $_SESSION['username']; ?></h2>
                                            <h3>ID:<?php echo $_SESSION['user_id']; ?></h3>
                                        </div>
                                        <hr>
                                        <a href="#" class="sub-menu-link">
                                            <img src="images/profile.png">
                                            <p>Edit Profile</p>
                                            <span></span>
                                        </a>
                                        <a href="logout.php" class="sub-menu-link">
                                            <img src="images/profile.png">
                                            <p>Logout</p>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a role="button" tabindex="0" href="login.php" class="login-button btn btn-primary">
                                    <span>Login</span>
                                </a>
                                <a role="button" tabindex="0" href="registration.php" class="login-button btn btn-primary">
                                    <span>Register</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <main class="content-container">
                <div class="product-detail-container">
                    <!-- Left Box: Product Image -->
                    <div class="left-box">
                        <div class="product-image">
                            <img src="Picture/<?php echo htmlspecialchars($row['product_image']); ?>"
                                alt="Product Image">
                        </div>
                    </div>

                    <!-- Right Box: Product Information -->
                    <div class="right-box">
                        <div class="product-info">
                            <h2 class="product-title"><?php echo $row['product_name']; ?></h2>
                            <p class="product-description">รายละเอียดสินค้า: <?php echo $row['detail']; ?></p>
                            <p class="product-specs">
                                <?php echo "ขนาด:" . $row['product_size'] . " | สี:" . $row['product_color'] . " | ประเภท:" . $row['Category_name']; ?>
                            </p>
                        </div>

                        <!-- Price and Availability -->
                        <div class="product-pricing">
                            <div class="price"><?php echo $row['product_price']; ?> ฿</div>
                        </div>

                        <div>
                            <label for="quantity">จำนวน:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
                        </div>

                        <!-- Actions -->
                        <div class="action-buttons">
                            <button class="add-to-cart">เพิ่มตะกร้า</button>
                            <button id="checkout-button" class="buy-now">ซื้อสินค้า</button>
                        </div>
                    </div>
                </div>

                <!-- Below Box: Recommended Products -->
                <?php
                // ดึงสินค้าที่เกี่ยวข้อง (ยกเว้นตัวเอง) จำนวน 4 รายการ
                $related_sql = "SELECT product_ID, product_name, product_price, product_image 
                    FROM product 
                    WHERE product_ID != '$id' 
                    ORDER BY RAND() 
                    LIMIT 4";
                $related_result = mysqli_query($conn, $related_sql);

                if ($related_result && mysqli_num_rows($related_result) > 0): ?>
                    <div class="below-box">
                        <h3>Recommended Products</h3>
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
            fetch('./create-checkout-session.php?id=<?php echo $id; ?>', {
                method: 'POST',
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (session) {
                    return stripe.redirectToCheckout({ sessionId: session.id });
                })
                .then(function (result) {
                    if (result.error) {
                        alert(result.error.message);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });
        });
    </script>
</body>

</html>