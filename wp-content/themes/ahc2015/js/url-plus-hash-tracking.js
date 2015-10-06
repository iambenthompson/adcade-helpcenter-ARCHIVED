
//Track pageviews for original summary links in Classes in API
jQuery(document).ready(function () {
	jQuery('#properties-summary .property.original a.self-referential').click(function(){
		var match = jQuery(this).attr('href').match(/#\S+/);
		var title = document.title + ((match[0] != "") ? " - " + match[0].substring(1) : "");
		__gaTracker('set', {
		  page: location.pathname + match[0],
		  title: title
		});
		__gaTracker('send', 'pageview');
	});
	jQuery('#methods-summary .method.original a.self-referential').click(function(){
		var match = jQuery(this).attr('href').match(/#\S+/);
		var title = document.title + ((match[0] != "") ? " - " + match[0].substring(1) : "");
		__gaTracker('set', {
		  page: location.pathname + match[0],
		  title: title
		});
		__gaTracker('send', 'pageview');
	});
	jQuery('.toc_widget a').click(function(){
		var match = jQuery(this).attr('href').match(/#\S+/);
		var title = document.title + ((match[0] != "") ? " - " + match[0].substring(1) : "");
		__gaTracker('set', {
		  page: location.pathname + match[0],
		  title: title
		});
		__gaTracker('send', 'pageview');
	});

});
//Actual pageviews with hashes in URL when page is requested is handled by Yoast Google Analytics custom JS code in Admin