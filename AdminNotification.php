<?php
session_start();
include "database.php";

// Handle AJAX request to update notification status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['noti_id'])) {
    $noti_id = intval($_POST['noti_id']);

    // Update the notification status to "read"
    $sql = "UPDATE notifications SET status = 'read' WHERE noti_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $noti_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
    exit(); // Stop further execution for AJAX requests
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminTableinfo.css">
    <link rel="stylesheet" href="CSS/adminNotification.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="layout expanded home-page">

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

                <div class="left-menu">
                    <?php include './Template/LeftNavBar/AdminLeftNav.php'; ?>
                </div>

                <div class="admin-content">
                    <div class="content">
                        <h2 class="page-title">รายการแจ้งเตือน</h2>

                        <table>
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>รหัสลูกค้า</th>
                                    <th>หัวข้อ</th>
                                    <th>ข้อความ</th>
                                    <th>ประเภท</th>
                                    <th>สถานะ</th>
                                    <th>เวลาแจ้งเตือน</th>
                                    <th>ยืนยัน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch notifications from the database
                                $sql = "SELECT * FROM notifications";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr id='row-" . $row['noti_id'] . "'>";
                                        echo "<td>" . $row['noti_id'] . "</td>";
                                        echo "<td>" . $row['User_ID'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['content'] . "</td>";
                                        echo "<td>" . $row['type'] . "</td>";
                                        echo "<td class='status'>" . $row['status'] . "</td>";
                                        echo "<td>" . $row['create_time'] . "</td>";
                                        echo "<td><button class='ok-btn' data-id='" . $row['noti_id'] . "'><i class='fa fa-check' aria-hidden='true'></i></button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>ไม่มีการแจ้งเตือน</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
        $(document).ready(function () {
            // Handle click event on the "ok-btn"
            $('.ok-btn').on('click', function () {
                const notiId = $(this).data('id');
                const row = $('#row-' + notiId);
    
                // Send AJAX request to update the status
                $.ajax({
                    url: '', // Same file
                    type: 'POST',
                    data: { noti_id: notiId },
                    success: function (response) {
                        if (response === 'success') {
                            // Remove the row from the table
                            row.fadeOut(300, function () {
                                $(this).remove();
                            });
                        } else {
                            alert('Failed to update notification status.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while updating the notification status.');
                    }
                });
            });
        });
    </script>
</body>

</html>