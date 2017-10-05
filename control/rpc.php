<?php
require_once("inc.php");

if (empty($_GET)) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$query = "SELECT * FROM slaves WHERE ip='".$ip."'";
	$resp = mysqli_query($sql_lnk, $query);
	$row = mysqli_fetch_assoc($resp);
	if (!$row) {
		mysqli_query($sql_lnk, "INSERT INTO slaves (ip) VALUES ('".$ip."')");
		die("Invalid.");
	}
	$status = $row['set_status'];
	if ($status == "disable") {
		die("disable");
	}
	else if ($status == "force") {
		die("force");
	}
	else {
		die("enable");
	}
}
else if (isset($_GET['status'])) {
	$status = $_GET['status'];
	if ($status == "True") {
		$query = "UPDATE slaves SET current_status='true' WHERE ip='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($sql_lnk, $query);
	}
	else if ($status == "False") {
		$query = "UPDATE slaves SET current_status='false' WHERE ip='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($sql_lnk, $query);
	}
}