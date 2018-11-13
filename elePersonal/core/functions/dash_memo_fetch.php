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

//Create memo table and populate with data from database
$output = '
<table class="table table-striped table-bordered">
    <tr>
    </tr>
 ';

if ($total_row > 0) {
    foreach ($result as $row) {
        $output .= '
		<tr>
			<td width="40%" class="viewMemo" id="' . $row["note_id"] . '"><a href="#">' . $row["title"] . '</a></td>
			<td width="40%">' . $row["created"] . '</td>
		</tr>
		';
    }
} else {
    $output .= '
	<tr>
		<td colspan="3" align="center">No memos found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;


?>


