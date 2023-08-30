<?php
/** 
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 *	Authors Kannan and Rajkumar
 */
class Application_Model_AddonReferenceGrade extends Zend_Db_Table_Abstract
{
    public $_name = 'addons_ref_grade_manual';
    protected $_id = 'id';
  
    //get details by record for edit
public function getRecord($reference_id)
    {       
    $select=$this->_db->select()
    ->from($this->_name)
    ->where("$this->_name.$this->_id=?", $reference_id)				   
    ->where("$this->_name.status !=?", 2);
    $result=$this->getAdapter()
    ->fetchRow($select);  
    return $result;
    }
	
	//Get all records
public function getRecords()
    {       
    $select=$this->_db->select()
    ->from($this->_name)
     ->order("$this->_name.$this->_id DESC");
        $result=$this->getAdapter()
    ->fetchAll($select);       
        return $result;
    }
    
public  function getNumberGradeValue($academic_id,$letter_grade,$deg_id='',$session=''){
   if(!empty($letter_grade)){
	$select = $this->_db->select()
	->from($this->_name)
        ->joinLeft(array("reference_items"=>"reference_grade_master_items"),"reference_items.reference_id=$this->_name.reference_id")
        ->where("$this->_name.academic_year_id=?",$academic_id)
	->where("reference_items.letter_grade=?",$letter_grade)
	->where("$this->_name.degree_id=?",$deg_id)
	->where("$this->_name.session=?",$session)
	->where("$this->_name.status !=?", 2);
	$result=$this->getAdapter()
        ->fetchRow($select);       
        return $result;	
                }
         else {return 0;}
	}
		
public function getExitstingRecord($flag)
	{
	$select = $this->_db->select()
	->from($this->_name,array('count(flag) as academic_count'))
	->where("$this->_name.flag=?",$flag);
	$result=$this->getAdapter()
        ->fetchRow($select);       
        return $result;	
		
	}	
	
}
?>