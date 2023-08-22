<?php
/**********************************************************************
  
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
$page_security = 'SA_MAINTENANCE';
$path_to_root = "../..";
include($path_to_root . "/includes/session.inc");

include_once($path_to_root . "/includes/date_functions.inc");

page(_($help_context = "Utility Parameters Master")); 

include($path_to_root . "/maintenance/includes/db/utilityparameters_db.inc");

include($path_to_root . "/includes/ui.inc");

simple_page_mode(true);
//-----------------------------------------------------------------------------------

function can_process() 
{
	
	/* if(strlen($_POST['param1']) == "0") 
	{
		display_error(_("The Parameter1 cannot be empty."));
		set_focus('param1');
		return false;
	}	 */ 
	
	return true;
}


if(list_updated('type_maintenance_id')){
	$Ajax->activate('parameters_table');
	}

//-----------------------------------------------------------------------------------

if ($Mode=='ADD_ITEM' && can_process()) 
{
	add_parameters($_POST['utilitys_id'],$_POST['type_maintenance_id'], $_POST['frequency_id'],$_POST['ut_param1'],$_POST['ut_param2'],$_POST['ut_param3'],$_POST['ut_param4'],$_POST['ut_param5'],$_POST['ut_param6'],$_POST['br_date'],$_POST['br_time'],$_POST['br_observations'],$_POST['br_comments']);
	display_notification(_('Parameters has been added'));
	$Mode = 'RESET';
} 
//-----------------------------------------------------------------------------------

if ($Mode=='UPDATE_ITEM' && can_process()) 
{
	display_notification(_('Selected Parameters has been updated'));
	update_parameters($selected_id, $_POST['utilitys_id'],$_POST['type_maintenance_id'],$_POST['frequency_id'],$_POST['ut_param1'],$_POST['ut_param2'],$_POST['ut_param3'],$_POST['ut_param4'],$_POST['ut_param5'],$_POST['ut_param6'],$_POST['br_date'],$_POST['br_time'],$_POST['br_observations'],$_POST['br_comments']);
	$Mode = 'RESET';
}
//-----------------------------------------------------------------------------------

function can_delete($selected_id)
{
	 if (key_in_foreign_table($selected_id, 'parameters_master', 'param_id'))
	{
		display_error(_("Cannot delete this Parameters."));
		return false;
	} 
	
	return true;
}
//-----------------------------------------------------------------------------------

if ($Mode == 'Delete')
{

	if (can_delete($selected_id))
	{
		delete_parameters($selected_id);
		display_notification(_('Selected Parameters has been deleted'));
	}
	$Mode = 'RESET';
}

if ($Mode == 'RESET')
{
	$selected_id = -1;
	$sav = get_post('show_inactive');
	unset($_POST);
	$_POST['show_inactive'] = $sav;
}
//-----------------------------------------------------------------------------------

$result = get_all_parameters(check_value('show_inactive'));

//display_error('asdf');die;
start_form();

start_table(TABLESTYLE, "width=35%");
$th = array(_("Utility"),_("Maintenance Type"), _("Frequency"),'','');
inactive_control_column($th);
table_header($th);

$k = 0;
while ($myrow = db_fetch($result)) 
{
	
	alt_table_row_color($k);	
	
	
	label_cell($myrow["u_name"]);
	if ($myrow["type_maintenance_id"] ==1)
	{
		label_cell('Preventive');
	}
	else{
		label_cell('N/A');
	}
	label_cell($myrow["f_name"]);
	//label_cell($myrow["ut_param1"]);
	//label_cell($myrow["ut_param2"]);
	//label_cell($myrow["ut_param3"]);
	//label_cell($myrow["ut_param4"]);
	//label_cell($myrow["ut_param5"]);
	//label_cell($myrow["ut_param6"]);
	inactive_control_cell($myrow["ut_param_id"], $myrow["inactive"], 'parameters_master', 'ut_param_id');
 	edit_button_cell("Edit".$myrow['ut_param_id'], _("Edit"));
 	delete_button_cell("Delete".$myrow['ut_param_id'], _("Delete"));
	end_row();
}

inactive_control_row($th);
end_table();
echo '<br>';
//-----------------------------------------------------------------------------------
div_start('parameters_table');
start_table(TABLESTYLE2);

if ($selected_id != -1) 
{
 	if ($Mode == 'Edit') {
		//editing an existing status code

		$myrow = get_parameters($selected_id);
		
		$_POST['utilitys_id']  = $myrow["utilitys_id"];
		$_POST['type_maintenance_id']  = $myrow["type_maintenance_id"];
		$_POST['frequency_id'] = $myrow["frequency_id"];
		$_POST['ut_param1']  = $myrow["ut_param1"];
		$_POST['ut_param2']  = $myrow["ut_param2"];
		$_POST['ut_param3']  = $myrow["ut_param3"];
		$_POST['ut_param4']  = $myrow["ut_param4"];
		$_POST['ut_param5']  = $myrow["ut_param5"];
		$_POST['ut_param6']  = $myrow["ut_param6"];
		$_POST['br_date']  = $myrow["br_date"];
		$_POST['br_time']  = $myrow["br_time"];
		$_POST['br_observations']  = $myrow["br_observations"];
		$_POST['br_comments']  = $myrow["br_comments"];
		
	}
	hidden('selected_id', $selected_id);
} 

utility_list_row(_("Utility:"), 'utilitys_id', null, false, true);

$utility_id = $_POST['utilitys_id'];
maintenancetype_list_row(_("Type of Maintenance:"), 'type_maintenance_id', null, false, true,$utility_id);
if(list_updated('utilitys_id')){
	$Ajax->activate('type_maintenance_id');
	$Ajax->activate('parameters_table');
}

freq_multilist_row(_("Frequency:"), 'frequency_id', null, false, true,$utility_id);
if(list_updated('utilitys_id')){
	$Ajax->activate('frequency_id');
	$Ajax->activate('parameters_table');
	
}

$myrow = get_parameters($_POST['utilitys_id'],$_POST['type_maintenance_id'],$_POST['frequency_id']);


end_table(1);
div_end();

submit_add_or_update_center($selected_id == -1, '', 'both');

end_form();
//------------------------------------------------------------------------------------

end_page();

?>

