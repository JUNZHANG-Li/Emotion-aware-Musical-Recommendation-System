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
    </nav>
    <br><br><br>
    <div class="login-container">
        <h2>Sign up</h2>
        <form action="signup_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="Music Enthusiasts">Music Enthusiasts</option>
                    <option value="Algorithm Developer">Algorithm Developer</option>
                </select>
            </div>
            <?php if ($error) : ?>
                <div class="error"><?php echo $error; ?></div>
                <br>
            <?php endif; ?>
            <input type="submit" name="submit" value="Sign up">
            <br>
            <br>
            <a href="login.php">Back</a>
        </form>
    </div>

    <script>
        const password = document.getElementById("password");
        const confirm_password = document.getElementById("confirm_password");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords do not match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
</body>
</html>
