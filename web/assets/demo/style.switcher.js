$(function() {
    "use strict";

	$.fn.alterClass = function ( removals, additions ) {
	
	var self = this;
	
	if ( removals.indexOf( '*' ) === -1 ) {
		// Use native jQuery methods if there is no wildcard matching
		self.removeClass( removals );
		return !additions ? self : self.addClass( additions );
	}
 
	var patt = new RegExp( '\\s' + 
			removals.
				replace( /\*/g, '[A-Za-z0-9-_]+' ).
				split( ' ' ).
				join( '\\s|\\s' ) + 
			'\\s', 'g' );
 
	self.each( function ( i, it ) {
		var cn = ' ' + it.className + ' ';
		while ( patt.test( cn ) ) {
			cn = cn.replace( patt, ' ' );
		}
		it.className = $.trim( cn );
	});
 
	return !additions ? self : self.addClass( additions );

	}

	var styleSwitcherButton = $("#style-switcher a.panel-button"),
		swatchButton = $('.switcher'),
		fontSwitcher = $('#font_switcher'),
		page = $('body'),
		switchStylesheet = $('#switchable-stylesheet'),
		switchNav = $('#nav_switcher'),
		nav = $('nav');

	// Style Switcher Open/Close
	// styleSwitcherButton.click(function() {
	// 	var styleSwitcher = $("#style-switcher");
	//     styleSwitcher.toggleClass("close-style-switcher", "open-style-switcher", 1000);
	//     styleSwitcher.toggleClass("open-style-switcher", "close-style-switcher", 1000);
	//     return false;
	// });

	$('body').on('click', '#style-switcher a.panel-button', function (event) {
    	var styleSwitcher = $("#style-switcher");
	    styleSwitcher.toggleClass("close-style-switcher", "open-style-switcher", 1000);
	    styleSwitcher.toggleClass("open-style-switcher", "close-style-switcher", 1000);
	    return false;
	});

	// Color Skins
	$('body').on('click', '#style-switcher .switcher', function (event) {
		var t = $(this),
	    	title = t.prop('title');
	    page.alterClass( 'solid-* pastel-* metallic-*', '' )
		page.addClass(title);
		return false;
	});

	// Change Fonts
	$('body').on('change', '#style-switcher #font_switcher', function (event) {
		var t = $(this);
		page.removeClass('contemporary retro classical');
		page.addClass( $('#style-switcher #font_switcher').val() );
	});

	// Change Navigation Color
	$('body').on('change', '#style-switcher #nav_switcher', function (event) {
		var t = $(this);
		nav.removeClass('navbar-default navbar-inverse');
		nav.addClass( $('#style-switcher #nav_switcher').val() );
		if ( t.val() == "navbar-default" ) {
			$('.navbar-brand img').attr('src','assets/images/foodster_navigation_logo.png');
		}
		else {
			$('.navbar-brand img').attr('src','assets/images/foodster_navigation_logo_inverse.png');
		}
	});

	// Change Navigation Position
	$('body').on('change', '#style-switcher #nav_pos_switcher', function (event) {
		nav.removeClass('navbar-static-top');
		nav.addClass( $('#style-switcher #nav_pos_switcher').val() );

		if ( $('#style-switcher #nav_pos_switcher').val() == 'navbar-fixed-top' ) {
			$('body').css('padding-top','100px');
		}
		else {
			$('body').css('padding-top','0');
		}
	});

	var demo = $("<div />").attr('id', 'style-switcher').addClass("close-style-switcher");
	demo.append(
	"<a class='panel-button'><i class='fa fa-gear fa-spin'></i></a>"
	+ "<div class='style-switcher-section'>"
	+ "<h4>Theme Colors<small>&nbsp;Choose from 3 palettes and 30 dynamic colors</small></h4>"
	+ "</div>"
	+ "<div class='style-switcher-section-col3'>"
	+ "    <h6>Solids</h6>"
	+ "    <a title='solid-black' class='switcher solid-black-bg'></a>"
	+ "    <a title='solid-red' class='switcher solid-red-bg'></a>"
	+ "    <a title='solid-orange' class='switcher solid-orange-bg'></a>"
	+ "    <a title='solid-yellow' class='switcher solid-yellow-bg'></a>"
	+ "    <a title='solid-green' class='switcher solid-green-bg'></a>"
	+ "    <a title='solid-turquoise' class='switcher solid-turquoise-bg'></a>"
	+ "    <a title='solid-aqua' class='switcher solid-aqua-bg'></a>"
	+ "    <a title='solid-blue' class='switcher solid-blue-bg'></a>"
	+ "    <a title='solid-purple' class='switcher solid-purple-bg'></a>"
	+ "    <a title='solid-pink' class='switcher solid-pink-bg'></a>"
	+ "    <a title='solid-tan' class='switcher solid-gray-bg'></a>"
	+ "    </div>"
	+ "    <div class='style-switcher-section-col3'>"
	+ "        <h6>Pastels</h6>"
	+ "        <a title='pastel-red' class='switcher pastel-red-bg'></a>"
	+ "        <a title='pastel-orange' class='switcher pastel-orange-bg'></a>"
	+ "        <a title='pastel-yellow' class='switcher pastel-yellow-bg'></a>"
	+ "        <a title='pastel-green' class='switcher pastel-green-bg'></a>"
	+ "        <a title='pastel-turquoise' class='switcher pastel-turquoise-bg'></a>"
	+ "        <a title='pastel-aqua' class='switcher pastel-aqua-bg'></a>"
	+ "        <a title='pastel-blue' class='switcher pastel-blue-bg'></a>"
	+ "        <a title='pastel-purple' class='switcher pastel-purple-bg'></a>"
	+ "        <a title='pastel-pink' class='switcher pastel-pink-bg'></a>"
	+ "        <a title='pastel-tan' class='switcher pastel-gray-bg'></a>"
	+ "    </div>"
	+ "    <div class='style-switcher-section-col3'>"
	+ "        <h6>Metallics</h6>"
	+ "        <a title='metallic-red' class='switcher metallic-red-bg'></a>"
	+ "        <a title='metallic-orange' class='switcher metallic-orange-bg'></a>"
	+ "        <a title='metallic-yellow' class='switcher metallic-yellow-bg'></a>"
	+ "        <a title='metallic-green' class='switcher metallic-green-bg'></a>"
	+ "        <a title='metallic-turquoise' class='switcher metallic-turquoise-bg'></a>"
	+ "        <a title='metallic-aqua' class='switcher metallic-aqua-bg'></a>"
	+ "        <a title='metallic-blue' class='switcher metallic-blue-bg'></a>"
	+ "        <a title='metallic-purple' class='switcher metallic-purple-bg'></a>"
	+ "        <a title='metallic-pink' class='switcher metallic-pink-bg'></a>"
	+ "        <a title='metallic-tan' class='switcher metallic-gray-bg'></a>"
	+ "    </div>"
	+ "    <div class='style-switcher-section'>"
	+ "        <h4>Other Options<small>&nbsp;Make it yours</small></h4>"
	+ "    </div>"
	+ "    <div class='style-switcher-section-col3'>"
	+ "        <h6>Navigation Color</h6>"
	+ "        <select name='nav_switcher' id='nav_switcher'>"
	+ "            <option value='navbar-default' selected>Light</option>"
	+ "            <option value='navbar-inverse'>Dark</option>"
	+ "        </select>"
	+ "    </div>"
	+ "</div>"
	);

    $("body").append(demo);

});