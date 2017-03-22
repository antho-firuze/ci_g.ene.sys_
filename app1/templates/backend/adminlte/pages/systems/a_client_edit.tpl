{var $url_module = $.php.base_url('systems/a_client')}

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
<script src="{$.const.TEMPLATE_URL}plugins/form-autofill/js/form-autofill.js"></script>
<script>
	var a = [];
	var col = subCol(12,"");
	var id = getURLParameter("id");
	var edit = getURLParameter("edit");
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	
	{* Set status to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	$('.content-header').find('h1').find('small').html(desc(edit));
	
	{* For design form interface *}
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	col.append(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.append(BSHelper.Input({ horz:false, type:"text", label:"Code", idname:"code", required: true, }));
	col.append(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true, }));
	col.append(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
	col.append(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.append(BSHelper.Input({ horz:false, type:"text", label:"SMTP Host", idname:"smtp_host", required: false, }));
	col.append(BSHelper.Input({ horz:false, type:"number", label:"SMTP Port", idname:"smtp_port", required: false, }));
	col.append(BSHelper.Checkbox({ horz:false, label:"Secure SMTP", idname:"is_securesmtp" }));
	formContent.append(subRow(col));
	formContent.append(subRow(subCol()));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	formContent.append( a );
	$('div.box-body').append(formContent);

	{* Begin: Populate data to form *}
	$.getJSON('{$url_module}', { "id": (id==null)?-1:id }, function(result){ 
		if (!isempty_obj(result.data.rows)) 
			formContent.xform('load', result.data.rows[0]);  
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