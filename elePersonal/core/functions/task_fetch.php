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

$query = "SELECT * FROM tasks WHERE user_fk= '" . $session_user_id . "' ORDER BY task_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();

$output = '
<table class="table table-striped table-bordered">
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th>Due</th>
        <th>Days Left</th>
        <th>Completed</th>
        <th>View</th>
        <th>Edit</th>
    </tr>
 ';

if ($total_row > 0) {
    foreach ($result as $row) {
        $date = strtotime($row["complete_by"]);
        $dateSub = strtotime($row["created"]);
        $remaining = $date - $dateSub;
        $days_remaining = floor($remaining / 86400);
        $hours_remaining = floor(($remaining % 86400) / 3600);


        global $x;

        if ($row["completed"] == 1) {
            $x = "checked";
        } else {
            $x = "";
        }

        $output .= '
		<tr>
			<td width="40%">' . $row["title"] . '</td>
			<td width="40%">' . $row["created"] . '</td>
			<td width="40%">' . $row["complete_by"] . '</td>
			<td width="10%">' . $days_remaining . '</td>
			<td width="10%">
				<input type="checkbox" name="check" id="' . $row["task_id"] . '" onclick="checkFunction()" ' . $x . '/>
              
			</td>
			<td width="10%">
				<button type="button" name="view" class="btn btn-primary btn-xs view" id="' . $row["task_id"] . '">View</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["task_id"] . '">Delete</button>
			</td>
		</tr>
		';

    }
} else {
    $output .= '
	<tr>
		<td colspan="7" align="center">No Tasks found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;


?>

<script>
    function checkFunction() {
        var id = $(this).attr('id'); //fetch contact id
        console.log(id)
    }


</script>

