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
<script src="{$.const.TEMPLATE_URL}plugins/input-mask/jquery.inputmask.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/plupload/js/plupload.full.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/plupload/js/moxie.min.js"></script> *}
{* <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.0/plupload.min.js"></script> *}

<style>
#img-preview canvas{
	border-radius: 50%;
	padding: 3px;
	border: 3px solid #d2d6de;
	margin-bottom: 13px;
}
</style>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)};
	var $id = getURLParameter("id"), $act = getURLParameter("action");
	var r_method = $.inArray($act, ['new','cpy']) > -1 ? 'POST' : 'PUT';
		
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var form2 = BSHelper.Form({ autocomplete:"off" });
	var form3 = BSHelper.Form({ autocomplete:"off" });
	var form4 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info", header:false, toolbtn:['min','rem'] });
	
	col.push( $('<div style="text-align:center;width:100%;" />') );
	col.push( $('<div id="img-preview" style="text-align:center;width:100%;" />') );
	col.push( $('<img class="profile-user-img img-responsive img-circle" src="{$.php.base_url()}upload/images/default-photo.png" style="width:150px; height:150px; margin-bottom:13px;" alt="Picture" />') );
	{* col.push( $('<h3 class="profile-username text-center">{$.session.user_name}</h3>') );  *}
	{* col.push( $('<p class="text-muted text-center">{$.session.user_description}</p>') );  *}
	col.push( $('<ul class="list-group list-group-unbordered" />')
		.append( $('<li class="list-group-item" />').append( $('<b>Credit Limit</b><a class="credit-limit pull-right">0</a>') ))
		.append( $('<li class="list-group-item" />').append( $('<b>Credit Used</b><a class="credit-used pull-right">0</a>') ))
  );
	col.push( BSHelper.Button({ type:"button", label:"Insert Picture", idname:"btn_uploadphoto", style:"width:100%;" }) ); 
	form1.append(subRow(subCol(12, col)));
	box1.find('.box-body').append(subRow(subCol(12, col)));
	
	var tab1 = BSHelper.Tabs({
		dataList: [
			{	title:"Personal", idname:"tab-personal", 
				content:function(){
					col = [], row = [], a = [];
					col.push(BSHelper.Input({ horz:false, type:"text", label:"Code", idname:"code", required: false, }));
					col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: false, }));
					col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
					row.push(subCol(6, col)); col = [];
					col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
					col.push(BSHelper.Checkbox({ horz:false, label:"Is Sales Representative", idname:"is_salesrep", value:0 }));
					row.push(subCol(6, col)); col = [];
					a.push(subRow(row)); col = []; row = [];
					row.push(subCol(6, col)); col = [];
					row.push(subCol(6, col)); col = [];
					a.push(subRow(row)); col = []; row = [];
					return a;
				} 
			},
			{	title:"Contact", idname:"tab-contact", 
				content:function(){
					col = [], row = [], a = [];
					col.push(BSHelper.Input({ type:"text", label:"Email", idname:"email", required: false }));
					col.push(BSHelper.Input({ horz:false, type:"text", label:"Phone", idname:"phone", required: false, }));
					col.push(BSHelper.Input({ horz:false, type:"text", label:"Fax", idname:"fax", required: false, }));
					col.push(BSHelper.Input({ horz:false, type:"text", label:"Website", idname:"website", required: false, }));
					row.push(subCol(6, col)); col = [];
					row.push(subCol(6, col)); col = [];
					return subRow(row);
				} 
			},
			{	title:"Customer", idname:"tab-customer", 
				content:function(){
					col = [], row = [], a = [];
					col.push(BSHelper.Checkbox({ horz:false, label:"Is Prospect", idname:"is_prospect", value:0 }));
					col.push(BSHelper.Checkbox({ horz:false, label:"Is Customer", idname:"is_customer", value:0 }));
					col.push(BSHelper.Combobox({ horz:false, label:"Sales Representative", idname:"salesrep_id", url:"{$.php.base_url('bpm/c_bpartner')}", remote: true }));
					col.push(BSHelper.Combobox({ label:"Credit Status", idname:"so_creditstatus", required: false, 
						list:[
							{ id:"1", name:"Credit Hold" },
							{ id:"2", name:"Credit OK" },
							{ id:"3", name:"Credit Stop" },
							{ id:"4", name:"Credit Watch" },
							{ id:"5", name:"No Credit Check" },
						] 
					}));
					col.push(BSHelper.Input({ horz:false, type:"number", label:"Credit Limit", idname:"so_creditlimit", style: "text-align: right;", step: ".01", required: false, value: 0, placeholder: "0.00" }));
					row.push(subCol(6, col)); col = [];
					col.push(BSHelper.Combobox({ label:"Invoice Rule", idname:"invoice_rule", required: false, 
						list:[
							{ id:"AD", name:"After Delivery" },
							{ id:"AOD", name:"After Order Delivered" },
							{ id:"CSAD", name:"Customer Schedule after Delivery" },
							{ id:"I", name:"Immediate" },
						] 
					}));
					col.push(BSHelper.Combobox({ label:"Delivery Rule", idname:"delivery_rule", required: false, 
						list:[
							{ id:"AR", name:"After Receipt" },
							{ id:"A", name:"Availability" },
							{ id:"CL", name:"Complete Line" },
							{ id:"CO", name:"Complete Order" },
							{ id:"F", name:"Force" },
							{ id:"M", name:"Manual" },
						] 
					}));
					col.push(BSHelper.Combobox({ label:"Delivery Via", idname:"deliveryvia_rule", required: false, 
						list:[
							{ id:"D", name:"Delivery" },
							{ id:"P", name:"Pickup" },
							{ id:"S", name:"Shipper" },
						] 
					}));
					col.push(BSHelper.Input({ horz:false, type:"number", label:"Sales TOP (Days)", idname:"so_top", style: "text-align: right;", step: "1", min: "0", required: false, value: 0, placeholder: "0" }));
					row.push(subCol(6, col)); col = [];
					return subRow(row);
				} 
			},
			{	title:"Vendor", idname:"tab-vendor", 
				content:function(){
					col = [], row = [], a = [];
					col.push(BSHelper.Checkbox({ horz:false, label:"Is Vendor", idname:"is_vendor", value:0 }));
					col.push(BSHelper.Checkbox({ horz:false, label:"Is PO Tax Exempt", idname:"is_potaxexempt", value:0 }));
					row.push(subCol(6, col)); col = [];
					col.push(BSHelper.Input({ horz:false, type:"number", label:"Purchase TOP (Days)", idname:"po_top", style: "text-align: right;", step: "1", min: "0", required: false, value: 0, placeholder: "0" }));
					row.push(subCol(6, col)); col = [];
					return subRow(row);
				} 
			},
			{	title:"Finance & Taxes", idname:"tab-finance", 
				content:function(){
					col = [], row = [], a = [];
					col.push(BSHelper.Input({ horz:false, type:"text", label:"NPWP No", idname:"npwp_no", required: false, }));
					col.push(BSHelper.Input({ horz:false, type:"date", label:"NPWP Date", idname:"npwp_date", cls:"auto_ymd", format:"{$.session.date_format}" }));
					col.push(BSHelper.Input({ horz:false, type:"textarea", label:"NPWP Address", idname:"npwp_address", }));
					row.push(subCol(6, col)); col = [];
					a.push(subRow(row)); col = []; row = [];
					row.push(subCol(6, col)); col = [];
					row.push(subCol(6, col)); col = [];
					a.push(subRow(row)); col = []; row = [];
					return a;
				} 
			},
		],
	});
	
	col = []; row = []; a = [];
	col.push(subCol(3, box1));
	
	a.push( tab1 );
	a.push( BSHelper.Button({ type:"submit", label:"Submit", cls:"btn-primary", style:"margin-top:-10px; margin-bottom:10px;" }) );
	a.push( '&nbsp;&nbsp;&nbsp;' );
	a.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", style:"margin-top:-10px; margin-bottom:10px;", idname:"btn_cancel", onclick:"window.history.back();" }) );
	
	col.push(subCol(9, a)); 
	form1.append(col);
	
	row.push(subRow(form1)); col = [];
	row.push(subRow(col)); col = [];
	$(".content").append(row);
	
	$("[data-mask]").inputmask();
	
	{* INITILIZATION *}
	$("#company_id").shollu_cb({ 
		onSelect: function(rowData){
			var id = $("#company_id").shollu_cb('getValue', 'id');
			$("#branch_id")
				.shollu_cb({ queryParams: { "orgtype_id":3,"parent_id":id }})
				.shollu_cb('setValue', '');
			$("#department_id").shollu_cb('setValue', '');
			$("#division_id").shollu_cb('setValue', '');
		}
	});
	
	$("#branch_id").shollu_cb({ 
		onSelect: function(rowData){
			var id = $("#branch_id").shollu_cb('getValue', 'id');
			$("#department_id")
				.shollu_cb({ queryParams: { "orgtype_id":4,"parent_id":id }})
				.shollu_cb('setValue', '');
			$("#division_id").shollu_cb('setValue', '');
		}
	});
	
	$("#department_id").shollu_cb({ 
		onSelect: function(rowData){
			var id = $("#department_id").shollu_cb('getValue', 'id');
			$("#division_id")
				.shollu_cb({ queryParams: { "orgtype_id":5,"parent_id":id }})
				.shollu_cb('setValue', '');
		}
	});
	
	{* Init data for custom element (combogrid, button etc.) *}
	var uploader = new plupload.Uploader({ url: $url_module, runtimes:"html5",
		filters: { max_file_size: "2mb", mime_types: [{ title:"Image files", extensions:"jpg,gif,png" }] },
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
				{* console.log(response.file_url); *}
				{* if (response.status) {  *}
					{* $('img.profile-user-img').attr('src', response.data_uri); *}
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
	
	{* $.getJSON($url_module + '_photo', { "personnel_id": ($id==null)?-1:$id }, function(result){  *}
	$.getJSON($url_module, { "id": ($id==null)?-1:$id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var photo_file = result.data.rows[0].photo_file;
			if (photo_file) {
				{* console.log(result.data.rows[0].photo_binx); *}
				{* $('img.profile-user-img').attr('src', result.data.rows[0].photo_binx); *}
				$("img.profile-user-img").attr("src", "{$.const.BASE_URL~$.session.personnel_photo_path}"+photo_file);
			}
			$(".profile-status").text(accounting.toFixed(result.data.rows[0].profile_status, 2)+'%');
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
