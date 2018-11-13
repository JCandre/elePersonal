<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 14/03/2018
 * Time: 02:57 PM
 */

//General functions

//if no user is logged in, redirect away from private pages
function protect_page()
{
    if (logged_in() === false) {
        header('Location: views/Protected.php');
        exit();
    }
}

//if the user is already logged in, redirect them away from pages they no longer need to access
function logged_in_redirect()
{
    if (logged_in() === true) {
        header('Location: index.php');
    }
}

//filter string to protect against sql injection attack
function sanitize($data)
{
    //htmlentities to help against user entered scripts
    return htmlentities(strip_tags(mysqli_real_escape_string($GLOBALS['conn'], $data)));
}

function array_sanitize(&$item)
{
    //htmlentities to help against user entered scripts
    $item = htmlentities(strip_tags(mysqli_real_escape_string($GLOBALS['conn'], $item)));
}

//output errors in new page
function outputErrors($errors)
{
    $output = array();
    foreach ($errors as $error) {
        $output[] = '<li>' . $error . '</li>';
    }
    return '<ul>' . implode('', $output) . '</ul>';
}

function logged_in()
{
    return (isset($_SESSION['user_id'])) ? true : false;
}

/**
 * Simple helper to debug to the console
 *
 * @param $data object, array, string $data
 * @param $context string  Optional a description.
 *
 * @return string
 */
function debug_to_console($data, $context = 'Debug in Console')
{

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output = 'console.info( \'' . $context . ':\' );';
    $output .= 'console.log(' . json_encode($data) . ');';
    $output = sprintf('<script>%s</script>', $output);

    echo $output;
}

?>