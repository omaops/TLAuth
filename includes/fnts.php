<?php
//Funtion below checks if session has been started or not (if the user has been logged in or not)
function sessionCheck()
{
    if (!isset($_SESSION['email'])) {
        // session isn't started so redirect user to regiser or login
        header("Location: signin.php");
    }
    // else
    // header("Location: index.php");Ö
}

//Does what it says
function checkEmailExist()
{
    include 'db_config.php';   //standard datebase local connection..

    if (isset($_POST['email']) && $_POST['email'] != "") {
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
    //ob_end_flush();
}


//Check if password matchs
function passCheck($p1, $p2)
{
    if ($p1 == $p2)
        return true;
    else
        return false;
}


//Does what it says
function loginUser($em, $ps)
{
   // ob_start();
    include 'db_config.php';   //standard datebase local connection..
    $message = 0;

    $sql = "SELECT password FROM member WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $em);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (password_verify($ps, $row['password'])) {
            //$message = 1;
            session_start();
            $_SESSION['email'] = $em;
            header("Location: ../index.php");
            exit();
        }
    }

    if ($message == 1) {
        session_start();
        $_SESSION['email'] = $em;
        header("Location: ../index.php");
        exit();
    } else {
        //$message = 0;
        header("Location: ../signin.php?o=");
        exit();
    }

   // ob_end_flush();
}

// function stsess($em){
//     header("Location: ../index.php");
//     session_start();
//         $_SESSION['email']= $em;
// }
