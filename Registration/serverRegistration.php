<?php
// Start the session
include '../Header/sessionConnection.php';

// Initializing variables
$email    = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost','root','','receipts');

// Verify if the user has click on the registration button
if (isset($_POST['reg_user_button'])) {
    // Receive all input values from the form
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

    // Verify if users exists
    if ($user) {
        if ($user['userId'] === $email) {
            // Pass an error message if the email exist
            array_push($errors, "Email already exists. ");
        }
    }

    // Register user if there are no errors in the form
    if (count($errors) == 0) {
        //Hashing the password
            $salt = $email; // Initialize salt with the user email
            $saltedPassword = $salt.$password_1; // Concatenate salt and password to form plaintext
            $hash = password_hash($saltedPassword, PASSWORD_DEFAULT); // Hash the password,
                                                                            // PASSWORD_DEFAULT is a constant that uses bcrypt algorithm (60 characters long)
                                                                            // Also, there is a salt provide in this API but I added a second salt to demonstrate the idea
                                                                            // If a user wanted to include only one custom salt they would code it the following way:
                                                                                    //$options = [
                                                                                    //    'salt' => "Own salt"
                                                                                    //    'cost' => 12 // the default cost is 10
                                                                                    //];
                                                                                    //$hash = password_hash($password, PASSWORD_DEFAULT, $options);
                                                                            // *It is possible to use stronger algorithm in a more advanced project
                                                                            // **The second parameter could also be PASSWORD_BCRYPT

         // Insert the user registration information in the table receipts in the database
         $queryUser = "INSERT INTO receipts (userId, userPassword, userFirstName, userLastName)
            VALUES('$email', '$hash', '$firstName', '$lastName' )";
         mysqli_query($db, $queryUser);


        if (mysqli_affected_rows($db) >= 1) {
            $_SESSION['userNewRegister'] = $email; // Store the user email, to fill the email input in the sign in form
            header('location: ../SignIn/signIn.php');
        }
    }
}

