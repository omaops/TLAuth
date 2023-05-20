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
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->num_rows;
            if ($numRows > 0) {
                return 1;
            }
            else
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
    //Your application url should be set here
    // create the activation link
    $APP_URL = "https://localhost/tlauth";
    //Sender email address. Recommended to use no-reply@yourdomain.com
    $SENDER_EMAIL_ADDRESS = "no-reply@localhost.com";
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
    $sql = 'UPDATE member
            SET active = 1,
                activated_at = CURRENT_TIMESTAMP
            WHERE email=:em';

    $statement = $conn()->prepare($sql);
    $statement->bindValue(':email', $em, PDO::PARAM_INT);

    return $statement->execute();
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

    $sql = "SELECT password FROM member WHERE email=?";
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


    // ob_end_flush();
}

//Verifies the user via a link
function verifyUser($em, $ac)
{
    // ob_start();
    include 'db_config.php';   //standard datebase local connection..
    $now = new DateTime();
    
    if(checkEmailExist_p($em) == 1){
        $sql = "SELECT activation_code FROM member WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $em);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) {
            if (password_verify($ac, $row['activation_code'])) {
                if ($row['activation_expiry'] >= $now)
                    return 1;
                elseif ($row['activation_expiry'] < $now)
                    return 2;
                else
                    return 4;
            } else
                return 2;
        }
    }
    else
    return 3;

    // ob_end_flush();
}
