<?php

class Application_Model_SubmitAssignment extends Zend_Db_Table_Abstract {

    public $_name = 'assignment_submitted';
    protected $_id = 'submitted_id';

    
      public function getstudents($batch,$term='',$courseId){
          
          $select = $this->_db->select()
                ->from('core_course_master',array('cc_id'))
                ->where("core_course_master.course_id=?", $courseId);

            $result = $this->getAdapter()
                ->fetchRow($select);
            if($result['cc_id'] == 1){
                $select = $this->_db->select()
            ->from("academic_master",array("department"))
            ->where("academic_master.academic_year_id =?",$result['core_course1']);
       
            $select = $this->_db->select()
               // ->distinct()
                ->from(array('info'=>'erp_student_information'))
                //->join(array("elective" => "erp_elective_selection_items"), "electives.student_id=info.student_id")
                  
                //->where("elective.term_id=?", $term)
                //->where("elective.electives=?", $courseId)
                ->where("info.academic_id =?", $batch)
                  ->group('info.student_id');
        //echo $select; exit;
        $result1 = $this->getAdapter()
                ->fetchAll($select);
        return $result1;
            }else{
                $select = $this->_db->select()
            ->from("academic_master",array("department"))
            ->where("academic_master.academic_year_id =?",$result['core_course1']);
       
            $select = $this->_db->select()
               // ->distinct()
                ->from(array('info'=>'erp_student_information'))
                ->join(array("elective" => "erp_elective_selection_items"), "elective.students_id=info.student_id")
                  
                ->where("elective.terms=?", $term)
                ->where("elective.electives=?", $courseId)
                ->where("info.academic_id =?", $batch)
                  ->group('info.student_id');
        //echo $select; exit;
        $result1 = $this->getAdapter()
                ->fetchAll($select);
        return $result1;
            }
            
    }
    
    
    
      public function getstudentsbyEmpl($session, $cmnTerms, $section,$cc_id,$dept='',$courseId=''){
       
        $select=$this->_db->select()
                      ->from($this->_name)	
                ->joinLeft(array("assignment" => "faculty_assignment"), "assignment.assignment_id=$this->_name.assignment_id");
                $select->where("assignment.session= ?",$session);
                $select->where("assignment.cmn_terms = ?", $cmnTerms);
                $select->where("assignment.cc_id = ?", $cc_id);
                if(!empty($dept))
                $select->where("assignment.cmn_terms = ?", $cmnTerms);
                if(!empty($courseId))
                $select->where("assignment.course_id =?",$courseId);
                $select->where("assignment.empl_id =?", $_SESSION['admin_login']['admin_login']->empl_id);
                
		  $select->where("assignment.status !=?", 2);
          //echo $select;die;
        $result=$this->getAdapter()
                      ->fetchAll($select);    

        return $result;
    }
    
    
      public function getstudentsWithoutEmpl($batch,$term,$course_id){
       
        $select=$this->_db->select()
                      ->from($this->_name)	
                ->joinLeft(array("assignment" => "faculty_assignment"), "assignment.assignment_id=$this->_name.assignment_id")
                ->where("assignment.academic_year_id= ?",$batch)
                ->where("assignment.term_id = ?", $term)
                 ->where("$this->_name.course_id =?",$course_id)
               // ->where("assignment.student_id = ?",$_SESSION['admin_login']['admin_login']->student_id)
              //  ->where("assignment.empl_id =?", $_SESSION['admin_login']['admin_login']->empl_id)
                // ->where("assignment.notification_status !=?", 1)
               // ->where("assignment.assignment_status !=?", 1)
		  ->where("assignment.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchAll($select);    

        return $result;
    }
    
    
    
    
}