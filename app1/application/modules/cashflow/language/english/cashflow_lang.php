<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Cashflow Lang - English
*
* Author: Ahmad Firuze
* 		  antho.firuze@gmail.com
*
* Location: -
*
* Created:  26.12.2015
*
* Description:  English language file for Module Cashflow 
*
*/
/* Notification: notif_ & success_  */
$lang['success_plan_posting'] 		= "Posting sucessfully !";
$lang['success_plan_unposting'] 		= "Unposting sucessfully !";
/* Confirmation: confirm_ */
/* Error/Failed: error_ */
// $lang['error_amount_overload'] 		= "Error: The amount you enter is too much ! [max=%01.2f]";
$lang['error_amount_overload'] 		= "Error: The amount you enter is too much ! [max=%s]";
$lang['error_qty_overload'] 		= "Error: The quantity you enter is too much ! [max=%s]";
$lang['error_had_detail'] 		= "Error: Data cannot be change, because they have details !";
$lang['error_requisition_eta'] 		= "Error: Requsition ETA must be under Planning ETA ! [under=%s]";
$lang['error_po_eta'] 		= "Error: Purchase Order ETA must be under Requisition ETA ! [under=%s]";
$lang['error_duplicate_doc_no'] 		= "Error: This Doc No already exists !";
$lang['error_duplicate_balance_amt'] 		= "Error: This Period [%s] already has a Balance !";
$lang['error_month_range_overload'] 		= "Error: Maximal range are %s months !";
$lang['error_day_range_overload'] 		= "Error: Maximal range are %s days !";
$lang['error_downloading_report'] 		= "Error: Downloading report file [%s] failed !";
$lang['error_filling_params'] 		= "Error: Please fill one of the columns !";
$lang['error_filling_params'] 		= "Error: Please fill one of the columns !";
$lang['error_plan_had_invoiced'] 		= "Error: Cannot delete plan, because this plan has invoiced. <br>Plase Delete Invoice first for this Plan !<br><br>Invoice no: %s";
$lang['error_plan_had_posted'] 		= "Error: Cannot edit/delete plan, because this plan has been posted. <br><br>You can edit/delete this plan after unposting them !";
$lang['error_unpost_plan_has_actual'] 		= "Error: Cannot unposting plan, because Invoice Plan has been Actualization !";
$lang['error_unpost_plan_has_payment'] 		= "Error: Cannot unposting plan, because this plan has Actual Payment !";
$lang['error_delete_invoice_has_payment'] 		= "Error: Cannot delete invoice, because this invoice has Actual Payment !";
/* Information: info_ */
