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

});