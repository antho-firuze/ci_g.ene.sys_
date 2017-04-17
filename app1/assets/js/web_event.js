/*!
 * web_event.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A script to trigger client side, if received message from the server
 */
/* var sse = new EventSource($BASE_URL+'z_libs/shared/pull');
sse.onerror = function(e){
	// Set Status to Offline !
	console.log(e.target);
	$('.user-panel').find('a').html('').append('<i class="fa fa-circle text-red" />Offline');
};
sse.onmessage = function(e){
	result = $.parseJSON(e.data);
	// Set Status to Online !
	$('.user-panel').find('a').html('').append('<i class="fa fa-circle text-green" />Online');
	
	switch(result.code) {
	case 'sys.msg':
		alert(result.message);
		break;
	case 'sys.reload':
		alert(result.message);
		location.reload();
		break;
	}
}; */

/* Set Status to Connecting... */
$('.user-panel').find('a').html('');

setInterval(function(){ 

	var usr_state = $(document).idleTimer("isIdle") ? 2 : 1;
	$.ajax({ url:$BASE_URL+'z_libs/shared/sse', method: "GET", async: true, dataType: 'json',
		data: { '_usr_state':usr_state }, 
		error: function(response) {
			// Set Status to Offline !
			$('.user-panel').find('a').html('').append('<i class="fa fa-circle text-red" />Offline');
		},
		success: function(response) {
			// Set Status to Online !
			$('.user-panel').find('a').html('').append('<i class="fa fa-circle text-green" />Online');
			console.log('response');
			console.log(response);
			if (typeof(response.table) !== 'undefined' && response.table){
				if ($.cookie('table') == response.table){
					dataTable1.ajax.reload( null, false );
					console.log('table:'+$.cookie('table')+' is reload');
				}
			}
		}
	});
		
		/* function(response){ 
		// Set Status to Online !
		$('.user-panel').find('a').html('').append('<i class="fa fa-circle text-green" />Online');
		switch(response.code) {
		case 'sys.msg':
			alert(response.message);
			break;
		case 'sys.reload':
			alert(response.message);
			location.reload();
			break;
		}
	})
	.fail(function() {
		// Set Status to Offline !
		$('.user-panel').find('a').html('').append('<i class="fa fa-circle text-red" />Offline');
	}); */
	
}, 5000);