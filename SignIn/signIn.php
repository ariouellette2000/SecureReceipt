<?php
// Start the session
include 'serverSignIn.php';
?>

<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
	<head>
		<title>Sign in</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Main -->
			<div id="main">
				<div class="wrapper">
					<div class="inner">

						<!-- Elements -->
							<header class="major">
								<h1>Sign In</h1>
                                <p>Not a member yet? Register <a href="../Registration/register.php"><strong style="color: #dfb516; text-decoration:underline">HERE</strong></a></p>
                                <?php if(isset($_SESSION["userNewRegister"])){?>
                                    <div class="isa_success" >
                                        <i class="fa fa-check-circle"></i>
                                        <?php echo 'Your account has been created. Please sign in. ';?>
                                    </div>
                                <?php } ?>
                                <?php if(isset($_GET['sendEmail'])):?>
                                    <p><?PHP echo $_GET['sendEmail'];?></p>
                                <?php  elseif(isset($_GET['adminType'])):?>
                                    <p><?PHP echo $_GET['adminType'];?></p>
                                <?php  endif;?>
                                <?php include 'errorsSignIn.php' ?>
								     </header>
							<div class="row gtr-200">
                                <div class="col-2 "></div>
								<div class="col-8 col-12-medium col-12-small">

									<!-- Form -->
										<form method="post" action="signIn.php">
											<div class="row gtr-uniform">
												<div class="col-12 col-12-xsmall">
                                                    <h5 class="TitleForm">Email :</h5>
                                                    <?php if(isset($_SESSION["userNewRegister"])){?>
                                                        <input type="email" name="email" id="email" value="<?php echo $_SESSION["userNewRegister"];?>" placeholder="Email" required oninvalid="setCustomValidity('Email is invalid')" oninput="setCustomValidity('')"/>
                                                    <?php }else{ ?>
                                                        <input type="email" name="email" id="email" value="" placeholder="Email" required oninvalid="setCustomValidity('Email is invalid')" oninput="setCustomValidity('')"/>
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
                                                    <i id="pass-status" style="font-size: 125%;margin-top: 30px"
                                                       class="fa fa-eye" aria-hidden="true" onClick="myFunction()"></i>
                                                </div>
                                                    <script>
                                                        function myFunction() {
                                                            var passwordInput = document.getElementById('password_1');
                                                            var passStatus = document.getElementById('pass-status');

                                                            if (passwordInput.type == 'password'){
                                                                passwordInput.type='text';
                                                                passStatus.className='fa fa-eye-slash';

                                                            }
                                                            else{
                                                                passwordInput.type='password';
                                                                passStatus.className='fa fa-eye';
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                                <div class="col-12 col-12-xsmall" style="text-align: left; padding-top:1%">
                                                    <a href="forgotPasswordForm.php?"><strong style="text-decoration:underline">Forgot password?</strong></strong></a>
                                                </div>
												<!-- Break -->
												<div class="col-12">
													<ul class="customActions">
                                                        <li><button type="submit" value="SignIn" class="primary" name="submitSignIn">Sign In</button></li>
                                                        <li><button type="reset" value="Cancel" onclick="goBack()">Cancel</button></li>
                                                        <script language='javascript' type='text/javascript'>
                                                            function goBack() {
                                                                window.history.back();
                                                            }
                                                        </script>
                                                    </ul>
												</div>
											</div>
										</form>
								</div>
                                <div class="col-2"></div>
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
