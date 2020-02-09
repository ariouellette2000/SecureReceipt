<?php
    // Include the back end of the sign out form
    include 'serverSignOut.php';
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Sign Out</title>
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
								<h1>Sign Out</h1>
                                <p>Are You Sure You Want to Exit?</p>
							<div class="row gtr-200">
								<div class="col-12 col-12-medium">

                                    <!-- Form -->
                                    <form method="post" action="signOut.php">
                                        <div class="row gtr-uniform">
                                    <div class="col-12">
                                        <ul class="customActions">
<!--                                            If press the user will be sign out-->
                                            <li><button type="submit" value="SignOut" class="primary" name="signOut_user">Sign Out</button></li>
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