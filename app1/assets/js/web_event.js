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

function requery()
{
	var usr_state = get($lockscreen) == 1 ? 'idle' : 'active';
	$.ajax({ url:$BASE_URL+'z_libs/sse', method: "GET", async: true, dataType: 'json', data: { '_usr_state':usr_state }	});
}

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

requery();

setInterval(function(){ requery(); }, 10000);

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