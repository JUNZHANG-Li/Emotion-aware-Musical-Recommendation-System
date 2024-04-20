<?php 
require 'setup_database.php'; 

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://redis:6379');
session_start();

// Fetch distinct countries from the database
$sql = "SELECT username, email, role FROM users WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Get the result
$row = $result->fetch_assoc();
if ($row) {
    if ($row) {
        $username = $row['username'];
        $email = $row['email'];
        switch ($row['role']) {
            case 1:
                $role = "Music Enthusiasts";
                break;
            case 2:
                $role = "Algorithm Developer";
                break;
            default:
                $role = "Role not defined";
        }    
    } else {
        echo '<script>alert("Oops! Something went wrong. Please try again later."); window.location.href = "index.php";</script>';
    }
} else {
    echo '<script>alert("Oops! Something went wrong. Please try again later."); window.location.href = "index.php";</script>';
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/userpage.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.php" class="navbar-link-title">Song Recommendation</a>
        </div>
    </nav>
    <br><br><br>
    <div class="userinfo-container">
        <h2>Your Profile</h2>
        <br>
        <br>
        <form action="logout.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <h3><?php echo $_SESSION['username']; ?></h3>
                <br>
                <label for="username">Email Address:</label>
                <h3><?php echo $email; ?></h3>
                <br>
                <label for="username">Role:</label>
                <h3><?php echo $role; ?></h3>
            </div>
            <br>
            <input type="submit" name="logout" value="Logout">
                <br>
                <br>
            <a href="index.php">Back</a>
        </form>
    </div>
</body>
</html>
