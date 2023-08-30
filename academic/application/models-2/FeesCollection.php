<?php
/* 
    Author: Raushan Kumar
    Date: 25  Oct. 2019
    Summary: This model is made for exam Form Submit Records
*/
class Application_Model_FeesCollection extends Zend_Db_Table_Abstract {

    public $_name = 'semester_fee_collection';
    protected $_id = 'id';

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id);
          //  echo $select; die;  
        $result = $this->getAdapter()
                ->fetchRow($select);
            
        return $result;
    }
    
    
    public function getRecordbyfid($id) {
        $select = $this->_db->select()
                ->from($this->_name)
              
                ->where("$this->_name.id=?", $id)
                ->where("$this->_name.status=?", 1)
                ->where("$this->_name.f_code !=?", 'F')
                ->where("$this->_name.mmp_txn !=?",'')
                ->where("$this->_name.mmp_txn !=?",0)
               
                ->order("$this->_name.id  DESC");
              
        $result = $this->getAdapter()
                ->fetchRow($select);
         //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    public function getRecordbyFidTermid($id,$cmn_terms) {
        $select = $this->_db->select()
                ->from($this->_name)
              
                ->where("$this->_name.id=?", $id)
                ->where("$this->_name.semester like ?", explode("t",$cmn_terms)[1])
                ->where("$this->_name.status=?", 1)
                ->where("$this->_name.f_code like ?", 'Ok')
               
                ->order("$this->_name.id  DESC");
        $result = $this->getAdapter()
                ->fetchRow($select);
         //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    
        public function getTRecordb($id) {
        $select = $this->_db->select()
                ->from($this->_name)
              
                ->where("$this->_name.stu_id=?", $id)
                ->where("$this->_name.mmp_txn !=?",'')
                ->where("$this->_name.mmp_txn !=?",0)
               
                ->order("$this->_name.id  DESC");
              
        $result = $this->getAdapter()
                ->fetchAll($select);
         //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    
    public function getPayRecords($id,$sem){
          $select = $this->_db->select()
                ->from($this->_name)
                // ->joinl(array("declared_terms"),"declared_terms.term_des=$this->_name.semester",array("term_name"))
                ->where("$this->_name.stu_id=?", $id)
                ->where("$this->_name.semester=?", $sem)
                ->where("$this->_name.status=?", 1)
                ->order("id desc");
              
        $result = $this->getAdapter()
                ->fetchAll($select);
       // echo $select;die;
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
     public function getPayTotRecords($id,$sem,$stat = 1){
          $select = $this->_db->select()
                ->from($this->_name,array('batch', 'name', 'class_roll', 'exam_id', 'department', 'phone', 'email', 'semester', 'fee', 'due_amount', 'status', 'submit_date', 'mmp_txn', 'mer_txn', 'bank_txn', 'bank_name', 'prod', 'f_code', 'clientcode', 'merchant_id', 'stu_id', 'date', 'type', 'description', 'live_status', 'pay_mode', 'pf', 'stx', 'total_amount', 'addon_fee'))
                ->where("$this->_name.stu_id=?", $id)
                ->where("$this->_name.semester=?", $sem)
                ->where("$this->_name.status=?", $stat)
                ->order("id desc");
        $result = $this->getAdapter()
                ->fetchAll($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    
        public function getPayRecordsBytxn($id){
          $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.mmp_txn=?", $id)
                ->where("$this->_name.stu_id like ?", "%F-2020%")
                ->order("id desc");
              
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
       public function getPayRecordsByMerSingle($id,$txn=array(),$date){
          $select = $this->_db->select();
                $select->from($this->_name);
                $select->where("$this->_name.merchant_id=?", $id);
                if(count($txn)>0)
                $select->where("$this->_name.mmp_txn not in (?)", $txn);
                $select->where("$this->_name.f_code =?","E000" );
                $select->where("$this->_name.submit_date = ?", $date);
                $select->order("id Desc");
        $result = $this->getAdapter()
                ->fetchRow($select);
          //echo"<pre>";print_r($result);die;
        return $result;
    }
    
      public function getsemfeebysubmitdate($from_date,$to_date,$sem){
          $select = $this->_db->select();
                $select->from($this->_name,array('stu_id','GROUP_CONCAT(f_code) as f_code'));
                $select->where("$this->_name.semester =?",$sem );
                $select->where("$this->_name.submit_date <=?", $to_date);
                $select->where("$this->_name.submit_date >=?", $from_date);
                $select->group(array("stu_id","semester"));
                $subselect = $this->_db->select()
                ->from($select)
                ->where("f_code  like ?",'%ok%');
                
        $result = $this->getAdapter()
                ->fetchAll($subselect);
                return $result;
      }
    
    //To get filter record : Kedar : 22 Oct 2020
       public function getPayRecordsByMerSingleForFilterData($to_date,$from_date,$dept,$sem){
        $start_date = explode('/',$to_date);
        $toDate = $start_date[2]."-".$start_date[1]."-".$start_date[0];         
        $end_date =explode('/',$from_date);
        $fromDate = $end_date[2]."-".$end_date[1]."-".$end_date[0]; 
        //echo '<pre>'; print_r($fromDate);exit;
          $select = $this->_db->select();
                $select->from($this->_name);
                $select->joinleft(array("department"),"department.id=$this->_name.department",array("department"));
                $select->joinleft(array("declared_terms"),"declared_terms.term_des=$this->_name.semester",array("term_name"));
                //$select->where("$this->_name.f_code =?","E000" );
                $select->where("$this->_name.status =?",1 );
                if(!empty($dept))
                $select->where("$this->_name.department =?", $dept);
                if(!empty($sem))
                $select->where("$this->_name.semester =?",$sem );
                $select->where("$this->_name.submit_date <=?", $toDate);
                $select->where("$this->_name.submit_date >=?", $fromDate);
                $select->order("id ASC");
        $result = $this->getAdapter()
                ->fetchAll($select);
            //echo $select;die;
            //echo"<pre>";print_r($result);die;
        return $result;
    }
       public function getStudentFeeInstallmentRecords($academic_id,$sem){
            preg_match_all("/\d+/", $sem,$term_num);
           $previousterm = "t".($term_num[0][0]-1); 
            $select = $this->_db->select();
                
                $select->from('erp_student_information',array('stu_fname','stu_id','roll_no','exam_roll','academic_id'));
                
                $select->joinleft(array("semester_fee_collection"),"$this->_name.stu_id=erp_student_information.stu_id and $this->_name.semester = '$sem'",array('class_roll','due_amount','fee','exam_id','description',"sum(IF(semester_fee_collection.status = '1' AND semester_fee_collection.semester = '$sem' ,semester_fee_collection.status, 0)) as total_installment"," SUM(IF(semester_fee_collection.status = '1' AND semester_fee_collection.semester = '$sem' , fee, 0)) AS paid_fees"));
                 if($sem !=='t1'){
                 $select->join(array("term_master"),"term_master.cmn_terms='$previousterm' and term_master.academic_year_id = erp_student_information.academic_id",array(""));
               $select->joinleft(array("tabulation_report"),"tabulation_report.term_id=term_master.term_id",array(""));
               $select->joinleft(array("tabulation_report_items"),"tabulation_report_items.tabl_id=tabulation_report.tabl_id and tabulation_report_items.student_id = erp_student_information.student_id",array(""));}
                $select->joinleft(array("department"),"department.id=$this->_name.department",array("department"));
              
                //$select->joinleft(array("declared_terms"),"declared_terms.term_des=$this->_name.semester",array("term_name"));
                $select->where("erp_student_information.academic_id in (?)",$academic_id);
                // $select->where("erp_student_information.stu_status =?",1); changed on 10112022 by bhupendar sr
                
               
               
                
                if($sem !=='t1'){
                     /// change by raushan 07-07-2023 for semester fee ///
                      $select->where("tabulation_report.sem_fee =?",0); 
                      
                $select->where("tabulation_report_items.final_remarks like ?","P");
                }
                $select->group(array("erp_student_information.stu_id"));
                //$select->limit("$this->_name.id",2);
                 // echo "<pre>".$select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
    
            //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    Public function getstudentSemfeeDetails($formId,$cmnTerms){
        $select = $this->_db->select();
                $select->from($this->_name,array('class_roll','fee','exam_id','description','stu_id',"sum(IF(semester_fee_collection.status = '1' AND semester_fee_collection.semester = '$cmnTerms' ,semester_fee_collection.status, 0)) as total_installment"," SUM(IF(semester_fee_collection.status = '1' AND semester_fee_collection.semester = '$cmnTerms' , fee, 0)) AS paid_fees"));
                $select->joinleft(array("department"),"department.id=$this->_name.department",array("department"));
                $select->where("$this->_name.stu_id=?",$formId);
                $select->where("$this->_name.status=?",1);
                $result = $this->getAdapter()
                ->fetchRow($select);
                //echo $select;die;
            //echo"<pre>";print_r($result);die;
        return $result;
    }
    


    
    
    
     public function getStudentForEndSemRecords($academic_id,$sem,$attend='',$stu_id=''){
      //  echo $pay; die();
            $select = $this->_db->select();
                
                $select->from('erp_student_information',array('stu_fname','stu_id','roll_no','exam_roll','academic_id'));
              
                 $select->joinleft(array("semester_fee_collection"),"$this->_name.stu_id=erp_student_information.stu_id",array('class_roll','due_amount','fee','exam_id','description',"sum(IF(semester_fee_collection.status = '1' AND semester_fee_collection.semester = '$sem' ,semester_fee_collection.status, 0)) as total_installment"," SUM(IF(semester_fee_collection.status = '1' AND semester_fee_collection.semester = '$sem' , fee, 0)) AS paid_fees"));
                 
               
                $select->joinleft(array("department"),"department.id=$this->_name.department",array("department"));
               // $select->joinleft(array("exam_form_submission"),"exam_form_submission.u_id=erp_student_information.stu_id",array("SUM(IF(exam_form_submission.payment_status = '1', fee, 0)) AS exampaid_fees"));
               /// $select->joinleft(array("term_master"),"term_master.term_id=exam_form_submission.term_id",array());
                if($attend) {
                $select->joinleft(array("semester_wise_attendance_report"),"semester_wise_attendance_report.u_id=$this->_name.stu_id",array("attend_status"));
                
                }
                $select->where("erp_student_information.academic_id in (?)",$academic_id);
                //===========================changed on 01-08-2023================//
              //  $select->where("erp_student_information.stu_status =?",1);
                //$select->where("term_master.cmn_terms =?",$sem);
                  if($attend) {
                $select->where("semester_wise_attendance_report.cmn_terms=?",$sem);
                $select->where("semester_wise_attendance_report.attend_status=?",1);
                     
                 }
                 
                 if($stu_id){
                    $select->where("erp_student_information.stu_id=?",$stu_id); 
                 }
                
                $select->group("erp_student_information.stu_id");
               
                //$select->limit("$this->_name.id",2);
        $result = $this->getAdapter()
                ->fetchAll($select);
           //echo "<pre>".$select;die;
          //  echo"<pre>";print_r($result);die;
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
     //   echo $data;die;
       $this->getAdapter()->query($data);
    }
}
    
}
