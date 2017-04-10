{var $url_module = $.php.base_url('systems/a_role_menu')}
{var $url_module_main = $.php.base_url('systems/a_role')}

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{$.const.ASSET_URL}js/form_edit.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	{* Get Params *}
	var x = getURLParameter("x");
	var role_id = getURLParameter("role_id");
	{* Start :: Init for Title, Breadcrumb *}
	{* Set status (new|edit|copy) to Page Title *}
	var desc = function(x){ if (x=='copy') return "(Copy Menu From Role...)"; };
	$(".content").before(BSHelper.PageHeader({ 
		title: "{$window_title}", 
		title_desc: "{$description}", 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"Role Access", link:"javascript:history.back()" },
			{ icon:"", title:"{$window_title}", link:"javascript:history.back()" },
			{ icon:"", title: desc(x), link:"" },
		]
	}));
	{* Additional for sub module *}
	$.getJSON('{$url_module_main}', { "id": (role_id==null)?-1:role_id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var code_name = ": "+result.data.rows[0].code_name;
			$('.content-header').find('h1').find('small').before(code_name);
		}
	});

	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	{* adding master key id *}
	col.push(BSHelper.Input({ type:"hidden", idname:"role_id", value:role_id }));
	col.push(BSHelper.Input({ type:"hidden", idname:"x", value:x }));
	{* standard fields table *}
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Combobox({ horz:false, label:"Please Choose Role to be copied !", idname:"copy_role_id", required:true, url:"{$.php.base_url('systems/a_role')}?filter=t1.id<>"+role_id, remote: true }));
	form1.append(subRow(subCol(6, col)));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	{* Form submit action *}
	form1.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		$.ajax({ url: "{$url_module}", method:"OPTIONS", async: true, dataType:'json',
			data: form1.serializeJSON(),
			success: function(data) {
				{* console.log(data); *}
				BootstrapDialog.alert(data.message, function(){
					window.history.back();
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