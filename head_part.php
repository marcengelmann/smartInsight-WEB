<div id="headpart">
    <a href="index.php"><h1><img id="icon" src="images/512.png">Smart Insight</h1></a>
    <?php if(isset($_SESSION["username"])){ ?>
        <div id="menu_box"><a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a> </div>
        <?php } ?>
            <div id="welcome_box">Willkommen,
                <?php if(isset($_SESSION["username"])){ echo $_SESSION['username']; } else { echo "Gast"; }?>!</div>
</div>
