<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/pivottable/pivot.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.css">

{* <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> *}
{* <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>

<script src="{$.const.TEMPLATE_URL}plugins/pivottable/pivot.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/pivottable/d3_renderers.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/pivottable/c3_renderers.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/pivottable/export_renderers.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action");
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	col.push(BSHelper.Combobox({ horz:false, label:"Choose your dataset", idname:"dataset_id", url:"{$.php.base_url('bpm/c_bpartner')}?filter=is_customer='1'", remote: true, required: false, }));
	col.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	row.push(subCol(12, col)); col = [];
	form1.append(subRow(row));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	col = [], row = [];
	var boxPivot = BSHelper.Box();
	col.push( '<div id="output" style="margin: 10px;"></div>' );
	boxPivot.find('.box-body').append(subRow(subCol(12, col)));
	$(".content").append(boxPivot);	
	
	{* INITILIZATION *}
	var start = moment().subtract(29, 'days');
	var end = moment();
	{* //Date range as a button *}
	$('#btn_cal').daterangepicker(
			{
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(29, 'days'),
				endDate: moment()
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

	form1.validator().on('submit', function(e) {
		if (e.isDefaultPrevented()) { return false;	} 
		
		form1.find("[type='submit']").prop( "disabled", true );
		
		$.ajax({ url: $url_module, method: 'OPTIONS', async: true, dataType:'json',
			data: form1.serializeJSON(),
			success: function(result) {
				if (result.status){
					form1.find("[type='submit']").prop( "disabled", false );
					var renderers = $.extend(
							$.pivotUtilities.renderers,
							$.pivotUtilities.c3_renderers,
							$.pivotUtilities.d3_renderers,
							$.pivotUtilities.export_renderers
							);
					{* console.log(result.data); *}
					$("#output").pivotUI(result.data, { hiddenAttributes: [""], renderers: renderers }, true);
					{* $("#output").pivotUI(
            [
                { color: "blue", shape: "circle" },
                { color: "red", shape: "triangle" }
            ],
            {
                rows: ["color"],
                cols: ["shape"]
            }
					); *}
				}
			},
			error: function(data) {
				if (data.status >= 500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				form1.find("[type='submit']").prop( "disabled", false );
				BootstrapDialog.show({ message:message, closable: false, type:'modal-danger', title:'Notification', 
					buttons: [{ label: 'OK', hotkey: 13, 
						action: function(dialogRef) {
							dialogRef.close();
						} 
					}],
				});
			}
		});
		return false;
	});
</script>
{* <script src="{$.const.ASSET_URL}js/report.js"></script> *}
