<?php
// Start the session
include '../Header/sessionConnection.php';

// Connect to the databases
$db = mysqli_connect('localhost','root','','photography');

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="is-preload">

<?php include '../Navigation/navigation.php' ?>

<!-- Banner -->
<div id="banner">
    <div class="wrapper style1 special">
        <div class="inner">
            <h1 class="heading alt">Secureceipt</h1>
            <p>One safety location for all your receipts.</p>

            <div class="img fit special video">
                <img src="../images/safety.jpg" alt="" style="width:80%"/>
            </div>
            <ul class="feature-icons">
                <li><a href=https://www.instagram.com/vanilla_picture/?hl=fr-ca" class="a_socialMedia"><span class="icon fa-instagram"></span><span class="label">Instagram</span></a></li>
                <li><a href="http://facebook.com/VANILLAPICTURE/" class="a_socialMedia"><span class="icon fa-facebook"></span><span class="label">Facebook</span></a></li>
                <li><a href="#getInTouch" class="a_socialMedia"><span class="icon fa-envelope"></span><span class="label">Gmail</span></a></li>
            </ul>
        </div>
    </div>
</div>

                    </li>
                </ul>
            </div>
        </div>
        <!-- footer -->
        <?php include '../Footer/footer.php' ?>
    </div>
</div>
<!--Script Links-->
<?php include '../Footer/scriptsLinks.php'?>
<script src="dist/gModal.min.js"></script>
<link href="dist/gModal.min.css" rel="stylesheet" />
</body>
</html>

