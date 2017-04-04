{var $url_module = $.php.base_url('systems/x_profile')}
{var $url_module_a_user = $.php.base_url('systems/a_user')}
{var $url_upload = $.php.base_url('systems/x_upload')}
{var $url_module_a_user_config = $.php.base_url('systems/a_user_config')}
{var $url_config = $.php.base_url('systems/x_config')}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  </div>
  <!-- /.content-wrapper -->

<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
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
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var form2 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	var tab1 = BSHelper.Tabs({
		dataList: [
			{	title:"General Setup", idname:"tab-gen", content:function(){
				col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
				col.push(BSHelper.Input({ type:"hidden", idname:"photo_file" }));
				
				col.push(BSHelper.Input({ type:"text", label:"Code", idname:"code" }));
				col.push(BSHelper.Input({ type:"text", label:"Name", idname:"name", required: true }));
				col.push(BSHelper.Input({ type:"textarea", label:"Description", idname:"description" }));
				col.push(BSHelper.Input({ type:"text", label:"Email", idname:"email", required: true }));
				row.push(subCol(6, col)); col = [];
				col.push( subRow(subCol(12, BSHelper.Button({ type:"submit", label:"Save", cls:"btn-primary" }) )) );
				row.push(subCol(12, col));
				return subRow(row);
			} },
			{	title:"Configuration", idname:"tab-dat", content:function(){
				col = []; 
				col.push(BSHelper.Combobox({ label:"Layout", idname:"layout", 
					list:[
						{ id:"layout-boxed", name:"Boxed" },
						{ id:"layout-fixed", name:"Fixed" },
						{ id:"sidebar-collapse", name:"Sidebar Collapse" },
					]
				}));
				col.push(BSHelper.Combobox({ label:"Skin Color", idname:"skin", 
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
				col.push(BSHelper.Combobox({ label:"Screen Timeout", idname:"screen_timeout", 
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
				col.push(BSHelper.Combobox({ label:"Language", idname:"language", 
					list:[
						{ id:"english", name:"English" },
						{ id:"indonesia", name:"Indonesia" },
					] 
				}));
				form2.append(col);
				return subRow(subCol(6, form2));
			} },
		],
	});
	col = [];
	col.push( $('<div style="text-align:center;width:100%;" />')
		.append( $('<img class="profile-user-img img-responsive img-circle" style="width:150px; margin-bottom:13px;" alt="User Picture" />') )
		.append( BSHelper.Button({ type:"button", label:"Upload Photo", idname:"btn_uploadphoto" }) ) 
		.append( '&nbsp;&nbsp;&nbsp;' ) 
		.append( $('<h3 class="profile-username text-center">{$.session.user_name}</h3>') ) 
		.append( $('<p class="text-muted text-center">{$.session.user_description}</p>') ) 
	);
	col.push( $('<ul class="list-group list-group-unbordered" />')
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Role (Default)", idname:"user_role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}?filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Organization (Default)", idname:"user_org_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_org')}?filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
  );
	col.push( BSHelper.Button({ type:"button", label:"Reload", idname:"btn_reload",
		onclick:"var last_url = window.location.href;
			$.getJSON('{$.const.RELOAD_LNK}', '', function(data){ window.location.replace(last_url); });" 
	}) ); 
	box1.find('.box-body').append(subRow(subCol(12, col)));
	
	col = [];
	col.push(subCol(3, box1));
	col.push(subCol(9, tab1));
	form1.append(subRow(col));
	$(".content").append(form1);
	
	{* Begin: Populate data to form *}
	$.getJSON("{$url_module}?view=1", '', function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var filename = result.data.rows[0]['photo_file'];
			if (filename) {
				$("img.profile-user-img").css("display", "");
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			}
			form1.shollu_autofill('load', result.data.rows[0]);  
		}
	});
	$.getJSON("{$url_module_a_user_config}", '', function(result){ 
		if (!isempty_obj(result.data)) {
			form2.shollu_autofill('load', result.data);  
		}
	});
	{* End: Populate data to form *}
	
	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url:"{$url_module}?userphoto=1&id="+{$.session.user_id}+"&photo_file="+$('#photo_file').val(), runtimes:"html5",
		filters: { max_file_size: "2mb", mime_types: [{ title:"Image files", extensions:"jpg,gif,png" }] },
		browse_button: "btn_uploadphoto", 
		multi_selection: false, 
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
		uploader.settings.url = "{$url_upload}?userphoto=1&id="+{$.session.user_id}+"&photo_file="+$('#photo_file').val();
	});
	uploader.init();

	{* Event on Element *}
	$("#user_role_id").shollu_cb({ onSelect: function(rowData){ $.ajax({ url:"{$url_module}?user_role_id="+rowData.id, method:"PUT" });	} });
	$("#user_org_id").shollu_cb({ onSelect: function(rowData){ $.ajax({ url:"{$url_module}?user_org_id="+rowData.id, method:"PUT" });	} });
	$.each(form2.find('input'), function(){
		if ($(this).attr('id')){
			var id = $(this).attr('id');
			$(this).shollu_cb({ 
				onSelect: function(rowData){ 
					if (rowData.id){
						var data = JSON.stringify($("[name='"+id+"']").serializeArray());
						$.ajax({ url:"{$url_config}", method:"PUT", data:data });	
					}
				}
			});
		}
	});
	
	{* Form submit action *}
	form1.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: '{$url_module}', method:"PUT", async: true, dataType:'json',
			data: form1.serializeJSON(),
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert('Saving data successfully !', function(){
					{* window.history.back(); *}
        });
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});

		return false;
	});
</script>