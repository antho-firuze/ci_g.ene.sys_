{var $url_module = $.php.base_url('systems/a_role_menu')}
{var $url_module_main = $.php.base_url('systems/a_role')}

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
<script>
	var a = [];	var col = [];
	var x = getURLParameter("x");
	var role_id = getURLParameter("role_id");
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = $('<div class="box"><div class="box-header"></div><div class="box-body"></div><div class="box-footer"></div></div>');
	form1.append(box1);
	
	{* Set status to Page Title *}
	$.getJSON('{$url_module_main}', { "id": (role_id==null)?-1:role_id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var code_name = ": "+result.data.rows[0].code_name;
			$('.content-header').find('h1').find('small').before(code_name);
		}
	});
	$('.content-header').find('h1').find('small').html("(Copy Menu From Role...)");
	
	{* adding master key id *}
	col.push(BSHelper.Input({ type:"hidden", idname:"role_id", value:role_id }));
	col.push(BSHelper.Input({ type:"hidden", idname:"x", value:x }));
	{* standard fields table *}
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Combobox({ horz:false, label:"Please Choose Role to be copied !", idname:"copy_role_id", required:true, url:"{$.php.base_url('systems/a_role')}?filter=t1.id<>"+role_id, remote: true }));
	box1.find(".box-body").append(subRow(subCol(6, col)));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	box1.find(".box-footer").append( a );
	$(".content").append(form1);

	{* Form submit action *}
	form1.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: "{$url_module}", method:"OPTIONS", async: true, dataType:'json',
			data: form1.serializeJSON(),
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert(data.message, function(){
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