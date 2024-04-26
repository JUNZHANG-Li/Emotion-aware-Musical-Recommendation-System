<div class="results">
<?php
    // Get user input
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
        // Construct URL with ID as query parameter
        $recommendation_model_url = "http://recommendation:5000/doc2vec";
        $id = $row['id'];
        $script_url = "$recommendation_model_url?id=$id";

        // Call the Python service using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $script_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON output to convert it into an array of strings
        $output = json_decode($output, true);

        if (empty($output)) {
            die("<br><br><br><h3>Connection failed, please try again later.</h3>");
        }

        echo "<h3>Result:</h3>";
        echo "<table>"; 
        echo "<tr> <th>Title</th> <th>Similarity</th> </tr>";
        
        for ($i = 0; $i < count($output)-1; $i++) {
            // Clean data
            // $output_info = explode(" ; ", $output[$i]);
            $output_info = $output[$i];

            // SQL
            require 'setup_database.php';
            $result = songTitle($mysqli, $output_info[0]);
            $mysqli->close();
            $row = $result->fetch_assoc();
            $songId = $output_info[0];
            $songTitle = $row['title'];
            
            // Output results

            $songSim = strval(round($output_info[1], 1)) . "%";

            echo "<tr>";
            echo "<td><h3><a href='song_details.php?id=" . $songId . "' target='_blank' style='color: black;'>$songTitle</h3></td><td>$songSim</td>";
            echo "</tr>";
        }
        echo "</table><br><br>";

    }

    // WordNet model
    if ($sim == '1' OR $sim == '2') {
        // Read Emotion Peference
        $emo = $_POST['emo'];

        // Construct URL with ID as query parameter
        $recommendation_model_url = "http://recommendation:5000/wordnet";
        $id = $row['id'];
        $script_url = "$recommendation_model_url?id=$id&sim=$sim&emo=$emo";

        // Call the Python service using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $script_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON output to convert it into an array of strings
        $output = json_decode($output, true);

        // No result found
        if ($output == null) {
            die("<br><br><br><h3>Connection failed, please try again later.</h3>");
        }
                
        // Output the result
        // echo $output[count($output)-1][0] . "<br>";
        // echo $output[count($output)-1][1] . "<br>";
        echo "<h3>Result:</h3>";
        echo "<table>"; 
        echo "<tr> <th>Title</th> <th>Similarity</th> </tr>";
        
        for ($i = 0; $i < count($output)-2; $i++) {
            // Clean data
            // $output_info = explode(" ; ", $output[$i]);
            $output_info = $output[$i];

            // SQL
            require 'setup_database.php';
            $result = songTitle($mysqli, $output_info[0]);
            $mysqli->close();
            $row = $result->fetch_assoc();
            $songId = $output_info[0];
            $songTitle = $row['title'];
            
            if ($sim == '1') {
                $songSim = strval(round($output_info[1], 1)) . "%";
            } else if ($sim == '2') {
                $songSim = strval(round($output_info[1], 2));
            }

            echo "<tr>";
            echo "<td><h3><a href='song_details.php?id=" . $songId . "' target='_blank' style='color: black;'>$songTitle</h3></td><td>$songSim</td>";
            echo "</tr>";
        }
        echo "</table><br><br>";
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