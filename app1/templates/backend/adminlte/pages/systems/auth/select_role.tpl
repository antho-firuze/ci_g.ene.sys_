{* 
	Template Name: AdminLTE 
	Modified By: Firuze
	Email: antho.firuze@gmail.com
	Github: antho-firuze
*}
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>{$head_title}</title>

{$.php.link_tag('favicon.ico', 'shortcut icon', 'image/ico')}
{$.php.link_tag($.const.TEMPLATE_URL~'bootstrap/css/bootstrap.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'font-awesome/css/font-awesome.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/ionicons/css/ionicons.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'dist/css/AdminLTE.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'dist/css/skins/_all-skins.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'css/custom.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/pace/pace.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/iCheck/square/blue.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/bootstrap-dialog/css/bootstrap-dialog.min.css')}

<script src="{$.const.ASSET_URL}js/common.func.js"></script>
<script>
	{* DECLARE VARIABLE *}
</script>
<script src="{$.const.TEMPLATE_URL}plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="{$.const.TEMPLATE_URL}bootstrap/js/bootstrap.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/pace/pace.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/iCheck/icheck.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.ASSET_URL}js/common.extend.func.js"></script>
<script src="{$.const.ASSET_URL}js/bootstrap.helper.js"></script>

</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href="{$.const.HOME_LINK}">{$page_title}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Select Role</p>

    <form>
			<div class="form-group">
				<label class="control-label" for="user_role_id">Role</label>
				<div class="control-input">
					<input type="text" class="form-control" placeholder="Select Role" id="user_role_id" name="user_role_id" required>
					<small class="form-text text-muted help-block with-errors"></small>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="user_org_id">Organization/Company</label>
				<div class="control-input">
					<input type="text" class="form-control" placeholder="Select Organization" id="user_org_id" name="user_org_id" required>
					<small class="form-text text-muted help-block with-errors"></small>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="user_orgtrx_id">Location</label>
				<div class="control-input">
					<input type="text" class="form-control" placeholder="Select Location" id="user_orgtrx_id" name="user_orgtrx_id" required>
					<small class="form-text text-muted help-block with-errors"></small>
				</div>
			</div>
			<br>
      <div class="row">
        <div class="col-md-6">
          <div class="checkbox icheck">
            <label>
              {* <input type="checkbox" name="remember"> Remember Me *}
              {* <input type="hidden" name="remember" value=0 > *}
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <button type="submit" class="btn btn-primary btn-flat">Submit</button>
					&nbsp;
          <button type="button" id="btn-cancel" class="btn btn-danger btn-flat">Cancel</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div style="position: fixed; bottom: 0; width: 100%;">
	Server [<strong>{$elapsed_time}</strong>] - Client [<strong>{microtime(true)-$start_time}</strong>]
</div>

<script>
	var form = $("form");
	$(document).ajaxStart(function() { Pace.restart(); });
	var user = "{$.session.user_id}" != "" ? "user_id={$.session.user_id}" : "";
	
	if (user == "")
		window.location.replace("{$.const.LOGOUT_LNK}");
		
	$("#user_role_id").shollu_cb({ url:"{$.php.base_url('systems/a_user_role')}?identify=1&filter="+user, idField:"role_id", textField:"code_name", emptyMessage:"<center><b>No results were found</b></center>", remote:true, });
	$("#user_org_id").shollu_cb({ url:"{$.php.base_url('systems/a_user_org')}?identify=1&filter="+user, idField:"org_id", textField:"code_name", emptyMessage:"<center><b>No results were found</b></center>", remote:true, 
		onSelect: function(rowData){
			$("#user_orgtrx_id").shollu_cb("setValue", "");
			$("#user_orgtrx_id").shollu_cb({ url:"{$.php.base_url('systems/a_user_orgtrx')}?identify=1&filter="+user+",parent_id="+rowData.id, idField:"org_id", textField:"code_name", emptyMessage:"<center><b>No results were found</b></center>", remote:true, });
		},
	});
	$("#user_orgtrx_id").shollu_cb({ url:"{$.php.base_url('systems/a_user_orgtrx')}?identify=1&filter=user_id=0", idField:"org_id", textField:"code_name", emptyMessage:"<center><b>No results were found</b></center>", remote:true, });
	
	$("#btn-cancel").on("click", function(){ window.location.replace("{$.const.LOGOUT_LNK}"); });
	
	form.submit( function(e) {
		e.preventDefault();
		
		{* console.log(form.serializeJSON()); return false; *}
		
		form.find('[type="submit"]').attr("disabled", "disabled");
		form.append(BSHelper.Input({ type:"hidden", idname:"identify", value:1 }));
		
		$.ajax({ url:"{$.const.ROLE_SELECTOR_LNK}", method:"PATCH", async:true, dataType:'json',
			data: form.serializeJSON(),
			success: function(data) {
				if (data.status) {
					var url = window.location.href;
					$.getJSON('{$.const.RELOAD_LNK}', '', function(data){ window.location.replace(url); });
				}
			},
			error: function(data, status, errThrown) {
				if (data.status >= 500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				{* setTimeout(function(){ form.find('[type="submit"]').removeAttr("disabled"); },1000); *}
				form.find("[type='submit']").prop( "disabled", false );
				BootstrapDialog.show({ type:'modal-danger', title:'Error ('+data.status+') :', message:message, buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); } }] });
			}
		});
	}); 
	
</script>
</body>
</html>
