<?php
//Checks wheather the user is signed in or not. If user is already signed in, it will redirect back to the index page.
session_start();
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}

//This will render any error messages sent from the authentcation methods. You can echo the message variable where ever you think is applicable to inform the user when using your app.
if (isset($_GET['e']))
    $errorMessage = "Email already exists. Got to the bottom link to sign in or reset your password. Thank You.<br>";
elseif (isset($_GET['p']))
    $errorMessage = "Passwords do not match. Please try again.<br>";
elseif (isset($_GET['d']))
    $errorMessage = "All fields are required!.<br>";
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
        //Just a simple sign up page you can replce with any type of style you want.
        //The form's action amd method attributes should stay the same unless you know what you are doing.
        //The input types and names should also stay the same.
        //There is an AJAX script that checks if the email is already in use or not in real-time so I wouldn't mess with the ID of the email input tag.
        ?>
        <h1>Sign Up</h1>
        <form method="post" action="includes/signup.php">

            <lable>First Name: </lable>
            <input type="text" name="firstname" required>
            <br>
            <br>
            <lable>Last Name: </lable>
            <input type="text" name="lastname" required>
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
            <button type="submit" id="subbtn">Create an Account</button>
        </form>
        <?php
        //Error message is echoed or rendered down below
        ?>
        <br>
        <?php echo $errorMessage; ?>
        <p>If you <storng>already have</storng> an account, <a href="signin.php">Sign In here</a></p>
    </div>
    <br>

</body>
<footer>
    <?php 
    // A simple AJAX script to check if the eamil user inputs is already in use or not.
    // If user continues with an eamil that is already in use, the system will not register and will redirect back to this page with an error message.
    ?>

    <!-- For online  <script src="http://code.jquery.com/jquery-3.3.1.js"></script> -->
    <!-- Down below is the same jquery script but offline (For accessability) -->
    <script src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript">
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "includes/checkEmailExist.php",
                data: 'email=' + $("#email1").val(),
                type: "POST",
                success: function(data) {
                    //if(data.trim()==''){$("#subbtn").attr("disabled", false);}
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
</footer>

</html>