
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="CSS/adminStyle.css">
<link rel="stylesheet" href="CSS/adminNavbar.css">
<div class="left-menu-content">
    <div class="logo">
        <h2 style="margin-top: 20px ; color: white;">1</h2>
    </div>
    <hr>
    <div class="ms-auto nav">
        <a href="AdminPage.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminPage.php' ? 'active' : ''; ?>">
            <span class="nav-link"><i class="fa fa-home"></i> จัดการ "สินค้ากรอบรูป"</span>
        </a>

        <a href="AdminArtPage.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminArtPage.php' ? 'active' : ''; ?>">
            <span class="nav-link"><i class="fa fa-paint-brush"></i> จัดการ "ภาพศิลป์"</span>
        </a>

        <a href="AdminTagPage.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminTagPage.php' ? 'active' : ''; ?>">
            <span class="nav-link"><i class="fa fa-tags"></i> จัดการ "หมวดหมู่"</span>
        </a>

        <!-- Dropdown for Reservation -->
        <div class="dropdown">
            <a class="dropdown-header <?php echo in_array(basename($_SERVER['PHP_SELF']), ['AdminReservePage.php', 'AdminReserveHistory.php']) ? 'active' : ''; ?>">
                <span class="nav-link"><i class="fa fa-calendar"></i> จองคิว (Reservation)</span>
            </a>
            <div class="dropdown-content">
                <a href="AdminReservePage.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminReservePage.php' ? 'active' : ''; ?>">
                    <span class="nav-link">ข้อมูลการจองคิว</span>
                </a>
                <a href="AdminReserveHistory.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'AdminReserveHistory.php' ? 'active' : ''; ?>">
                    <span class="nav-link">ประวัติการจองคิว</span>
                </a>
            </div>
        </div>
    </div>
    <hr>
</div>



<style>
    /* General styles for the sub-menu links */

    .sub-menu-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        padding-left: 20px;
        color: #000000;
        transition: background-color 0.3s, color 0.3s;
        border-radius: 5px;
    }

    .sub-menu-link i {
        margin-right: 10px;
        font-size: 18px;
    }

    .sub-menu-link:hover {
        background-color: #0078D7;
        color: #ffffff;
    }

    .sub-menu-link:hover i {
        color: #ffffff;
    }
</style>