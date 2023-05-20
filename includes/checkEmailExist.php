<?php
 include 'db_config.php';   //standard datebase local connection..

 if(isset($_POST['email']) && $_POST['email']!="") {
     if ($stmt = $conn->prepare('SELECT email FROM member WHERE email = ?')) {
         $stmt->bind_param('s', $_POST['email']);
         $stmt->execute();
         $stmt->store_result();
         $numRows = $stmt->num_rows;
         if ($numRows > 0) {
             echo "<span style='color:red; font-size:12px;'class=''> Email Already In Use. <a href='forgotpassword.php'>Forgot Password?</a></span>";
         }
         else {
             echo "";
         }
     }
 }
$conn->close();
ob_end_flush();
?>