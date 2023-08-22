<?php
/**********************************************************************
  
	Released underhe GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
$page_security = 'SA_ITEMSSTATVIEW';
$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");

if (!@$_GET['popup'])
{
	if (isset($_GET['stock_id'])){
		page(_($help_context = "Inventory Item Status"), true);
	} else {
		page(_($help_context = "Inventory Item Status"));
	}
}
if (isset($_GET['stock_id']))
	$_POST['stock_id'] = $_GET['stock_id'];
include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/includes/ui.inc");
//include_once($path_to_root . "/includes/manufacturing.inc");
include_once($path_to_root . "/includes/data_checks.inc");

include_once($path_to_root . "/inventory/includes/inventory_db.inc");

if (list_updated('stock_id')) 
	$Ajax->activate('status_tbl');
//----------------------------------------------------------------------------------------------------

check_db_has_stock_items(_("There are no items defined in the system."));

if (!@$_GET['popup'])
	start_form();

if (!isset($_POST['stock_id']))
	$_POST['stock_id'] = get_global_stock_item();

if (!@$_GET['popup'])
{
	echo "<center> " . _("Item:"). " ";
	echo stock_costable_items_list('stock_id', $_POST['stock_id'], false, true);
}	
echo "<br>";

echo "<hr></center>";

set_global_stock_item($_POST['stock_id']);

$mb_flag = get_mb_flag($_POST['stock_id']);
$kitset_or_service = false;

div_start('status_tbl');
if (is_service($mb_flag))
{
	display_note(_("This is a service and cannot have a stock holding, only the total quantity on outstanding sales orders is shown."), 0, 1);
	$kitset_or_service = true;
}

$loc_details = get_loc_details($_POST['stock_id']);

start_table(TABLESTYLE);

if ($kitset_or_service == true)
{
	$th = array(_("Location"), _("Demand"));
}
else
{
	$th = array(_("Location"), _("Quantity On Hand"), _("Re-Order Level"),
		_("Demand"), _("Available"), _("On Order"), _("Consumed items"), _("Issued Items"), _("Scrap items"));
}
table_header($th);
$dec = get_qty_dec($_POST['stock_id']);
$j = 1;
$k = 0; //row colour counter

while ($myrow = db_fetch($loc_details))
{

	alt_table_row_color($k);

	$demand_qty = get_demand_qty($_POST['stock_id'], $myrow["loc_code"]);
	$demand_qty += get_demand_asm_qty($_POST['stock_id'], $myrow["loc_code"]);


	$qoh = get_qoh_on_date($_POST['stock_id'], $myrow["loc_code"]);
        
        $qoh1 = get_qoi_on_date($_POST['stock_id'], $myrow["loc_code"]);
        
         $qoh2 = get_return_on_item($_POST['stock_id'], $myrow["loc_code"]);
         $qoh5 = get_return_on_group_item($_POST['stock_id'], $myrow["loc_code"]);
        //$qoh =$qoh1[0];
        // print_r($qoh2);
         //print_r($qoh5['tq']); 
	if ($kitset_or_service == false)
	{
		//$qoo = get_on_porder_qty($_POST['stock_id'], $myrow["loc_code"]);
		//$qoo += get_on_worder_qty($_POST['stock_id'], $myrow["loc_code"]);
           
            $qoo2=abs($qoh1[0]);
             if($qoh2['item_status']=='2'){
                
               $qoo1=$qoo2-$qoh2['tq'];
               
           //   if($qoh=='0'){
                //  continue;
               $qoo=$qoh2['tq'];
             /// }
                
            }
            else {
               
              $qoh= $qoh+$qoh2['tq']+$qoh5['tq'];
               $qoo1=$qoo2-$qoh2['tq']-$qoh5['tq'];
            }
            
		label_cell($myrow["location_name"]);
		qty_cell($qoh, false, $dec);
        qty_cell($myrow["reorder_level"], false, $dec);
        qty_cell($demand_qty, false, $dec);
        qty_cell($qoh - $demand_qty, false, $dec);
        qty_cell($qooo, false, $dec);
        qty_cell($qoo1, false, $dec);
        qty_cell($qoo1, false, $dec);
        qty_cell($qoo, false, $dec);
        end_row();

	}
	else
	{
	/* It must be a service or kitset part */
		label_cell($myrow["location_name"]);
		qty_cell($demand_qty, false, $dec);
		qty_cell($demand_qty, false, $dec);
		qty_cell($demand_qty, false, $dec);
		qty_cell($demand_qty, false, $dec);
		end_row();

	}
	$j++;
	If ($j == 12)
	{
		$j = 1;
		table_header($th);
	}
}

end_table();
div_end();
if (!@$_GET['popup'])
{
	end_form();
	end_page(@$_GET['popup'], false, false);
}	

?>
