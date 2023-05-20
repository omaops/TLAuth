<?php
// session_start();
// if (isset($_SESSION['email'])) {
//     header('Location: index.php');
// }
// if (isset($_GET['e']))
//     $errorMessage = "Email already exists. Got to the bottom link to sign in or reset your password. Thank You.<br>";
// elseif (isset($_GET['p']))
//     $errorMessage = "Passwords do not match. Please try again.<br>";
// else
//     $errorMessage = "";
if(isset($_GET['email']) && isset($_GET['rstcode'])){
    $reset = resetUser($_GET['email'], $_GET['rstcode']);
}
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
        <h1>Reset Password</h1>
        <form method="post" action="includes/reset.php">


            Reset Password :
            <input type="password" name="user[user_pass]" id="reg_pass" required="required">Confirm password
            <input type="password" name="user[user_confirm_pass]" id="reg_confirm_pass" required="required">
            <button type="submit" id="enter" disabled="true" value="Register">Register</button>
        </form>
        <?php
        //The location of the link below should be the same as well
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