$(function(){
	
	if($(window).width() > 768) {
		$('#trans_wrap').css('margin-top',$(window).height() / 2 - $('#trans_wrap').height() / 2 + 'px');
	}
	
	$(window).resize(function(){
		if($(window).width() > 768) {
			$('#trans_wrap').css('margin-top',$(window).height() / 2 - $('#trans_wrap').height() / 2 + 'px');
		} else {
			$('#trans_wrap').css('margin-top', 0);
		}
	});
	
});
