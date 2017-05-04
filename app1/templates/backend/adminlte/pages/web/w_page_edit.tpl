<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
{* <script src="{$.const.TEMPLATE_URL}plugins/tinymce/js/tinymce/tinymce.min.js"></script> *}
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/summernote/summernote.css">
<script src="{$.const.TEMPLATE_URL}plugins/summernote/summernote.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)};
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Title", idname:"title", required: true }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Title Desc", idname:"title_desc" }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	row.push(subCol(6, col)); col = [];
	a.push(subRow(row)); row = [];
	col.push(BSHelper.Input({ horz:false, type:"textarea", idname:"body_content", cls:"summernote" }));
	row.push(subCol(12, col)); col = [];
	a.push(subRow(row));
	form1.append(a);
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
