<?php
//Funtion below checks if session has been started or not (if the user has been logged in or not)
//
function sessionCheck()
{
    if (!isset($_SESSION['email'])) {
        // session isn't started so redirect user to regiser or login
        header("Location: signin.php");
    }
    // else
    // header("Location: index.php");Ö
}

//Does what it says but works via a get request
function checkEmailExist()
{
    include 'db_config.php';   //standard datebase local connection...

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

//Does what it says but via a parameter. Returns a 1 or 0.
function checkEmailExist_p($em)
{
    include 'db_config.php';   //standard datebase local connection...

    if ($stmt = $conn->prepare('SELECT email FROM member WHERE email = ?')) {
        $stmt->bind_param('s', $em);
        $stmt->execute();
        $stmt->store_result();
        $numRows = $stmt->num_rows;
        if ($numRows > 0) {
            return 1;
        } else
            return 0;
    }
    return 0;

    $conn->close();
    //ob_end_flush();
}

//Generate a random activation code to verify email
function generate_activation_code()
{
    return bin2hex(random_bytes(16));
}

//this will send activation email
function send_activation_email($email, $activation_code)
{
    include 'config.php';
    
    $activation_link = $APP_URL . "/activate.php?email=$email&actcode=$activation_code";

    // set email subject & body
    $subject = 'Please activate your account';
    $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activation_link
            MESSAGE;
    // email header
    $header = "From:" . $SENDER_EMAIL_ADDRESS;

    // send the email
    mail($email, $subject, nl2br($message), $header);
}

//this will send password reset email
function send_reset_email($email, $reset_code)
{
    include 'config.php';
    
    $activation_link = $APP_URL . "/reset.php?email=$email&rstcode=$reset_code";

    // set email subject & body
    $subject = 'Please reset your password';
    $message = <<<MESSAGE
            Hi,
            Please click the following link to reset your password:
            $activation_link
            MESSAGE;
    // email header
    $header = "From:" . $SENDER_EMAIL_ADDRESS;

    // send the email
    mail($email, $subject, nl2br($message), $header);
}

//Delete a user or an account
function delete_user_by_id($em, $active = 0)
{
    include 'db_config.php';

    $sql = 'DELETE FROM member
            WHERE email =:em and active=:active';

    $statement = $conn()->prepare($sql);
    $statement->bindValue(':em', $em, PDO::PARAM_INT);
    $statement->bindValue(':active', $active, PDO::PARAM_INT);

    return $statement->execute();
}

//Activate the user after link is initiated
function activate_user($em)
{
    include 'db_config.php';
    $v=1;
    
    try {
      $connn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $connn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
      $sql = "UPDATE member SET verified='$v' WHERE email='$em'";
    
      // Prepare statement
      $stmt = $connn->prepare($sql);
    
      // execute the query
      $stmt->execute();
    
      // echo a message to say the UPDATE succeeded
      if($stmt->rowCount() == 0)
      echo "Account already activated";
      elseif($stmt->rowCount() == 1)
      echo "Account activated";
    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
    
    $connn = null;

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
    include 'db_config.php';

    $sql = "SELECT * FROM member WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $em);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (password_verify($ps, $row['password'])) {
            if ($row['verified'] == 1) {
                session_start();
                $_SESSION['email'] = $em;
                header("Location: ../index.php");
                exit();
            } else {
                header("Location: ../signin.php?v=");
                exit();
            }
        } else {
            header("Location: ../signin.php?o=");
            exit();
        }
    }
    header("Location: ../signin.php?o=");
    exit();

    // ob_end_flush();
}

//Verifies the user via a link
function verifyUser($em, $ac)
{
    // ob_start();
    include 'db_config.php';   //standard datebase local connection..
    //$now = new DateTime();

    if (checkEmailExist_p($em) == 1) {
        $sql = "SELECT * FROM member WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $em);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            if (password_verify($ac, $row['activation_code'])) {
                if ($row['activation_expiry'] >= $row['updated_at'])
                    return 1;
                elseif ($row['activation_expiry'] < $row['updated_at'])
                    return 2;
                else
                    return 4;
            } else
                return 2;
        }
    } else
        return 3;

    // ob_end_flush();
}

//resets the user password
function resetUser($em, $rc)
{
    // ob_start();
    include 'db_config.php';   //standard datebase local connection..
    //$now = new DateTime();

    if (checkEmailExist_p($em) == 1) {
        $sql = "SELECT * FROM member WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $em);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            if (password_verify($rc, $row['reset_code'])) {
                if ($row['reset_expiry'] >= $row['updated_at'])
                    return 1;
                elseif ($row['reset_expiry'] < $row['updated_at'])
                    return 2;
                else
                    return 4;
            } else
                return 2;
        }
    } else
        return 3;

    // ob_end_flush();
}

//Initiates a reset password
function resetPass($em){
    include 'db_config.php';

    if(checkEmailExist_p($em) == 0)
    header("Location: ../forgot_password.php?e=");
    elseif(checkEmailExist_p($em) == 1){
        //send_reset_email($em, $activation_code);
         // prepare and bind
         $stmt = $conn->prepare("UPDATE member SET reset_code=?, reset_expiry=?");
         $stmt->bind_param("ss", $hashed_reset_code, $reset_expiry);
 
         // set parameters and execute
         //One day expiration date
         $expiry = 1 * 24  * 60 * 60;

         $reset_code = generate_activation_code();
         $hashed_reset_code = password_hash($reset_code, PASSWORD_DEFAULT);
         $reset_expiry = date('Y-m-d H:i:s',  time() + $expiry);
         $stmt->execute();
 
         //Send verification code
         send_reset_email($em, $reset_code);
         //Unit testing ------------> Delete
         $myfile = fopen("newfile_reset.txt", "w") or die("Unable to open file!");
         $txt = $em . " -------- " . $reset_code;
         fwrite($myfile, $txt);
         fclose($myfile);
 
         //echo "New user created successfully";
         header("Location: ../forgot_password.php?p=");
 
         $stmt->close();
         $conn->close();
     } else {
         //echo "password mismatch";
         header("Location: ../forgot_password.php?o=");
         exit;
     }
    }