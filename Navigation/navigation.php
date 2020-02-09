<!-- Header -->
<?php
// Start the session
include '../Header/sessionConnection.php';

echo '<header id="header" class="alt">
    <nav id="nav">
        <ul>
            <li class="current"><a href="../Home/homepage.php">Home</a></li>
            <li>
                    <a href="../Gallery/gallery.php">Gallery</a>
            </li>';

            echo '<li><a href="../Shop/packages.php">Packages</a></li>
                    <li><a href="../Agenda/agenda.php">Agenda</a></li>
                    ';



            if(!(isset($_SESSION['userSignIn']))) {
                echo '<li><a href="../SignIn/signIn.php" class="icon fa-user-circle"> Sign in</a></li>';
            }
            else{
                if ($_SESSION['userTypeSignIn'] === 'administrator') :
                    echo '<li><a>Administration</a>
                            <ul>
                                <li><a class="navdrop" href="../Announcement/announcement.php" style="color:white;">Announcement</a></li>
                              
                                <li><a class="navdrop" href="../Reports/reportsSummary.php" style="color:white;">Reports</a></li>
                            </ul>
                          </li>';
                endif;


                echo '<li><a href="../Profile/viewProfile.php" class="icon fa-user-circle"> Profile</a>';
                    echo '<ul>
                        <li><a class="navdrop" href="../SignOut/signOut.php" style="color:white;"> Sign Out</a></li>
                    </ul>';
                    echo '</li>';
            }
        echo '</ul>
    </nav>
</header>';
?>