<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 20/03/2018
 * Time: 04:06 AM
 */

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
//Call general function to protect page access
protect_page();

$connect = new PDO('mysql:host=localhost;dbname=elepersonal', 'root', '');

/* Store events data*/
$data = array();
/* Query to interrogate database*/
$query = "SELECT * FROM events WHERE user_fk= '" . $session_user_id . "' ORDER BY id";

/* Prep query and execute*/
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach ($result as $row) {
    $data[] = array(
        'id' => $row["id"],
        'title' => $row["title"],
        'start' => $row["start_event"],
        'end' => $row["end_event"]
    );
}

echo json_encode($data);
?>