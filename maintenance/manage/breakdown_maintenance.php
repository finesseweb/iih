<?php

$page_security = 'SA_MAINTAINBREAKDOWN';
$path_to_root = "../..";


include($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/date_functions.inc");
page(_($help_context = "Breakdown Maintenance ")); 

//include($path_to_root . "/maintenance/includes/db/parameters_db.inc");
include($path_to_root . "/includes/ui.inc");

//include_once($path_to_root . "/manufacturing/includes/manufacturing_db.inc");
//include_once($path_to_root . "/manufacturing/includes/manufacturing_ui.inc");
$_SESSION['page_title'] = _($help_context = "New Breakdown");
 
//page($_SESSION['page_title'], false, false, "", $js);
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?php echo $path_to_root . "/js/jquery-ui.css" ?>">

   <script src="<?php echo $path_to_root . "/js/jquery-ui.js"?>"></script>
  
</head>
<body>

<?php
if(isset($_GET['success']))
{
	display_notification("Breakdown Maintenance has been added!");
}
start_form();
    if (get_post('Show'))
{
	$Ajax->activate('trans_tbl');
}
//------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------
$query = "SELECT prev.*,s.description AS Item,con.supp_name AS contractor FROM ".TB_PREF."breakdown_maintenance AS prev LEFT JOIN ".TB_PREF."utility AS utly ON utly.id= prev.utility_id  LEFT JOIN ".TB_PREF."stock_master s ON s.stock_id= utly.items_id LEFT JOIN ".TB_PREF."contractor con ON con.supplier_id= prev.contractor_id WHERE utly.type=1";
$res=db_query($query);
//$result=db_fetch($res);

div_start('trans_tbl');
start_table(TABLESTYLE);

$th = array(_("#"),_("Reference"), _("Date"),
	_("Utility"),_("Contractor"),_("Start Time"), _("End Time"), _("Observations"),_("Corrective Action Suggested"),_("Corrective Action Initiated"),_("EDIT"));
table_header($th);


function get_trans($break_id,$type)
{

	$label = $break_id;
	$class ='';
	$id=$break_id;
	$icon = '';
	 $viewer = $path_to_root."maintenance/view/";
	if ($type == 'Break')
	hidden('Break_id',$break_id);
		$viewer .= "maintain_breakdown_view.php?id=".$break_id;
	
	return viewer_link($label, $viewer, $class, $id,  $icon);
	
}

$k = 0; 
$i=1; //row colour counter
while ($myrow = db_fetch($res))
{
	alt_table_row_color($k);
        label_cell($i);
	label_cell(get_trans($myrow['break_id'],'Break'));
	label_cell($myrow["maintain_date"]);
	label_cell($myrow["Item"]);
	//label_cell($myrow["frequency"]);
	label_cell($myrow["contractor"]);
  //  $nextpendingdate = date("d-m-Y", strtotime($myrow["frequency_des"], strtotime($myrow["prv_ob_date"])));
	label_cell($myrow["break_st_time"]);
	label_cell($myrow["break_end_time"]);
	label_cell($myrow["ob_reason"]);
	label_cell($myrow["ob_1"]);
	label_cell($myrow["ob_2"]);
	 edit_button_cell("Edit" . $myrow['break_id'], _("Edit")); 
	 delete_button_cell("Update".$myrow['break_id'], _("Update"));
	end_row();
 
	$i++;
}

end_table(2);
div_end();



end_form();
//display_error($_POST['maintain_date']);
?>
<form id="basicForm" action="add_breakdown_maintenance.php" method="POST" >
<table width="30%" align="center" style="padding:10px;">
<tr >
 <td>Date <input type="text" class="sal"  name="maintain_date" id="maintain_date" value ="<?=$_POST['maintain_date'];?>"/></td>
 <td>Utility
  <select type="text" name="utility_id" id="utility_id" >
 <?php  
 // $sql= "SELECT id,name FROM ".TB_PREF."utility";  
  $sql= "SELECT utly.id,CASE  WHEN(utly.name !='')  THEN  utly.name  WHEN (utly.items_id !='') THEN s.description END AS u_name FROM ".TB_PREF."utility AS utly LEFT JOIN ".TB_PREF."stock_master AS s ON  utly.items_id=s.stock_id";
  $res=db_query($sql);
     echo "<option>Select</option>";
	while($row = db_fetch($res))
	{  
	?>  
	<option value="<?php  echo $row['id']; ?>"><?php echo $row['u_name']; ?></option>
	<?php  
	 } ?>
  </select></td>  
  
  <td>Contractor
  <select type="text" name="contractor_id" id="contractor_id">
 <?php $sql= "SELECT supplier_id,supp_name FROM ".TB_PREF."contractor ORDER BY supplier_id"; 
   $res=db_query($sql);
     echo "<option>Select</option>";
	while($row = db_fetch($res))
	{ 
	?>  
	<option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supp_name']; ?></option>
	<?php  
	} ?>
  </select></td>
 <!--  <td >Frequency
  <select type="text" name="frequency_id" id="frequency_id">
 <?php /* $sql= "SELECT freq_id,frequency_name
   FROM ".TB_PREF."frequency_master"; 
   $res=db_query($sql);
     echo "<option>Select</option>";
	while($row = db_fetch($res))
	{  */
	?>  
	<option value="<?php // echo $row['freq_id']; ?>"><?php // echo $row['frequency_name']; ?></option>
	<?php  
	// } ?>
  </select></td>  -->
  </tr>
 </table>
 <div id="records"></div>
 <hr>
  <div id="addmore_fields">

   </br>
 
 <div align="center">
 <br>
 <br>
 <input type="submit" id="add_entry" name="add_entry" value="Submit" align="center"> 
 </div>
 </form>
 </body>
<script type="text/javascript">
function myFunction() {
	var name= document.getElementById("check_name").value;
    document.getElementById("check_sign").value = name;
}

function myFunct() {
	var name= document.getElementById("inspect_name").value;
    document.getElementById("inspect_sign").value = name;
}

function myFun() {
	var quan_offered= document.getElementById("quan_offered").value;
    var quan_accepted= document.getElementById("quan_accepted").value;
    var quan_rejected= quan_offered - quan_accepted;
	document.getElementById("quan_rejected").value = quan_rejected;
  } 

</script>
 
 <script>
 $('#maintain_date').datepicker({
	dateFormat: 'dd-mm-yy',
	prevText: '<i class="fa fa-chevron-left"></i>',
	nextText: '<i class="fa fa-chevron-right"></i>',
	maxDate: 0 
});
 </script>

 
 <script>
  
$("#utility_id").change(function() {
	 var utility_id=$("#utility_id").val();
	//  alert(utility_id);
	 
	 $.ajax({ 
			type: "POST",
			url:'<?php echo $path_to_root . "/maintenance/manage/ajax_get_breakdownrecords.php";?>',
			data: { utility_id : utility_id}
		}).done( function( data ) { 
	     //	alert(data);
			
			$("#records").html(data);
		});
	/* $.ajax({ 
			type: "POST",
			url:'<?php echo $path_to_root . "/maintenance/manage/ajax_get_breakdownfrequency.php";?>',
			data: { utility_id : utility_id}
		}).done( function( data ) { 
	     //	alert(data);
			$("#frequency_id").html(data);
		}); */
});
/* $("#frequency_id").change(function() {
	var frequency_id=$(this).val();
	 var utility_id=$("#utility_id").val();
	//  alert(utility_id);
	 
	  $.ajax({ 
			type: "POST",
			url:'<?php echo $path_to_root . "/maintenance/manage/ajax_get_breakdownrecords.php";?>',
			data: { frequency_id : frequency_id,utility_id : utility_id}
		}).done( function( data ) { 
	     //	alert(data);
			
			$("#records").html(data);
		});
});  */ 
$('[name^="Edit"]').click(function(){
   var text = $(this).attr('name');
    var matches = text.match(/[(0-9)]+/);
    
     $.ajax({ 
			type: "POST",
			url:'<?php echo $path_to_root . "/maintenance/manage/ajax_get_editbreakdowndrecords.php";?>',
			data: { selected_id: matches[0]}
		}).done( function( data ) { 
	   //  var res = JSON.parse(data);
	     $("#records").html(data)
                     /// alert(res);
//	         var utility_id=$("#utility_id").val();
//	 // alert(utility_id);
//	 $.ajax({ 
//			type: "POST",
//			url:'<?php echo $path_to_root . "/maintenance/manage/ajax_get_utlyfrequency.php";?>',
//			data: { utility_id : utility_id}
//		}).done( function( data ) { 
//	     //	alert(data);
//			$("#frequency_id").html(data);
//			$("#frequency_id").val(res['frequency_id']);
//		});
//		
//	var frequency_id=res['frequency_id'];
//	 var utility_id=$("#utility_id").val();
//	//  alert(utility_id);
//	 
//	  $.ajax({ 
//			type: "POST",
//			url:'<?php echo $path_to_root . "/maintenance/manage/ajax_get_preventiverecords.php";?>',
//			data: { frequency_id : frequency_id,utility_id : utility_id}
//		}).done( function( data ) { 
//	     //	alert(data);
//			
//			$("#records").html(data);
//			updatevale(res);
//		});
//		
		});
   
    
});
 
 </script>
 
</html>
<?php
end_page();
?>
<style>
input.sal{
width:70px;
}
</style>