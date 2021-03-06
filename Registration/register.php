<?php
// Include the back end for the registration page
include 'serverRegistration.php';

// Verify if the user is sign in, if not continue
if (!isset($_SESSION['userNewSignIn'])) {
    ?>

    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <title>Register</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="../assets/css/main.css"/>
    </head>
    <body class="is-preload">

    <!-- Main -->
    <div id="main">
        <div class="wrapper">
            <div class="inner">
                <header class="major">
                    <h1>Sign up</h1>
                    <p>Create a new account here</p>
<!--                    Include the error message for the registration form -->
                    <?php include "errorsRegistration.php" ?>
                </header>
                <div style="margin:auto">
                    <div class="row gtr-200">
                        <!-- Form -->
                        <h3>Register</h3>
                        <form method="post" action="register.php">
                            <div class="row gtr-uniform">
                                <div class="col-8 col-12-small col-12-xsmall">
                                    <h5 class="TitleForm">Email:</h5>
                                    <input type="email" name="email" id="email" value="" placeholder="Email" required
                                           oninvalid="setCustomValidity('Email is invalid')"
                                           oninput="setCustomValidity('')"/>
                                </div>
                                <div class="col-8 col-11-small col-11-xsmall">
                                    <h5 class="TitleForm">Password:</h5>
                                    <input type="password" name="password_1" id="password_1" value=""
                                           placeholder="Password"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}"
                                           title="Password must contain between 6 and 20 characters, including UPPER/lowercase and numbers"
                                           required oninvalid="setCustomValidity('Password is invalid')"
                                           oninput="setCustomValidity('')"/>
                                </div>
                                <div class="col-1 col-1-xsmall">
<!--                                    Eye icon to enable to user to see in text their password-->
                                    <i id="pass-status" style="font-size: 125%;margin-top: 30px"
                                       class="fa fa-eye" aria-hidden="true" onClick="seeEyePWReg()"></i>
                                </div>

                                <script>
//                                   Change input type password to text, for a user to view their password
                                    function seeEyePWReg() {
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
                                <div class="col-8 col-11-small col-11-xsmall">
                                    <h5 class="TitleForm">Confirm password:</h5>
                                    <input type="password" name="password_2" id="password_2" value=""
                                           placeholder="Confirm Password"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}"
                                           title="Please enter the same Password as above"
                                           oninput="check(this)"
                                           required/>
                                    <script language='javascript' type='text/javascript'>
//                                        Verify if the Confirm password field matches with the first password field
                                        function check(input) {
                                            if (input.value != document.getElementById('password_1').value) {
                                                // Input is invalid -- set the error message
                                                input.setCustomValidity('Password Must Match.');
                                            } else {
                                                // Input is valid -- reset the error message
                                                input.setCustomValidity('');
                                            }
                                        }
                                    </script>
                                </div>
                                <div class="col-1 col-1-xsmall">
                                    <i id="pass-status-2" style="font-size: 125%;margin-top: 30px"
                                       class="fa fa-eye" aria-hidden="true" onClick="modifEyeIcon()"></i>
                                </div>

                                <script>
//                                    Modify the eye icon depending on his status
                                    function modifEyeIcon() {
                                        var passwordInput = document.getElementById('password_2');
                                        var passStatus = document.getElementById('pass-status-2');

                                        if (passwordInput.type == 'password') {
                                            // User sees input type text, eye with a slash
                                            passwordInput.type = 'text';
                                            passStatus.className = 'fa fa-eye-slash';

                                        } else {
                                            // User sees input type password, open eye
                                            passwordInput.type = 'password';
                                            passStatus.className = 'fa fa-eye';
                                        }
                                    }
                                </script>
<!--                                About you section, can contain further personal information if desired-->
                                <div class="col-8 col-12-small col-12-xsmall">
                                    <h3>About you...</h3>
                                </div>
                                <div class="col-8 col-12-small col-12-xsmall">
                                    <h5 class="TitleForm">FirstName:</h5>
                                    <input type="text" name="firstName" id="firstName" value="" placeholder="First Name"
                                           maxlength="20" required oninvalid="setCustomValidity('FirstName is invalid')"
                                           oninput="setCustomValidity('')"/>
                                </div>
                                <div class="col-8 col-12-small col-12-xsmall">
                                    <h5 class="TitleForm">LastName:</h5>
                                    <input type="text" name="lastName" id="lastName" value="" placeholder="Last Name"
                                           maxlength="20" required oninvalid="setCustomValidity('LastName is invalid')"
                                           oninput="setCustomValidity('')"/>
                                </div>
                                <div class="col-12">
                                    <ul class="actions">
                                        <li>
                                            <button type="submit" value="Signup" class="primary" name="reg_user_button">
                                                Sign up
                                            </button>
                                        </li>
                                        <li>
                                            <button onclick="location.href='../SignIn/signIn.php'" type="reset"
                                                    value="Cancel">Cancel
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p>
                    Already a member? <a href="../SignIn/signIn.php" style="color: #dfb516; text-decoration: underline">Sign
                        in</a>
                </p>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../Footer/footer.php' ?>

    <!--Script Links-->
    <?php include '../Footer/scriptsLinks.php' ?>

    </body>
    </html>
<?php } else {
    header('location: ../SignOut/signOut.php');
} ?>
