// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 06 Oct, 2021 09:14AM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Custom JS
// +----------------------------+

// Create an instance of Notyf
var notyf = new Notyf({
    position:{x:'right', y:'top'},
    duration:6000,
    dismissable:true,
    types: [
        {
            type: 'info',
            background: '#17a2b8',
            icon: {
                className: 'ri ri-information-line text-white',
                tagName: 'i',
                text: ''
            }
        }
    ]
});
notyf.info = function (message) {
    notyf.open({
        type: 'info',
        message: message
    });
}

// PJAX
var pjax;
var initButtons = function () {
	var buttons = document.querySelectorAll("a.lazy");
	if (!buttons) {
		return;
	}
};

document.addEventListener("pjax:send", function() {
	loader_display();
});
document.addEventListener("pjax:error", function(event) {
	if (event.request.status == 404) {
		page_error(event.request.status+" "+event.request.statusText);
	}
	loader_display("hide");
});
document.addEventListener("pjax:success", function() {
	autoactive();
	re_init();
	initButtons();
});
document.addEventListener("DOMContentLoaded", function () {
	pjax = new Pjax({
	  	elements: ["a.lazy"],
	  	selectors: ["title","div.page-content"],
	  	cacheBust: true
	});
	autoactive();
	re_init();
	initButtons();
});


// Auto Active
function autoactive() {
    var current = location.pathname;
    $('#sidebar-menu ul li a').removeClass("active");
    $('#sidebar-menu ul li a').removeClass("mm-active");
    $('#sidebar-menu ul li').removeClass("active");
    $('#sidebar-menu ul li a').each(function() {
        var $this = $(this);
        new_current = current.split("/")[current.split("/").length-1];
        if (new_current == '') {
            $('#sidebar-menu ul li:not(.menu-title):first a').addClass("active")
        }
        else {
            // if the current path is like this link, make it active
            // if($this.attr('href').indexOf(new_current) !== -1){
            //     $this.parent().addClass('active');
            //     return false;
            // }
            if ($this.attr('href') == "./"+new_current) {
                $this.parent().addClass('active');
                $this.addClass('active');
            }   
        }
    });
    // close sidebar
    if ($("body").hasClass('sidebar-enable')) {
        $("body").removeClass('sidebar-enable');
    }
}
function re_init() {
    $(function() {
    	bsCustomFileInput.init();
        // Datatables clients
        $(".data-table").each(function() {
        	// Default Datatable options
	        dataTablesOptions = {
	        	dom: 'Bfrtip',
	        	"bDestroy": true,
	        	"order": [],
	        	responsive: false,
	            fixedHeader: true,
				// pageLength: 15,
    	        // language:{
    	        // 	paginate:{
    	        // 		previous:"<i class='mdi mdi-chevron-left'>",
    	        // 		next:"<i class='mdi mdi-chevron-right'>"
    	        // 	}
    	        // },
    	        // drawCallback:function() {
    	        // 	$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
    	        // },
    	        buttons:[
    	        	{
    	        		extend: 'excel',
    	        		text: '<i class="ri ri-file-excel-2-line"></i>',
    	        		className: 'btn btn-success mr-2',
    	        		exportOptions: {
    	        			columns: 'th:not(.no-export)'
    	        		},
    	        		titleAttr: 'Export To Excel'
    	        	},
    	        	{
    	        		extend: 'pdf',
    	        		text: '<i class="mdi mdi-file-pdf-outline"></i>',
    	        		className: 'btn btn-danger mr-2',
    	        		exportOptions: {
    	        			// columns: 'th:not(:last-child)'
    	        			columns: 'th:not(.no-export)'
    	        		},
    	        		titleAttr: 'Export To PDF'
    	        	},
    	        	{
    	        		extend: 'copy',
    	        		text: '<i class="ri ri-file-copy-line"></i>',
    	        		className: 'btn btn-primary',
    	        		exportOptions: {
    	        			columns: 'th:not(.no-export)'
    	        		},
    	        		titleAttr: 'Copy Table'
    	        	}
    	        ],
    	        columnDefs: [ {
	               orderable: false,
	               className: 'select-checkbox',
	               targets:   0
	           	}],
	           select: {
	               style:    'multi',
	               selector: 'td:first-child'
	           },
	        }

	        // Create tfoot from thead
	        var footer = $('<tfoot>'+$(this).find('thead').html()+'</tfoot>').insertAfter($(this).find('tbody'));

	        // Fetch from Ajax
	        /*if ($(this).hasClass('dt-ajax')) {
	        	dataTablesOptions.ajax = $(this).attr('ajax-source');
	        }*/

	        // DataTable options
            if ($(this).hasClass('dt-resp')) {
                dataTablesOptions.responsive = true;
            }
            if (!$(this).hasClass('dt-search')) {
                delete dataTablesOptions.initComplete;
            }
            if (!$(this).hasClass('dt-checkbox')) {
                delete dataTablesOptions.columnDefs;
                delete dataTablesOptions.select;
            }
            if (!$(this).hasClass('dt-fixed')) {
                delete dataTablesOptions.fixedHeader;
            }

            dt_table = $(this).DataTable(dataTablesOptions);
            // dt_table.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
        });
    });

    if ($(".summernote").length) {
	    // Summernote editor
	    $('.summernote').summernote({
	        placeholder: 'Type Something...',
	        tabsize: 4,
	    	height:200,
	    	minHeight:null,
	    	maxHeight:null,
	    	focus:!0,
	    	toolbar: [
	    	  ['style', ['style']],
	    	  ['font', ['bold', 'underline', 'clear']],
	    	  ['fontname', ['fontname']],
	    	  ['color', ['color']],
	    	  ['para', ['ul', 'ol', 'paragraph']],
	    	  ['table', ['table']],
	    	  ['insert', ['picture', 'link']],
	    	  ['view', ['fullscreen', 'help']],
	    	],
	    	callbacks: {
	    	    onImageUpload: function(files) {
	    	        sendEditorFile(files[0]);
	    	    }
	    	}
	    });
    }
}

