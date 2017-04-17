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
/* ========================================= */
/* Default init for Header									 */
/* ========================================= */
var $pageid = getURLParameter("pageid");

// $( document ).ready(function() {
	/* Start :: Init for Title, Breadcrumb */
	var $title	= $.cookie('title'+$pageid)
	$(".content").before(BSHelper.PageHeader({ 
		title: $title, 
		title_desc: act_name, 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link: $APPS_LNK },
			{ icon:"", title: $title, link:"javascript:history.back()" },
			{ icon:"", title: act_name, link:"" },
		]
	}));

// });
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
			
			form.find("[type='submit']").prop( "disabled", true );
			
			var data = form.serializeOBJ();
			
			$.getJSON( $BASE_URL+$class+'/'+$method, { export:1, pageid:$pageid, filetype:data.filetype, is_compress:data.is_compress }, function(result){ 
				if (!result.status) {
					BootstrapDialog.alert(result.message);
					form.find("[type='submit']").prop( "disabled", false );
				} else {
					window.open(result.file_url);
					
					setTimeout(function(){ window.history.back(); }, 500); 
				}
			});

			return false;
		});
	});
	
});
