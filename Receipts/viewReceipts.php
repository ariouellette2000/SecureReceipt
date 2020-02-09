<?php
// Start the session
include '../Header/sessionConnection.php';

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'photography');
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Gallery</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link rel="stylesheet" href="../../assets/css/main.css"/>
    <link rel="stylesheet" href="../../assets/css/gallery.css"/>

</head>
<body class="is-preload">

<?php include '../Navigation/navigation.php' ?>
<!-- Main -->
<div id="main">
    <div class="wrapper">
        <div class="inner">
            <?php if (isset($_SESSION['userTypeSignIn']) && $_SESSION['userTypeSignIn'] === 'administrator') { ?>
                <a href="addReceipts.php"><span>&#43</span> Add Image</a>
            <?php } ?>
            <!-- Elements -->
            <header class="major">
                <h1>Gallery</h1>
                
<!--                Button go back to the top-->
                <button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-angle-double-up"></button>
                <script>
                mybutton = document.getElementById("myBtn");

                // When the user scrolls down 20px from the top of the document, show the button
                window.onscroll = function() {scrollFunction()};

                function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
                } else {
                mybutton.style.display = "none";
                }
                }

                // When the user clicks on the button, scroll to the top of the document
                function topFunction() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                }
                </script>
                <div class="row">
                    <div class="col-2-small col-2-xsmall"></div>
                    <div class="col-12 col-12-medium col-8-small col-8-xsmall">
                <ul class="customActions2">
                    <li>
                        <button class="customActions2Buttons" id="all" type="button" value="All"
                                onclick="location.href= 'viewReceipts.php'">All
                        </button>
                    </li>
                    <li>
                        <button class="customActions2Buttons" id="travel" type="button" value="Travel"
                                onclick="location.href= 'viewReceipts.php?categorySelect=travel'">Travel
                        </button>
                    </li>
                    <?php
                    // Look for any events name
                    $gallery_event_name_query = "SELECT DISTINCT gallerySubCategory FROM gallery WHERE gallerySubCategory IS NOT NULL AND galleryCategory = 'Events'";
                    $gallery_result_event_name = mysqli_query($db, $gallery_event_name_query);
                    if (mysqli_num_rows($gallery_result_event_name) > 0) {
                        while ($gallery_event = mysqli_fetch_assoc($gallery_result_event_name)) {
                            if ($gallery_event['gallerySubCategory'] != null)
                                $eventsChoices[] = $gallery_event['gallerySubCategory'];
                        }
                    }
                    ?>
                    <li class="dropdownHovering">
                        <button class="customActions2Buttons" id="events" type="button" value="Events"
                                onclick="location.href= 'viewReceipts.php?categorySelect=events'">Events
                        </button>
                        <div class="dropContents">
                            <ul class="dropotron level-0 right"
                                style=" user-select:none; position:absolute; z-index:100000; opacity:1;margin-top: 0px;">
                                <?php if (mysqli_num_rows($gallery_result_event_name) > 0) { ?>
                                    <?php foreach ($eventsChoices as $choiceEvent) : ?>
                                        <li style="cursor:pointer;padding-left:0px;">
                                            <button class="navdrop"
                                                    onclick="location.href= './viewReceipts.php?categorySelect=events&subCategorySelect=<?php echo $choiceEvent; ?>'"
                                                    style="box-shadow:none;white-space: nowrap; "><small
                                                        style="color:white;"><?php echo $choiceEvent; ?></small>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <li style="cursor:pointer;padding-left:0px;">
                                        <button class="navdrop"
                                                onclick="location.href= 'viewReceipts.php'"
                                                style="box-shadow:none;white-space: nowrap; "><small
                                                    style="color:white;">All</small></button>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php
                    // Look for any brands name
                    $gallery_brand_name_query = "SELECT DISTINCT gallerySubCategory FROM gallery WHERE gallerySubCategory IS NOT NULL AND galleryCategory = 'Brands'";
                    $gallery_result_brand_name = mysqli_query($db, $gallery_brand_name_query);
                    if (mysqli_num_rows($gallery_result_brand_name) > 0) {
                        while ($gallery_brand = mysqli_fetch_assoc($gallery_result_brand_name)) {
                            if ($gallery_brand['gallerySubCategory'] != null)
                                $brandsChoices[] = $gallery_brand['gallerySubCategory'];
                        }
                    }
                    ?>
                    <li class="dropdownHovering">
                        <button class="customActions2Buttons" id="brands" type="button" value="Brands"
                                onclick="location.href= 'viewReceipts.php?categorySelect=brands'">Brands
                        </button>
                        <div class="dropContents">
                            <ul class="dropotron level-0 right"
                                style=" user-select:none; position:absolute; z-index:100000; opacity:1;margin-top: 0px;">
                                <?php if (mysqli_num_rows($gallery_result_brand_name) > 0) { ?>
                                    <?php foreach ($brandsChoices as $choiceBrand) : ?>
                                        <li style="cursor:pointer;padding-left:0px;">
                                            <button class="navdrop"
                                                    onclick="location.href= './viewReceipts.php?categorySelect=brands&subCategorySelect=<?php echo $choiceBrand; ?>'"
                                                    style="box-shadow:none;white-space: nowrap; "><small
                                                        style="color:white;"><?php echo $choiceBrand; ?></small>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <li style="cursor:pointer;padding-left:0px;">
                                        <button class="navdrop"
                                                onclick="location.href= 'viewReceipts.php'"
                                                style="box-shadow:none;white-space: nowrap; "><small
                                                    style="color:white;">All</small></button>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>

                    <?php
                    // Look for any portraits name
                    $gallery_portrait_name_query = "SELECT DISTINCT gallerySubCategory FROM gallery WHERE gallerySubCategory IS NOT NULL AND galleryCategory = 'Portraits'";
                    $gallery_result_portrait_name = mysqli_query($db, $gallery_portrait_name_query);
                    if (mysqli_num_rows($gallery_result_portrait_name) > 0) {
                        while ($gallery_portrait = mysqli_fetch_assoc($gallery_result_portrait_name)) {
                            if ($gallery_portrait['gallerySubCategory'] != null)
                                $portraitsChoices[] = $gallery_portrait['gallerySubCategory'];
                        }
                    }
                    ?>
                    <li class="dropdownHovering">
                        <button class="customActions2Buttons" id="portraits" type="reset" value="Portraits"
                                onclick="location.href= 'viewReceipts.php?categorySelect=portraits'">Portraits
                        </button>
                        <div class="dropContents">
                            <ul class="dropotron level-0 right"
                                style=" user-select:none; position:absolute; z-index:100000; opacity:1;margin-top: 0px;">
                                <?php if (mysqli_num_rows($gallery_result_portrait_name) > 0) { ?>
                                    <?php foreach ($portraitsChoices as $choicePortrait) : ?>
                                        <li style="cursor:pointer;padding-left:0px;">
                                            <button class="navdrop"
                                                    onclick="location.href= './viewReceipts.php?categorySelect=portraits&subCategorySelect=<?php echo $choicePortrait; ?>'"
                                                    style="box-shadow:none;white-space: nowrap; "><small
                                                        style="color:white;"><?php echo $choicePortrait; ?></small>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <li style="cursor:pointer;padding-left:0px;">
                                        <button class="navdrop"
                                                onclick="location.href= 'viewReceipts.php'"
                                                style="box-shadow:none;white-space: nowrap; "><small
                                                    style="color:white;">All</small></button>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
                </div>
                    <div class="col-2-small col-2-xsmall"></div>
            </header>
            <div class="row">

                <!--                 The Modal -->
                <div id="myModal" class="modal">

                    <!--                     The Close Button -->
                    <span class="closeModal">&times;</span>

                    <!--                     Modal Content (The Image) -->
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                    <?php if (isset($_SESSION['userSignIn']) && $_SESSION['userTypeSignIn'] === 'administrator') { ?>
                        <!--                     Modal Caption (Image Text) -->
                        <div id="deleteButton">
                            <button style="width:30%;border:1px solid white; color:white;background-color: transparent;"
                                    id="deleteImg" class="reset" value="deleteImg">Delete
                            </button>
                        </div>
                    <?php } else { ?>
                        <div id="buttons" style="text-align: center">
                            <button style="width:20%;border-style:none; color:white;background-color: transparent;font-size:30px;"
                                    id="previousImg" class="reset" value="previousImg">&#8592;
                            </button>
                            <button style="width:20%;border-style:none; color:white;background-color: transparent;font-size:30px;"
                                    id="nextImg" class="reset" value="nextImg">&#8594;
                            </button>
                        </div>
                    <?php } ?>
                </div>
                <?php
                $categorySelected = '';
                if (isset($_GET['categorySelect'])) {
                    $categorySelected = $_GET['categorySelect'];
                }

                if (!($categorySelected === '' || $categorySelected === 'all')) {
                    // Select query for specific gallery elements
                    $gallery_check_query = "SELECT * FROM gallery WHERE galleryCategory='$categorySelected'";
                    if (isset($_GET['subCategorySelect'])) {
                        $brandsNameSelected = $_GET['subCategorySelect'];
                        if ($brandsNameSelected !== '') {
                            $gallery_check_query = "SELECT * FROM gallery WHERE galleryCategory='$categorySelected' AND gallerySubCategory='$brandsNameSelected'";
                        }
                    }
                } else {
//                         Select query for all gallery elements
                    $gallery_check_query = "SELECT * FROM gallery";
                }
                $gallery_result = mysqli_query($db, $gallery_check_query);

                if (mysqli_affected_rows($db) >= 1) {
                    // Loop through all images
                    while ($gallery = mysqli_fetch_assoc($gallery_result)) {
                        $images[] = $gallery['galleryImage'];
                        $ids[] = $gallery['galleryId'];
                        $captions[] = $gallery['galleryTitle'];
                        $subCategories[] = $gallery['gallerySubCategory'];
                        $categories[] = $gallery['galleryCategory'];
                    }

                    // Initialize column index
                    $columnIndex = 1;

                    // Display images
                    echo '<div class="column 1">';

                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) {
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 1) {
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" value="' . $subCategories[$i] . '" name="' . $categories[$i] .'">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';

                    $columnIndex = 1;
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) {
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 2) {
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" value="' . $subCategories[$i] . '" name="' . $categories[$i] .'">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';

                    $columnIndex = 1;
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) {
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 3) {
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" value="' . $subCategories[$i] . '" name="' . $categories[$i] . '">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';

                    $columnIndex = 1;
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) {
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 4) {
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" value="' . $subCategories[$i] . '" name="' . $categories[$i] .'">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';
                } else {
                    echo '<p>The selected category has no pictures.</p>';
                }
                ?>
                <script language='javascript' type='text/javascript'>
                    var modal = document.getElementById("myModal");

                    // Get the image and insert it inside the modal - use its "alt" text as a caption
                    var modalImg = document.getElementById("img01");
                    var captionText = document.getElementById("caption");
                    var imgs = document.getElementsByTagName("img");
                    var deleteButton = document.getElementById("deleteImg");
                    var nextButton = document.getElementById('nextImg');
                    var previousButton = document.getElementById('previousImg');
                    for (var i = 0; i < imgs.length; i++) {
                        var img = document.getElementById(imgs[i].id);
                        var curImageId = "";
                        img.onclick = function () {
                            var jsnewArrayId = new Array();
                            var jsnewArrayCaption = new Array();
                            var jsnewArraySource = new Array();
                            var jsnewArraySubCategory = new Array();
                            <?php foreach($ids as $key => $val){ ?>
                            jsnewArrayId.push('<?php echo $val; ?>');
                            <?php } ?>
                            <?php foreach($captions as $key => $val){ ?>
                            jsnewArrayCaption.push('<?php echo $val; ?>');
                            <?php } ?>
                            <?php foreach($images as $key => $val){ ?>
                            jsnewArraySource.push('<?php echo $val; ?>');
                            <?php } ?>
                            <?php foreach($subCategories as $key => $val){ ?>
                            jsnewArraySubCategory.push('<?php echo $val; ?>');
                            <?php } ?>



                            modal.style.display = "block";
                            modalImg.src = this.src;
                            var altText = this.alt;
                            var subCategory = this.getAttribute("value");
                            var category = this.getAttribute("name");

                            captionText.innerHTML = altText
                                <?php if(isset($_SESSION['userSignIn']) && $_SESSION['userTypeSignIn'] === 'administrator'):?>
                                + '&nbsp;' +
                                '<a href="./modifyImageForm.php?modificationId=' + this.id +
                                '&categorySelect=' + category +
                                '&subCategorySelect=' + subCategory +
                                '"' + 'class="pencil"><i class="fa fa-pencil"></i></a>'
                                <?php endif; ?>.concat("<br><i>".concat(subCategory.concat("</i>")));
                            curImageId = this.id;


                            if (nextButton || previousButton) {
                                if (this.id === jsnewArrayId[jsnewArrayId.length - 1]) {
                                    // alert(nextId)
                                    nextButton.style.visibility = "hidden";
                                } else {
                                    nextButton.style.visibility = "visible";
                                }

                                if (this.id === jsnewArrayId[0]) {
                                    previousButton.style.visibility = "hidden";
                                } else {
                                    previousButton.style.visibility = "visible";
                                }

                                previousButton.onclick = function () {
                                    var boolArray2 = false;
                                    var previousId = "";
                                    var previousCaption = "";
                                    var previousSource = "";
                                    var previousSubCategory = "";

                                    for (var i = jsnewArrayId.length; i >= 0; i--) {
                                        if (boolArray2 === true) {
                                            previousId = jsnewArrayId[i];
                                            previousCaption = jsnewArrayCaption[i];
                                            previousSource = jsnewArraySource[i];
                                            previousSubCategory = jsnewArraySubCategory[i];
                                            boolArray2 = false;
                                        }
                                        if (jsnewArrayId[i] === curImageId) {
                                            boolArray2 = true;
                                        }
                                    }

                                    if (previousId === jsnewArrayId[jsnewArrayId.length - 1]) {
                                        // alert(nextId)
                                        nextButton.style.visibility = "hidden";
                                    } else {
                                        nextButton.style.visibility = "visible";
                                    }

                                    if (previousId === jsnewArrayId[0]) {
                                        previousButton.style.visibility = "hidden";
                                    } else {
                                        previousButton.style.visibility = "visible";
                                    }


                                    modalImg.src = previousSource;
                                    var altText = previousCaption;
                                    var subCategory = previousSubCategory;
                                    captionText.innerHTML = altText
                                        <?php if(isset($_SESSION['userSignIn']) && $_SESSION['userTypeSignIn'] === 'administrator'):?>
                                        + '&nbsp;' +
                                        '<a href="./modifyImageForm.php?modificationId=' + previousId +
                                        '&categorySelect=' + category +
                                        '&subCategorySelect=' + subCategory +
                                        '"' + 'class="pencil"><i class="fa fa-pencil"></i></a>'
                                        <?php endif; ?>.concat("<br><i>".concat(subCategory.concat("</i>")));
                                    curImageId = previousId;
                                };

                                nextButton.onclick = function () {
                                    var boolArray = false;
                                    var nextId = "";
                                    var nextCaption = "";
                                    var nextSource = "";
                                    var nextSubCategory = "";

                                    for (var i = 0; i < jsnewArrayId.length; i++) {
                                        if (boolArray === true) {
                                            nextId = jsnewArrayId[i];
                                            nextCaption = jsnewArrayCaption[i];
                                            nextSource = jsnewArraySource[i];
                                            nextSubCategory = jsnewArraySubCategory[i];
                                            boolArray = false;
                                        }
                                        if (jsnewArrayId[i] === curImageId) {
                                            boolArray = true;
                                        }
                                    }

                                    if (nextId === jsnewArrayId[jsnewArrayId.length - 1]) {
                                        // alert(nextId)
                                        nextButton.style.visibility = "hidden";
                                    } else {
                                        nextButton.style.visibility = "visible";
                                    }

                                    if (nextId === jsnewArrayId[0]) {
                                        previousButton.style.visibility = "hidden";
                                    } else {
                                        previousButton.style.visibility = "visible";
                                    }
                                    modalImg.src = nextSource;
                                    var altText = nextCaption;
                                    var subCategory = nextSubCategory;
                                    captionText.innerHTML = altText
                                        <?php if(isset($_SESSION['userSignIn']) && $_SESSION['userTypeSignIn'] === 'administrator'):?>
                                        + '&nbsp;' +
                                        '<a href="./modifyImageForm.php?modificationId=' + nextId +
                                        '&categorySelect=' + category +
                                        '&subCategorySelect=' + subCategory +
                                        '"' + 'class="pencil"><i class="fa fa-pencil"></i></a>'
                                        <?php endif; ?>.concat("<br><i>".concat(subCategory.concat("</i>")));
                                    curImageId = nextId;
                                };
                            } else {
                                deleteButton.onclick = function () {
                                    var clicked_id = curImageId;
                                    var typeOfPage = "gallery";
                                    var categorySelect = "";
                                    var subCategorySelect = "";
                                    <?php if(!isset($_GET["categorySelect"])){?>

                                        mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                            mscAlert("Post deleted");
                                        });
                                    <?php }else{?>
                                    <?php if(isset($_GET["subCategorySelect"])){?>
                                        categorySelect = "<?php echo $_GET['categorySelect']?>";
                                        subCategorySelect = "<?php echo $_GET['subCategorySelect']?>";
                                        mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                            mscAlert("Post deleted");
                                        });
                                    <?php }else{?>
                                         categorySelect = "<?php echo $_GET['categorySelect']?>";
                                        mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                            mscAlert("Post deleted");
                                        });
                                    <?php } ?>
                                    <?php } ?>
                                };
                            }
                        };
                    }


                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName("closeModal")[0];

                    // When the user clicks on <span> (x), close the modal
                    span.onclick = function () {
                        modal.style.display = "none";
                    };
                </script>
            </div>
        </div>
    </div>
</div>
</div>


<?php include '../Footer/footer.php' ?>

<!--Script Links-->
<?php include '../Footer/scriptsLinks.php'?>

<link rel="stylesheet" href="../../popUp/css/msc-style.css">
<link rel="icon" type="image/png" href="/favicon.png">
<script src="../../popUp/js/msc-script.js"></script>

</body>
</html>