<?php
include('settings.php');
$today = date('d-m-Y');
$colour = 'white';

$stmt = $db->prepare("UPDATE `$tbl_name_canvas` SET `_dat` = ?, `_time` = ? WHERE `_dat` NOT LIKE 'white'");
	$stmt->bind_param('ss', $colour, $today);
	$stmt->execute();
	$stmt -> close();
	$db -> close();
		
header("Location: ../index.php");
?>