<?php
// Start the session
include 'serverSignIn.php';
?>

<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Sign in</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
</head>
<body class="is-preload">

<!-- Main -->
<div id="main">
    <div class="wrapper">
        <div class="inner">
            <header class="major">
                <h1>Sign In</h1>
                <p>Not a member yet? Register <a href="../Registration/register.php"><strong style="color: #dfb516; text-decoration:underline;">HERE</strong></a></p>

<!--            Success Message (After a user has register) -->
                <?php if (isset($_SESSION["userNewRegister"])) { ?>
                    <div class="isa_success">
                        <i class="fa fa-check-circle"></i>
                        <?php echo 'Your account has been created. Please sign in. '; ?>
                    </div>
                <?php } ?>

<!--            Error Message (Wrong sign in information)-->
                <?php include 'errorsSignIn.php' ?>

            </header>
            <div class="row gtr-200">
                <div class="col-2 "></div>
                <div class="col-8 col-12-medium col-12-small">

                    <!-- SignIn Form -->
                    <form method="post" action="signIn.php">
                        <div class="row gtr-uniform">
                            <div class="col-12 col-12-xsmall">
                                <h5 class="TitleForm">Email :</h5>
                                <!-- Fill email input if the user just registered -->
                                <?php if (isset($_SESSION["userNewRegister"])) { ?>
                                    <input type="email" name="email" id="email"
                                           value="<?php echo $_SESSION["userNewRegister"]; ?>" placeholder="Email"
                                           required oninvalid="setCustomValidity('Email is invalid')"
                                           oninput="setCustomValidity('')"/>
                                <?php } else { ?>
                                    <input type="email" name="email" id="email" value="" placeholder="Email" required
                                           oninvalid="setCustomValidity('Email is invalid')"
                                           oninput="setCustomValidity('')"/>
                                <?php } ?>
                            </div>
                            <div class="col-11 col-11-xsmall">
                                <h5 class="TitleForm">Password :</h5>
                                <input type="password" name="password_1" id="password_1" value="" placeholder="Password"
                                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}"
                                       title="Password must contain between 6 and 20 characters, including UPPER/lowercase and numbers"
                                       required/>
                            </div>
                            <div class="col-1 col-1-xsmall">
<!--                                Eye icon to enable to user to see in text their password-->
                                <i id="pass-status" style="font-size: 125%;margin-top: 30px"
                                   class="fa fa-eye" aria-hidden="true" onClick="seeEyePW()"></i>
                            </div>
                            <script>
//                              Change input type password to text, for a user to view their password
                                function seeEyePW() {
                                    var passwordInput = document.getElementById('password_1');
                                    var passStatus = document.getElementById('pass-status');

                                    if (passwordInput.type == 'password') {
                                        passwordInput.type = 'text';
                                        passStatus.className = 'fa fa-eye-slash';

                                    } else {
                                        passwordInput.type = 'password';
                                        passStatus.className = 'fa fa-eye';
                                    }
                                }
                            </script>
                        </div>
                        <br>
                        <div class="col-12">
                            <ul class="customActions">
                                <li>
                                    <button type="submit" value="SignIn" class="primary" name="submitSignIn">Sign In
                                    </button>
                                </li>
                                <li>
                                    <button type="reset" value="Cancel" onclick="goBack()">Cancel</button>
                                </li>
                                <script language='javascript' type='text/javascript'>
                                    function goBack() {
                                        window.history.back();
                                    }
                                    }
                                </script>
                            </ul>
                        </div>
                </div>
                </form>
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
