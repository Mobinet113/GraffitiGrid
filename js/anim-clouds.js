function animClouds(){
		
		$('.clouds').animate({
			opacity: 1,
		}, 1000, function(){
		
			$('.clouds').animate({
				left: '-1550'
			}, 170000, 'linear', function(){
				$(this).css('opacity', '0');
				$(this).css('left', '1400px');
				animClouds()
			});
		});
	}