<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('DEFAULT_CLIENT_ID')	  OR define('DEFAULT_CLIENT_ID', 11);
defined('DEFAULT_ORG_ID')	  	  OR define('DEFAULT_ORG_ID', 16);

// FRONTEND CONSTANT VARIABLE
defined('TITLE_F')	  	   			OR define('TITLE_F', 'HD GROUPS');
defined('WEB_LOGO_TEXT_MN_F')	  OR define('WEB_LOGO_TEXT_MN_F', 'HDG');
defined('WEB_LOGO_TEXT_LG_F')	  OR define('WEB_LOGO_TEXT_LG_F', 'HD GROUPS');
defined('FRONTEND_THEME')	   		OR define('FRONTEND_THEME', 'frontend_theme/');

defined('DATE_FORMAT_F')				OR define('DATE_FORMAT_F', 'd/m/Y');
defined('TIME_FORMAT_F')				OR define('TIME_FORMAT_F', 'h:i:s');
defined('DATETIME_FORMAT_F')		OR define('DATETIME_FORMAT_F', 'd/m/Y h:i:s');

defined('HOME_F_LNK')						OR define('HOME_F_LNK', 'frontend');

// BACKEND CONSTANT VARIABLES
defined('APP_TITLE_B')	  	   	OR define('APP_TITLE_B', 'HD GROUPS - APPS');
defined('TITLE_B')	  	   			OR define('TITLE_B', '<b>HD</b> GROUPS');
defined('WEB_LOGO_TEXT_MN_B')	  OR define('WEB_LOGO_TEXT_MN_B', 'HDG');
defined('WEB_LOGO_TEXT_LG_B')	  OR define('WEB_LOGO_TEXT_LG_B', 'HD GROUPS');
defined('BACKEND_THEME')	   		OR define('BACKEND_THEME', 'backend_theme/');

defined('DATE_FORMAT_B')				OR define('DATE_FORMAT_B', 'd/m/Y');
defined('TIME_FORMAT_B')				OR define('TIME_FORMAT_B', 'h:i:s');
defined('DATETIME_FORMAT_B')		OR define('DATETIME_FORMAT_B', 'd/m/Y h:i:s');

defined('HOME_B_LNK')						OR define('HOME_B_LNK', 'sys');
defined('AUTH_LNK')							OR define('AUTH_LNK', 'sys/x_auth');
defined('LOGIN_LNK')						OR define('LOGIN_LNK', 'sys/x_login');
defined('LOGOUT_LNK')						OR define('LOGOUT_LNK', 'sys/x_logout');
defined('UNLOCK_LNK')						OR define('UNLOCK_LNK', 'sys/x_unlock');
defined('CONFIG_LNK')						OR define('CONFIG_LNK', 'sys/x_config');
defined('SRCMENU_LNK')					OR define('SRCMENU_LNK', 'sys/x_srcmenu');
defined('CHGPWD_LNK')						OR define('CHGPWD_LNK', 'sys/x_chgpwd');
defined('PROFILE_LNK')					OR define('PROFILE_LNK', 'sys/x_profile');
defined('INFOLST_LNK')					OR define('INFOLST_LNK', 'frontend/infolist');


// OTHER
defined('URL_SEPARATOR')				OR define('URL_SEPARATOR', '/');


// API SETTINGS
defined('APPLICATION_KEY')	   	OR define('APPLICATION_KEY', 'lLHi5iSpufGDO%2BSEuzwz7JaN0sWk7OeZIcXwiwpHQ88%3D');
defined('API_BASE_URL')	   	   	OR define('API_BASE_URL', 'http://iproduct.trigraha.com:4222/_g.ene.sys_api_/');
defined('API_URL')	   		   		OR define('API_URL', API_BASE_URL.'api/v1/');


