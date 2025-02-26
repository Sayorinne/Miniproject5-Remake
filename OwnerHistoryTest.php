<?php
session_start();
require_once('StripeHistory.php');

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: login.php");
    exit();
}

$transactions = StripeHistory::getTransactionHistory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Backdoor - Edit Post</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Internal CSS -->
    <link rel="stylesheet" href="CSS/ownerStyle.css">
    <link rel="stylesheet" href="CSS/ownerDashboard.css">
    <link rel="stylesheet" href="CSS/ownerNavbar.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


    <!-- JavaScript -->
    <script src="JS/profile.js" defer></script>
    <script src="JS/texteditor.js" defer></script>


</head>
<body>
    <div class="layout expanded home-page">


    <?php
    // เชื่อมต่อกับฐานข้อมูล
    include "database.php";
    // คำสั่ง SQL SELECT เพื่อดึงข้อมูลจากตาราง "topic"
    $sql = "SELECT * FROM review";
    $result = mysqli_query($conn, $sql);
    ?>


        <!-- Right Main -->
        <div class="right-main">
            <div class="top-nav">
                <div class="inside">
                    <!-- <input type="text" name="search" placeholder="Search.."> -->
                    <div class="left-icon">
                        <!-- Account validate -->
                        <?php if(isset($_SESSION['Admin_ID'])): ?>
                            <div class="profile-button">
                            <p class =" fa fa-user" style= "margin: 10px" onclick="toggloeMenu()"> <?php echo $_SESSION['username_admin']; ?> </p>
                            </div>
                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">
                                        <img src="Picture/Sihba_07.jpg" >
                                        <h2><?php echo $_SESSION['username_admin']; ?></h2>
                                        <h3>ID:<?php echo $_SESSION['Admin_ID']; ?></h3>
                                    </div>
                                    
                                    <hr>
                                    <a href="#" class="sub-menu-link">
                                        <img src="images/profile.png">
                                        <p>Edit Profile</p>
                                        <span></span>
                                    </a>

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
                    </div>
                </div>
            </div>
            
            <!-- Main Content Row -->
        <div class="admin-wrapper">
        <div class="left-menu">

            <hr>
                <div class="left-menu-content">                   
                    <div class="ms-auto nav">
                    <a aria-current="page" class href="OwnerPage.php">
                            <span class="nav-link"><span>แดชบอร์ด</span></span>
                        </a>

                        <a class href="OwnerEmployeePage.php">
                            <span class="nav-link"><span>จัดการ "พนักงาน"</span></span>
                        </a>
                    </div>
                <hr>
            </div>
        </div>
        




        <div class="admin-content"> 
            <h1>Transaction History</h1>
            
            <?php if (isset($transactions['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($transactions['error']); ?></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Billing Address</th>
                            <th>Payment Method</th>
                            <th>Debug Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['id']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['amount'] . ' ' . $transaction['currency']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['status']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['date']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['customer_email']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['customer_phone']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['billing_address']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['payment_method']); ?></td>
                                <td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
