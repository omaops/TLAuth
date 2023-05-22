<?php
//Checks if email data is set and runs the resetPass method from the funtion pool to validate and send a forgot password link to the user's email. 
//If email is not sent, user is redircted back to the forgot_password.php page with an error flag
include 'fnts.php';
if (isset($_POST['email']))
    resetPass($_POST['email']);
else
    header("Location: ../forgot_password.php?o=");
