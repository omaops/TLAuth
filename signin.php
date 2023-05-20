<?php
//Include in all your pages (Recommended)
session_start();
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}
//

//Checks for error messages sent from the authentcation methods. You can echo the message variable where ever you think is applicable in your app.
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
//
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
        //Just a simple login page you can replce with any type of style you want.
        //The form's action amd method attributes should stay the same unless you agian know what you are doing.
        //The input types and names should also stay the same.
        //The comments w
        ?>
        <h1>Sign In</h1>
        <!-- Make sure your form sends the respective form data to the includes/signin.php script so that the scrpt can verify the user.-->
        <form method="post" action="includes/signin.php">

            <lable>Email</lable>
            <!-- Name attribute of the input scripts should not change unless you know what you are doing. -->
            <input type="email" name="email" required>
            <br>
            <br>
            <lable>Password</lable>
            <input type="password" name="password" required>
            <br>
            <br>
            <button type="submit">Login</button>
        </form>
        <!-- Link below will send you to a signup page if you do not have an account -->
        <br>
        <p>If you <strong>don't</strong> have an account, <a href="signup.php">Sign up here</a></p>
        <p>Reset <a href="forgot_password.php">Password</a></p>
        <!-- Here you will get any error messages like if you didn't input a correct email or password. This is where the message variable above is rendered accordingly -->
        <p><?php echo $Message; ?></p>
    </div>
</body>

</html>