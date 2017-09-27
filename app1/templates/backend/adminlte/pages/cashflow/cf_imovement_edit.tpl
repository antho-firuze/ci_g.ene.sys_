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
	col.push(BSHelper.Combobox({ horz:false, label:"Outbound No", label_link:"", textField:"doc_no", idname:"id", url:"{$.php.base_url('cashflow/cf_omovement')}?for_inbound=1&act="+$act, remote: true, required: true, disabled: ($act=='edt'?true:false) }));
	col.push(BSHelper.Combobox({ horz:false, label:"From Org", label_link:"", idname:"org_to_id", textField:"code_name", url:"{$.php.base_url('systems/a_org_list')}", remote: true, disabled: true }));
	col.push(BSHelper.Combobox({ horz:false, label:"From Org Trx", label_link:"", idname:"orgtrx_to_id", textField:"code_name", url:"{$.php.base_url('systems/a_orgtrx_list')}", remote: true, disabled: true }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Delivery Date", idname:"delivery_date", cls:"auto_ymd", format:"{$.session.date_format}", readonly: true }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Received Date", idname:"received_date", cls:"auto_ymd", format:"{$.session.date_format}", required: true }));
	row.push(subCol(6, col)); col = [];
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
	$("#id").shollu_cb({
		onSelect: function(rowData){
			$("#org_to_id").shollu_cb("setValue", rowData.org_to_id);
			$("#orgtrx_to_id").shollu_cb("setValue", rowData.orgtrx_to_id);
			$("#doc_date").val(rowData.doc_date);
			$("#delivery_date").val(rowData.delivery_date);
			$("#doc_ref_no").val(rowData.doc_ref_no);
			$("#doc_ref_date").val(rowData.doc_ref_date);
			$("#description").val(rowData.description);
		}
	});
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
