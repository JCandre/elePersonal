<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 13/03/2018
 * Time: 12:43 AM
 *
 * Process login
 */

/* Address book SQL CRUD functions*/

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
//Call general function to protect page access
protect_page();

//Open connection to backend database
$connect = new PDO('mysql:host=localhost;dbname=elepersonal', 'root', '');

if (isset($_POST["action"])) {

    if ($_POST["action"] == "insert") {
        $query = "
          INSERT INTO contacts (Name, Work, Phone, Email, Address, Birthday, user_fk)
          VALUES (:Name, :Work, :Phone, :Email, :Address, :Birthday, :user_fk)
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':Name' => $_POST['name'],
                ':Work' => $_POST['work'],
                ':Phone' => $_POST['phone'],
                ':Email' => $_POST['email'],
                ':Address' => $_POST['address'],
                ':Birthday' => $_POST['birthday'],
                ':user_fk' => $session_user_id
            )
        );
        debug_to_console($statement);
        echo '<p>Contact saved...</p>';

    }

    if ($_POST["action"] == "update") {
        $query = "UPDATE contacts SET 
        Name= '" . $_POST["name"] . "', 
        Work= '" . $_POST["work"] . "', 
        Phone= '" . $_POST["phone"] . "', 
        Email= '" . $_POST["email"] . "', 
        Address= '" . $_POST["address"] . "', 
        Birthday= '" . $_POST["birthday"] . "',
        user_fk= '" . $session_user_id . "' 
        WHERE contact_id = '" . $_POST["hidden_id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Contact Updated...</p>';
    }

    if ($_POST["action"] == "delete") {
        $query = "DELETE FROM contacts WHERE contact_id = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Contact Deleted</p>';
    }


    if ($_POST["action"] == "fetch_single") {
        $query = "
		SELECT * FROM contacts WHERE contact_id = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['rName'] = $row['Name'];
            $output['rWork'] = $row['Work'];
            $output['rPhone'] = $row['Phone'];
            $output['rEmail'] = $row['Email'];
            $output['rAddress'] = $row['Address'];
            $output['rBirthday'] = $row['Birthday'];
        }
        echo json_encode($output);
    }


}


?>