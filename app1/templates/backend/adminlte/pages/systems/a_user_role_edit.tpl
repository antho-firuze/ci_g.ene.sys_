{var $url_module = $.php.base_url('systems/a_user_role')}
{var $url_module_main = $.php.base_url('systems/a_user')}

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
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script>
	var a = [];
	var col = subCol(12,"");
	var id = getURLParameter("id");
	var edit = getURLParameter("edit");
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	
	{* Set status to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	var user_id = getURLParameter("user_id");
	$.getJSON('{$url_module_main}', { "id": (user_id==null)?-1:user_id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var code_name = ": "+result.data.rows[0].code_name;
			$('.content-header').find('h1').find('small').before(code_name);
		}
	});
	$('.content-header').find('h1').find('small').html(desc(edit));
	
	{* For design form interface *}
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	{* adding master key id *}
	col.append(BSHelper.Input({ type:"hidden", idname:"user_id", value:user_id }));
	
	{* standard fields table *}
	col.append(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.append(BSHelper.Combobox({ horz:false, label:"Role", idname:"role_id", url:"{$.php.base_url('systems/a_role')}", remote: true }));
	col.append(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
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
			formContent.shollu_autofill('load', result.data.rows[0]);  
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