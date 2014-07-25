<?php
$Xscale = 200; //Size of the grid
$Yscale = 130; //Size of the grid

for($y = 1; $y <= $Yscale; $y++){
	echo '<tr id="'.$y.'">';
	for($x = 1; $x <= $Xscale; $x++){
		$tileID = $x.'_'.$y;
			
		echo '<td id="'.$tileID.'"></td>';	
			
	}
	echo '</tr>';
}



?>