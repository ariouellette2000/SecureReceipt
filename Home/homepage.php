<?php
// Start the session
include '../Header/sessionConnection.php';
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Home</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="../assets/css/main.css"/>
    </head>
    <body class="is-preload">

    <?php
        // Add the navigation
        include '../Navigation/navigation.php'
    ?>

    <!-- Banner -->
    <div id="banner">
        <div class="wrapper style1 special">
            <div class="inner">
                <h1 class="heading alt">Secureceipt</h1>
                <p>One safety location for all your receipts.</p>
                <div class="img fit special video">
                    <img src="../images/safety.jpg" alt="" style="width:80%"/>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../Footer/footer.php' ?>
    <!--Script Links-->
    <?php include '../Footer/scriptsLinks.php' ?>
    </body>
</html>

