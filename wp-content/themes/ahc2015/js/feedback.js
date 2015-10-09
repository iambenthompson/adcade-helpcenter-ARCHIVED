/**
 * feedback.js
 *
 * Defines click functionality for feedback buttons (Was this helpful? Yes / No)
 */

jQuery(document).ready(function () {
	// YES button
	jQuery('.page-feedback-voting button.positive').click(function(){
		__gaTracker('send', 'event', 'Page Feedback', 'Vote', 'Positive', 1);
	});
	// NO button
	jQuery('.page-feedback-voting button.negative').click(function(){
		__gaTracker('send', 'event', 'Page Feedback', 'Vote', 'Negative', -1);
	});
});