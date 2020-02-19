<?php
// Start the session
include '../Header/sessionConnection.php';

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'receipts');
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Receipts</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../assets/css/gallery.css"/>

</head>
<body class="is-preload">

<?php include '../Navigation/navigation.php' ?>
<!-- Main -->
<div id="main">
    <div class="wrapper">
        <div class="inner">
            <header class="major">
                <h1>Receipts</h1>

<!--            Begins button go back to the top-->
                <button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-angle-double-up">Top</button>
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

                <!--                Dropdown of category choice-->
                <?php
                // Get the categories from the database to the eventually place it in the dropdown
                $email = $_SESSION['userNewSignIn']; // Only select the categories associated with the connected user
                $upload_cat_name_query = "SELECT DISTINCT uploadCategory FROM upload_receipts WHERE uploadCategory IS NOT NULL AND userId = '$email'";
                $upload_result_cat_name = mysqli_query($db, $upload_cat_name_query);
                if (mysqli_num_rows($upload_result_cat_name) > 0) {
                    while ($upload_cat = mysqli_fetch_assoc($upload_result_cat_name)) {
                        $categoriesChoices[] = $upload_cat['uploadCategory']; // Store all categories in a array
                    }
                }
                ?>

<!--            Category dropdown-->
                <div class="row">
                    <div class="col-10 col-10-small col-10-xsmall" id="dropdownCategory">
                        <select name="category" id="category" title="Category" required oninvalid="setCustomValidity('Category is invalid')" oninput="setCustomValidity('')">
                            <?php
                            if(isset($_GET['categorySelect'])){
                                if(isset($_GET['categorySelect']) != "") { ?>
                                    <option value="" selected hidden>-Select a Category-</option>
                                    <?php
                                } }else{
                                ?>
                                <option value="" selected hidden>-Select a Category-</option>
                                <?php
                            }?>
                            <?php
                            if(mysqli_num_rows($upload_result_cat_name)>0){
                                foreach ($categoriesChoices as $categoryChoice) { // Go through the category array initialize previously
                                    if(!isset($_GET['categorySelect'])){
                                        echo '<option value="' . $categoryChoice . '" title="' . $categoryChoice . '">' . $categoryChoice . '</option>';
                                    }else{
                                        if($_GET['categorySelect'] === $categoryChoice) {
                                            echo '<option value="' . $categoryChoice . '" title="' . $categoryChoice . '" selected>' . $categoryChoice . '</option>';
                                        }else{
                                            echo '<option value="' . $categoryChoice . '" title="' . $categoryChoice . '">' . $categoryChoice . '</option>';
                                        }
                                    }
                                }?>
                                <?php
                            }?>
                        </select>
                    </div>
                    <div class="col-2 col-2-small col-2-xsmall" id="dropdownCategory">
                        <a href="addReceipts.php" class="addReceipts"><span>&#43</span></a>
                    </div>
                </div>
            </header>
            <div class="row">
<!--            The Modal -->
                <div id="myModal" class="modal">
<!--                The Close Button -->
                    <span class="closeModal">&times;</span>
<!--                 Modal Content (The Image) -->
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
<!--                Delete Button -->
                    <div id="deleteButton">
                        <button style="background-color: transparent;"
                                id="deleteImg" class="reset" value="deleteImg">Delete
                        </button>
                    </div>
                </div>


<!--            Verify the category of a receipt directly when the dropdown is changed-->
                <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
                <script>
                    // Create an input type text if the chosen category is "Other"
                    $(document).ready(function () {
                        var value = "";
                        $("#category").change(function () { // Detect if there is any change to the category dropdown
                            value = $(this).val(); // Store the value of the dorpdown
                            window.location.href= 'viewReceipts.php?categorySelect='+value; //Reload the page depending on the selected category
                        });
                    });
                </script>


