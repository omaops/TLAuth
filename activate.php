<?php
include 'includes/fnts.php';

$message = "";
if(isset($_GET['email']) && isset($_GET['actcode'])){
    $message = $message."both are set";
    $verified = verifyUser($_GET['email'], $_GET['actcode']);
    if($verified == 1){
        activate_user($_GET['email']);
        $message = "Activation Sucessful.";
    }
    elseif ($verified == 2)
    $message = "Activation Link Expired. Resend by initiating a 'Forgot my Password' process.";
    elseif ($verified == 3)
    $message = "Account doesn't exist.";
    else
    $message = "Activation Failed. Try again.";
} else
$message = "Hi";

echo "<h1>".$message."</h1>";
echo "<a href='signup.php'>Sign Up</a><br>";
echo "<a href='signin.php'>Sign In</a><br>";