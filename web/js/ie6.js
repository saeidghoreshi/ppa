$(function() {
	$('div.login img').attr('src','images/logo_small.png');
	
	$('.default-value').each(function() {
		var default_value = this.value;
		var prompt_value = $(this).attr('title');
		if(!default_value) {
			this.value = prompt_value;
			$(this).addClass('waiting-user-input');
		}
		$(this).focus(function() {
			if(this.value == prompt_value) {
				$(this).removeClass('waiting-user-input');
				this.value = '';
			}
		});
		$(this).blur(function() {
			if(this.value == '') {
				$(this).addClass('waiting-user-input');
				this.value = prompt_value;
			}
		});
	});
}); 