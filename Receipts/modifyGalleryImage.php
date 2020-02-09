<?php
// Start the session
include '../Header/sessionConnection.php';

// connect to the database
$db = mysqli_connect('localhost','root','','photography');

if(isset($_POST["save_caption"])) {
    // Caption
    $caption_form = mysqli_real_escape_string($db, $_POST['caption']);
    if($caption_form === ''){
        $caption_form = null;
    }

    $id_form = mysqli_real_escape_string($db, $_POST['imgId']);
    $category_form = mysqli_real_escape_string($db, $_POST['imgCategory']);
    $sub_category_form = mysqli_real_escape_string($db, $_POST['imgSubCategory']);

    $queryGalleryUpdate = "UPDATE gallery SET galleryTitle='$caption_form' WHERE galleryId='$id_form'";
    mysqli_query($db, $queryGalleryUpdate);

        if($category_form === 'Brands'||$category_form === 'Portraits'||$category_form === 'Events') {
            header("location: ./viewReceipts.php?categorySelect=" . $category_form . "&subCategorySelect=" . $sub_category_form . "#". $imgId);
        }else{
            header("location: ./viewReceipts.php?categorySelect=" . $category_form. "#". $id_form);
        }

}
