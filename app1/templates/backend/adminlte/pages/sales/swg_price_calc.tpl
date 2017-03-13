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

      <!-- Default box -->
      <div class="box">
        {* <div class="box-header with-border">
          <h3 class="box-title">Title</h3>
        </div> *}
				<div class="box-body">
					<!-- /.box-body -->
					{* <div class="box-footer"></div> *}
					<!-- /.box-footer-->
				</div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
	var contentForm = $('<form><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	var col_l = contentForm.find('div.col-left');
	var col_r = contentForm.find('div.col-right');
	function createForm(){
		col_l.append(BSHelper.ComboboxForm({ label:"Price List", idname:"pricelist_id", url:"{$.php.base_url('systems/c_currency')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		col_l.append(BSHelper.ComboboxForm({ label:"Size", idname:"swg_size_id", url:"{$.php.base_url('sales/e_swg_size')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		col_r.append(BSHelper.ComboboxForm({ label:"Size", idname:"swg_size_id", url:"{$.php.base_url('sales/e_swg_size')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		$('div.box-body').append(contentForm);
		contentForm.find('form').addClass('form-horizontal').attr('autocomplete', 'off');
	}
	
	createForm();
	
	{* From this line, the code can be change *}
	{* ====================================== *}
	var form = $('<form />', { class: 'form-horizontal', autocomplete: 'off' });
	function createForm1(){
		form.html('');
		form.append(BSHelper.Input({ type:"text", label:"Name", idname:"name", readonly:false, required: true, placeholder:"string(60)" }));
		form.append(BSHelper.TextArea({ label:"Description", idname:"description", placeholder:"string(2000)" }));
		form.append(BSHelper.Checkbox({ label:"Is Active", idname:"is_active" }));
		form.append(BSHelper.Checkbox({ label:"Is Can Export", idname:"is_canexport" }));
		form.append(BSHelper.Checkbox({ label:"Is Can Report", idname:"is_canreport" }));
		form.append(BSHelper.Checkbox({ label:"Is Can Approved Own Doc", idname:"is_canapproveowndoc" }));
		form.append(BSHelper.Checkbox({ label:"Is Access All Orgs", idname:"is_accessallorgs" }));
		form.append(BSHelper.Checkbox({ label:"Is Use User Org Access", idname:"is_useuserorgaccess" }));
		form.append(BSHelper.Combobox({ label:"Currency", idname:"currency_id", url:"{$.php.base_url('systems/c_currency')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		form.append(BSHelper.Combobox({ label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		return form;
	}
			{* $.ajax({ url: '',method: "GET",dataType: 'json', *}
				{* data: '{"skin": "'+$(this).data('skin')+'"}' *}
			{* }); *}
</script>