<?php

//Calender delete function
$connect = new PDO('mysql:host=localhost;dbname=elePersonal', 'root', '');

if (isset($_POST["id"])) {
    $query = "
 DELETE from events WHERE id=:id
 ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':id' => $_POST['id']
        )
    );
}

?>