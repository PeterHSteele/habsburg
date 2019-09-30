jQuery(document).ready(function($){
	let button = $('#menu-toggle'),
		menu = $('#primary-menu'),
		container = $('.main-navigation'),
		clone;

	button.click(function(){
		if ( menu.hasClass('open')){
			menu.removeClass( 'open' )
			menu.slideUp(300);
		} else{
			menu.addClass( 'open' );
			menu.slideDown(300);
		}
	})
});