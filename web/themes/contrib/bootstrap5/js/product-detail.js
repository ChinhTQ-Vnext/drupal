
jQuery.noConflict();
jQuery(function($){
	/*=============================================================
		toggle
	=============================================================*/
	if(!jQuery('div#featureArea div').hasClass("outer")){jQuery('div#featureArea').hide();}
	$('#featureArea h2').click(function(){
		var elm=$(this).parents('.outer');
		if(elm.find('.inner:animated').length ==0){
			$(elm).toggleClass('open')
			$(elm).find('.inner').slideToggle(600);
		}
		return false;
	});
	$('a.openFea').click(function(){
		var ancTop = $("#feature").offset().top;
		var elmAll=$(this).parents().parents().parents('#featureArea').children('.outer');
		$(elmAll).addClass('open')
		$(elmAll).find('.inner').slideDown(600);
		$('html,body').animate({ scrollTop: ancTop }, 'fast');
		return false;
	});
	$('a.closeFea').click(function(){
		var ancTop2 = $("#feature").offset().top;
		var elmAll2=$(this).parents().parents().parents('#featureArea').children('.outer');
		$(elmAll2).removeClass('open')
		$(elmAll2).find('.inner').slideUp(600);
		$('html,body').animate({ scrollTop: ancTop2 }, 'fast');
		return false;
	});
});



