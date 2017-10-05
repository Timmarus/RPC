<?php
require_once("inc.php");
if (!empty($_POST)) {
	if (isset($_POST['toggle'])) {
		$id = $_POST['toggle'];
		if (!is_numeric($id)) {
			echo "<pre>Invalid input.</pre>";
		}
		else {
			#UPDATE mytable SET display = CASE WHEN display = 1 THEN 0 ELSE 1 END WHERE title = 'My article title';
			#$query = "UPDATE slaves SET set_status= CASE WHEN set_status = 'disable' OR set_status = 'force' THEN 'enable' ELSE 'disable' WHERE id=".$id;
			$query = "UPDATE slaves SET set_status=IF(set_status='disable' OR set_status='force', 'enable', 'disable') WHERE id=".$id;
			mysqli_query($sql_lnk, $query);
			echo mysqli_error($sql_lnk);
		}
	}
	else if (isset($_POST['force'])) {
		$id = $_POST['force'];
		if (!is_numeric($id)) {
			echo "<pre>Invalid input.</pre>";
		}
		else {
			$query = "UPDATE slaves set set_status='force' WHERE id=".$id;
			mysqli_query($sql_lnk, $query);
		}
	}
}
?>

<html>
<head>
	<title>
		Control Room
	</title>
</head>
<body>
	<form method="POST" action="">
		<table border="1">
			<tr>
				<th>IP</th>
				<th>Current Status</th>
				<th>Enable/Disable</th>
				<th>Force Enable</th>
			</tr>
			<?php
			$query = "SELECT * FROM slaves";
			$resp = mysqli_query($sql_lnk, $query);
			while ($slave = mysqli_fetch_assoc($resp)) {
				echo "<tr>";
				echo "<td>".$slave['ip']."</td>";
				echo "<td>";
				if ($slave['current_status'] == "false") {
					echo "Enabled";
				}
				else {
					echo "Disabled";
				}
				echo "</td>";
				echo "<td><button type='submit' name='toggle' value='".$slave['id']."'>";
				if ($slave['set_status'] != "disable") {
					echo "Disable";
				}
				else {
					echo "Enable";
				}
				echo "</button></td>";
				echo "<td><button type='submit' name='force' value='".$slave['id']."'>Force</button></td>";
				echo "</tr>";
			}
			?>
		</table>
	</form>
</body>
</html>