<?php include 'serverAddReceipts.php'; ?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Add Image</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">

    <?php include '../Navigation/navigation.php' ?>

		<!-- Main -->
			<div id="main">
				<div class="wrapper">
					<div class="inner">
						<!-- Elements -->
							<header class="major">
								<h1>Add a Receipt</h1>
								<p>Please fill out the form to add a receipt.</p>
                                <?php include 'errorsReceipts.php' ?>
							</header>
                        <div style="margin:auto">
							<div class="row gtr-200">
									<!-- Form -->
										<form method="post" action="addReceipts.php" enctype="multipart/form-data">
											<div class="row gtr-uniform">

                                                <?php
                                                 // Connect to the database
                                                $db = mysqli_connect('localhost','root','','receipts');

                                                // Categories
                                                $upload_cat_name_query = "SELECT DISTINCT uploadCategory FROM upload_receipts WHERE uploadCategory IS NOT NULL";
                                                $upload_result_cat_name = mysqli_query($db, $upload_cat_name_query);
                                                if (mysqli_num_rows($upload_result_cat_name) > 0) {
                                                    while ($upload_cat = mysqli_fetch_assoc($upload_result_cat_name)) {
                                                        $categoriesChoices[] = $upload_cat['uploadCategory'];
                                                    }
                                                }
                                                ?>
                                                <div class="col-8 col-12-small col-12-xsmall" id="dropdownCategory">
                                                    <h5 class="TitleForm">Category: </h5>
                                                    <select name="category" id="category" title="Category" required oninvalid="setCustomValidity('Category is invalid')" oninput="setCustomValidity('')">
                                                        <option value="" selected hidden>-Select Category-</option>
                                                        <?php
                                                        if(mysqli_num_rows($upload_result_cat_name)>0){
                                                            foreach ($categoriesChoices as $choiceBrand) {
                                                                ?>
                                                                    <option value="<?= $choiceBrand ?>" title="<?= $choiceBrand ?>"><?= $choiceBrand ?></option>
                                                                <?php
                                                            }?>
                                                            <?php
                                                        }?>
                                                        <option value="Other" title="Other">Other</option>
                                                    </select>
                                                </div>

                                                <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#category").change(function () {
                                                            var value = $(this).val();
                                                            $('.otherCategoriesDiv').remove();
                                                            if(value == 'Other') {
                                                                $('#dropdownCategory').append('<div class="otherCategoriesDiv"><h5 class="TitleForm">New Category: </h5><input type="text" name="newCategory" id="newCategory" placeholder="New Category Name" maxlength="100" required/></div>');
                                                            }
                                                        });
                                                    });
                                                </script>

												<div class="col-8 col-12-small col-12-xsmall">
                                                    <h5 class="TitleForm">Notes: </h5>
                                                    <input type="text" name="caption" id="caption" value="" placeholder="Notes" maxlength="100" title="Please fill out this field." />
                                                </div>
                                                <div class="col-8 col-12-small col-12-xsmall">
<!--                                                    Upload image here-->
                                                    <h5 class="TitleForm">Select image to upload:</h5>
                                                    <input type="file" name="fileToUpload" id="fileToUpload" required>

                                                </div>
												<!-- Break -->
												<div class="col-12">
													<ul class="actions">
                                                        <li><button type="submit" value="Submit" class="primary" name="submitImage">Submit</button></li>
                                                        <li><button type="reset" value="Cancel" onclick="goGallery()">Back</button></li>
                                                        <script language='javascript' type='text/javascript'>
                                                            function goGallery() {
                                                               window.location.href ="viewReceipts.php";
                                                            }
                                                        </script></ul>
												</div>
											</div>
										</form>
							</div>
						</div>
                    </div>
                </div>
			</div>

    <?php include '../Footer/footer.php' ?>

    <!--Script Links-->
    <?php include '../Footer/scriptsLinks.php'?>

	</body>
</html>

