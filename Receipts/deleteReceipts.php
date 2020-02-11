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
$encrypt_image = $path['uploadImage'];


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

$file_pointer = $decryption;

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