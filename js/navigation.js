/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
 
jQuery(document).ready( function($) {
	var container, button, menu, links, i, len, search_expand, toggle, form, list_items;

	toggle = function( container, toggler, toggled, aria_prop ) {
		
		if ( container.hasClass( 'toggled' ) ) {
			container.removeClass( 'toggled' );
			toggler.setAttribute( aria_prop, 'false' );
			toggled.attr( aria_prop, 'false' );
		} else {
			container.addClass( 'toggled' );
			toggler.setAttribute( aria_prop, 'true' );
			toggled.attr( aria_prop, 'true' );
		}
	};

	/*=========
	Menu Toggle
	==========*/

	container = document.getElementById( 'site-navigation' )
	containerJquery = $( '#site-navigation' ); // same as prev line but can be used in jquery fns
	
	if ( ! container ) {
		return;
	}

	
	button = document.getElementById( 'menu-toggle' );
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = $(".main-navigation ul");

	// Hide menu toggle button if menu is empty.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
	}

	menu.attr( 'aria-expanded', 'false' );
	
	if ( -1 === menu.attr('class').indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}	
	
	button.addEventListener('click',function(e){
		if ( menu.hasClass('open')){
			menu.removeClass( 'open' ).slideUp(300).attr( 'aria-expanded', false )
		} else{
			menu.addClass( 'open' ).slideDown(300).attr( 'aria-expanded', true );
		}
	});
	

	
	//remove .toggle from menu on resize window
	window.onresize = function(){
		button.setAttribute( 'aria-expanded', 'false' );
		menu.attr( 'aria-expanded', 'false' );
		menu.removeClass('open')
		menu.attr('style','')	
	}

	/*=========
	Search Bar Toggle
	==========*/

	forms = Array.from( document.getElementsByClassName( 'nav-search-form' ) );
	
	//search_expands = Array.from( document.getElementsByClassName( 'nav-search-expand' ) );
	search_expands = $('.nav-search-expand');
	
	if ( 'undefined' === typeof search_expands ){
		return;
	}

	search_fields =  $('.nav-search-field');

	search_expands.attr( 'aria-pressed', 'false' );
	search_expands.click( function( event ){
		toggle( $(this).parent(), event.target, $(this).parent().children( 'input' ), 'aria-pressed');
	});

	/*=========
	Nav li focus
	==========*/
	
	// Get all the link elements within the menu.
	links    = menu.find( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
});
