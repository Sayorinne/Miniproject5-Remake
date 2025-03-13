<?php if (isset($_SESSION['Employee_ID'])): 
    include "database.php";
    $employee_ID = $_SESSION['Employee_ID'];
    $sql = "SELECT * From employee WHERE Employee_ID = '$employee_ID'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
?>
    <div class="profile-button">
        <p class=" fa fa-user" style="margin: 10px" onclick="toggloeMenu()">
            <?php echo $row['Username_employee']; ?>
        </p>
    </div>
    <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
            <img src="Picture/<?php echo htmlspecialchars($row['employee_image']); ?>" id="image-preview" style="max-width: 200px;">
                <h2><?php echo $row['Username_employee']; ?></h2>
                <h3>ID:<?php echo $_SESSION['Employee_ID']; ?></h3>
            </div>

            <hr>
             
             <td><a href='AdminProfile.php'class='sub-menu-link'><img src='images/profile.png'>Edit Profile <span></span></a>
            
           
            <a href="logout.php" class="sub-menu-link">
                <img src="images/profile.png">
                <p>Logout</p>
                <span></span>
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