<?php
// PRESENTATION
// Cipher method used
$cipherMethod = "AES-128-CTR"; // CipherMethod is the method used to encrypt and decrypt
// AES-CTR is the counter mode for AES encryption, it XOR the text

// Use OpenSSl Encryption method
$options = 0; // Bitwise disjunction (fast & simple) of OPENSSL_RAW_DATA and OPENSSL_ZERO_PADDING
// Zero is the default value

// Initialization Nonce used later with secret key
$nonce = '1234567891011121'; // a number that is used only once, in order to improve the security in this program, more precisely the authentication, the nonce should be random

//
//  //Here is another alternative for using the nonce, but generated randomly
//  $nonce_length = openssl_cipher_iv_length($cipherMethod); // Length
//  $encryption_nonce = random_bytes($iv_length);  // Generate randomly 16 digit values
//  $decryption_nonce = random_bytes($iv_length);   // Repeat for decryption
//  // $encryption_nonce and $decryption_nonce would be in the openssl_decrypt or openssl_encrypt as the $nonce variable
//


//Get password (key) from database
$email = $_SESSION['userNewSignIn']; // Get the email of the connected user
$user_password_query = "SELECT userPassword FROM receipts WHERE userId = '$email'";
$user_result_password = mysqli_query($db, $user_password_query);
if (mysqli_num_rows($user_result_password) > 0) {
    while ($user_pw = mysqli_fetch_assoc($user_result_password)) {
        $passwordDb = $user_pw['userPassword']; // Store the hashed password
    }
}
// Initialize the decryption or encryption key with the hashed password
$encryption_key = $passwordDb;
$decryption_key = $passwordDb;// A symmetric key, the same has the encryption key, got through the hashed password in the db
