<?php
//Funtion below checks if session has been started or not (if the user has been logged in or not)
function sessionCheck(){
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        // session isn't started so redirect user to regiser or login
        header("Location: signin.php");
    }
}












?>