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
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	{* Get Params *}
	var $url_module = "{$url_module}";
	var id = getURLParameter("id");
	var edit = getURLParameter("edit");
	var role_id = getURLParameter("role_id");
	{* Start :: Init for Title, Breadcrumb *}
	{* Set status (new|edit|copy) to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	$(".content").before(BSHelper.PageHeader({ 
		title: "{$title}", 
		title_desc: desc(edit), 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"Role Access", link:"javascript:history.back()" },
			{ icon:"", title:"{$title}", link:"javascript:history.back()" },
			{ icon:"", title: desc(edit), link:"" },
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
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	{* adding master key id *}
	col.push(BSHelper.Input({ type:"hidden", idname:"role_id", value:role_id }));
	{* standard fields table *}
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Combobox({ horz:false, label:"Menu", idname:"menu_id", url:"{$.php.base_url('systems/a_menu')}?filter=is_active='1',type<>'G'&ob=name", remote: true }));
	col.push(BSHelper.Combobox({ label:"Type", idname:"type", disabled: true, 
		list:[
			{ id:"G", name:"GROUP" },
			{ id:"F", name:"FORM" },
			{ id:"P", name:"PROCESS/REPORT" },
			{ id:"W", name:"WINDOW" },
		] 
	}));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Combobox({ horz:false, label:"Allow", idname:"permit_window", remote: false, 
		list:[
			{ id:"1", name:"Only Create" },
			{ id:"2", name:"Only Edit" },
			{ id:"3", name:"Only Delete" },
			{ id:"4", name:"Can Create & Edit" },
			{ id:"5", name:"Can Create & Delete" },
			{ id:"6", name:"Can Edit & Delete" },
			{ id:"7", name:"Can All" },
		] 
	}));
	col.push(BSHelper.Combobox({ horz:false, label:"Allow", idname:"permit_form", remote: false, 
		list:[
			{ id:"1", name:"Execute" },
		] 
	}));
	col.push(BSHelper.Combobox({ horz:false, label:"Allow", idname:"permit_process", remote: false, 
		list:[
			{ id:"1", name:"Execute" },
		] 
	}));
	form1.append(subRow(subCol(6, col)));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);

	{* Event *}
	$("#menu_id").shollu_cb({
		onSelect: function(rowData){
			$("#type").shollu_cb('setValue', rowData.type);
			hidden_permission_box();
			if (rowData.type == 'F')
				$("#permit_form").closest(".form-group").css("display", "");
			if (rowData.type == 'P')
				$("#permit_process").closest(".form-group").css("display", "");
			if (rowData.type == 'W')
				$("#permit_window").closest(".form-group").css("display", "");
		},
		onChange: function(rowData){
			{* console.log(rowData); *}
			hidden_permission_box();
			if (rowData.type == 'F')
				$("#permit_form").closest(".form-group").css("display", "");
			if (rowData.type == 'P')
				$("#permit_process").closest(".form-group").css("display", "");
			if (rowData.type == 'W')
				$("#permit_window").closest(".form-group").css("display", "");
		}
	});
	
	function hidden_permission_box(){
		$("#permit_form").closest(".form-group").css("display", "none");
		$("#permit_process").closest(".form-group").css("display", "none");
		$("#permit_window").closest(".form-group").css("display", "none");
	}
	
	$(document).ready(function(){
		hidden_permission_box();
	});
	
</script>