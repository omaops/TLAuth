<?php
//Checks wheather the user is signed in or not. If user is already signed in, it will redirect back to the index page.
session_start();
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}

//This will render any messages sent from other pages or methods. You can echo the message variable where ever you think is applicable to inform the user when using your app.
if (isset($_GET['e']))
    $Message = "Email is not registered<br>";
elseif (isset($_GET['p']))
    $Message = "Password Reset Link Sent. Please go to your email and click on the link to reset your password.<br>";
elseif (isset($_GET['o']))
    $Message = "Somthing went wrong. Please try again..<br>";
else
    $Message = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <div>
        <?php
        //Just a simple forgot password page you can replace with any type of style you want.
        //The form's action amd method attributes should stay the same unless you know what you are doing.
        //The input types and names should also stay the same.
        ?>
        <h1>Reset Password</h1>
        <form method="post" action="includes/forgot_password.php">

            <lable>Email</lable>
            <!-- Name attribute of the input scripts should not change unless you know what you are doing. -->
            <input type="email" name="email" required>

            <br>
            <br>
            <button type="submit">Send</button>
        </form>
        <!-- Link below will send you to a signup page if you do not have an account -->
        <br>
        <p>If you <strong>don't</strong> have an account, <a href="signup.php">Sign up here</a></p>

        <?php //This is where the message variable above is rendered accordingly 
        ?>
        <p><?php echo $Message; ?></p>
    </div>
</body>

</html>