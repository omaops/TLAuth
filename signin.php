<?php
//Checks wheather the user is signed in or not. If user is already signed in, it will redirect back to the index page.
session_start();
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}
//This will render any error messages sent from the authentcation methods. You can echo the message variable where ever you think is applicable to inform the user when using your app.
if (isset($_GET['e']))
    $Message = "You have registered sucessfully. You can now Sign In<br>";
elseif (isset($_GET['o']))
    $Message = "Wrong credentials. Please try again.<br>";
elseif (isset($_GET['v']))
    $Message = "Account is not activated.<br> Please go to your email and click on the link to activate your account.<br>";
elseif (isset($_GET['s']))
    $Message = "Password has been changed. Please login with your new password.<br>";
else
    $Message = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>

<body>
    <div>
        <?php
        //Just a simple sign in page you can replce with any type of style you want.
        //The form's action amd method attributes should stay the same unless you know what you are doing.
        //The input types and names should also stay the same.
        ?>
        <h1>Sign In</h1>
        <?php
        //Make sure your form sends the respective form data to the includes/signin.php script so that the scrpt can verify the user
        ?>
        <form method="post" action="includes/signin.php">

            <lable>Email</lable>
            <?php //Name attribute of the input tags should not change unless you know what you are doing 
            ?>
            <input type="email" name="email" required>
            <br>
            <br>
            <lable>Password</lable>
            <input type="password" name="password" required>
            <br>
            <br>
            <button type="submit">Login</button>
        </form>
        <?php //Link below will send you to a signup page if you do not have an account 
        ?>
        <br>
        <?php //Link below will send you to a sign up page 
        ?>
        <p>If you <strong>don't</strong> have an account, <a href="signup.php">Sign up here</a></p>
        <?php //Link below will send you to a page that will allow users to reset their passwords 
        ?>
        <p>Reset <a href="forgot_password.php">Password</a></p>
        <?php //Down below is where the error message variable that was stated at the top of the page is rendered accordingly 
        ?>
        <p><?php echo $Message; ?></p>
    </div>
</body>

</html>