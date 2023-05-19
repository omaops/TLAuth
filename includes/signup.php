<?php
include 'fnts.php';
include 'db_config.php';
ob_start();
//echo "hi?";
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])){
//echo "all data set";
    //Check if email already exists
    checkEmailExist();

if(passCheck($_POST['password1'], $_POST['password2'])){

//echo "passwrods equal";

// prepare and bind
$stmt = $conn->prepare("INSERT INTO member (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);

// set parameters and execute
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$hashed_password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
$stmt->execute();

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
?>