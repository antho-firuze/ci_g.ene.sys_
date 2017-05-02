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
			{	title:"Select & Upload File", idname:"step-1", content: function(){
				row = [];
				col.push(BSHelper.Combobox({ label:"File Type", idname:"filetype", required: true, value: 'csv',
					list:[
						{ id:"xls", name:"Excel File (.xls)" },
						{ id:"csv", name:"Comma Separated Values File (.csv)" },
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
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
			{	title:"Mapping Fields", idname:"step-2", content: function(){
				row = [];
				col.push("Session Failed !<br><br>");
				col.push(BSHelper.Button({ type:"button", label:"Reset Process", idname:"btn_reset" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
			{	title:"Import Data", idname:"step-3", content: function(){
				row = [];
				col.push("Session Failed !<br><br>");
				col.push(BSHelper.Button({ type:"button", label:"Reset Process", idname:"btn_reset" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
		],
	});
	form1.append(SWContent);
	
	{* Event on change filetype *}
	var filetype = [{ title:"CSV files", extensions:"csv" }];
	$("#filetype").shollu_cb({
		onSelect: function(rowData){
			if (rowData.id == 'xls')
				filetype = [{ title:"Excel files", extensions:"xls" }];
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
		paceOptions = {	ajax: true };
		Pace.restart();
		uploader.start();
	});
	
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
		
		uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5",
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
						$("#filename").parent().find("small").html("File Uploaded !");
						
						set_step2(response.table_fields, response.tmp_fields);
						
						setTimeout(function(){
							$("#btn_uploadfile").prop("disabled", true);
							$(".smartwizard").smartWizard("next");
							paceOptions = {	ajax: false	};
						}, 500);
					}
				},
				Error: function(up, err) {
					console.log('Plupload Error');
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
	
	function set_step2(fields, tmp_fields){
		var form2 = BSHelper.Form({ autocomplete:"off", idname:"form-2" });	
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
		col.push(BSHelper.Button({ type:"submit", label:"Submit" }));
		row.push(subCol(6, col)); col = [];
		$("#step-2").empty();
		$("#step-2").append(form2.append(subRow(row)));
		
		form2.validator().on('submit', function(e) {
			if (e.isDefaultPrevented()) { return false;	} 
			
			$(".smartwizard").smartWizard("next");
			set_step3();
			return false;
		});
	}
	
	function set_step3(){
		row = []; col = [];
		col.push(BSHelper.Button({ type:"button", label:"Start Import", idname:"btn_startimport" }));
		row.push(subCol(12, col)); col = [];
		$("#step-3").empty();
		$("#step-3").append(subRow(row));
		
		$("#btn_startimport").click(function(e){
			e.stopPropagation();
			
			var data = $("#form-2").serializeOBJ();
			data = { import:1, step:2, pageid:$pageid, filter:$filter, ob:$ob, filetype:$("#filetype").shollu_cb("getValue"), importtype:$("#importtype").shollu_cb("getValue"), fields:data };
			
			{* $(this).prop('disabled', true); *}
			
			console.log('Importing on progress...');
			paceOptions = {	ajax: true };
			Pace.restart();
			
			$.ajax({ url: $url_module, method: "POST", data: data, 
				success: function(result){ 
					if (!result.status) {
						BootstrapDialog.alert(result.message);
						$(this).prop('disabled', false);
					} else {

						setTimeout(function(){
							col.push("<br><br>");
							col.push(result.message);
							col.push("<br><br>");
							col.push(BSHelper.Button({ type:"button", label:"Close", onclick:"window.history.back();" }));
							row.push(subCol(12, col)); col = [];
							$("#step-3").append(subRow(row).hide().fadeIn(1000));
							window.open(result.file_url);
						}, 1000);
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
					BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});
			paceOptions = {	ajax: false };

		});
	}
	
</script>
<script src="{$.const.TEMPLATE_URL}plugins/SmartWizard/js/jquery.smartWizard.min.js"></script>
<script src="{$.const.ASSET_URL}js/import_data.js"></script>
