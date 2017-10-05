<?php


$sql_ip = "localhost";
$sql_db = "rpc";
$sql_user = "root";
$sql_pass = "";

$sql_lnk = mysqli_connect($sql_ip, $sql_user, $sql_pass, $sql_db);

if (!$sql_lnk) {
	die("Unable to connect to MySQL.");
}