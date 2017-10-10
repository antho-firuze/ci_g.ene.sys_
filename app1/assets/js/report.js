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
	act_name = "";
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
	
	/* This class is for auto conversion from dmy to ymd */
	$(".auto_ymd").on('change', function(){
		$('input[name="'+$(this).attr('id')+'"]').val( datetime_db_format($(this).val(), $(this).attr('data-format')) );
	});
	
	/* Init form */
	$('form').each(function(e){
		var form = $(this);
		
		if (typeof(tinyMCE) !== 'undefined') {
			form.on('submit', function(e){
				form.find('textarea.editor-tinymce').val(tinyMCE.activeEditor.getContent());
			});
		}
		
		form.validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) { return false;	} 
			// var r_method = ($act == 'new') ? 'POST' : ($act == 'cpy') ? 'POST' : 'PUT';
			// var r_method = $.inArray($act, ['new','cpy']) > -1 ? 'POST' : $.inArray($act, ['edt']) > -1 ? 'PUT' : 'OPTIONS';
			
			/* adding primary key id on the fly */
			// form.append(BSHelper.Input({ type:"hidden", idname:"id", value:$id }));
			
			/* adding foreign key id on the fly */
			// if ($filter){
				// $.each($filter.split(','), function(i, val){
					// var fil = val.split('=');
					// form.append(BSHelper.Input({ type:"hidden", idname:fil[0], value:fil[1] }));
				// });
			// }
			// console.log(form.serializeJSON()); return false;
			
			form.find("[type='submit']").prop( "disabled", true );
			
			$.ajax({ url: $url_module, method: 'OPTIONS', async: true, dataType:'json',
				data: form.serializeJSON(),
				success: function(data) {
					if (data.status){
						form.find("[type='submit']").prop( "disabled", false );
						window.open(data.file_url);
					}
					/* BootstrapDialog.show({ message:data.message, closable: false,
						buttons: [{ label: 'OK', hotkey: 13, 
							action: function(dialogRef) {
								window.open(result.file_url);
								// window.history.back();
							} 
						}],
					}); */
					// var dialog = BootstrapDialog.alert(data.message, function(){
						// window.history.back();
					// });
					// setInterval(function(){ $('#'+dialog.getButtons()[0].id).focus(); },100);
				},
				error: function(data) {
					if (data.status >= 500){
						var message = data.statusText;
					} else {
						var error = JSON.parse(data.responseText);
						var message = error.message;
					}
					form.find("[type='submit']").prop( "disabled", false );
					BootstrapDialog.show({ message:message, closable: false, type:'modal-danger', title:'Notification', 
						buttons: [{ label: 'OK', hotkey: 13, 
							action: function(dialogRef) {
								dialogRef.close();
							} 
						}],
					});
					// BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});

			return false;
		});
	});
	
});
