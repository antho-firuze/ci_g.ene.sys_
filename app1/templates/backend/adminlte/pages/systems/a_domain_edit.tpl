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
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $title	= "{$title}";
	{* Get Params *}
	var id = getURLParameter("id"), act = getURLParameter("action");
	var act_name = (act == 'new') ? "(New)" : (act == 'edt') ? "(Edit)" : (act == 'cpy') ? "(Copy)" : act;
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Code", idname:"code", required: false, }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true, }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Path", idname:"path", required: false, }));
	col.push(BSHelper.Combobox({ label:"Time Zone", idname:"timezone", required: true, 
		list:[
			{ id:"Asia/Jakarta", name:"Asia/Jakarta" },
		] 
	}));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Combobox({ label:"Client", idname:"client_id", required: true, url:"{$.php.base_url('systems/a_client')}", remote: true }));
	col.push(BSHelper.Combobox({ label:"Organization", idname:"org_id", required: true, url:"{$.php.base_url('systems/a_org')}", remote: true }));
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

</script>
