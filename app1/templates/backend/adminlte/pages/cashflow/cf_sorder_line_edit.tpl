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
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)};
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	var format_money = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Line No", idname:"seq", required: false, value: 0, step: "1", min: "0" }));
	{* col.push(BSHelper.Combobox({ horz:false, label:"Item", label_link:"{$.const.PAGE_LNK}?pageid=30", idname:"item_id", url:"{$.php.base_url('sales/m_pricelist_item_list')}?level=1&filter=t1.itemtype_id=1,t1.pricelist_id=", remote: true })); *}
	col.push(BSHelper.Combobox({ horz:false, label:"Item Category", label_link:"{$.const.PAGE_LNK}?pageid=47", idname:"itemcat_id", url:"{$.php.base_url('inventory/m_itemcat')}", remote: true, required: true, }));
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Item Name", idname:"item_name", required: false, })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Item Size", idname:"item_size", required: false, })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"number", label:"Unit Price", idname:"price", required: false, value: 0, })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"number", label:"Quantity", idname:"qty", required: true, value: 1 })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Sub Amount", idname:"sub_amt", style: "text-align: right;", format: format_money, required: false, value: 0, onchange:"calculate_amount()", })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"VAT Amount", idname:"vat_amt", style: "text-align: right;", format: format_money, required: false, value: 0, onchange:"calculate_amount()", })); *}
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Sub Amount", idname:"sub_amt", style: "text-align: right;", step: ".01", min: "0", required: false, value: 0, onchange:"calculate_amount()", placeholder: "0.00" }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"VAT Amount", idname:"vat_amt", style: "text-align: right;", step: ".01", min: "0", required: false, value: 0, onchange:"calculate_amount()", placeholder: "0.00" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Total Amount", idname:"ttl_amt", style: "text-align: right;", format: format_money, required: false, value: 0, readonly: true, }));
	row.push(subCol(6, col)); col = [];
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
	function calculate_amount(){ 
		{* $("#ttl_amt").val( parseFloat($("#sub_amt").inputmask('unmaskedvalue')) + parseFloat($("#vat_amt").inputmask('unmaskedvalue')) ); *}
		$("#ttl_amt").val( parseFloat($("#sub_amt").val()) + parseFloat($("#vat_amt").val()) );
	}
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
