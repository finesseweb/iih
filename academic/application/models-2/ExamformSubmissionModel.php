<?php
/* 
    Author: Raushan Kumar
    Date: 25  Oct. 2019
    Summary: This model is made for exam Form Submit Record
*/
class Application_Model_ExamformSubmissionModel extends Zend_Db_Table_Abstract {

    public $_name = 'exam_form_submission';
    protected $_id = 'id';

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id);
              
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
              // ->where("$this->_name.status=?",0)
              ->where("$this->_name.non_collegiate_status !=?",1)
               ->order('id  DESC');
               //echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        //  echo"<pre>";print_r($result);die;
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
               //echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    public function getNonRecordbyfid($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.u_id=?", $id)
                ->where("$this->_name.academic_year_id is NOT NULL")
                ->where("$this->_name.academic_year_id !=?",0) 
                ->where("$this->_name.non_collegiate_status =?",1);
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    

    
    public function getPaymentRecordbyfid($id,$term) {
        $select = $this->_db->select()
               //->from($this->_name,array('payment_activation','payment_status','academic_year_id','student_id','session_id'))
                ->from($this->_name)
                ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
                 ->where("md5($this->_name.u_id)=?", $id)
                ->where("$this->_name.non_collegiate_status=?",0)
                ->where("term.cmn_terms =?",$term)
               // ->where("$this->_name.status=?",0)
                ->where("$this->_name.payment_status=?",1)
                ->order('id  DESC');
        // echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
          // echo"<pre>";print_r($result);die;  
        return $result;
    }
    
     public function getPaymentactivefid($id,$term) {
        $select = $this->_db->select()
               //->from($this->_name,array('payment_activation','payment_status','academic_year_id','student_id','session_id'))
                ->from($this->_name)
                ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
                 ->where("md5($this->_name.u_id)=?", $id)
                ->where("$this->_name.non_collegiate_status=?",0)
                ->where("term.cmn_terms =?",$term)
               // ->where("$this->_name.status=?",0)
              //  ->where("$this->_name.payment_status=?",1)
                ->order('id  DESC');
          
        $result = $this->getAdapter()
                ->fetchRow($select);
          // echo"<pre>";print_r($result);die;  
        return $result;
    }
    
    public function getPaidRecordbyfid($id,$term) {
        $select = $this->_db->select()
            ->from($this->_name,array('payment_activation','payment_status'))
            /// ->from($this->_name,array())
             ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
              ->where("$this->_name.u_id=?", $id)
            // ->where("$this->_name.non_collegiate_status=?",0)
             ->where("term.cmn_terms =?",$term)
            // ->where("$this->_name.status=?",0)
             ->where("$this->_name.payment_status=?",1)
             ->order('id  DESC');
        // echo $select; die();  
        $result = $this->getAdapter()
             ->fetchRow($select); 
            // echo "<pre>";print_r($result);exit;
            if($result['payment_status']==1){
        return $result;
            }
            return 0;
    }
    
   
    
    
    public function getAllPaidRecordbyfid($id,$term) {
        $select = $this->_db->select()
            ->from($this->_name)
             ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
              ->where("$this->_name.u_id=?", $id)
             ->where("term.cmn_terms =?",$term)
             ->where("$this->_name.payment_status=?",1)
             ->order('id  DESC');
         //echo $select; die();  
        $result = $this->getAdapter()
             ->fetchAll($select);         
        return $result;
    }
    
        public function getAllRecordbyfid($id,$term) {
        $select = $this->_db->select()
            ->from($this->_name)
             ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
              ->where("$this->_name.u_id=?", $id)
             ->where("term.cmn_terms =?",$term)
             ->order('id  DESC');
         //echo $select; die();  
        $result = $this->getAdapter()
             ->fetchRow($select);         
        return $result;
    }
    
    public function isPaymentExist($id,$term) {
        $select = $this->_db->select()
                ->from($this->_name,array('payment_activation','payment_status'))
                 ->join(array("term"=>"term_master"),"term.term_id=$this->_name.term_id")
                ->where("md5($this->_name.u_id)=?", $id)
                ->where("$this->_name.non_collegiate_status=?",0)
                ->where("term.cmn_terms =?",$term)
                ->where("$this->_name.status=?",1)
                ->order('id  DESC');
             
        $result = $this->getAdapter()
                ->fetchRow($select);
         // echo"<pre>".$select;die;
        return $result;
    }
    
        public function getPaymentRecordbyfid1($id,$acad_id,$term_id) {
        $select = $this->_db->select()
                ->from($this->_name,array('payment_activation'))
                ->where("$this->_name.u_id=?", $id)
                ->where("$this->_name.academic_year_id=?", $acad_id)
                ->where("$this->_name.term_id=?", $term_id)
              ->where("$this->_name.non_collegiate_status=?",1);
             // ->order('id  Asc');
        $result = $this->getAdapter()
                ->fetchRow($select);
         //echo $select;die;
        return $result['payment_activation'];
    }
    
    public function getPaymentByTermId($id,$term_id){
         $select = $this->_db->select()
                ->from($this->_name,array('payment_activation','payment_status'))
                ->where("$this->_name.u_id = ?", $id)
                ->where("$this->_name.term_id =?",$term_id)
                ->where("$this->_name.status=?",1)
                ->order('id  DESC');
            // echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
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
//      public function getEndExamFeeRecords($academic_id,$academic_year,$session,$sem){
      
       
//       $select= "SELECT atom_tb.*,exam_form_submission.*,erp_student_information.*,exam_form_submission.id as eid from exam_form_submission JOIN atom_tb on atom_tb.form_id=exam_form_submission.u_id JOIN erp_student_information ON erp_student_information.stu_id=exam_form_submission.u_id WHERE exam_form_submission.u_id NOT IN (SELECT u_id FROM `exam_form_submission` WHERE `payment_status` = 1 AND term_id IN ($sem)) AND exam_form_submission.term_id IN ($sem) AND exam_form_submission.payment_status=0 AND erp_student_information.stu_status=1 AND erp_student_information.academic_id IN ($academic_id) GROUP by exam_form_submission.u_id";
//  echo "<pre>".$select;die;

// //       $select = $this->_db->select();
// //                
// //                $select->from('erp_student_information',array('stu_fname','stu_id','roll_no','exam_roll'));
// //                $select->joinleft(array("exam_form_submission"),"$this->_name.u_id=erp_student_information.stu_id and $this->_name.term_id = '$sem'",array("u_id","id as exam_id","term_id"));
// //                $select->join(array("atom_tb"),"$this->_name.u_id=atom_tb.form_id");
// //                $select->where("erp_student_information.academic_id =?",$academic_id);
// //                $select->where("erp_student_information.stu_status =?",1);
// //                $select->where("exam_form_submission.payment_status =?",0);
// //                $select->group("erp_student_information.stu_id");
//                 //$select->order("$this->_name.id",'desc');
//                 //$select->limit("$this->_name.id",2);
//         $result = $this->getAdapter()
//                 ->fetchAll($select);
//         echo "<pre>".$select;die;
//             //echo"<pre>";print_r($result);die;
//         return $result;
//     } 
    
    
     public function getEndExamFeeRecords($academic_id,$academic_year,$session,$terms) {
        $select = "SELECT ugnon_form_submission.u_id  FROM exam_form_submission as `ugnon_form_submission`
,term_master
WHERE term_master.term_id = ugnon_form_submission.term_id 
and  `payment_status` = 1 AND `payment_activation` = 1 
AND `non_collegiate_status` = 0 
and ugnon_form_submission.academic_year_id in ('$academic_id') 
and ugnon_form_submission.session_id in ('$session') 
and  term_master.cmn_terms like  '$terms'
group by ugnon_form_submission.u_id";
        $result = $this->getAdapter()
                ->fetchAll($select);
          
        return $result;
    }
    
    
   public function getstulasttermpayment($id) {
         
        $select = $this->_db->select()
                ->from($this->_name)
               
                ->where("$this->_name.term_id=?", $id)
                ->where("$this->_name.payment_status =?", '1');
              
        $result = $this->getAdapter()
                ->fetchAll($select);
       
        return $result;
    }
    
    
}
