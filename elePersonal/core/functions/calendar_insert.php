<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
//Call general function to protect page access
protect_page();

//Open connection to database for CRUD operation
$connect = new PDO('mysql:host=localhost;dbname=elepersonal', 'root', '');

if (isset($_POST["title"])) {
    $query = "
 INSERT INTO events 
 (title, start_event, end_event, user_fk) 
 VALUES (:title, :start_event, :end_event, :user_fk)
 ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':title' => $_POST['title'],
            ':start_event' => $_POST['start'],
            ':end_event' => $_POST['end'],
            ':user_fk' => $session_user_id

        )
    );
}


?>