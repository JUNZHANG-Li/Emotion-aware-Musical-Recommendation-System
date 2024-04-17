<?php
require_once 'setup_database.php'; // Check DB status
$mysqli->close();

session_start(); // Read Account Info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>
    <?php include 'components/input.php'; ?>
    <?php 
    if (isset($_POST['recommendation'])) {
        include 'components/recommendation.php';
    }
    ?>
</body>

</html>
