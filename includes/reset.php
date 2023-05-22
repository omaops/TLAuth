<?php
//Initiates a reset password process by validating the inputs and calling the reset_the_password() method. This validates the reset codes validity as well before changeing the password or redirctes back with an error flag
include 'fnts.php';

if (isset($_POST['email']) && isset($_POST['rstcode']) && isset($_POST['pass1']) && isset($_POST['pass2'])) {
    if ($_POST['pass1'] == $_POST['pass2']) {
        reset_the_password($_POST['email'], $_POST['rstcode'], $_POST['pass1']);
    } else
        header("Location: ../reset.php?p=");
} else
    header("Location: ../signin.php?oo=");
