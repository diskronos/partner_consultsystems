(function($) {
$(function() {

	$('ul.tab').each(function() {
		$(this).find('li').each(function(i) {
			$(this).click(function(){
				$(this).addClass('current').siblings().removeClass('current')
					.parents(".right-column").find('div.form-box').eq($(this).index()).fadeIn(50).siblings('div.form-box').hide();
			});
		});
	});

})
})(jQuery)