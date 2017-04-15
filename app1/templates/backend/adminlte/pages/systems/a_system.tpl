<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			{$title}
			<small>{$title_desc}</small>
		</h1>
	</section>
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
	var $url_module = "{$.php.base_url()~$class~'/'~$method}";
	var a=[];	var col = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = $('<div class="box"><div class="box-header"></div><div class="box-body"></div><div class="box-footer"></div></div>');
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
				a.push(BSHelper.Combobox({ label:"Date Format", idname:"date_format", required: true, 
					list:[
						{ id:"dd/mm/yyyy", name:"dd/mm/yyyy" },
						{ id:"mm/dd/yyyy", name:"mm/dd/yyyy" },
						{ id:"dd-mm-yyyy", name:"dd-mm-yyyy" },
						{ id:"mm-dd-yyyy", name:"mm-dd-yyyy" },
					] 
				}));
				a.push(BSHelper.Combobox({ label:"Time Format", idname:"time_format", required: true, 
					list:[
						{ id:"hh:mm", name:"hh:mm" },
						{ id:"hh:mm:ss", name:"hh:mm:ss" },
					] 
				}));
				a.push(BSHelper.Combobox({ label:"DateTime Format", idname:"datetime_format", required: true, 
					list:[
						{ id:"dd/mm/yyyy hh:mm", name:"dd/mm/yyyy hh:mm" },
						{ id:"mm/dd/yyyy hh:mm", name:"mm/dd/yyyy hh:mm" },
						{ id:"dd-mm-yyyy hh:mm", name:"dd-mm-yyyy hh:mm" },
						{ id:"mm-dd-yyyy hh:mm", name:"mm-dd-yyyy hh:mm" },
					] 
				}));
				a.push(BSHelper.Input({ type:"text", label:"User Photo Path", idname:"user_photo_path", required: true, placeholder:"string(200)" }));
				col.push(subCol(6, a));
				return subRow(col);
			} },
			{	title:"Email Setup", idname:"tab-eml", content:function(){
				a = []; col = [];
				a.push(BSHelper.Input({ type:"text", label:"SMTP Host", idname:"smtp_host", }));
				a.push(BSHelper.Combobox({ label:"SMTP Port", idname:"smtp_port", 
					list:[
						{ id:"25", name:"25" },
						{ id:"465", name:"465" },
					] 
				}));
				a.push(BSHelper.Input({ type:"text", label:"SMTP User", idname:"smtp_user", }));
				a.push(BSHelper.Input({ type:"password", label:"SMTP Password", idname:"smtp_pass", }));
				a.push(BSHelper.Combobox({ label:"SMTP Timeout", idname:"smtp_timeout", 
					list:[
						{ id:"5", name:"5" },
						{ id:"6", name:"6" },
						{ id:"7", name:"7" },
						{ id:"8", name:"8" },
						{ id:"9", name:"9" },
						{ id:"10", name:"10" },
					] 
				}));
				col.push(subCol(6, a)); a=[];
				a.push(BSHelper.Combobox({ label:"Charset", idname:"charset", 
					list:[
						{ id:"iso-8859-1", name:"iso-8859-1" },
						{ id:"utf-8", name:"utf-8" },
					] 
				}));
				a.push(BSHelper.Combobox({ label:"Mail Type", idname:"mailtype", 
					list:[
						{ id:"html", name:"html" },
						{ id:"text", name:"text" },
					] 
				}));
				a.push(BSHelper.Combobox({ label:"Priority", idname:"priority", 
					list:[
						{ id:"1", name:"Highest" },
						{ id:"3", name:"Normal" },
						{ id:"5", name:"Lowest" },
					] 
				}));
				a.push(BSHelper.Combobox({ label:"Protocol", idname:"protocol", 
					list:[
						{ id:"mail", name:"mail" },
						{ id:"smtp", name:"smtp" },
						{ id:"sendmail", name:"sendmail" },
					] 
				}));
				col.push(subCol(6, a));
				return subRow(col);
			} },
		],
	});
	{* box1.find('.box-body').append(tabContent); *}
	form1.append(tabContent);
	
	{* Button *}
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Save", cls:"btn-primary" }) );
	{* box1.find('.box-footer').append(a); *}
	form1.append(a);
	
	{* form1.append(box1); *}
	$(".content").append(form1);
	
	{* Begin: Populate data to form *}
	$.getJSON($url_module, '', function(result){ 
		if (!isempty_obj(result.data.rows)) 
			form1.shollu_autofill('load', result.data.rows[0]);  
	});
	{* End: Populate data to form *}
	
	{* Event *}
	
	{* Form submit action *}
	form1.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		form1.find("[type='submit']").prop( "disabled", true );
		
		$.ajax({ url: $url_module, method:"PUT", async: true, dataType:'json',
			data: form1.serializeJSON(),
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert(data.message);
				form1.find("[type='submit']").prop( "disabled", false );
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