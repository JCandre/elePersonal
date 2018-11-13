<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 27/03/2018
 * Time: 02:39 PM
 */
$to = 'j.ckillerv@gmail.com'; //email to send confirmation to
$headers = 'From: noreply@elePersonal.com'; //from header
$subject = 'elePersonal Signup | Verification'; //email subject line
$message = '
    
    Thank you for signing up to elePersonal!
    Your account has been created, all you have left to do is verify you email address to activate the account.
    
    ------------------------
    Reminder!
    
    ------------------------
    
    Please click this link to activate your account:
    
    '; //email body containing link
mail($to, $subject, $message, $headers); //send the email