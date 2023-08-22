<?php
/** 
 * @Framework Zend Framework
 * @category   ERP Product
 *	Authors     Kedar Kumar
 */
class Application_Model_PassOutModel extends Zend_Db_Table_Abstract
{
    public $_name = 'pass_out_students';
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
    
    public function checkStudentId($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.stu_id=?", $id)				   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    public function checkPublishedData($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.academic_id=?", $id)				   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    public function checkforPassoutNo($session,$stream)
    {       
        $select=$this->_db->select()
                      ->from($this->_name,array('max(pass_out_no) as lastPassOutNo'))
                      ->where("$this->_name.session=?", $session)				   
                      ->where("$this->_name.stream=?", $stream)				   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    
    public function getRecordByIds($values)
    {       
        $select=$this->_db->select()
                      ->from($this->_name,array('department'))
                      ->where("$this->_name.$this->_id IN(?)",  explode(',',$values))
                      //->where("$this->_name.$this->_id=?", $id)				   
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchAll($select);   
        //echo $select;die;
        return $result;
    }
    //Modified 13 sept 2021
    public function getStudentsForPassOut($stream,$session,$academic_id='',$maxCountCheck)
    {       
        $select=$this->_db->select()
                      ->from($this->_name,array('stu_id','pass_out_no','publish_date'));
                      $select->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=$this->_name.stu_id", array('stu_fname','stu_lname','stu_id'));
                      $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.stu_id", array('final_remarks', 'student_id'));
                      $select->where("$this->_name.session=?", $session);
                      $select->where("tr_items.sgpa !=?", 0.00);
                      if(!empty($academic_id))
                      $select->where("$this->_name.academic_id=?", $academic_id);			   
					$select->where("$this->_name.status !=?", 2);
                    $select->group("tr_items.student_id");
                    $select->having("count(tr_items.student_id)=$maxCountCheck");
        $result=$this->getAdapter()
                      ->fetchAll($select);   
   // echo "<pre>".$select;die;
        return $result;
    }
    
	
      public function getGradeSheetNumber($batch_id, $student_dmi_id) {
         
        $select = $this->_db->select()
                ->from($this->_name,array('pass_out_no as sr_no'))                
                ->where("$this->_name.academic_id =?", $batch_id)
                ->where("$this->_name.stu_id =?", $student_dmi_id);
     //  echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
      if(is_array($result))
          return $result['sr_no'];
      else 
          return 0;
    }
	

}
?>