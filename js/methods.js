/* Author:
M.Satrya - http://twitter.com/msattt
*/

var $ = jQuery.noConflict();

$(document).ready(function(){

	// Drop-down menu
	$( ".menu-primary li" ).hover(function(){
		$(this).find( "ul:first" ).slideDown( "fast" );
	}, function(){
		$(this).find( "ul:first" ).slideUp( "fast" );
	});

	// Slides
	$('#slides').camera({
		height: '400px',
    	pagination: false,
    	loader: 'bar',
        navigation: true,
        navigationHover: true,
        playPause: false
    });

    // prettyPhoto
    $("a[rel^='prettyPhoto']").prettyPhoto({
    	theme: 'dark_square',
    	social_tools: false
    });

});