(function($) {
$(function() {

	$('ul.tabs').each(function() {
		$(this).find('li').each(function(i) {
			$(this).click(function(){
				$(this).addClass('current').siblings().removeClass('current')
					.parents(".sk-content").find('div.left-column').eq($(this).index()).fadeIn(150).siblings('div.left-column').hide();
			});
		});
	});

})
})(jQuery)