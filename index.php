<?php
session_start();
if(!isset($_SESSION['email'])){
    header('Location: signin.php');
}


//This is going to be a template of any of the landing pages of your app that can only be seen by authenticated user
//In all pages we are going to see if you have access
//Make sure to put this in all your pages that require a login credential


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body>
    <h1>You are logged in (<?php echo $_SESSION['email']; ?>)</h1>
    <br><br>
    <a href="includes/logout.php">logout</a>
</body>
</html>