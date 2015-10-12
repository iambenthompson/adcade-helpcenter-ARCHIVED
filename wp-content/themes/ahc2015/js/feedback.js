/**
 * feedback.js
 *
 * Defines click functionality for feedback buttons (Was this helpful? Yes / No)
 */

jQuery(document).ready(function () {
	// YES button
	jQuery('.page-feedback-voting').on('click', 'button.positive', function(){
		__gaTracker('send', 'event', 'Page Feedback', 'Vote', 'Positive', 1);
		jQuery('.page-feedback-voting button').off('click').remove();
		jQuery('.page-feedback-voting p').append('<strong>Thank you!</strong>');
	});
	// NO button
	jQuery('.page-feedback-voting').on('click', 'button.negative', function(){
		__gaTracker('send', 'event', 'Page Feedback', 'Vote', 'Negative', -1);
		jQuery('.page-feedback-voting button').off('click').remove();
		jQuery('.page-feedback-voting p').append('<strong>Thank you!</strong>');
	});
});