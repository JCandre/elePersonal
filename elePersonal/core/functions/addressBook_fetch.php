<?php
/**
 * Created by PhpStorm.
 * User: JoelA
 * Date: 13/03/2018
 * Time: 12:43 AM
 *
 * Process login
 */

/* Fetch and populate the front end address book*/

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

$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>View</th>
		<th>Edit</th>
	</tr>
';

if ($total_row > 0) {
    foreach ($result as $row) {
        $output .= '
		<tr>
			<td width="40%">' . $row["Name"] . '</td>
			<td width="40%">' . $row["Email"] . '</td>
			<td width="10%">
				<button type="button" name="view" class="btn btn-primary btn-xs view" id="' . $row["contact_id"] . '">View</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["contact_id"] . '">Delete</button>
			</td>
		</tr>
		';
    }
} else {
    $output .= '
	<tr>
		<td colspan="4" align="center">No contacts found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;

?>