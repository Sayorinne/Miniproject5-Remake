<?php
$user = null; // Initialize $user as null

// Create a separate database connection for the header
$header_conn = new mysqli("localhost", "root", "26102540c", "frameart_db");

$cart_count = 0; // Initialize cart count

if (isset($_SESSION['user_id'])) {
    $User_ID = $_SESSION['user_id'];
    
    // Fetch user details
    $sql_user = "SELECT * FROM customer WHERE User_ID = '$User_ID'";
    $result_user = $header_conn->query($sql_user);

    if ($result_user && $result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
    }

    // Fetch cart item count for the user's active cart
    $sql_cart = "
        SELECT COUNT(ci.Item_ID) AS cart_count 
        FROM cart_item ci
        INNER JOIN shopping_cart sc ON ci.Cart_ID = sc.Cart_ID
        WHERE sc.User_ID = '$User_ID' AND (sc.Status IS NULL OR sc.Status = 'pending')
    ";
    $result_cart = $header_conn->query($sql_cart);

    if ($result_cart && $result_cart->num_rows > 0) {
        $cart_data = $result_cart->fetch_assoc();
        $cart_count = $cart_data['cart_count'];
    }
}
// Close the header connection to avoid conflicts
$header_conn->close()


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="JS/profile.js" defer></script>

<div class="shopping-cart-icon">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="CustomerAddtoCart.php" class="cart-link">
            <i class="fa fa-shopping-cart" style="font-size: 24px; position: relative;">
                <?php if ($cart_count > 0): ?>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </i>
        </a>
    <?php endif; ?>
</div>

<div class="profile-icon">
    <!-- Account validate -->
    <?php if ($user): ?>
        <div class="profile-image">
            <img src="Picture/<?php echo htmlspecialchars($user['customer_image']); ?>" id="image-preview" style="max-width: 200px;" onclick="toggloeMenu()">
        </div>
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="Picture/<?php echo htmlspecialchars($user['customer_image']); ?>" id="image-preview" style="max-width: 200px;">
                    <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                    <h3>ID: <?php echo htmlspecialchars($_SESSION['user_id']); ?></h3>
                </div>
                <hr>
                <a href="CustomerProfile.php" class="sub-menu-link">
                <i class="fa fa-edit" style="margin-right: 20px" ></i>
                    <p>แก้ไขโปรไฟล์</p>
                </a>
                <a href="logout.php" class="sub-menu-link">
                <i class="fa fa-sign-out" style="margin-right: 20px"></i>
                    <p>ออกจากระบบ</p>
                </a>
            </div>
        </div>
    <?php else: ?>
        <a role="button" tabindex="0" href="login.php" class="login-button btn btn-primary">
            <span>ล็อคอิน</span>
        </a>
        <a role="button" tabindex="0" href="registration.php" class="login-button btn btn-primary">
            <span>สมัครสมาชิก</span>
        </a>
    <?php endif; ?>
</div>

<style>
/* Style for the cart icon and count */
.shopping-cart-icon {
    position: relative;
    display: inline-block;
}

.cart-link {
    text-decoration: none;
    color: inherit;
}

.cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    padding: 2px 6px;
    line-height: 1;
}
</style>