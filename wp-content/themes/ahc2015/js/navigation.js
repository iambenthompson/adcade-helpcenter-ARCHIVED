/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function() {
	var Menu=function(menuId,wrapperSelector,wrapperClass){
		var menu,
			menuEl=document.querySelector(menuId);

		if(menuEl){
			var children=menuEl.children,
				wrapper=document.querySelector(wrapperSelector);

			if(children.length>1&&wrapper){
				var open=children[0],
					close=children[1];

				menuEl.onclick=function(e){
					e.preventDefault(),
					menu.wrapper.classList.toggle(wrapperClass),
					menu.menu.classList.toggle("closed"),
					menu.closed=!menu.closed
				},
				menu={closed:!0,open:open,close:close,menu:menuEl,wrapper:wrapper}
			}
		}
		return menu
	};

	window.addEventListener("DOMContentLoaded",
		function(){
			new Menu("#nav-button",".menu-site-nav-container","closed-nav")
			//new Menu("#sidebar-nav-button","#sidebar","expanded")
		},!1)

	//BELOW WAS INCLUDED IN THEME..  ABOVE WAS MIGRATED FROM V1 HC
	/*
	var container, button, menu, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}
	*/
	/**
	 * Sets or removes .focus class on an element.
	 */
	 /*
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
	}*/
} )();
