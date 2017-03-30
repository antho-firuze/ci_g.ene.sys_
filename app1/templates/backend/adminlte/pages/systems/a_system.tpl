{var $url_module = $.php.base_url('systems/a_system')}

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {$window_title}
        <small>{$description}</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/form-autofill/js/form-autofill.js"></script>
<script>
	var a=[];	var col = [];
	var formContent = $('<form "autocomplete"="off" />');
	var boxContent = $('<div class="box"><div class="box-header"></div><div class="box-body"></div><div class="box-footer"></div></div>');
	var tabContent = BSHelper.Tabs({
		dataList: [
			{	title:"General Setup", idname:"tab-gen", content:function(){
				a.push(BSHelper.Input({ type:"hidden", idname:"id" }));
				a.push(BSHelper.Input({ type:"text", label:"Code", idname:"code" }));
				a.push(BSHelper.Input({ type:"text", label:"Name", idname:"name", required: true }));
				a.push(BSHelper.Input({ type:"textarea", label:"Description", idname:"description" }));
				col.push(subCol(6, a)); a=[];
				a.push(BSHelper.Input({ type:"text", label:"Head Title", idname:"head_title", required: true }));
				a.push(BSHelper.Input({ type:"text", label:"Page Title", idname:"page_title", required: true }));
				a.push(BSHelper.Input({ type:"text", label:"Logo Text Mini", idname:"logo_text_mn", required: true, maxlength:3, placeholder:"string(3)" }));
				a.push(BSHelper.Input({ type:"text", label:"Logo Text Large", idname:"logo_text_lg", required: true, placeholder:"string(20)" }));
				col.push(subCol(6, a));
				return subRow(col);
			} },
			{	title:"Date & Time Setup", idname:"tab-dat", content:function(){
				a = []; col = [];
				{* a.push(BSHelper.Input({ type:"text", label:"Date Format", idname:"date_format", required: true, placeholder:"d/m/Y" })); *}
				a.push(BSHelper.Combobox({ label:"Date Format", idname:"date_format", required: true, list:[
					{ value:"dd/mm/yyyy", title:"dd/mm/yyyy" },
					{ value:"mm/dd/yyyy", title:"mm/dd/yyyy" },
					{ value:"dd-mm-yyyy", title:"dd-mm-yyyy" },
					{ value:"mm-dd-yyyy", title:"mm-dd-yyyy" },
				] }));
				a.push(BSHelper.Input({ type:"text", label:"Time Format", idname:"time_format", required: true, placeholder:"h:i:s" }));
				a.push(BSHelper.Input({ type:"text", label:"DateTime Format", idname:"datetime_format", required: true, placeholder:"d/m/Y h:i:s" }));
				a.push(BSHelper.Input({ type:"text", label:"User Photo Path", idname:"user_photo_path", required: true, placeholder:"string(200)" }));
				col.push(subCol(6, a));
				return subRow(col);
			} },
			{	title:"Email Setup", idname:"tab-eml", content:function(){
				a = []; col = [];
				a.push(BSHelper.Input({ type:"text", label:"SMTP Host", idname:"smtp_host", }));
				a.push(BSHelper.Input({ type:"number", label:"SMTP Port", idname:"smtp_port", }));
				a.push(BSHelper.Input({ type:"text", label:"SMTP User", idname:"smtp_user", }));
				a.push(BSHelper.Input({ type:"Password", label:"SMTP Password", idname:"smtp_pass", }));
				a.push(BSHelper.Input({ type:"number", label:"SMTP Timeout", idname:"smtp_timeout", }));
				col.push(subCol(6, a)); a=[];
				a.push(BSHelper.Input({ type:"text", label:"Charset", idname:"charset", }));
				a.push(BSHelper.Input({ type:"text", label:"Mail Type", idname:"mailtype", }));
				a.push(BSHelper.Input({ type:"number", label:"Priority", idname:"priority", }));
				a.push(BSHelper.Input({ type:"text", label:"Protocol", idname:"protocol", }));
				col.push(subCol(6, a));
				return subRow(col);
			} },
		],
	});
	{* boxContent.find('.box-body').append(tabContent); *}
	formContent.append(tabContent);
	
	{* Button *}
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Save", cls:"btn-primary" }) );
	{* boxContent.find('.box-footer').append(a); *}
	formContent.append(a);
	
	{* formContent.append(boxContent); *}
	$(".content").append(formContent);
	
	{* Begin: Populate data to form *}
	$.getJSON('{$url_module}', '', function(result){ 
		if (!isempty_obj(result.data.rows)) 
			formContent.xform('load', result.data.rows[0]);  
	});
	{* End: Populate data to form *}
	
	{* Form submit action *}
	formContent.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: '{$url_module}', method:"PUT", async: true, dataType:'json',
			data: formContent.serializeJSON(),
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert('Saving data successfully !', function(){
					{* window.history.back(); *}
        });
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

		return false;
	});
</script>