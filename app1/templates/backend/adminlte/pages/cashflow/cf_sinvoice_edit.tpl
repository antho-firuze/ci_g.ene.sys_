<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action");
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Doc No", idname:"doc_no", format: "'casing': 'upper'", required: false, required: true, }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Doc Date", idname:"doc_date", cls:"auto_ymd", format:"{$.session.date_format}", required: true }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Reference No", idname:"doc_ref_no", required: false, required: false }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Reference Date", idname:"doc_ref_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false }));
	row.push(subCol(6, col)); col = [];
	{* col.push(BSHelper.Combobox({ horz:false, label:"Branch", label_link:"{$.const.PAGE_LNK}?pageid=18", idname:"orgtrx_id", url:"{$.php.base_url('systems/a_org_parent_list')}?orgtype_id=3&parent_id={$.session.org_id}", remote: true, required: true })); *}
	{* col.push(BSHelper.Combobox({ horz:false, label:"DO No", label_link:"{$.const.PAGE_LNK}?pageid=88", textField:"doc_no", idname:"inout_id", url:"{$.php.base_url('cashflow/cf_sinout')}?for_invoice=1", remote: true, required: false })); *}
	col.push(BSHelper.Combobox({ horz:false, label:"SO No", label_link:"{$.const.PAGE_LNK}?pageid=88", textField:"doc_no", idname:"order_id", url:"{$.php.base_url('cashflow/cf_sorder')}?for_invoice_cus=1&act="+$act, remote: true, required: true, disabled: ($act=='edt'?true:false) }));
	col.push(BSHelper.Combobox({ horz:false, label:"Customer", idname:"bpartner_id", url:"{$.php.base_url('bpm/c_bpartner')}?filter=is_customer='1'", remote: true, required: true, disabled: true }));
	col.push(BSHelper.Combobox({ label:"Type", idname:"plan_type", required: true, value: 0, disabled: true, 
		list:[
			{ id:"0", name:"Plan Cash-In" },
		] 
	}));
	col.push(BSHelper.Combobox({ horz:false, label:"Plan Cash-In", textField:"note", idname:"order_plan_id", url:"{$.php.base_url('cashflow/cf_sorder_plan')}?for_invoice=1&filter=order_id=99", remote: true, required: true }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Amount", idname:"amount", style: "text-align: right;", step: ".01", required: true, value: 0, placeholder: "0.00" }));
	row.push(subCol(6, col)); col = [];
	form1.append(subRow(row));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	$("[data-mask]").inputmask();
	
	{* INITILIZATION *}
	$("#order_id").shollu_cb({
		onSelect: function(rowData){
			$("#bpartner_id").shollu_cb('setValue', rowData.bpartner_id);
			$("#order_plan_id").shollu_cb({ queryParams: { for_invoice:1, filter:"order_id="+rowData.id } });
		}
	});
	$("#order_plan_id").shollu_cb({
		onSelect: function(rowData){
			$("#amount").val(rowData.amount);
		}
	});
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
