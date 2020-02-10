<?php

$imgId = $_GET['idImageDelete'];

// Start the session
include '../Header/sessionConnection.php';

// Connect to the database
$db = mysqli_connect('localhost','root','','receipts');

// Find path of file
$path_get_query = "SELECT * FROM upload_receipts WHERE uploadId='$imgId'";
$result = mysqli_query($db, $path_get_query);
$path = mysqli_fetch_assoc($result);

$file_pointer = $path['uploadImage'];

// Use unlink() function to delete a file
    if (!unlink($file_pointer)) {
        echo ("$file_pointer cannot be deleted due to an error");
    }
    else {

//  Delete image in the database
        $queryDeleteUpload = "DELETE FROM upload_receipts WHERE uploadId = '$imgId'";
        mysqli_query($db, $queryDeleteUpload);
        header('location: ./viewReceipts.php?categorySelect='.$_GET["categorySelect"]);
    }
?>