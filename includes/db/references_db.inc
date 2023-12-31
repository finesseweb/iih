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
//--------------------------------------------------------------------------------------------------

function get_reference($type, $id)
{
	$sql = "SELECT * FROM ".TB_PREF."refs WHERE type=".db_escape($type)." AND id=".db_escape($id);

	$result = db_query($sql, "could not query reference table");
    $row = db_fetch($result);
    return $row['reference'];
}

function get_reference1($type, $id)
{
	$sql = "SELECT * FROM ".TB_PREF."refs1 WHERE type=".db_escape($type)." AND id=".db_escape($id);

	$result = db_query($sql, "could not query reference table");
    $row = db_fetch($result);
    return $row['reference'];
}

//--------------------------------------------------------------------------------------------------
 
function update_reference($type, $id, $reference)
{
    $sql = "REPLACE ".TB_PREF."refs SET reference=".db_escape($reference)
			.", type=".db_escape($type).", id=".db_escape($id);
    db_query($sql, "could not update reference entry");
}

function update_reference1($type, $id, $reference)
{
    $sql = "REPLACE ".TB_PREF."refs1 SET reference=".db_escape($reference)
			.", type=".db_escape($type).", id=".db_escape($id);
    db_query($sql, "could not update reference entry");
}


//--------------------------------------------------------------------------------------------------

function delete_reference($type, $id)
{
	$sql = "DELETE FROM ".TB_PREF."refs WHERE type=".db_escape($type)." AND id=".db_escape($id);

	return db_query($sql, "could not delete from reference table");
}

function delete_reference1($type, $id)
{
	$sql = "DELETE FROM ".TB_PREF."refs1 WHERE type=".db_escape($type)." AND id=".db_escape($id);

	return db_query($sql, "could not delete from reference table");
}


//--------------------------------------------------------------------------------------------------

function find_reference($type, $reference)
{
	// ignore refs references for voided transactions
	$sql = "SELECT r.id FROM ".TB_PREF."refs r LEFT JOIN ".TB_PREF."voided v ON"
		." r.type=v.type AND r.id=v.id"
		." WHERE r.type=".db_escape($type)
		." AND reference=".db_escape($reference)
		." AND ISNULL(`memo_`)";

	$result = db_query($sql, "could not query reference table");

    return (db_num_rows($result) > 0);
}

function find_reference1($type, $reference)
{
	// ignore refs references for voided transactions
	$sql = "SELECT r.id FROM ".TB_PREF."refs1 r LEFT JOIN ".TB_PREF."voided v ON"
		." r.type=v.type AND r.id=v.id"
		." WHERE r.type=".db_escape($type)
		." AND reference=".db_escape($reference)
		." AND ISNULL(`memo_`)";

	$result = db_query($sql, "could not query reference table");

    return (db_num_rows($result) > 0);
}

//--------------------------------------------------------------------------------------------------

function save_next_reference($type, $reference)
{
    $sql = "UPDATE ".TB_PREF."sys_types SET next_reference=" . db_escape(trim($reference)) 
		. " WHERE type_id = ".db_escape($type);

	db_query($sql, "The next transaction ref for $type could not be updated");
}

function save_next_reference1($type, $reference)
{
    $sql = "UPDATE ".TB_PREF."sys_types1 SET next_reference=" . db_escape(trim($reference)) 
		. " WHERE type_id = ".db_escape($type);

	db_query($sql, "The next transaction ref for $type could not be updated");
}


//--------------------------------------------------------------------------------------------------

function get_next_reference($type)
{
   $sql = "SELECT next_reference FROM ".TB_PREF."sys_types WHERE type_id = ".db_escape($type);

    $result = db_query($sql,"The last transaction ref for $type could not be retreived");

    $row = db_fetch_row($result);
    return $row[0]; 
	
}

function get_next_reference1($type)
{
   $sql = "SELECT next_reference FROM ".TB_PREF."sys_types1 WHERE type_id = ".db_escape($type);

    $result = db_query($sql,"The last transaction ref for $type could not be retreived");

    $row = db_fetch_row($result);
    return $row[0]; 
	
}

?>