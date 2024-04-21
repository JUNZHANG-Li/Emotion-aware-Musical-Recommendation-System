<?php
require_once 'setup_database.php'; // Check DB status

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://redis:6379');
session_start(); // Read Account Info


// Prevent Direct Navigation 
directNavigation();

// Retrieve songId from the URL query string
$songId = isset($_GET['id']) ? intval($_GET['id']) : -1;

// Get Song Details
if ($songId !== -1) {
    $sql = "SELECT title, summary FROM `songs` WHERE id = ?";
    // Prepare the statement
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $songId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_assoc();
        $songTitle = $row['title'];
        $songSummary = $row['summary'];
    } else {
        // Handle error if preparation fails
        die("Preparation failed: " . $mysqli->error);
    }
}
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <td><b>Title:</b></td>
            <td><br><b><?php echo $songTitle; ?></b><br><br></td>
        </tr>
        <tr>
            <td><b>Summary:</b></td>
            <td><?php echo $songSummary; ?></td>
        </tr>
    </table>
</body>

</html>

<?php

function directNavigation() {
    $errorMessage = "Direct navigation is not allowed. Sorry for the inconvenience.";
    
    if(isset($_SERVER['HTTP_REFERER'])) {
        $historyArray = explode(';', $_SERVER['HTTP_REFERER']);
        if(empty($historyArray)) {
            showErrorMessage($errorMessage);
        }
    } else {
        showErrorMessage($errorMessage);
    }
}

function showErrorMessage($message) {
    echo "
        <script>
            window.alert('$message');
            window.location = 'index.php';
        </script>
    ";
}

?>
