{* 
	Template Name: AdminLTE 
	Modified By: Firuze
	Email: antho.firuze@gmail.com
	Github: antho-firuze
*}
<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="no-cache, no-cache">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>{$.session.head_title}</title>
{$.php.link_tag('favicon.ico', 'shortcut icon', 'image/ico')}
{$.php.link_tag($.const.TEMPLATE_URL~'bootstrap/css/bootstrap.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'font-awesome/css/font-awesome.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/ionicons/css/ionicons.min.css')}

{* {$.php.link_tag($.const.TEMPLATE_URL~'plugins/datatables/media/css/jquery.dataTables.min.css')} *}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/datatables/media/css/dataTables.bootstrap4.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/datatables/extensions/select/css/select.dataTables.min.css')}

{$.php.link_tag($.const.TEMPLATE_URL~'dist/css/AdminLTE.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'dist/css/skins/_all-skins.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/autoComplete/jquery.auto-complete.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'css/custom.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/pace/pace-center-circle.css')}
{* {$.php.link_tag($.const.TEMPLATE_URL~'plugins/iCheck/flat/blue.css')} *}
{* {$.php.link_tag($.const.TEMPLATE_URL~'plugins/iCheck/flat/orange.css')} *}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/bootstrap-dialog/css/bootstrap-dialog.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/shollu-combobox/css/shollu_cb-grey.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/animate/animate.min.css')}
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/lobibox/css/lobibox.min.css')}
<script src="{$.const.ASSET_URL}js/common.func.js"></script>
<script>
	{* DECLARE VARIABLE *}
	{var $sidebar = $.session.sidebar !: ''}
	var x_config_lnk = '{$.const.U_CONFIG_LNK}';
	var $skin = 'skin{$.const.DEFAULT_CLIENT_ID~$.const.DEFAULT_ORG_ID}';
	var $sidebar = 'sidebar{$.const.DEFAULT_CLIENT_ID~$.const.DEFAULT_ORG_ID}';
	var $screen_timeout = 'screen_timeout{$.const.DEFAULT_CLIENT_ID~$.const.DEFAULT_ORG_ID}';
	var $lockscreen = 'lockscreen{$.const.DEFAULT_CLIENT_ID~$.const.DEFAULT_ORG_ID}';
	var $BASE_URL = '{$.php.base_url()}';
	var $APPS_LNK = '{$.const.APPS_LNK}';
	var $TEMPLATE_URL = '{$.const.TEMPLATE_URL}';
	var $HEAD_TITLE = '{$.session.head_title}';
	{* Defined Language *}
	var lang_confirm_delete = "{$.php.lang('confirm_delete')}";
	var lang_confirm_copy = "{$.php.lang('confirm_copy')}";
	var lang_notif_choose_record = "{$.php.lang('notif_choose_record')}";
	{* store($skin, "{$.session.skin !: $.session.default_skin}"); *}
	{* store($sidebar, "{$.session.sidebar !: ''}"); *}
	{* store($screen_timeout, "{$.session.screen_timeout !: $.session.default_screen_timeout}"); *}
	store($skin, "{$.session.skin}");
	store($sidebar, "{$.session.sidebar !: ''}");
	store($screen_timeout, "{$.session.screen_timeout}");
</script>
<script src="{$.const.TEMPLATE_URL}plugins/jQuery/jquery-3.2.1.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/idletimer/idle-timer.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/pace/pace.min.js"></script>
<script src="{$.const.TEMPLATE_URL}bootstrap/js/bootstrap.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>

<script src="{$.const.TEMPLATE_URL}plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datatables/media/js/dataTables.bootstrap4.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datatables/extensions/select/js/dataTables.select.min.js"></script>

<script src="{$.const.TEMPLATE_URL}plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/fastclick/fastclick.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/autoComplete/jquery.auto-complete.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/uri.js/URI.min.js"></script>
<script src="{$.const.TEMPLATE_URL}dist/js/app.min.js"></script>
<script src="{$.const.ASSET_URL}js/common.extend.func.js"></script>
<script src="{$.const.ASSET_URL}js/bootstrap.helper.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  {* $main_header *}
  {include $.const.TEMPLATE_PATH ~ "include/main_header.tpl"}
  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  {* $navbar_left *}
  {include $.const.TEMPLATE_PATH ~ "include/navbar_left.tpl"}
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  {include $content}
  <!-- /.content-wrapper -->
  {* $main_footer *}
  {include $.const.TEMPLATE_PATH ~ "include/main_footer.tpl"}
  <!-- Control Sidebar -->
  {* $navbar_right *}
  {include $.const.TEMPLATE_PATH ~ "include/navbar_right.tpl"}
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
{include $.const.TEMPLATE_PATH ~ "include/lockscreen.tpl"}
<script src="{$.const.TEMPLATE_URL}js/custom.js"></script>
<script>
	{* init for pace option *}
	paceOptions = {	ajax: false, elements: false, restartOnRequestAfter: false	};
	{* init for skin & sidebar *}
	$(document.body).addClass(get($sidebar)).addClass(get($skin)).addClass("{$.session.layout}");
	
	{* This lines is for removing tab index on tag <a> *}
	$("body").find("a").each(function(){
		$(this).attr("tabindex", "-1");
	});
	
	{* sign-out *}
	$("#go-sign-out").click(function(e){
		e.preventDefault();
		if (confirm("Are you sure ?")) {
			{* window.location.replace($(this).attr('href')); *}
			window.location.href = $(this).attr('href');
		}
	});
	
	{* searching-menu *}
	var xhr;
	$("#searching-menu").autoComplete({	minChars: 1, delay: 0, cache: false,
		source: function(term, response){
			try { xhr.abort(); } catch(e){}
			xhr = $.getJSON("{$.const.SRCMENU_LNK}", { q: term }, function(data){ response(data.data); });
		},
		renderItem: function (item, search){
			search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
			var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
			return '<div style="height:35px; width:300px; padding-top:7px;" class="autocomplete-suggestion" data-id="' + item['menu_id'] + '" data-val="' + item['name'] + '"><i class="fa fa-circle-o"></i> '+ item['name'].replace(re, "<b>$1</b>") + '</div>';
		},
		onSelect: function(e, term, item){
			window.location.href = "{$.const.PAGE_LNK}?pageid="+item.data('id');
		} 
	});
  
</script>
{* <script src="{$.const.ASSET_URL}js/web_event.js"></script> *}
</body>
</html>