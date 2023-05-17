<?php
 include 'db.php';   //standard datebase local connection..

 if(isset($_POST['userName']) && $_POST['userName']!="") {
     if ($stmt = $con->prepare('SELECT userName FROM users WHERE userName = ?')) {
         $stmt->bind_param('s', $_POST['userName']);
         $stmt->execute();
         $stmt->store_result();
         $numRows = $stmt->num_rows;
         if ($numRows > 0) {
             echo "<span class=''> Username Not Available.</span>";
         } else {
             echo "<span class=''> Username Available.</span>";
         }
     }
 }
$con->close();
ob_end_flush();

?>
