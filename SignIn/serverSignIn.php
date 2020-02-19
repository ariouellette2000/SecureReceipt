<?php

// Start the session
include '../Header/sessionConnection.php';

// Initializing main variables
$email = "";
$password_1 = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'receipts');

// Verify if the visitor has sign in, only user that have not sign in yet can acccess to page
if (!isset($_SESSION['userNewSignIn'])) {

// Verify if the sign in form has been submitted
    if (isset($_POST['submitSignIn'])) {
        // Receive all input values from the form
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

        // First check the database to make sure a user does exist with the same email
        $user_check_query = "SELECT * FROM receipts WHERE userId='$email'";
        $resultUser = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($resultUser);

        // Verify if a record is found in the database
        if (!($user)) {
            // Verify if the user has already register
            if (!($user['userId'] === $email)) {
                // Pass an error if the email already exist in the db
                array_push($errors, "Email does not exist. ");
            }
        } else {
            // PRESENTATION
            // Verify that entered password fits the password in the database
            $salt = $email; // Insert a salt to hash
            $saltedPassword = $email . $password_1; // Concatenate the final plaintext
            if (password_verify($saltedPassword, $user['userPassword'])) { // Compare the entered pw with the hashed password in the database
                $_SESSION['userNewSignIn'] = $email; // Store the email of the user signing in, in a session
                unset($_SESSION['userNewRegister']); // Unsaved the email of the last account that has registered
                header('location: ../Home/homepage.php');
            } else {
                // Pass an error if the password is not the same from the database
                array_push($errors, "Password is invalid. ");
            }
        }
    }
} else {
    // Redirect to the sign out page if the user is already sign in
    header('location: ../SignOut/signOut.php');
} ?>
