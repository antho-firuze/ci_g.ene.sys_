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
$lang['notif_update_plan_has_posted'] 		= "You can edit/delete this plan after unposting !";
$lang['notif_update_outbound_completed'] 		= "This Outbound has had an Inbound !";
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
$lang['error_update_outbound_completed'] 		= "Error: Cannot edit/delete this Outbound, because this Outbound has had an Inbound !";
$lang['error_update_inbound_completed'] 		= "Error: Cannot edit/delete this Inbound, because this Inbound has been Completed !";
$lang['error_delete_so_had_shipment'] 		= "Error: Data cannot be delete, because this SO has been Shipment. <br>Plase Delete Shipment first for this SO !<br><br>Shipment no: %s";
$lang['error_delete_so_has_been_posted'] 		= "Error: Data cannot be delete, because this SO Plan has been Posted. <br>Plase Unposting SO Plan first for deleting this SO !";
$lang['error_delete_so_line_had_shipment'] 		= "Error: Data cannot be delete, because this SO Line has been Shipment. <br>Plase Delete Shipment first for this Line !<br><br>Shipment no: %s";
$lang['error_delete_po_had_received'] 		= "Error: Data cannot be delete, because this PO has been received. <br>Plase Delete MR first for this PO !<br><br>MR no: %s";
$lang['error_delete_po_has_been_posted'] 		= "Error: Data cannot be delete, because this PO Plan has been Posted. <br>Plase Unposting PO Plan first for deleting this PO !";
$lang['error_delete_po_line_had_received'] 		= "Error: Data cannot be delete, because this PO Line has been received. <br>Plase Delete MR first for this Line !<br><br>MR no: %s";
$lang['error_delete_pr_had_po'] 		= "Error: Data cannot be delete, because this Requisition has been made PO. <br>Plase Delete PO first for this Requisition !<br><br>PO no: %s";
$lang['error_delete_pr_line_had_po'] 		= "Error: Data cannot be delete, because this Requisition Line has been made PO. <br>Plase Delete PO first for this Line !<br><br>PO no: %s";
$lang['error_delete_request_had_pr'] 		= "Error: Data cannot be delete, because this Request has been made PR. <br>Plase Delete PR first for this Request !<br><br>PR no: %s";
$lang['error_delete_request_line_had_pr'] 		= "Error: Data cannot be delete, because this Request Line has been made PR. <br>Plase Delete PR first for this Line !<br><br>PR no: %s";
$lang['error_saving_shipment_already_completed'] 		= "Error: Data cannot be save, because this item has been Completed.<br><br>Shipment no: %s";
$lang['error_saving_material_receipt_already_completed'] 		= "Error: Data cannot be save, because this item has been Completed.<br><br>Material Receipt no: %s";
/* Information: info_ */
