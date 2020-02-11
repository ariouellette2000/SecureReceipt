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
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../assets/css/gallery.css"/>

</head>
<body class="is-preload">

<?php include '../Navigation/navigation.php' ?>
<!-- Main -->
<div id="main">
    <div class="wrapper">
        <div class="inner">
            <!-- Elements -->
            <header class="major">
                <h1>Receipts</h1>

                <!--                Button go back to the top-->
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
                <!--                End of button top function-->

                <!--                Dropdown of category choice-->
                <?php
                // Categories
                $upload_cat_name_query = "SELECT DISTINCT uploadCategory FROM upload_receipts WHERE uploadCategory IS NOT NULL";
                $upload_result_cat_name = mysqli_query($db, $upload_cat_name_query);
                if (mysqli_num_rows($upload_result_cat_name) > 0) {
                    while ($upload_cat = mysqli_fetch_assoc($upload_result_cat_name)) {
                        $categoriesChoices[] =$upload_cat['uploadCategory'];
                    }
                }
                ?>
                <!--                View receipts category navigation-->
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
                                foreach ($categoriesChoices as $categoryChoice) {
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
                <!--                    End of receipts category dropdown-->

            </header>
            <div class="row">

                <!--                 The Modal -->
                <div id="myModal" class="modal">

                    <!--                     The Close Button -->
                    <span class="closeModal">&times;</span>

                    <!--                     Modal Content (The Image) -->
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                    <!--                     Modal Caption (Image Text) -->
                    <div id="deleteButton">
                        <button style="background-color: transparent;"
                                id="deleteImg" class="reset" value="deleteImg">Delete
                        </button>
                    </div>
                </div>




                <!--            Verify the category of a receipt directly when the dropdown is changed-->
                <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
                <script>
                    // //Get the category
                    $(document).ready(function () {
                        var value = "";
                        $("#category").change(function () {
                            value = $(this).val();
                            window.location.href= 'viewReceipts.php?categorySelect='+value;
                        });
                    });
                </script>


                <!--                Loops to display or view all receipts-->
                <?php
                $categorySelected = '';
                if (isset($_GET['categorySelect'])) {
                    $categorySelected = $_GET['categorySelect'];
                }

                //                Get all receipts informations from the database
                //DECRYPTION
                if (!($categorySelected === '')) {
                    // Select query for specific gallery elements
                    $gallery_check_query = "SELECT * FROM upload_receipts WHERE uploadCategory='$categorySelected'";

                } else {
//                         Select query for all gallery elements
                    $gallery_check_query = "SELECT * FROM upload_receipts";
                }
                $gallery_result = mysqli_query($db, $gallery_check_query);

                if (mysqli_affected_rows($db) >= 1) {
                    // Loop through all images
                    while ($gallery = mysqli_fetch_assoc($gallery_result)) {

                        $encrypt_image = $gallery['uploadImage'];

                        //Decryption
                        // Cipher method used
                        $cipherMethod = "AES-128-CTR";

                        // Use OpenSSl Encryption method
                        $nonce_length = openssl_cipher_iv_length($cipherMethod);
                        $options = 0;

                        // Initialization Vector or Nonce used later with secret key
                        $nonce = '1234567891011121';

                        // Encryption key

                        //Get password in database
                        $email = $_SESSION['userNewSignIn'];
                        $user_password_query = "SELECT userPassword FROM receipts WHERE userId = '$email'";
                        $user_result_password = mysqli_query($db, $user_password_query);
                        if (mysqli_num_rows($user_result_password) > 0) {
                            while ($user_pw = mysqli_fetch_assoc($user_result_password)) {
                                $passwordDb =$user_pw['userPassword'];
                            }
                        }
                        $decryption_key = $passwordDb;
                        //generate with openssl_random_pseudo_bytes

                        // Use openssl_decrypt() function to decrypt the data
                        $decryption = openssl_decrypt ($encrypt_image, $cipherMethod,
                            $decryption_key, $options, $nonce);


                        $images[] = $decryption;
                        $ids[] = $gallery['uploadId'];
                        $captions[] = $gallery['uploadCaption'];
                        $categories[] = $gallery['uploadCategory'];
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
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] .'">';
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
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] .'">';
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
                            echo '<img class="imgGallery" id="' . $ids[$i] . '"src="' . $images[$i] . '" alt="' . $captions[$i] . '" name="' . $categories[$i] . '">';
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

                    var modal = document.getElementById("myModal");
                    // Get the image and insert it inside the modal - use its "alt" text as a caption
                    var modalImg = document.getElementById("img01");
                    var captionText = document.getElementById("caption");
                    var imgs = document.getElementsByTagName("img");
                    var deleteButton = document.getElementById("deleteImg");
                    for (var i = 0; i < imgs.length; i++) {
                        var img = document.getElementById(imgs[i].id);
                        var curImageId = "";
                        img.onclick = function () {

                            modal.style.display = "block";
                            modalImg.src = this.src;
                            var altText = this.alt;

                            // captionText.innerHTML = altText;
                            curImageId = this.id;


                            //Delete a receipt
                            deleteButton.onclick = function () {
                                var clicked_id = curImageId;
                                var typeOfPage = "viewReceipt";
                                var categorySelect = "";
                                var subCategorySelect = "";
                                <?php if(!isset($_GET["categorySelect"])){?>
                                mscConfirm(typeOfPage, categorySelect, subCategorySelect, clicked_id, "Delete?", function () {
                                    mscAlert("Post deleted");
                                });
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