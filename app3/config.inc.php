<?php 
defined('FCPATH') OR exit('No direct script access allowed'); 

/* Database DSN */ 
define('DB_DSN', 'pgsql:host=119.18.158.218;port=4111;dbname=db_genesys;user=postgres;password=admin123'); 
// define('DB_DSN', ''); 

/* Database Driver */ 
define('DB_DRIVER', 'pdo'); 
// define('DB_DRIVER', 'mysqli'); 

/* Database Host */ 
define('DB_HOST', ''); 
// define('DB_HOST', 'localhost'); 

/* Database Username */ 
define('DB_USERNAME', ''); 
// define('DB_USERNAME', 'root'); 

/* Database Password */ 
define('DB_PASS', ''); 

/* Database Name */ 
define('DB_NAME', ''); 
// define('DB_NAME', 'spc'); 

/* Base URL */ 
define('BASE_URL', 'http://localhost/ci/app3/'); 
// define('BASE_URL', 'http://spc.trigraha.com/'); 

/* Email Domain */ 
define('EMAIL_DOMAIN', 'localhost'); 

/* Time Zone */ 
define('TIME_ZONE', 'Asia/Jakarta'); 

define('DEFAULT_CLIENT_ID', 11);
define('DEFAULT_ORG_ID', 12);

// FRONTEND CONSTANT VARIABLE
define('TITLE_F', 'PT. TGS');
define('WEB_LOGO_TEXT_MN_F', 'TGS');
define('WEB_LOGO_TEXT_LG_F', 'PT. TGS');
define('FRONTEND_THEME', 'frontend_theme/');

define('DATE_FORMAT_F', 'd/m/Y');
define('TIME_FORMAT_F', 'h:i:s');
define('DATETIME_FORMAT_F', 'd/m/Y h:i:s');

define('HOME_F_LNK', 'frontend');

// BACKEND CONSTANT VARIABLES
define('APP_TITLE_B', 'PT. TGS - APPS');
define('TITLE_B', '<b>PT. TGS</b>');
define('WEB_LOGO_TEXT_MN_B', 'TGS');
define('WEB_LOGO_TEXT_LG_B', 'PT. TGS');
define('BACKEND_THEME', 'backend_theme/');

define('DATE_FORMAT_B', 'd/m/Y');
define('TIME_FORMAT_B', 'h:i:s');
define('DATETIME_FORMAT_B', 'd/m/Y h:i:s');

define('HOME_B_LNK', 'sys');
define('AUTH_LNK', 'sys/x_auth');
define('LOGIN_LNK', 'sys/x_login');
define('LOGOUT_LNK', 'sys/x_logout');
define('UNLOCK_LNK', 'sys/x_unlock');
define('CONFIG_LNK', 'sys/x_config');
define('SRCMENU_LNK', 'sys/x_srcmenu');
define('CHGPWD_LNK', 'sys/x_chgpwd');
define('PROFILE_LNK', 'sys/x_profile');
define('INFOLST_LNK', 'frontend/infolist');

// OTHER
define('URL_SEPARATOR', '/');

// API SETTINGS
define('APPLICATION_KEY', 'lLHi5iSpufGDO%2BSEuzwz7JaN0sWk7OeZIcXwiwpHQ88%3D');
define('API_BASE_URL', 'http://iproduct.trigraha.com:4222/_g.ene.sys_api_/');
define('API_URL', API_BASE_URL.'api/v1/');
