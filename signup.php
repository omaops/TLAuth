<?php
if(isset($_GET['e']))
$errorMessage = "Email already exists. Got to the bottom link to sign in or reset your password. Thank You.<br>";
elseif(isset($_GET['p']))
$errorMessage = "Passwords do not match. Please try again.<br>";
else
$errorMessage = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    <h1>Sign Up</h1>
    <form method="post" action="includes/signup.php">

        <lable>First Name: </lable>
        <input type="text" name="email" required>
        <br>
        <br>
        <lable>Last Name: </lable>
        <input type="text" name="email" required>
        <br>
        <br>
        <lable>Email: </lable>
        <input type="email" name="email" id="email1" onBlur="checkAvailability()" required>
        <br>
        <span id="user-availability-status"></span>
        <p><img src="images/loading.gif" id="loaderIcon" style="display:none; width:30px; height:20px;" /></p>
        <br>
        <lable>Password: </lable>
        <input type="password" name="password1" required>
        <br>
        <br>
        <lable>Confirm Password: </lable>
        <input type="password" name="password2" required>
        <br>
        <br>
        <button type="submit" id="subbtn" disabled>Create an Account</button>
    </form>
       <?php 
       //The location of the link below should be the same as well
       ?>
       <br>
<p>If you <storng>already have</storng> an account, <a href="signin.php">Sign In here</a></p>
    </div>
    <br>
    <?php echo $errorMessage; ?>
</body>
<footer>
    <?php // A simple AJAX script to check if the eamil is already in use. ?>

    <script src="http://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">     

function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "includes/checkEmailExist.php",
data:'email='+$("#email1").val(),
type: "POST",
success:function(data){
//if(data.trim()==''){$("#subbtn").attr("disabled", false);}
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
</footer>
</html>