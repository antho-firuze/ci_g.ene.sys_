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
				<form role="form">
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Price List</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">Material (JAN 2017)</option>
									</select>
								</div>
								{* <div class="form-group">
									<label>Type</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">Standard</option>
										<option>Non Standard</option>
									</select>
								</div> *}
								<div class="form-group">
									<label>Size</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">NON STANDARD</option>
										<option>1/2</option>
										<option>3/4</option>
									</select>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>D1</label>
											<div class="input-group">
												<input type="text" class="form-control">
												<span class="input-group-addon">mm</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>D2</label>
											<div class="input-group">
												<input type="text" class="form-control">
												<span class="input-group-addon">mm</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>D3</label>
											<div class="input-group">
												<input type="text" class="form-control">
												<span class="input-group-addon">mm</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>D4</label>
											<div class="input-group">
												<input type="text" class="form-control">
												<span class="input-group-addon">mm</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Class</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">150</option>
										<option>300</option>
									</select>
								</div>
								<div class="form-group">
									<label>Series</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">Serie A</option>
										<option>Serie B</option>
									</select>
								</div>
								<div class="form-group">
									<label>Quantity</label>
									<div class="input-group">
										<input type="text" class="form-control" value=1>
										<span class="input-group-addon">.00</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Material IR</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">304</option>
										<option>316</option>
									</select>
								</div>
								<div class="form-group">
									<label>Material OR</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">304</option>
										<option>316</option>
									</select>
								</div>
								<div class="form-group">
									<label>Material HOOP</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">304</option>
										<option>316</option>
									</select>
								</div>
								<div class="form-group">
									<label>Material FILLER</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">GRAPHITE</option>
										<option>PTFE</option>
										<option>MICA</option>
									</select>
								</div>
								<div class="form-group">
									<label>Branch</label>
									<select class="form-control select2" style="width: 100%;">
										<option selected="selected">Jakarta</option>
										<option>Surabaya</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
									<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<!-- /.box-footer-->
				</form>
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
		col_l.append(BSHelper.Combobox({ label:"Price List", idname:"pricelist_id", url:"{$.php.base_url('systems/c_currency')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		$('div.box-body').append(contentForm);
		contentForm.find('form').addClass('form-horizontal').attr('autocomplete', 'off');
	}
	
	{* createForm(); *}
	
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