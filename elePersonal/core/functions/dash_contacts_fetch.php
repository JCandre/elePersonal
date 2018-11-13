<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 13/03/2018
 * Time: 12:43 AM
 *
 * Process login
 */

/* logging process*/

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
protect_page();

$connect = new PDO('mysql:host=localhost;dbname=elePersonal', 'root', '');

$query = "SELECT * FROM contacts WHERE user_fk= '" . $session_user_id . "' ORDER BY contact_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();

//Create contacts table and populate with data from database
$output = '
<table class="table table-striped table-bordered">
	<div>
	</div>
';

if ($total_row > 0) {
    foreach ($result as $row) {
        $output .= '
		<tr>
			<td width="40%" class="viewContact" id="' . $row["contact_id"] . '"><a href="#">' . $row["Name"] . '</a></td>
			<td width="40%">' . $row["Email"] . '</td>
		</tr>
		';
    }
} else {
    $output .= '
	<tr>
		<td colspan="2" align="center">No contacts found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;

?>