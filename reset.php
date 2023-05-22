<?php
//Checks if the user is already signed in or not
session_start();
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}
//Error message to get rendered accordingly to the get requrest sent form other pages or methods
include 'includes/fnts.php';
if (isset($_GET['e']))
    $errorMessage = "Email already exists. Got to the bottom link to sign in or reset your password. Thank You.<br>";
elseif (isset($_GET['p']))
    $errorMessage = "Passwords do not match. Please try again.<br>";
elseif (isset($_GET['s']))
    $errorMessage = "Password has been changed.<br>";
else
    $errorMessage = "";

//This checks if email and reset codes are set then calls a resetUser method to validate the code and email and renders response message accordingly.
if (isset($_GET['email']) && isset($_GET['rstcode'])) {
    $message = "";
    $reset = resetUser($_GET['email'], $_GET['rstcode']);
    if ($reset == 3)
        $message = "Email not found. Please contact the admin if you think this is a mistake. Thank You";
    elseif ($reset == 1)
        $message = "Enter your new password here";
    elseif ($reset == 2)
        $message = "Wrong Link or link has expired";
    elseif ($reset == 4)
        $message = "Unknown Error occured. Please try again";
    else
        $message = "Unknown Error occured. Please try again";
} else // If no valid email or reset code is found on the url, it will redirect to the sign in page without any action taken.
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
        //Just a simple password reseting page you can replce with any type of style you want.
        //The form's action amd method attributes should stay the same unless you know what you are doing.
        //The input types and names should also stay the same.
        //Here, the passwords should match, otherwise the button will not be enabled. Incase, the data is sent through, the passwords are again revalidated so no need to worry. Just and additional input validation.
        //The $message variable can be rendered anywhere you deem necessary to your application.
        ?>
        <h1>Reset Password (<?php echo $message; ?>)</h1>
        <form method="post" action="includes/reset.php">

            Reset Password :
            <input type="password" name="pass1" id="reg_pass" required="required"><br>
            Confirm password:
            <input type="password" name="pass2" id="reg_confirm_pass" required="required"><br>
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <input type="hidden" name="rstcode" value="<?php echo $_GET['rstcode']; ?>"><br>
            <button type="submit" id="enter" disabled="true">Reset</button>

        </form>
        <?php
        //Renders the error message
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