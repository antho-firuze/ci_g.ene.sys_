{var $url_module = $.php.base_url('systems/a_system')}

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
	var a=[];
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	var col_l = formContent.find('div.col-left');
	var col_r = formContent.find('div.col-right');
	
	col_l.append();
	col_l.append(BSHelper.Input({ type:"hidden", idname:"id" }));
	col_l.append(BSHelper.Input({ type:"text", label:"Name", idname:"name", required: true, placeholder:"string(60)" }));
	col_l.append(BSHelper.Input({ type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	col_l.append(BSHelper.Input({ type:"text", label:"Head Title", idname:"head_title", required: true, placeholder:"string(60)" }));
	col_l.append(BSHelper.Input({ type:"text", label:"Page Title", idname:"page_title", required: true, placeholder:"string(60)" }));
	col_l.append(BSHelper.Input({ type:"text", label:"Logo Text Mini", idname:"logo_text_mn", required: true, maxlength:3, placeholder:"string(3)" }));
	col_l.append(BSHelper.Input({ type:"text", label:"Logo Text Large", idname:"logo_text_lg", required: true, placeholder:"string(20)" }));
	
	col_r.append(BSHelper.Input({ type:"text", label:"Date Format", idname:"date_format", required: true, placeholder:"d/m/Y" }));
	col_r.append(BSHelper.Input({ type:"text", label:"Time Format", idname:"time_format", required: true, placeholder:"h:i:s" }));
	col_r.append(BSHelper.Input({ type:"text", label:"DateTime Format", idname:"datetime_format", required: true, placeholder:"d/m/Y h:i:s" }));
	col_r.append(BSHelper.Input({ type:"text", label:"User Photo Path", idname:"user_photo_path", required: true, placeholder:"string(200)" }));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Save", cls:"btn-primary" }) );
	formContent.append( a );
	$('div.box-body').append(formContent);
	
	{* Begin: Populate data to form *}
	$.getJSON('{$url_module}', '', function(result){ 
		if (!isempty_obj(result.data.rows)) 
			formContent.xform('load', result.data.rows[0]);  
	});
	{* End: Populate data to form *}
	
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