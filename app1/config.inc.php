<?php 
defined('FCPATH') OR exit('No direct script access allowed'); 

/* Database DSN */ 
define('DB_DSN', 'pgsql:host=103.20.189.26;port=4111;dbname=db_genesys;user=postgres;password=admin123'); 

/* Database Driver */ 
define('DB_DRIVER', 'pdo'); 

/* Database Host */ 
define('DB_HOST', ''); 

/* Database Username */ 
define('DB_USERNAME', ''); 

/* Database Password */ 
define('DB_PASS', ''); 

/* Database Name */ 
define('DB_NAME', ''); 

/* Base URL */ 
define('BASE_URL', 'http://localhost/ci/app1/'); 
// define('BASE_URL', 'http://apps.hdgroup.id/'); 
// define('BASE_URL', 'http://iproduct.trigraha.com/'); 

/* Email Domain */ 
define('EMAIL_DOMAIN', 'localhost'); 

/* Time Zone */ 
define('TIME_ZONE', 'Asia/Jakarta'); 

define('DEFAULT_CLIENT_ID', 11);
define('DEFAULT_ORG_ID', 16);

// FRONTEND CONSTANT VARIABLE
define('TITLE_F', 'HD GROUPS');
define('WEB_LOGO_TEXT_MN_F', 'HDG');
define('WEB_LOGO_TEXT_LG_F', 'HD GROUPS');
define('FRONTEND_THEME', 'frontend_theme/');

define('DATE_FORMAT_F', 'd/m/Y');
define('TIME_FORMAT_F', 'h:i:s');
define('DATETIME_FORMAT_F', 'd/m/Y h:i:s');

define('HOME_F_LNK', 'frontend');

// BACKEND CONSTANT VARIABLES
define('APP_TITLE_B', 'HD GROUPS - APPS');
define('TITLE_B', '<b>HD</b> GROUPS');
define('WEB_LOGO_TEXT_MN_B', 'HDG');
define('WEB_LOGO_TEXT_LG_B', 'HD GROUPS');
define('BACKEND_THEME', 'backend_theme/');

define('DATE_FORMAT_B', 'd/m/Y');
define('TIME_FORMAT_B', 'h:i:s');
define('DATETIME_FORMAT_B', 'd/m/Y h:i:s');

define('HOME_B_LNK', 'systems');
define('AUTH_LNK', 'systems/x_auth');
define('LOGIN_LNK', 'systems/x_login');
define('LOGOUT_LNK', 'systems/x_logout');
define('UNLOCK_LNK', 'systems/x_unlock');
define('CONFIG_LNK', 'systems/x_config');
define('SRCMENU_LNK', 'systems/x_srcmenu');
define('CHGPWD_LNK', 'systems/x_chgpwd');
define('PROFILE_LNK', 'systems/x_profile');
define('INFOLST_LNK', 'frontend/infolist');

// OTHER
define('URL_SEPARATOR', '/');

// API SETTINGS
define('APPLICATION_KEY', 'lLHi5iSpufGDO%2BSEuzwz7JaN0sWk7OeZIcXwiwpHQ88%3D');
define('API_BASE_URL', '');
define('API_URL', API_BASE_URL.'api/v1/');


