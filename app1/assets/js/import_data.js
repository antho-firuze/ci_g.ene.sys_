/*!
 * import_data.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A script file to support import_data.tpl
 */
/* Get Params */
var id = getURLParameter("id"), 
	$pageid = getURLParameter("pageid"),
	$filter = getURLParameter("filter"),
	$ob = getURLParameter("ob"),
	act = getURLParameter("action"),
	act_name = "(Importing Data To Database)";
/* 
/* ========================================= */
/* Default init for Header									 */
/* ========================================= */

// $( document ).ready(function() {
	/* Start :: Init for Title, Breadcrumb */
	// console.log($bread);
	// console.log($bread.length);
	$(document).prop('title', $HEAD_TITLE+' > '+$bread[$bread.length-1].title);
	$bread.unshift({ icon:"fa fa-dashboard", title:"Dashboard", link: "window.location.replace('"+$APPS_LNK+"')" });
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	
	$(".content-header small").html(act_name);
// });
/* 
/* ==================================== */
/* Default action for Form Import Data */
/* ==================================== */
$( document ).ready(function() {
	
	/* Init form */
	/* $('form').each(function(e){
		var form = $(this);
		
		form.validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) { return false;	} 
			
			form.find("[type='submit']").prop( "disabled", true );
			
			var data = form.serializeOBJ();
			
			$.getJSON( $BASE_URL+$class+'/'+$method, { import:1, pageid:$pageid, filter:$filter, ob:$ob, filetype:data.filetype, importtype:data.importtype }, function(result){ 
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
	}); */
	
});
