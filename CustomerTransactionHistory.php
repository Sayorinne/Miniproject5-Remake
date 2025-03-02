<?php
session_start();
include "database.php";



$user_id = $_SESSION['user_id'];

$sql = "SELECT t.*, p.product_name 
        FROM transactions t 
        JOIN product p ON t.product_id = p.product_ID 
        WHERE t.customer_id = ? 
        ORDER BY t.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
</head>
<body>
    <h1>Transaction History</h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Product</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Shipping Address</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['created_at']; ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo $row['amount'] . ' ' . $row['currency']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <?php echo htmlspecialchars($row['shipping_name']) . '<br>' .
                           htmlspecialchars($row['shipping_address_line1']) . '<br>' .
                           htmlspecialchars($row['shipping_city']) . ', ' .
                           htmlspecialchars($row['shipping_state']) . ' ' .
                           htmlspecialchars($row['shipping_postal_code']) . '<br>' .
                           htmlspecialchars($row['shipping_country']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>