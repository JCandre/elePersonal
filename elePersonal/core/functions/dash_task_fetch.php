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

//Create tasks table and populate with data from database
$output = '
<table class="table table-striped table-bordered">
    <tr>
        <th>Title</th>
        <th>Days Left</th>
        <th>Completed</th>
    </tr>
 ';

if ($total_row > 0) {
    foreach ($result as $row) {
        $date = strtotime($row["complete_by"]);
        $dateSub = strtotime($row["created"]);
        //Calculate remaining time
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
			<td width="20%" class="viewTask" id="' . $row["task_id"] . '"><a href="#">' . $row["title"] . '</a></td>
			<td width="10%">' . $days_remaining . '</td>
			<td width="10%">
				<input type="checkbox" name="check" id="' . $row["task_id"] . '" onclick="checkFunction()" ' . $x . '/>
              
			</td>
		</tr>
		';

    }
} else {
    $output .= '
	<tr>
		<td colspan="3" align="center">No Tasks found</td>
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

