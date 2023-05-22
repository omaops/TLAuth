<?php
//Here the data is passed from the signin page and a method is called to check for the validity of the email and password.
include 'fnts.php';
loginUser($_POST['email'], $_POST['password']);
