<?php
session_start();

include "database.php";
$employee_ID = $_SESSION['Employee_ID'];
$sql = "SELECT * From employee WHERE Employee_ID = '$employee_ID'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $employee = mysqli_fetch_assoc($result);
} else {
    die(" ไม่พบข้อมูลพนักงาน!");
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

    <link rel="stylesheet" href="CSS/adminStyle.css">
    <link rel="stylesheet" href="CSS/adminNavbar.css">
    <link rel="stylesheet" href="CSS/adminProfilePage.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- JavaScript -->

    <script src="JS/profile.js" defer></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/loginNotify.js"></script>
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
                <div class="left-menu">


                <div class="left-menu">
                    <?php include './Template/LeftNavBar/AdminLeftNav.php'; ?>
                </div>
                </div>


                <div class="admin-content">


                    <div class="profile-container">
                        <img src="Picture/<?php echo htmlspecialchars($employee['employee_image']); ?>"
                            id="image-preview" style="max-width: 200px;">
                        <h2>Profile Information</h2>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <p><?php echo isset($employee['Username_employee']) ? $employee['Username_employee'] : 'Guest'; ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <p>
                                <?php
                                echo isset($employee['email']) ? $employee['email'] : 'Not available';
                                ?>
                            </p>
                        </div>

                        <a class="edit-profile-btn"
                            href="AdminEditProfile.php?Employee_ID=<?php echo $row['Employee_ID']; ?>">
                            <button>Edit Profile</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>