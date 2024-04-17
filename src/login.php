<?php
// Retrieve error message, if any
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.php" class="navbar-link-title">Song Recommendation</a>
        </div>
        <div class="navbar-right">
            <a href="signup.php" class="navbar-link">Sign Up</a>
        </div>
    </nav>
    <br><br><br>
    <div class="login-container">
        <h2>Sign in</h2>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php if ($error) : ?>
                <div class="error"><?php echo $error; ?></div>
                <br>
            <?php endif; ?>
            <input type="submit" name="submit" value="Sign in">
            <br>
            <br>
            <a href="index.php">Back</a>
        </form>
    </div>
</body>
</html>
