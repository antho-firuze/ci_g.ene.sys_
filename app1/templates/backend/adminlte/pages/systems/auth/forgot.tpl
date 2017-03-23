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

</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href="{$.const.HOME_LINK}">{$page_title}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Please input user name & email address</p>

    <form>
      {* <div class="form-group has-feedback"> *}
        {* <span class="glyphicon glyphicon-user form-control-feedback"></span> *}
        {* <input type="text" class="form-control" placeholder="User Name" name="username" required> *}
      {* </div> *}
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <input type="text" class="form-control" placeholder="Email" name="email" required>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

	{if (isset($facebook) || isset($gplus))}
		<div class="social-auth-links text-center">
		  <p>- OR -</p>
		{if (isset($facebook))}
		  <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
			Facebook</a>
		{/if}
		{if (isset($gplus))}
		  <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
			Google+</a>
		{/if}
		</div>
	{/if}
    <!-- /.social-auth-links -->
	
    {* Click <a href="#">here</a> if you forgot your password, or back to <a href="{$.const.HOME_LNK}">frontend</a>.<br> *}
    {* <a href="register.html" class="text-center">Register a new membership</a> *}
	
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
	
	form.submit( function(e) {
		e.preventDefault();
		
		$.ajax({ url:"{$.const.AUTH_LNK}?forgot=1", method:"GET", async:true, dataType:'json',
			data: { "email":$("[name='email']").val() },
			beforeSend: function(xhr) { form.find('[type="submit"]').attr("disabled", "disabled"); },
			complete: function(xhr, data) {	setTimeout(function(){ form.find('[type="submit"]').removeAttr("disabled");	},1000); },
			success: function(data) {
				if (data.status) {
					BootstrapDialog.alert({ type:'modal-info', title:'Information', message:"We already send the link for reset your password !" });
					window.location.replace("{$.const.LOGIN_LNK}");
				}
			},
			error: function(data, status, errThrown) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				setTimeout(function(){ form.find('[type="submit"]').removeAttr("disabled"); },1000);
				BootstrapDialog.alert({ type:'modal-danger', title:'Error ('+data.status+') :', message:message });
			}
		});
	}); 
	
</script>
</body>
</html>
