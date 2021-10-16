// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 08 Jun, 2021 05:36PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// | This Javascript class (LogadApp) MUST only be present in scripts
// | created by the company / individual mention above (Logad Networks)
// +------------------------------------------------------------------------+

// +----------------------------+
// | APP class
// +----------------------------+
class LogadApp {
	
	constructor(container) {
		this.container = container;
	}

	// XHR requests
	ajax_request(url, data, form = true) {
	    if(form == false){
	        var send = $.ajax({
	            url: url,
	            type: "POST",
	            data: data,
	            dataType: "json",
	            cache: false,
	            error: function (xhr) {
	                if (xhr.status == 404 || xhr.status == 500) {
	                    page_error("An unexpected error seems to have occurred. Now that we know, we're working to fix it ☺\nERROR : "+xhr.status);
	                }
	            },
	        });
	    }

	    if(form == true) {
	        var send = $.ajax({
	            url: url,
	            type: "POST",
	            data: data,
	            dataType: "json",
	            cache: false,
	            contentType: false,
	            processData: false,
	            error: function (xhr) {
	                if (xhr.status == 404 || xhr.status == 500) {
	                    page_error("An unexpected error seems to have occurred. Now that we know, we're working to fix it ☺\nERROR : "+xhr.status);
	                }
	            },
	        });
	    }
	    return send;
	}

	// Handle form submissions
	handleForm (form, options) {
		var btn = form.find('[type=submit]');
		var btn_text = btn.text();
		btn.text('please wait..');
		btn.addClass('disabled');
		btn.attr('disabled', true);
		var response = '';
		var formData = new FormData(form[0]);
		if (options.append) {
			for (var appendKey in options.append) {
				var value = options.append[appendKey];
				formData.append(appendKey, value);
			}
		}
		var req = this.ajax_request(options.url,formData);
		req.done(function (data) {
			if (data.error == false) {
				notyf.success(data.msg);
				if (options.callback_function) {
					options.callback_function(data);
				}
				btn.text(btn_text);
				btn.removeClass("disabled");
				btn.removeAttr("disabled");
				response = "success";
			} else {
				notyf.error(data.msg);
				btn.text(btn_text);
				btn.removeClass("disabled");
				btn.removeAttr("disabled");
				response = "failed";
			}
		});
		req.fail(function (xhr) {
			response = 'error';
			btn.text(btn_text);
			btn.removeClass("disabled");
			btn.removeAttr("disabled");
		});

		return response;
	}
}

// Handle Page errors
function page_error(msg = "Some error occurred. Please contact system support") {
	if (msg == 404) {
		msg = "404. Page not found";
	}
	notyf.error(msg);
}