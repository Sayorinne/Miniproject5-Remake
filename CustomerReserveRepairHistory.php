<?php
session_start();
include "database.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  echo "Please log in to view your reservation history.";
  exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>Q
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FrameArt | ประวัติการจอง</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- External CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/post.css" />
  <link rel="stylesheet" href="CSS/navbar.css" />
  <link rel="stylesheet" href="CSS/CustomerHistoryReserve.css" />
  <link rel="stylesheet" href="CSS/CustomerReserveHistoryStatus.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <!-- JavaScript -->
  <script src="JS/profile.js" defer></script>
</head>

<body>
  <div class="layout expanded home-page">
    <!-- Left Menu -->
    <?php include './Template/LeftNavBar/LeftNav.php'; ?>

    <div class="right-main">
      <div class="top-nav">
        <div class="inside">
          <div class="left-section"></div>
          <div class="right-section">
            <?php include './Template/Header/CustomerHeaderContent.php'; ?>
          </div>
        </div>
      </div>

      <!-- Main Content Section -->
      <div class="booking-history">
        <h2><i class="fas fa-clock"></i> ประวัติการจองคิว</h2>
        <div class="booking-table">
          <?php // Fetch repair reservation history for the logged-in user
          $sql = "SELECT rr.repair_id, rr.reservation_date, rr.reservation_time, rr.detail, rst.status_name 
                  FROM repair_reservations rr
                  JOIN reserve_status_type rst ON rr.status_ID = rst.status_ID
                  WHERE rr.User_ID = '$user_id'
                  ORDER BY rr.reservation_date ASC";
          $result = mysqli_query($conn, $sql);
          ?>
          <table>
            <thead>
              <tr>
                <th>วันที่</th>
                <th>เวลา</th>
                <th>สถานะ</th>
                <th>การจัดการ</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($reserveRepair = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($reserveRepair['reservation_date']); ?></td>
                    <td><?php echo htmlspecialchars($reserveRepair['reservation_time']); ?></td>
                    <td> <span class="<?php echo $statusClass; ?>">
                        <?php echo htmlspecialchars($reserveRepair['status_name']); ?>
                      </span>
                    </td>
                    <td>
                      <a href="CustomerReserveRepairHistoryDetail.php?repair_id=<?php echo $reserveRepair['repair_id']; ?>">
                        <button class="btn-detail"><i class="fas fa-eye"></i> รายละเอียด</button>
                      </a>
                      <?php if ($reserveRepair['status_ID'] == 0): ?>
                        <button class="btn-cancel"><i class="fas fa-times"></i> ยกเลิก</button>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6">ไม่มีประวัติการจอง</td>
                </tr>
              <?php endif; ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>