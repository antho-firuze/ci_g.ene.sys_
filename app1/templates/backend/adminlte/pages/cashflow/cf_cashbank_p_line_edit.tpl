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
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.numeric.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script> *}
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action");
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	var format_currency = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Line No", idname:"seq", required: false, value: 0, }));
	col.push(BSHelper.Combobox({ label:"Doc Type", idname:"doc_type", required: true, disabled: ($act=='edt'?true:false), 
		list:[
			{ id:"IV", name:"Invoice Vendor" },
			{ id:"OP", name:"Others Payment" },
		] 
	}));
	col.push(BSHelper.Combobox({ horz:false, label:"Doc No", label_link:"{$.const.PAGE_LNK}?pageid=85", textField:"code_name", idname:"doc_no", url:"{$.php.base_url('cashflow/cf_pinvoice')}?for_cashbank=1&act="+$act, remote: true, required: true, disabled: ($act=='edt'?true:false) }));
	col.push(BSHelper.Combobox({ horz:false, label:"Account", label_link:"{$.const.PAGE_LNK}?pageid=85", textField:"code_name", idname:"account_id", url:"{$.php.base_url('cashflow/cf_account')}?filter=is_receipt='0'", remote: true, required: true }));
	col.push(BSHelper.Combobox({ horz:false, label:"Payment Note", label_link:"", textField:"code_name", idname:"note", url:"{$.php.base_url('cashflow/cf_porder_plan')}?for_cashbank=1", remote: true, required: true }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Amount", idname:"amount", style: "text-align: right;", step: ".01", required: true, value: 0, placeholder: "0.00" }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
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
	var doc_type;
	$("#doc_type").shollu_cb({
		onSelect: function(rowData){
			var doc_type = rowData.id;
			{* console.log(rowData); *}
			if (rowData.id == 'IV') {
				$("#doc_no").shollu_cb({ url:"{$.php.base_url('cashflow/cf_pinvoice')}?for_cashbank=1&act="+$act });
				$("#account_id").shollu_cb('setValue', 2);
				$("#account_id").shollu_cb('disable', true);
				$("#note").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder_plan')}?for_cashbank=1", });
				$("#note").shollu_cb('disable', true);
			}
			if (rowData.id == 'OP') {
				$("#doc_no").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap')}?for_cashbank=1&act="+$act });
				$("#account_id").shollu_cb('disable', false);
				$("#note").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap_plan')}?for_cashbank=1", });
				$("#note").shollu_cb('disable', false);
			}
		}
	});
	
	$("#doc_no").shollu_cb({
		onSelect: function(rowData){
			if (rowData.id == 'IV') {
				$("#amount").val(rowData.amount);
				$("#note").shollu_cb('setValue', rowData.order_plan_id);
			}
			if (rowData.id == 'OP') {
				$("#note").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap_plan')}?for_cashbank=1", });
			}
		}
	});
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
