/*!
 * export_data.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A script file to support export_data.tpl
 */
/* 
/* ==================================== */
/* Default action for Form Export Data */
/* ==================================== */
$( document ).ready(function() {
	
	/* Init form */
	$('form').each(function(e){
		var form = $(this);
		
		form.validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) { return false;	} 
			
			var data = form.serializeOBJ();
			// console.log(data);
			// console.log(data.is_compress);
			// return false;
			
			$.getJSON( $BASE_URL+'systems', { export:1, filetype:data.filetype, is_compress:data.is_compress }, function(result){ 
				if (!result.status){
					BootstrapDialog.alert(result.message);
				} else {
					BootstrapDialog.alert(data.message, function(){
						window.history.back();
					});
				}
			});

			return false;
		});
	});
	
});
