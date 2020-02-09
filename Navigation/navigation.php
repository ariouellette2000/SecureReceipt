<!-- Header -->
<?php
// Start the session
include '../Header/sessionConnection.php';

echo '<header id="header" class="alt">
        <nav id="nav">
        <ul>
            <li class="current"><a href="../Home/homepage.php">Home</a></li>
        ';

            if(!(isset($_SESSION['userNewSignIn']))) {
                echo '<li><a href="../SignIn/signIn.php" class="icon fa-user-circle"> Sign In</a></li>';
            }else{
                //Put a dropdown here with add receipt, and view
                echo '<li><a href="../Receipts/viewReceipts.php">Receipts</a></li>';

                echo '<li><a href="../SignOut/signOut.php" class="icon fa-user-circle"> Sign Out</a></li>';
            }
        echo '</ul>
    </nav>
</header>';
?>