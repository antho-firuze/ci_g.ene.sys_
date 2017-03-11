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
$local = in_array($_SERVER['HTTP_HOST'], ['localhost', '192.168.1.7', '192.168.0.59']) ? 'ci/app1/' : '';
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/'.$local); 

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
switch ($_SERVER['HTTP_HOST'])
{
	case 'apps.hdgroup.id':
		$client_id = 11;
		$org_id = 16;
		break;
	case 'apps.fajarbenua.co.id':
		$client_id = 11;
		$org_id = 11;
		break;
	case 'apps.trigraha.com':
		$client_id = 11;
		$org_id = 12;
		break;
	default:
		$client_id = 11;
		$org_id = 16;
		break;
}
define('DEFAULT_CLIENT_ID', $client_id);
define('DEFAULT_ORG_ID', $org_id);

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