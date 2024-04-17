<?php
require 'database.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    switch ($_POST['role']) {
        case "Music Enthusiasts":
            $role = 1;
            break;
        case "Algorithm Developer":
            $role = 2;
            break;
        default:
            $role = 0;
    }

    // Hash the password before storing it in the database (improve security)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    

    // Validate matching email and confirm email
    if ($password !== $confirm_password) {
        $error = "password and confirm password do not match.";
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    } 
    
    else {
        // Check if username or email already exists
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Username is already taken. Please take a new username.";
            header("Location: signup.php?error=" . urlencode($error));
            exit();
        } else {
            // Use prepared statement to insert user data
            $insert_query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($connection, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "sssi", $username, $email, $hashed_password, $role);

            // Execute the prepared statement
            if (!mysqli_stmt_execute($insert_stmt)) {
                error_log('Database Error: ' . mysqli_error($connection));
                die('Oops! Something went wrong. Please try again later.');
            } else {
                echo '<script>alert("Account created successfully! Click Close to return to the login screen"); window.location.href = "login.php";</script>';
                exit();
            }
        }
    }
}

mysqli_close($connection);
?>
