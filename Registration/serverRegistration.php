<?php
// Start the session
include '../Header/sessionConnection.php';

// Initializing variables
$email    = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost','root','','receipts');

// REGISTER USER
if (isset($_POST['reg_user_button'])) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastName']);


    // Form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($email)) { array_push($errors, "Email is required. "); }
    if (empty($password_1)) { array_push($errors, "Password is required. "); }
    if (empty($password_2)) { array_push($errors, "Confirm Password is required. "); }
    if (empty($firstName)) { array_push($errors, "First Name is required. "); }
    if (empty($lastName)) { array_push($errors, "Last Name is required. "); }

    // First check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM receipts WHERE userId='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['userId'] === $email) {
            array_push($errors, "Email already exists. ");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        //Hash
            //Insert a salt
                $salt = $email;
                $saltedPassword = $email.$password_1;
            //Hash the salted PW
                $hash = password_hash($saltedPassword, PASSWORD_DEFAULT);

         // Insert the user information in the table receipts in the database
         $queryUser = "INSERT INTO receipts (userId, userPassword, userFirstName, userLastName)
            VALUES('$email', '$hash', '$firstName', '$lastName' )";
         mysqli_query($db, $queryUser);


        if (mysqli_affected_rows($db) >= 1) {
            $_SESSION['userNewRegister'] = $email;
            header('location: ../SignIn/signIn.php');
        }
    }
}
