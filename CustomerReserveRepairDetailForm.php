<?php
session_start();
include "database.php";

// Check if User_ID is set in the session
if (!isset($_SESSION['user_id'])) {
    echo "Error: User_ID is not set in the session.";
    exit;
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = isset($_POST['year']) ? $_POST['year'] : null;
    $month = isset($_POST['month']) ? $_POST['month'] : null;
    $day = isset($_POST['day']) ? $_POST['day'] : null;
    $time = isset($_POST['time']) ? $_POST['time'] : null;

    // Debugging: Check if all required POST data is present
    if (empty($year) || empty($month) || empty($day) || empty($time)) {
        echo "Error: Missing reservation details.";
        exit;
    }
} else {
    header('Location: CustomerReserveRepair.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrameArt</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/CustomerReserve.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>

</head>

<body>

    <div class="layout expanded home-page">
        <!-- Left Menu -->
        <?php include './Template/LeftNavBar/LeftNav.php'; ?>

        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <div class="left-section">
                        <h1>หน้าหลัก</h1>
                    </div>
                    <div class="right-section">
                    <?php include './Template/Header/CustomerHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <main>
                <div class="form-container">
                    <h2>Reserve Repair Details</h2>
                    <form action="RepairReserveSubmit.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="year" value="<?php echo $year; ?>">
        <input type="hidden" name="month" value="<?php echo $month; ?>">
        <input type="hidden" name="day" value="<?php echo $day; ?>">
        <input type="hidden" name="time" value="<?php echo $time; ?>">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname:</label>
                            <input type="text" id="surname" name="surname" required>
                        </div>
                        <div class="form-group">
                            <label for="detail">Detail:</label>
                            <textarea id="detail" name="detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="service-container">
                            <a href="CustomerReservation.php" class="service-btn return">
                                ย้อนกลับ

                            </a>
                            <button type="submit" class="service-btn accept">
                                ยืนยัน
                            </button>
                        </div>
                </div>
                </form>
        </div>
        </main>
    </div>
    </div>
</body>

</html>