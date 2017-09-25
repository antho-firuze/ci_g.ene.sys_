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
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ name:'copy_menu', title:"Copy Menu From Role..." }, ],
		processMenuDisable: [],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		act_menu: { copy: false, edit: true, delete: true },
		sub_menu: [],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:false, data:"role_name", title:"Role" },
			{ width:"150px", orderable:false, data:"code_name", title:"Menu" },
			{ width:"55px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Type", render:function(data, type, row){ return (data=='F') ? 'FORM' : (data=='P') ? 'PROCESS' : (data=='W') ? 'WINDOW' : 'GROUP'; } },
			{ width:"150px", orderable:false, data:"parent_name", title:"Parent Name" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Allow", 
				render:function(data, type, row){ 
					if (row.type == 'W'){
						switch(row.permit_window){ 
							case '1':return 'Create';break; 
							case '2':return 'Edit';break; 
							case '3':return 'Delete';break; 
							case '4':return 'Create & Edit';break; 
							case '5':return 'Create & Delete';break; 
							case '6':return 'Edit & Delete';break; 
							case '7':return 'Can All';break; 
							default:return 'Not Allow'; 
						}; 
					} else if (row.type == 'F'){
						switch(row.permit_form){ 
							case '1':return 'Execute';break; 
							default:return 'Not Allow'; 
						}; 
					} else if (row.type == 'P'){
						switch(row.permit_process){ 
							case '1':return 'Execute';break; 
							default:return 'Not Allow'; 
						}; 
					} else {
						return ''
					}
				} 
			},
		],
	};
	
	function copy_dashboard()
	{
		var col = [], row = [], a = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		col.push("<h3>All Menu in this Role will be replaced, Are you sure ?</h3>");
		a.push(BSHelper.LineDesc({ label:"Doc Date", value: data.doc_date }));
		a.push(BSHelper.LineDesc({ label:"Customer", value: data.bpartner_name }));
		a.push(BSHelper.LineDesc({ label:"Reference No", value: data.doc_ref_no }));
		a.push(BSHelper.LineDesc({ label:"Reference Date", value: data.doc_ref_date }));
		a.push(BSHelper.LineDesc({ label:"Expected DT Customer", value: data.expected_dt_cust }));
		col.push( $('<dl class="dl-horizontal">').append(a) ); a = [];
		col.push(BSHelper.Input({ horz:false, type:"date", label:"ETD", idname:"etd", cls:"auto_ymd", format:"{$.session.date_format}", value: data.etd, required: true }));
		col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.find("[data-mask]").inputmask();
		form1.on('submit', function(e){ e.preventDefault(); });
		
		BootstrapDialog.show({
			title: 'Update SO ETD', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_MEDIUM, message: form1, 
			buttons:[{ 
				cssClass: 'btn-primary', label: 'Submit', hotkey: 13, action: function(dialog) {
					var button = this;
					
					if (form1.validator('validate').has('.has-error').length === 0) {
						button.spin();
						button.disable();
						
						form1.append(BSHelper.Input({ type:"hidden", idname:"id", value:data.id }));
						
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
				if (!confirm("All Menu in this Role will be replaced, Are you sure ?")) {
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
