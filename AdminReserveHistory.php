<?php
session_start();
include 'database.php';

// Fetch Repair Reservations with status_ID = 2 or 3
$sqlRepair = "
SELECT rr.*, COALESCE(rst.status_name, 'Unknown Status') AS status_name, c.Username, 'Repair' AS type
FROM repair_reservations rr
LEFT JOIN reserve_status_type rst ON rr.status_ID = rst.status_ID
LEFT JOIN customer c ON rr.User_ID = c.User_ID
WHERE rr.status_ID IN (2, 3)
ORDER BY reservation_date ASC, reservation_time ASC;
";

$resultRepair = mysqli_query($conn, $sqlRepair);

if (!$resultRepair) {
    die("Error fetching repair reservations: " . $conn->error);
}

$repairReservations = mysqli_fetch_all($resultRepair, MYSQLI_ASSOC);

// Fetch Custom Reservations with status_ID = 2 or 3
$sqlCustom = "
SELECT cr.*, COALESCE(rst.status_name, 'Unknown Status') AS status_name, c.Username, 'Custom' AS type
FROM custom_reservations cr
LEFT JOIN reserve_status_type rst ON cr.status_ID = rst.status_ID
LEFT JOIN customer c ON cr.User_ID = c.User_ID
WHERE cr.status_ID IN (2, 3)
ORDER BY reservation_date ASC, reservation_time ASC;
";

$resultCustom = mysqli_query($conn, $sqlCustom);

if (!$resultCustom) {
    die("Error fetching custom reservations: " . $conn->error);
}

$customReservations = mysqli_fetch_all($resultCustom, MYSQLI_ASSOC);

// Determine which type to display (Repair or Custom)
$filterType = isset($_GET['type']) ? $_GET['type'] : 'all';

// Determine which status to display (Accepted or Canceled)
$filterStatus = isset($_GET['status']) ? intval($_GET['status']) : 0;

// Reset sub-filter when main filter changes
if (!isset($_GET['status'])) {
    $filterStatus = 0;
}

