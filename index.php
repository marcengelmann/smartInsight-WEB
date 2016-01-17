<?php include("auth.php");
if(isset($_SESSION["username"])){
header("Location: dashboard.php");
echo("should have done something!");
exit(); }
?>
    <!--
    <!DOCTYPE html>
    <html>

    ?php include("header.html"); ?>

        <body>
            <div class="form">
                <p>Welcome
                    ?php echo $_SESSION['username']; ?>!</p>
                <p>This is secure area.</p>
                <p><a href="dashboard.php">Dashboard</a></p>
                <a href="logout.php">Logout</a>
            </div>
        </body>

    </html>-->
