<?php
session_start();
include 'database.php';

// Handle AJAX request to update reservation status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['repairId']) && isset($_POST['statusId'])) {
        // Update status for repair reservations
        $repairId = intval($_POST['repairId']);
        $statusId = intval($_POST['statusId']);

        $sql = "UPDATE repair_reservations SET status_ID = ? WHERE repair_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $statusId, $repairId);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }

        $stmt->close();
    } elseif (isset($_POST['customId']) && isset($_POST['statusId'])) {
        // Update status for custom reservations
        $customId = intval($_POST['customId']);
        $statusId = intval($_POST['statusId']);

        $sql = "UPDATE custom_reservations SET status_ID = ? WHERE custom_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $statusId, $customId);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "Invalid request"]);
    }

    $conn->close();
    exit;
}

// Fetch repair reservations
$sqlRepair = "
SELECT rr.*, COALESCE(rst.status_name, 'Unknown Status') AS status_name, c.Username, 'Repair' AS type
FROM repair_reservations rr
LEFT JOIN reserve_status_type rst ON rr.status_ID = rst.status_ID
LEFT JOIN customer c ON rr.User_ID = c.User_ID
WHERE rr.status_ID = 1
ORDER BY reservation_date ASC, reservation_time ASC;
";

$resultRepair = mysqli_query($conn, $sqlRepair);

if (!$resultRepair) {
    die("Error fetching repair reservations: " . $conn->error);
}

$repairReservations = mysqli_fetch_all($resultRepair, MYSQLI_ASSOC);

// Fetch custom reservations
$sqlCustom = "
SELECT cr.*, COALESCE(rst.status_name, 'Unknown Status') AS status_name, c.Username, 'Custom' AS type
FROM custom_reservations cr
LEFT JOIN reserve_status_type rst ON cr.status_ID = rst.status_ID
LEFT JOIN customer c ON cr.User_ID = c.User_ID
WHERE cr.status_ID = 1
ORDER BY reservation_date ASC, reservation_time ASC;
";

$resultCustom = mysqli_query($conn, $sqlCustom);

if (!$resultCustom) {
    die("Error fetching custom reservations: " . $conn->error);
}

$customReservations = mysqli_fetch_all($resultCustom, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reserve Page</title>

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
            justify-content: space-between;
            gap: 100px;
        }

        .reservation-column {
            flex: 1;
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
    </style>

    <!-- JavaScript -->
    <script>
        function updateStatus(repairId, statusId) {
            const formData = new FormData();
            formData.append('repairId', repairId);
            formData.append('statusId', statusId);

            fetch('', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status updated successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to update status: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status.');
                });
        }

        function updateCustomStatus(customId, statusId) {
            const formData = new FormData();
            formData.append('customId', customId);
            formData.append('statusId', statusId);

            fetch('', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status updated successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to update status: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status.');
                });
        }
    </script>
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
                        <h2 class="page-title">รายการจองคิว</h2>

                        <!-- Reservation Container -->
                        <div class="reservation-container">
                            <!-- Repair Reservations -->
                            <div class="reservation-column">
                                <h3 class="w3-text-blue">จองคิว "สั่งซ่อม"</h3>
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
                                            <h3><?php echo $reservationRow["name"] . " " . $reservationRow["surname"]; ?>
                                            </h3>
                                            <p><strong>เวลา:</strong> <?php echo $reservationRow["reservation_time"]; ?></p>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>รายละเอียด:</strong> <?php echo $reservationRow["detail"]; ?></p>
                                            <p><strong>เบอร์โทร:</strong> <?php echo $reservationRow["phone"]; ?></p>
                                            <p><strong>รหัสลูกค้า:</strong> <?php echo $reservationRow["User_ID"]; ?></p>
                                            <p><strong>ชื่อผู้ใช้:</strong> <?php echo $reservationRow["Username"]; ?></p>
                                            <p><strong>เวลาบันทึก:</strong> <?php echo $reservationRow["created_at"]; ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <button class="w3-button w3-green"
                                                onclick="updateStatus(<?php echo $reservationRow['repair_id']; ?>, 2)">Accept</button>
                                            <button class="w3-button w3-red"
                                                onclick="updateStatus(<?php echo $reservationRow['repair_id']; ?>, 3)">Decline</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Custom Reservations -->
                            <div class="reservation-column">
                                <h3 class="w3-text-blue">จองคิว "สั่งทำกรอบรูป"</h3>
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
                                            <h3><?php echo $reservationRow["name"] . " " . $reservationRow["surname"]; ?>
                                            </h3>
                                            <p><strong>เวลา:</strong> <?php echo $reservationRow["reservation_time"]; ?></p>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>รายละเอียด:</strong> <?php echo $reservationRow["detail"]; ?></p>
                                            <p><strong>เบอร์โทร:</strong> <?php echo $reservationRow["phone"]; ?></p>
                                            <p><strong>รหัสลูกค้า:</strong> <?php echo $reservationRow["User_ID"]; ?></p>
                                            <p><strong>ชื่อผู้ใช้:</strong> <?php echo $reservationRow["Username"]; ?></p>
                                            <p><strong>เวลาบันทึก:</strong> <?php echo $reservationRow["created_at"]; ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <button class="w3-button w3-green"
                                                onclick="updateCustomStatus(<?php echo $reservationRow['custom_id']; ?>, 2)">Accept</button>
                                            <button class="w3-button w3-red"
                                                onclick="updateCustomStatus(<?php echo $reservationRow['custom_id']; ?>, 3)">Decline</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
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