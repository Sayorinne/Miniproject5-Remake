<?php 
session_start();
header("Content-Type: text/html; charset=UTF-8");
include "database.php";
?>

<!DOCTYPE html>
<html lang="th">

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
          <table>
            <thead>
              <tr>
                <th>รหัส</th>
                <th>วันที่</th>
                <th>เวลา</th>
                <th>บริการ</th>
                <th>สถานะ</th>
                <th>การจัดการ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#B00123</td>
                <td>08/04/2025</td>
                <td>13:00</td>
                <td>ใส่กรอบภาพ</td>
                <td><span class="status pending">รอดำเนินการ</span></td>
                <td>
                  <button class="btn-detail"><i class="fas fa-eye"></i> รายละเอียด</button>
                  <button class="btn-cancel"><i class="fas fa-times"></i> ยกเลิก</button>
                </td>
              </tr>
              <tr>
                <td>#B00110</td>
                <td>01/04/2025</td>
                <td>10:30</td>
                <td>ซ่อมแซมกรอบ</td>
                <td><span class="status completed">เสร็จสิ้น</span></td>
                <td>
                  <button class="btn-detail"><i class="fas fa-eye"></i> รายละเอียด</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
