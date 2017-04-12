{var $url_module = $.php.base_url('web/w_page')}

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/ckeditor/ckeditor.js"></script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	{* Get Params *}
	var $url_module = "{$url_module}";
	var id = getURLParameter("id");
	var edit = getURLParameter("edit");
	var auto_populate = false;
	{* Start :: Init for Title, Breadcrumb *}
	{* Set status (new|edit|copy) to Page Title *}
	var desc = function(edit){ if (edit==1) return "(Edit)"; else if (edit==2) return "(New)"; else return "(Copy)"; };
	$(".content").before(BSHelper.PageHeader({ 
		title:"{$title}", 
		title_desc: desc(edit), 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"{$title}", link:"javascript:history.back()" },
			{ icon:"", title: desc(edit), link:"" },
		]
	}));
	
	{* For design form interface *}
	var col = [], row = [], a = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });	
	var box1 = BSHelper.Box({ type:"info" });
	var req = function(edit){ if (edit==1) return false; else if (edit==2) return true; else return true; };
	col.push(BSHelper.Input({ type:"hidden", idname:"id" }));
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true })); *}
	{* col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description" })); *}
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Title", idname:"title", required: true }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Title Desc", idname:"title_desc", ckeditor: true }));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	row.push(subCol(6, col)); col = [];
	a.push(subRow(row)); row = [];
	col.push(BSHelper.Input({ horz:false, type:"textarea", idname:"body_content" }));
	row.push(subCol(12, col)); col = [];
	a.push(subRow(row));
	form1.append(a);
	form1.append(subRow(subCol()));
	col = [];
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	col.push( '&nbsp;&nbsp;&nbsp;' );
	col.push( BSHelper.Button({ type:"button", label:"Cancel", cls:"btn-danger", idname:"btn_cancel", onclick:"window.history.back();" }) );
	form1.append( col );
	box1.find('.box-body').append(form1);
	$(".content").append(box1);
	
	$(document).ready(function(){
		CKEDITOR.replace('body_content');
		
		setTimeout(function(){
			$.getJSON($url_module, { "id": (id==null)?-1:id }, function(result){ 
				if (!isempty_obj(result.data.rows)) {
					form1.shollu_autofill('load', result.data.rows[0]);  
					CKEDITOR.instances['body_content'].setData(result.data.rows[0].body_content);
				}
			});
		}, 200)
	});
	
	$('form').on('submit', function(){
		CKEDITOR.instances.body_content.updateElement();
	});
	
</script>