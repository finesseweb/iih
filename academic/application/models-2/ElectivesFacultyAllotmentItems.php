<?php
/** 
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 *	Authors Kannan and Rajkumar
 */
class Application_Model_ElectivesFacultyAllotmentItems extends Zend_Db_Table_Abstract
{
    public $_name = 'electives_faculty_allotment_items';
    protected $_id = 'electives_faculty_item_id';
  
    //get details by record for edit
	public function getRecords($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.faculty_allotment_id=?", $id)	;		   
					  
        $result=$this->getAdapter()
                      ->fetchAll($select);    
    //print_r($result);die;					  
        return $result;
    }
	
	public function trashItems($id) {

        $this->_db->delete($this->_name, "faculty_allotment_id=$id");

    }
	
	
	
	

}
?>