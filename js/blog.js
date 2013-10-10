(function($) {
	$(function() {
		$('.ajaxForm[method="post"]').submit(function() {
			var output = $('#output');
			var form = $(this);

			var name = $(this).find('input[name="name"]').val(),
				body = $(this).find('textarea[name="comment"]').val();

			var formData = '{ "name":"' + name + '", "body":"' + body + '" }';

			console.log("Submitting: " + formData);

			$.post($(this).attr('action'), formData)
			.done(function(data) {
				output.append('Server response: ' + JSON.parse(data).data + '<br/>');
			})
			.fail(function(xhr, err, ex) {
				output.append('Something bad happened: ' + err + '<br/>');
				output.append('Exception: ' + ex + '<br/>');
			});

			return false;
		});
	});
})(jQuery);