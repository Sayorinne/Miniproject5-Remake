<?php
session_start();
include "database.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  echo "Please log in to view reservation details.";
  exit();
}

$user_id = $_SESSION['user_id'];

// Check if repair_id is provided in the URL
if (!isset($_GET['custom_id'])) {
  echo "Invalid request. No reservation ID provided.";
  exit();
}

$custom_id = $_GET['custom_id'];

// Debugging: Check repair_id and user_id
echo "Repair ID: " . htmlspecialchars($repair_id) . "<br>";
echo "User ID: " . htmlspecialchars($user_id) . "<br>";

// Fetch reservation details from the database
$sql = "SELECT cr.custom_id, cr.reservation_date, cr.reservation_time, cr.detail, rst.status_name 
        FROM custom_reservations cr
        JOIN reserve_status_type rst ON cr.status_ID = rst.status_ID
        WHERE cr.custom_id = ? AND cr.User_ID = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
  echo "Error preparing statement: " . $conn->error;
  exit();
}

$stmt->bind_param("ss", $custom_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Check if the query returns any rows
if ($result->num_rows === 0) {
  echo "No reservation found for the given ID or User_ID.";
  exit();
  
}

$reserveCustom = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FrameArt | รายละเอียดการจอง</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- External CSS -->
  <link rel="stylesheet" href="CSS/CustomerDetailHistoryReserve.css" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/post.css" />
  <link rel="stylesheet" href="CSS/navbar.css" />
  <link rel="stylesheet" href="CSS/CustomerHistoryReserve.css" />
  <link rel="stylesheet" href="CSS/CustomerReserveHistoryStatus.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
    rel="stylesheet" />
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

      <!-- Booking Detail Section -->
      <div class="booking-detail">
        <h2>รายละเอียดการจอง</h2>
        <div class="detail-card">

          <div class="detail-row">
            <span class="label">วันที่จอง : &nbsp;</span>
            <span class="value"><?php echo htmlspecialchars($reserveCustom['reservation_date']); ?></span>
          </div>

          <div class="detail-row">
            <span class="label">เวลา : &nbsp;</span>
            <span class="value"><?php echo htmlspecialchars($reserveCustom['reservation_time']); ?></span>
          </div>

          <div class="detail-row">
            <span class="label">เนื้อหา : &nbsp;</span>
            <span class="value"><?php echo htmlspecialchars($reserveCustom['detail']); ?></span>
          </div>

          <div class="detail-row">
              <span class="label">สถานะ : &nbsp;</span>
              <span class="value">
                  <?php 
                  // Map status_name to CSS class
                  $statusClass = '';
                  if ($reserveCustom['status_name'] == 'รอดำเนินการ') {
                      $statusClass = 'status-pending';
                  } elseif ($reserveCustom['status_name'] == 'ยืนยัน') {
                      $statusClass = 'status-confirmed';
                  } elseif ($reserveCustom['status_name'] == 'ยกเลิก') {
                      $statusClass = 'status-cancelled';
                  }
                  ?>
                  <span class="<?php echo $statusClass; ?>">
                      <?php echo htmlspecialchars($reserveCustom['status_name']); ?>
                  </span>
              </span>
          </div>

          <div class="button-group">
            <button class="btn-back" onclick="history.back()">ย้อนกลับ</button>
            <?php if ($reserveCustom['status_name'] == 'รอดำเนินการ'): ?>
              <button class="btn-cancel">ยกเลิกการจอง</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>