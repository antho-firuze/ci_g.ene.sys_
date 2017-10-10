<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/summernote/summernote.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/bootstrap-multiselect/css/bootstrap-multiselect.css">
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/multiple-select/multiple-select.css"> *}
<script src="{$.const.TEMPLATE_URL}plugins/summernote/summernote.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.numeric.extensions.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/dependencyLibs/inputmask.dependencyLib.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/multiple-select/multiple-select.js"></script> *}
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, $act = getURLParameter("action");
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", cls:"summernote", height:50 }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Valid From", idname:"valid_from", cls:"auto_ymd", format:"{$.session.datetime_format}", required: false }));
	col.push(BSHelper.Input({ horz:false, type:"date", label:"Valid Till", idname:"valid_till", cls:"auto_ymd", format:"{$.session.datetime_format}", required: false }));
	col.push(BSHelper.Input({ horz:false, type:"hidden", idname:"valid_org" }));
	col.push(BSHelper.Input({ horz:false, type:"hidden", idname:"valid_orgtrx" }));
	col.push(BSHelper.Multiselect({ horz:false, label:"Valid Org", idname:"select_valid_org", url:"{$.php.base_url('systems/a_org?for_user=1')}", required: false }));
	col.push(BSHelper.Multiselect({ horz:false, label:"Valid OrgTrx", idname:"select_valid_orgtrx", url:"{$.php.base_url('systems/a_orgtrx?for_user=1')}", required: false }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
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

	function requery_valid_org(){
		$.getJSON($("#select_valid_org").attr('url'), {}, function(result){ 
			if (!isempty_obj(result.data.rows)) { 
				$("#select_valid_org").empty();
				$.each(result.data.rows, function(i, item) {
					$("#select_valid_org").append('<option value="' + item.id + '">' + item.code_name + '</option>');
				});
				$("#select_valid_org")
					.multiselect("destroy")
					.multiselect({
						includeSelectAllOption: true,
						enableFiltering: true,
						filterBehavior: "text",
						enableCaseInsensitiveFiltering: true,
						onChange: function(element, checked) {
							var selected = [];
							$('#select_valid_org option:selected').each(function(index, brand){
									selected.push([$(this).val()]);
							});
							$("#valid_org").val(selected.join(","));
							requery_valid_orgtrx(selected.join(","));
							{* console.log(selected); *}
						},
						onSelectAll: function() {
							var selected = [];
							$('#select_valid_org option:selected').each(function(index, brand){
									selected.push([$(this).val()]);
							});
							$("#valid_org").val(selected.join(","));
							requery_valid_orgtrx(selected.join(","));
							{* console.log(selected.join(",")); *}
						},
						onDeselectAll: function() {
							var selected = [];
							$('#select_valid_org option:selected').each(function(index, brand){
									selected.push([$(this).val()]);
							});
							$("#valid_org").val(selected.join(","));
							requery_valid_orgtrx(selected.join(","));
							{* console.log(selected.join(",")); *}
						}
				});
			}
		});
	}
	
	function requery_valid_orgtrx(parent_id){
		if (isempty_arr(parent_id)) {
			$("#select_valid_orgtrx").multiselect();
			return false;
		}
		$.getJSON($("#select_valid_orgtrx").attr('url'), { parent_id: parent_id }, function(result){ 
			if (!isempty_obj(result.data.rows)) { 
				$("#select_valid_orgtrx").empty();
				$.each(result.data.rows, function(i, item) {
					$("#select_valid_orgtrx").append('<option value="' + item.id + '">' + item.parent_name + ' => ' + item.code_name + '</option>');
				});
				$("#select_valid_orgtrx")
					.multiselect("destroy")
					.multiselect({
						includeSelectAllOption: true,
						enableFiltering: true,
						filterBehavior: "text",
						enableCaseInsensitiveFiltering: true,
						onChange: function(element, checked) {
							var selected = [];
							$('#select_valid_orgtrx option:selected').each(function(index, brand){
									selected.push([$(this).val()]);
							});
							$("#valid_orgtrx").val(selected.join(","));
							{* console.log(selected); *}
						},
						onSelectAll: function() {
							var selected = [];
							$('#select_valid_org option:selected').each(function(index, brand){
									selected.push([$(this).val()]);
							});
							$("#valid_orgtrx").val(selected.join(","));
							{* console.log(selected.join(",")); *}
						},
						onDeselectAll: function() {
							var selected = [];
							$('#select_valid_org option:selected').each(function(index, brand){
									selected.push([$(this).val()]);
							});
							$("#valid_orgtrx").val(selected.join(","));
							{* console.log(selected.join(",")); *}
						}
				});
			}
		});
	}
	
	requery_valid_org(); 
	requery_valid_orgtrx();
	
	setTimeout(function(){
		if ($act == 'edt'){
			var str = $("#valid_org").val();
			$("#valid_org").val(str.replace(/[{}]/g, ""));
			$("#select_valid_org").multiselect("select", str.replace(/[{}]/g, "").split(","));
			requery_valid_orgtrx(str.replace(/[{}]/g, ""));
			str = $("#valid_orgtrx").val();
			setTimeout(function(){
				$("#valid_orgtrx").val(str.replace(/[{}]/g, ""));
				$("#select_valid_orgtrx").multiselect("select", str.replace(/[{}]/g, "").split(","));
			}, 1000);
		}
	}, 2000);
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
