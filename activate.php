<?php

//This page informs users if they have successfully activated their accounts or not and allows them to sign in or sign up

include 'includes/fnts.php';

$message = "";
if (isset($_GET['email']) && isset($_GET['actcode'])) {
    $verified = verifyUser($_GET['email'], $_GET['actcode']);
    if ($verified == 1) {
        activate_user($_GET['email']);
        $message = "Activation Sucessful.";
    } elseif ($verified == 2)
        $message = "Activation Link Expired. Resend by initiating a 'Forgot my Password' process.";
    elseif ($verified == 3)
        $message = "Account doesn't exist.";
    else
        $message = "Activation Failed. Try again.";
} else
    $message = "Invalid Activation Link.";

echo "<h1>" . $message . "</h1>";
echo "<a href='signup.php'>Sign Up</a><br>";
echo "<a href='signin.php'>Sign In</a><br>";
