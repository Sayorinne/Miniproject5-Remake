<?php

require 'database.php';

$password = 'owner';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $hashedPassword;
?>
