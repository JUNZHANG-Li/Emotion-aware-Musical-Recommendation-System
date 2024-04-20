<?php 
require_once 'setup_database.php'; 
$mysqli->close();

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Recommendation</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
    
<nav class="navbar">
    <div class="navbar-left">
        <a href="index.php" class="navbar-link-title">Song Recommendation</a>
    </div>
    <div class="navbar-right">
        <?php if (isset($_SESSION['username'])) : ?>
            <!-- <a href="records.php" class="navbar-link">Records</a> -->
            <a href="userpage.php" class="navbar-link">Welcome, <?php echo $_SESSION['username']; ?></a>
        <?php else : ?>
            <a href="login.php" class="navbar-link">Account</a>
        <?php endif; ?>
    </div>
</nav>

<form method="POST">
    <br><br>
    <p>Select a model and enter the song title below</p>
    <select id="sim" name="sim" required>
        <option value="" disabled>Doc2Vec: </option>
        <option value="0"<?php if(isset($_POST['sim']) && $_POST['sim'] == '0') echo ' selected'; ?>>General (fast)</option>
        <option value="" disabled>WordNet: </option>
        <option value="1"<?php if(isset($_POST['sim']) && $_POST['sim'] == '1') echo ' selected'; ?>>Sense</option>
        <option value="2"<?php if(isset($_POST['sim']) && $_POST['sim'] == '2') echo ' selected'; ?>>Sense & Intensity</option>
    </select>
    <input type="text" id="song" name="song" placeholder="Enter a song" value="<?php echo isset($_POST['song']) ? $_POST['song'] : ''; ?>" required>
    <br>
    <input type="submit" name="recommendation" value="Get Recommendations">
</form>

<div class="results">
    <?php
        if (isset($_POST['recommendation'])) {
            $sim = $_POST['sim'];
            $song = $_POST['song'];

            // SQL
            require 'setup_database.php';
            $result = songId($mysqli, $song);
            $mysqli->close();

            // Fetch result
            $row = $result->fetch_assoc();
            if ($row == null) {
                die("<br><br><br><h3>Sorry, the song '$song' is not support yet</h3>");
            }
            
            // Doc2Vec model
            if ($sim == '0') {                
                // Execute recommendation model
                $command = escapeshellcmd("python3 doc2vec.py " . $row['id']);
                $output = shell_exec($command);
    
                if ($output == null) {
                    die("<br><br><br><h3>Connection failed, please try again later.</h3>");
                }
                
                $output = explode("\n", $output);
                
                // Output the result
                echo "<h3>Result:</h3>";
    
                echo "<table>"; 
                echo "<tr> <th>Title</th> <th>Similarity</th> </tr>";
                
                for ($i = 0; $i < count($output)-1; $i++) {
                    // Clean data
                    $output_info = explode(" ; ", $output[$i]);
    
                    // SQL
                    require 'setup_database.php';
                    $result = songTitle($mysqli, $output_info[0]);
                    $mysqli->close();
                    $row = $result->fetch_assoc();
                    $songTitle = $row['title'];
                    
                    // Output results
                    $songSim = strval(round($output_info[1], 1)) . "%";
    
                    echo "<tr>";
                    echo "<td><h3>$songTitle</h3></td><td>$songSim</td>";
                    echo "</tr>";
                }
                echo "</table><br><br>";

            }

            // WordNet model
            if ($sim == '1' OR $sim == '2') {
                // Execute recommendation model
                $command = escapeshellcmd("python3 script.py " . $row['id'] . " " . $sim);
                $output = shell_exec($command);
    
                if ($output == null) {
                    die("<br><br><br><h3>Connection failed, please try again later.</h3>");
                }
                
                $output = explode("\n", $output);
                
                // Output the result
                echo "<br><h3>Result:</h3><br><br>";
    
                echo "<table>"; 
                echo "<tr> <th>Title</th> <th>Similarity</th> </tr>";
                
                for ($i = 0; $i < count($output)-1; $i++) {
                    // Clean data
                    $output_info = explode(" ; ", $output[$i]);
    
                    // SQL
                    require 'setup_database.php';
                    $result = songTitle($mysqli, $output_info[0]);
                    $mysqli->close();
                    $row = $result->fetch_assoc();
                    $songTitle = $row['title'];
    
                    if ($sim == '1') {
                        $songSim = strval(round($output_info[1], 1)) . "%";
                    } else if ($sim == '2') {
                        $songSim = strval(round($output_info[1], 2));
                    }
    
                    echo "<tr>";
                    echo "<td><h3>$songTitle</h3></td><td>$songSim</td>";
                    echo "</tr>";
                }
                echo "</table><br><br>";
            }
                    
        }
    ?>
</div>
</body>
</html>

<?php
    function songId($mysqli, $song) {
        $sql = "SELECT id FROM `songs` WHERE title = ?";
        
        // Prepare the statement
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $song);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            // Handle error if preparation fails
            die("Preparation failed: " . $mysqli->error);
        }
    }

    function songTitle($mysqli, $song) {
        $sql = "SELECT title FROM `songs` WHERE id = ?";
        
        // Prepare the statement
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $song);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            // Handle error if preparation fails
            die("Preparation failed: " . $mysqli->error);
        }
    }
?>