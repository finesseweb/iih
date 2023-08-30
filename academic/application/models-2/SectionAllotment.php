<?php
/** 
 * @Framework Zend Framework
 * @category   ERP Product
 *	Authors     Kedar Kumar
 */
class Application_Model_SectionAllotment extends Zend_Db_Table_Abstract
{
    public $_name = 'section_allotment';
    protected $_id = 'id';
  
    //get details by record for edit
	public function getRecords()
    {       
        $select=$this->_db->select()
                      ->from($this->_name)			   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchAll($select);       
        return $result;
    }
    
    public function getRecordById($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.$this->_id=?", $id)				   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    public function getAcademicYear($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.academic_year=?", $id)				   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    
	public function getFilterRecord($acad_id,$section=''){
        $select=$this->_db->select()
                      ->from($this->_name, array('stu_id','term_id','section'));
            $select->joinLeft(array("students"=>"erp_student_information"),"students.student_id=$this->_name.stu_id",array('stu_fname as studentName','roll_no','stu_id as form_id','exam_roll'));
                     $select ->joinleft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_description"));
                      $select->joinleft(array("section"=>"section_master"),"section.id=$this->_name.section",array("name as section_name"));
                      $select->where("$this->_name.academic_id=?", $acad_id);	
                      if(!empty($section))
                      $select->where("$this->_name.section=?", $section);
        
        $result=$this->getAdapter()
                      ->fetchAll($select);    
        //echo $select;die;
        return $result;
    }
	
	public function checkBatchSection($acad_id,$term_id,$section){
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.academic_id=?", $acad_id)				   
                      ->where("$this->_name.term_id=?", $term_id)				   
                      ->where("$this->_name.section=?", $section);
        
        $result=$this->getAdapter()
                      ->fetchAll($select);    
        //echo $select;die;
        return $result;
    }
	

}
?>