	function IsEmail(email) {
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
	
	
		function checkConfirm(original, against, formfield, warnelem){
			$(against).focusout(function(){
				var orig = $(original).val().toLowerCase();
				var conf = $(against).val().toLowerCase();


				if (orig != conf){
					$(warnelem + ' b').html(formfield + ' Does Not Match!');
					isValid1 = false;
				} else {
					$(warnelem + ' b').html('');
					isValid1 = true;
				}
			});
		};
	
		function sendReq(sendDat, getfield, formfield, warnelem){
			$('.reg-' + warnelem + ' b').html('<img src="media/ajax-loader.gif" alt="loading">');
			setTimeout(function() {
				$.ajax({
					type: "POST",
					url: 'sources/user_action.php',
					data: { action: 'read', dsend: sendDat, field: getfield},
					success: function(data) {
						console.log(data);
						if (data === 'available'){
							$('.reg-' + warnelem + ' b').html(formfield + ' Available!')
							$('.reg-' + warnelem + ' b').css('color', 'ForestGreen');
							isValid2 = true;
						
						} else {
							$('.reg-' + warnelem + ' b').html(formfield + ' Unavailable');
							$('.reg-' + warnelem + ' b').css('color', 'fireBrick');
							isValid2 = false;
						}
					}
				})
			}, 1250);
		};
		
		
		function checkField(element, code, forminput, checkAval){
			$(element).focusout(function(){
				var dat = $(this).val();
				var warnelem = forminput.toLowerCase().replace(/ /g, '');

				if (forminput == 'Email Address'){
					var emailad = $('#selEmailAddress').val();
					if (!IsEmail(emailad)){
						$('.reg-' + warnelem + ' b').css('color', 'fireBrick');
						$('.reg-' + warnelem + ' b').html('Email Address is Not Valid');
						isValid3 = false;
					} else {
						checkField2()
					}
				} else {
				checkField2()
				}
				
				function checkField2(){
					if(dat.length > 0){
						if (checkAval === true){
							sendReq(dat, code, forminput, warnelem);
						} else {
							$('.reg-' + warnelem + ' b').html('');
							isValid3 = true;
							$('input[type="submit"]').removeAttr('disabled');
						}
					} else {
						$('.reg-' + warnelem + ' b').html(forminput + ' Required');
						$('.reg-' + warnelem + ' b').css('color', 'fireBrick');
						isValid3 = false;
						$('input[type="submit"]').attr('disabled','disabled');
					}
				};
				
			});
		};
		
		
		window.validateForm = function(){
			if(isValid1 == false || isValid2 == false || isValid3 == false){
				$('.finerror').html('Please check the form for errors');
				return false;
			}
		};
		
		window.validateForm2 = function(){
			var rec = $('#selrecipient').val().length;
			console.log(rec);
			if(isValid1 == false || isValid2 == false || isValid3 == false || rec < 1){
				$('.finerror').html('Please check the form for errors');
				return false;
			}
		};