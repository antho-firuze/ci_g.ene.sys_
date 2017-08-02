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
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $bread = {$.php.json_encode($bread)};
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info" });
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Code", idname:"code", required: false, }));
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Name", idname:"name", required: true, }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
	col.push(BSHelper.Checkbox({ horz:false, label:"Is Active", idname:"is_active", value:1 }));
	col.push(BSHelper.Combobox({ label:"Type", idname:"type", 
		list:[
			{ id:"BOX-3", name:"BOX-3" },
			{ id:"BOX-5", name:"BOX-5" },
			{ id:"BOX-7", name:"BOX-7" },
		] 
	}));
	row.push(subCol(6, col)); col = [];
	col.push(BSHelper.Input({ horz:false, type:"text", label:"Link", idname:"link", }));
	col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Query", idname:"query", }));
	col.push(BSHelper.Combobox({ label:"Icon", idname:"icon", 
		list:[
			{ id:"ion ion-cube", name:"cube" },
			{ id:"ion ion-document", name:"document" },
			{ id:"ion ion-document-text", name:"document-text" },
			{ id:"ion ion-person", name:"person" },
			{ id:"ion ion-person-stalker", name:"person-stalker" },
			{ id:"ion ion-leaf", name:"leaf" },
			{ id:"ion ion-speedometer", name:"speedometer" },
		] 
	}));
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Icon", idname:"icon", })); *}
	col.push(BSHelper.Combobox({ label:"Color", idname:"color", 
		list:[
			{ id:"bg-aqua", name:"aqua" },
			{ id:"bg-aqua-active", name:"aqua-active" },
			{ id:"bg-green", name:"green" },
			{ id:"bg-green-active", name:"green-active" },
			{ id:"bg-yellow", name:"yellow" },
			{ id:"bg-yellow-active", name:"yellow-active" },
			{ id:"bg-red", name:"red" },
			{ id:"bg-red-active", name:"red-active" },
			{ id:"bg-blue", name:"blue" },
			{ id:"bg-blue-active", name:"blue-active" },
			{ id:"bg-light-blue", name:"light-blue" },
			{ id:"bg-light-blue-active", name:"light-blue-active" },
			{* { id:"bg-navy", name:"navy" }, *}
			{* { id:"bg-navy-active", name:"navy-active" }, *}
			{* { id:"bg-teal", name:"teal" }, *}
			{* { id:"bg-teal-active", name:"teal-active" }, *}
			{* { id:"bg-olive", name:"olive" }, *}
			{* { id:"bg-olive-active", name:"olive-active" }, *}
			{* { id:"bg-lime", name:"lime" }, *}
			{* { id:"bg-lime-active", name:"lime-active" }, *}
			{* { id:"bg-orange", name:"orange" }, *}
			{* { id:"bg-orange-active", name:"orange-active" }, *}
			{* { id:"bg-fuchsia", name:"fuchsia" }, *}
			{* { id:"bg-fuchsia-active", name:"fuchsia-active" }, *}
			{* { id:"bg-purple", name:"purple" }, *}
			{* { id:"bg-purple-active", name:"purple-active" }, *}
			{* { id:"bg-maroon", name:"maroon" }, *}
			{* { id:"bg-maroon-active", name:"maroon-active" }, *}
			{* { id:"bg-black", name:"black" }, *}
			{* { id:"bg-black-active", name:"black-active" }, *}
		] 
	}));
	{* col.push(BSHelper.Input({ horz:false, type:"text", label:"Color", idname:"color", })); *}
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

</script>
<script src="{$.const.ASSET_URL}js/window_edit.js"></script>
