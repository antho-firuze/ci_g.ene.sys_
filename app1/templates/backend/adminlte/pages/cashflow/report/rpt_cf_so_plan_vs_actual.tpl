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
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	{* col.push(BSHelper.Input({ horz:false, type:"date", label:"Period From", idname:"fdate", cls:"auto_ymd", format:"mm-yyyy", required: true })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"date", label:"Period To", idname:"tdate", cls:"auto_ymd", format:"mm-yyyy", required: true })); *}
	a = [];
	a.push(subCol(6, BSHelper.Input({ horz: true, lblsize: "col-sm-4", colsize: "col-sm-8", type:"date", label:"Date From", idname:"fdate", cls:"auto_ymd", format:"{$.session.date_format}", required: false })));
	a.push(subCol(6, BSHelper.Input({ horz: true, lblsize: "col-sm-4", colsize: "col-sm-8", type:"date", label:"Date To", idname:"tdate", cls:"auto_ymd", format:"{$.session.date_format}", required: false })));
	col.push(BSHelper.Label({ horz: false, label:"Period :", idname:"fperiod", required: false, elcustom:subRow(a) }));
	col.push(BSHelper.Combobox({ horz:false, label:"SO No", cls:"order_id", label_link:"", textField:"doc_no", idname:"order_id", url: $url_module+"?peek_so=1", remote: true, required: false }));
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

</script>
<script src="{$.const.ASSET_URL}js/report.js"></script>
