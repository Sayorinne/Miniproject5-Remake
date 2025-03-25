<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "database.php";

$selected_category = isset($_GET['category']) ? $_GET['category'] : '';


$products = [];
if ($selected_category) {

    $sql = "
        SELECT p.* 
        FROM product p
        INNER JOIN product_type pt ON p.Category_ID = pt.Category_ID
        WHERE pt.Category_name = ?
    ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $selected_category);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
    } else {
        die("Failed to prepare statement: " . $conn->error);
    }
} else {

    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
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
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/post.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/miniTagSearch.css">

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

            <!-- Main Content Row -->
            <main>
                <div class="w3-container content-container">
                    <div class="content-flex">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="image-card">
                                    <a href="CustomerDetailArtFrame.php?id=<?php echo $product['product_ID']; ?>">
                                        <img src="Picture/<?php echo htmlspecialchars($product['product_image']); ?>" class="w3-image w3-card-4" alt="Product Image">
                                        <h5><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                        <p><strong>Price:</strong> ฿<?php echo number_format($product['product_price'], 2); ?></p>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>ไม่พบสินค้าในหมวดหมู่ที่เลือก</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>