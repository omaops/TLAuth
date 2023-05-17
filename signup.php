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
        <input type="email" name="email" required>
        <br>
        <br>
        <lable>Last Name: </lable>
        <input type="email" name="email" required>
        <br>
        <br>
        <lable>Email: </lable>
        <input type="email" name="email" required>
        <br>
        <br>
        <lable>Password: </lable>
        <input type="password" name="password" required>
        <br>
        <br>
        <lable>Confirm Password: </lable>
        <input type="password" name="password" required>
        <br>
        <br>
        <button type="submit">Create an Account</button>
    </form>
       <?php 
       //The location of the link below should be the same as well
       ?>
       <br>
<p>If you <storng>already have</storng> an account, <a href="signin.php">Sign In here</a></p>
    </div>
</body>
</html>