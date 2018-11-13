<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 25/04/2018
 * Time: 02:42 AM
 */

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
protect_page();

$connect = new PDO('mysql:host=localhost;dbname=elepersonal', 'root', '');

date_default_timezone_set("Europe/London");

if (isset($_POST["action"])) {

    if ($_POST["action"] == "insert") {
        $query = "
          INSERT INTO notes (title, message, created, user_fk)
          VALUES (:title, :message, :created, :user_fk)
        ";
        $statement = $connect->prepare($query);
        debug_to_console(date("Y-m-d h:i:s"));
        $statement->execute(
            array(
                ':title' => $_POST['title'],
                ':message' => $_POST['message'],
                ':created' => date("Y-m-d h:i:s"),
                ':user_fk' => $session_user_id
            )
        );
        echo '<p>Memo saved</p>';

    }

    if ($_POST["action"] == "update") {
        $query = "UPDATE notes SET 
        title= '" . $_POST["title"] . "', 
        Message= '" . $_POST["message"] . "', 
        created= '" . date("Y-m-d h:i:s") . "'
        WHERE note_id = '" . $_POST["hidden_id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Memo updated</p>';
    }

    if ($_POST["action"] == "delete") {
        $query = "DELETE FROM notes WHERE note_id = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Memo deleted</p>';

    }


    if ($_POST["action"] == "fetch_single") {
        $query = "
		SELECT * FROM notes WHERE note_id = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['rTitle'] = $row['title'];
            $output['rMessage'] = $row['message'];
        }
        echo json_encode($output);
    }


}

?>