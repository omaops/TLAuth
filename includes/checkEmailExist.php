<?php
//This is the php script that gets executed by the AJAX library to check email avialability in real time

 include 'db_config.php';   //standard datebase local connection string

 //Checks if email is set and not null
 if(isset($_POST['email']) && $_POST['email']!="") {
    //Goes on to check connection status and execute a query
     if ($stmt = $conn->prepare('SELECT email FROM member WHERE email = ?')) {
         $stmt->bind_param('s', $_POST['email']);
         $stmt->execute();
         $stmt->store_result();
         $numRows = $stmt->num_rows;
         if ($numRows > 0) {
            //If data (email) exists, sends this html code
             echo "<span style='color:red; font-size:12px;'class=''> Email Already In Use. <a href='forgotpassword.php'>Forgot Password?</a></span>";
         }
         else {
            //If email does not exist, sends empty string (Nothing rendered in html)
             echo "";
         }
     }
 }
$conn->close();
ob_end_flush();
