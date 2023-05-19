<?php
session_start();
if(isset($_SESSION['email'])){
    header('Location: index.php');
}
if(isset($_GET['e']))
$Message = "You have registered sucessfully. You can now Sign In<br>";
elseif(isset($_GET['o']))
$Message = "Wrong credentials. Please try again.<br>";
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
       //Just a simple login page you can replce with any type of style you want. 
       //The form's action amd method should stay the same.
       //The input types and names should also stay the same.
       //Inputs are requrited
       ?>
    <h1>Sign In</h1>
    <form method="post" action="includes/signin.php">
        
        <lable>Email</lable>
        <input type="email" name="email" required>
        <br>
        <br>
        <lable>Password</lable>
        <input type="password" name="password" required>
        <br>
        <br>
        <button type="submit">Login</button>
    </form>
       <?php 
       //The location of the link below should be the same as well
       ?>
       <br>
<p>If you <strong>don't</strong> have an account, <a href="signup.php">Sign up here</a></p>
<p>Reset <a href="#">Password</a></p>

<p><?php echo $Message; ?></p>
    </div>
</body>
</html>