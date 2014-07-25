<?php
include('settings.php');
$today = date('d-m-Y');
$tile = $_POST['tile'];
$colour= $_POST['colour'];
$cursrv= $_SERVER["SERVER_NAME"];
$presrv= $_SERVER["HTTP_REFERER"];


	$stmt = $db->prepare("UPDATE `$tbl_name_canvas` SET `_dat` = ?, `_time` = ? WHERE `_tile` = ?");
		$stmt->bind_param('sss', $colour, $today, $tile);
		$stmt->execute();
		$stmt -> close();
		$db -> close();


?>