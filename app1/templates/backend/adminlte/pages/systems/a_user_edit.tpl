{var $url_module = $.php.base_url('systems/a_user')}

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
	col.push( $('<div style="text-align:center;width:100%;"><span class="glyphicon glyphicon-camera"></span><img class="profile-user-img img-responsive img-circle" style="width:200px" alt="User Picture"></div>'));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"User Name", idname:"name", required: true, placeholder:"string(60)", }));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password", required: req(edit), placeholder:"Password", minlength:6, help:"Minimum of 6 characters" })));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_confirm", required: req(edit), placeholder:"Confirm", idmatch:"password", errormatch:"Whoops, these don't match" })));
	col.push(BSHelper.Label({ horz:false, label:"Password", idname:"password", required: req(edit), elcustom:subRow(a) }));
	row.push(subCol(6, col));
	
	col = [];
	col.push(BSHelper.Input({ horz:false, type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Full BP Access", idname:"is_fullbpaccess" }));
	col.push(BSHelper.Combogrid({ horz:false, label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", isLoad:true, placeholder:"typed or choose" }));
	row.push(subCol(6, col));
	boxContent.find(".box-body").append(subRow(row));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	boxContent.find(".box-footer").append( a );
	$(".content").append(formContent);

	{* Begin: Populate data to form *}
	$.getJSON('{$url_module}', { "id": (id==null)?-1:id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var filename = result.data.rows[0]['photo_file'];
			console.log("{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+filename);
			formContent.xform('load', result.data.rows[0]);  
		}
	});
	
	{* Init data for combogrid *}

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