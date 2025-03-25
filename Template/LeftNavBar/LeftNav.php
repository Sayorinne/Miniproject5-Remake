<?php
// Fetch categories from the product_type table
$categories = [];
$sql = "SELECT Category_name FROM product_type";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['Category_name'];
    }
} else {
    $categories = ["No categories found"]; // Fallback if no categories are found
}

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="CSS/navbar.css">
<link rel="stylesheet" href="CSS/miniTagSearch.css">
<script src="JS/tagFilter.js" defer></script>

<div class="left-menu">
    <div class="logo">
        <a href="#">
            <img src="Picture/logoframeart.png" style="width: 200px;">
        </a>
        <hr>
        <div class="left-menu-content">
            <div class="ms-auto nav">
                <a href="CustomerHomepage.php" <?php echo $current_page === 'CustomerHomepage.php' ? 'aria-current="page"' : ''; ?>>
                    <span class="nav-link"><span>หน้าหลัก</span></span>
                </a>

                <!-- Sub-menu with categories from the database -->
                <div class="nav-item" onmouseenter="openMenu()" onmouseleave="closeMenu()">
                    <a href="CustomerArtFrame.php" <?php echo $current_page === 'CustomerArtFrame.php' ? 'aria-current="page"' : ''; ?>>
                        <span class="nav-link"><span>กรอบรูป</span></span>
                    </a>
                    <div id="categorySubMenu" class="submenu">
                        <?php foreach ($categories as $category): ?>
                            <div class="category-item"
                                onclick="filterByCategory('<?php echo htmlspecialchars($category); ?>')">
                                <?php echo htmlspecialchars($category); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <script>
                        function filterByCategory(category) {
                            window.location.href = `CustomerArtFrame.php?category=${encodeURIComponent(category)}`;
                        }
                    </script>
                </div>

                <a href="CustomerWorkart.php" <?php echo $current_page === 'CustomerWorkart.php' ? 'aria-current="page"' : ''; ?>>
                    <span class="nav-link"><span>งานศิลป์</span></span>
                </a>

                <a href="CustomerReservation.php" <?php echo $current_page === 'CustomerReservation.php' ? 'aria-current="page"' : ''; ?>>
                    <span class="nav-link"><span>จองคิว</span></span>
                </a>
            </div>
        </div>
    </div>
</div>