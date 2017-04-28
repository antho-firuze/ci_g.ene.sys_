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
				col.push(BSHelper.Button({ type:"button", label:"Select File", idname:"btn_selectfile" }));
				row.push(subCol(6, col)); col = [];
				row.push(subCol(6, col)); col = [];
				return subRow(row);
			} },
			{	title:"Import Data", idname:"step-3", content: function(){
				row = [];
				col.push(BSHelper.Button({ type:"button", label:"Select File", idname:"btn_selectfile" }));
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
			multipart_params: { "import":1, "step":1, "filetype": $("#filetype").shollu_cb("getValue") },
			init: {
				FilesAdded: function(up, files) {
					{* console.log(files); *}
					$("#filename").val(files[0].name);
					$("#filename").parent().find("small").html("");
					$("#btn_uploadfile").prop("disabled", false);
				},
				FileUploaded: function(up, file, info) {
					var response = $.parseJSON(info.response);
					console.log(response);
					if (response.status) { 
						$("#filename").parent().find("small").html("File Uploaded !");
						$("#btn_uploadfile").prop("disabled", true);
						$(".sw-btn-next").prop('disabled', false);
						paceOptions = {	ajax: false	};
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
		{* // Toolbar extra buttons *}
		var btnFinish = $('<button></button>').text('Finish')
			.addClass('btn btn-info')
			.on('click', function(){ alert('Finish Clicked'); });
		var btnCancel = $('<button></button>').text('Cancel')
			.addClass('btn btn-danger')
			.on('click', function(){ $(".smartwizard").smartWizard("reset"); });                         
		
		{* // Smart Wizard *}
		$(".smartwizard").smartWizard({ 
			selected: 0, 
			theme: 'arrows',
			transitionEffect:'fade',
			showStepURLhash: true,
			toolbarSettings: { 
				{* toolbarPosition: 'both', *}
				{* toolbarExtraButtons: [btnFinish, btnCancel] *}
			}
		});
		$(".sw-btn-next").prop('disabled', true);
		
		{* // Step show event  *}
		$(".smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
			 {* //alert("You are on step "+stepNumber+" now"); *}
			{* if(stepPosition === 'first'){
				$("#prev-btn").addClass('disabled');
			}else if(stepPosition === 'final'){
				$("#next-btn").addClass('disabled');
			}else{
				$("#prev-btn").removeClass('disabled');
				$("#next-btn").removeClass('disabled');
			} *}

			{* console.log(stepNumber); *}
			{* if (stepDirection == "forward" && stepNumber == 1){
			} *}
		});
		
	});
	
</script>
<script src="{$.const.TEMPLATE_URL}plugins/SmartWizard/js/jquery.smartWizard.min.js"></script>
<script src="{$.const.ASSET_URL}js/import_data.js"></script>
