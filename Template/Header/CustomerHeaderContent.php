<div class="shopping-cart-icon">
    <?php if (isset($_SESSION['user_id'])): ?>
        <h5>คำสั่งซื้อทั้งหมด</h5>
    <?php endif; ?>
</div>
<div class="profile-icon">
    <!-- Account validate -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="profile-image">
        <img src="Picture/<?php echo htmlspecialchars($user['customer_image']); ?>" id="image-preview" style="max-width: 200px;"onclick="toggloeMenu()">
        </div>
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="Picture/<?php echo htmlspecialchars($user['customer_image']); ?>" id="image-preview" style="max-width: 200px;">
                    <h2><?php echo $_SESSION['username']; ?></h2>
                    <h3>ID:<?php echo $_SESSION['user_id']; ?></h3>
                </div>
                <hr>
                <a href="CustomerProfile.php" class="sub-menu-link">
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