// Filter Reservations by status
if ($filterStatus !== 0) {
    $repairReservations = array_values(array_filter($repairReservations, function ($reservation) use ($filterStatus) {
        return intval($reservation['status_ID']) == $filterStatus;
    }));

    $customReservations = array_values(array_filter($customReservations, function ($reservation) use ($filterStatus) {
        return intval($reservation['status_ID']) == $filterStatus;
    }));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reserve History</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminTableinfo.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->

    <script src="JS/profile.js" defer></script>


    <style>
        .reservation-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .reservation-cards {
            margin-top: 20px;
        }

        .date-heading {
            font-size: 1.5em;
            font-weight: bold;
            color: #0078D7;
            margin-bottom: 10px;
        }

        .filter-buttons {
            margin-bottom: 20px;
        }

        .filter-buttons button,
        .sub-filter-buttons button {
            margin-right: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-buttons .active,
        .sub-filter-buttons .active {
            background-color: #0078D7;
            color: white;
        }

        .filter-buttons button:hover,
        .sub-filter-buttons button:hover {
            background-color: #0056a3;
            color: white;
        }

        .sub-filter-buttons {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="layout expanded home-page">

        <div class="left-menu">
            <?php include './Template/LeftNavBar/AdminLeftNav.php'; ?>
        </div>

        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-icon">
                        <?php include './Template/Header/AdminHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="admin-wrapper">
                <div class="admin-content">
                    <div class="content">
                        <h2 class="page-title">ประวัติการจองคิว</h2>

                        <!-- Filter Buttons -->
                        <div class="filter-buttons">
                            <a href="?type=all">
                                <button
                                    class="<?php echo $filterType === 'all' ? 'active' : ''; ?>">แสดงทั้งหมด</button>
                            </a>
                            <a href="?type=repair">
                                <button class="<?php echo $filterType === 'repair' ? 'active' : ''; ?>">ข้อมูล
                                    "คิวสั่งซ่อม"</button>
                            </a>
                            <a href="?type=custom">
                                <button class="<?php echo $filterType === 'custom' ? 'active' : ''; ?>">ข้อมูล
                                    "คิวสั่งทำ"</button>
                            </a>
                        </div>

                        <!-- Sub-Filter Buttons -->
                        <div class="sub-filter-buttons">
                            <a href="?type=<?php echo $filterType; ?>&status=2">
                                <button class="<?php echo $filterStatus === 2 ? 'active' : ''; ?>">"ยืนยัน"</button>
                            </a>
                            <a href="?type=<?php echo $filterType; ?>&status=3">
                                <button class="<?php echo $filterStatus === 3 ? 'active' : ''; ?>">"ยกเลิก"</button>
                            </a>
                        </div>

                        <!-- Reservation Container -->
                        <div class="reservation-container">
                            <?php
                            if ($filterType === 'all' || $filterType === 'repair'): ?>
                                <h3 class="w3-text-blue">ข้อมูลจองคิว "สั่งซ่อม"</h3>
                                <?php
                                $currentDate = null; // To track the current date being displayed
                                foreach ($repairReservations as $reservationRow):
                                    // Check if the date has changed
                                    if ($currentDate !== $reservationRow["reservation_date"]):
                                        $currentDate = $reservationRow["reservation_date"];
                                        ?>
                                        <!-- Display the date heading -->
                                        <div class="date-heading"><?php echo "วันที่จอง: " . $currentDate; ?></div>
                                    <?php endif; ?>
                                    <!-- Display the reservation card -->
                                    <div class="reservation-card w3-card-4 w3-padding w3-margin-bottom">
                                        <div class="card-header w3-display-container">
                                            <span class="status-badge w3-display-topright w3-tag w3-round w3-yellow">
                                                <?php echo $reservationRow["status_name"]; ?>
                                            </span>
                                            <h3><?php echo $reservationRow["name"] . " " . $reservationRow["surname"]; ?></h3>
                                            <p><strong>เวลา:</strong> <?php echo $reservationRow["reservation_time"]; ?></p>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>รายละเอียด:</strong> <?php echo $reservationRow["detail"]; ?></p>
                                            <p><strong>เบอร์โทร:</strong> <?php echo $reservationRow["phone"]; ?></p>
                                            <p><strong>รหัสลูกค้า:</strong> <?php echo $reservationRow["User_ID"]; ?></p>
                                            <p><strong>ชื่อผู้ใช้:</strong> <?php echo $reservationRow["Username"]; ?></p>
                                            <p><strong>เวลาบันทึก:</strong> <?php echo $reservationRow["created_at"]; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php
                            if ($filterType === 'all' || $filterType === 'custom'): ?>
                                <h3 class="w3-text-blue">ข้อมูลจองคิว "สั่งทำกรอบรูป"</h3>
                                <?php
                                $currentDate = null; // To track the current date being displayed
                                foreach ($customReservations as $reservationRow):
                                    // Check if the date has changed
                                    if ($currentDate !== $reservationRow["reservation_date"]):
                                        $currentDate = $reservationRow["reservation_date"];
                                        ?>
                                        <!-- Display the date heading -->
                                        <div class="date-heading"><?php echo "วันที่จอง: " . $currentDate; ?></div>
                                    <?php endif; ?>
                                    <!-- Display the reservation card -->
                                    <div class="reservation-card w3-card-4 w3-padding w3-margin-bottom">
                                        <div class="card-header w3-display-container">
                                            <span class="status-badge w3-display-topright w3-tag w3-round w3-yellow">
                                                <?php echo $reservationRow["status_name"]; ?>
                                            </span>
                                            <h3><?php echo $reservationRow["name"] . " " . $reservationRow["surname"]; ?></h3>
                                            <p><strong>เวลา:</strong> <?php echo $reservationRow["reservation_time"]; ?></p>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>รายละเอียด:</strong> <?php echo $reservationRow["detail"]; ?></p>
                                            <p><strong>เบอร์โทร:</strong> <?php echo $reservationRow["phone"]; ?></p>
                                            <p><strong>รหัสลูกค้า:</strong> <?php echo $reservationRow["User_ID"]; ?></p>
                                            <p><strong>ชื่อผู้ใช้:</strong> <?php echo $reservationRow["Username"]; ?></p>
                                            <p><strong>เวลาบันทึก:</strong> <?php echo $reservationRow["created_at"]; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                    <?php include './Template/popup/notificationPopup.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>