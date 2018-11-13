<?php
/*Require core functions needed for web app to work*/
if (!isset($_SESSION)) {
    session_start();
}

//#disable error reporting so sensitive information isn't revealed to users
error_reporting(0);

require 'database/connect.php';
require 'functions/users.php';
require 'functions/general.php';


//only pull data if user is logged in
if (logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'name', 'surname', 'email', 'home_address', 'country', 'phone_number', 'profile_img');

    //force logout if your account no longer activated - admin control
    if (user_active($user_data['username']) === false) {
        session_destroy();
        header('Location: index.php');
    }
}


$errors = array();
?>