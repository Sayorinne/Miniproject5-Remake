<?php
session_start();
include "database.php";
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
                    </div>
                    <div class="right-section">
                        <?php include './Template/Header/CustomerHeaderContent.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <main>
                <div class="w3-container content-container">
                    <div class="content-flex">
                        <?php
                        include "database.php";
                        $sql = "SELECT * From artproduct";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="image-card">';
                                echo '<a href="CustomerDetailWorkart.php?id=' . $row['Art_ID'] . '">';
                                echo '<img src="Picture/' . $row['Art_image'] . '" class="w3-image w3-card-4" alt="product Image">';
                                echo '<h5>' . $row['Art_name'] . '</h5>';
                                echo '<p><strong>Price:</strong> ฿' . number_format($row['Art_price'], 2) . '</p>';
                                echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>ไม่พบสินค้า</p>';
                        }
                        mysqli_close($conn);
                        ?>
                    </div>
            </div>
        </main>
        </div>


    </div>
</body>
</html>
