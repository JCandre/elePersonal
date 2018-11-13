<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 13/03/2018
 * Time: 05:12 AM
 */

//On logout... destroy session and redirect
session_start();
session_destroy();
header('Location: ../index.php');

?>