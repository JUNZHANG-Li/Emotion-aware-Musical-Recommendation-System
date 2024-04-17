<?php
session_start();

if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to the login page (or any other desired page after logout)
    header("Location: index.php");
    exit();
}
?>
