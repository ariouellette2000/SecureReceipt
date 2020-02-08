<?php

// Start the session
include '../Header/sessionConnection.php';

// Initializing variables
$email    = "";
$password_1 = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost','root','','photography');
if(!isset($_SESSION['userSignIn'])){
// REGISTER USER
if (isset($_POST['signIn_user'])) {
    // Receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

    // First check the database to make sure a user does exist with the same email
    $user_check_query = "SELECT * FROM all_user WHERE userId='$email'";
    $resultUser = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($resultUser);

    // Verify if a record if found in the db
    if (!($user)) {
        // Verify if the user has already register
        if (!($user['userId'] === $email)) {
            array_push($errors, "Email does not exist. ");
        }
    }
    else{
        // Verify that entered password fits the password in the database
        if (password_verify($password_1, $user['userPassword'])){
                $_SESSION['userSignIn'] = $email;
                $_SESSION['userTypeSignIn'] = $user['userType'];
                header('location: ../Home/homepage.php');
            }
            else{
                array_push($errors, "Password is invalid. ");
            }
    }
}
 }else{
   header('location: ../SignOut/signOut.php');
}?>
