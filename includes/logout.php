<?php
//Does what it says. Logs out the user by destroying the login session
session_start();
session_destroy();
header("Location: ../signin.php");
        exit();
