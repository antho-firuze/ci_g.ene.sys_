{var $url_copyrole = $.php.base_url('systems/a_role_menu_xcopy')}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $title	= "{$title}";
	{* Get Params *}
	var id = getURLParameter("id"), act = getURLParameter("action"), key = getURLParameter("key"), val = getURLParameter("val");
	var act_name = "(Copy Menu From Role...)";
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Combobox({ horz:false, label:"Please Choose Role to be copied !", idname:"copy_role_id", required:true, url:"{$.php.base_url('systems/a_role')}?filter=t1.id<>"+val, remote: true }));
	row.push(subCol(6, col)); col = [];
	row.push(subCol(6, col));
	form1.append(subRow(row));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	{* Form submit action *}
	form1.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		form1.append(BSHelper.Input({ type:"hidden", idname:"id", value:id }));
		form1.append(BSHelper.Input({ type:"hidden", idname:"action", value:act }));
		form1.append(BSHelper.Input({ type:"hidden", idname:key, value:val }));
		
		form1.find("[type='submit']").prop( "disabled", true );
		
		$.ajax({ url: "{$url_copyrole}", method:"OPTIONS", async: true, dataType:'json',
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
				form1.find("[type='submit']").prop( "disabled", false );
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});

		return false;
	});
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
