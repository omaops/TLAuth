<?php
include 'fnts.php';
include 'db_config.php';
ob_start();
//echo "hi?";
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
    //echo "all data set";
    //Check if email already exists
    checkEmailExist();

    if (passCheck($_POST['password1'], $_POST['password2'])) {

        //echo "passwrods equal";

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO member (firstname, lastname, email, password, activation_code, activation_expiry) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $hashed_activation_code, $activation_expiry);

        // set parameters and execute
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
        //Unit testing ------------> Delete
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        $txt = $email . " -------- " . $activation_code;
        fwrite($myfile, $txt);
        fclose($myfile);

        //echo "New user created successfully";
        header("Location: ../signin.php?e=");

        $stmt->close();
        $conn->close();
    } else {
        //echo "password mismatch";
        header("Location: ../signup.php?p=");
        exit;
    }
}
ob_end_flush();
