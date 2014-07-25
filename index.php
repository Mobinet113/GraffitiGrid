<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
<script src="js/jquery.hotkeys.js" type="text/javascript"></script>
<script src="js/jquery-1.9.0.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
<script src="js/html2canvas.js" type="text/javascript"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('tbody').html('<img src="media/ajax-loader.gif" />');
		$.ajax({
			type: "POST",
			url: 'sources/grid.php',
			data: {},
			success: function(data) {
				$('tbody').html(data);
				drawBase();
				drawData();
			}
		});
		$('.custom').ColorPicker({
			onChange: function (hsb, hex, rgb) {
				$('.custom').val('#' + hex);
				$('.cussample').css('backgroundColor', '#' + hex);
				selCol = '#'+hex;
			}
		});
		
		//Hotkeys
		$(document).bind('keydown', 'r', function (evt){drawData();});
		
		$('.forceRefresh').click(function(){drawData();});
		
		$('.clearcanvas').click(function(){
			var r = confirm("Wipe the canvas?");
			if (r == true){
				window.location.replace('sources/clear.php');
			}
		});
		
		
		function autorefr(){
			setTimeout(function(){
				drawData();
				autorefr();
			},1000);
		}
		
		function drawData(){
			var n = null;
			$('.forceRefresh').css({'background':'firebrick','color':'white'});
			
			$.ajax({
				type: "POST",
				url: 'sources/grid_dat.php',
				success: function(data) {
					n = data;
					n = n.split('|');
					for(var i=0;i<n.length+1;i++){
						var s = n[i].toString();
						var s = s.split(':');
						$('#'+s[0]).css("background", s[1]);
						$('#'+s[0]).css("border", s[1]);
						$('.forceRefresh').css({'background':'white','color':'black'});
					}
				}
			});
		}
		

		function drawPalette(){
			selTool= 'pencil';
			selCol = 'black';
		
			$('.colours').click(function(){
				selCol = $(this).css('backgroundColor');
				seltool = 'pencil';
				$('.colours, .tool').css('border', 'solid 2px white');
				$(this).css('border', 'solid 2px black');
			});
			$('.tool').click(function(){
				selTool = $(this).attr('id');
				$('.colours, .tool').css('border', 'solid 2px white');
				$(this).css('border', 'solid 2px black');
			});
			
			$('.palette .custom').keyup(function(){
				var cusCol = $(this).val();
				$('.cussample').css('background', cusCol);
			});
		}
	
		
	
		function drawBase(){
			drawPalette();
			isMouseDown = false;
			$('body').mousedown(function() {
				isMouseDown = true;
			})
			.mouseup(function() {
				isMouseDown = false;
			});

			
			$('td').mouseenter(function(){
				$(this).css('border', 'solid 1px black');
					if(isMouseDown === true){
						var curTile = $(this).attr('id');
						
						if(selTool == 'pencil'){
							$(this).css('background',selCol);
							$(this).css('border', selCol);
							$.ajax({
								type: "POST",
								url: 'sources/post.php',
								data: {tile: curTile, colour: selCol},
								success: function(data) {
									$('#error').append(data);
								}
							});
						}else if(selTool == 'eyedropper'){
							selCol = $(this).css('background-color');
							console.log(selCol);
							$('.cussample').css('background', selCol);
							$('.tool').css('border', 'solid white 2px');
							$('.cussample').css('border', 'solid black 2px');
							selTool = 'pencil';
						}
					}
			});	
			
			$('td').mouseleave(function(){
				$(this).css('border', 'solid 0px');
			});
		}
		
	$('.render').click(function(){
		html2canvas(document.body, {
			onrendered: function(canvas) {
				document.body.appendChild(canvas);
			},
			width: 300,
			height: 300
		});
		var dataURL = canvas.toDataURL();
		 document.getElementById('canvasImg').src = dataURL;
	});
});
</script>
</head>
</body>
<div id="header">
	<div class="wrapper">
	<h1>Live Canvas</h1>
	<b>"You can draw things!"</b>
	</div>
</div>

<div id="maincontainer">
<div id="grid">
	<table>
		<tbody>
	
		</tbody>
	</table>
	
	<canvas>
	
	</canvas>
</div>
<div class="palette">
	<b>Palette</b><br />
	<div class="colours black">		</div>
	<div class="colours white">		</div>
	<div class="colours blue">		</div>
	<div class="colours green">		</div>
	<div class="colours red">		</div>
	<div class="colours orange">	</div>
	<input class="custom" type="text" /><div class="colours cussample">	</div><br /><br />
	<div class="tool" id="eyedropper">E</div><br /><br />
	<?php
		if($_SERVER['REMOTE_ADDR'] == '86.13.116.93'){
			echo '<button class="clearcanvas">Clear Grid</button>';
		}
	?>
	<button class="forceRefresh">Refresh Canvas</button>
</div>
<div id="footer">
	<div class="wrapper">
		<p>Oh look! Another silly website by that guy.</p>
		<p>You can come and visit me at <a href="http://www.houseof.mobi">http://www.houseof.mobi</a>
		<p>If you enjoyed this little site, please consider donating: 
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="VDLWYVVJYRZL8">
			<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
</div>
</body>
</html>