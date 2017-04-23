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
/* ========================================= */
/* Default init for Header									 */
/* ========================================= */
$( document ).ready(function() {
	/* Start :: Init for Title, Breadcrumb */
	$(".content").before(BSHelper.PageHeader({ 
		title: $title, 
		title_desc: act_name, 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link: $APPS_LNK },
			{ icon:"", title: $title, link:"javascript:history.back()" },
			{ icon:"", title: act_name, link:"" },
		]
	}));

});
/* ==================================== */
/* Default action for Form Edit */
/* ==================================== */
$( document ).ready(function() {
	
	/* Begin: Populate data to form */
	if(typeof(auto_populate)==='undefined') auto_populate = true;
	if (auto_populate){
		$.getJSON($url_module, { "id": (id==null)?-1:id }, function(result){ 
			if (!isempty_obj(result.data.rows)) 
				$('form').shollu_autofill('load', result.data.rows[0]);  
				$('form').validator('update');
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
			var r_method = (act == 'new') ? 'POST' : (act == 'cpy') ? 'POST' : 'PUT';
			
			form.find("[type='submit']").prop( "disabled", true );
			
			$.ajax({ url: $url_module, method: r_method, async: true, dataType:'json',
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
					form.find("[type='submit']").prop( "disabled", false );
					BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});

			return false;
		});
	});
});


