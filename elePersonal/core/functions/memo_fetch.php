<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 25/04/2018
 * Time: 01:54 AM
 */

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/core/init.php";
include($path);
protect_page();

$connect = new PDO('mysql:host=localhost;dbname=elePersonal', 'root', '');

$query = "SELECT * FROM notes WHERE user_fk= '" . $session_user_id . "' ORDER BY note_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();

$output = '
<table class="table table-striped table-bordered">
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th>View</th>
        <th>Edit</th>
    </tr>
 ';

if ($total_row > 0) {
    foreach ($result as $row) {
        $output .= '
		<tr>
			<td width="40%">' . $row["title"] . '</td>
			<td width="40%">' . $row["created"] . '</td>
			<td width="10%">
				<button type="button" name="view" class="btn btn-primary btn-xs view" id="' . $row["note_id"] . '">View</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["note_id"] . '">Delete</button>
			</td>
		</tr>
		';
    }
} else {
    $output .= '
	<tr>
		<td colspan="4" align="center">No memos found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;


?>


