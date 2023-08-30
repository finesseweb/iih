<?php
/**
 * Application_Model_ErpInventoryGrnItems
 *
 * @Framework Zend Framework
 * @Powered By TIS
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2014 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 */
class Application_Model_ElectiveSelectionItems extends Zend_Db_Table_Abstract {

    protected $_name = 'erp_elective_selection_items';
    protected $_id = 'items_id';

    /**
     * Set Primary Key Id as a Parameter 
     *
     * @param string $id
     * @return single dimention array
     */
    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_id=?", $id);
				//echo $select; die;getByTermId
        $result = $this->getAdapter()
                ->fetchRow($select);
				
        return $result;
    }

    /**
     * Retrieve all Records
     *
     * @return Array
     */
    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name);
				//->where("$this->_name.items_status !=2");
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }

	
   public function trashItems($elective_id='',$course_id='') {
      $where =   array("elective_id = $elective_id");
       if($course_id)
       {
         $where = array("elective_id = $elective_id","electives=$course_id")  ;
       }
       
        $this->_db->delete($this->_name, $where);
    }
	
   public function trashItemsAll($academic_id='',$term_id='') {
        $this->_db->delete($this->_name,"terms = $term_id");
    }
   public function trashItemsAll1($academic_id='',$course_id='') {
        $this->_db->delete($this->_name,"electives = $course_id");
    }
	
	public function getItemsRecords($elective_id) {
        $select = $this->_db->select()
                ->from($this->_name)
				 ->where("$this->_name.elective_id=?", $elective_id);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    
    	public function getGEAeccforTermOne($elective_id,$student_id) {
        $select = $this->_db->select()
                ->from($this->_name,array("case 
WHEN `erp_elective_selection_items`.`electives` not in(4,5) THEN
ge_id
END as ge_id",
"case WHEN `erp_elective_selection_items`.`electives` in(4,5) THEN
electives
END as aecc"))
				 ->where("$this->_name.elective_id=?", $elective_id);
				 
				 $supselect = $this->_db->select()
				 ->from($select,array("group_concat(Distinct ge_id) as ge_id , group_concat(Distinct aecc) as aecc"));
// 			if($student_id == 11041){
// 			    echo "<pre>".$supselect; die;
// 			}
        $result = $this->getAdapter()
                ->fetchAll($supselect);
        return $result;
    }
    
    
     public function getCoreCouseDetailByTermGeStudentAll($academic_year_id,$term_id,$ge_id){
        $select=$this->_db->select()
                      ->from($this->_name,array('course_id'))
                      ->where("$this->_name.academic_year_id=?", $academic_year_id)
                        ->where("$this->_name.term_id=?", $term_id)
                        ->where("$this->_name.ge_id=?", $ge_id)
                        ->where("$this->_name.status !=?", 2);
        //  echo $select;die;
        $result=$this->getAdapter()
                      ->fetchAll($select);   
        return $result;	

	}
     public function getCoreCouseDetailByTermGeStudentAllwithcourse($academic_year_id,$term_id,$course){
        $select=$this->_db->select()
                      ->from($this->_name,array('electives','students_id'))
                      ->join(array('term'=>'term_master'),"term.term_id = $this->_name.terms",array())
                      ->join(array('student'=>'erp_student_information'),"student.student_id = $this->_name.students_id",array('academic_id'))
                        ->where("term.cmn_terms=?", $term_id)
                        ->where("$this->_name.electives=?", $course);
        $result=$this->getAdapter()
                      ->fetchAll($select);   
        return $result;	

	}
     public function getElectiveId($academic_year_id,$term_id,$student_id){
        $select=$this->_db->select()
                      ->from("erp_elective_selection",array('elective_id'))
                        ->where("erp_elective_selection.academic_year_id=?", $academic_year_id)
                        ->where("erp_elective_selection.term_id=?", $term_id)
                        ->where("erp_elective_selection.student_id=?", $student_id);
        //  echo $select;die;
        $result=$this->getAdapter()
                      ->fetchRow($select);   
        return $result['elective_id'];	

	}

        
  public function getCouseDetailByStudentId($academic_year_id,$term_id='',$ge_id){
        $select=$this->_db->select()
                      ->from($this->_name)
                ->join(array("select1" => "erp_elective_selection"), "select1.elective_id=$this->_name.elective_id",array())
                 ->where("select1.academic_year_id=?", $academic_year_id)
                        ->where("$this->_name.terms=?", $term_id)
                      ->where("$this->_name.students_id=?", $ge_id);
      //  echo $select;die;
        $result=$this->getAdapter()
                      ->fetchAll($select);   
        
        //print_r($result);
        //die();
        
        
        return $result;	

	}
        
        public function getByTermId($term_id){
            
           $select=$this->_db->select()
            ->from($this->_name,array("distinct(electives) as course_ids"))	
            ->where("$this->_name.terms=?", $term_id);
            
            $result=$this->getAdapter()
            
            ->fetchAll($select);    	  
        return $result;
            
        }
    

    public function getTermIdByFid($id)
    {       
        $select=$this->_db->select()
            ->from($this->_name,array("max(`terms`) as terms"))	
            ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array('term_name'))
            ->where("$this->_name.students_id=?", $id);
            $result=$this->getAdapter()
            ->fetchAll($select);    
  	//echo"<pre>";print_r($result);die;	  
        return $result;
    }
    
    
    
    public function getelectivestudentDetails($academic_id='',$term_id='',$course_id='')
    {       
        $select=$this->_db->select()
            ->from($this->_name,array())	
            ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array())
            ->joinLeft(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array('student_id','concat(stu_id,"-",stu_fname) as name'))
              
            ->where("term.academic_year_id in(?)", explode(',',$academic_id))
            ->where("term.cmn_terms=?", $term_id)
            ->where("$this->_name.electives=?", $course_id);
            $result=$this->getAdapter()
            ->fetchAll($select);    
  	//echo"<pre>";print_r($result);die;	  
        return $result;
    }
    
    public function getelectivestudentDetails1($academic_id='',$term_id='',$course_id='',$pay=false,$attendance = false)
    {  
              
       $term_model = new Application_Model_TermMaster();
     $termpay = $term_model->getTermRecordsbycmnelective(explode(',',$academic_id),$term_id);
  //   Echo $academic_id; die;
     $term_id1 = $term_id;
      $currentTerm=$term_id1;
            if($term_id1 != 't1'){
            $term_id_arr = explode('t',$term_id1);
            $term_id1 = ((int)$term_id_arr[1])-1;
            $term_id1 = 't'.$term_id1;
            }
        $select=$this->_db->select();
            $select->from($this->_name,array())	;
            
            $select->join(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"));
            $select->join(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("short_code as academic_year"));
            if($pay){
             $select->join(array("payment_ug"=>"exam_form_submission"),"payment_ug.student_id=student.student_id",array());
            }
            if($attendance){
                $select->joinLeft(array("semester_wise_attendance_report"),"semester_wise_attendance_report.u_id = student.stu_id",array("component_paper","max(attend_status) as attend_status"));}
                if($currentTerm !='t1' ){   
                    
                        $select->join(array('tab_items'=>'tabulation_report_items'),"tab_items.student_id = $this->_name.students_id",array());
                        $select->join(array('tab_report'=>'tabulation_report'),"tab_report.tabl_id = tab_items.tabl_id",array());
                        $select->join(array('term'=>'term_master'),"term.academic_year_id = tab_report.academic_id and term.term_id = tab_report.term_id",array('term_name',"term_id","cmn_terms","academic_year_id"));
                        $select->where("term.cmn_terms =?", $term_id1);
                        $select->where("tab_items.promotion_text like ?", 'Promoted'.'%');
                }
                else
                {
                    $select->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array("term_name"));
                }
            $select->where("term.academic_year_id in(?)", explode(',',$academic_id));
            if($attendance){
             $select->where("semester_wise_attendance_report.cmn_terms =?",$currentTerm);
               $select->where("semester_wise_attendance_report.course_id =?",$course_id);
            }
            //====================[As per bhupendar only active student will show in attendance sheet] 14:02:2023 16:06
             $select->where("student.stu_status = ?", 1);
             if($pay){
             $select->where("payment_ug.payment_status =?", 1);
            $select->where("payment_ug.term_id in (?)", explode(',',$termpay));
             }
                 if($attendance){
            $select->group("semester_wise_attendance_report.u_id");
                 }
            $select->order("student.exam_roll");
            
            $select->where("$this->_name.electives=?", $course_id);
             $select->group("$this->_name.students_id");
           // echo $select; die;
            
             if($attendance){
                 $select1=$this->_db->select();
            $select1->from($select);
            $select1->where("attend_status=?",0);
                    $result=$this->getAdapter()
                    ->fetchAll($select1);    
             }
             else
             {
                 $result=$this->getAdapter()
                    ->fetchAll($select);  
             }
       //   echo $select1; die;
        return $result;
    }
        
   public function saveRows($array) {
        $vAmount    = count($array);
        $values     = array();
        $columns    = array();
    if($vAmount>0){
        foreach ($array as $colval) {
            foreach ($colval as $column=>$value) {
                array_push($values,$value);
                !in_array($column,$columns) ? array_push($columns,$column) : null;
            }
        }

        $cAmount    = count($columns);
        $values     = array_chunk($values, $cAmount);
        $iValues    = '';
        $iColumns   = implode("`, `", $columns);

        for($i=0; $i<$vAmount;$i++)
            $iValues.="('".implode("', '", $values[$i])."')".(($i+1)!=$vAmount ? ',' : null);

        $data="INSERT INTO `".$this->_name."` (`".$iColumns."`) VALUES ".$iValues;
   //     echo $data; die;
        $this->getAdapter()->query($data);
    }
   }
	
}