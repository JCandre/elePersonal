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
//Call general function to protect page access
protect_page();

//Process updating user profile data

if (empty($_POST) === false) {
    $required_fields = array('name', 'surname', 'email');

    //Make sure user fills all required fields
    foreach ($_POST as $key => $value) {
        //if a value that has been set to required is empty
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Highlighted fields are required';
            //exit loop if 1 error is found
            break 1;
        }
    }

    //Validate email and check if already in use
    if (empty($errors) === true) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Valid email address required';
        } else if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
            $errors[] = 'Email already in use';
        }
    }

} else {
    $errors[] = 'No data received';
}


if (empty($_POST) === false && empty($errors) === true) {
    //update user data
    $update_data = array(
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'email' => $_POST['email'],
        'home_address' => $_POST['home_address'],
        'country' => $_POST['country'],
        'phone_number' => $_POST['phone_number']
    );
    //call users.php function to update user data
    update_user($update_data);
    echo "<script type='text/javascript'> alert('Details successfully updated'); window.location ='../../Profile.php'; </script>";
} else if (empty($errors) === false) {
    //print errors
// show the array as javascript object and redirect to index
    echo "<script type='text/javascript'> alert(" . json_encode($errors) . "); window.location ='../../Profile.php'; </script>";

}

?>