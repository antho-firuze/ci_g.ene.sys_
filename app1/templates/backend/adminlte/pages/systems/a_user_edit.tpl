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

      <!-- Default box -->
      <div class="box">
				<div class="box-body"></div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
	var a = [];
	var col = subCol(12,"");
	var id = getURLParameter("id");
	{* var edit = getURLParameter("edit")==1 ? true : false; *}
	var edit = getURLParameter("edit");
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	
	{* Set status to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	$('.content-header').find('h1').find('small').html(desc(edit));
	
	{* For design form interface *}
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	col.append(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.append(BSHelper.Input({ horz:false, type:"text", label:"User Name", idname:"name", required: true, placeholder:"string(60)", }));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password", required: req(edit), placeholder:"Password", minlength:6, help:"Minimum of 6 characters" })));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_confirm", required: req(edit), placeholder:"Confirm", idmatch:"password", errormatch:"Whoops, these don't match" })));
	col.append(BSHelper.Label({ horz:false, label:"Password", idname:"password", required: req(edit), elcustom:subRow(a) }));
	col.append(BSHelper.Input({ horz:false, type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
	col.append(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	col.append(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.append(BSHelper.Checkbox({ horz:false, label:"Is Full BP Access", idname:"is_fullbpaccess" }));
	col.append(BSHelper.Combogrid({ horz:false, label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", isLoad:false, placeholder:"typed or choose" }));
	formContent.append(subRow(col));
	formContent.append(subRow(subCol()));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel" }) );
	formContent.append( a );
	$('div.box-body').append(formContent);

	{* Begin: Populate data to form *}
	$.getJSON('{$url_module}', { "id": (id==null)?-1:id }, function(result){ 
		if (!isempty_obj(result.data.rows)) 
			formContent.xform('load', result.data.rows[0]);  
	});
	{* End: Populate data to form *}
	
	{* Default action for button cancel *}
	$("#btn_cancel").click(function(){ window.history.back();	});
	
	{* Init data for combogrid *}
	$("#supervisor_id").combogrid({ 
		source: function(term, response){
			$.getJSON($("#supervisor_id").data('url'), term, function(data){ response(data.data); });
		}
	});

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