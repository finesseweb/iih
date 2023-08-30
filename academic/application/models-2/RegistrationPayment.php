<?php

/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */
class Application_Model_RegistrationPayment extends Zend_Db_Table_Abstract {

    public $_name = 'registration_payment';
    protected $_id = 'id';

     public function getRecordbypaymentid($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                 ->join(array("exam"=>"ugnon_payment_details"),"exam.payment_id=$this->_name.id",array('mmp_txn','bank_name','bank_txn','date','total_fee as amt','f_code'))
                ->where("exam.$this->_id=?", $id);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    
    
    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id);
              
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    
    public function getPaymentByTermId($id,$term_id){
         $select = $this->_db->select()
                ->from($this->_name,array('payment_activation','payment_status'))
                ->where("$this->_name.u_id = ?", $id)
                ->where("$this->_name.term_id =?",$term_id)
                ->where("$this->_name.status=?",1)
                ->where("$this->_name.payment_activation=?",1)
                ->order('id  DESC');
            // echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
        
    }
        public function getPaymentByTermIdcol($id,$term_id){
         $select = $this->_db->select()
                ->from($this->_name,array('payment_activation','payment_status'))
                ->where("$this->_name.u_id = ?", $id)
                ->where("$this->_name.term_id =?",$term_id)
                ->where("$this->_name.status=?",1)
                ->where("$this->_name.payment_activation=?",0)
                ->order('id  DESC');
            // echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
        
    }
    public function getRecordbyfid($id) {
       //echo $id ; die;
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("md5($this->_name.u_id)=?", $id)
                ->where("$this->_name.academic_year_id is NOT NULL")
               ->where("$this->_name.status !=?",0)
              ->where("$this->_name.payment_activation !=?",1)
               ->order('id  DESC');
               //echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
     
    public function getRecordbyfid3($id) {
      //echo $id ; die;
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.u_id=?", $id)
                ->where("$this->_name.academic_year_id is NOT NULL")
               ->where("$this->_name.academic_year_id !=?",0)
               ->where("$this->_name.status !=?",1)
               ->order('id  DESC');
               //echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    
    public function getRecordbyfid1($id) {
       //echo $id ; die;
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("md5($this->_name.u_id)=?", $id)
                ->where("$this->_name.academic_year_id is NOT NULL")
               ->where("$this->_name.academic_year_id !=?",0)
              ->where("$this->_name.status !=?",1)
               ->order('id  desc');
            //   echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    public function getNonRecordbyfid($id,$sem) {
        $select = $this->_db->select()
                ->from($this->_name)
                 ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array())
                 ->join(array("exam"=>"examination_dates"),"exam.id=$this->_name.exam_month_id",array())
                ->where("$this->_name.u_id=?", $id)
                ->where("$this->_name.academic_year_id is NOT NULL")
                ->where("$this->_name.academic_year_id !=?",0) 
                ->where("$this->_name.payment_activation =?",1)
                ->where("exam.status =?", 1)
                ->where("exam.admit_card_status =?", 1)
                ->where("exam.cmn_terms =?", $sem)
                ->where("term.cmn_terms=?", $sem)
               //->where("$this->_name.status =?",0)
                 ->order('id  desc');
      // echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
public function getNonFormSubmitRecord($id,$sem) {
        $select = $this->_db->select()
                ->from($this->_name)
                  ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array('term_description'))
                  ->where("$this->_name.u_id=?", $id) 
               ->where("$this->_name.status =?",1)
               ->where("$this->_name.payment_activation =?",1)
                 ->where("term.cmn_terms=?", $sem)
               //->where("$this->_name.status =?",0)
                 ->order('id  desc');
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
public function getNonPreviewRecord($id,$sem) {
        $select = $this->_db->select()
                ->from($this->_name)
                  ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array('term_description'))
                  ->where("$this->_name.u_id=?", $id)
                ->where("$this->_name.academic_year_id is NOT NULL")
               ->where("$this->_name.academic_year_id !=?",0) 
               ->where("$this->_name.payment_activation =?",1)
                 ->where("$this->_name.term_id=?", $sem)
               //->where("$this->_name.status =?",0)
                 ->order('id  desc');
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    
    public function getPaymentRecordbyfid($id,$sem='') {
        $select = $this->_db->select()
                ->from($this->_name)
                 ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array('term_name'))
                ->where("$this->_name.u_id=?", $id)
                ->where("term.cmn_terms=?", $sem)
             //   ->where("$this->_name.payment_activation=?",0)
               ->where("$this->_name.payment_status=?",1)
                ->order('id  DESC');
          /// echo $select;die;    
        $result = $this->getAdapter()
                ->fetchAll($select);
         
        return $result;
    }
    
        public function getPaymentRecordbyfid1($id,$acad_id,$term_id) {
        $select = $this->_db->select()
                ->from($this->_name,array('payment_activation'))
                ->where("$this->_name.u_id=?", $id)
                ->where("$this->_name.academic_year_id=?", $acad_id)
                ->where("$this->_name.term_id=?", $term_id)
              ->where("$this->_name.payment_activation=?",1);
             // ->order('id  Asc');
        $result = $this->getAdapter()
                ->fetchRow($select);
         //echo $select;die;
        return $result['payment_activation'];
    }
    
    
     public function checkPaymentRecord($id,$sem,$exam_month_id="") {
        $select = $this->_db->select()
                ->from($this->_name,array('payment_activation','payment_status'))
                ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array())
                ->join(array("exam"=>"ugnon_payment_details"),"exam.payment_id=$this->_name.id",array('mmp_txn','bank_name','bank_txn','date','total_fee as amt','f_code','id as pay_id','payment_id','u_id'))
                ->where("md5($this->_name.u_id)=?", $id) 
                ->where("term.cmn_terms=?", $sem)
                ->where("exam.f_code like ?", "ok")
                ->where("$this->_name.payment_status=?",1)
                ->where("$this->_name.payment_activation=?",1)
                
                ->where("exam.type=?", 3);
                  
        $result = $this->getAdapter()
                ->fetchRow($select);
        // echo $select;die;
        return $result;
    }
    
