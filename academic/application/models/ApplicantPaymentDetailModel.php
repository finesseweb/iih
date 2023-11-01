<?php
/*
  Author: Kedar Kumar
  Summary: This model is used for pwc entrance exam Payments Information.
  Date: 23 Dec. 2019
 */

//ini_set('display_errors', '1');
class Application_Model_ApplicantPaymentDetailModel extends Zend_Db_Table_Abstract {

    public $_name = 'applicant_payement_details';
    protected $_id = 'id';

    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name, array('course', "count(distinct(record.form_id)) as total_applied", 'sum(case when payment_status = 1 then 1 ELSE 0 END) as paid'))
                ->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = $this->_name.id", array())
                ->where("$this->_name.course!=?", '')
                ->group("$this->_name.course");
        // echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }
	
	
	 public function getRecordsprint() {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = $this->_name.id", array())
				->joinLeft(array('department' => 'department_type'), "department.id = $this->_name.course", array("department_type"))
                ->where("$this->_name.payment_status=?", 1)
                ->order("$this->_name.id desc");
        // echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }

    //Added By Kedar : 07 Oct 2020
    public function getRecordByYearId($yearId) {
        $select = $this->_db->select()
                ->from($this->_name, array('course', "count(distinct(record.form_id)) as total_applied", 'sum(case when payment_status = 1 then 1 ELSE 0 END) as paid'))
                ->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = $this->_name.id", array())
                ->where("$this->_name.course!=?", '')
                ->where("$this->_name.acad_year_id=?", $yearId)
                ->group("$this->_name.course");
      // echo "<pre>".$select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }

    public function getRecordById($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.id=?", $id);

        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }

    public function getRecordByCouse($id,$acad_id= '5',$academic=false) {
      $acad_id  = empty($acad_id)?5:$acad_id;
    
          
        $sql = "Select  roll_no,payment_status,applicant_course_details.*,
            applicant_educational_details.*,
            applicant_personal_details.*,
			applicant_registration.*
      
       from
       applicant_payement_details,
       applicant_educational_details,
       applicant_course_details,
       applicant_payment_record,
       applicant_personal_details,
	   applicant_registration
       where 
       
       applicant_payment_record.payment_id=applicant_payement_details.id
       and applicant_educational_details.application_no = applicant_payement_details.application_no
       and applicant_course_details.application_no = applicant_payement_details.application_no
       and applicant_personal_details.application_no = applicant_payement_details.application_no
       
       and applicant_payement_details.course != ''";
       $sql.=$academic?" and applicant_course_details.course = '$id'":" and applicant_payement_details.course = '$id'";
       $sql.="and applicant_payement_details.payment_status = '1' 
       and applicant_payement_details.roll_no != 0 
       and applicant_payment_record.f_code= 'Ok' 
          and applicant_payement_details.acad_year_id = $acad_id";
      
      // echo "<pre>".$sql;die;
        $result = $this->getAdapter()
                ->fetchAll($sql);
      //  echo"<pre>";print_r($result);die;	
        return $result;


    }
	
	public function getRecordByCouse1($id,$acad_id) {
    
    
            $select = $this->_db->select()
                ->from("applicant_course_details")
				->joinleft(array("applicant_registration"), "applicant_registration.application_no=applicant_course_details.application_no")
				->joinleft(array("applicant_personal_details"), "applicant_personal_details.application_no=applicant_course_details.application_no")
				->joinleft(array("applicant_educational_details"), "applicant_educational_details.application_no=applicant_course_details.application_no")
                ->where("applicant_course_details.course=?", $id)
				->where("applicant_course_details.acad_year_id=?", $acad_id)
				->where("applicant_personal_details.acad_year_id=?", $acad_id)
				->where("applicant_educational_details.acad_year_id=?", $acad_id);
               
        //->order('id desc')
        //->limit(1);
        $result = $this->getAdapter()
                ->fetchAll($select);
        // echo"<pre>";print_r($result);exit;	  
        return $result;
      
      


    }
	public function getRecordByCouseID1($id,$acad_id) {
    
    
            $select = $this->_db->select()
                ->from("applicant_course_details",array())
				->joinleft(array("applicant_registration"), "applicant_registration.application_no=applicant_course_details.application_no")
				->joinleft(array("applicant_personal_details"), "applicant_personal_details.application_no=applicant_course_details.application_no")
                ->where("applicant_course_details.course=?", $id)
				->where("applicant_course_details.acad_year_id=?", $acad_id);
			///	->where("applicant_personal_details.acad_year_id=?", $acad_id);
               
        //->order('id desc')
        //->limit(1);
        $result = $this->getAdapter()
                ->fetchAll($select);
        // echo"<pre>";print_r($result);exit;	  
        return $result;
      
      


    }
	
	
	
	public function getRecordByCouse2($id,$acad_id,$course) {
      
    $sql = "Select educourse.*,applicant_educational_details.*,
            
       applicant_personal_details.*,
       applicant_registration.*
       from
       applicant_educational_details ,
       applicant_course_details as educourse,
       applicant_personal_details,
	   applicant_registration";
	   if($course==1) {
	  $sql.= ",applicant_payment_record,
	    applicant_payement_details";
	  
	   }
        $sql.=" where educourse.course = $id and educourse.acad_year_id = $acad_id";
		if($course==1)   
        $sql.=" and applicant_payement_details.payment_status = '1'" ;
      // echo "<pre>".$sql; die;
        $result = $this->getAdapter()
                ->fetchAll($sql);
      //  echo"<pre>";print_r($result);die;	
        return $result; 


    }
	
	
	
     public function getRecordByStuid($stu_id) {
      $stu_id  = empty($stu_id)?0:$stu_id;
        $sql = "Select  roll_no,payment_status,applicant_course_details.*,
            applicant_educational_details.*,
            applicant_personal_details.*,
            applicant_payment_record.date,
            applicant_payment_record.mmp_txn,
            session_info.session,
            department_type.department_type,
            department.department
      
       from
       applicant_payement_details,
       applicant_educational_details,
       applicant_course_details,
       applicant_payment_record,
       applicant_personal_details,
       session_info,
       department_type,
       department
       where 
       
       applicant_payment_record.payment_id=applicant_payement_details.id
       and applicant_educational_details.application_no = applicant_payement_details.application_no
       and applicant_course_details.application_no = applicant_payement_details.application_no
       and applicant_personal_details.application_no = applicant_payement_details.application_no
       and session_info.id = applicant_course_details.session
       and department_type.id         = applicant_payement_details.course 
       and department.department_type         = department_type.id 
       and applicant_payement_details.course != ''";
    //   $sql.=$academic?" and applicant_course_details.core_course1 = '$id'":" and applicant_payement_details.course = '$id'";
       $sql.="and applicant_payement_details.payment_status = '1' 
       and applicant_payement_details.roll_no != 0 
       and applicant_payment_record.f_code= 'Ok' 
          and applicant_payement_details.form_id = '$stu_id'";
        $result = $this->getAdapter()
                ->fetchRow($sql);	
      if(!$result)
        return false;
        
        return $result;


    }

    public function getRecordbyUid($form_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.form_id=?", $form_id);

        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }

    public function getsavedData($conditions) {
        $sql = "Select applicant_payement_details.roll_no as roll,applicant_payement_details.applicant_name,applicant_payement_details.email_id,
       applicant_payment_record.*,
       entrance_exam_schedule.*
       from
       applicant_payement_details,
       entrance_exam_schedule,
       applicant_payment_record
       where 
       applicant_payment_record.payment_id=applicant_payement_details.id
       and entrance_exam_schedule.department = applicant_payement_details.course
       and applicant_payment_record.f_code= 'Ok'
       and entrance_exam_schedule.status= 0
       and md5(applicant_payement_details.application_no)='$conditions'";
        //echo $sql;die;
        $result = $this->getAdapter()
                ->fetchRow($sql);

        return $result;
    }

    //To get filled form Filled data 

    public function insertPayMode($application_no, $payMode) {

        if ($application_no) {

            $where = array(
                "md5(application_no) = ?" => $application_no
            );
            $data = array(
                'payment_mode' => $payMode
            );
            $query = Zend_Db_Table_Abstract::getDefaultAdapter();
            $query = $this->_db->update('applicant_course_details', $data, $where);
            return $query;
        }
    }

    public function checkCourseForRoll($course) {
        $select = $this->_db->select()
                ->from(array($this->_name),
                        array('roll_no' => 'max(roll_no) as roll_no', 'payment_status'))
                        ->where("$this->_name.acad_year_id=?", 6)
                ->where("$this->_name.course=?", $course);

        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo $select; die;
        //echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function checkRow($form_id) {
        $select = $this->_db->select()
                ->from(array($this->_name),
                        array('form_id' => 'form_id as form_id'))
                ->where("$this->_name.form_id=?", $form_id);

        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo $select; die;
        //echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function getChallan($application_no = '') {
        $select = $this->_db->select();
        $select->from(array($this->_name),
                array('challan_no' => 'max(challan_no) as challan_no'));
        if ($application_no) {
            $select->where("md5($this->_name.application_no)=?", $application_no);
        }

        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo $select; die;
        //echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function checkRow2($form_id) {
        $select = $this->_db->select()
                ->from(array($this->_name),
                        array('form_id' => 'form_id as form_id'))
                ->where("$this->_name.form_id=?", $form_id)
                ->where("$this->_name.payment_status=?", 1);
        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo $select; die;
        //echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function check_payment_status($applicatonNumber) {
        $select = $this->_db->select()
                ->from(array($this->_name), array('payment_status'))
                ->where("$this->_name.application_no=?", $applicatonNumber);
        //->order('id desc')
        //->limit(1);
        $result = $this->getAdapter()
                ->fetchAll($select);

        //echo $select;die;
        // echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function check_payment_statusMD5($applicatonNumber) {
        $select = $this->_db->select()
                ->from(array($this->_name), array('payment_status'))
                ->where("md5($this->_name.application_no)=?", $applicatonNumber)
                ->group("$this->_name.payment_status");
        //->order('id desc')
        //->limit(1);
        $result = $this->getAdapter()
                ->fetchAll($select);
        // echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function payedApplicant($applicatonNumber) {
        $select = $this->_db->select()
                ->from(array($this->_name), array('payment_status'))
                ->where("$this->_name.payment_status=?", 1)
                ->where("$this->_name.application_no=?", $applicatonNumber);
        //->order('id desc')
        //->limit(1);
        $result = $this->getAdapter()
                ->fetchRow($select);

        //echo $select;die;
        // echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    public function check_for_status($applicatonNumber) {
        $select = $this->_db->select()
                ->from(array($this->_name))
                ->join(array("applicant_course_details"), "applicant_course_details.application_no=$this->_name.application_no")
                ->join(array("entrance_exam_schedule"), "entrance_exam_schedule.department=applicant_course_details.course")
                ->joinleft(array("applicant_registration"), "applicant_registration.application_no=$this->_name.application_no")
                ->where("entrance_exam_schedule.status =?", 0)
                ->where("md5($this->_name.application_no)=?", $applicatonNumber);
        // ->order("$this->_name.id desc")
        // ->limit(1);
        $result = $this->getAdapter()
                ->fetchAll($select);

        //echo $select;die;
        // echo"<pre>";print_r($result);exit;	  
        return $result;
    }

    //All course by payment
    public function getAllUgCourseCount($year_id = '') {
       $year_id=  $year_id['year_id'];
      // print_r($year_id); die;
        //====[Kedars code]==========//
        // $select = $this->_db->select();
        // $select->from(array($this->_name), array('course', 'count(applicant_payement_details.course) as total_count'));

        // $select->joinleft(array("department_type"), "department_type.id=$this->_name.course", array("department_type", "session_id"));
        
        // $select->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = applicant_payement_details.id", array());
        // $select->joinLeft(array("applicant_course_details"), "applicant_course_details.application_no=$this->_name.application_no");
        // $select->joinLeft(array("academic_master"), "academic_master.academic_year_id=applicant_course_details.core_course1");
        // $select->joinleft(array("department"), "department.id=academic_master.department", array("department"));
        // $select->joinleft(array('seat' => 'sanctioned_seat'), "seat.course = $this->_name.course", array("max_seat"));
        // $select->where("applicant_payement_details.payment_status=?", 1);
        // if (!empty($year_id)) {
        //     $select->where("applicant_payement_details.acad_year_id=?", $year_id);
        // }
        // $select->where("seat.core_course=?", 0);
        // $select->where("seat.generic_elective=?", 0);
        // $select->where("record.f_code=?", Ok);
        // $select->where("department_type.degree_id=?", 1);
        // $select->group(array('applicant_course_details.core_course1'));
        // $select->order(array('department_type.degree_id'));
     //   echo "<pre>".$select; die;
 
$select = "SELECT count(applicant_payement_details.course) as total_count,department_type.department_type, session_id,department.department,department_type.id as academic_year_id  FROM `applicant_course_details` 
,applicant_payement_details
,applicant_payment_record
,department_type
,academic_master
,department
WHERE 
applicant_payement_details.application_no = applicant_course_details.application_no
and applicant_payment_record.payment_id = applicant_payement_details.id
and applicant_payment_record.application_id = applicant_payement_details.application_no
and department_type.id = applicant_course_details.course
and department.department_type = department_type.id
and academic_master.department =  department.id
and department.id = academic_master.department
and applicant_payement_details.payment_status = 1
and applicant_payement_details.acad_year_id= $year_id
and applicant_payment_record.f_code like 'Ok'
and department_type.degree_id = 1
group by applicant_course_details.course,applicant_course_details.core_course1
order by department_type.degree_id";

//echo "<pre>".$select; die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        
      //  echo"<pre>";print_r($result);exit;
        return $result;
    }
    
    public function getAllUgCourseCount1($year_id = '') {
       $year_id=  $year_id['year_id'];
        // print_r($year_id); die;
        // ====[Kedars code]==========//
        $select = $this->_db->select();
        $select->from(array($this->_name), array('course', 'count(applicant_payement_details.course) as total_count'));

        $select->joinleft(array("department_type"), "department_type.id=$this->_name.course", array("department_type", "session_id"));
        
        $select->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = applicant_payement_details.id", array());
        $select->joinLeft(array("applicant_course_details"), "applicant_course_details.application_no=$this->_name.application_no");
        $select->joinLeft(array("academic_master"), "academic_master.academic_year_id=applicant_course_details.core_course1");
        $select->joinleft(array("department"), "department.id=academic_master.department", array("department"));
        $select->joinleft(array('seat' => 'sanctioned_seat'), "seat.course = $this->_name.course", array("max_seat"));
        $select->joinleft(array('follow' => 'applicant_documents_followup'), "follow.application_no = $this->_name.application_no");
        $select->where("applicant_payement_details.payment_status=?", 1);
        if (!empty($year_id)) {
            $select->where("applicant_payement_details.acad_year_id=?", $year_id);
        }
        $select->where("seat.core_course=?", 0);
        $select->where("seat.generic_elective=?", 0);
         $select->where("follow.acad_year_id=?",$year_id);
        $select->where("record.f_code=?", Ok);
        $select->where("department_type.degree_id=?", 1);
        $select->group(array('applicant_course_details.course'));
        $select->order(array('department_type.degree_id'));
        // echo "<pre>".$select; die;
  
        $result = $this->getAdapter()
                ->fetchAll($select);
        
        //echo"<pre>";print_r($result);exit;
        return $result;
    }
    //For Principal Interface Date:25 May 2020
    //All course by payment

    public function getdocumentVerifiedRecordByCouse($id="",$acad_id="") {
      
                  $acad_id  = empty($acad_id)?5:$acad_id;
        $sql = "Select  roll_no,payment_status,applicant_course_details.*,
            applicant_educational_details.*,
            applicant_personal_details.*
      
       from
       applicant_payement_details,
       applicant_educational_details,
       applicant_course_details,
       applicant_payment_record,
       applicant_personal_details,
       applicant_documents_followup
       where 
       
       applicant_payment_record.payment_id=applicant_payement_details.id
       and applicant_educational_details.application_no = applicant_payement_details.application_no
       and applicant_course_details.application_no = applicant_payement_details.application_no
       and applicant_personal_details.application_no = applicant_payement_details.application_no
       and applicant_documents_followup.application_no = applicant_payement_details.application_no
       and applicant_payement_details.course != ''
       and applicant_payement_details.course = '$id'
       and applicant_payement_details.payment_status = '1' 
       and applicant_payement_details.roll_no != 0 
       and applicant_payment_record.f_code= 'Ok' 
        and applicant_documents_followup.certificate_list != '' 
          and applicant_payement_details.acad_year_id = $acad_id";
      //  echo "<pre>".$sql;die;
        $result = $this->getAdapter()
                ->fetchAll($sql);
      //  echo"<pre>";print_r($result);die;	
        return $result;

    }
    
    
    public function getProfRecords($academic){
        $select = "Select  applicant_course_details.applicant_name,applicant_course_details.applicant_name,applicant_course_details.application_no,applicant_course_details.form_id,applicant_course_details.email_id,department_type.department_type,applicant_course_details.phone,roll_no
      ,case WHEN applicant_course_details.core_course1 in $academic and applicant_course_details.core_course2 not in $academic then '1st preference' WHEN applicant_course_details.core_course2 in $academic and applicant_course_details.core_course1 not in $academic THEN '2nd Preference' ELSE 'Both' END as preference
       from
       applicant_payement_details,
       applicant_educational_details,
       applicant_course_details,
       applicant_payment_record,
       applicant_personal_details,
       department_type
       where 
       
       applicant_payment_record.payment_id=applicant_payement_details.id
       and department_type.id =  applicant_course_details.course
       and applicant_educational_details.application_no = applicant_payement_details.application_no
       and applicant_course_details.application_no = applicant_payement_details.application_no
       and applicant_personal_details.application_no = applicant_payement_details.application_no
       
       and applicant_payement_details.course != ''and applicant_payement_details.payment_status = '1' 
       and applicant_payement_details.roll_no != 0 
       and applicant_payment_record.f_code= 'Ok' 
       and (applicant_course_details.core_course1 in $academic  OR applicant_course_details.core_course2 in $academic)";
     //  echo"<pre>".$select;die;	
         $result = $this->getAdapter()
                ->fetchAll($select);
      //  echo"<pre>";print_r($result);die;	
        return $result;
       
    }
    

    public function getapprovedRecordByCourse($id) {
        $select = $this->_db->select()
                ->from($this->_name, array('max(roll_no) as roll_no1', "$this->_name.*", 'max(payment_status) as payment_status1'))
                ->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = $this->_name.id", array())
                ->joinLeft(array('documents' => 'applicant_documents_followup'), "documents.application_no = $this->_name.application_no")
                ->joinLeft(array('personals' => 'applicant_personal_details'), "personals.application_no = $this->_name.application_no", array('father_name', 'dob_date'))
                ->joinLeft(array('pay_mode' => 'applicant_paymode_details'), "pay_mode.application_no = $this->_name.application_no", array('pay_mode1'))
                ->where("$this->_name.course!=?", '')
                ->where("documents.principal_status =?", 1)
                ->where("$this->_name.course=?", $id)
                ->where("record.f_code like ?", 'ok')
                ->group('record.form_id');

        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }

    public function getSlipGeneratedRecordByCourse($id,$year) {
        $select = $this->_db->select()
                ->from($this->_name, array('max(roll_no) as roll_no1', "$this->_name.*", 'max(payment_status) as payment_status1'))
                ->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = $this->_name.id", array())
                ->joinLeft(array('documents' => 'applicant_documents_followup'), "documents.application_no = $this->_name.application_no")
                ->joinLeft(array('personals' => 'applicant_personal_details'), "personals.application_no = $this->_name.application_no", array('father_name', 'dob_date'))
                ->joinLeft(array('pay_mode' => 'applicant_paymode_details'), "pay_mode.application_no = $this->_name.application_no", array('pay_mode1', 'pay_mode2'))
                ->where("$this->_name.course!=?", '')
                ->where("$this->_name.payment_status=?", 1)
                ->where("documents.principal_status =?", 1)
                ->where("documents.fee_slip =?", 1)
                ->where("$this->_name.course=?", $id)
                ->where("$this->_name.acad_year_id=?", 5)
                ->where("record.f_code like ?", 'ok')
                ->group('record.form_id');

        $result = $this->getAdapter()
                ->fetchAll($select);
       // echo"<pre>".$select; die;	  
        return $result;
    }

    //For paid applicants details after payment interface
    public function getPaidRecordByCourse($id,$acad_id= 5) {
        $select = $this->_db->select()
                ->from($this->_name, array('max(roll_no) as roll_no1', "$this->_name.*", 'max(payment_status) as payment_status1',"$this->_name.form_id as stu_id"))
                ->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = $this->_name.id", array())
                ->joinLeft(array('paymode' => 'applicant_paymode_details'), "paymode.application_no = $this->_name.application_no", array('class_roll', 'pay_mode1', 'amount1', 'unique_id1', 'date_time1'))
                ->joinLeft(array('edu' => 'applicant_educational_details'), "edu.application_no = $this->_name.application_no", array('edu.*'))
                ->joinLeft(array('course' => 'applicant_course_details'), "course.application_no = $this->_name.application_no", array('course.*'))
                ->joinLeft(array('personal' => 'applicant_personal_details'), "personal.application_no = $this->_name.application_no", array('personal.*'))
                ->where("$this->_name.course!=?", '')
                ->where("$this->_name.acad_year_id =?", $acad_id)
                ->where("$this->_name.payment_status=?", 1)
                ->where("paymode.class_roll !=?", '')
                ->where("$this->_name.course=?", $id)
                ->where("record.f_code like ?", 'ok')
                ->group('record.form_id');
//echo "<pre>".($select);exit;
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
    }
    
    
    public function totalRecord($id,$acad_id= 5){
       $select  ="SELECT erp_student_information.*,department_type.department_type,department.department FROM `erp_student_information`,
academic_master
,department
,department_type
where erp_student_information.academic_id = academic_master.academic_year_id
and department.id = academic_master.department
and department_type.id = department.department_type
and academic_master.academic_year =$acad_id
and department_type.id =$id";  
$result = $this->getAdapter()
                ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;

    }

    //End
    public function getAllPgCourseCount($year_id = '') {
        
           $select = $this->_db->select();
        $select->from(array($this->_name), array('course', 'count(applicant_payement_details.course) as total_count'));

        $select->joinleft(array("department_type"), "department_type.id=$this->_name.course", array("department_type", "session_id", "id as academic_year_id"));

        $select->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = applicant_payement_details.id", array());
         $select->joinLeft(array("applicant_course_details"), "applicant_course_details.application_no=$this->_name.application_no");
        //$select->joinleft(array('seat' => 'sanctioned_seat'), "seat.course = $this->_name.course", array("max_seat"));
        //$select->joinLeft(array("academic_master"), "academic_master.academic_year_id=applicant_course_details.core_course1");
     //   $select->joinleft(array('follow' => 'applicant_documents_followup'), "follow.application_no = $this->_name.application_no");
     
        $select->where("applicant_payement_details.payment_status=?", 1);
        if (!empty($year_id)) {
            $select->where("applicant_payement_details.acad_year_id=?", $year_id);
        }
      //  $select->where("seat.core_course=?", 0);
       // $select->where("seat.generic_elective=?", 0);
        $select->where("record.f_code=?", Ok);
       //  $select->where("follow.acad_year_id=?",$year_id);
        $select->where("department_type.degree_id !=?", 1);
        $select->group(array('applicant_payement_details.course'));
        $select->order(array('department_type.degree_id'));
          
        
       
        
        $result = $this->getAdapter()
                ->fetchAll($select);
       // echo "<pre>".$select; die;
        //echo"<pre>";print_r($result);exit;
        return $result;
    }
    
    
    public function getAllPgCourseCountverified($year_id = '') {
        $select = $this->_db->select();
        $select->from(array($this->_name), array('course', 'count(applicant_payement_details.course) as total_count'));

        $select->joinleft(array("department_type"), "department_type.id=$this->_name.course", array("department_type", "session_id"));

        $select->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = applicant_payement_details.id", array());
         $select->joinLeft(array("applicant_course_details"), "applicant_course_details.application_no=$this->_name.application_no");
        $select->joinleft(array('seat' => 'sanctioned_seat'), "seat.course = $this->_name.course", array("max_seat"));
        $select->joinLeft(array("academic_master"), "academic_master.academic_year_id=applicant_course_details.core_course1");
       $select->joinleft(array('follow' => 'applicant_documents_followup'), "follow.application_no = $this->_name.application_no");
     
        $select->where("applicant_payement_details.payment_status=?", 1);
        if (!empty($year_id)) {
            $select->where("applicant_payement_details.acad_year_id=?", $year_id);
        }
        $select->where("seat.core_course=?", 0);
        $select->where("seat.generic_elective=?", 0);
        $select->where("record.f_code=?", Ok);
        $select->where("follow.acad_year_id=?",$year_id);
        $select->where("department_type.degree_id !=?", 1);
        $select->group(array('applicant_payement_details.course'));
        $select->order(array('department_type.degree_id'));
        
        
        
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo "<pre>".$select; die;
        //echo"<pre>";print_r($result);exit;
        return $result;
    }

 public function getallcount($course) { 
 
   $select = $this->_db->select();
        $select->from(array($this->_name), array('course', 'count(applicant_payement_details.course) as total_count'));
        $select->where("course=?", $course);
		$select->group(array('applicant_payement_details.course'));
		$result = $this->getAdapter()
                ->fetchRow($select);
		  //echo"<pre>";print_r($result);exit;		
		 return $result['total_count'];
 }
 
 
 public function GetTransactionDetails($form_id,$acad_id) {
        $select = $this->_db->select();
        $select->from(array($this->_name,array("$this->_name.*")));
        $select->joinLeft(array('record' => 'applicant_payment_record'), "record.payment_id = applicant_payement_details.id", array("record.mmp_txn","record.bank_name"));
        $select->joinLeft(array("applicant_course_details"), "applicant_course_details.application_no=$this->_name.application_no");
        $select->joinLeft(array('personal' => 'applicant_personal_details'), "personal.application_no = $this->_name.application_no", array('personal.*'));
		$select->joinLeft(array('registration' => 'applicant_registration'), "registration.application_no = $this->_name.application_no", array('registration.*'));
     
        $select->where("applicant_payement_details.payment_status=?", 1);
        $select->where("applicant_payement_details.acad_year_id=?", $acad_id);
        $select->where("applicant_payement_details.form_id=?", $form_id);
        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo "<pre>".$select; die;
        //echo"<pre>";print_r($result);exit;
        return $result;
    }
 
 

    //ENd 
}
?>
