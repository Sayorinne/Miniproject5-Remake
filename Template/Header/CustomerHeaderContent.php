<?php
$user = null; // Initialize $user as null

// Create a separate database connection for the header
$header_conn = new mysqli("localhost", "root", "26102540c", "frameart_db");

if ($header_conn->connect_error) {
    die("Connection failed: " . $header_conn->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $User_ID = $_SESSION['user_id'];
    $sql = "SELECT * FROM customer WHERE User_ID = '$User_ID'";
    $result = $header_conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

// Close the header connection to avoid conflicts
$header_conn->close();
?>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="shopping-cart-icon">
    <?php if (isset($_SESSION['user_id'])): ?>
        <h5>คำสั่งซื้อทั้งหมด</h5>
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