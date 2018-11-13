<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 20/03/2018
 * Time: 04:30 AM
 */

$connect = new PDO('mysql:host=localhost;dbname=elePersonal', 'root', '');


if (isset($_POST["id"])) {
    $query = "
 UPDATE events 
 SET title=:title, start_event=:start_event, end_event=:end_event 
 WHERE id=:id
 ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':title' => $_POST['title'],
            ':start_event' => $_POST['start'],
            ':end_event' => $_POST['end'],
            ':id' => $_POST['id']
        )
    );
}
?>