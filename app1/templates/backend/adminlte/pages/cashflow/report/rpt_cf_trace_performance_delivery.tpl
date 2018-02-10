<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.css">
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script> *}
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action");
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	{* col.push(BSHelper.Input({ horz:false, type:"date", label:"Period From", idname:"fdate", cls:"auto_ymd", format:"mm-yyyy", required: true })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"date", label:"Period To", idname:"tdate", cls:"auto_ymd", format:"mm-yyyy", required: true })); *}
	{* a = []; *}
	{* a.push(subCol(6, BSHelper.Input({ horz: true, lblsize: "col-sm-4", colsize: "col-sm-8", type:"date", label:"Date From", idname:"fdate", cls:"auto_ymd", format:"{$.session.date_format}", required: false }))); *}
	{* a.push(subCol(6, BSHelper.Input({ horz: true, lblsize: "col-sm-4", colsize: "col-sm-8", type:"date", label:"Date To", idname:"tdate", cls:"auto_ymd", format:"{$.session.date_format}", required: false }))); *}
	{* col.push(BSHelper.Label({ horz: false, label:"Period :", idname:"fperiod", required: false, elcustom:subRow(a) })); *}
	a = [];
	a.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	col.push(BSHelper.Label({ horz: false, label:"Period", idname:"fperiod", required: false, elcustom: a }));
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

	{* INITILIZATION *}
	var start = moment().startOf('month');
	var end = moment().endOf('month');
	{* //Date range as a button *}
	$('#btn_cal').daterangepicker(
			{
				ranges: {
					{* 'Today': [moment(), moment()], *}
					{* 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')], *}
					{* 'Last 7 Days': [moment().subtract(6, 'days'), moment()], *}
					{* 'Last 30 Days': [moment().subtract(29, 'days'), moment()], *}
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
				},
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month')
			},
			function (start, end) {
				{* console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('MMMM D, YYYY')); *}
				$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$("#fdate").val(start.format('YYYY-MM-DD'));
				$("#tdate").val(end.format('YYYY-MM-DD'));
			}
	);
	
	$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	$("#fdate").val(start.format('YYYY-MM-DD'));
	$("#tdate").val(end.format('YYYY-MM-DD'));

</script>
<script src="{$.const.ASSET_URL}js/report.js"></script>
