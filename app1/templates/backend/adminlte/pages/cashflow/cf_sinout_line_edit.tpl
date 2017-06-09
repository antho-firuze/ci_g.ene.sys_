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
	var format_currency = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Line No", idname:"seq", required: false, value: 0, }));
	{* col.push(BSHelper.Combobox({ horz:false, label:"Item", label_link:"{$.const.PAGE_LNK}?pageid=30", idname:"item_id", url:"{$.php.base_url('sales/m_pricelist_item_list')}?level=1&filter=t1.itemtype_id=1,t1.pricelist_id=", remote: true })); *}
	{* col.push(BSHelper.Combobox({ horz:false, label:"SO Line", label_link:"{$.const.PAGE_LNK}?pageid=88", textField:"list_name", idname:"order_line_id", url:"{$.php.base_url('cashflow/cf_sorder_line')}", remote: true, required: false, })); *}
	col.push(BSHelper.Combobox({ horz:false, label:"SO Line", label_link:"{$.const.PAGE_LNK}?pageid=88", textField:"list_name", idname:"order_line_id", url:"{$.php.base_url('cashflow/cf_sorder_line')}?for_shipment=1", remote: true, required: false, }));
	col.push(BSHelper.Combobox({ horz:false, label:"Item Category", label_link:"{$.const.PAGE_LNK}?pageid=47", idname:"itemcat_id", url:"{$.php.base_url('inventory/m_itemcat')}", remote: true, required: true }));
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Item Name", idname:"item_name", required: false, })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Item Size", idname:"item_size", required: false, })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"number", label:"Unit Price", idname:"price", required: false, value: 0, })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"number", label:"Quantity", idname:"qty", required: false, value: 1 })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Sub Amount", idname:"sub_amt", style: "text-align: right;", format: format_currency, required: false, value: 0, onchange:"calculate_amount()", })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"VAT Amount", idname:"vat_amt", style: "text-align: right;", format: format_currency, required: false, value: 0, onchange:"calculate_amount()", })); *}
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Sub Amount", idname:"sub_amt", style: "text-align: right;", step: ".01", required: false, value: 0, onchange:"calculate_amount()", placeholder: "0.00" }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"VAT Amount", idname:"vat_amt", style: "text-align: right;", step: ".01", required: false, value: 0, onchange:"calculate_amount()", placeholder: "0.00" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Total Amount", idname:"ttl_amt", style: "text-align: right;", format: format_currency, required: false, value: 0, readonly: true, }));
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

	var $filter = getURLParameter("filter");
	if ($filter.split('=')[0] == 'inout_id'){
		var inout_id = $filter.split('=')[1];
				{* $("#order_line_id").shollu_cb({ queryParams: { get_order_line:1, inout_id:inout_id, having:"amount" } }); *}
				$("#order_line_id").shollu_cb({ queryParams: { for_shipment:1, inout_id:inout_id, having:"amount" } });
		$.getJSON($url_module, { "get_order_id": 1, "inout_id": inout_id }, function(result){ 
			if (result.data.order_id) {
				$("#order_line_id").attr("required", true);
				{* $("#order_line_id").shollu_cb({ queryParams: { filter:"order_id="+result.data.order_id } }); *}
				$("#itemcat_id").shollu_cb("disable", true);
				$("#sub_amt").attr("readonly", true);
				$("#vat_amt").attr("readonly", true);
			} else {
				$("#order_line_id").attr("required", false);
				$("#order_line_id").shollu_cb("disable", true);
				$("#itemcat_id").shollu_cb("disable", false);
			}
		});
	}
	
	$("#order_line_id").shollu_cb({
		onSelect: function(rawData){
			$("#itemcat_id").shollu_cb('setValue', rawData.itemcat_id);
			$("#sub_amt").val(rawData.sub_amt);
			$("#vat_amt").val(rawData.vat_amt);
			$("#ttl_amt").val(rawData.ttl_amt);
		}
	});
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
