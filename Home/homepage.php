<?php
// Start the session
include '../Header/sessionConnection.php';

// Connect to the databases
$db = mysqli_connect('localhost','root','','photography');

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Vanilla Picture</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="is-preload">

<?php include '../Navigation/Navigation.php' ?>

<!-- Banner -->
<div id="banner">
    <div class="wrapper style1 special">
        <div class="inner">
            <h1 class="heading alt">VANILLA PICTURE</h1>
            <p>Photographer</p>

            <div class="image fit special video">
                <img src="../../images/homepage_frontcover.jpg" alt="" />
            </div>
            <ul class="feature-icons">
                <li><a href=https://www.instagram.com/vanilla_picture/?hl=fr-ca" class="a_socialMedia"><span class="icon fa-instagram"></span><span class="label">Instagram</span></a></li>
                <li><a href="http://facebook.com/VANILLAPICTURE/" class="a_socialMedia"><span class="icon fa-facebook"></span><span class="label">Facebook</span></a></li>
                <li><a href="#getInTouch" class="a_socialMedia"><span class="icon fa-envelope"></span><span class="label">Gmail</span></a></li>
            </ul>
        </div>
    </div>
</div>

<!-- One -->
<div id="one">
    <div class="wrapper special">
        <div class="inner">
            <header class="major">
                <h2>BIOGRAPHY</h2>
            </header>
            <div  class="image fit special biblio">
                <img src="../../images/homepage_biblio.jpg" alt="" />
            </div>
            <p class="special">
                Sophie, better known under the name of Vanilla Picture,
                is enjoying tremendous success. A pianist and artist at heart,
                she showcases all her talent through photography,
                a passion that has inhabited her since a very young age.
                Sophie had the chance to photograph several models, actors and influencers.
                Since 2017, his career has taken off with photo shoots from around
                the world. Companies such as National Bank, Little Burgundy,
                the <i>Journal de Montréal</i>, <i>TVA nouvelle</i> have used Vanilla Picture's
                creations.
            </p>
            <ul class="actions">
                <li><a href="../Gallery/gallery.php" class="button">My work</a></li>
            </ul>
        </div>
    </div>
</div>


<!--                            Announcement -->
<?php
// Insert the announcement information in the table announcement in the database
$queryAnnouncement = "SELECT * FROM announcement";
$resultPost = mysqli_query($db, $queryAnnouncement);

if ($resultPost) { // if user exists
    echo '<br><br>
                                    <div id="one">
                                        <div class="wrapper special">
                                            <div class="inner">
                                                <header class="major">
                                                    <h2 id="announcementSection">ANNOUNCEMENT</h2>
                                                </header>';
    if (isset($_GET['sendEmailApplication'])) {?>
        <div class="isa_success" >
            <i class="fa fa-check-circle"></i>
                <?php echo $_GET['sendEmailApplication'];?>
        </div>
    <?php
    }
    if(isset($_GET['DeleteMessage'])){?>
        <div class="isa_success" >
            <i class="fa fa-check-circle"></i>
                <?php echo $_GET['DeleteMessage'];?>
        </div>
<?php
    }
    $noElements = false;
    foreach ($resultPost as $eachPost) {
        // Verify if end date is after now and start date is before now
        if ((strtotime($eachPost['announcementEndDate']) > strtotime('now')) && strtotime($eachPost['announcementStartDate']) <= strtotime('now')) {
            echo '<p class="announcementHome"> <strong>'.$eachPost['announcementTitle'].'</strong><br>'
                .$eachPost['announcementDetail'].'  - <small><i>By Sophie Perras</i></small>';
            // Only administrator can modify annoucement
            if(isset($_SESSION['userSignIn']) && $_SESSION['userTypeSignIn'] === 'administrator'){
                $idLink = '../Announcement/modifyAnnouncementForm.php?announcementId='.$eachPost['announcementId'];
                if($eachPost['announcementModel'] === '1') {
                    echo '<br><i class="linkHomeAnnouncement" style="text-decoration: none;"> * This announcement is a model search</i>';
                }
                echo '<br><a class="linkHomeAnnouncement" href='.$idLink.'> Modify </a>';
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                echo '<a style="cursor:pointer" class="linkHomeAnnouncement" id="'.$eachPost['announcementId'].'" onclick="myDelete(this.id)">Delete</a>';?>
                <link rel="stylesheet" href="../../popUp/css/msc-style.css">
                <link rel="icon" type="image/png" href="/favicon.png">
                    <script src="../../popUp/js/msc-script.js"></script>
                    <script>
                        //Function for delete popup
                        function myDelete(clicked_id){
                            var typeOfPage = "announcement";
                            var categorySelect = "";
                            var subCategorySelect = "";
                            mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                  mscAlert("Post deleted");
                            });
                        }
                    </script>
<?php
            }
            else if(isset($_SESSION['userSignIn']) && $_SESSION['userTypeSignIn'] === 'model'){
                if($eachPost['announcementModel'] === '1') {
                    $idLink = '../Announcement/applyAnnouncementForm.php?announcementId=' . $eachPost['announcementId'] . '&announcementTitle=' . $eachPost['announcementTitle'];
                    echo '<br><a class="linkHomeAnnouncement" href=' . $idLink . '> Apply </a>';
                }
            }
            else{
                if($eachPost['announcementModel'] === '1') {
                    $idLink = '../Announcement/applyAnnouncementForm.php?announcementId='.$eachPost['announcementId'];
                    echo '<br><i class="linkHomeAnnouncement" style="text-decoration: none;">***If you wish to apply please <a class="linkHomeAnnouncement" href="../SignOut/SignOutToRegister.php">sign up</a> as a "Model"</i>';
                }
            }
            echo '</p>';
            $noElements = true;
        }
    }
    if($noElements === false){
        echo '<p> No announcements posted for now. Please come back later.</p>';
    }
    echo '                    <hr>
                                                    </div>
                                               </div>
                                            </div>
                                        </div>';
}
?>

