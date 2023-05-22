<?php
//THIS IS THE FUNTION OR METHOD POOL. IT CONTAINS MOST OF THE FUNCTIONS THAT RUN THE APPLICATION
//RECOMMENDED NOT TO CHANGE ANYTHING HERE UNLESS YOU ABSOLUTLY KNOW WHAT YOU ARE DOING

//Funtion below checks if session has been started or not (if the user has been logged in or not) 
//Currnetly not implimented
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

//Does what it says but via a parameter that takes an email address. Returns 1 if email exists or 0 if it doesn't.
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

//Generate a random activation code to verify user account or to reset them
//It goes through a hashing process before it is sent ofcourse.
function generate_activation_code()
{
    return bin2hex(random_bytes(16));
}

//This will send activation email after a user finishes signing up.
function send_activation_email($email, $activation_code)
{
    include 'config.php';

    //Link structure
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
    //YOU CAN CHANGE THIS TO YOUR OWN EMAILING SERVER AS SOME HOSTS DONT ALLOW mail() METHOD TO RUN ON THEIR SERVERS
    mail($email, $subject, nl2br($message), $header);
}

//This will send password reset email link
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
    //YOU CAN CHANGE THIS TO YOUR OWN EMAILING SERVER AS SOME HOSTS DONT ALLOW mail() METHOD TO RUN ON THEIR SERVERS
    mail($email, $subject, nl2br($message), $header);
}

//Delete a user or an account (You can link this to your admin system of you have one and call this method from there or how ever you want)
//The first parameter is the email address of the user
//Currently not implimented here but available if you need it for your app (Method can be rewritten as you see fit)
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

//Activate the user after link is initiated and verified.
function activate_user($em)
{
    include 'db_config.php';
    $v = 1;

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
        if ($stmt->rowCount() == 0)
            echo "Account already activated";
        elseif ($stmt->rowCount() == 1)
            echo "Account activated";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $connn = null;
}

//Does what it says, check if passwords match.
function passCheck($p1, $p2)
{
    if ($p1 == $p2)
        return true;
    else
        return false;
}


//Checks and starts the session for authenticated users. If an error occurs, redirects users to sign in page with respective error message
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
    $conn->close();
    header("Location: ../signin.php?o=");
    exit();

    // ob_end_flush();
}

//Verifies the activation code and the email it was sent to. Checks if link is valid and link hasn't expired yet.
//If link is verified, returns a value 1 else 2, 3 ... that will be interpreted by the method calling scripts.
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
    $conn->close();

    // ob_end_flush();
}

//Verifies the reset password code and the email it was sent to. Checks if link is valid and link hasn't expired yet.
//If link is verified, returns a value 1 else 2, 3 ... that will be interpreted by the method calling scripts.
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
                if ($row['reset_expiry'] >= $row['updated_at']) {
                    return 1;
                } elseif ($row['reset_expiry'] < $row['updated_at'])
                    return 2;
                else
                    return 4;
            } else
                return 2;
        }
    } else
        return 3;
    $conn->close();

    // ob_end_flush();
}

//Initiates a reset password by creating a reset code, hashing and storing it with an expiry date and calles send_reset_email() method to send the link to the user's email
function resetPass($em)
{
    include 'db_config.php';

    if (checkEmailExist_p($em) == 0)
        header("Location: ../forgot_password.php?e=");
    elseif (checkEmailExist_p($em) == 1) {
        // prepare and bind
        $stmt = $conn->prepare("UPDATE member SET reset_code=?, reset_expiry=? WHERE email=?");
        $stmt->bind_param("sss", $hashed_reset_code, $reset_expiry, $em);

        //One day expiration date
        $expiry = 1 * 24  * 60 * 60;

        $reset_code = generate_activation_code();
        $hashed_reset_code = password_hash($reset_code, PASSWORD_DEFAULT);
        $reset_expiry = date('Y-m-d H:i:s',  time() + $expiry);
        $stmt->execute();

        //Send verification code
        send_reset_email($em, $reset_code);

        //ONLY FOR UNIT TESTING ------------> Delete!!!!!!!!!!!!!!!1
        //The line below allows you to create a local file with the email and hash values.
        $myfile = fopen("newfile_reset.txt", "w") or die("Unable to open file!");
        $txt = $em . " -------- " . $reset_code;
        fwrite($myfile, $txt);
        fclose($myfile);

        //Redirects to forgot_password page with message flag
        header("Location: ../forgot_password.php?p=");

        $stmt->close();
        $conn->close();
    } else {
        //This means the email does not exist in the database and will be redircted with and error message to forgot_password.php page
        header("Location: ../forgot_password.php?o=");
        exit;
    }
}

//This will reset a validated link executioner user's password and randomizing the reset hash code to disable the user form using older reset links again.
function reset_the_password($em, $rc, $ps)
{
    include 'db_config.php';
    if (resetUser($em, $rc) == 1) {
        //send_reset_email($em, $activation_code);
        // prepare and bind
        $stmt = $conn->prepare("UPDATE member SET reset_code=?, reset_expiry=?, password=? WHERE email=?");
        $stmt->bind_param("ssss", $hashed_reset_code, $reset_expiry, password_hash($ps, PASSWORD_DEFAULT), $em);

        // set parameters and execute
        //One day expiration date
        $expiry = 1 * 24  * 60 * 60;

        $reset_code = generate_activation_code();
        $hashed_reset_code = password_hash($reset_code, PASSWORD_DEFAULT);
        $reset_expiry = date('Y-m-d H:i:s',  time() + $expiry);
        $stmt->execute();

        //Send verification code
        //send_reset_email($em, $reset_code);

        //Redirects the user with a successfully changed password message flag
        header("Location: ../signin.php?s=");

        $stmt->close();
        $conn->close();
    } else {
        //Redirects to the reset.php page with an error flag
        header("Location: ../reset.php?e=");

        exit;
    }
}
