<?php

//Send out validation email
function verify($email, $username, $hash)
{
    $to = $email; //email to send confirmation to
    $headers = 'From:noreply@elePersonal.com' . "\r\n"; //from header
    $subject = 'elePersonal Signup | Verification'; //email subject line
    $message = '
    
    Thank you for signing up to elePersonal!
    Your account has been created, all you have left to do is verify you email address to activate the account.
    
    ------------------------
    Reminder!
    Username: ' . $username . '
    ------------------------
    
    Please click this link to activate your account:
    http: localhost:63342/elePersonal/Verify.php?email=' . $email . '&hash=' . $hash . '
    
    '; //email body containing link
    mail($to, $subject, $message, $headers); //send the email
}

//username and password recovery
function recover($mode, $email)
{
    $mode = sanitize($mode);
    $email = sanitize($email);

    $user_data = user_data(user_id_from_email($email), 'user_id', 'name', 'username');

    if ($mode == 'username') {
        //recover username code here
    } else if ($mode == 'password') {
        //recover password code here
    }
}

//check username already exists in database
function user_exists($username)
{
    $username = sanitize($username);
    $query = "SELECT * FROM users WHERE username = '" . $username . "'";
    if ($result = mysqli_query($GLOBALS['conn'], $query)) {
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
        mysqli_free_result($result);
    }
}

//check email address already exists in database
function email_exists($email)
{
    $email = sanitize($email);
    $query = "SELECT * FROM users WHERE email = '" . $email . "'";
    if ($result = mysqli_query($GLOBALS['conn'], $query)) {
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
        mysqli_free_result($result);
    }
}

//check profile activated from validation email
function user_active($username)
{
    $username = sanitize($username);
    $query = "SELECT * FROM users WHERE username = '" . $username . "' AND activated = 1";
    if ($result = mysqli_query($GLOBALS['conn'], $query)) {
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
        mysqli_free_result($result);
    }
}

//Get user id from username
function user_id_from_username($username)
{
    $username = sanitize($username);
    $query3 = "SELECT user_id FROM users WHERE username = '" . $username . "'";
    if ($result = mysqli_query($GLOBALS['conn'], $query3)) {
        if (mysqli_num_rows($result) == 1) {
            while ($obj = mysqli_fetch_object($result)) {
                return $obj->user_id;
            }
        }
        mysqli_free_result($result);
    }
}

//Get user id from email
function user_id_from_email($email)
{
    $email = sanitize($email);
    $query3 = "SELECT user_id FROM users WHERE username = '" . $email . "'";
    if ($result = mysqli_query($GLOBALS['conn'], $query3)) {
        if (mysqli_num_rows($result) == 1) {
            while ($obj = mysqli_fetch_object($result)) {
                return $obj->user_id;
            }
        }
        mysqli_free_result($result);
    }
}

//return user id to set active session
function login($username, $password)
{
    $user_id = user_id_from_username($username);
    $username = sanitize($username);
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
    if ($result = mysqli_query($GLOBALS['conn'], $query)) {
        if (mysqli_num_rows($result) == 1) {
            return $user_id;
        } else {
            return false;
        }
        mysqli_free_result($result);
    }
}

//fetch user data
function user_data($user_id)
{
    $data = array();
    $user_id = (int)$user_id;

    $func_num_args = func_num_args();
    $func_get_args = func_get_args();

    if ($func_num_args > 1) {
        unset($func_get_args[0]);

        $fields = '`' . implode('`, `', $func_get_args) . '`';
        $query = "SELECT $fields FROM `users` WHERE `user_id` = '$user_id'";
        $data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], $query));

    }
    return $data;
}

; //possible error

//send user registration data to database
function register_user($register_data)
{
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);

    //$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $fields = implode(', ', array_keys($register_data));
    //data that will be inserted
    $data = '\'' . implode('\', \'', $register_data) . '\'';
    $query = "INSERT INTO `users` ($fields) VALUES ($data)";
    debug_to_console($query);
    mysqli_query($GLOBALS['conn'], $query);

}

//update user data in database
function update_user($update_data)
{
    global $session_user_id;
    $update = array();
    array_walk($update_data, 'array_sanitize');

    foreach ($update_data as $field => $data) {
        $update[] = '`' . $field . '` = \'' . $data . '\'';
    }

    $query = "UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $session_user_id";
    mysqli_query($GLOBALS['conn'], $query);


}

//update password
function change_password($user_id, $password)
{
    $user_id = (int)$user_id;
    $password = md5($password);

    $query = "UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id";
    mysqli_query($GLOBALS['conn'], $query);
}

//update user profile image
function update_profile_img($user_id, $file_temp_location, $file_extn)
{
    $file_path = 'res/img/profile_img/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
    move_uploaded_file($file_temp_location, $file_path);

    $query = "UPDATE `users` SET `profile_img` = '" . $file_path . "' WHERE `user_id` = " . (int)$user_id;
    mysqli_query($GLOBALS['conn'], $query);
}

?>