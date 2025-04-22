<?php
session_start();
include 'database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Complete</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .message-box {
            text-align: center;
            background: white;
            width: 800px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message-box h1 {
            margin: 0 0 10px;
        }
        .message-box p {
            margin: 0 0 20px;
        }
        .message-box button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
    </style>
    <script>
        function redirectToHomepage() {
            window.location.href = 'CustomerHomepage.php';
        }
        setTimeout(redirectToHomepage, 5000);
    </script>
</head>
<body>
    <div class="message-box">
    <img src="Picture/StampSorry.png" alt="Cute Icon">
        <h1>Transaction Failed</h1>
        <p>ชำระเงินไม่สำเร็จ โปรดตรวจสอบบัตรชำระเงินของท่านอีกครั้ง</p>
        <button onclick="redirectToHomepage()">กลับสู่หน้าหลัก</button>
    </div>
</body>
</html>