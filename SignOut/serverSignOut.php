<?php
// Start session
include '../Header/sessionConnection.php';

// Verify if the user is sign in
if (isset($_SESSION['userNewSignIn'])) {
    // Verify if the user has press the sign out button
    if (isset($_POST['signOut_user'])) {
        // Unset sessions, set during the sign in
        unset($_SESSION['userNewSignIn']);
        // Go back to the home page when a user sign out
        header('location: ../Home/homepage.php');
    }
}else{
    // Go back to the sign in page if a user is not sign in
    header('location: ../SignIn/signIn.php');
}