<!-- Footer -->
<div id="footer">
    <div class="wrapper style2">
        <div class="inner">
            <header class="major">
                <h2 id = "getInTouch">Get in touch</h2>
                <p>Please fill out this form with your own information, to send an email to Sophie Perras.</p>
                <?php if(isset($_GET['sendEmailHome'])){
                    if($_GET['sendEmailHome'] === 'Email successfully sent'){
                    ?>
                        <div class="isa_success" >
                            <i class="fa fa-check-circle"></i>
                            <?php echo $_GET['sendEmailHome'];?>
                        </div>
                    <?php }else{?>
                        <div class="isa_error" >
                            <i class="fa fa-times-circle"></i>
                            <?php echo $_GET['sendEmailHome'];?>
                        </div>
                <?php
                }}?>

            </header>
            <div class="content">
                <div class="form">
                    <form method="post" action="sendEmailHomePage.php">
                        <div class="fields">
                            <div class="field half">
                                <h5 class="TitleForm">Name:</h5>
                                <input name="name" id="name" placeholder="Name" type="text" required oninvalid="setCustomValidity('Name is invalid')" oninput="setCustomValidity('')"/>
                            </div>
                            <div class="field half">
                                <h5 class="TitleForm">Email:</h5>
                                <input name="email" id="email" placeholder="Email" type="email"
                                    <?php if(isset($_SESSION['userSignIn'])){echo 'value="'.$_SESSION['userSignIn'].'"';}?>
                                       required oninvalid="setCustomValidity('Email is invalid')" oninput="setCustomValidity('')"/>
                            </div>
                            <div class="field">
                                <h5 class="TitleForm">Message:</h5>
                                <textarea name="message" id="message" rows="6" placeholder="Message"
                                          required oninvalid="setCustomValidity('Message is invalid')" oninput="setCustomValidity('')"></textarea>
                            </div>
                        </div>
                        <ul class="actions special">
                            <li><input type="submit" class="primary" name="sendMessage" class="button" value="Send Message" /></li>
                        </ul>
                    </form>
                </div>
                <ul class="icons">
                    <li>
                        <span class="icon fa-id-badge"></span>
                        <div>
                            <strong>Personal Account</strong>
                            <a href="https://www.instagram.com/vanillashowx/?hl=fr-ca">@vanillashowx</a>
                        </div>
                    </li>
                    <li>
                        <span class="icon fa-envelope"></span>
                        <div>
                            <strong>Email</strong>
                            <a href="mailto:information@domain.ext">Vanilla.picture@gmail.com</a>
                        </div>
                    </li>
                    <li>
                        <span class="icon fa-phone"></span>
                        <div>
                            <strong>Phone</strong>
                            (450) 806-6346
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

