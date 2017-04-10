/*!
 * form_edit.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A functions for build Form to Add/Edit/Copy Data
 */
/* 
/* ==================================== */
/* Default action for Form Edit */
/* ==================================== */
$( document ).ready(function() {
	
	/* Begin: Populate data to form */
	$.getJSON($url_module, { "id": (id==null)?-1:id }, function(result){ 
		if (!isempty_obj(result.data.rows)) 
			form1.shollu_autofill('load', result.data.rows[0]);  
	});
	
	/* Init form */
	$('form').each(function(e){
		var form = $(this);
		form.validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) { return false;	} 
			
			$.ajax({ url: $url_module+'?id='+id, method:(edit==1?"PUT":"POST"), async: true, dataType:'json',
				headers: { "TYPE": "W" },
				data: form.serializeJSON(),
				success: function(data) {
					BootstrapDialog.alert(data.message, function(){
						window.history.back();
					});
				},
				error: function(data) {
					if (data.status==500){
						var message = data.statusText;
					} else {
						var error = JSON.parse(data.responseText);
						var message = error.message;
					}
					BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});

			return false;
		});
	});
});


