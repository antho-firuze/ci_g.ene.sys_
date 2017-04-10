{var $url_module = $.php.base_url('systems/x_chgpwd')}

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script>
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		title:"{$title}", 
		title_desc:"{$title_desc}", 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"{$title}", link:"" },
		]
	}));

	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Input({ type:"text", label:"User Name", idname:"name", readonly: true, placeholder:"string(60)" }));
	col.push(BSHelper.Input({ type:"password", label:"Old Password", idname:"password", required: true, placeholder:"Old Password" }));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_new", required: true, placeholder:"New Password", minlength:6, help:"Minimum of 6 characters" })));
	a.push(subCol(6, BSHelper.Input({ type:"password", label:"", idname:"password_confirm", required: true, placeholder:"Confirm", idmatch:"password_new", errormatch:"Whoops, these don't match" })));
	col.push(BSHelper.Label({ horz:false, label:"New Password", idname:"password_new", required: true, elcustom:subRow(a) }));
	form1.append(subRow(subCol(6, col)));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", cls:"btn-primary" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);
	
	{* Begin: Populate data to form *}
	$.getJSON('{$url_module}', '', function(result){ 
		if (!isempty_obj(result.data.rows)) 
			form1.shollu_autofill('load', result.data.rows[0]);  
	});
	{* End: Populate data to form *}
	
	{* Form submit action *}
	form1.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: '{$url_module}', method:"PUT", async: true, dataType:'json',
			data: JSON.stringify({ "password_new": $("#password_new").val() }), 
			headers: { "X-AUTH": "Basic " + btoa($("#name").val() + ":" + $("#password").val())	},
			beforeSend: function(xhr) {	form1.find('[type="submit"]').attr("disabled", "disabled"); },
			complete: function(xhr, data) {
				setTimeout(function(){ form1.find('[type="submit"]').removeAttr("disabled");	},1000);
			},
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert('Password has beed changed !', function(){
					form1.shollu_autofill("reset");
					$.getJSON('{$url_module}', '', function(result){ 
						if (!isempty_obj(result.data.rows)) 
							form1.shollu_autofill('load', result.data.rows[0]);  
					});
        });
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				setTimeout(function(){ form1.find('[type="submit"]').removeAttr("disabled"); },1000);
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});

		return false;
	});
</script>