function sendEditorFile(file, editor, welEditable) {
    data = new FormData();
    data.append("file", file);

    xhrRequest({
    	url : "./backend/editor-upload",
    	data : data,
    	form : true,
    	done : function (data) {
	        if (data.error == false) {
	        	notyf.success(data.msg);
	            var image = $('<img>').attr('src', data.url);
	            $('.summernote').summernote("insertNode", image[0]);
	        } else {
	            page_error(data.msg);
	        }
    	}
    });
}

// Redirect to another page
function redirect(url, use_pjax = false) {
	if (!use_pjax) {
		window.location.href = url;
	}
	else {
		pjax.loadUrl(url);
	}
}

function reload(use_pjax = false) {
	if (!use_pjax) {
		window.location.reload(true);
	} else {
		pjax_reload();
	}
}

function loader_display(act = "display"){
	if (act == "display") {
		$("#loader").css({
			opacity: '1',
			display: ''
		});
	}
	else {
		$("#loader").css({
			opacity: '0',
			display: 'none'
		});
	}
}

// Handle Desktop notifications
function push_noti(title,body, link = '#'){
	Push.create(title, {
		body: body,
		icon: '../assets/img/logo-alt.png',
		link: link,
		timeout: 4000,
		onClick: function () {
			console.log("Fired!");
			window.focus();
			this.close();
		},
		onShow: function () {
			console.log("show");
			$("#notification-sound")[0].play();
		},
		vibrate: [200, 100, 200, 100, 200, 100, 200]
	});
}

// Custom Submit function
(function($){
	$.fn.ajaxSubmit = function(options) {
		$(this).submit(function(event) {
			event.preventDefault();
			if (options.summernote) {
				options.content = $('#summernote').summernote('code');
			}
			logad.handleForm($(this), options);
		});
      	return this;
   	}; 
})(jQuery);

// Custom ajax request
function xhrRequest(options) {
	if (!options.form) {
		form = false;
	} else {
		form = true;
	}
	var req = logad.ajax_request(options.url, options.data, form);
	req.done(function(data) {
		if (options.done) {
			options.done(data);
		}
	});
	req.fail(function(xhr) {
		if (!options.fail || options.fail == 'default') {
			page_error("Xhr request failed");
			console.log(xhr);
		}
	});
}

// Reload using pjax
function pjax_reload(){
    pjax.loadUrl(window.location.href);
}

// Load Content into modal
// function modal_load(url, data, buttons = null){
function modal_load(options){
    modal = $("#contentModal");
    modal_body = $('#modal-ajax-content');
    modal_label = $("#contentModalLabel");
    modal_footer = $("#contentModal .modal-footer");

    // Buttons
    btns = options.buttons + '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';

    // Assign the modal footer first
    modal_footer.html(btns);
    
    $("#contentModal .modal-body").addClass('running');
    modal.modal('show');
    var req = logad.ajax_request(options.url, options.data, false);
    req.done(function(data) {
        if(data.error == false) {
            notyf.success(data.msg);
            modal_body.html(data.html);
            modal_label.html(data.title);
            $("#contentModal .modal-body").removeClass('running');
        } else {
            notyf.error(data.msg);
        }
    });
    req.fail(function(xhr) {
        modal_body.html("<h1 class='text-danger text-center'>Content failed to load</h1>");
        $("#contentModal .modal-body").removeClass('running');
        console.log("Xhr Error");
    });
}

function livePosNotifications() {
	xhrRequest({
		url : "./backend/live-notifications",
		done : function (data) {
			if(data.error == false) {
				$.each(data.notifications, function(index, val) {
					notyf.info(val);
					$("#notification-sound")[0].play();
				});
			} else {
			    page_error(data.msg);
			}
		} 
	})
}