<?php
// Start the session
include '../Header/sessionConnection.php';

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'receipts');

// Get the id of the desired image to be deleted
$imgId = $_GET['idImageDelete'];

// Find encrypted path of file from the database with the image id
$path_get_query = "SELECT * FROM upload_receipts WHERE uploadId='$imgId'";
$result = mysqli_query($db, $path_get_query);
$path = mysqli_fetch_assoc($result);
$encrypt_image = $path['uploadImage']; // Store the encrypted path of the image

// Decryption
    // Include the decryption variables
    include '../Cryptography/cryptographyVariables.php';

    // Use openssl_decrypt() function to decrypt the receipts path
    $decryption = openssl_decrypt($encrypt_image, $cipherMethod,
        $decryption_key, $options, $nonce);

    // Store the decrypted path of the file
    $file_pointer = $decryption;

// Use unlink() function to delete a file
if (!unlink($file_pointer)) {
    echo("$file_pointer cannot be deleted due to an error");
} else {
    // Delete image in the database with the desired image id selected
    $queryDeleteUpload = "DELETE FROM upload_receipts WHERE uploadId = '$imgId'";
    mysqli_query($db, $queryDeleteUpload);
    // Redirect to the view Receipts page on the right category
    header('location: ./viewReceipts.php?categorySelect=' . $_GET["categorySelect"]);
}
?>