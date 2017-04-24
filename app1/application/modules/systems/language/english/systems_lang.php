<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Systems Lang - English
*
* Author: Ahmad Firuze
* 		  antho.firuze@gmail.com
*
* Location: -
*
* Created:  26.12.2015
*
* Description:  English language file for System 
*				- Base on Window
*
*/

/* CRUD */
$lang['confirm_delete'] 		= 'Are you sure you want to delete this record ?';
$lang['success_delete'] 		= 'Deleting Data Successfully !';
$lang['success_update'] 		= 'Updating Data Successfully !';
$lang['success_saving'] 		= 'Saving Data Successfully !';
$lang['success_delete_undo'] 	= 'Undo Deleting Data Successfully !';
$lang['error_delete'] 			= 'Error: Deleting data !';
$lang['error_update'] 			= 'Error: Updating data !';
$lang['error_saving'] 			= 'Error: Saving data !';
/* EXPORT/IMPORT */
$lang['export_failed']					= 'Export Data Failed !';
$lang['import_failed']					= 'Import Data Failed !';

/* Navigation Bar */
$lang['nav_dash']		= "Dashboard";
$lang['nav_view_site']		= "View Site";
$lang['nav_general_menu']       = "General Menu";
$lang['nav_content_menu']       = "Content Menu";
$lang['nav_admin_users']	= "Users";
$lang['nav_nav_header']         = "Navigation";
$lang['nav_chgpwd']		= "Change Password";
$lang['nav_lckscr']		= "Lock Screen";
$lang['nav_logout']		= "Sign Out";
$lang['nav_gel_settings']	= "General Menu";
$lang['nav_analytics']		= "Analytics";

//CONFIRMATION
$lang['confirm_new_status'] 	= 'Please choose a new status below ?';
$lang['confirm_deal'] 			= 'Please choose a customer respond/feedback ?';
$lang['confirm_reason'] 		= 'Please, give a reason ?';
$lang['confirm_reorder'] 		= 'Are you sure want to RE-ORDER this table ?';
$lang['confirm_rst_pwd'] 		= 'Are you sure want to RESET PASSWORD this user ?';
$lang['confirm_export'] 		= 'Are you sure want to EXPORT this data ?';

//SUCCESS NOTIFICATION 
$lang['success_dealing'] 		= 'Good job...! :)';
$lang['success_chg_pwd'] 		= 'New Password has been activated, and after this you will logout !';
$lang['success_rst_pwd'] 		= 'Password has been reset successfully !';

//ERROR NOTIFICATION
$lang['permission_failed_menu'] = 'You don\'t have permission to access this menu !';
$lang['permission_failed_crud'] = 'You don\'t have permission to do this action !';

/* Upload */
$lang['err_generate_photo'] = 'Generate Photo Failed !';
$lang['err_upload_photo'] = 'Upload Photo Failed !';

$lang['error_no_detail']		= 'ERROR: This data has no detail(s) !';
$lang['error_filter_date'] 		= '(Date From) must be smaller than (Date To) !';
$lang['error_exists_data'] 		= 'Error: This data has already exists !';
$lang['error_data_transaction'] = 'Error: This data has already have TRANSACTIONS !';
$lang['error_delete_auth'] 		= 'Error: Only user who entry that, can remove it !';
$lang['error_old_password']  	= 'Error: Wrong Old Password !';
$lang['error_file_not_exists']  = 'Error: The file does not exist. Please check your files and try again.';
$lang['error_wrong_file_xls']   = 'Error: Wrong file excel !. The fields is not same with the table.';
$lang['error_due_date']   		= 'Error: Due date is coincide with holidays. Please change the due date !';
$lang['error_add_currency_rate'] = 'Error: This Currency has already exists on database. <br>Use Edit/Update for changing the Rates !';