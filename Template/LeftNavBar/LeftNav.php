<?php
// Fetch categories from the product_type table
$categories = [];
$sql = "SELECT Category_name FROM product_type";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($category_row = mysqli_fetch_assoc($result)) {
        $categories[] = $category_row['Category_name'];
    }
} else {
    $categories = ["No categories found"]; // Fallback if no categories are found
}

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="CSS/navbar.css">
<link rel="stylesheet" href="CSS/miniTagSearch.css">
<script src="JS/tagFilter.js" defer></script>

<div class="left-menu">
    <div class="logo">
        <a href="#">
            <img src="Picture/LogoFrame.png" style="height: 60px;">
        </a>
    </div>
    <div class="left-menu-content">
        <hr>
        <div class="ms-auto nav">
            <!-- Home Link -->
            <a href="CustomerHomepage.php" <?php echo $current_page === 'CustomerHomepage.php' ? 'aria-current="page"' : ''; ?>>
                <span class="nav-link">
                    <i class="fa fa-home"></i> <span>หน้าหลัก</span>
                </span>
            </a>

            <!-- Sub-menu with categories from the database -->
            <div class="nav-item" onmouseenter="openMenu()" onmouseleave="closeMenu()">
                <a href="CustomerArtFrame.php" <?php echo $current_page === 'CustomerArtFrame.php' ? 'aria-current="page"' : ''; ?>>
                    <span class="nav-link">
                        <i class="fa fa-picture-o"></i> <span>กรอบรูป</span>
                    </span>
                </a>
                <div id="categorySubMenu" class="submenu">
                    <?php foreach ($categories as $category): ?>
                        <div class="category-item" onclick="filterByCategory('<?php echo htmlspecialchars($category); ?>')">
                            <?php echo htmlspecialchars($category); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Work Art Link -->
            <a href="CustomerWorkart.php" <?php echo $current_page === 'CustomerWorkart.php' ? 'aria-current="page"' : ''; ?>>
                <span class="nav-link">
                    <i class="fa fa-paint-brush"></i> <span>งานศิลป์</span>
                </span>
            </a>

            <!-- Reservation Link -->
            <a href="CustomerReservation.php" <?php echo $current_page === 'CustomerReservation.php' ? 'aria-current="page"' : ''; ?>>
                <span class="nav-link">
                    <i class="fa fa-calendar"></i> <span>จองคิว</span>
                </span>
            </a>
            <hr>
            
            <div class="dropdown">
                <a
                    class="dropdown-header <?php echo in_array(basename($_SERVER['PHP_SELF']), ['AdminReservePage.php', 'AdminReserveHistory.php']) ? 'active' : ''; ?>">
                    <span class="nav-link"><i class="fa fa-calendar"></i> ประวัติ</span>
                </a>
                <div class="dropdown-content">
                    <a href="#"
                        class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminReservePage.php' ? 'active' : ''; ?>">
                        <span class="nav-link">การจองคิว</span>
                    </a>
                    <a href="#"
                        class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminReserveHistory.php' ? 'active' : ''; ?>">
                        <span class="nav-link">การสั่งซื้อ</span>
                    </a>
                </div>
            </div>

        </div>
        <hr>
    </div>
</div>

<script>
    function filterByCategory(category) {
        window.location.href = `CustomerArtFrame.php?category=${encodeURIComponent(category)}`;
    }
</script>

<style>
    /* General styles for the left menu */
    .left-menu {
        background-color: #ffffff;
        border-right: 1px solid #000000;
        position: fixed;
        top: 0;
        bottom: 0;
        width: 260px;
        z-index: 10;
    }

    .left-menu-content {
        padding: 20px;
    }

    .nav a {
        text-decoration: none;
        color: #000000;
        display: flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
        margin-bottom: 10px;
    }

    .nav a i {
        margin-right: 10px;
        font-size: 18px;
    }

    .nav a:hover {
        background-color: #f0f0f0;
        color: #0078D7;
    }

    .nav a[aria-current="page"] {
        font-weight: bold;
        background-color: #0078D7;
        color: #ffffff;
    }

    .submenu {
        display: none;
        padding-left: 20px;
    }

    .nav-item:hover .submenu {
        display: block;
    }

    .category-item {
        padding: 5px 10px;
        cursor: pointer;
        background-color: rgb(255, 255, 255);
        transition: 0.3s, color 0.3s;
    }

    .submenu div:hover {
        background-color: rgb(166, 224, 247);
    }

    .category-item:hover {
        color: rgb(0, 0, 0);
    }
    /* General styles for the dropdown */
    .dropdown {
        position: relative;
    }

    .dropdown-header {
        cursor: pointer;
        font-size: 16px;
        font-weight: normal;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #000000;
        border-radius: 5px;
        transition: color 0.3s, background-color 0.3s;
    }

    .dropdown-header.active {
        font-weight: bold;
        color: #ffffff;
        background-color: #0078D7;
    }

    .dropdown-header:hover {
        color: #ffffff;
        background-color: #0056a3;
    }

    .dropdown-content {
        max-height: 0;
        overflow: hidden;
        flex-direction: column;
        margin-left: 20px;
        margin-top: 10px;
        opacity: 0;
        transform: translateY(-10px);
        transition: max-height 0.5s ease, opacity 0.5s ease, transform 0.5s ease;
    }

    .dropdown:hover .dropdown-content {
        max-height: 200px; /* Adjust based on the content height */
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-content a {
        padding: 8px 15px;
        font-size: 14px;
        color: #000000;
        background-color: #f9f9f9;
        border-left: 3px solid transparent;
        transition: background-color 0.3s, border-color 0.3s;
        border-radius: 5px;
    }

    .dropdown-content a.active {
        font-weight: bold;
        color: #ffffff;
        background-color: #0078D7;
        border-left: 3px solid #0078D7;
    }

    .dropdown-content a:hover {
        background-color: #0056a3;
        border-left: 3px solid #0056a3;
        color: #ffffff;
    }
</style>