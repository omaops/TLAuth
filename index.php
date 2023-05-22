<?php
//This is going to be a template of any of the landing pages of your app that can only be seen by authenticated users
//Add the lines below at the top of all pages that require users to login or authenticate.
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: signin.php');
}
//If users are signed in, they will have access to the page. Else, they will be redircted to the sign in page where they will have to sign in or sign up to create an account
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
    <?php 
    //The session echo down below is just to show who is logged in
    ?>
    <h1>You are logged in (<?php echo $_SESSION['email']; ?>)</h1>
    <br><br>
    <?php 
    //Link the includes/logout.php link to any logout event you have in your php app
    ?>
    <a href="includes/logout.php">logout</a>
</body>

</html>