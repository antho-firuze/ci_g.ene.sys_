<?php 
defined('FCPATH') OR exit('No direct script access allowed'); 

/* Database DSN */ 
define('DB_DSN', 'pgsql:host=103.20.189.26;port=4111;dbname=db_genesys;user=postgres;password=admin123'); 
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

/* Template Folder */
define('TEMPLATE_FOLDER', 'templates');

/* Cache Folder */
define('CACHE_FOLDER', 'var/cache');

/* Fenom Settings */
define('TEMPLATE_FCPATH', FCPATH . TEMPLATE_FOLDER);
define('CACHE_FCPATH', FCPATH . CACHE_FOLDER);

/* Default Client & Organization */
define('DEFAULT_CLIENT_ID', 11);
define('DEFAULT_ORG_ID', 12);

/* BACKEND CONSTANT VARIABLES */
define('AUTH_LNK', 'systems/x_auth');
define('LOGIN_LNK', 'systems/x_login');
define('LOGOUT_LNK', 'systems/x_logout');
define('UNLOCK_LNK', 'systems/x_unlock');
define('CONFIG_LNK', 'systems/x_config');
define('SRCMENU_LNK', 'systems/x_srcmenu');
define('PROFILE_LNK', 'systems/x_profile');
define('INFOLST_LNK', 'frontend/infolist');

// OTHER
define('URL_SEPARATOR', '/');

// API SETTINGS
define('APPLICATION_KEY', 'lLHi5iSpufGDO%2BSEuzwz7JaN0sWk7OeZIcXwiwpHQ88%3D');
define('API_BASE_URL', '');
define('API_URL', API_BASE_URL.'api/v1/');