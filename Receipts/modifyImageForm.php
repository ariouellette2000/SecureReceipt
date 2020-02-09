<?php
include 'modifyGalleryImage.php';
// Start the session
include '../Header/sessionConnection.php';

$db = mysqli_connect('localhost','root','','photography');

if(isset($_GET['modificationId'])){
    if(isset($_SESSION['userSignIn'])&& $_SESSION['userTypeSignIn'] === 'administrator') {
        $imgId = $_GET['modificationId'];
        $gallery_retrieve_query = "SELECT * FROM gallery WHERE galleryId='$imgId'";
        $gallery_result = mysqli_query($db, $gallery_retrieve_query);

        if (mysqli_affected_rows($db) >= 1) {
            // Loop through all images
            while ($gallery = mysqli_fetch_assoc($gallery_result)) {
                $image = $gallery['galleryImage'];
                $category = $_GET['categorySelect'];
                $caption = $gallery['galleryTitle'];
                $subCategory = $_GET['subCategorySelect'];
            }
        }?>


<!--        HTML-->
        <!DOCTYPE HTML>
            <html lang="en">
                <head>
                    <title>Modify Caption</title>
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
                                            <h1>Modify Caption</h1>
                                            <p>Fill out the form to modify the caption.</p>
                                        </header>
                                    <div style="margin:auto">
                                        <div class="row gtr-200">
                                                <!-- Form -->
                                                    <form method="post" action="modifyImageForm.php">
                                                        <div class="row gtr-uniform">
                                                                <div class="image special fit biblio" style="padding-left: 0px;padding-top:0px; ">
                                                                    <img class="biblio" id="<?php $imgId; ?>"src="<?php echo $image ?>">
                                                                </div>

<!--                                                            Hidden field to go back from the modification page-->
                                                            <input type="hidden" name="imgId" id="imgId" value="<?php echo $imgId;?>">
                                                            <input type="hidden" name="imgCategory" id="imgCategory" value="<?php echo $category;?>">
                                                            <?php if($category === 'Brands'||$category === 'Events'||$category === 'Portraits'){?>
                                                                    <input type="hidden" name="imgSubCategory"
                                                                    id="imgSubCategory" value="<?php echo $subCategory;?>">
                                                            <?php } ?>


                                                            <div class="col-8 col-12-xsmall" style="padding-top:0px;">
                                                                <h5 class="TitleForm">Caption:</h5>
                                                                <input type="text" name="caption" id="caption" value="<?php echo $caption;?>" placeholder="Caption" maxlength="100"/>
                                                            </div>
                                                            <!-- Break -->
                                                            <div class="col-12">
                                                                <ul class="actions">
                                                                    <li><button type="submit" value="Submit" class="primary" name="save_caption">Save</button></li>
                                                                    <li><button type="reset" value="Cancel" onclick="goBack()">Cancel</button></li>
                                                                    <script language='javascript' type='text/javascript'>
                                                                        function goBack() {
                                                                            window.history.back();
                                                                        }
                                                                    </script>
                                                            </div>
                                                        </div>
                                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!--                footer-->
                <?php include '../Footer/footer.php' ?>

                <!--Script Links-->
                <?php include '../Footer/scriptsLinks.php'?>

                </body>
            </html>
<?php
    }
}
?>

