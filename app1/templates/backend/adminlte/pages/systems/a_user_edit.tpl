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
	var a=[];
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	var col_l = formContent.find('div.col-left');
	var col_r = formContent.find('div.col-right');
	
	col_l.append(BSHelper.FormInput({ type:"text", label:"User Name", idname:"name", required: true, placeholder:"string(60)" }));
	col_l.append(BSHelper.FormInput({ type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	col_l.append(BSHelper.FormInput({ type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
	col_l.append(BSHelper.FormCheckbox({ label:"Is Active", idname:"is_active" }));
	col_l.append(BSHelper.FormCheckbox({ label:"Is Full BP Access", idname:"is_fullbpaccess" }));
	col_l.append(BSHelper.FormCombobox({ label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", isCombogrid: true, placeholder:"typed or choose" }));
	a = [];
	a.push( BSHelper.FormButton({ type:"submit", label:"Submit", cls:"btn-primary" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.FormButton({ type:"button", label:"Cancel", cls:"btn-primary", idname:"btn_cancel" }) );
	formContent.append( a );
	$('div.box-body').append(formContent);
	
	{* console.log(getURLParameter('id')); *}
	$.getJSON('{$url_module}', { "id":getURLParameter('id') }, function(data){ 
		var rows;
		if (!isempty_obj(data.data.rows)) {
			rows = data.data.rows[0];
			formContent.xform('load', rows);  
			{* console.log(rows); *}
		}
	});
	
		
		{* BootstrapDialog.show({ title: 'Update Record', type: BootstrapDialog.TYPE_PRIMARY, message: form,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-primary',
				label: '&nbsp;&nbsp;Save',
				action: function(dialog) {
					if (! form.valid()) return false;
					
					var button = this;
					button.spin();
					
					$.ajax({ url: '{$url_module ~ "?id="}'+data.id, method: "PUT", async: true, dataType: 'json',
						data: form.serializeJSON(),
						success: function(data) {
							dialog.close();
							dataTable1.ajax.reload( null, false );
							Lobibox.notify('info', { msg: data.message });
						},
						error: function(data) {
							if (data.status==500){
								var message = data.statusText;
							} else {
								var error = JSON.parse(data.responseText);
								var message = error.message;
							}
							button.stopSpin();
							dialog.enableButtons(true);
							dialog.setClosable(true);
							BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
						}
					});
				}
			}, {
					label: 'Close',
					action: function(dialog) { dialog.close(); }
			}],
			onshown: function(dialog) {
				form.validate({ ignore:'', rules:{ password_confirm:{ equalTo: "#password_new" }} });
				form.find('#name').focus();
			}
		}); *}
</script>