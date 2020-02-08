<?php
// Start the session
include '../Header/sessionConnection.php';

// Include the back end for a forgetting password
include 'sendEmailForgotPassword.php'; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
</head>
<body class="is-preload">

<?php include '../Navigation/navigation.php' ?>

<!-- Main -->
<div id="main">
    <div class="wrapper">
        <div class="inner">

            <!-- Elements -->
            <header class="major">
                <h1>Find Your Password</h1>
                <p> An email will be sent with a new password.</p>
                <?php include 'errorsSignIn.php' ?>
            </header>
            <div class="row gtr-200">
                <div class="col-2"></div>
                <div class="col-8 col-12-medium col-12-small">

                    <!-- Form -->
                    <form method="post" action="forgotPasswordForm.php">
                        <div class="row gtr-uniform">
                            <div class="col-12 col-12-xsmall">
                                <h5 class="TitleForm">Email:</h5>
                                <i style="font-size:12px;"> * A new password will be send to you by email, it is possible to change the password afterward.</i>
                                    <input type="email" name="email" id="email" value="" placeholder="Email" required oninvalid="setCustomValidity('Email is invalid')" oninput="setCustomValidity('')"/>
                            </div>
                        </div>
                        <br>
                        <!-- Break -->
                        <div class="col-12">
                            <ul class="customActions">
                                <li><button type="submit" value="forgot_password" class="primary" name="forgot_password">Submit</button></li>
                                <li><button type="reset" value="Cancel" onclick="window.location.href='signIn.php'">Cancel</button></li>
                            </ul>
                        </div>
                </div>
                <div class="col-2"></div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- footer -->
<?php include '../Footer/footer.php' ?>

<!--Script Links-->
<?php include '../Footer/scriptsLinks.php'?>

</body>
</html>
