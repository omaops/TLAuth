<?php
//Here the data is passed from the signin page and a method is called to check for the validity of the email and password.
//fnts.php is the method pool that has all the funtions for you in one place
include 'fnts.php';
resetPass($_POST['email']);