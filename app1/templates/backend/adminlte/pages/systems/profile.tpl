{var $url_module = $.php.base_url('systems/x_profile')}
{var $url_module_a_user = $.php.base_url('systems/a_user')}
{var $url_upload = $.php.base_url('systems/x_upload')}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
        <small>From this page, you can customize your settings. </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{$.const.APPS_LNK}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
	var a=[];	var col = [];
	var formContent = $('<form "autocomplete"="off" />');
	var boxContent = $('<div class="box"><div class="box-header"></div><div class="box-body"></div><div class="box-footer"></div></div>');
	var tabContent = BSHelper.Tabs({
		dataList: [
			{	title:"General Setup", idname:"tab-gen", content:function(){
				a.push(BSHelper.Input({ type:"hidden", idname:"id" }));
				a.push(BSHelper.Input({ type:"hidden", idname:"photo_file" }));
				
				a.push(BSHelper.Input({ type:"text", label:"Code", idname:"code" }));
				a.push(BSHelper.Input({ type:"text", label:"Name", idname:"name", required: true }));
				a.push(BSHelper.Input({ type:"textarea", label:"Description", idname:"description" }));
				a.push(BSHelper.Input({ type:"text", label:"Email", idname:"email", required: true }));
				col.push(subCol(6, a)); a=[];
				a.push( subRow(subCol(12, BSHelper.Button({ type:"submit", label:"Save", cls:"btn-primary" }) )) );
				col.push(subCol(12, a));
				return subRow(col);
			} },
			{	title:"Configuration", idname:"tab-dat", content:function(){
				a = []; col = [];
				{* a.push(BSHelper.Input({ type:"text", label:"Date Format", idname:"date_format", required: true, placeholder:"d/m/Y" })); *}
				{* a.push(BSHelper.Input({ type:"text", label:"Time Format", idname:"time_format", required: true, placeholder:"h:i:s" })); *}
				{* a.push(BSHelper.Input({ type:"text", label:"DateTime Format", idname:"datetime_format", required: true, placeholder:"d/m/Y h:i:s" })); *}
				{* a.push(BSHelper.Input({ type:"text", label:"User Photo Path", idname:"user_photo_path", required: true, placeholder:"string(200)" })); *}
				{* col.push(subCol(6, a)); *}
				return subRow(col);
			} },
		],
	});
	a = [];
	a.push( $('<div style="text-align:center;width:100%;" />')
		.append( $('<img class="profile-user-img img-responsive img-circle" style="width:150px; margin-bottom:13px;" alt="User Picture" />') )
		.append( BSHelper.Button({ type:"button", label:"Upload Photo", idname:"btn_uploadphoto" }) ) 
		.append( '&nbsp;&nbsp;&nbsp;' ) 
		.append( $('<h3 class="profile-username text-center">{$.session.user_name}</h3>') ) 
		.append( $('<p class="text-muted text-center">{$.session.user_description}</p>') ) 
	);
	a.push( $('<ul class="list-group list-group-unbordered" />')
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Role (Default)", idname:"user_role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}?filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
		.append( $('<li class="list-group-item" />')
			.append( BSHelper.Combobox({ horz:false, label:"Organization (Default)", idname:"user_org_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_org')}?filter=user_id="+{$.session.user_id}, remote: true, required:true }) ) )
  );
	a.push( BSHelper.Button({ type:"button", label:"Reload", idname:"btn_reload",
		onclick:"var last_url = window.location.href;
			$.getJSON('{$.const.RELOAD_LNK}', '', function(data){ window.location.replace(last_url); });" 
	}) ); 
	boxContent.find('.box-body').append(subRow(subCol(12, a)));
	
	col = [];
	col.push(subCol(3, boxContent));
	{* Button *}
	a = [];
	a.push( tabContent );
	col.push(subCol(9, a));
	
	
	formContent.append(subRow(col));
	$(".content").append(formContent);
	
	{* Begin: Populate data to form *}
	$.getJSON("{$url_module}?view=1", '', function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var filename = result.data.rows[0]['photo_file'];
			if (filename) {
				$("img.profile-user-img").css("display", "");
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			}
			formContent.shollu_autofill('load', result.data.rows[0]);  
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
	
	
	{* Form submit action *}
	formContent.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: '{$url_module}', method:"PUT", async: true, dataType:'json',
			data: formContent.serializeJSON(),
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