{var $url_module = $.php.base_url('systems/a_user')}
{var $url_upload = $.php.base_url('systems/x_upload')}

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {$window_title}
        <small>{$description}</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/form-autofill/js/form-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
	var a = [];	var col = [];	var row = [];
	var id = getURLParameter("id");
	var edit = getURLParameter("edit");
	var formContent = $('<form "autocomplete"="off"></form>');
	var boxContent = $('<div class="box"><div class="box-header"></div><div class="box-body"></div><div class="box-footer"></div></div>');
	formContent.append(boxContent);
	
	{* Set status to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	$('.content-header').find('h1').find('small').html(desc(edit));
	
	{* For design form interface *}
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Input({ type:"hidden", idname:"photo_file" }));
	col.push( $('<div style="text-align:center;width:100%;" />')
		.append( $('<img class="profile-user-img img-responsive img-circle" style="width:150px; margin-bottom:13px;" alt="User Picture" />') )
		.append( BSHelper.Button({ type:"button", label:"Upload Photo", idname:"btn_uploadphoto" }) ) 
		.append( '&nbsp;&nbsp;&nbsp;' ) 
		.append( BSHelper.Button({ type:"button", label:"Generate Image", idname:"btn_generatephoto", 
			onclick:"$.getJSON('{$url_module}?genphoto=1&id='+$('#id').val()+'&name='+$('#name').val()+'&photo_file='+$('#photo_file').val(), '', function(data){	
				if (data.status) { 
					$('img.profile-user-img').attr('src', data.file_url);
					$('#photo_file').val(data.photo_file);
				}
			});" 
		}) ) 
	);
	col.push(BSHelper.Input({ horz:false, type:"text", label:"User Name", idname:"name", required: true, placeholder:"string(60)", }));
	a = [];
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password", required: req(edit), placeholder:"Password", minlength:6, help:"Minimum of 6 characters" })));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_confirm", required: req(edit), placeholder:"Confirm", idmatch:"password", errormatch:"Whoops, these don't match" })));
	col.push(BSHelper.Label({ horz:false, label:"Password", idname:"password", required: req(edit), elcustom:subRow(a) }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	row.push(subCol(6, col));
	
	col = [];
	col.push(BSHelper.Input({ horz:false, type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Full BP Access", idname:"is_fullbpaccess" }));
	col.push(BSHelper.Combogrid({ horz:false, label:"Role (Default)", idname:"user_role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}?filter=user_id="+id, isLoad:true }) );
	col.push(BSHelper.Combogrid({ horz:false, label:"Organization (Default)", idname:"user_org_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_org')}?filter=user_id="+id, isLoad:true }) );
	col.push(BSHelper.Combogrid({ horz:false, label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", isLoad:true }));
	row.push(subCol(6, col));
	boxContent.find(".box-body").append(subRow(row));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	boxContent.find(".box-footer").append( a );
	$(".content").append(formContent);

	{* Begin: Populate data to form *}
	$("img.profile-user-img").css("display", "none");
	$.getJSON('{$url_module}', { "id": (id==null)?-1:id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var filename = result.data.rows[0]['photo_file'];
			if (filename) {
				$("img.profile-user-img").css("display", "");
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			}
			formContent.xform('load', result.data.rows[0]);  
		}
	});
	
	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url:"{$url_upload}?userphoto=1&id="+id+"&photo_file="+$('#photo_file').val(), runtimes:"html5",
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
				document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
			}
		}
	});
	uploader.bind('BeforeUpload', function(uploader, file) {
		uploader.settings.url = "{$url_upload}?userphoto=1&id="+id+"&photo_file="+$('#photo_file').val();
	});
	uploader.init();

	
	{* Form submit action *}
	formContent.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: '{$url_module ~ "?id="}'+id, method:(edit==1?"PUT":"POST"), async: true, dataType:'json',
			data: formContent.serializeJSON(),
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert('Saving data successfully !', function(){
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
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});

		return false;
	});
</script>