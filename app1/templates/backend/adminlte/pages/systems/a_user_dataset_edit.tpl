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
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Code", idname:"code", required: false, })); *}
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true, }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Combobox({ horz:false, label:"Choose query from template", label_link:"{$.const.PAGE_LNK}?pageid=228", idname:"dataset_id", url:"{$.php.base_url('systems/a_dataset')}", remote: true, required: false, }));
	col.push(BSHelper.Button({ type:"button", label:"Load", idname:"btn_load" }));
	row.push(subCol(6, col)); col = [];
	form1.append(subRow(row));
	
	col = []; row = []; 
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Query", idname:"query", rows: 10 }));
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

	$("#btn_load").click(function(){
		var col = [], row = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		col.push("<h4 style='color:red; font-weight:bold;'>WARNING : Column Query will be replaced, are you sure ?</h4>");
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.on('submit', function(e){ e.preventDefault(); });
		(function blink(){
			form1.find("h4").fadeOut().fadeIn(blink); 
		})();
		
		BootstrapDialog.show({
			title: 'Copy Menu', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_MEDIUM, message: form1, 
			buttons:
			[{ 
				label: 'Do it !', cssClass: 'btn-primary', hotkey: 13, action: function(dialog) {
					$("#query").val($("#dataset_id").shollu_cb('getValue', 'query'));
					dialog.close();
				}
			}, {
				label: 'Cancel', cssClass: 'btn-danger', action: function(dialog) { dialog.close(); }
			}],
		});
	});
</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
