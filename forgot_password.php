<?php
if(isset($_GET['e']))
$Message = "Email is not registered<br>";
elseif(isset($_GET['p']))
$Message = "Password Reset Link Sent. Please go to your email.<br>";
elseif(isset($_GET['o']))
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
        //Just a simple login page you can replce with any type of style you want.
        //The form's action amd method attributes should stay the same unless you agian know what you are doing.
        //The input types and names should also stay the same.
        //The comments w
        ?>
        <h1>Reset Password</h1>
        <!-- Make sure your form sends the respective form data to the includes/signin.php script so that the scrpt can verify the user.-->
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
        
        <!-- Here you will get any error messages like if you didn't input a correct email or password. This is where the message variable above is rendered accordingly -->
        <p><?php echo $Message; ?></p>
    </div>
</body>
</html>