<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $class = "{$class}", $method = "{$method}", $bread = {$.php.json_encode($bread)};
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Combobox({ label:"File Type", idname:"filetype", required: true, value: 'csv',
		list:[
			{ id:"xls", name:"Excel File (.xls)" },
			{ id:"csv", name:"Comma Separated Values File (.csv)" },
		] 
	}));
	col.push(BSHelper.Button({ type:"button", label:"Select File", idname:"btn_selectfile" }));
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

	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5",
		filters: { max_file_size: "{$.session.max_file_upload}", mime_types: [{ title:"CSV files", extensions:"csv" }] },
		browse_button: "btn_selectfile", 
		multi_selection: false,
		{* multipart_params: { "userphoto":1, "id":id, "photo_file":$('#photo_file').val() }, *}
		multipart_params: {  },
		init: {
			FilesAdded: function(up, files) {
				{* uploader.start(); *}
			},
			FileUploaded: function(up, file, info) {
				var response = $.parseJSON(info.response);
				console.log(response.file_url);
				if (response.status) { 
					$('img.profile-user-img').attr('src', response.file_url);
					$('#photo_file').val(response.photo_file);
				}
			},
			Error: function(up, err) {
				document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
			}
		}
	});
	uploader.bind('BeforeUpload', function(uploader, file) {
		{* uploader.settings.multipart_params = { "userphoto":1, "id":id, "photo_file":$('#photo_file').val() }; *}
		uploader.settings.multipart_params = {  };
	});
	uploader.init();
	
</script>
<script src="{$.const.ASSET_URL}js/import_data.js"></script>
