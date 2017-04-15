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
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true, placeholder:"string(60)", }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Can Export", idname:"is_canexport" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Can Report", idname:"is_canreport" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Can View Log", idname:"is_canviewlog" }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Combobox({ horz:false, label:"Currency", idname:"currency_id", url:"{$.php.base_url('systems/c_currency')}", remote: true }));
	col.push(BSHelper.Combobox({ horz:false, label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", remote: true }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Can Approved Own Doc", idname:"is_canapproveowndoc" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Access All Orgs", idname:"is_accessallorgs" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Use User Org Access", idname:"is_useuserorgaccess" }));
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