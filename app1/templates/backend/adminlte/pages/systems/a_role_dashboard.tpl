<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!-- /.row -->
		<div class="box box-body datagrid table-responsive no-padding"></div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ name: 'copy_dashboard', title:"Copy Dashboard From Role..." }, ],
		processMenuDisable: [],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		act_menu: { copy: false, edit: true, delete: true },
		sub_menu: [],
		order: ['t1.seq'],
		columns: [
			{ width:"100px", orderable:false, data:"role_name", title:"Role" },
			{ width:"150px", orderable:false, data:"code_name", title:"Dashboard" },
			{ width:"150px", orderable:false, data:"tags", title:"Tags" },
			{ width:"55px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Type" },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"seq", title:"Line", render:function(data, type, row){ return '<input type="number" class="seq" style="width:50px; text-align:center;" min="1" value="'+data+'">'; } },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
		],
	};
	
	function copy_dashboard(data)
	{
		var col = [], row = [], a = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		col.push("<h4 style='color:red; font-weight:bold;'>WARNING : All Dashboard in this Role will be replaced !</h4>");
		col.push(BSHelper.Combobox({ horz:false, label:"Source Role", idname:"copy_role_id", required:true, url:"{$.php.base_url('systems/a_role')}", remote: true }));
		col.push( $('<dl class="dl-horizontal">').append(a) ); a = [];
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.on('submit', function(e){ e.preventDefault(); });
		(function blink(){
			form1.find("h4").fadeOut().fadeIn(blink); 
		})();
		
		
		BootstrapDialog.show({
			title: 'Copy Dashboard', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_MEDIUM, message: form1, 
			buttons:[{ 
				cssClass: 'btn-primary', label: 'Submit', hotkey: 13, action: function(dialog) {
					var button = this;
					
					if (form1.validator('validate').has('.has-error').length === 0) {
						button.spin();
						button.disable();
						
						form1.append(BSHelper.Input({ type:"hidden", idname:"role_id", value:data.role_id }));
						
						$.ajax({ url: $url_module+'_xcopy', method: "OPTIONS", async: true, dataType: 'json',
							data: form1.serializeJSON(),
							success: function(data) {
								BootstrapDialog.show({ closable: false, message:data.message, 
									buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); } }],
								});
								dataTable1.ajax.reload( null, false );
								dialog.close();
								window.history.back(); 
							},
							error: function(data) {
								if (data.status==500){
									var message = data.statusText;
								} else {
									var error = JSON.parse(data.responseText);
									var message = error.message;
								}
								button.stopSpin();
								button.enable();
								BootstrapDialog.show({ closable: false, type:'modal-danger', title:'Notification', message:message, 
									buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); window.history.back(); } }],
								});
							}
						});
					}
				}
			}, {
				label: 'Cancel', cssClass: 'btn-danger', action: function(dialog) { dialog.close(); window.history.back(); }
			}],
			onshown: function(dialog) {
				{* /* This class is for auto conversion from dmy to ymd */ *}
				$(".auto_ymd").on('change', function(){
					$('input[name="'+$(this).attr('id')+'"]').val( datetime_db_format($(this).val(), $(this).attr('data-format')) );
				}).trigger('change');
			}
		});
	}
	
	{* btn-process1 in Toolbar *}
	{* $(document.body).click('button', function(e){
		switch($(e.target).attr('id')){
			case 'btn-process1':
				if (!confirm("All Dashboard in this Role will be replaced, Are you sure ?")) {
					return false;
				}
				var $pageid = getURLParameter("pageid"), $filter = getURLParameter("filter");
				$pageid = "?pageid="+$pageid+","+$(e.target).attr("data-pageid");
				$filter = $filter ? "&filter="+$filter : "";
				window.location.href = getURLOrigin()+$pageid+$filter+"&action=prc";
				break;
		}
	});	 *}
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
<script>
	$('.dataTables_wrapper').find('tbody').on('keypress keyup', '.seq', function (e) {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		var newLine = parseInt($(this).val());
		
		{* TAB || ESC *}
		if (e.keyCode == 9 || e.keyCode == 27){	
			{* console.log(data.seq); *}
			$(this).val(data.seq);
			return false;
		}
		
		if (e.keyCode == 13 && e.type == 'keypress'){
			if (data.seq == newLine)
				return false;
				
			{* console.log($.extend({}, data, { 'newline':newLine })); return false; *}
			$.extend(data, { 'newline':newLine });
			{* console.log(data); return false; *}
			
			$.ajax({ method: 'PUT', url: $url_module, data: JSON.stringify(data), dataType: 'json',
				success: function(data){
					dataTable1.ajax.reload( null, false );
				},
				error: function(data) {
					if (data.status==500){
						var message = data.statusText;
					} else {
						var error = JSON.parse(data.responseText);
						var message = error.message;
					}
					BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});
		}
	});
</script>
