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
<script src="{$.const.TEMPLATE_URL}plugins/js-cookie/js.cookie.js"></script>

</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href="{$.const.HOME_LINK}">{$page_title}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <input type="text" class="form-control" placeholder="User Name" name="username" required>
      </div>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Remember Me
              {* <input type="hidden" name="remember" value=0 > *}
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
	
    Click <a href="{$.const.FORGOT_LNK}">here</a> if you forgot your password, or back to <a href="{$.const.HOME_LNK}">frontend</a>.<br>
    {* <a href="register.html" class="text-center">Register a new membership</a> *}
	
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div style="position: fixed; bottom: 0; width: 100%;">
	Server [{$.php.get_dsn_host()}][<strong>{$elapsed_time}</strong>] - Client [<strong>{microtime(true)-$start_time}</strong>] - Your IP [<strong>{$.php.get_ip_address}</strong>]
</div>

<script>
	var form = $("form");
	$(document).ajaxStart(function() { Pace.restart(); });
	$("[name='remember']")
		.iCheck({ checkboxClass: 'icheckbox_square-blue', radioClass: 'iradio_square-blue', increaseArea: '20%' })
		.iCheck('uncheck');
	
	$(document).ready(function(){
		console.log(Cookies.get("identity"));
		var $identity = Cookies.get("identity");
		if ($identity) {
			$("[name='username']").val($identity);
			$("[name='password']").val(1234567890);
			$("[name='remember']").iCheck('check');
		}
	});
	
	form.submit( function(e) {
		e.preventDefault();
		var rememberme = $("[name='remember']").prop('checked') ? 1 : 0;
		
		{* form.find('[type="submit"]').attr("disabled", "disabled"); *}
		
		$.ajax({ url:"{$.const.AUTH_LNK}", method:"UNLOCK", async:true, dataType:'json',
			headers: { "X-AUTH": "Basic " + btoa($("[name='username']").val() + ":" + $("[name='password']").val()) },
			data: JSON.stringify({ "login":1, "rememberme":rememberme, "current_url":window.location.href }),
			beforeSend: function(xhr) { form.find('[type="submit"]').attr("disabled", "disabled"); },
			success: function(data) {
				{* alert("Login success !"); *}
				if (data.status) {
					store('lockscreen{$.const.DEFAULT_CLIENT_ID~$.const.DEFAULT_ORG_ID}', 0);
					window.location.replace(data.url);
					{* window.location = data.url; *}
				}
			},
			error: function(data, status, errThrown) {
				{* alert("Login error !"); *}
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				setTimeout(function(){ form.find('[type="submit"]').removeAttr("disabled"); },1000);
				BootstrapDialog.show({ message:message, closable: false, type:'modal-danger', title:'Notification', 
					buttons: [{ label: 'OK', hotkey: 13, 
						action: function(dialogRef) {
							dialogRef.close();
						} 
					}],
				});
				{* BootstrapDialog.alert({ type:'modal-danger', title:'Error ('+data.status+') :', message:message }); *}
			}
		});
	}); 
	
</script>
</body>
</html>