     public function getRecordBysession($id ='' ,$batch_id ='') {
         
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinleft(array("acad"=>"academic_master"),"acad.session=$this->_name.session_id")
                ->where("acad.academic_year_id=?", $batch_id)
                ->where("$this->_name.session_id=?", $id);
              
        $result = $this->getAdapter()
                ->fetchAll($select);
       
        return $result;
    }
    public function getRecordByacademic($batch_id ='') {
         
        // $select = $this->_db->select()
        //         ->from($this->_name)
        //         ->join(array("exam"=>"ugnon_payment_details"),"exam.payment_id=$this->_name.id",array('mmp_txn','bank_name','bank_txn','date','total_fee as amt','exam_fee','late_fine','f_code'))
        //         ->join(array("term"=>"term_master"),"term.academic_year_id=$this->_name.academic_year_id",array('term_description','term_id','cmn_terms','academic_year_id as batch_id'))
        //         ->where("$this->_name.academic_year_id in (?)", $batch_id)
        //         ->where("$this->_name.payment_status=?", 1)
        //         ->where("exam.f_code like ?", 'Ok')
        //         ->where("exam.exam_fee < ?", 1000)
        //         ->where("term.cmn_terms =?", 't1');
        //       //  echo $select; die;
        
$select = "SELECT registration_payment.*, course_fee.examFee,registration_payment.payment_status, CASE when payment_status = 1 then course_fee.examFee ELSE 0 end as amt,CASE WHEN course_fee.feeForm_extended_date > registration_payment.created_date THEN 0 ELSE course_fee.fineFee * floor(DATEDIFF(feeForm_extended_date,created_date)/ perday) end as fine , `term`.`term_description`, `term`.`term_id`, `term`.`cmn_terms`, `term`.`academic_year_id` AS `batch_id` FROM `registration_payment` 
JOIN erp_student_information on erp_student_information.stu_id = registration_payment.u_id
JOIN academic_master on academic_master.academic_year_id  = erp_student_information.academic_id
join course_fee on course_fee.session_id = academic_master.session and course_fee.department = academic_master.department
JOIN `term_master` AS `term` ON term.academic_year_id = erp_student_information.academic_id
WHERE (registration_payment.academic_year_id in ('".implode("','",$batch_id)."')) AND (term.cmn_terms ='t1') and payment_status =1";


$result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    public function getRecords() {

         $select=$this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term"=>"declared_terms"),"term.term_des=$this->_name.cmn_terms",array("term_name"))
            ->joinleft(array("course"=>"course_master"),"course.course_id=$this->_name.course_id",array("course_name"))
            ->joinleft(array("course_cat"=>"course_category_master"),"course_cat.cc_id=$this->_name.cc_id",array("cc_name"))
            ->joinleft(array("degree_info"),"degree_info.id=$this->_name.degree_id",array("degree"))
            
            
            //->where("$this->_name.attend_status !=?",1)
            ->where("$this->_name.status !=?",2);
            //echo $select;die;
            $result=$this->getAdapter()
            ->fetchAll($select);  
            //echo"<pre>";print_r($result);die;
        return $result;
    }
    public function getDurationFromList(){
        $select = $this->_db->select()
		->from('duration', array('id','duration_from'))				
				->where("status =?",0)
                ->order('id  DESC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
		$st_year ='';
		$end_year='';
        foreach ($result as $val) {
			
			$data[date('h:i a ',strtotime($val['duration_from']))] = date('h:i a ',strtotime($val['duration_from']));
		
        }
        return $data;
    }
    public function getDurationToList(){
        $select = $this->_db->select()
          
		->from('duration', array('id','duration_to'))				
				->where("status =?",0)
                ->order('id  DESC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
		$st_year ='';
		$end_year='';
        foreach ($result as $val) {
			//date('h:i:s a m/d/Y', strtotime($date));
			$data[date('h:i a ',strtotime($val['duration_to']))] = date('h:i a ',strtotime($val['duration_to']));
		
        }
        return $data;
    }
    
     public function getPaidRecordbyfid($id,$term) {
        $select = $this->_db->select()
               ->from($this->_name,array('payment_activation','payment_status'))
               /// ->from($this->_name,array())
               // ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
                 ->where("$this->_name.u_id=?", $id)
               // ->where("$this->_name.payment_activation=?",0)
                ->where("$this->_name.term_id =?",$term)
               // ->where("$this->_name.status=?",0)
                ->where("$this->_name.payment_status=?",1)
                ->order('id  DESC');
            //echo $select; die();  
        $result = $this->getAdapter()
                ->fetchRow($select);
         
        return $result;
    }
    
     public function getNonEndExamFeeRecords($academic_id,$academic_year,$session,$sem,$exam_id){
        
         $select= "SELECT atom_tb.*,ugnon_form_submission.*,erp_student_information.*,ugnon_form_submission.id as eid from ugnon_form_submission JOIN atom_tb on atom_tb.form_id=ugnon_form_submission.u_id JOIN erp_student_information ON erp_student_information.stu_id=ugnon_form_submission.u_id WHERE ugnon_form_submission.u_id NOT IN (SELECT u_id FROM `ugnon_form_submission` WHERE `payment_status` = 1 AND term_id IN ($sem)) AND ugnon_form_submission.term_id IN ($sem) AND ugnon_form_submission.payment_status=0 AND erp_student_information.stu_status=1 AND erp_student_information.academic_id IN ($academic_id) AND ugnon_form_submission.exam_month_id='$exam_id' GROUP by ugnon_form_submission.u_id";

//            $select = $this->_db->select();
//                
//                $select->from('erp_student_information',array('stu_fname','stu_id','roll_no','exam_roll'));
//                $select->joinleft(array("ugnon_form_submission"),"$this->_name.u_id=erp_student_information.stu_id and $this->_name.term_id = '$sem'",array("u_id","id as exam_id","term_id"));
//                $select->join(array("atom_tb"),"$this->_name.u_id=atom_tb.form_id");
//                $select->where("erp_student_information.academic_id =?",$academic_id);
//                $select->where("erp_student_information.stu_status =?",1);
//                $select->where("ugnon_form_submission.payment_status =?",0);
//                $select->where("ugnon_form_submission.session_id =?",$session);
//                 $select->where("ugnon_form_submission.exam_month_id =?",$exam_id);
//                $select->group("erp_student_information.stu_id");
                //$select->order("$this->_name.id",'desc');
                //$select->limit("$this->_name.id",2);
        $result = $this->getAdapter()
                ->fetchAll($select);
      // echo $select;die;
            //echo"<pre>";print_r($result);die;
        return $result;
    } 

}

?> 