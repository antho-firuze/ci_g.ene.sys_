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
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)};
	var $filter = getURLParameter("filter");
	var arr_filter = {};
	$filter.split(',').forEach(function(x){
			arr = x.split('=');
			arr[1] && (arr_filter[arr[0]] = arr[1]);
	});
	{* console.log(arr_filter.user_org_id); *}
	$.getJSON($url_module, { get_org_id: 1, user_org_id: arr_filter.user_org_id }, function(result){
		{* console.log(result.data); *}
		$("#org_id").shollu_cb({ queryParams: { "orgtype_id":3, "parent_id":result.data.org_id }});
	});
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	{* col.push(BSHelper.Combobox({ horz:false, label:"Location/Branch", label_link:"{$.const.PAGE_LNK}?pageid=18", idname:"org_id", textField:"name", url:"{$.php.base_url('systems/a_org_parent_list')}?orgtype_id=3&parent_id="+arr_filter.user_org_id, remote: true })); *}
	col.push(BSHelper.Combobox({ horz:false, label:"Location/Branch", label_link:"{$.const.PAGE_LNK}?pageid=18", idname:"org_id", textField:"name", url:"{$.php.base_url('systems/a_org_parent_list')}?orgtype_id=3", remote: true }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
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

</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
