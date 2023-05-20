<?php
//This is going to be a template of any of the landing pages of your app that can only be seen by authenticated users
//In all pages we are going to see if user have access. In order to do that we need to add the line below to check if a user has a valid session.
//All your landing pages need the lines below added at the top of all pages.
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: signin.php');
}
//Include this block of php code abaove in all your landing pages that require login or authentication access
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
    <!-- The echo is just to show who is logged in. -->
    <h1>You are logged in (<?php echo $_SESSION['email']; ?>)</h1>
    <br><br>
    <!-- Link this to any logout event you have in your php app  -->
    <a href="includes/logout.php">logout</a>
</body>

</html>