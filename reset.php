<?php
// session_start();
// if (isset($_SESSION['email'])) {
//     header('Location: index.php');
// }
include 'includes/fnts.php';
if (isset($_GET['e']))
    $errorMessage = "Email already exists. Got to the bottom link to sign in or reset your password. Thank You.<br>";
elseif (isset($_GET['p']))
    $errorMessage = "Passwords do not match. Please try again.<br>";
elseif (isset($_GET['s']))
    $errorMessage = "Password has been changed.<br>";
else
    $errorMessage = "";
if(isset($_GET['email']) && isset($_GET['rstcode'])){
    $message = "";
    $reset = resetUser($_GET['email'], $_GET['rstcode']);
    if($reset == 3)
    $message = "Email not found. Please contact the admin if you think this is a mistake. Thank You";
    elseif($reset == 1)
    $message = "Enter your new password here";
    elseif($reset == 2)
    $message = "Wrong Link or link has expired";
    elseif($reset == 4)
    $message = "Unknown Error occured. Please try again";
    else
    $message = "Unknown Error occured. Please try again";


    //3 -> email not found
    //1 -> You are allowed to change
    //2 -> Link expired ... redo
    //4 -> Unknown Error occured. Please try again.
} else
header("Location: signin.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <div>
        <?php
        //Just a simple sign up landing page you can replce with any type of style you want. 
        //The form's action amd method should stay the same.
        //The input types and names should also stay the same.
        //Inputs are required
        //You can add your own data types here and modify the file in the includes signup and database
        ?>
        <h1>Reset Password (<?php echo $message;?>)</h1>
        <form method="post" action="includes/reset.php">

            Reset Password :
            <input type="password" name="pass1" id="reg_pass" required="required"><br>
            Confirm password:
            <input type="password" name="pass2" id="reg_confirm_pass" required="required"><br>
            <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
            <input type="hidden" name="rstcode" value="<?php echo $_GET['rstcode'];?>"><br>
            <button type="submit" id="enter" disabled="true">Reset</button>

        </form>
        <?php
        //The location of the link below should be the same as well
        echo $errorMessage;
        ?>
        <br>
        <?php echo $errorMessage; ?>
        <p>If you <storng>already have</storng> an account, <a href="signin.php">Sign In here</a></p>
    </div>
    <br>

</body>
<footer>
    <?php // A simple AJAX script to check if the eamil is already in use. 
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript">
        $("#reg_confirm_pass").blur(function() {
            var user_pass = $("#reg_pass").val();
            var user_pass2 = $("#reg_confirm_pass").val();
            //var enter = $("#enter").val();

            if (user_pass.length == 0) {
                alert("please fill password first");
                $("#enter").prop('disabled', true) //use prop()
            } else if (user_pass == user_pass2) {
                $("#enter").prop('disabled', false) //use prop()
            } else {
                $("#enter").prop('disabled', true) //use prop()
                alert("Your password doesn't same");
            }

        });
    </script>
</footer>

</html>