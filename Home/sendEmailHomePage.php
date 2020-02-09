<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../emailTool/autoload.php';

// Start the session
include '../Header/sessionConnection.php';

// Initializing variables
$errors = array();
$email = "";

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'photography');

// REGISTER USER
if (isset($_POST['sendMessage'])) {
    if (!isset($_SESSION['userSignIn']) || $_SESSION['userTypeSignIn'] !== 'administrator') {
        // Receive all input values from the form
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $message = mysqli_real_escape_string($db, $_POST['message']);


        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($name)) {
            array_push($errors, "Name ");
        }
        if (empty($email)) {
            array_push($errors, "Email ");
        }
        if (empty($message)) {
            array_push($errors, "Message ");
        }
        if($errors != 0){
            header('location: ./homepage.php?sendEmailHome=Please fill all fields.#getInTouch');
        }

        $subject = "Vanilla Website - FAQ";
        // Put right link
        $message = '<strong>' . $name . ',</strong>' . ' has send you this message :<br>' . $message .
            '<br><br> ' . 'If you wish to reply, you can do so via ' . $email . '.';


        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->Username = "ariouellette2000@gmail.com"; //sender gmail
        $mail->Password = 'Spot6516'; //password for the gmail
        try {
            // Receiver, replace with email enter
            $mail->AddAddress("arianeouellette@yahoo.ca");
        } catch (\PHPMailer\PHPMailer\Exception $e) {
        }
        try {
            // Sender
            $mail->SetFrom("ariouellette2000@gmail.com");
        } catch (\PHPMailer\PHPMailer\Exception $e) {
        }
//        $mail->Subject = $subject . " from " . $name;
        $mail->Subject = $subject;
        $mail->Body = $message;

        try {
            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $_SESSION['userNewAccount'] = $email;
                header('location: ./homepage.php?sendEmailHome=Email successfully sent#getInTouch');
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
        }

    } else {
        header('location: ./homepage.php?sendEmailHome=Administrators are not allowed to send FAQ email.#getInTouch');
    }
}


