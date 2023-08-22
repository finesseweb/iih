<?php
/** 
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 *	Authors Kannan and Rajkumar
 */
class Application_Model_ReferenceGradeMaster extends Zend_Db_Table_Abstract
{
    public $_name = 'reference_grade_master';
    protected $_id = 'reference_id';
  
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
						->joinleft(array("ref"=>"reference_grade_master_items"),"ref.reference_id=$this->_name.reference_id",array('GROUP_CONCAT(letter_grade) as from_date','GROUP_CONCAT(number_grade) as batch_code'))
					  ->joinleft(array("cat"=>"course_category_master"),"cat.cc_id=$this->_name.cc_id",array('cc_name'))
					  ->where("$this->_name.status !=?", 2)
					  ->group(array("$this->_name.cc_id","$this->_name.degree_id"))
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
		
	public function getExitstingRecord($academic_id,$degree,$session)
	{
		$select = $this->_db->select()
					->from($this->_name,array('count(academic_year_id) as academic_count'))
					 ->where("$this->_name.academic_year_id=?",$academic_id)
					 ->where("$this->_name.degree_id=?",$degree)
					 ->where("$this->_name.session=?",$session)
					->where("$this->_name.status !=?", 2);
				$result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;	
		
	}


public function getExitstingRe($degree,$session)
	{
		$select = $this->_db->select()
					->from($this->_name,array('count(cc_id) as cc_id'))
					
					 ->where("$this->_name.degree_id=?",$degree)
					 ->where("$this->_name.session=?",$session)
					->where("$this->_name.status !=?", 2);
				$result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;	
		
	}	
		public function getRefrenceRecord($degree,$session)
	{
		$select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("reference_items"=>"reference_grade_master_items"),"reference_items.reference_id=$this->_name.reference_id",array("reference_items.letter_grade"))
					 ->where("$this->_name.degree_id=?",$degree)
					 ->where("$this->_name.session=?",$session)
					->where("$this->_name.status !=?", 2);
				$result=$this->getAdapter()
                      ->fetchAll($select);       
        return $result;	
		
	}
}
?>