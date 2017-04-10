{var $url_module = $.php.base_url('systems/a_menu')}

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
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	{* Get Params *}
	var $url_module = "{$url_module}";
	var id = getURLParameter("id");
	var edit = getURLParameter("edit");
	{* Start :: Init for Title, Breadcrumb *}
	{* Set status (new|edit|copy) to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	$(".content").before(BSHelper.PageHeader({ 
		title:"{$window_title}", 
		title_desc: desc(edit), 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"{$window_title}", link:"javascript:history.back()" },
			{ icon:"", title: desc(edit), link:"" },
		]
	}));
	
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true, placeholder:"string(60)", }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", placeholder:"string(2000)" }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Parent", idname:"is_parent", value:0 }));
	col.push(BSHelper.Combobox({ horz:false, label:"Parent Menu", idname:"parent_id", url:"{$.php.base_url('systems/a_menu')}?filter=is_parent='1'", remote: true }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Icon", idname:"icon", placeholder:"string(60)" }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Sub Module", idname:"is_submodule", value:0 }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Table", idname:"url", placeholder:"string(60)" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Path", idname:"path", placeholder:"string(100)" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Class", idname:"class", placeholder:"string(60)" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Method", idname:"method", placeholder:"string(60)" }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Window Title", idname:"window_title", placeholder:"string(100)" }));
	row.push(subCol(6, col));
	form1.append(subRow(row));
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);
	
</script>