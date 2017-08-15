<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
{$.php.link_tag($.const.TEMPLATE_URL~"plugins/SmartWizard/css/smart_wizard.min.css")}
{$.php.link_tag($.const.TEMPLATE_URL~"plugins/SmartWizard/css/smart_wizard_theme_arrows.min.css")}
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $class = "{$class}", $method = "{$method}", $bread = {$.php.json_encode($bread)};
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	box1.find('.box-body').append(form1);
	$(".content").append(box1);
	
	var SWContent = BSHelper.SmartWizard({
		dataList: [
			{	title:"Select & Upload File", idname:"step-uploading", content: function(){
				row = [];
				col.push(BSHelper.Combobox({ label:"File Type", idname:"filetype", required: true, value: 'xls',
					list:[
						{ id:"xls", name:"Excel 97-2003 Workbook (*.xls)" },
						{ id:"xlsx", name:"Excel 2007-newer Workbook (*.xlsx)" },
						{ id:"csv", name:"Comma Separated Values File (*.csv)" },
					] 
				}));
				col.push(BSHelper.Combobox({ label:"Import Type", idname:"importtype", required: true, value: 'insert',
					list:[
						{ id:"insert", name:"Insert Records" },
						{ id:"update", name:"Update Records" },
					] 
				}));
				col.push(BSHelper.Input({ type:"text", label:"Filename", idname:"filename", disabled: true, required: true, placeholder: " " }));
				col.push(BSHelper.Button({ type:"button", label:"Select File", idname:"btn_selectfile" }));
				col.push("&nbsp;&nbsp;");
				col.push(BSHelper.Button({ type:"button", label:"Upload File", idname:"btn_uploadfile" }));
				col.push("&nbsp;&nbsp;");
				col.push(BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", onclick:"window.history.back();" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
			{	title:"Format Options", idname:"step-formatting", content: function(){
				row = [];
				{* Format options *}
				col.push(BSHelper.Combobox({ label:"Date Format", idname:"date_format", required: true, value:"yyyy-mm-dd", 
					list:[
						{ id:"yyyy-mm-dd", name:"yyyy-mm-dd" },
						{ id:"dd/mm/yyyy", name:"dd/mm/yyyy" },
						{ id:"mm/dd/yyyy", name:"mm/dd/yyyy" },
						{ id:"dd-mm-yyyy", name:"dd-mm-yyyy" },
						{ id:"mm-dd-yyyy", name:"mm-dd-yyyy" },
						{ id:"dd/mm/yyyy hh:mm", name:"dd/mm/yyyy hh:mm" },
						{ id:"mm/dd/yyyy hh:mm", name:"mm/dd/yyyy hh:mm" },
						{ id:"dd-mm-yyyy hh:mm", name:"dd-mm-yyyy hh:mm" },
						{ id:"mm-dd-yyyy hh:mm", name:"mm-dd-yyyy hh:mm" },
					] 
				}));
				{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Date Delimiter", idname:"date_delimiter", required: true, value:"/" })); *}
				{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Time Delimiter", idname:"time_delimiter", required: true, value:":" })); *}
				{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Decimal Symbol", idname:"decimal_symbol", required: true, value:"." })); *}
				col.push(BSHelper.Button({ type:"button", label:"Next", idname:"btn_next" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
			{	title:"Mapping Fields", idname:"step-mapping-field", content: function(){
				row = [];
				col.push("Session Failed !<br><br>");
				col.push(BSHelper.Button({ type:"button", label:"Reset Process", idname:"btn_reset" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
			{	title:"Import Data", idname:"step-importing-data", content: function(){
				row = [];
				col.push(BSHelper.Button({ type:"button", label:"Start Import", idname:"btn_startimport" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
		],
	});
	form1.append(SWContent);
	
	{* Event on change filetype *}
	var filetype = [{ title:"Excel files", extensions:"xls" }];
	$("#filetype").shollu_cb({
		onSelect: function(rowData){
			if (rowData.id == 'xls')
				filetype = [{ title:"Excel files", extensions:"xls" }];
			else if (rowData.id == 'xlsx')
				filetype = [{ title:"Excel files", extensions:"xlsx" }];
			else
				filetype = [{ title:"CSV files", extensions:"csv" }];
			
			restart_plupload();
		}
	});
	
	$("#btn_uploadfile").click(function(e){
		e.stopPropagation();
		if ($("#filename").val() == ''){
			alert("Please select the file to be import...");
			return false;
		}
			
		console.log('Uploading the file...');
		{* For manually pace start *}
		Pace.stop(); Pace.bar.render();
		uploader.start();
	});
	
	$("button[name='btn_next']").click(function(e){ $(".smartwizard").smartWizard("next"); });
	$("button[name='btn_reset']").click(function(e){ $(".smartwizard").smartWizard("reset"); });
	
	
	{* Explanation this plupload how to become function is 
	*	 because there is still any bug when changed mime_types with API, the mime_types is still the same.
	*
	*	 This is the API:
	*	 uploader.setOption('filters', { mime_types: filetype }); 
	*}
	var uploader;
	function restart_plupload()
	{
		if (typeof (uploader) !== "undefined"){
			uploader.destroy();
		} 
		
		{* uploader = new plupload.Uploader({ url: "{$.php.base_url()}test/upload_file", runtimes:"html5", chunk_size : "50000", *}
		uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5", 
			chunk_size : "50kb",
			filters: { max_file_size: "{$.session.max_file_upload}", mime_types: filetype },
			browse_button: "btn_selectfile", 
			multi_selection: false,
			multipart_params: { "import":1, "step":1, "filetype": $("#filetype").shollu_cb("getValue"), "importtype": $("#importtype").shollu_cb("getValue") },
			init: {
				FilesAdded: function(up, files) {
					{* console.log(files); *}
					$("#filename").val(files[0].name);
					$("#filename").parent().find("small").html("");
					$("#btn_uploadfile").prop("disabled", false);
				},
				FileUploaded: function(up, file, info) {
					var response = $.parseJSON(info.response);
					{* console.log(response); *}
					if (response.status) { 
						$("#filename").parent().find("small").html(response.message);
						
						Pace.bar.update(100); 
						setTimeout(function(){
							{* preparation for field mapping *}
							set_mapping_field(response.table_fields, response.tmp_fields);
							$("#filetype").shollu_cb("disable", true);
							$("#btn_selectfile").prop("disabled", true);
							$("#btn_uploadfile").prop("disabled", true);
							$(".smartwizard").smartWizard("next");
							Pace.stop();
						}, 500);
					} else {
						BootstrapDialog.alert(response.message);
						restart_plupload();
						$(".smartwizard").smartWizard("reset");
					}
				},
				UploadProgress: function(up, file) {
					if (file.percent == 100)
						file.percent = 97;
					Pace.bar.update(file.percent); 
				},
				Error: function(up, err) {
					console.log('Plupload Error');
					restart_plupload();
					Pace.stop();
					$(".smartwizard").smartWizard("reset");
					document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
				}
			}
		});
		uploader.init();
	}
	restart_plupload();
	
	$(document).ready(function(){
		
		{* // Smart Wizard *}
		$(".smartwizard").smartWizard({ 
			selected: 0, 
			theme: 'arrows',
			transitionEffect:'fade',
			keyNavigation: false,
			showStepURLhash: false,
			toolbarSettings: { 
				toolbarPosition: 'none',
			}
		});
		
	});
	
	function set_mapping_field(fields, tmp_fields){
		var form3 = BSHelper.Form({ autocomplete:"off", idname:"form-mapping-field" });	
		var tmp_list = [];
		$.each(tmp_fields, function(i, val){
			tmp_list[i] = { id:val, name:val };
		});
		{* console.log(tmp_list); return false; *}
		row = []; col = [];
		$.each(fields, function(i, val){
			col.push(BSHelper.Combobox({ label:val, idname:val, required: true, value:val, list:tmp_list }));
			if (i >= 4) {
				row.push(subCol(6, col)); col = [];
			}
		});
		row.push(subRow()); col = [];
		col.push(BSHelper.Button({ type:"submit", label:"Next" }));
		row.push(subCol(6, col)); col = [];
		$("#step-mapping-field").empty();
		$("#step-mapping-field").append(form3.append(subRow(row)));
		
		form3.validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) { return false;	} 
			
			$(".smartwizard").smartWizard("next");
			return false;
		});
	}
	
	$("#btn_startimport").click(function(e){
		e.stopPropagation();
		
		var data = $("#form-mapping-field").serializeOBJ();
		data = { 
			import:1, step:2, pageid: $pageid, filter: $filter, ob: $ob, 
			filetype: $("#filetype").shollu_cb("getValue"), 
			importtype: $("#importtype").shollu_cb("getValue"), 
			date_format: $("#date_format").shollu_cb("getValue"),
			fields: data 
		};
		
		$(this).prop('disabled', true);
		
		console.log('Importing on progress...');
		{* For manually pace start *}
		Pace.stop(); Pace.bar.render();
		
		$.ajax({ url: $url_module, method: "POST", data: data, 
			success: function(result){ 
				if (result.status) {
					Pace.bar.update(100); 
					setTimeout(function(){
						col = []; row = [];
						col.push("<br><br>");
						col.push(result.message);
						col.push("<br><br>");
						col.push(BSHelper.Button({ type:"button", label:"Close", cls:"btn-danger", onclick:"window.history.back();" }));
						row.push(subCol(12, col)); col = [];
						$("#step-importing-data").append(subRow(row).hide().fadeIn(1000));
						Pace.stop();
						window.open(result.file_url);
					}, 1000);
				} else {
					BootstrapDialog.alert(result.message);
					$(this).prop('disabled', false);
				}
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				$(this).prop('disabled', false);
				Pace.stop();
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});
		
		getProcess();
	});
	
	function getProcess() {
		$.ajax({ type: "GET",	url: $url_module,	data: { "get_process": 1 },
			success: function(result){
				if (result.status){
					if (result.data.percent < 100) {
						Pace.bar.update(result.data.percent); 
						getProcess();
					} 
				}
			}
		});
	}
	
</script>
<script src="{$.const.TEMPLATE_URL}plugins/SmartWizard/js/jquery.smartWizard.min.js"></script>
<script src="{$.const.ASSET_URL}js/import_data.js"></script>
