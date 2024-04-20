<form method="POST">
    <br>
    <br>
    <p>Select a model and enter the song title below</p>
    
    <select id="sim" name="sim" required onchange="toggleEmotion()">
    <!-- <select id="sim" name="sim" required> -->
        <option value="" disabled selected>Select Model</option>
        <option value="0"<?php if(isset($_POST['sim']) && $_POST['sim'] == '0') echo ' selected'; ?>>Doc2Vec</option>
        <option value="1"<?php if(isset($_POST['sim']) && $_POST['sim'] == '1') echo ' selected'; ?>>Sense</option>
        <option value="2"<?php if(isset($_POST['sim']) && $_POST['sim'] == '2') echo ' selected'; ?>>Sense & Intensity</option>
    </select>

    <!-- <select id="emo" name="emo" required style="display: none;"> -->
    <select id="emo" name="emo" style="display: none;">
        <option value="" disabled selected>Select Emotion</option>
        <option value="none"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'none') echo ' selected'; ?>>No Peference</option>
        <option value="wonder"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'wonder') echo ' selected'; ?>>Wonder</option>
        <option value="transcendence"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'transcendence') echo ' selected'; ?>>Transcendence</option>
        <option value="tenderness"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'tenderness') echo ' selected'; ?>>Tenderness</option>
        <option value="nostalgia"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'nostalgia') echo ' selected'; ?>>Nostalgia</option>
        <option value="peacefulness"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'peacefulness') echo ' selected'; ?>>Peacefulness</option>
        <option value="power"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'power') echo ' selected'; ?>>Power</option>
        <option value="joyful"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'joyful') echo ' selected'; ?>>Joyful</option>
        <option value="tension"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'tension') echo ' selected'; ?>>Tension</option>
        <option value="sadness"<?php if(isset($_POST['emo']) && $_POST['emo'] == 'sadness') echo ' selected'; ?>>Sadness</option>
    </select>

    <input type="text" id="song" name="song" placeholder="Enter a song" value="<?php echo isset($_POST['song']) ? $_POST['song'] : ''; ?>" required>
    <br>
    <input type="submit" name="recommendation" value="Get Recommendations">
</form>

<script>
    function toggleEmotion() {
        var simValue = document.getElementById("sim").value;
        var emoSelect = document.getElementById("emo");

        if (simValue === "0") {
            emoSelect.style.display = "none";
            emoSelect.removeAttribute("required");
        } else {
            emoSelect.style.display = "inline-block";
            emoSelect.setAttribute("required", "required");
        }
    }
    
    toggleEmotion()
</script>
