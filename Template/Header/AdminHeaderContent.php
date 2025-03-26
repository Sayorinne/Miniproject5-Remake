<?php if (isset($_SESSION['Employee_ID'])): 
    include "database.php";
    $employee_ID = $_SESSION['Employee_ID'];
    $sql = "SELECT * From employee WHERE Employee_ID = '$employee_ID'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $admin_row = mysqli_fetch_assoc($result);
    }
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class="profile-button">
        <p class="fa fa-user" style="margin: 10px" onclick="toggloeMenu()">
            <?php echo $admin_row['Username_employee']; ?>
        </p>
    </div>
    <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
                <img src="Picture/<?php echo htmlspecialchars($admin_row['employee_image']); ?>" id="image-preview" style="max-width: 200px;">
                <h2><?php echo $admin_row['Username_employee']; ?></h2>
                <h3>ID: <?php echo $_SESSION['Employee_ID']; ?></h3>
            </div>

            <hr>

            <!-- Edit Profile Link -->
            <a href="AdminProfile.php" class="sub-menu-link">
                <i class="fa fa-edit"></i>
                <p style="margin-left: 20px">Edit Profile</p>
            </a>

            <!-- Logout Link -->
            <a href="logout.php" class="sub-menu-link">
                <i class="fa fa-sign-out"></i>
                <p style="margin-left: 20px">Logout</p>
            </a>
        </div>
    </div>
<?php else: ?>
    <a role="button" tabindex="0" href="login.php" class="login-button btn btn-primary">
        <span>Login</span>
    </a>
    <a role="button" tabindex="0" href="registration.php" class="login-button btn btn-primary">
        <span>Register</span>
    </a>
<?php endif; ?>

