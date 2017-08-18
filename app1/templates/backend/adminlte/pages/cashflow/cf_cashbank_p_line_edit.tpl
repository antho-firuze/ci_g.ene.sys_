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
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script> *}
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action"), cashbank_id;
	var $filter = getURLParameter("filter");
	if ($filter.split('=')[0] == 'cashbank_id'){
		cashbank_id = $filter.split('=')[1];
	}
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	var format_money = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Line No", idname:"seq", required: false, value: 0, step: "1", min: "0" }));
	{* col.push(BSHelper.Combobox({ label:"Doc Type", idname:"doc_type", required: true, disabled: ($act=='edt'?true:false), 
		list:[
			{ id:"2", name:"Invoice Vendor" },
			{ id:"4", name:"Others Payment" },
		] 
	})); *}
	col.push(BSHelper.Combobox({ horz:false, label:"Invoice No", label_link:"{$.const.PAGE_LNK}?pageid=85", textField:"code_name", idname:"invoice_id", url:"{$.php.base_url('cashflow/cf_oinvoice')}?for_cashbank=1&cashbank_id="+cashbank_id+"&act="+$act, remote: true, required: true, disabled: ($act=='edt'?true:false) }));
	col.push(BSHelper.Combobox({ horz:false, label:"Account", label_link:"{$.const.PAGE_LNK}?pageid=85", textField:"code_name", idname:"account_id", url:"{$.php.base_url('cashflow/cf_account')}", remote: true, required: true, disabled: true }));
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Doc No", idname:"doc_no", required: false, readonly: true, hidden: true })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"date", label:"Doc Date", idname:"doc_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false, hidden: true })); *}
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Note", idname:"note", required: false, readonly: true }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Amount", idname:"ori_amount", style: "text-align: right;", step: ".01", min: "0", required: true, value: 0, placeholder: "0.00", disabled: true, hidden: ($act=='edt'?true:false) }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Paid Amount", idname:"amount", style: "text-align: right;", step: ".01", min: "0", required: true, value: 0, placeholder: "0.00", readonly: true }));
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
	{* $("#doc_type").shollu_cb({
		onSelect: function(rowData){
			doc_type = rowData.id;
			if (doc_type == '2') {
				$("#invoice_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_pinvoice')}?for_cashbank=1&cashbank_id="+cashbank_id+"&doc_type="+doc_type+"&act="+$act });
				$("#invoice_id").shollu_cb('setValue', '');
				$("#invoice_id").shollu_cb('disable', false);
				$("#account_id").shollu_cb('setValue', 2);
				$("#account_id").shollu_cb('disable', true);
				$("#ori_amount").val(0);
				$("#amount").val(0);
				$("#note").val("");
				$("#description").val("");
			}
			if (doc_type == '4') {
				$("#invoice_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_oinvoice')}?for_cashbank=1&cashbank_id="+cashbank_id+"&doc_type="+doc_type+"&act="+$act });
				$("#invoice_id").shollu_cb('setValue', '');
				$("#invoice_id").shollu_cb('disable', false);
				$("#account_id").shollu_cb('setValue', '');
				$("#account_id").shollu_cb('disable', false);
				$("#ori_amount").val(0);
				$("#amount").val(0);
				$("#note").val("");
				$("#description").val("");
			}
		}
	}); *}
	
	$("#invoice_id").shollu_cb({
		onSelect: function(rowData){
			{* $("#doc_no").val(rowData.doc_no); *}
			{* $("#doc_date").val(rowData.doc_date); *}
			$("#ori_amount").val(rowData.net_amount);
			$("#amount").val(rowData.net_amount);
			$("#note").val(rowData.note);
			$("#description").val(rowData.description);
			$("#account_id").shollu_cb('setValue', rowData.account_id);
		}
	});
	
	{* Only for edit mode *}
	{* $(document).ready(function(){
		setTimeout(function(){
			if ($act == "edt") {
				doc_type = $("#doc_type").shollu_cb('getValue');
				if (doc_type == '2') {
					$("#invoice_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_pinvoice')}?for_cashbank=1&act="+$act });
				}
				if (doc_type == '4') {
					$("#invoice_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap')}?for_cashbank=1&act="+$act });
				}
			}
		} ,2000);
	}); *}
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
