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
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.numeric.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action");
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	var format_money = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
	col.push(BSHelper.Combobox({ horz:false, label:"Branch", label_link:"{$.const.PAGE_LNK}?pageid=18", idname:"orgtrx_id", url:"{$.php.base_url('systems/a_org_parent_list')}?orgtype_id=3&parent_id={$.session.org_id}", remote: true, required: true, disabled: ($act=='edt'?true:false), value: {$.session.orgtrx_id}, hidden: "{$.session.show_branch_entry}"=="1" ? false : true }));
	col.push(BSHelper.Combobox({ label:"Doc Type", idname:"doc_type", required: true, disabled: ($act=='edt'?true:false), 
		list:[
			{ id:"5", name:"Other Inflow" },
			{ id:"6", name:"Other Outflow" },
		] 
	}));
	col.push(BSHelper.Combobox({ horz:false, label:"AR/AP No", textField:"doc_no", idname:"ar_ap_id", url:"{$.php.base_url('cashflow/cf_ar')}", remote: true, required: true, disabled: true }));
	col.push(BSHelper.Combobox({ horz:false, label:"AR/AP Plan", textField:"code_name", idname:"ar_ap_plan_id", url:"{$.php.base_url('cashflow/cf_ar_plan')}?for_invoice=1", remote: true, required: true, disabled: true }));
	col.push(BSHelper.Combobox({ horz:false, label:"Business Partner", label_link:"{$.const.PAGE_LNK}?pageid=87", idname:"bpartner_id", url:"{$.php.base_url('bpm/c_bpartner')}", remote: true, required: false, disabled: true }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Note", idname:"note", required: false, readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Amount", idname:"amount", style: "text-align: right;", step: ".01", min: "0", required: false, value: 0, onchange:"calculate_amount()", placeholder: "0.00", readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"number", label:"Adjustment Amount", idname:"adj_amount", style: "text-align: right;", step: ".01", required: false, value: 0, onchange:"calculate_amount()", placeholder: "0.00", readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Net Amount", idname:"net_amount", style: "text-align: right;", format: format_money, required: false, value: 0, readonly: true, placeholder: "0.00", }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Doc No", idname:"doc_no", format: "'casing': 'upper'", required: false, hidden: true }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Invoice Date", idname:"doc_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false, readonly: true, hidden: ($act=='edt'?false:true) }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Invoice Plan Date", idname:"invoice_plan_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false, readonly: true, }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Payment Plan Date", idname:"payment_plan_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false, readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Received Plan Date", idname:"received_plan_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false, readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Reference No", idname:"doc_ref_no", required: false, }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Reference Date", idname:"doc_ref_date", cls:"auto_ymd", format:"{$.session.date_format}", required: false }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"account_id", idname:"account_id", hidden: true }));
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
	function calculate_amount(){ 
		{* $("#ttl_amt").val( parseFloat($("#sub_amt").inputmask('unmaskedvalue')) + parseFloat($("#vat_amt").inputmask('unmaskedvalue')) ); *}
		$("#net_amount").val( parseFloat($("#amount").val()) + parseFloat($("#adj_amount").val()) );
		$(".auto_ymd").trigger('change');
		form1.validator('update').validator('validate');
	}
	
	$("#received_plan_date").closest(".form-group").css("display", "none");
	$("#payment_plan_date").closest(".form-group").css("display", "none");
	
	function clearVal(){
		$("#ar_ap_id").shollu_cb('setValue', '');
		$("#ar_ap_id").shollu_cb('disable', false);
		$("#bpartner_id").shollu_cb('setValue', '');
		$("#ar_ap_plan_id").shollu_cb('setValue', '');
		$("#ar_ap_plan_id").shollu_cb('disable', true);
		$("#amount").val(0);
		$("#note").val("");
		$("#description").val("");
	}
	
	$("#doc_type").shollu_cb({
		onSelect: function(rowData){
			doc_type = rowData.id;
			if (doc_type == '5') {
				$("#ar_ap_id").closest(".form-group").find("label span").text("AR No *");
				$("#ar_ap_plan_id").closest(".form-group").find("label span").text("AR Plan *");

				$("#ar_ap_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ar')}?for_invoice=1&act="+$act });
				$("#received_plan_date").closest(".form-group").css("display", "");
				$("#payment_plan_date").closest(".form-group").css("display", "none");
				$("#received_plan_date").attr("required", true);
				$("#payment_plan_date").attr("required", false);
			}
			if (doc_type == '6') {
				$("#ar_ap_id").closest(".form-group").find("label span").text("AP No *");
				$("#ar_ap_plan_id").closest(".form-group").find("label span").text("AP Plan *");

				$("#ar_ap_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap')}?for_invoice=1&act="+$act });
				$("#received_plan_date").closest(".form-group").css("display", "none");
				$("#payment_plan_date").closest(".form-group").css("display", "");
				$("#received_plan_date").attr("required", false);
				$("#payment_plan_date").attr("required", true);
			}
			
			clearVal();
			form1.validator('update').validator('validate');
		}
	});
	
	$("#ar_ap_id").shollu_cb({
		onSelect: function(rowData){
			if (doc_type == '5')
				$("#ar_ap_plan_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ar_plan')}?for_invoice=1&filter=ar_ap_id="+rowData.id+"&act="+$act });
			if (doc_type == '6')
				$("#ar_ap_plan_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap_plan')}?for_invoice=1&filter=ar_ap_id="+rowData.id+"&act="+$act });
				
			$("#ar_ap_plan_id").shollu_cb('setValue', '');
			$("#ar_ap_plan_id").shollu_cb('disable', false);
			$("#doc_no").val(rowData.doc_no);
			$("#amount").val(0);
			$("#note").val("");
			$("#description").val("");
		}
	});
	
	$("#ar_ap_plan_id").shollu_cb({
		onSelect: function(rowData){
			$("#bpartner_id").shollu_cb('setValue', rowData.bpartner_id);
			$("#amount").val(rowData.ttl_amt);
			$("#note").val(rowData.note);
			$("#description").val(rowData.description);
			$("#account_id").val(rowData.account_id);
			$("#invoice_plan_date").val(rowData.doc_date);
			$("#received_plan_date").val(rowData.received_plan_date);
			$("#payment_plan_date").val(rowData.payment_plan_date);
			
			calculate_amount();
		}
	});
	
	{* form1.on('submit', function(e){
		e.preventDefault();
		
		console.log($("#doc_date").val());
		console.log(form1.serializeJSON());
		return false;
	}); *}
	
	{* Only for edit mode *}
	$(document).ready(function(){
		setTimeout(function(){
			if ($act == "edt") {
				doc_type = $("#doc_type").shollu_cb('getValue');
				var ar_ap_id = $("#ar_ap_id").val();
				if (doc_type == '5') {
					$("#ar_ap_id").closest(".form-group").find("label span").text("AR No *");
					$("#ar_ap_plan_id").closest(".form-group").find("label span").text("AR Plan *");

					$("#ar_ap_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ar')}?for_invoice=1&act="+$act });
					$("#received_plan_date").closest(".form-group").css("display", "");
					$("#payment_plan_date").closest(".form-group").css("display", "none");
					$("#received_plan_date").attr("required", true);
					$("#payment_plan_date").attr("required", false);
				}
				if (doc_type == '6') {
					$("#ar_ap_id").closest(".form-group").find("label span").text("AP No *");
					$("#ar_ap_plan_id").closest(".form-group").find("label span").text("AP Plan *");

					$("#ar_ap_id").shollu_cb({ url:"{$.php.base_url('cashflow/cf_ap')}?for_invoice=1&act="+$act });
					$("#ar_ap_id").shollu_cb('setValue', ar_ap_id);
					$("#received_plan_date").closest(".form-group").css("display", "none");
					$("#payment_plan_date").closest(".form-group").css("display", "");
					$("#received_plan_date").attr("required", false);
					$("#payment_plan_date").attr("required", true);
				}
			}
			form1.validator('update').validator('validate');
		} ,2000);
	});
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
