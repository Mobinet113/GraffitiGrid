<?php
require('settings.php');
$today = date('d-m-Y');
$stmt = $db->prepare("SELECT `_tile`,`_dat` FROM `$tbl_name_canvas`");
$stmt -> execute();
$stmt->bind_result($resultTile, $resultDat);

while ($stmt->fetch()) {
    echo $resultTile.':'.$resultDat.'|';
}

$stmt->free_result();
?>