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
	col.push(BSHelper.Combobox({ label:"Doc Type", idname:"doc_type", required: true, disabled: ($act=='edt'?true:false), 
		list:[
			{ id:"2", name:"Invoice Vendor" },
			{ id:"3", name:"Invoice Clearance" },
			{ id:"4", name:"Invoice Custom Duty" },
		] 
	}));
	col.push(BSHelper.Combobox({ horz:false, label:"Doc No", label_link:"{$.const.PAGE_LNK}?pageid=93", textField:"code_name", idname:"order_id", url:"{$.php.base_url('cashflow/cf_porder')}?for_invoice=1&act="+$act, remote: true, required: true, disabled: true }));
	col.push(BSHelper.Combobox({ horz:false, label:"Vendor", label_link:"{$.const.PAGE_LNK}?pageid=87", idname:"bpartner_id", url:"{$.php.base_url('bpm/c_bpartner')}?filter=is_vendor='1'", remote: true, required: true, disabled: ($act=='edt'?false:true) }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Vendor TOP (Days)", idname:"po_top", style: "text-align: right;", step: ".01", required: false, value: 0, placeholder: "0", readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"PO ETA", idname:"eta_po", cls:"auto_ymd", format:"{$.session.date_format}", required: false, disabled: true }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Doc No", idname:"doc_no", format: "'casing': 'upper'", required: true, }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Doc Date", idname:"doc_date", cls:"auto_ymd", format:"{$.session.date_format}", required: true }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Payment Plan Date", idname:"payment_plan_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Combobox({ horz:false, label:"Payment Note", textField:"note", idname:"plan_id", url:"{$.php.base_url('cashflow/cf_porder_plan')}?for_invoice=1", remote: true, required: ($act=='edt'?false:true), disabled: true }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Payment Note", idname:"note", required: false, readonly: true, hidden: true }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Amount", idname:"amount", style: "text-align: right;", step: ".01", required: true, value: 0, placeholder: "0.00" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Reference No", idname:"doc_ref_no", required: false, required: false, }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Reference Date", idname:"doc_ref_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false }));
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
	function clearVal(){
		$("#order_id").shollu_cb('setValue', '');
		$("#order_id").shollu_cb('disable', false);
		$("#bpartner_id").shollu_cb('setValue', '');
		$("#plan_id").shollu_cb('setValue', '');
		$("#plan_id").shollu_cb('disable', true);
		$("#amount").val(0);
		$("#note").val("");
		$("#description").val("");
	}
	
	$("#doc_type").shollu_cb({
		onSelect: function(rowData){
			doc_type = rowData.id;
			if (doc_type == '2')
				$("#order_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder')}?for_invoice_plan=1&act="+$act });
			if (doc_type == '3')
				$("#order_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder')}?for_invoice_plan_clearance=1&act="+$act });
			if (doc_type == '4')
				$("#order_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder')}?for_invoice_plan_import=1&act="+$act });
			
			clearVal();
		}
	});
	
	$("#order_id").shollu_cb({
		onSelect: function(rowData){
			$("#bpartner_id").shollu_cb('setValue', rowData.bpartner_id);
			$("#bpartner_id").shollu_cb('disable', false);
			$("#eta_po").val(rowData.eta);
			if (doc_type == '2')
				$("#plan_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder_plan')}?for_invoice=1&filter=order_id="+rowData.id+"&act="+$act });
			if (doc_type == '3')
				$("#plan_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder_plan_clearance')}?for_invoice=1&filter=order_id="+rowData.id+"&act="+$act });
			if (doc_type == '4')
				$("#plan_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_porder_plan_import')}?for_invoice=1&filter=order_id="+rowData.id+"&act="+$act });
				
			$("#plan_id").shollu_cb('setValue', '');
			$("#plan_id").shollu_cb('disable', false);
			$("#amount").val(0);
			$("#note").val("");
			$("#description").val("");
			
			$("#bpartner_id").shollu_cb('select');
		}
	});
	
	$("#bpartner_id").shollu_cb({
		onSelect: function(rowData){
			$("#po_top").val(rowData.po_top);
		}
	});
	
	$("#plan_id").shollu_cb({
		onSelect: function(rowData){
			$("#amount").val(rowData.amount);
			$("#note").val(rowData.note);
			$("#description").val(rowData.description);
		}
	});
	
	{* Only for edit mode *}
	$(document).ready(function(){
		setTimeout(function(){
			if ($act == "edt") {
				$("#plan_id").removeAttr('required');
				$("#plan_id").closest(".form-group").css("display", "none");
				$("#note").closest(".form-group").css("display", "");
			}
		} ,2000);
	});
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
