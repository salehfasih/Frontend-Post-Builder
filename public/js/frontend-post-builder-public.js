(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	//  Form submission handler
	$(document).on('submit', '.fps_frontend_form form', function (e) {
		e.preventDefault();
		var formData = $(this).serialize();
		var userId = $('#fps_user_id').val();
		// Add nonce to the form data
		formData += '&action=fps_create_post';
		formData += '&fps_post_builder_nonce=' + $('#fps_post_builder_nonce').val();


		if (!userId) {
			alert("Please Login to create a post.");
			return;
		}
		$.ajax({
			type: 'POST',
			url: fps_ajax_object.ajax_url,
			data: formData,
			success: function (response) {
				if (response.success) {

					$(".fps_main_wrapper .submission_message").html("<p>Post created successfully!</p>");
					setTimeout(function () {
						$(".fps_main_wrapper .submission_message").html("");
						$('.fps_frontend_form form')[0].reset();
						location.reload();
					}, 3000);

				} else {
					alert('Error creating post: ' + response.data);
				}
			},
			error: function (error) {

				console.error('Error:', error);
				alert('An error occurred while processing your request.' + error);
			}
		});
	});


})(jQuery);
