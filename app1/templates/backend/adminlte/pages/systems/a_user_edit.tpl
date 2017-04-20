<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $title	= "{$title}", auto_populate = false;
	{* Get Params *}
	var id = getURLParameter("id"), act = getURLParameter("action");
	var act_name = (act == 'new') ? "(New)" : (act == 'edt') ? "(Edit)" : (act == 'cpy') ? "(Copy)" : act;
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	var req = (act == 'new') ? true : (act == 'edt') ? false : true;
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Input({ type:"hidden", idname:"photo_file" }));
	col.push( $('<div style="text-align:center;width:100%;" />')
		.append( $('<img class="profile-user-img img-responsive img-circle" style="width:150px; margin-bottom:13px;" alt="User Picture" />') )
		.append( BSHelper.Button({ type:"button", label:"Upload Photo", idname:"btn_uploadphoto" }) ) 
		.append( '&nbsp;&nbsp;&nbsp;' ) 
		.append( BSHelper.Button({ type:"button", label:"Generate Image", idname:"btn_generatephoto", 
			onclick:"$.ajax({ 
				url:$url_module,
				data: JSON.stringify({ genphoto:1, id:$('#id').val(), name:$('#name').val(), photo_file:$('#photo_file').val() }),
				method:'PUT', async: true, dataType:'json', 
				success: function(data){	
					if (data.status) { 
						$('img.profile-user-img').attr('src', data.file_url);
						$('#photo_file').val(data.photo_file);
					}
				}
			});" 
		}) ) 
	);
	col.push(BSHelper.Input({ horz:false, type:"text", label:"User Name", idname:"name", required: true, placeholder:"string(60)", }));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password", required: req, placeholder:"Password", minlength:6, help:"Minimum of 6 characters" })));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_confirm", required: req, placeholder:"Confirm", idmatch:"password", errormatch:"Whoops, these don't match" })));
	col.push(BSHelper.Label({ horz:false, label:"Password", idname:"password", required: req, elcustom:subRow(a) }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	row.push(subCol(6, col));
	col = [];
	col.push(BSHelper.Input({ horz:false, type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Full BP Access", idname:"is_fullbpaccess" }));
	col.push(BSHelper.Combobox({ horz:false, label:"Role (Default)", idname:"user_role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}?filter=user_id="+id, remote: true }) );
	col.push(BSHelper.Combobox({ horz:false, label:"Organization (Default)", idname:"user_org_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_org')}?filter=user_id="+id, remote: true }) );
	col.push(BSHelper.Combobox({ horz:false, label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", remote: true }));
	row.push(subCol(6, col));
	form1.append(subRow(row));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	{* Begin: Populate data to form *}
	$("img.profile-user-img").css("display", "none");
	$.getJSON($url_module, { "id": (id==null)?-1:id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var filename = result.data.rows[0]['photo_file'];
			if (filename) {
				$("img.profile-user-img").css("display", "");
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			}
			form1.shollu_autofill('load', result.data.rows[0]);  
		}
	});
	
	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5",
		filters: { max_file_size: "{$.session.max_file_upload}", mime_types: [{ title:"Image files", extensions:"jpg,gif,png" }] },
		browse_button: "btn_uploadphoto", 
		multi_selection: false,
		multipart_params: { "userphoto":1, "id":id, "photo_file":$('#photo_file').val() },
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
				document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
			}
		}
	});
	uploader.bind('BeforeUpload', function(uploader, file) {
		uploader.settings.multipart_params = { "userphoto":1, "id":id, "photo_file":$('#photo_file').val() };
	});
	uploader.init();

</script>