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
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<style>
#img-preview canvas{
	border-radius: 50%;
	padding: 3px;
	border: 3px solid #d2d6de;
	margin-bottom: 13px;
}
</style>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)}, auto_populate = false;
	{* Get Params *}
	var $id = getURLParameter("id"), $act = getURLParameter("action");
	var r_method = $.inArray($act, ['new','cpy']) > -1 ? 'POST' : 'PUT';
	{* var act_name = ($act == 'new') ? "(New)" : (act == 'edt') ? "(Edit)" : (act == 'cpy') ? "(Copy)" : act; *}
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	var req = ($act == 'new') ? true : ($act == 'edt') ? false : true;
	col.push(BSHelper.Input({ type:"hidden", idname:"photo_file" }));
	col.push( $('<div id="img-preview" style="text-align:center;width:100%;" />') );
	col.push( $('<img class="profile-user-img img-responsive img-circle" src="{$.php.base_url()}upload/images/default-photo.png" style="width:150px; height:150px; margin-bottom:13px;" alt="Picture" />') );
	col.push( $('<div style="text-align:center;width:100%;" />')
		{* .append( $('<img id="btn_uploadphoto" class="profile-user-img img-responsive img-circle" style="width:150px; margin-bottom:13px; cursor:pointer; cursor:hand;" title="Upload Photo" alt="User Picture" />') ) *}
		.append( BSHelper.Button({ type:"button", label:"Insert Picture", idname:"btn_uploadphoto" }) ) 
		{* .append( '&nbsp;&nbsp;&nbsp;' )  *}
		{* .append( BSHelper.Button({ type:"button", label:"Generate Image", idname:"btn_generatephoto",  *}
			{* onclick:"$.ajax({  *}
				{* url:$url_module, *}
				{* data: JSON.stringify({ genphoto:1, id:id, name:$('#name').val(), photo_file:$('#photo_file').val() }), *}
				{* method:'PUT', async: true, dataType:'json',  *}
				{* success: function(data){	 *}
					{* if (data.status) {  *}
						{* $('img.profile-user-img').attr('src', data.file_url); *}
						{* $('#photo_file').val(data.photo_file); *}
					{* } *}
				{* } *}
			{* });"  *}
		{* }) )  *}
	);
	col.push(BSHelper.Input({ horz:false, type:"text", label:"User Name", idname:"name", required: true, placeholder:"string(60)", }));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password", required: req, placeholder:"Password", minlength:6, help:"Minimum of 6 characters" })));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_confirm", required: req, placeholder:"Confirm", idmatch:"password", errormatch:"Whoops, these don't match" })));
	col.push(BSHelper.Label({ horz:false, label:"Password", idname:"password", required: req, elcustom:subRow(a) }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Input({ horz:false, type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Full BP Access", idname:"is_fullbpaccess" }));
	col.push(BSHelper.Combobox({ horz:false, label:"Role (Default)", idname:"user_role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}?filter=user_id="+$id, remote: true }) );
	col.push(BSHelper.Combobox({ horz:false, label:"Organization (Default)", idname:"user_org_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_org')}?filter=user_id="+$id, remote: true }) );
	col.push(BSHelper.Combobox({ horz:false, label:"Supervisor", label_link:"{$.const.PAGE_LNK}?pageid=20", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", remote: true }));
	row.push(subCol(6, col)); col = [];
	form1.append(subRow(row));
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5",
		filters: { max_file_size: "{$.session.max_file_upload}", mime_types: [{ title:"Image files", extensions:"jpg,gif,png" }] },
		browse_button: "btn_uploadphoto", 
		multi_selection: false,
		multipart_params: { "userphoto":1, "id": $id },
		init: {
			FilesAdded: function(up, files) {
				{* uploader.start(); *}
				console.log(up.files.length);
				
				{* up.setOption('http_method', r_method); *}
				
				if(uploader.files.length > 1)
				{
					$('#img-preview canvas')[0].remove();
					uploader.removeFile(uploader.files[0]);
					uploader.refresh();
				} else {
					$('.profile-user-img').hide();
				}
				plupload.each(files, function(file) {
					var img = new mOxie.Image();
					img.onload = function() {
						this.embed($('#img-preview').get(0), {
								width: 150,
								height: 150,
								crop: false
						}).unbind( "click" );
					};
					img.load(file.getSource());
				});
			},
			FileUploaded: function(up, file, info) {
				var response = $.parseJSON(info.response);
				BootstrapDialog.alert(response.message, function(){
					window.history.back();
				});
				{* var response = $.parseJSON(info.response); *}
				{* console.log(response.file_url); *}
				{* if (response.status) {  *}
					{* $('img.profile-user-img').attr('src', response.file_url); *}
					{* $('#photo_file').val(response.photo_file); *}
				{* } *}
			},
			Error: function(up, err) {
				console.log(err);
				var msg = '';
				if (err.code == -600 )
					msg = 'Error: Maximal file size is '+up.settings.filters.max_file_size;
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:msg });
			}
		}
	});
	uploader.bind('BeforeUpload', function(uploader, file) {
		uploader.settings.multipart_params = { "userphoto":1, "id": $id };
	});
	uploader.init();

	{* Begin: Populate data to form *}
	{* $("img.profile-user-img").css("display", "none"); *}
	$.getJSON($url_module, { "id": ($id==null)?-1: $id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var photo_file = result.data.rows[0]['photo_file'];
			if (photo_file) {
				{* $("img.profile-user-img").css("display", ""); *}
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.user_photo_path}"+photo_file);
			}
			form1.shollu_autofill('load', result.data.rows[0]);  
		}
	});
	
	form1.validator().on('submit', function(e) {
		if (e.isDefaultPrevented()) { return false;	} 
		
		{* adding primary key id on the fly *}
		form1.append(BSHelper.Input({ type:"hidden", idname:"id", value:$id }));
		
		form1.find("[type='submit']").prop( "disabled", true );
		
		$.ajax({ url: $url_module, method: r_method, async: true, dataType:'json',
			data: form1.serializeJSON(),
			success: function(data) {
				if (r_method == 'POST') {
					console.log(data.id);
					$id = data.id;
				}
				if (uploader.files.length > 0) {
					uploader.start();
				} else {
					BootstrapDialog.alert(data.message, function(){
						window.history.back();
					});
				}
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				form1.find("[type='submit']").prop( "disabled", false );
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});

		return false;
	});

</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
