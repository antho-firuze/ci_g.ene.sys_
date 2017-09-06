/*!
 * form_edit.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A functions for build Form to Add/Edit/Copy Data
 */
/* Get Params */
var $id = getURLParameter("id"), $act = getURLParameter("action"), $filter = getURLParameter("filter");
var $data;
/* 
/* ========================================= */
/* Default init for Header									 */
/* ========================================= */
// $( document ).ready(function() {
	/* Start :: Init for Title, Breadcrumb */
	$(document).prop('title', $HEAD_TITLE+' > '+$bread[$bread.length-1].title);
	$bread.unshift({ icon:"fa fa-dashboard", title:"Dashboard", link: "window.location.href = '"+$APPS_LNK+"'" });
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	
// });
/* ==================================== */
/* Default action for Form Edit */
/* ==================================== */
$( document ).ready(function() {
	
	/* This class is for auto conversion from dmy to ymd */
	$(".auto_ymd").on('change', function(){
		$('input[name="'+$(this).attr('id')+'"]').val( datetime_db_format($(this).val(), $(this).attr('data-format')) );
	});
	
	/* Begin: Populate data to form */
	if(typeof(auto_populate)==='undefined') auto_populate = true;
	if (auto_populate){
		$.getJSON($url_module, { "id": ($id==null)?-1:$id }, function(result){ 
			$data = result.data.rows[0];
			if (!isempty_obj(result.data.rows)) 
				$('form').shollu_autofill('load', result.data.rows[0]);  
				$('form').validator('update');
				
				/* Trigger auto conversion */
				$(".auto_ymd").trigger('change');
		});
	}
	
	/* For summernote editor */
	if (jQuery().summernote) {
		var strVal = $('.summernote').val();
		$('.summernote')
			.summernote({ height: 300, minHeight: null, maxHeight: null })
			.summernote('code', strVal);
	}
	
	/* For tinymce editor */
	if (typeof(tinyMCE) !== 'undefined') {
		tinymce.init({ 
			selector:'.tinymce', 
			height: '500px', 
			content_css: [
					$TEMPLATE_URL+'bootstrap/css/bootstrap.min.css',
					$TEMPLATE_URL+'dist/css/skins/'+get($skin)+'.min.css',
					$TEMPLATE_URL+'font-awesome/css/font-awesome.min.css'
			],
			remove_trailing_brs: false,
			convert_urls : false,
			extended_valid_elements : "*[*],script[charset|defer|language|src|type]",
			valid_elements: "*[*],script[charset|defer|language|src|type]",
			plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code codesample fullscreen insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor glyphicons b_button jumbotron row_cols boots_panels boot_alert form_insert fontawesome",
			toolbar1: "insertfile undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage codesample",
			toolbar2: "forecolor backcolor emoticons glyphicons fontawesome | b_button jumbotron row_cols boots_panels boot_alert form_insert",
			image_advtab: true,
			image_class_list: [
					{ title: 'None', value: ''},
					{ title: 'Responsive', value: 'img-responsive'},
					{ title: 'Rounded & Responsive', value: 'img-responsive img-rounded'},
					{ title: 'Circle & Responsive', value: 'img-responsive img-circle'},
					{ title: 'Thumbnail & Responsive', value: 'img-responsive img-thumbnail'}
			],
			style_formats: [
					{ title: 'Text', items: [
							{ title: 'Muted text', inline: 'span', classes: 'text-muted'},
							{ title: 'Primary text', inline: 'span', classes: 'text-primary'},
							{ title: 'Success text', inline: 'span', classes: 'text-success'},
							{ title: 'Info text', inline: 'span', classes: 'text-info'},
							{ title: 'Warning text', inline: 'span', classes: 'text-warning'},
							{ title: 'Danger text', inline: 'span', classes: 'text-danger'},
							{ title: 'Badges', inline: 'span', classes: 'badge'}
					] },
					{ title: 'Label', items: [
							{ title: 'Default Label', inline: 'span', classes: 'label label-default'},
							{ title: 'Primary Label', inline: 'span', classes: 'label label-primary'},
							{ title: 'Success Label', inline: 'span', classes: 'label label-success'},
							{ title: 'Info Label', inline: 'span', classes: 'label label-info'},
							{ title: 'Warning Label', inline: 'span', classes: 'label label-warning'},
							{ title: 'Danger Label', inline: 'span', classes: 'label label-danger'}
					] },
					{ title: 'Headers', items: [
							{ title: 'h1', block: 'h1' },
							{ title: 'h2', block: 'h2' },
							{ title: 'h3', block: 'h3' },
							{ title: 'h4', block: 'h4' },
							{ title: 'h5', block: 'h5' },
							{ title: 'h6', block: 'h6' }
					] },
					{ title: 'Blocks', items: [
							{ title: 'p', block: 'p' },
							{ title: 'div', block: 'div' },
							{ title: 'pre', block: 'pre' }
					] },
					{ title: 'Containers', items: [
							{ title: 'section', block: 'section', wrapper: true, merge_siblings: false },
							{ title: 'article', block: 'article', wrapper: true, merge_siblings: false },
							{ title: 'blockquote', block: 'blockquote', wrapper: true },
							{ title: 'hgroup', block: 'hgroup', wrapper: true },
							{ title: 'aside', block: 'aside', wrapper: true },
							{ title: 'figure', block: 'figure', wrapper: true }
					] }
			]
		});
	}
	
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
			var r_method = $.inArray($act, ['new','cpy']) > -1 ? 'POST' : $.inArray($act, ['edt']) > -1 ? 'PUT' : 'OPTIONS';
			
			/* adding primary key id on the fly */
			form.append(BSHelper.Input({ type:"hidden", idname:"id", value:$id }));
			
			/* adding foreign key id on the fly */
			if ($filter){
				$.each($filter.split(','), function(i, val){
					var fil = val.split('=');
					form.append(BSHelper.Input({ type:"hidden", idname:fil[0], value:fil[1] }));
				});
			}
			// console.log(form.serializeJSON()); return false;
			
			form.find("[type='submit']").prop( "disabled", true );
			
			$.ajax({ url: $url_module, method: r_method, async: true, dataType:'json',
				data: form.serializeJSON(),
				success: function(data) {
					
					BootstrapDialog.show({ message:data.message, closable: false,
						buttons: [{ label: 'OK', hotkey: 13, 
							action: function(dialogRef) {
								window.history.back();
							} 
						}],
					});
					// var dialog = BootstrapDialog.alert(data.message, function(){
						// window.history.back();
					// });
					// setInterval(function(){ $('#'+dialog.getButtons()[0].id).focus(); },100);
				},
				error: function(data) {
					if (data.status==500){
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


