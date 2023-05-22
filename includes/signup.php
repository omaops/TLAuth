<?php
//Simply registers the users and send an activation link to the registered email

include 'fnts.php';
include 'db_config.php';
ob_start();
//Checks if the values are set and validates inputs or else sends error message back to the view (signup.php) page
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {

    //Check if email already exists
    checkEmailExist();

//Checks if passwords match
    if (passCheck($_POST['password1'], $_POST['password2'])) {

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO member (firstname, lastname, email, password, activation_code, activation_expiry) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $hashed_activation_code, $activation_expiry);

        //One day expiration date
        $expiry = 1 * 24  * 60 * 60;

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $hashed_password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
        $activation_code = generate_activation_code();
        $hashed_activation_code = password_hash($activation_code, PASSWORD_DEFAULT);
        $activation_expiry = date('Y-m-d H:i:s',  time() + $expiry);
        $stmt->execute();

        //Send verification code
        send_activation_email($email, $activation_code);
        //ONLY FOR UNIT TESTING ------------> Delete!!!!!!!!!!!!!!!1
        //The line below allows you to create a local file with the email and hash values.
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        $txt = $email . " -------- " . $activation_code;
        fwrite($myfile, $txt);
        fclose($myfile);

        //Send user message to go and check email for an activation link
        header("Location: ../signin.php?e=");

        $stmt->close();
        $conn->close();
    } else {
        //Send error with password mismatch back to the signup
        header("Location: ../signup.php?p=");
        exit;
    }
} else
header("Location: ../signup.php?d=");
ob_end_flush();
