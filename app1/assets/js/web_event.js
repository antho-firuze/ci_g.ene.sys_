/*!
 * web_event.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A script to trigger client side, if received message from the server
 */
 
/* Set Status to Connecting... */
$('.user-panel').find('a').html('');

/* ======================== */
/* Using EventSource Method */
/* ======================== */
/* 
var sse = new EventSource($BASE_URL+'z_libs/shared/pull');
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

/* =================================== */
/* Using Timer with Ajax Short Polling */
/* =================================== */

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
			// console.log('sse.response');
			// console.log(response);
			if (typeof(response.table) !== 'undefined' && response.table){
				if ($.cookie('table') == response.table){
					dataTable1.ajax.reload( null, false );
					// console.log('table:'+$.cookie('table')+' is reload');
				}
			}
		}
	});
		
}, 5000);

/* =================================== */
/* Using Ajax with Long Polling Method */
/* =================================== */
/**
 * AJAX long-polling
 *
 * 1. sends a request to the server (without a timestamp parameter)
 * 2. waits for an answer from server.php (which can take forever)
 * 3. if server.php responds (whenever), put data_from_file into #response
 * 4. and call the function again
 *
 * @param timestamp
 */
/*  
function getContent(timestamp)
{
    var queryString = {'timestamp' : timestamp};

    $.ajax({ 
			type: 'GET',
			url: $BASE_URL+'z_libs/shared/long_poll',
			data: queryString,
			success: function(response){
				console.log('long_poll.response');
				console.log(response);
				
				// call the function again, this time with the timestamp we just got from server.php
				getContent(response.timestamp);
			}
		});
}

// initialize jQuery
$(function() {
    getContent();
}); */