<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 13/03/2018
 * Time: 12:43 AM
 *
 * Process login
 */

/* logging process*/

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
logged_in_redirect();

if (empty($_POST) === false) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //username or password missing add error to errors array in init.php
    if (empty($username) === true || empty($password) === true) {
        $errors[] = 'You need to enter a username and password';
    } else if (strlen($username) > 32) {
        $errors[] = 'Username too long';
    } else if (strlen($password) > 32) {
        $errors[] = 'Password too long';
    } else if (user_exists($username) === false) {
        $errors[] = 'Unable to find username, Have you registerd?';
    } else if (user_active($username) === false) {
        $errors[] = 'Account not yet activated!';
    } else {
        $login = login($username, $password);
        if ($login === false) {
            $errors[] = 'Username/password combination was incorrect';
        } else {
            //set the user session
            //redirect user to home

            $_SESSION['user_id'] = $login;
            header('Location: ../../index.php');
            exit();
        }
    }
    //print_r($errors);
} else {
    $errors[] = 'No data received';
}

//If there is an error, print message
if (empty($errors) === false) {
// show the array as javascript object and redirect to index
    echo "<script type='text/javascript'> alert(" . json_encode($errors) . "); window.location ='../../Index.php'; </script>";

}

?>