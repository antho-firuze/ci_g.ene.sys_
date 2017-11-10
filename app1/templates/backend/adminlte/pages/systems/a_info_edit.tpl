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
	col.push(BSHelper.Multiselect({ horz:false, label:"Valid Org", idname:"valid_org", url:"{$.php.base_url('systems/a_org?for_user=1')}", required: false, remote: true, onChange: "filter_orgtrx" }));
	col.push(BSHelper.Multiselect({ horz:false, label:"Valid OrgTrx", idname:"valid_orgtrx", url:"{$.php.base_url('systems/a_orgtrx?for_user=1')}", required: false, remote: true }));
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

	function filter_orgtrx(data, val){
		var select = $("#valid_orgtrx");
		if (isempty_arr(data)) {
			select.empty();
			select.multiselect("rebuild");
			return false;
		}
		
		var params = { parent_id: data.join(',') };
		$.getJSON(select.attr('url'), params, function(result){ 
			if (!isempty_obj(result.data.rows)) { 
				select.empty();
				$.each(result.data.rows, function(i, item) {
					select.append('<option value="' + item.id + '">' + item.parent_name + ' => ' + item.code_name + '</option>');
				});
				select
					.multiselect("destroy")
					.multiselect({ includeSelectAllOption: true, enableFiltering: true,	filterBehavior: "text",	enableCaseInsensitiveFiltering: true,	maxHeight: 200,	});
				if (val) select.multiselect('select', val.replace(/\s+/g, '').split(','));
			}
		});
	}
	
	setTimeout(function(){
		if ($("#valid_org").val()) filter_orgtrx($("#valid_org").val(), $("#valid_orgtrx").attr("data-value"));
	}, 2000);
	
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