<!--            Loops to display or view all receipts-->
                <?php
                // Set the selected category
                $categorySelected = '';
                if (isset($_GET['categorySelect'])) {
                    $categorySelected = $_GET['categorySelect'];
                }

                // Get all receipts information from the database
                $email = $_SESSION['userNewSignIn'];
                if (!($categorySelected === '')) {
                    // Select query for specific gallery elements
                    $gallery_check_query = "SELECT * FROM upload_receipts WHERE uploadCategory='$categorySelected' AND userId='$email'";

                } else {
                    // Select query for all gallery elements
                    $gallery_check_query = "SELECT * FROM upload_receipts WHERE userId='$email'";
                }
                $gallery_result = mysqli_query($db, $gallery_check_query);

                if (mysqli_affected_rows($db) >= 1) {
                    // Loop through all images
                    while ($gallery = mysqli_fetch_assoc($gallery_result)) {

                            $encrypt_image = $gallery['uploadImage']; // Store the encrypted path of the image

                            // PRESENTATION
                            //Decryption
                                // Include the decryption variables
                                include '../Cryptography/cryptographyVariables.php';

                                // Use openssl_decrypt() function to decrypt the data
                                $decryption = openssl_decrypt($encrypt_image, $cipherMethod,
                                    $decryption_key, $options, $nonce);

                            // Store all receipts information in arrays
                            $images[] = $decryption;
                            $ids[] = $gallery['uploadId'];
                            $captions[] = $gallery['uploadCaption'];
                            $categories[] = $gallery['uploadCategory'];
                    }

                // Display all receipts images in columns
                    // Initialize column index
                    $columnIndex = 1;

                    // Column 1
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) { // Restart index each times it comes to 4
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 1) { // Only display images with the column index 1
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] .'">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';

                    // Initialize column index
                    $columnIndex = 1;

                    // Column2
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) { // Restart index each times it comes to 4
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 2) { // Only display images with the column index 2
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] .'">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';

                    // Initialize column index
                    $columnIndex = 1;

                    // Column 3
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) { // Restart index each times it comes to 4
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 3) { // Only display images with the column index 3
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] . '">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';

                    // Initialize column index
                    $columnIndex = 1;

                    // Column 3
                    echo '<div class="column">';
                    for ($i = 0; $i < count($images); $i++) {
                        if ($columnIndex > 4) { // Restart index each times it comes to 4
                            $columnIndex = 1;
                        }
                        if ($columnIndex == 4) { // Only display images with the column index 4
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] .'">';
                        }
                        $columnIndex++;
                    }
                    echo '</div>';
                } else {
                    echo '<p>The selected category has no pictures.</p>';
                }
                ?>


                <script language='javascript' type='text/javascript'>
                // When a user clicked on an image the div modal appears so the image is zoomed
                    // Get the modal attribute and all images
                    var modal = document.getElementById("myModal");
                    var modalImg = document.getElementById("img01");
                    var captionText = document.getElementById("caption");
                    var imgs = document.getElementsByTagName("img");
                    var deleteButton = document.getElementById("deleteImg");

                    //Go through all images of the gallery
                    for (var i = 0; i < imgs.length; i++) {
                        // Get the clicked image
                        var img = document.getElementById(imgs[i].id);
                        var curImageId = "";
                        img.onclick = function () {

                            // Use its "alt" text as a caption, the
                            modal.style.display = "block";
                            modalImg.src = this.src; // Use its "src" text as the source of the current zoomed image
                            captionText.innerHTML = this.alt; //  Use its "alt" text as a caption, the
                            curImageId = this.id; // Use its "id" as the current zoomed image


                            // When the user clicks on the delete button in the modal
                            deleteButton.onclick = function () {
                                var clicked_id = curImageId;
                                var typeOfPage = "viewReceipt"; // Specif the page in case the pop up is used in other pages
                                var categorySelect = "";
                                var subCategorySelect = ""; // Additional feature in the future for a sub category

                                // No category selected
                                <?php if(!isset($_GET["categorySelect"])){?>
                                mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                    mscAlert("Post deleted");
                                });

                                // Selected category
                                <?php }else{?>
                                categorySelect = "<?php echo $_GET["categorySelect"];?>";
                                mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                    mscAlert("Post deleted");
                                });
                                <?php } ?>
                            };
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

<link rel="stylesheet" href="../popUp/css/msc-style.css">
<link rel="icon" type="image/png" href="/favicon.png">
<script src="../popUp/js/msc-script.js"></script>

</body>
</html>