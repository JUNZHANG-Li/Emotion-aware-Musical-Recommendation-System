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
