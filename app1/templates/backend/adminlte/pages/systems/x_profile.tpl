<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
	var $url_module = "{$.php.base_url('systems/x_profile')}";
	{* Start :: Init for Title, Breadcrumb & Content Body *}
	$(".content-wrapper").append(BSHelper.PageHeader({ 
		title:"User Profile", 
		title_desc:"From this page, you can customize your settings.", 
		bc_list:[
			{ icon:"fa fa-dashboard", title:" Home", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:" User profile", link:"" },
		]
	}));
	$(".content-wrapper").append( $('<section class="content" />') );
	{* End :: Init for Title, Breadcrumb & Content Body *}
	
	{* For design form interface *}
	var col = [], row = [];	
	var form1 = BSHelper.Form({ autocomplete:"off", idname:"form1" });	
	var form2 = BSHelper.Form({ autocomplete:"off", idname:"form2" });	
	var form3 = BSHelper.Form({ autocomplete:"off", idname:"form3" });	
	var box1 = BSHelper.Box({ type:"info" });

	col.push( $('<div style="text-align:center;width:100%;" />')
		.append( $('<img id="btn_uploadphoto" class="profile-user-img img-responsive img-circle" style="width:150px; margin-bottom:13px; cursor:pointer; cursor:hand;" title="Upload Photo" alt="User Picture" />') )
		{* .append( BSHelper.Button({ type:"button", label:"Upload Photo", idname:"btn_uploadphoto" }) )  *}
		{* .append( '&nbsp;&nbsp;&nbsp;' )  *}
		.append( $('<h3 class="profile-username text-center">{$.session.user_name}</h3>') ) 
		.append( $('<p class="text-muted text-center">{$.session.user_description}</p>') ) 
	);
	col.push( $('<ul class="list-group list-group-unbordered" />')
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Role (Default)", idname:"user_role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}?filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Organization (Default)", idname:"user_org_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_org')}?level=1&filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Location (Default)", idname:"user_orgtrx_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_orgtrx')}?level=1&filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
  );
	col.push( BSHelper.Button({ type:"submit", label:"Save & Reload", idname:"btn_reload" }) );
	{* col.push( BSHelper.Button({ type:"submit", label:"Save & Reload", idname:"btn_reload",
		onclick:"var last_url = window.location.href;
			$.getJSON('{$.const.RELOAD_LNK}', '', function(data){ window.location.replace(last_url); });" 
	}) );  *}
	form1.append(subRow(subCol(12, col)));
	box1.find('.box-body').append(form1);

	var tab1 = BSHelper.Tabs({
		dataList: [
			{	title:"General Setup", idname:"tab-gen", 
				content:function(){
					col = [];
					col.push(BSHelper.Input({ type:"hidden", idname:"photo_file" }));
					col.push(BSHelper.Input({ type:"text", label:"Code", idname:"code" }));
					col.push(BSHelper.Input({ type:"text", label:"Name", idname:"name", required: true }));
					col.push(BSHelper.Input({ type:"textarea", label:"Description", idname:"description" }));
					col.push(BSHelper.Input({ type:"text", label:"Email", idname:"email", required: true }));
					form2.append(subRow(subCol(6, col)));
					form2.append(subRow(subCol(12, BSHelper.Button({ type:"submit", label:"Save", cls:"btn-primary" }) )) );
					return form2;
				} 
			},
			{	title:"Configuration", idname:"tab-dat", 
				content:function(){
					col = []; 
					col.push(BSHelper.Combobox({ label:"Layout", idname:"layout", required: false, 
						list:[
							{ id:"layout-boxed", name:"Boxed" },
							{ id:"layout-fixed", name:"Fixed" },
							{ id:"sidebar-collapse", name:"Sidebar Collapse" },
						]
					}));
					col.push(BSHelper.Combobox({ label:"Skin Color", idname:"skin", required: false, 
						list:[
							{ id:"skin-blue", name:"Blue" },
							{ id:"skin-black", name:"Black" },
							{ id:"skin-red", name:"Red" },
							{ id:"skin-yellow", name:"Yellow" },
							{ id:"skin-purple", name:"Purple" },
							{ id:"skin-green", name:"Green" },
							{ id:"skin-blue-light", name:"Blue Light" },
							{ id:"skin-black-light", name:"Black Light" },
							{ id:"skin-red-light", name:"Red Light" },
							{ id:"skin-yellow-light", name:"Yellow Light" },
							{ id:"skin-purple-light", name:"Purple Light" },
							{ id:"skin-green-light", name:"Green Light" },
						] 
					}));
					col.push(BSHelper.Combobox({ label:"Screen Timeout", idname:"screen_timeout", required: false, 
						list:[
							{ id:"60000", name:"1 minute" },
							{ id:"120000", name:"2 minutes" },
							{ id:"180000", name:"3 minutes" },
							{ id:"300000", name:"5 minutes" },
							{ id:"600000", name:"10 minutes" },
							{ id:"900000", name:"15 minutes" },
							{ id:"1200000", name:"20 minutes" },
							{ id:"1500000", name:"25 minutes" },
							{ id:"1800000", name:"30 minutes" },
							{ id:"2700000", name:"45 minutes" },
							{ id:"3600000", name:"1 hour" },
							{ id:"7200000", name:"2 hours" },
							{ id:"10800000", name:"3 hours" },
							{ id:"14400000", name:"4 hours" },
							{ id:"18000000", name:"5 hours" },
						] 
					}));
					col.push(BSHelper.Combobox({ label:"Language", idname:"language", required: false, 
						list:[
							{ id:"english", name:"English" },
							{* { id:"indonesia", name:"Indonesia" }, *}
						] 
					}));
					col.push(BSHelper.Combobox({ label:"Show Branch Entry", idname:"show_branch_entry", required: false, 
						list:[
							{ id:"0", name:"No" },
							{ id:"1", name:"Yes" },
						] 
					}));
					form3.append(subRow(subCol(6, col)));
					form3.append(subRow(subCol(12, BSHelper.Button({ type:"submit", label:"Save", idname:"btn_saveconfig" }) ))); 
					return form3;
				} 
			},
		],
	});
	
	col = [];
	col.push(subCol(3, box1));
	col.push(subCol(9, tab1));
	$(".content").append(subRow(col));
	
	{* Begin: Populate data to form *}
	$.getJSON($url_module+"?view=1", '', function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var filename = result.data.rows[0]['photo_file'];
			if (filename) {
				$("img.profile-user-img").css("display", "");
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			}
			form1.shollu_autofill('load', result.data.rows[0]);  
			form2.shollu_autofill('load', result.data.rows[0]);  
			
			$("#user_orgtrx_id").shollu_cb({ queryParams: { "filter": "user_id="+{$.session.user_id}+",user_org_id="+result.data.rows[0].user_org_id }});
			
			form1.validator('update');
			form2.validator('update');
		}
	});
	$.getJSON("{$.php.base_url('systems/a_user_config')}", '', function(result){ 
		if (!isempty_obj(result.data)) {
			form3.shollu_autofill('load', result.data);  
			form3.validator('update');
		}
	});
	{* End: Populate data to form *}
	
	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5",
		filters: { max_file_size: "2mb", mime_types: [{ title:"Image files", extensions:"jpg,gif,png" }] },
		browse_button: "btn_uploadphoto", 
		multi_selection: false, 
		multipart_params: { "userphoto":1, "id":{$.session.user_id}, "photo_file":$('#photo_file').val() },
		init: {
			FilesAdded: function(up, files) {
				uploader.start();
			},
			FileUploaded: function(up, file, info) {
				var response = $.parseJSON(info.response);
				console.log(response.file_url);
				if (response.status) { 
					$('img.profile-user-img').attr('src', response.file_url);
					$('#photo_file').val(response.photo_file);
				}
			},
			Error: function(up, err) {
				{* document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message)); *}
			}
		}
	});
	uploader.bind('BeforeUpload', function(uploader, file) {
		uploader.settings.multipart_params = { "userphoto":1, "id":{$.session.user_id}, "photo_file":$('#photo_file').val() };
	});
	uploader.init();

	{* Event on Element *}
	$("#user_org_id").shollu_cb({ 
		onSelect: function(rowData){ 
			$("#user_orgtrx_id").shollu_cb('setValue', '');
			$("#user_orgtrx_id").shollu_cb({ queryParams: { "level":1, "filter": "user_id="+ {$.session.user_id} +",user_org_id="+rowData.id } });
		}
	});
	
	{* Form submit action *}
	$(document.body).find('form').each(function(e){
		if ($.inArray($(this).attr('id'), ["form1","form2","form3"]) != -1){
			
			$(this).validator().on('submit', function (e) {
				{* e.stopPropagation; *}
				if (e.isDefaultPrevented()) { return false;	} 
				
				{* $(this).find("[type='submit']").prop( "disabled", true ); *}
				
				if ($(this).attr('id') == 'form1'){
					$(this).append( BSHelper.Input({ type:"hidden", idname:"change_user_role", value:1 }) );
				} else if ($(this).attr('id') == 'form2'){
					$(this).append( BSHelper.Input({ type:"hidden", idname:"update_user_profile", value:1 }) );
				} else if ($(this).attr('id') == 'form3'){
					$(this).append( BSHelper.Input({ type:"hidden", idname:"update_user_config", value:1 }) );
				}
				
				$.ajax({ url: $url_module, method:"PUT", async: true, dataType:'json',
					data: $(this).serializeJSON(),
					success: function(data) {
						{* if ($(this).attr('id') == 'form1'){ *}
							{* $.getJSON('{$.const.RELOAD_LNK}', '', function(data){ window.location.replace(window.location.href); }); *}
							{* return false; *}
						{* } *}
					
						BootstrapDialog.show({ message:data.message, closable: false,
							buttons: [{ label: 'OK', hotkey: 13, 
								action: function(dialogRef) {
									$.getJSON('{$.const.RELOAD_LNK}', '', function(data){ 
										{* window.location.replace(window.location.href);  *}
										window.history.back();
									});
								} 
							}],
						});
						{* $(this).find("[type='submit']").prop( "disabled", false ); *}
						{* BootstrapDialog.alert(data.message); *}
						{* form2.validator('update'); *}
						{* form3.validator('update'); *}
					},
					error: function(data) {
						if (data.status==500){
							var message = data.statusText;
						} else {
							var error = JSON.parse(data.responseText);
							var message = error.message;
						}
						{* $(this).find("[type='submit']").prop( "disabled", false ); *}
						BootstrapDialog.show({ message:message, closable: false, type:'modal-danger', title:'Notification', 
							buttons: [{ label: 'OK', hotkey: 13, 
								action: function(dialogRef) {
									dialogRef.close();
								} 
							}],
						});
						{* BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message }); *}
					}
				});

				return false;
			});
			
		}
		
	});
</script>