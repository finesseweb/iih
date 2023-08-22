//<?php
/**
 * Application_Model_ErpInventoryGrnItems
 *
 * @Framework Zend Framework
 * @Powered By TIS
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2014 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 */
class Application_Model_BackSelectionItems extends Zend_Db_Table_Abstract {

    protected $_name = 'back_selection_items';
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
				//echo $select; die;
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

	
   public function trashItems($elective_id='') {
        $this->_db->delete($this->_name, "elective_id = $elective_id");
    }
	
	public function getItemsRecords($elective_id) {
        $select = $this->_db->select()
                ->from($this->_name)
				 ->where("$this->_name.elective_id=?", $elective_id);
        $result = $this->getAdapter()
                ->fetchAll($select);
	
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

          public function getelectivestudentDetails1($academic_id='',$term_id='',$course_id='',$ge_id = 0,$pay=false,$month="")
    {  
    
        $select=$this->_db->select();
            $select->from($this->_name,array());	
            $select->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array("term_name","cmn_terms"));
            $select->join(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"));
            $select->join(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("short_code as academic_year",'session'));
            //$select->join(array("exam"=>"examchecker"),"exam.session=acad.session");
            //$select->join(array("exam1"=>"examchecker"),"exam1.sem=term.cmn_terms");
            if($pay){
             $select->join(array("payment_ug"=>"ugnon_form_submission"),"payment_ug.student_id=student.student_id",array());
             $select->join(array("exam_dates"=>"examination_dates"),"exam_dates.id=payment_ug.exam_month_id",array());
            }
            else
            {
            $select->join(array("gradem"=>"grade_allocation_master"),"gradem.academic_id=student.academic_id and gradem.term_id = $this->_name.terms",array());
            $select->join(array("gradei"=>"grade_allocation_items"),"gradei.grade_allocation_id=gradem.grade_id and gradei.student_id = $this->_name.students_id",array());
            }
            $select->where("term.academic_year_id in(?)", explode(',',$academic_id));
            if($ge_id ==0){
            $select->where("$this->_name.ge_id=?", $ge_id);
            }
            else {
                $select->where("$this->_name.ge_id !=?", 0);
            }
             $select->where("$this->_name.fail_status =?", 0);
             //====================[As per bhupendar only active student will show in attendance sheet] 14:02:2023 16:06
              $select->where("student.stu_status = ?", 1);
             if($pay){
             $select->where("payment_ug.payment_status =?", 1);
              $select->where("payment_ug.term_id in (?)", explode(',',$term_id));
              if($month){
            $select->where("DATE_FORMAT(exam_dates.exam_date,'%b-%Y') like ?", $month);}
             }else{
                 $select->where("gradem.course_id =?", $course_id);
                 $select->where("gradem.flag = ?", 'R');
                  //$select->where("substring_index(substring_index(gradei.grade_value,',',1),',',-1) REGEXP (?)", "(F|NA|Ab)");
                  $select->where("gradei.grade_value REGEXP (?)", "(F|NA|Ab|D)");
             }
            $select->where("term.term_id in (?)", explode(',',$term_id));
            $select->order("student.exam_roll");
            $select->where("$this->_name.electives=?", $course_id);
            $select->group("$this->_name.students_id");
        //   echo "<pre>".$select;exit;
            $result=$this->getAdapter()
            ->fetchAll($select); 
            
         if($pay){
            if(!count($result))
          return $this->getelectivestudentDetails2($academic_id,$term_id,$course_id,$ge_id,$pay,$month );
         }
         // print_r($result); die();
        return $result;
    }
    
              public function getelectivestudentDetails2($academic_id='',$term_id='',$course_id='',$ge_id = 0,$pay,$month="")
    {  
        
        
        $select=$this->_db->select();
            $select->from($this->_name,array());	
            $select->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array("term_name"));
            $select->joinLeft(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"));
            $select->joinLeft(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("short_code as academic_year"));
             if($pay){
             $select->join(array("payment_pg"=>"pg_non_form_data"),"payment_pg.student_id=student.student_id",array());
             $select->join(array("exam_dates"=>"examination_dates"),"exam_dates.id=payment_pg.exam_month_id",array());
             }
             else
             {
            $select->join(array("gradem"=>"grade_allocation_master"),"gradem.academic_id=student.academic_id and gradem.term_id = term.term_id",array());
            $select->join(array("gradei"=>"grade_allocation_items"),"gradei.grade_allocation_id=gradem.grade_id and gradei.student_id = $this->_name.students_id",array());
             }
            $select->where("term.academic_year_id in(?)", explode(',',$academic_id));
            if($ge_id ==0){
            $select->where("$this->_name.ge_id=?", $ge_id);
            }
            else {
                $select->where("$this->_name.ge_id !=?", 0);
            }
             $select->where("$this->_name.fail_status =?", 0);
            $select->where("student.stu_status not in (?)", array(2,3));
              if($pay){
             $select->where("payment_pg.payment_status =?", 1);
              $select->where("payment_pg.term_id in (?)", explode(',',$term_id));
              if($month){
            $select->where("DATE_FORMAT(exam_dates.exam_date,'%b-%Y') like ?", $month);}
              }
              else{
                  $select->where("gradem.course_id =?", $course_id);
                  $select->where("gradem.flag = ?", 'R');
                  $select->where("substring_index(substring_index(gradei.grade_value,',',1),',',-1) REGEXP (?)", "(F|NA|Ab)");
             }
            $select->where("term.term_id in (?)", explode(',',$term_id));
            $select->order("student.exam_roll");
            $select->where("$this->_name.electives=?", $course_id);
     
            $result=$this->getAdapter()
            ->fetchAll($select);    	  
        return $result;
    }
    
    public function getStuRecords($uid,$sem) {
                $select = $this->_db->select()

                ->from($this->_name)
                ->join(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"))
                 ->join(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("session","department"))
                 ->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array())
                 ->where("md5(student.stu_id)=?", $uid)
                 ->where("term.cmn_terms=?", $sem)
                 ->where("$this->_name.fail_status=?", 0);
                $result = $this->getAdapter()

                ->fetchAll($select);



        return $result;

    }
        public function getStudRecordsbydate($uid,$pblisdate = "2023-04-30") {
                $select = $this->_db->select()

                ->from($this->_name)
                ->join(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"))
                 ->join(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("session","department"))
                 ->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array())
                 ->where("student.stu_id=?", $uid)
                 ->where("$this->_name.publish_date >=?", $pblisdate);
                $result = $this->getAdapter()

                ->fetchRow($select);



        return $result;

    }
    
    
     public function getStuSubRecords($uid,$sem) {
                $select = $this->_db->select()

                ->from($this->_name)
                ->join(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"))
                 ->join(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("session","department"))
                 ->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array())
                 ->where("student.stu_id=?", $uid)
                 ->where("term.cmn_terms=?", $sem)
                 ->where("$this->_name.fail_status=?", 0);
                $result = $this->getAdapter()

                ->fetchAll($select);

//echo $select; exit;

        return $result;

    }
   public function getStuPreviewRecords($uid,$sem) {
                $select = $this->_db->select()

                ->from($this->_name)
                ->join(array("student"=>"erp_student_information"),"student.student_id=$this->_name.students_id",array("student.*"))
                 ->join(array("acad"=>"academic_master"),"acad.academic_year_id=student.academic_id",array("session","department"))
                 //->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms",array())
                 ->where("student.stu_id=?", $uid)
                 ->where("$this->_name.terms=?", $sem)
                 ->where("$this->_name.fail_status=?", 0);
                $result = $this->getAdapter()

                ->fetchAll($select);

//echo $select; exit;

        return $result;

    } 
    
  public function getStudentForNonColRecords($academic_id,$sem,$exmId='',$pay=''){
      //  echo $pay; die();
            $select = $this->_db->select();
                
                $select->from('erp_student_information'  ,array('stu_fname','stu_id','roll_no','exam_roll'));
              
                $select->joinleft(array("back_selection_items"),"$this->_name.students_id=erp_student_information.student_id");
                $select->joinleft(array("term_master"),"term_master.term_id=back_selection_items.terms",array("term_id"));
                 
               
                //$select->joinleft(array("department"),"department.id=$this->_name.department",array("department"));
                if(!empty($pay)){
                $select->joinleft(array("ugnon_form_submission"),"ugnon_form_submission.u_id=erp_student_information.stu_id",array("exam_month_id","term_id"));
                $select->joinleft(array("ugnon_payment_details"),"ugnon_payment_details.payment_id = ugnon_form_submission.id",array("exam_fee","late_fine"));
                }
               
                $select->where("erp_student_information.academic_id in (?)",$academic_id);
                if(!empty($pay)){
                $select->where("ugnon_form_submission.exam_month_id in (?)",$exmId);
                $select->where("ugnon_form_submission.payment_status = (?)",1);
                }
                $select->where("erp_student_information.stu_status =?",1);
                $select->where("term_master.cmn_terms =?",$sem);
                $select->where("$this->_name.fail_status =?",0);
                $select->group("erp_student_information.stu_id");
                //echo "<prE>".$select;die;
                //$select->limit("$this->_name.id",2);
        $result = $this->getAdapter()
                ->fetchAll($select);
         
          //  echo"<pre>";print_r($result);die;
        return $result;
    }   


    
    public function getDropDownNonugList() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("erp" => "erp_student_information"), "erp.student_id=$this->_name.students_id")
            ->join(array("acad" => "academic_master"), "acad.academic_year_id=erp.academic_id")
            ->where("$this->_name.fail_status =?", 0)
            ->where("erp.status !=?", 2)
            ->order('acad.academic_year_id  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {
            //echo"<pre>";print_r($val);exit;
            $data[$val['academic_year_id']] = $val['short_code'];

            //$data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
            //$data[$val['session_id']] =$val['session'];
            //echo "<pre>";print_r($data);die;
        }
        return $data;
    }
 
    public function getPreviousrecord($sem,$stu_id,$last_attempt_year='') {
        
         if ($sem != 't1') {
                    $term_id_arr = explode('t', $sem);
                    $term_id = ((int) $term_id_arr[1]) - 1;
                    $term_id = 't' . $term_id;
                }
                
                $select = $this->_db->select()

                ->from($this->_name)
                ->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms")
                 ->join(array("exam"=>"examchecker"),"exam.sem=term.cmn_terms")        
                 ->where("$this->_name.students_id=?", $stu_id)
                 ->where("term.cmn_terms=?", $term_id)
               ///  ->where("exam.last_attempt_year<=?", $last_attempt_year)  
                  ->where("$this->_name.fail_status=?", 0);
                $result = $this->getAdapter()

                ->fetchAll($select);

//echo $select; exit;

        return $result;

    }  
    
    
    
     public function getPreviousrecordnew($sem,$stu_id,$session='') {
        
         if ($sem != 't1') {
                    $term_id_arr = explode('t', $sem);
                    $term_id = ((int) $term_id_arr[1]) - 1;
                    $term_id = 't' . $term_id;
                }
                
                $select = $this->_db->select()

                ->from($this->_name)
                ->join(array("term"=>"term_master"),"term.term_id=$this->_name.terms")
                 ->join(array("exam"=>"examchecker"),"exam.sem=term.cmn_terms")        
                 ->where("$this->_name.students_id=?", $stu_id)
                 ->where("term.cmn_terms=?", $term_id)
                 ->where("exam.session =?", $session)  
                  ->where("$this->_name.fail_status=?", 0);
                $result = $this->getAdapter()

                ->fetchAll($select);

echo $select; exit;

        return $result;

    }  
	

		
	
	
}