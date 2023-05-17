<?php
include 'db_config.php';
//Funtion below checks if session has been started or not (if the user has been logged in or not)
function sessionCheck(){
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        // session isn't started so redirect user to regiser or login
        header("Location: signin.php");
    }
}

//Does what it says
function checkEmailExist(){
    include 'db_config.php';   //standard datebase local connection..

 if(isset($_POST['email']) && $_POST['email']!="") {
     if ($stmt = $conn->prepare('SELECT email FROM member WHERE email = ?')) {
         $stmt->bind_param('s', $_POST['email']);
         $stmt->execute();
         $stmt->store_result();
         $numRows = $stmt->num_rows;
         if ($numRows > 0) {
            header("Location: ../signup.php?e=");
            exit();
         }
     }
 }
$conn->close();
ob_end_flush();

}


//Check if password matchs
function passCheck($p1, $p2){
if($p1 == $p2)
return true;
else
return false;
}









?>