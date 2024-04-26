<?php

    $mysqli = new mysqli("db", "admin", "secretpassword", "song_recommendation_database");
    $mysqli->query('SET GLOBAL local_infile=1');

    mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);
    $local_infile = 'SET GLOBAL local_infile=1';

    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    if ($result = $mysqli->query($local_infile)){
        // echo "local file is set \n";
    }else{
        echo $mysqli->error;
    }
    
    // Loading songs
    $result = $mysqli->query("SELECT * FROM `songs` LIMIT 1");
    if ($result && $result->num_rows > 0) {
        // echo "Table 'songs' is not empty. No need to load data.\n";
    } else {
        $loadDataSQL = "LOAD DATA LOCAL INFILE 'data/lyrics_summaries.txt'
                        INTO TABLE `songs`
                        FIELDS TERMINATED BY '#'
                        LINES TERMINATED BY '\n'
                        IGNORE 1 LINES
                        (id, title, summary)";

        // Execute the SQL statement
        if ($mysqli->query($loadDataSQL) === TRUE) {
            // echo "songs.txt loaded successfully.\n";
        } else {
            echo "Error loading data: " . $mysqli->error;
        }
    }
?>
