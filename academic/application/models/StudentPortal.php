<?php

/**

 * @Framework Zend Framework

 * @Powered By TIS 
 * @category   ERP Product

 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.

 * (http://www.techintegrasolutions.com)

 * 	Author Divakar

 */
class Application_Model_StudentPortal extends Zend_Db_Table_Abstract {

    public $_name = 'erp_student_information';
    protected $_id = 'student_id';
    private $_flashMessenger = null;

    //get details by record for edit

     public function getStudenInfo($id='') {
        $patt = '/F-\d{4}-\d{1,}/i';
        $column = preg_match($patt,$id)?"stu_id":"student_id";
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.$column =?", $id);
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    
        public function getCounrtyInfo($session) {



        $select = $this->_db->select()
            ->from($this->_name,array('GROUP_CONCAT(Distinct(state)) as state','GROUP_CONCAT(Distinct(stu_nationality)) as country','GROUP_CONCAT(Distinct(religion)) as religion'))
             ->join(array("am" => "academic_master"), "am.academic_year_id= $this->_name.academic_id")
             ->where("am.session in (?)", $session)
            ->where("$this->_name.status !=?", 2);
   //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
    
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }

    public function getStudenInfoByU1($id) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
       // echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }
    public function getStudenInfoByid($id) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.student_id in (?)", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchAll($select);
       // echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }
    public function getStudenInfoByU2($id) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("md5($this->_name.stu_id) =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }

    public function getStudenInfoByStuIdForSemFee($id, $sem = '') {

        $select = $this->_db->select()
            ->from($this->_name);
        $select->joinleft(array("am" => "academic_master"), "am.academic_year_id= $this->_name.academic_id", array('short_code', 'department', 'session'));
        if ($sem) {
            $select->joinleft(array("tm" => "term_master"), "tm.academic_year_id= $this->_name.academic_id", array('term_id'));
            $select->where("tm.cmn_terms =?", $sem);
        }
        $select->where("$this->_name.status !=?", 2);
        $select->where("$this->_name.stu_id =?", $id);
        $select->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
       // echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }

    public function getStudenInfoByU($id) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("md5($this->_name.stu_id) =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }
    //Added by Kedar :  Date:14 Sept 2021
    public function getStudentTcInfo($id) {
        $select = $this->_db->select()
            ->from($this->_name,array('tc_number','tc_status'))
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }

    
    public function getStudenInfoByFormId($id) {
       
        $term1 = 't1';
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");
//echo "<pre>".$select; die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        if ($result) {

            $select = $this->_db->select()
                ->from($this->_name);

            $select->join(array("am" => "academic_master"), "am.academic_year_id= $this->_name.academic_id", array('batch_code', 'department', 'session'));
            if ($result['leaving_sem'] != $term1)
                $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.student_id", array('sum(total_grade_point) as total_grade', 'sum(total_credit_point) as total_credit', 'sum(fail_in_ct_ids) as failed_count', 'max(tabl_id) as tr_id'));
            //$select->from('academic_master',array('batch_code','department','session'));
            if ($result['leaving_sem'] != $term1) {

                $select->where("tr_items.student_id=?", $result['student_id']);
                $select->group("tr_items.student_id");
            }
            $select->where("am.academic_year_id=?", $result['academic_id']);
           //echo "<pre>".$select;exit;
            $result1 = $this->getAdapter()
                ->fetchRow($select);
                    
        }

        if ($result1) {
            $select = $this->_db->select()
                ->from('session_info', array('session','id'))
                ->where("session_info.id=?", $result1['session']);

            $result2 = $this->getAdapter()
                ->fetchRow($select);
        }
        else{
           return ;
        }
        
        if (!empty($result['leaving_sem']) && $result['leaving_sem'] != $term1) {
            //echo '<pre>'; print_r('Sm'); exit;
            $select = $this->_db->select()
                ->from('tabulation_report', array('added_date'))
                ->where("tabulation_report.tabl_id=?", $result1['tr_id']);

            $result3 = $this->getAdapter()
                ->fetchRow($select);
        }
        if ($result1) {
            $select = $this->_db->select()

                ->from('department', array('id','degree_id','description'))

                ->where("department.id=?", $result1['department']);

            $result4 = $this->getAdapter()
                ->fetchRow($select);
        }

        //echo $select;die;
        $split_date = explode('-', $result3['added_date']);
        $result['last_exam_date'] = $split_date[0];
        $result['failed_count'] = $result1['failed_count'];
        $result['total_grade'] = $result1['total_grade'];
        $result['total_credit'] = $result1['total_credit'];
        $result['batch'] = $result1['batch_code'];
        $result['session'] = $result2['session'];
        $result['session_id'] = $result2['id'];
        $result['degree'] = $result4['degree_id'];
        $result['dept_name'] = $result4['description'];

        $result['dept_id'] = $result4['id'];

    
        return $result;
    }

    //Added by Kedar :  Date:15 Feb 2021
    public function getStudenInfoByFormIdForPassoutCert($id) {
        $rwo='';
        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("pass_stu" => "pass_out_students"), "pass_stu.stu_id=$this->_name.student_id", array('pass_out_no', 'publish_date'))
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        $term1 = 't1';
        //echo '<pre>';print_r($result);die;
        if ($result) {

            $select = $this->_db->select()
                ->from($this->_name);

            $select->join(array("am" => "academic_master"), "am.academic_year_id= $this->_name.academic_id", array('batch_code', 'department', 'session'));
            // if ($result['leaving_sem'] != $term1)
            //     $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.student_id", array('sum(total_grade_point) as total_grade', 'sum(total_credit_point) as total_credit', 'sum(fail_in_ct_ids) as failed_count', 'max(tabl_id) as tr_id'));
            // //$select->from('academic_master',array('batch_code','department','session'));
            // if ($result['leaving_sem'] != $term1) {

            //     $select->where("tr_items.student_id=?", $result['student_id']);
            //     $select->group("tr_items.student_id");
            // }
            $select->where("am.academic_year_id=?", $result['academic_id']);
            //echo $select;die;
            $result1 = $this->getAdapter()
                ->fetchRow($select);
        }
        
         if ($result) {
         $select->join(array("tr_items" => "grade_allocation_items"), "tr_items.student_id=$this->_name.student_id", array('grade_value'));
          $select->where("tr_items.student_id=?", $result['student_id']);
          $result6 = $this->getAdapter()
                ->fetchAll($select);
         
        }  
        foreach($result6 as $res) {
            $rwo.=$res['grade_value'];
            $rwo.=',';
        }
       
        if ($result1) {
            $select = $this->_db->select()
                ->from('session_info', array('session', 'id'))
                ->where("session_info.id=?", $result1['session']);

            $result2 = $this->getAdapter()
                ->fetchRow($select);
        }

//        if (isset($result['leaving_sem']) && $result['leaving_sem'] != $term1) {
//
//            $select = $this->_db->select()
//                ->from('tabulation_report', array('added_date'))
//                ->where("tabulation_report.tabl_id=?", $result1['tr_id']);
//
//            $result3 = $this->getAdapter()
//                ->fetchRow($select);
//        }
        if ($result1) {
            $select = $this->_db->select()

                ->from('department', array('id','degree_id','description'))

                ->where("department.id=?", $result1['department']);

            $result4 = $this->getAdapter()
                ->fetchRow($select);
        }
        if ($result1) {
            $select = $this->_db->select()
                ->from('examination_dates', array('exam_date'))
                ->where("examination_dates.academic_id=?", $result['academic_id'])
                ->where("examination_dates.cmn_terms=?", $result['leaving_sem']);
            $result5 = $this->getAdapter()
                ->fetchRow($select);
        }
        
        //echo $select;die;
        $split_date = explode('-', $result3['added_date']);
        $result['last_exam_date'] = $split_date[0];
        $result['failed_count'] = $result1['failed_count'];
        $result['total_grade'] = $result1['total_grade'];
        $result['total_credit'] = $result1['total_credit'];
        $result['batch'] = $result1['batch_code'];
        $result['session'] = $result2['session'];
        $result['session_id'] = $result2['id'];
        $result['degree'] = $result4['degree_id'];
        $result['dept_name'] = $result4['description'];

        $result['dept_id'] = $result4['id'];

        $result['exam_date'] = !empty($result5['exam_date']) ? $result5['exam_date'] : 'N/A';
         $result['grade_value']=(explode(',',$rwo)); 
        //echo "<pre>";  print_r($result);exit;
        return $result;
    }

    public function getDepartmentType($acad_id) {
        $select = $this->_db->select()
            ->from('academic_master', array('department'))
            ->where("academic_master.academic_year_id=?", $acad_id);

        $result = $this->getAdapter()
            ->fetchRow($select);
        if ($result) {
            $select = $this->_db->select()
                ->from('department', array('debt_group'))
                ->where("department.id=?", $result['department']);

            $result1 = $this->getAdapter()
                ->fetchRow($select);
        }
        $result['stream'] = $result1['debt_group'];

        //echo "<pre>";  print_r($result);exit;
        return $result;
    }

    public function getTcNumber($stream) {
        $select = $this->_db->select()
            ->from($this->_name, array('max(tc_number) as tcNumber'))
            ->where("$this->_name.stream=?", $stream);

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }

    public function getStudenInfoByFormIdpromoted($id, $term_id = '') {
        $select = $this->_db->select()
            ->from($this->_name)
            //->joinLeft(array("session"=>"session_info"),"session.id=$this->_name.session",array('session'))
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        if ($term_id) {
            if ($result) {
                $currentTerm = $term_id;
                if ($term_id != 't1') {
                    $term_id_arr = explode('t', $term_id);
                    $term_id = ((int) $term_id_arr[1]) - 1;
                    $term_id = 't' . $term_id;
                }

                $select = $this->_db->select();

                $select->from($this->_name, array('concat(stu_id,"-",stu_fname) as name', "$this->_name.*"));


                $select->join(array('tab_items' => 'tabulation_report_items'), "tab_items.student_id = $this->_name.student_id");
                $select->join(array('tab_report' => 'tabulation_report'), "tab_report.tabl_id = tab_items.tabl_id");
                $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id and term.term_id = tab_report.term_id");
                $select->join(array('payment' => 'exam_form_submission'), "payment.term_id = term.term_id and payment.student_id = $this->_name.student_id");
                $select->where("$this->_name.academic_id in(?)", $result['academic_id']);
                if ($currentTerm != 't1') {
                    $select->where("term.cmn_terms =?", $term_id);
                    $select->where("tab_items.final_remarks != ?", 'F');
                }
                $select->where("$this->_name.stu_id =?", $id);
                $select->where("$this->_name.status !=?", 2);
                $select->where("payment.status =?", 1);
                $select->where("payment.payment_status =?", 1);
                $select->group("$this->_name.student_id");
                $select->order("$this->_name.exam_roll");
                //echo $select;die;
                $result1 = $this->getAdapter()
                    ->fetchRow($select);
            }
        }
        //echo '<pre>'; print_r($result1);exit;
        if ($result) {

            $select = $this->_db->select()
                ->from('academic_master', array('batch_code', 'department', 'session'))
                ->where("academic_master.academic_year_id=?", $result['academic_id']);

            $result2 = $this->getAdapter()
                ->fetchRow($select);
        }
        if ($result2) {
            $select = $this->_db->select()
                ->from('session_info', array('session', 'id'))
                ->where("session_info.id=?", $result2['session']);

            $result3 = $this->getAdapter()
                ->fetchRow($select);
        }


        //echo $select;die;
        if (!empty($result1)) {
            $result['batch'] = $result2['batch_code'];
            $result['session'] = $result3['session'];

            //echo "<pre>";  print_r($result);exit;
            return $result;
        }
    }

    public function getStudentsInfoByAcademicId($id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.tc_status =?", 1)
            ->where("$this->_name.academic_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        // echo "<pre>";  print_r($result);exit;

        return $result;
    }
    
     public function getCasteCategory($session ) {
         $select = $this->_db->select();
            $select->from($this->_name,array('cast_category'));
             $select->join(array("academic_master" => "academic_master"), "academic_master.academic_year_id=$this->_name.academic_id");
            
            $select->where("academic_master.session in (?)", $session);
            
            $select->group("cast_category");

        $result = $this->getAdapter()
            ->fetchAll($select);
        
        // echo "<pre>";  print_r($result);exit;

        return $result;
     }
     
     
     
     public function getstudentdetailsAll($am_id,$term_id,$country,$state,$religion,$cast_category,$active){
            $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $term_id = 't' . $term_id;
        }
         $select = "SELECT erp_student_information.*  FROM `erp_student_information` ";
         
    if($currentTerm && $currentTerm != 't1'){     
$select.=",term_master
,tabulation_report
,tabulation_report_items";
}

$select.=" WHERE  erp_student_information.`academic_id` = $am_id";

if($currentTerm && $currentTerm != 't1'){  
    $select.=" and erp_student_information.academic_id = term_master.academic_year_id
    and tabulation_report.term_id = term_master.term_id
    and tabulation_report_items.tabl_id = tabulation_report.tabl_id
    and tabulation_report_items.student_id = erp_student_information.student_id
    and term_master.cmn_terms LIKE '$term_id'"; 
}

        if($country){
            $select.=" and erp_student_information.stu_nationality = '$country'";
        }
        if($state){
             $select.=" and erp_student_information.state in ('$state')";
        }
        if($religion){
             $select.=" and erp_student_information.religion in ('$religion')";
        }
       if($active !=="!=0"){
             $select.=" and erp_student_information.cast_category ";
             if($cast_category==''){
                $select.=" is null"; 
             }
             else
             {
                 $select.= " = '$cast_category'";
             }
       }
         if($active){
             $select.=" and erp_student_information.stu_status  $active";
        }
        
      //  echo "<pre>".$select; die;
        
         $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
         
     }
    
        public function getCasteCategoryTotal($session,$term_id,$country,$state,$religion) {
            $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $term_id = 't' . $term_id;
        }
        
        
   ///date
        $select = "SELECT session_info.session,academic_master.academic_year_id ,degree_info.degree,department.department, cast_category, count(cast_category) totalAdmission,  SUM(case when stu_status = 1 then 1 else 0 end) as Active ,   SUM(case when stu_status > 1 then 1 else 0 end) as Inactive FROM `session_info`
,academic_master
,erp_student_information";
if($currentTerm && $currentTerm != 't1'){
$select.=",term_master
,tabulation_report
,tabulation_report_items";
}

$select.=",degree_info
,department
where academic_master.session = session_info.id"; 

if($currentTerm && $currentTerm != 't1'){
$select.=" and term_master.academic_year_id = academic_master.academic_year_id
and tabulation_report.term_id = term_master.term_id
and tabulation_report_items.tabl_id = tabulation_report.tabl_id
and tabulation_report_items.student_id = erp_student_information.student_id";
}

$select.=" and erp_student_information.academic_id = academic_master.academic_year_id
and department.id = academic_master.department
and department.degree_id = degree_info.id";
if($currentTerm && $currentTerm != 't1'){
$select.=" and term_master.cmn_terms like '$term_id'";
}

if($country){
    $select.=" and erp_student_information.stu_nationality = '$country'";
}
if($state){
     $select.=" and erp_student_information.state in ('$state')";
}
if($religion){
     $select.=" and erp_student_information.religion in ('$religion')";
}
$select.=" and session_info.id in ('$session')
GROUP by erp_student_information.cast_category,academic_master.academic_year_id";
//echo "<pre>". $select ; die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }
    
    public function getStudentDetailByAcadId($id,$term_id) {
         $select = $this->_db->select()
            ->from('section_allotment')
            ->where("section_allotment.academic_id =?", $id)
            ->where("section_allotment.term_id =?", $term_id);

            $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        $studentList=array();
       
       //echo "<pre>";  print_r($result);exit;
        foreach ($result as $key => $value) {
            array_push($studentList,$value['stu_id']);
            
        }
        // echo "<pre>";  print_r($studentList);exit;
        $select = $this->_db->select()
            ->from($this->_name);
            $select->where("$this->_name.stu_status =?", 1);
            if(!empty($studentList))
            $select->where("$this->_name.student_id not in(?)", $studentList);
            $select->where("$this->_name.academic_id =?", $id);
            $select->group("erp_student_information.roll_no");

        $result1 = $this->getAdapter()
            ->fetchAll($select); 
        
            //echo $select;die;
         //echo "<pre>";  print_r($result1);exit;

        return $result1;
    }
        public function getFinalStudentIds($academic,$count){
       $select = "select student_id from tabulation_report,tabulation_report_items
where tabulation_report_items.tabl_id = tabulation_report.tabl_id
and tabulation_report.academic_id = $academic
group by student_id having count(*) = $count";
$result = $this->getAdapter()
            ->fetchAll($select);
            return $result;
    }
    //Added by Kedar : for Section Allotment
    public function getStudentDetailByAcadIdForSectionAllotment($id,$term_id) {
         $select = $this->_db->select()
            ->from('section_allotment')
            ->where("section_allotment.academic_id =?", $id)
            ->where("section_allotment.term_id =?", $term_id);
    
            $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        $studentList=array();
        $stu_status=['1','6'];
       //echo "<pre>";  print_r($result);exit;
        foreach ($result as $key => $value) {
            array_push($studentList,$value['stu_id']);
            
        }
        // echo "<pre>";  print_r($studentList);exit;
        $select = $this->_db->select()
            ->from($this->_name);
            $select->where("$this->_name.stu_status IN(?)", $stu_status);
            //$select->orwhere("$this->_name.stu_status =?", 6);
            if(!empty($studentList))
           $select->where("$this->_name.student_id not in(?)", $studentList);
            $select->where("$this->_name.academic_id =?", $id);
            $select->group("erp_student_information.roll_no");

        $result1 = $this->getAdapter()
            ->fetchAll($select); 
        
            //echo $select;die;
         //echo "<pre>";  print_r($result1);exit;

        return $result1;
    }
    //end

    public function getStudentsInfoByAcademicIdForCollegiatePassOut($academic_id, $termId, $maxCountCheck) {
        $select = $this->_db->select()
            ->from('exam_form_submission')
            ->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=exam_form_submission.student_id", array('final_remarks', 'student_id'))
            ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array('stu_fname', 'stu_lname', 'stu_id'))
            ->where("exam_form_submission.academic_year_id =?", $academic_id)
            ->where("exam_form_submission.term_id =?", $termId)
            //->where("tr_items.sgpa !=?", 0.0)
            ->order("erp_student.stu_fname")
            ->group("tr_items.student_id");
            //->having("count(tr_items.student_id)=$maxCountCheck");

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        //echo "<pre>";  print_r($result1);  exit;
        return $result;
    }

    public function getStudentsInfoByAcademicIdForNonCollegiatePassOut($academic_id, $termId, $maxCountCheck) {
        $select = $this->_db->select()
            ->from('ugnon_form_submission')
            ->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=ugnon_form_submission.student_id", array('final_remarks', 'student_id'))
            ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array('stu_fname', 'stu_lname', 'stu_id'))
            ->where("ugnon_form_submission.academic_year_id =?", $academic_id)
            ->where("ugnon_form_submission.term_id =?", $termId)
            ->where("tr_items.sgpa !=?", 0.0)
            ->order("erp_student.stu_fname")
            ->group("tr_items.student_id")
            ->having("count(tr_items.student_id)=$maxCountCheck");

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        //echo "<pre>";  print_r($result);  exit;
        return $result;
    }

    public function getStudentList($studentList) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.student_id in(?)", $studentList)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.exam_roll");
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
        //->where("acad.academic_year_id in(?)", explode(',', $academic_id)); 
    }
    public function getStudentListByFormId($studentList) {
        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'erp_student_information.stu_id', 'erp_student_information.roll_no', 'erp_student_information.reg_no', 'erp_student_information.exam_roll', 'concat(erp_student_information.father_fname," ",erp_student_information.father_lname) as father_name'))

        ->joinLeft(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code"))
       
            ->where("$this->_name.stu_id in(?)", $studentList)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.exam_roll");
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
        //->where("acad.academic_year_id in(?)", explode(',', $academic_id)); 
    }

    //END

    public function getStudenacademicDetails($id) {



        $select = $this->_db->select()
            ->from($this->_name)
         ->joinLeft(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code"))
         ->joinLeft(array("session_info"), "session_info.id=academic_master.session", array("session","id as session_id"))
       
            //->where("$this->_name.status !=?", 2)
           //changed status as per request nasim sir   13-02-2023
            ->where("$this->_name.stu_status =?", 1)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");
//echo $select; die;
        $result = $this->getAdapter()
            ->fetchRow($select);


        return $result;
    }
    
    
        public function getStudenacademicDetailsnew($id) {



        $select = $this->_db->select()
            ->from($this->_name)
         ->joinLeft(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code","department"))
         ->joinLeft(array("session_info"), "session_info.id=academic_master.session", array("session","id as session_id"))
       
            ->where("$this->_name.status !=?", 2)
           //changed status as per request bhupendr sir coz migration status is not maintaing   13-03-2023
        //    ->where("$this->_name.stu_status =?", 1)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");
//echo $select; die;
        $result = $this->getAdapter()
            ->fetchRow($select);


        return $result;
    }
    
    public function getpendingstudent($stu_id){
                $select ="SELECT erp_student_information.stu_id,exam_roll, examchecker.* ,back_selection_items.electives FROM `erp_student_information`,
                    academic_master,
                    examchecker,
                    back_selection_items,
                    term_master
                    WHERE academic_master.academic_year_id = erp_student_information.academic_id
                    and examchecker.session = academic_master.session
                    and term_master.academic_year_id = academic_master.academic_year_id
                    and examchecker.academic_year = academic_master.academic_year
                    and back_selection_items.students_id = erp_student_information.student_id
                    and back_selection_items.terms = term_master.term_id
                    and term_master.cmn_terms = examchecker.sem
                    and back_selection_items.fail_status = 0
                    and  academic_master.session in (3,2,6) and stu_status in (1,2,6)  and stu_id = '$stu_id'
                    and examchecker.last_attempt_year >= DATE_FORMAT(now(),'%Y')";
        $result = $this->getAdapter()
                    ->fetchRow($select);
        return $result;

    }
    

    public function getelectivestudentDetailsBack($academic_id = '', $term_id = '', $pay = false,$month="",$pubmonth='') {

        $select = $this->_db->select();
        $select->from(array("student" => $this->_name), array("student.*"));

        $select->joinLeft(array("acad" => "academic_master"), "acad.academic_year_id=student.academic_id", array("short_code as academic_year"));
        if ($pay) {
            $select->join(array("payment_ug" => "ugnon_form_submission"), "payment_ug.student_id=student.student_id", array());
        }
        $select->where("acad.academic_year_id in(?)", explode(',', $academic_id));

        $select->where("student.stu_status =?", 1);
        if ($pay) {
            $select->where("payment_ug.payment_status =?", 1);
            $select->where("payment_ug.term_id in(?)",  $term_id);
          //  $select->where("payment_ug.examination_name =?", $month);
            $select->where("payment_ug.exam_month_id =?", $pubmonth);
        }
//echo $select; die;
        $select->order("student.exam_roll");
        $select->group("student.student_id");
        // echo $select; die;
        $result = $this->getAdapter()
     
            ->fetchAll($select);

        if ($pay) {
            if (!count($result))
                return $this->getelectivestudentDetailsBackpg($academic_id, $term_id, $pay,$month);
        }

        return $result;
    }

    public function getelectivestudentDetailsBackpg($academic_id = '', $term_id = '', $pay = false,$month="") {


        $select = $this->_db->select();
        $select->from(array("student" => $this->_name), array("student.*"));
        $select->joinLeft(array("acad" => "academic_master"), "acad.academic_year_id=student.academic_id", array("short_code as academic_year"));
        if ($pay) {
            $select->join(array("payment_pg" => "pg_non_form_data"), "payment_pg.student_id=student.student_id", array());
        }
        $select->where("acad.academic_year_id in(?)", explode(',', $academic_id));
        $select->where("student.stu_status =?", 1);
        if ($pay) {
            $select->where("payment_pg.payment_status =?", 1);
            $select->where("payment_pg.term_id in(?)",  $term_id);
             $select->where("payment_pg.examination_name =?", $month);
        }
//             
        $select->order("student.exam_roll");
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    //Get Students with t.c fee collection status: Kedar : Date: 06 Nov 2020
    public function getStudentacademicDetailsForTc($id, $feeType) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("tc_fee_collection"), "tc_fee_collection.stu_id=$this->_name.stu_id", array("status as pay_status", "fee_type"))
            ->where("$this->_name.status !=?", 2)
            ->where("tc_fee_collection.status =?", 1)
            ->where("tc_fee_collection.fee_type =?", $feeType)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        //echo "<pre>";  print_r($result);exit;
        return $result;
    }

    //End Date : 06 Nov 2020

    public function getPermotedStudenacademicDetails($stu_id, $academic_id, $term_id) {


        $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $term_id = 't' . $term_id;
        }
   ///date 19-04-2021---- validation for all term//// 
        else {
            $currentTerm = $term_id;
        }
        $select = $this->_db->select();
        $select->from($this->_name, array('concat(stu_id,"-",stu_fname) as name', "$this->_name.*"));
  ///date 19-04-2021---- validation for all term [30-12-2022] comented coz promotions are working as per setting [on disccusion ]//// 

//  if ($currentTerm =='t3' || $currentTerm =='t5') {
  ////raushan 18-01-2023///
if($currentTerm!='t1') {
        $select->join(array('tab_items' => 'tabulation_report_items'), "tab_items.student_id = $this->_name.student_id");
        $select->join(array('tab_report' => 'tabulation_report'), "tab_report.tabl_id = tab_items.tabl_id");
        $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id and term.term_id = tab_report.term_id");
      }
      ///raushaan///
      
    //   ///date 19-04-2021---- validation for all term [30-12-2022] comented coz promotions are working as per setting [on disccusion ]//// 
     ///raushaan///
      else {
          $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id"); 
       }
        if($currentTerm!='t1') {
        $select->join(array('payment' => 'exam_form_submission'), "payment.term_id = term.term_id and payment.student_id = $this->_name.student_id");
        }
        $select->where("$this->_name.academic_id in(?)", $academic_id);
        ///date 19-04-2021---- validation for all term [30-12-2022] comented coz promotions are working as per setting [on disccusion ]//// 
        // if ($currentTerm == 't3' || $currentTerm == 't5') {
        ///raushan//
           if($currentTerm!='t1') {
            $select->where("tab_items.final_remarks != ?", 'F');
           }
           //raushan//
           
        //  }
         $select->where("term.cmn_terms =?", $term_id);
        $select->where("$this->_name.stu_id =?", $stu_id);
        $select->where("$this->_name.status !=?", 2);
        if($currentTerm!='t1') {
        // $select->where("payment.status =?", 1);
        $select->where("payment.payment_status =?", 1);
        }
        $select->group("$this->_name.student_id");
        $select->order("$this->_name.exam_roll");
//echo "<pre>". $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    
    
      public function getPaymentStudenacademicDetails($stu_id, $academic_id, $term_id) {
         $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $currentTerm = 't' . $term_id;
        }
        else {
            $currentTerm = $term_id;
        }

        $select = $this->_db->select();

        $select->from($this->_name, array('concat(stu_id,"-",stu_fname) as name', "$this->_name.*"));
        $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id");
        $select->join(array('payment' => 'exam_form_submission'), "payment.term_id = term.term_id and payment.student_id = $this->_name.student_id");
      
        $select->where("$this->_name.academic_id in(?)", $academic_id);
        $select->where("$this->_name.stu_id =?", $stu_id);
        $select->where("$this->_name.status !=?", 2);
        $select->where("payment.status =?", 1);
        $select->where("payment.payment_status =?", 1);
        $select->where("term.academic_year_id =?", $academic_id);
        $select->where("term.cmn_terms =?", $currentTerm);
        $select->group("$this->_name.student_id");
        $select->order("$this->_name.exam_roll");
// echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    

    public function getStudenInfoByU_ID($id) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("attend_info" => "attendance_info"), "attend_info.u_id=$this->_name.stu_id", array('batch'))
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_id =?", $id)
            ->group("erp_student_information.roll_no");

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }

    public function getStudentM($uid) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.stu_id =?", $uid);

        $result = $this->getAdapter()
            ->fetchRow($select);

        // echo "<pre>";  print_r($result);exit;

        return $result;
    }

    public function getStudenFullInfo($id) {


          //$stu_status=['1','6'];
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array('session as session_id','short_code'))
            ->joinleft(array("sess" => "session_info"), "sess.id=academic.session", array('session'))
            ->joinleft(array("dept" => "department"), "dept.id=academic.department", array('degree_id'))

            ->joinleft(array("erp"=>"erp_elective_selection_items"),"erp.students_id=$this->_name.student_id",array('erp.ge_id','erp.aecc'))
            ->where("$this->_name.stu_status =?", 1)
            ->where("md5($this->_name.stu_id) =?", $id)
            ->limit(1);

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;

        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }

    public function getRecord($id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("academic_master"), "academic_master.academic_year_id=erp_student_information.academic_id", array("session", "department","batch_code"))
            ->joinleft(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.student_id", array('sum(total_grade_point) as total_grade', 'sum(total_credit_point) as total_credit', 'sum(fail_in_ct_ids) as failed_count', 'max(tabl_id) as tr_id'))
            ->where("$this->_name.$this->_id=?", $id)
            ->where("$this->_name.status !=?", 2);

      //  echo "<pre>".$select;die;

        $result = $this->getAdapter()
            ->fetchRow($select);

        if ($result) {
            $select = $this->_db->select()
                ->from('department', array('id','degree_id','description'))
                ->where("department.id=?", $result['department']);

            $result1 = $this->getAdapter()
                ->fetchRow($select);
        }

        $username = $this->getUserName($id);

        $result['participant_username'] = $username['participant_username'];

        $result['participant_Alumni'] = $username['participant_Alumni'];

        $result['secondary_mail'] = $username['participant_email'];



        $result['linked_in'] = $username['linked_in'];
        $result['degree_id'] = $result1['degree_id'];
        $deptStack= array('30','31','32','33','35','39');
        //echo '<pre>';print_r($result1['id']);die;
        if (in_array($result1['id'], $deptStack, TRUE) ){ 
            //echo '<pre>';print_r('in stack');die;
            $result['name_of_university_exam'] = $result['batch_code'];
        }else if($result1['id'] == 14){
            //echo '<pre>';print_r('14l');die;
            $result['name_of_university_exam'] = $result['batch_code'].' in ACCOUNTING';
        }
        else {
            //echo '<pre>';print_r('out of stack');die;
            $result['name_of_university_exam'] = $result['batch_code'].' in '.$result1['description'];
        }
        
       

        return $result;
    }

    //Added by kedar 19 Nov 2019

    public function getRecordbyUid($u_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('student_id,stu_id,exam_roll,stu_email_id,roll_no,stu_mobileno, CONCAT(stu_fname," ",stu_lname) AS studentName,concat(father_fname," ",father_lname) As FatherName','filename'))
            ->where("$this->_name.stu_id=?", $u_id)
            ->where("$this->_name.status !=?", 2);

        //echo $select;die;

        $result = $this->getAdapter()
            ->fetchRow($select);





        //echo"<pre>"; print_r($result);exit;

        return $result;
    }

    public function UpdateMobileRecordbyId($s_id = '', $stu_mobile = '', $father_mobile = '', $student_email = '') {

        $data = array(
            'stu_mobileno' => $stu_mobile,
            'father_mobileno' => $father_mobile,
            'stu_email_id' => $student_email
        );

        $where = array(
            'student_id = ?' => $s_id
        );

        $query = Zend_Db_Table_Abstract::getDefaultAdapter();

        $query->update('erp_student_information', $data, $where);

        //echo $query;exit;
        //return $DB;
    }

    //End

    public function getUserName($id) {

        $select = $this->_db->select()
            ->from('participants_login', array('participant_username', 'participant_Alumni', 'linked_in', 'participant_email'))
            ->where("participants_login.$this->_id=?", $id)
            ->where("participants_login.participant_Active !=?", 2);

        //echo $select;die;

        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }

    public function getUserName1($id) {

        $select = $this->_db->select()
            ->from('erp_student_information', array('filename'))
            ->where("erp_student_information.$this->_id=?", $id);

        //echo $select;die;

        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result['filename'];
    }

    public function getImage($id) {

        $select = $this->_db->select()
            ->from('erp_student_information')
            ->where("md5(erp_student_information.stu_id)=?", $id);

        //echo $select;die;

        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }

    public function getRecordsById($id) {



        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id")
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.student_id =?", $id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }
    
    
        public function getRecordsByStudentAcademic($id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id")
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.academic_id =?", $id);

        $result = $this->getAdapter()
            ->fetchAll($select);
//echo "<pre>";print_r($result); die;
        return $result;
    }

    public function checkRecords($id) {

        $select = $this->_db->select()
            ->from('participants_login')
            ->where("participants_login.student_id =?", $id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return count($result);
    }

    public function checkAlumni($id) {

        $select = $this->_db->select()
            ->from('erp_alumni_table')
            ->where("erp_alumni_table.student_id =?", $id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return count($result);
    }

    public function getAlumniDetail($student_id) {

        $select = $this->_db->select()
            ->from(array('alumni' => 'erp_alumni_table'))
            ->joinleft(array("participant" => "participants_login"), "participant.student_id=alumni.student_id", array("participant_pword"))
            ->where("alumni.student_id =?", $student_id);



        $result = $this->getAdapter()
            ->fetchRow($select);



        return $result;
    }

    public function getstudentsbyacademics($academic_id, $term_id, $pay = false, $attendance = false) {
        $term_model = new Application_Model_TermMaster();
        $termpay = $term_model->getTermRecordsbycmnelective(explode(',', $academic_id), $term_id);
        $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $term_id = 't' . $term_id;
        }

        $select = $this->_db->select();

        $select->from($this->_name, array('concat(stu_id,"-",stu_fname) as name', "$this->_name.*"));

        if ($currentTerm != 't1') {
            $select->join(array('tab_items' => 'tabulation_report_items'), "tab_items.student_id = $this->_name.student_id", array());
            $select->join(array('tab_report' => 'tabulation_report'), "tab_report.tabl_id = tab_items.tabl_id", array());

            $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id and term.term_id = tab_report.term_id", array());
        }
        if ($pay) {
            $select->join(array("payment" => "exam_form_submission"), "payment.student_id=$this->_name.student_id", array());
        }

        $select->where("$this->_name.academic_id in(?)", $academic_id);
        if ($attendance) {
            $select->joinLeft(array("semester_wise_attendance_report"), "semester_wise_attendance_report.u_id = $this->_name.stu_id", array("component_paper", "max(attend_status) as attend_status"));
        }
        if ($currentTerm != 't1') {
            $select->where("term.cmn_terms = ?", "$term_id");
            $select->where("tab_items.promotion_text like ?", 'Promoted'.'%');
        }
        if ($attendance) {
            $select->where("semester_wise_attendance_report.cmn_terms =?", $currentTerm);
            $select->where("semester_wise_attendance_report.course_id =?", 0);
        }
        $select->where("$this->_name.status !=?", 2);
        //====================[As per bhupendar only active student will show in attendance sheet] 14:02:2023 16:06
        $select->where("$this->_name.stu_status = ?", 1);
        if ($pay) {
            $select->where("payment.payment_status =?", 1);
            $select->where("payment.term_id in (?)", explode(',', $termpay));
        }
        $select->group("$this->_name.student_id");

        $select->order("$this->_name.exam_roll");

        if ($attendance) {
            $select1 = $this->_db->select();
            $select1->from($select);
            $select1->where("attend_status=?", 0);
            $result = $this->getAdapter()
                ->fetchAll($select1);
        } else {
           // echo "<pre>".$select;exit;
            $result = $this->getAdapter()
                ->fetchAll($select);
        }

        return $result;
    }

    //Get all records

    public function getRecords() {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"))
            ->joinleft(array("terms" => "term_master"), "terms.term_id=$this->_name.terms_id", array("term_name"))
            ->where("$this->_name.academic_id !=?", 0)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id DESC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    //Get all records

    public function getRecordsfordetails() {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"))
            ->joinleft(array("terms" => "term_master"), "terms.term_id=$this->_name.terms_id", array("term_name"))
            ->where("$this->_name.academic_id !=?", 0)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id DESC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }
// SELECT `erp_student_information`.*, `academic`.`short_code` AS `academic_year`, `credits`.`credit_number` FROM `erp_student_information`
//  JOIN `academic_master` AS `academic` ON academic.academic_year_id=erp_student_information.academic_id
//  join term_master on term_master.academic_year_id = academic.academic_year_id
//  join tabulation_report on tabulation_report.academic_id = academic.academic_year_id and tabulation_report.term_id = term_master.term_id
//  join tabulation_report_items on tabulation_report_items.tabl_id = tabulation_report.tabl_id  and erp_student_information.student_id = tabulation_report_items.student_id
// JOIN `academic_credits` AS `credits` ON credits.academic_id=erp_student_information.academic_id
//  WHERE (erp_student_information.academic_id !=0) 
//  AND (erp_student_information.status !=2) 
//  AND (academic.session ='1' ) 
//  AND (academic.department ='16' ) 
//  AND (erp_student_information.stu_status =1) and term_master.cmn_terms = (select concat("t",count(*)-1) as cmn_terms from term_master where term_master.academic_year_id = 1)
    // Add By kedar 23 Sept. 2019


public function getCompletedStudentsOnly($academic_id){
    $cmn_terms = $this->getSecondLastTerm('','',$academic_id );
     $select = $this->_db->select();
        $select->from($this->_name,array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'father_fname', 'roll_no', 'exam_roll', 'stu_id', 'stu_status'));
        $select->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"));
        $select->join(array("term_master" => "term_master"), "term_master.academic_year_id = academic.academic_year_id", array(""));
        $select->join(array("tabulation_report" => "tabulation_report"), "tabulation_report.academic_id = academic.academic_year_id and tabulation_report.term_id = term_master.term_id", array(""));
        $select->join(array("tabulation_report_items" => "tabulation_report_items"), "tabulation_report_items.tabl_id = tabulation_report.tabl_id  and erp_student_information.student_id = tabulation_report_items.student_id", array(""));
//=====comented
        $select->join(array("credits" => "academic_credits"), "credits.academic_id=$this->_name.academic_id", array("credit_number"));

        $select->where("$this->_name.academic_id =?", $academic_id);
$select->where("academic.academic_year_id =?", $academic_id);
        $select->where("$this->_name.status !=?", 2);
$select->where("term_master.cmn_terms =? ", $cmn_terms);
$select->where("tabulation_report.flag like ? ", 'R');
    $select->group("$this->_name.$this->_id");

       // echo "<pre>".$select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    
}


public function getSecondLastTerm($session="",$department="",$academic_id=""){
    
     $select = $this->_db->select();

        $select->from("term_master",array('concat("t",count(*)-1) as cmn_terms'));

        $select->join(array("academic" => "academic_master"), "academic.academic_year_id=term_master.academic_year_id", array("short_code AS academic_year"));
        if(empty($academic_id)){
           $select->where("academic.session =?", $session);
            $select->where("academic.department =?", $department);
            }
            else
            $select->where("academic.academic_year_id =?", $academic_id);
        $result = $this->getAdapter()
            ->fetchRow($select);
           return  $result['cmn_terms']; 
        
}
  public function getRecordsBySession($session_id = '', $department_id = '', $flag = '') {

        $select = $this->_db->select();

        $select->from($this->_name);

        $select->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"));
//=====comented
        $select->joinleft(array("credits" => "academic_credits"), "credits.academic_id=$this->_name.academic_id", array("credit_number"));

        $select->where("$this->_name.academic_id !=?", 0);

        $select->where("$this->_name.status !=?", 2);

        if (!empty($session_id)) {

            $select->where("academic.session =? ", $session_id);

            $select->where("academic.department =? ", $department_id);
            if ($flag == A)
                $select->where("$this->_name.stu_status =?", 1);
        }

        $select->order("$this->_name.$this->_id DESC");

       // echo $select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

  public function getRecordsBySessionselected($session_id = '', $department_id = '', $flag = '') {

        $select = $this->_db->select();

        $select->from($this->_name,array("student_id","stu_fname", "stu_lname", "gender", "stu_mobileno", 
        "stu_email_id", "stu_dob", "present_addr", "premanent_addr", "stu_status", 
        "adv_col", "father_fname", "father_lname", "father_mobileno", "mother_fname", "mother_lname",
        "mother_mobileno", "academic_id", "stu_id", 
        "passing_year", "blood_group", "reg_no", "exam_roll", "roll_no", 
        "stu_aadhar", "stu_nationality", "stu_doA",  "earned_credit", "stu_caste", 
        "cast_category", "institution", "university", "last_exam_year_passing", "place_of_exam","state","religion","is_migration"));

        $select->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"));
//=====comented
      //  $select->joinleft(array("credits" => "academic_credits"), "credits.academic_id=$this->_name.academic_id", array("credit_number"));

        $select->where("$this->_name.academic_id !=?", 0);

        $select->where("$this->_name.status !=?", 2);

        if (!empty($session_id)) {

            $select->where("academic.session =? ", $session_id);

            $select->where("academic.department in (?) ", $department_id);
            if ($flag == A)
                $select->where("$this->_name.stu_status =?", 1);
        }
 $select->group("$this->_name.student_id");
        $select->order("$this->_name.$this->_id DESC");
       

    //  echo "<pre>".$select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }


    public function getRecordsBySessioncredit($session_id = '', $department_id = '', $flag = '') {
   $cmn_terms = $this->getSecondLastTerm($session_id , $department_id );
        $select = $this->_db->select();

        $select->from($this->_name);

        $select->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"));
        $select->join(array("term_master" => "term_master"), "term_master.academic_year_id = academic.academic_year_id", array(""));
        $select->join(array("tabulation_report" => "tabulation_report"), "tabulation_report.academic_id = academic.academic_year_id and tabulation_report.term_id = term_master.term_id", array(""));
        $select->join(array("tabulation_report_items" => "tabulation_report_items"), "tabulation_report_items.tabl_id = tabulation_report.tabl_id  and erp_student_information.student_id = tabulation_report_items.student_id", array(""));
//=====comented
        $select->join(array("credits" => "academic_credits"), "credits.academic_id=$this->_name.academic_id", array("credit_number"));

        $select->where("$this->_name.academic_id !=?", 0);

        $select->where("$this->_name.status !=?", 2);
$select->where("term_master.cmn_terms =? ", $cmn_terms);
$select->where("tabulation_report.flag like ? ", 'R');
        if (!empty($session_id)) {

            $select->where("academic.session =? ", $session_id);

            $select->where("academic.department =? ", $department_id);
            if ($flag == A)
                $select->where("$this->_name.stu_status =?", 1);
        }
    $select->group("$this->_name.$this->_id");
        $select->order("$this->_name.exam_roll");

      //  echo "<pre>".$select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }


 public function getRecordsForEarnedcredit($session_id = '', $department_id = '', $flag = '') {
   $cmn_terms = $this->getSecondLastTerm($session_id , $department_id );
        $select = $this->_db->select();

        $select->from($this->_name);

        $select->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"));
        $select->join(array("term_master" => "term_master"), "term_master.academic_year_id = academic.academic_year_id", array(""));
        $select->join(array("tabulation_report" => "tabulation_report"), "tabulation_report.academic_id = academic.academic_year_id and tabulation_report.term_id = term_master.term_id", array(""));
        $select->join(array("tabulation_report_items" => "tabulation_report_items"), "tabulation_report_items.tabl_id = tabulation_report.tabl_id  and erp_student_information.student_id = tabulation_report_items.student_id", array(""));
//=====comented
        $select->join(array("credits" => "academic_credits"), "credits.academic_id=$this->_name.academic_id", array("credit_number"));

        $select->where("$this->_name.academic_id !=?", 0);

        $select->where("$this->_name.status !=?", 2);
        $select->where("term_master.cmn_terms =? ", $cmn_terms);
        $select->where("tabulation_report.flag like ? ", 'R');
        if (!empty($session_id)) {

            $select->where("academic.session =? ", $session_id);

            $select->where("academic.department =? ", $department_id);
           
        }
    $select->group("$this->_name.$this->_id");
        $select->order("$this->_name.exam_roll");

       // echo "<pre>".$select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }
    

public function getRecordsForEarnedcreditnew($session_id = '', $department_id = '', $flag = '') {
   $cmn_terms = $this->getSecondLastTerm($session_id , $department_id );
        $select = $this->_db->select();

        $select->from($this->_name);

        $select->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id", array("short_code AS academic_year"));
        $select->join(array("term_master" => "term_master"), "term_master.academic_year_id = academic.academic_year_id", array("term_id","cmn_terms"));
       //=====comented
        $select->join(array("credits" => "academic_credits"), "credits.academic_id=$this->_name.academic_id", array("credit_number"));

        $select->where("$this->_name.academic_id !=?", 0);

        $select->where("$this->_name.status !=?", 2);
        $select->where("term_master.cmn_terms =? ", 't6');
      
        if (!empty($session_id)) {

            $select->where("academic.session =? ", $session_id);

            $select->where("academic.department =? ", $department_id);
           
        }
    $select->group("$this->_name.$this->_id");
        $select->order("$this->_name.exam_roll");

       ///echo "<pre>".$select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }


    public function getDropDownList() {

        $select = $this->_db->select()
            ->from($this->_name, array('student_id', 'stu_fname'))
            ->where("$this->_name.status!=?", 2)
            ->order('student_id  ASC');

        $result = $this->getAdapter()->fetchAll($select);

        $data = array();



        foreach ($result as $val) {



            $data[$val['student_id']] = $val['stu_fname'];
        }

        return $data;
    }

    public function getstudents($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'father_fname', 'roll_no', 'exam_roll', 'stu_id', 'stu_status'))
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getstudentsByStuStatus($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'father_fname', 'roll_no', 'exam_roll', 'stu_id', 'stu_status','reg_no','stu_email_id','father_mobileno','filename'))
            ->where("$this->_name.academic_id=?", $academic_id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getstudents1($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_id," ",erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->where("$this->_name.academic_id in(?)", $academic_id)
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getStudentsSortByName($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.academic_id in (?)", $academic_id)
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.stu_status =?", 1)
            ->order("$this->_name.stu_fname ASC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }
    public function getStudentsSortByNameAll($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.academic_id in (?)", $academic_id)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.stu_fname ASC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }
    public function getstudentsyearwise($academic_id, $year_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("$this->_name.year=?", $year_id)
            ->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getstudentsdetails($academic_id, $term_id = '', $attend = false, $pay = false) {

        $term_model = new Application_Model_TermMaster();
        $term_id1 = $term_model->getTermRecordsbycmn($academic_id, $term_id)['term_id'];

        $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $term_id = 't' . $term_id;
        }

        $select = $this->_db->select();

        $select->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'erp_student_information.stu_id', 'erp_student_information.roll_no', 'erp_student_information.reg_no', 'erp_student_information.exam_roll', 'concat(erp_student_information.father_fname," ",erp_student_information.father_lname) as father_name'));
        if ($attend) {
            $select->join(array("semester_wise_attendance_report"), " semester_wise_attendance_report.u_id = erp_student_information.stu_id", array("component_paper", "attend_status", "u_id"));
        }
        $select->joinLeft(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code"));
        if ($pay) {
            $select->join(array("payment_ug" => "exam_form_submission"), "payment_ug.student_id=$this->_name.student_id", array());
        }

        $select->where("$this->_name.academic_id in(?)", $academic_id);
        if ($currentTerm != 't1') {
            $select->join(array('tab_items' => 'tabulation_report_items'), "tab_items.student_id = $this->_name.student_id");
            $select->join(array('tab_report' => 'tabulation_report'), "tab_report.tabl_id = tab_items.tabl_id");
            $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id and term.term_id = tab_report.term_id");
            $select->where("term.cmn_terms =?", $term_id);
            $select->where("tab_items.final_remarks != ?", 'F');
        }
        if ($attend) {
            $select->where("semester_wise_attendance_report.u_id is Not null");
            $select->where("semester_wise_attendance_report.cmn_terms =?", $currentTerm);
        }
        $select->where("$this->_name.status !=?", 2);
        if ($pay) {
            $select->where("payment_ug.payment_status =?", 1);
            $select->where("payment_ug.term_id =?", $term_id1);
        }
        $select->group("$this->_name.student_id");
        $select->order("$this->_name.exam_roll");
        //   echo $select ; die;
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getstudentsdetailattend($academic_id, $term_id = '',$pay = false, $tab_Offset = true,$termMasterId='',$section='') {
        
       //====== $stu_status=['1','6'];
        $stu_status=['1'];
      //  echo '<pre>'; print_r($tab_Offset);exit;
        $currentTerm = $term_id;
        if ($term_id != 't1') {
            $term_id_arr = explode('t', $term_id);
            $term_id = ((int) $term_id_arr[1]) - 1;
            $term_id = 't' . $term_id;
        }
        if ($pay == 1) {
             $term_model = new Application_Model_TermMaster();
           $term_id1 = $term_model->getTermRecordsbycmn($academic_id, $term_id)['term_id'];
           // $term_id1 = $termMasterId-1;
        }

        $select = $this->_db->select();

        $select->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'erp_student_information.stu_id', 'erp_student_information.roll_no', 'erp_student_information.reg_no', 'erp_student_information.exam_roll', 'concat(erp_student_information.father_fname," ",erp_student_information.father_lname) as father_name'));

        $select->joinLeft(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code"));
        if ($pay) {
            $select->join(array("payment_ug" => "exam_form_submission"), "payment_ug.student_id=$this->_name.student_id", array());
        }
        if(!empty($section))
        $select->join(array("section_allotment"), "section_allotment.stu_id=$this->_name.student_id", array());


        $select->where("$this->_name.academic_id in(?)", $academic_id);
        if ($tab_Offset == 1) {
            if ($currentTerm != 't1') {
                $select->join(array('tab_items' => 'tabulation_report_items'), "tab_items.student_id = $this->_name.student_id");
                $select->join(array('tab_report' => 'tabulation_report'), "tab_report.tabl_id = tab_items.tabl_id");
                $select->join(array('term' => 'term_master'), "term.academic_year_id = $this->_name.academic_id and term.term_id = tab_report.term_id");
                $select->where("term.cmn_terms =?", $term_id);
                //$select->where("tab_items.final_remarks != ?", 'F'); 02-06-2021.. Covid-19
                $select->where("tab_items.final_remarks != ?", 'F');
                $select->where("tab_items.promotion_text != ?" ,'');
            }
        }
        //For Form Submission Student
        if ($pay) {
            $select->where("payment_ug.payment_status =?", 1);
            $select->where("payment_ug.term_id =?", $term_id1);
        }
        if(!empty($section))
        $select->where("section_allotment.section =?", $section);
        if(!empty($termMasterId ) && !empty($section))
        $select->where("section_allotment.term_id =?", $termMasterId);
        $select->where("$this->_name.stu_status IN(?)", $stu_status);
        $select->group("$this->_name.student_id");
        $select->order("$this->_name.exam_roll");
       // echo "<pre>". $select ; die;
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }


	 public function getleftstudentcourse($academic_year_id,$department_id,$employee_id,$term_id,$department = '',$course_id){
	     
	     $select ="select * from (select stu_id,course_id,course_code,course_name,grade_allocation_items.grade_allocation_id,students,roll_no,exam_roll,father_name from (SELECT CONCAT(erp_student_information.stu_fname,' ',erp_student_information.stu_lname) AS students,  erp_student_information.roll_no, erp_student_information.reg_no, erp_student_information.exam_roll, concat(erp_student_information.father_fname,' ',erp_student_information.father_lname) as father_name,erp_student_information.stu_id,grade_allocation_master.grade_id,erp_student_information.student_id,course_master.course_id,course_master.course_code,grade_allocation_master.term_id,course_master.course_name  FROM (`grade_allocation_master` 
,erp_student_information
,course_master) 
WHERE 
erp_student_information.academic_id = grade_allocation_master.academic_id
and course_master.course_id = grade_allocation_master.course_id
and grade_allocation_master.`academic_id` = $academic_year_id 
AND `term_id` = $term_id 
AND grade_allocation_master.`course_id` = $course_id and flag like 'r') as newtb
LEFT JOIN grade_allocation_items on grade_allocation_items.grade_allocation_id = newtb.grade_id
and grade_allocation_items.student_id = newtb.student_id
) as temtb
where temtb.grade_allocation_id is null ";
$result1 = $this->getAdapter()
		->fetchAll($select);
	return $result1;
		
	 }

    public function getstudentsdetailsFinal($academic_id, $term_count = 6) {





        $select = $this->_db->select();

        $select->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'erp_student_information.stu_id', 'erp_student_information.roll_no', 'erp_student_information.reg_no', 'erp_student_information.exam_roll', 'concat(erp_student_information.father_fname," ",erp_student_information.father_lname) as father_name'));
        $select->join(array('tab_items' => 'tabulation_report_items'), "tab_items.student_id = $this->_name.student_id");
        $select->join(array('tab_report' => 'tabulation_report'), "tab_report.tabl_id = tab_items.tabl_id");
        $select->join(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code"));



        $select->where("$this->_name.academic_id = ?", $academic_id);
        $select->where("tab_report.academic_id = ?", $academic_id);
        $select->where("tab_report.flag like (?)", 'R');
//        $select->where("$this->_name.status !=?", 2);
//        $select->where("$this->_name.stu_status !=?", 3);
        $select->group("tab_items.student_id");
        $select->having("count(*)= ?", $term_count);
        $select->order("$this->_name.exam_roll");
//        echo $select; die;
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getstudentsdetailsWithAttendence($academic_id, $cmn_terms = '', $course, $ge_id, $limti = 100, $offset = 0, $attend = false, $pay = false) {
        $term_model = new Application_Model_TermMaster();
        $term_id1 = $term_model->getTermRecordsbycmn($academic_id, $cmn_terms)['term_id'];
        $select = $this->_db->select();

        $select->from($this->_name, array('CONCAT(erp_student_information.stu_fname," ",erp_student_information.stu_lname) AS students', 'erp_student_information.student_id', 'erp_student_information.stu_id', 'erp_student_information.roll_no', 'erp_student_information.reg_no', 'erp_student_information.exam_roll', 'concat(erp_student_information.father_fname," ",erp_student_information.father_lname) as father_name'));
        if ($attend == 1) {
            $select->join(array("semester_wise_attendance_report"), " semester_wise_attendance_report.u_id = erp_student_information.stu_id", array("component_paper", "attend_status"));
        }
        if ($pay) {
            $select->join(array("payment_ug" => "exam_form_submission"), "payment_ug.student_id=$this->_name.student_id", array());
        }
        $select->join(array("academic_master"), "academic_master.academic_year_id=$this->_name.academic_id", array("short_code"));
       
        $select->where("$this->_name.academic_id = (?)", $academic_id);
        if ($attend == 1) {
            if (!empty($ge_id)) {
                $select->where("semester_wise_attendance_report.ge_id = ?", $ge_id);
                $select->where("semester_wise_attendance_report.course_id = ?", $course);
            } else {
                $select->where("semester_wise_attendance_report.ge_id = 0");
                $select->where("semester_wise_attendance_report.course_id = 0");
            }

            $select->where("semester_wise_attendance_report.cmn_terms =?", $cmn_terms);
        }
        if ($pay) {
            $select->where("payment_ug.payment_status =?", 1);
            $select->where("payment_ug.term_id=?", $term_id1);
        }
        $select->where("$this->_name.status !=?", 2);
        $select->group("erp_student_information.stu_id");
        $select->order('erp_student_information.exam_roll');

        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }
    
    
   public function getNotAddedStudents($academic_year_id, $cmn_terms = '', $course, $ge_id, $limti = 100, $offset = 0, $attend = false, $pay = false,$term_id){
          $course = !$course?0:$course;
  
        $select ="select * from (select tmptb.*,grade_allocation_items.student_id as present from (SELECT `employee_allotment_master`.*,
        `allocation_items`.`course_id`, `allocation_items`.`department_id`, 
        `allocation_items`.`employee_id`, `course`.`course_id` AS `course`, `course`.`course_name`, `acad`.`department`
        ,CONCAT(student_info.stu_fname,' ',student_info.stu_lname) AS students, 
        student_info.student_id, student_info.stu_id,
        student_info.roll_no, student_info.reg_no, 
       student_info.exam_roll, 
       acad.short_code,
        concat(student_info.father_fname,' ',student_info.father_lname) as father_name";
        $select.=$attend?" ,attendance.attend_status,attendance.component_paper ":"";
       
        $select.=" FROM
        `employee_allotment_master`
        ,`employee_allocation_items_master` AS `allocation_items`
        ,`course_master` AS `course`
        ,`academic_master` AS `acad`
        ,`erp_student_information` as student_info
        ,`term_master` as term";
        
        $select.=$attend?",semester_wise_attendance_report as attendance":"";
        $select.=$pay?",exam_form_submission as payment":"";
        $select.=$ge_id?",erp_elective_selection as elective
        ,erp_elective_selection_items":"";
        
        $select.=" where allocation_items.ea_id = employee_allotment_master.ea_id 
        and course.course_id = allocation_items.course_id
        and term.term_id = allocation_items.term_id";
        
        $select.=$ge_id?" and elective.term_id = allocation_items.term_id
        and erp_elective_selection_items.electives = allocation_items.course_id
        and erp_elective_selection_items.elective_id = elective.elective_id
        and student_info.academic_id = elective.academic_year_id and student_info.student_id = erp_elective_selection_items.students_id":" and student_info.academic_id = acad.academic_year_id";
         
        $select.=$attend && $ge_id?" and attendance.u_id = student_info.stu_id and attendance.course_id = erp_elective_selection_items.electives":"";
         $select.=$attend && !$ge_id?" and attendance.u_id = student_info.stu_id and attendance.cmn_terms = '$cmn_terms' and attendance.course_id=0":"";
        $select.=$pay?" and payment.student_id = student_info.student_id and payment.term_id = allocation_items.term_id and payment.payment_status = 1":"";
        $select.=" and acad.academic_year_id = employee_allotment_master.academic_year_id 
        and (employee_allotment_master.academic_year_id=$academic_year_id) AND (allocation_items.term_id=$term_id) and student_info.stu_status = 1) as tmptb
        left join  grade_allocation_master on grade_allocation_master.course_id = tmptb.course_id and grade_allocation_master.academic_id = $academic_year_id and grade_allocation_master.flag not like  'b'
        left join  grade_allocation_items on grade_allocation_items.grade_allocation_id = grade_allocation_master.grade_id and  grade_allocation_items.student_id = tmptb.student_id"; 
        
        $select.=!$ge_id?" and grade_allocation_master.ge_id = 0":"";
        
        $select.=" ) as newtb where present is null and newtb.course = $course group by student_id ";
        
        
        $result = $this->getAdapter()
			->fetchAll($select);
			return $result;
       
    }
    

    public function getstudentsdetails1($academic_id, $ct_id) {

        $select = $this->_db->select()
            ->from('core_course_master', array('academic_year_id'))

            //->joinLeft(array("core_course_master"),"core_course_master.academic_year_id=$this->_name.academic_id",array("cc_id"))
            //->where("core_course_master.academic_year_id=?", 1)
            ->distinct()
            ->where("core_course_master.cc_id=?", 1);



        //->where("$this->_name.status !=?", 2);
        // echo $select;die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        //echo "<pre>"; print_r($result);die;

        return $result;
    }

    public function getstudentsdetailsForFirstTerm($academic_id) {

        $structID = $this->structID($academic_id);

        if ($structID != 0) {

            $select = $this->_db->select()
                ->from("erp_fee_structure_items")
                ->where('structure_id =?', $structID);

            $due_dates = $this->getAdapter()
                ->fetchAll($select);

            $t1_date = date("Y-m-d", strtotime($due_dates[0]['t1_date']));

            $t2_date = date("Y-m-d", strtotime($due_dates[0]['t2_date']));

            $t3_date = date("Y-m-d", strtotime($due_dates[0]['t3_date']));

            $t4_date = date("Y-m-d", strtotime($due_dates[0]['t4_date']));

            $t5_date = date("Y-m-d", strtotime($due_dates[0]['t5_date']));

            $term_id = $this->getTermId($structID['structure_id'], 1);

            $category = $this->getFeeCategory();

            $total_fee_in_that_term = 0;

            foreach ($category as $key_category => $value) {

                $total_fee_in_that_term += $this->getFee($structID['structure_id'], 1, $value['category_id'])[0]['total'];
            }

            $service_fee = $this->getFee($structID['structure_id'], 1, 2);

            $otherAnnualCharges = $this->getFee($structID['structure_id'], 1, 3);

            $tuition_fee = abs($total_fee_in_that_term - ((int) $service_fee[0]['total'] + (int) $otherAnnualCharges[0]['total']));

            $result = array(
                'gpa' => 0.0,
                'fee' => $total_fee_in_that_term,
                'service_fee' => $service_fee[0]['total'],
                'other_annual_charges' => $otherAnnualCharges[0]['total'],
                'tuition_fee' => $tuition_fee,
                'fee_discount' => 0,
                'total_fee' => $total_fee_in_that_term,
                'batch_id' => $academic_id,
                'term_id' => $term_id,
                't1_date' => $t1_date,
                't2_date' => $t2_date,
                't3_date' => $t3_date,
                't4_date' => $t4_date,
                't5_date' => $t5_date
            );

            return $result;
        } else
            return 0;
    }

    public function getFeeCategory() {



        $select = $this->_db->select()
            ->from('erp_fee_category_master', array('category_id'))
            ->where("status !=?", 2);

        // echo $select; exit;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getTermId($structure_id, $terms) {

        $select = $this->_db->select()
            ->from('erp_fee_structure_term_items', array('terms_id as term_id'))
            ->where("structure_id =?", $structure_id)
            ->where("terms =?", (INT) $terms);

        // echo $select; exit;

        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result['term_id'];
    }

    public function getFee($structure_id, $term_id, $category_id) {

        $select = $this->_db->select()
            ->from('erp_fee_structure_term_items', array('sum(fees) as total'))
            ->where("structure_id =?", $structure_id)
            ->where("category_id =?", $category_id)
            ->where("terms =?", (INT) $term_id);

        // echo $select; exit;

        $result = $this->getAdapter()
            ->fetchAll($select);



        return $result;
    }

    public function getstudentsdetailsByTerm_id($academic_id, $term_id, array $pre_index_details) {

        $x = $this->myfunc($term_id);

        //print($academic_id." ". $term_id);exit;

        $terms_count = strlen($x['term_name']);

        $term_val = substr($x['term_name'], $terms_count - 1);

        // echo "<pre>";print_r($term_id);exit;

        $structID = $this->structID($academic_id);

        if ($structID != 0) {



            $select = $this->_db->select()
                ->from(array("student" => $this->_name), array('sum(fees) as sum', 'CONCAT(stu_fname,' . " " . ' stu_lname) as students', 'stu_id as participants_id', 'student_id'))
                ->join(array("ref_master" => "course_grade_after_penalties_items"), "ref_master.student_id=student.student_id")
                ->join(array("structure" => "erp_fee_structure_master"), "structure.academic_id=student.academic_id")
                ->join(array("due_date" => "erp_fee_structure_term_items"), "due_date.structure_id=structure.structure_id")
                ->join(array("due_date_real" => "erp_fee_structure_items"), "due_date_real.structure_id=structure.structure_id")



                // ->join(array("scholarship" => "scholarship_management"),"scholarship.term_id = student.academic_id" )
                ->where("student.academic_id = ?", $academic_id)
                ->where("ref_master.term_id = ?", $term_id)

                // ->where('scholarship.term_id = ?', $term_id)
                ->where("due_date.structure_id =?", $structID['structure_id'])
                ->where("due_date.category_id =?", 1)
                ->where("due_date.terms_id =?", $term_id)
                ->group("student.stu_id")
                ->where("student.status !=?", 2);

            //echo $select ; exit;



            $result = $this->getAdapter()
                ->fetchAll($select);



            if (count($result) != 0) {

                $i = 0;

                $total_fee_in_that_term = $this->getTotalFee($structID['structure_id'], $term_id);

                $service_fee = $this->getServiceFee($structID['structure_id'], $term_id);

                $x = array();

                $otherAnnualCharges = $this->getOtherAnnualCharges($structID['structure_id'], $term_id);

                foreach ($result as $key => $value) {



                    $gpa_percent = $this->getPercentage($result[$i]['student_id'], $pre_index_details, $academic_id);



                    $result[$i]['total_fee'] = $total_fee_in_that_term[0]['total'];

                    $result[$i]['sum1'] = $service_fee;

                    $result[$i]['sum2'] = $otherAnnualCharges;



                    if (count($gpa_percent) > 0) {



                        if ($pre_index_details['c_type'] != 'el') {

                            //  print_r($gpa_percent);exit;

                            $result[$i]['scholarship_percent'] = $gpa_percent[0]['fee'];

                            $result[$i]['cgpa'] = $gpa_percent[0]['cgpa'];
                        } else {

                            $result[$i]['scholarship_percent'] = $gpa_percent[0]['fee'];

                            $result[$i]['cgpa'] = $gpa_percent[0]['cgpa'];
                        }

                        $total_fee = $this->getCalculatedFee($result[$i]['sum'], $result[$i]['scholarship_percent'], $total_fee_in_that_term[0]['total']);



                        $result[$i]['calculated_fee'] = $total_fee;
                    } else {

                        //  $x[$i] = "hello";

                        $result[$i]['scholarship_percent'] = "0";

                        $result[$i]['calculated_fee'] = $total_fee_in_that_term[0]['total'];
                    }

                    $i++;
                }
            } else {

                $result = 3;
            }
        } else {

            $result = 0;
        }

// echo "<pre>";print_r($result);exit;

        return $result;
    }

    public function getTotalFee($structure_id, $term_id) {

        $select = $this->_db->select()
            ->from('erp_fee_structure_term_items', array('sum(fees) as total'))
            ->where("structure_id =?", $structure_id)
            ->where("terms_id =?", (INT) $term_id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getPercentage($final_grade, array $pre_index_details, $batch) {



        if ($pre_index_details['c_type'] != 'el') {

            $select = $this->_db->select()
                ->from(array('gr' => 'course_grade_after_penalties_items'), array('gr.term_id', 'gr.student_id', 'gr.item_id', 'gr.cgpa', '(SELECT sch.scholarship_fee_wavier FROM scholarship_management sch WHERE sch.status =0 AND batch_id =' . $batch . ' AND gr.cgpa BETWEEN sch.gpa_from AND sch.gpa_to) as fee'))
                ->where('gr.student_id = ?', $final_grade)
                ->where('gr.term_id = ?', $pre_index_details['id']);

            // echo $select;exit;

            $result = $this->getAdapter()
                ->fetchAll($select);

            //  print_r($result);exit;
        } else {

            //print_r($pre_index_details['id']);exit;

            $select = $this->_db->select()
                ->from(array('gr' => 'experiential_grade_allocation_items'), array('gr.student_id', 'gr.grade_allocation_item_id', 'gr.cgpa', '(SELECT sch.scholarship_fee_wavier FROM scholarship_management sch WHERE sch.status =0 AND batch_id =' . $batch . ' AND gr.cgpa BETWEEN sch.gpa_from AND sch.gpa_to) as fee'))
                ->join(array("ref_master" => "experiential_grade_allocation_master"), "ref_master.grade_id=gr.grade_allocation_id")
                ->where('ref_master.course_id = ?', $pre_index_details['id'])
                ->where('student_id = ?', $final_grade);

            //echo $select; exit;

            $result = $this->getAdapter()
                ->fetchAll($select);
        }

        // echo "<pre>";print_r($result);echo "</pre>";exit;

        return $result;
    }

    public function getLastId() {

        $select = $this->_db->select()
            ->from('scholarship_management', array('max(id) as last_id'));

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result[0]['last_id'];
    }

    public function checkLastValue($last_id, $gpa_from) {
        
    }

    public function getServiceFee($structure_id, $term_id) {

        //print($term_id);exit;

        $select = $this->_db->select()
            ->from('erp_fee_structure_term_items', array('sum(fees) as sum1'))
            ->where("structure_id =?", $structure_id)
            ->where("category_id =?", 2)
            ->where("terms_id =?", (INT) $term_id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getOtherAnnualCharges($structure_id, $term_id) {

        $select = $this->_db->select()
            ->from('erp_fee_structure_term_items', array('sum(fees) as sum2'))
            ->where("structure_id =?", $structure_id)
            ->where("category_id =?", 3)
            ->where("terms_id =?", (INT) $term_id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getCalculatedFee($sum, $relief_percent_in_fee, $total_fee) {

        $other_term_fee = $total_fee - $sum;

        $scholarship_fee = $other_term_fee + ($sum - ($sum / 100) * $relief_percent_in_fee);

        return $scholarship_fee;
    }

    public function myfunc($term_id) {



        $select = $this->_db->select()
            ->from("term_master", 'term_name')
            ->where("term_id =?", $term_id);



        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result[0];
    }

    public function structID($id) {



        $select = $this->_db->select()
            ->from("erp_fee_structure_master", 'structure_id')
            ->where("academic_id =?", $id);



        $result = $this->getAdapter()
            ->fetchAll($select);

        //print_r($result);exit; 

        if (count($result) == 0) {

            return 0;
        } else {

            return $result[0];
        }
    }

    public function getStuIds() {

        $select = $this->_db->select()
            ->from($this->_name, 'student_id')
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id DESC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getStudentNames($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname,erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchAll($select);

        $data = array();

        foreach ($result as $k => $val) {

            $data[$val['student_id']] = $val['students'];
        }

        return $data;
    }

    public function getStudentDetails($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname,erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->join(array("exam" => "exam_form_submission"), "exam.u_id=erp_student_information.stu_id")
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("exam.payment_status=?", 1)
            // ->where("exam.status=?", 0)
            ->where("$this->_name.status !=?", 2)
            ->group("exam.u_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
        //print_r($result);
        //die();
        $data = array();

        foreach ($result as $k => $val) {

            $data[$val['student_id']] = $val['students'];
        }

        return $data;
    }

    public function getNonugDetails($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname,erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->join(array("exam" => "ugnon_form_submission"), "exam.u_id=erp_student_information.stu_id")
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("exam.payment_status=?", 1)
            ->where("exam.status=?", 0)
            ->where("$this->_name.status !=?", 2)
            ->group("exam.u_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
        //print_r($result);
        //die();
        $data = array();

        foreach ($result as $k => $val) {

            $data[$val['student_id']] = $val['students'];
        }

        return $data;
    }

    public function getNonpgDetails($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('CONCAT(erp_student_information.stu_fname,erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->join(array("exam" => "pg_non_form_data"), "exam.u_id=erp_student_information.stu_id")
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("exam.payment_status=?", 1)
            ->where("exam.status=?", 0)
            ->where("$this->_name.status !=?", 2)
            ->group("exam.u_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
        //print_r($result);
        //die();
        $data = array();

        foreach ($result as $k => $val) {

            $data[$val['student_id']] = $val['students'];
        }

        return $data;
    }

    public function getStudentPCRecord($academic_id = '', $stu_id = '',$filter_status='') {

        //print_r($branch_id); die;

        if (!empty($academic_id) || !empty($stu_id)) {

            $where = "";

            if (!empty($academic_id)) {

                $where .= " AND erp_student_information.academic_id = '$academic_id'";
            }

            if (!empty($stu_id)) {

                $where .= " AND erp_student_information.student_id = '$stu_id'";
            }



            $select = "SELECT `erp_student_information`.* FROM `erp_student_information` WHERE erp_student_information.status!=2 $where GROUP BY erp_student_information.student_id order by erp_student_information.exam_roll";
        }

        //echo $select; die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        //print_r($result);die;

        return $result;
    }
    public function getYearWiseFilteredStudentRecord($academic_id, $stu_id,$tablArr,$filter_status){
        $select = $this->_db->select()
            ->from($this->_name,array('stu_fname', 'stu_lname', 'stu_id','academic_id','student_id'));
        if(!empty($filter_status))
            $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.student_id", array('final_remarks'));
            
        
            if (!empty($academic_id) || !empty($stu_id)) {
                if (!empty($academic_id)) {
                $select->where("$this->_name.academic_id =?", $academic_id);
                }
                if (!empty($stu_id)) {
                $select->where("$this->_name.student_id =?", $stu_id);
                }
            }
            
            $select->order("$this->_name.stu_fname");
            if(!empty($filter_status) && $filter_status == 1){
                $select->where("tr_items.tabl_id in (?)",$tablArr);
                $select->having("count(tr_items.student_id)=2");
                $select->where("tr_items.sgpa !=?", 0.0);
                
            }
            if(!empty($filter_status) && $filter_status == 2){
                $select->where("tr_items.tabl_id in(?)",$tablArr);
                //$select->having("count(tr_items.student_id)=2");
                $select->where("tr_items.sgpa =?", 0.0);
                
            }
            if(!empty($filter_status) && $filter_status == 3){
                $select->where("tr_items.tabl_id in(?)",$tablArr);
                //$select->where("tr_items.sgpa =?", 0.0);
                //$select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            $select->group("$this->_name.student_id");
            //echo $select;die;
            
        $result = $this->getAdapter()
            ->fetchAll($select);
       
        //echo "<pre>";  print_r($result);  exit;
        return $result;
    }
    public function getTermWiseFilteredStudentRecord($academic_id, $stu_id,$tablId,$filter_status){
        $select = $this->_db->select()
            ->from($this->_name,array('stu_fname', 'stu_lname', 'stu_id','academic_id','student_id'));
        if(!empty($filter_status))
            $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.student_id", array('final_remarks'));
            
        
            if (!empty($academic_id) || !empty($stu_id)) {
                if (!empty($academic_id)) {
                $select->where("$this->_name.academic_id =?", $academic_id);
                }
                if (!empty($stu_id)) {
                $select->where("$this->_name.student_id =?", $stu_id);
                }
            }
            
            $select->order("$this->_name.stu_fname");
            if(!empty($filter_status) && $filter_status == 1){
                $select->where("tr_items.tabl_id =?",$tablId);
                $select->where("tr_items.sgpa !=?", 0.0);
            }
            if(!empty($filter_status) && $filter_status == 2){
                $select->where("tr_items.tabl_id =?",$tablId);
                $select->where("tr_items.sgpa =?", 0.0);
                //$select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            if(!empty($filter_status) && $filter_status == 3){
                $select->where("tr_items.tabl_id =?",$tablId);
                //$select->where("tr_items.sgpa =?", 0.0);
                //$select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            
         //   echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
       
        //echo "<pre>";  print_r($result);  exit;
        return $result;
    }
    public function getBackTermWiseFilteredStudentRecord($academic_id, $stu_id,$tablId,$filter_status){
        $select = $this->_db->select()
            ->from($this->_name,array('stu_fname', 'stu_lname', 'stu_id','academic_id','student_id'));
        if(!empty($filter_status))
            $select->join(array("btr_items" => "back_tabulation_report_items"), "btr_items.student_id=$this->_name.student_id", array('sgpa'));
            
        
            if (!empty($academic_id) || !empty($stu_id)) {
                if (!empty($academic_id)) {
                $select->where("$this->_name.academic_id =?", $academic_id);
                }
                if (!empty($stu_id)) {
                $select->where("$this->_name.student_id =?", $stu_id);
                }
            }
            
            $select->order("$this->_name.stu_fname");
            if(!empty($filter_status) && $filter_status == 1){
                $select->where("btr_items.tabl_id =?",$tablId);
                $select->where("btr_items.sgpa !=?", 0.0);
            }
            if(!empty($filter_status) && $filter_status == 2){
                $select->where("btr_items.tabl_id =?",$tablId);
                $select->where("btr_items.sgpa =?", 0.0);
                //$select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            if(!empty($filter_status) && $filter_status == 3){
                $select->where("btr_items.tabl_id =?",$tablId);
                //$select->where("tr_items.sgpa =?", 0.0);
                //$select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            
            //echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
       
        //echo "<pre>";  print_r($result);  exit;
        return $result;
    }
    
    public function getFilteredStudentRecord($academic_id, $stu_id,$filter_status,$maxCountCheck,$year_id=''){
        $select = $this->_db->select()
            ->from($this->_name,array('stu_fname', 'stu_lname', 'stu_id','academic_id','student_id'));
        if(!empty($filter_status) && $filter_status == 1  || $filter_status == 2 )
            $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.student_id=$this->_name.student_id", array('final_remarks'));
            
        
            if (!empty($academic_id) || !empty($stu_id)) {
                if (!empty($academic_id)) {
                $select->where("$this->_name.academic_id =?", $academic_id);
                }
                if (!empty($stu_id)) {
                $select->where("$this->_name.student_id =?", $stu_id);
                }
            }
            
            $select->order("$this->_name.stu_fname");
            if(!empty($filter_status) && $filter_status == 1){
                $select->where("tr_items.sgpa !=?", 0.0);
                $select->group("tr_items.student_id");
                if(empty($year_id))
                $select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            if(!empty($filter_status) && $filter_status == 2){
                $select->where("tr_items.sgpa =?", 0.0);
                $select->group("tr_items.student_id");
                if(empty($year_id))
                $select->having("count(tr_items.student_id)=$maxCountCheck");
            }
            
          //  echo "<pre>".$select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
       
        //echo "<pre>";  print_r($result1);  exit;
        return $result;
    }

    public function getStudentResult($academic_id = '', $count = '') {

        //print_r($branch_id); die;

        if (!empty($academic_id)) {

            $where = "";

            if (!empty($academic_id)) {

                $where = $academic_id;
            }
            if (!empty($count)) {

                $tot = $count;
            }
            $select = "SELECT erp_student_information.stu_id, erp_student_information.stu_fname,tabulation_report.added_date,SUM(tabulation_report_items.sgpa) as total_sgpa, round(sum(tabulation_report_items.total_grade_point)/ sum(tabulation_report_items.total_credit_point),2) as cgpa FROM `tabulation_report` 
JOIN tabulation_report_items on tabulation_report_items.tabl_id = tabulation_report.tabl_id
join erp_student_information on erp_student_information.student_id = tabulation_report_items.student_id
where tabulation_report.academic_id = $where and tabulation_report_items.sgpa !=0 GROUP by tabulation_report_items.student_id HAVING count(*) = $tot
ORDER BY `cgpa` DESC";
            // $select = "SELECT `erp_student_information`.* FROM `erp_student_information` WHERE erp_student_information.status!=2 $where GROUP BY erp_student_information.student_id order by erp_student_information.exam_roll";
        }

        // echo $select; die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        //  print_r($result);die;

        return $result;
    }

    public function getStudentadmitRecord($academic_id = '', $stu_id = '', $term_id = '') {

        // print_r($term_id); die;

        if (!empty($academic_id) || !empty($stu_id)) {

            $where = "";

            if (!empty($academic_id)) {

                $where .= " AND erp_student_information.academic_id = '$academic_id'";
            }

            if (!empty($stu_id)) {

                $where .= " AND erp_student_information.student_id = '$stu_id'";
            }

            $where .= " AND term_master.cmn_terms='$term_id' AND exam_form_submission.payment_status='1'";
            // $where .= " AND exam_form_submission.status='0' AND exam_form_submission.payment_status='1'";
            $select = "SELECT erp_student_information.* FROM `exam_form_submission` join erp_student_information on erp_student_information.stu_id = exam_form_submission.u_id join term_master on term_master.academic_year_id = exam_form_submission.academic_year_id $where GROUP BY u_id order by stu_fname asc";
        }

        //echo $select; die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        //print_r($result);die;

        return $result;
    }

    public function getNonugadmitRecord($academic_id = '', $stu_id = '',$term='') {

        //print_r($branch_id); die;

        if (!empty($academic_id) || !empty($stu_id)) {

            $where = "";

            if (!empty($academic_id)) {

                $where .= " where erp_student_information.academic_id = '$academic_id'";
            }

            if (!empty($stu_id)) {

                $where .= " AND erp_student_information.student_id = '$stu_id'";
            }

            $where .= " AND ugnon_form_submission.status='0' AND ugnon_form_submission.payment_status='1'";
            if($term)
            $where .= " And term_master.cmn_terms like '$term' and year_exam = ".DATE("Y") ;

            $select = "SELECT erp_student_information.* FROM `ugnon_form_submission` join erp_student_information on erp_student_information.student_id = ugnon_form_submission.student_id join term_master on term_master.term_id = ugnon_form_submission.term_id $where GROUP BY u_id order by stu_fname asc";
        }

         //echo "<prE>".$select; die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        //print_r($result);die;

        return $result;
    }

    public function getNonpgadmitRecord($academic_id = '', $stu_id = '',$term='') {

        //print_r($branch_id); die;

        if (!empty($academic_id) || !empty($stu_id)) {

            $where = "";

            if (!empty($academic_id)) {

                $where .= " where erp_student_information.academic_id = '$academic_id'";
            }

            if (!empty($stu_id)) {

                $where .= " AND erp_student_information.student_id = '$stu_id'";
            }
             if($term)
            $where .= " And term_master.cmn_terms like '$term' and year_exam = ".DATE("Y") ;

            $where .= " AND pg_non_form_data.status='0' AND pg_non_form_data.payment_status='1'";

            $select = "SELECT erp_student_information.* FROM `pg_non_form_data` join erp_student_information on erp_student_information.stu_id = pg_non_form_data.u_id join term_master on term_master.term_id = pg_non_form_data.term_id $where GROUP BY u_id order by stu_fname asc";
        }

        //echo $select; die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        //print_r($result);die;

        return $result;
    }

    public function getStudentsAcademicWise($academic_year_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('student_id', 'stu_id', "concat(stu_fname,' ',stu_lname) as stu_fname"))
            ->where("$this->_name.academic_id in (?)", $academic_year_id)
            ->where("$this->_name.status!=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);
        $data = array();
        foreach ($result as $val) {
            $data[$val['student_id']] = $val['stu_id'] . '-' . $val['stu_fname'];
        }
        return $data;
    }

    public function fetchDiscontinuedStudentDetailById($stu_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.stu_id=?", $stu_id)
            ->where("$this->_name.stu_status = ?", 2)
            ->where("$this->_name.status != ?", 2)
            ->order("student_id DESC")
            ->limit(1, 0);

        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }

    public function fetchDiscontinuedBatchesOfStudent($student_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.stu_id IN (SELECT stu_id FROM $this->_name WHERE student_id = ?)", $student_id)
            ->where("$this->_name.stu_status = ?", 2)
            ->where("$this->_name.status != ?", 2)
            ->order("$this->_name.student_id ASC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function fetchAllBatchesOfStudent($student_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.stu_id IN (SELECT stu_id FROM $this->_name WHERE student_id = ?)", $student_id)
            ->where("$this->_name.status != ?", 2)
            ->order("$this->_name.student_id ASC");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getDistincetStudentsByBatchId($academic_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('DISTINCT(erp_student_information.stu_id) as stu_id', 'CONCAT(erp_student_information.stu_fname,erp_student_information.stu_lname) AS students', 'erp_student_information.student_id'))
            ->where("$this->_name.academic_id=?", $academic_id)
            ->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    //To check existed exam roll no.

    public function getDataExists($reg_no, $exam_roll) {

        $select = $this->_db->select();

        $select->from($this->_name, array('reg_no', 'exam_roll'));

        if (!empty($reg_no) && !empty($exam_roll)) {

            $select->where('reg_no IN(?)', $reg_no);

            $select->orWhere('exam_roll IN(?)', $exam_roll);
        } else if ($reg_no) {

            $select->where('reg_no IN(?)', $reg_no);

            $select->orWhere('exam_roll IN(?)', $reg_no);
        } else if ($exam_roll) {

            $select->where('exam_roll IN(?)', $exam_roll);

            $select->orWhere('reg_no IN(?)', $exam_roll);
        } else {

            $result = 0;
        }

        //echo $select; die;

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    //For promotion documents follow up
    public function insertPromotionStudents($data) {

        $query = Zend_Db_Table_Abstract::getDefaultAdapter();
        $query = $this->_db->insert('promotion_documents_followup', $data);
        //echo $query;die;
        return $query;
    }

    public function updatePromotionStudents($form_id) {
        $where = array(
            'form_id = ?' => $form_id
        );
        $dataArray = array(
            'status' => 2
        );
        $query = Zend_Db_Table_Abstract::getDefaultAdapter();
        $query = $this->_db->update('promotion_documents_followup', $dataArray, $where);
        return $query;
    }

    public function updateBlockStatusPromotionStudents($form_id) {
        $where = array(
            'form_id = ?' => $form_id
        );
        $dataArray = array(
            'status' => 0
        );
        $query = Zend_Db_Table_Abstract::getDefaultAdapter();
        $query = $this->_db->update('promotion_documents_followup', $dataArray, $where);
        return $query;
    }

    public function checkPromotionDocument($form_id) {
        $select = $this->_db->select();
        $select->from(array('promotion_documents_followup'), array('form_id', 'status', 'date'));
        $select->where("promotion_documents_followup.form_id=?", $form_id);
        //$select->where("promotion_documents_followup.status =?",2);
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        //  echo"<pre>";print_r($result);die;	  
        return $result;
    }

    public function checkPromotionDocumentWithStatus($form_id) {
        $select = $this->_db->select();
        $select->from(array('promotion_documents_followup'), array('form_id', 'status', 'date'));
        $select->where("promotion_documents_followup.form_id=?", $form_id);
        $select->where("promotion_documents_followup.status =?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        //echo"<pre>";print_r($result);die;	  
        return $result;
    }

    //Get Total Active student count by academic id
    public function getStudentCount($acadId) {
        $stu_status=['1','6'];
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.academic_id =?", $acadId)
            
            ->where("$this->_name.stu_status IN(?)", $stu_status);

        $result = $this->getAdapter()
            ->fetchAll($select);

        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }
        
       public function getStudenttotal($acadId) {
        $select = $this->_db->select()
            ->from($this->_name,array("count(*) as total_students"))
            ->where("$this->_name.academic_id in (?)", $acadId);
        $result = $this->getAdapter()
            ->fetchRow($select);

        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }
    
      public function getStudenttotalAll($acadId) {
        $select = $this->_db->select()
            ->from($this->_name,array("count(*) as total_students","academic_id"))
             ->join(array("batch"=>"academic_master"),"batch.academic_year_id = $this->_name.academic_id",array())
                ->join(array("depart"=>"department"),"depart.id = batch.department",array("depart.short_code")) 
            ->where("$this->_name.academic_id in (?)", $acadId)
            ->group("$this->_name.academic_id")
            ->order("$this->_name.academic_id ASC");
        $result = $this->getAdapter()
            ->fetchAll($select);

        //  echo "<pre>";  print_r($result);exit;

        return $result;
    }
    public function getDashBoardDetails($batch_ids,$cmn_terms){
    
        $select = $this->_db->select()
            ->from($this->_name)
             ->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_id",array('short_code as batch_code'))
             ->join(array("department" => "department"), "department.id=academic.department",array("department"))
             ->join(array("department_type" => "department_type"), "department_type.id=department.department_type",array("department_type"))
            ->join(array("erp_fee_structure_master" => "erp_fee_structure_master"), "erp_fee_structure_master.academic_id=$this->_name.academic_id",array())
            ->join(array("erp_fee_structure_items" => "erp_fee_structure_items"), "erp_fee_structure_items.structure_id=erp_fee_structure_master.structure_id")
            ->join(array("term_master" => "term_master"), "term_master.academic_year_id=$this->_name.academic_id",array("term_description","cmn_terms"))
            ->join(array("semester_fee_collection" => "semester_fee_collection"), "semester_fee_collection.stu_id=$this->_name.stu_id and semester_fee_collection.semester like concat('%',substr('$cmn_terms',length('$cmn_terms')))",array("fee","f_code","status as payment_status","semester"))
            ->where("$this->_name.academic_id in (?)",$batch_ids)
             ->where("semester_fee_collection.status = ?",'1');
            $select1 = $this->_db->select();
            $select1->from($select,array('t.*','sum(fee) as paid_fee'));
            $select1->where("cmn_terms like ?", $cmn_terms);
            $select1->group("student_id");
            $result = $this->getAdapter()
            ->fetchAll($select1);
            return $result;
        
    }
    
    
    public function getAllDetailsStudents($stu_id = "",$terms= "t1"){
        
        $select = "select erp_student_information.*, department.department,department_type.department_type ,GROUP_CONCAT(course_master.course_code) as course,session_info.session,session_info.id as session_id,term_master.term_id,GROUP_CONCAT(master_ge.general_elective_name) as ge1 from erp_student_information,academic_master,session_info,department,department_type,term_master,erp_elective_selection_items,course_master
,master_ge
where erp_student_information.academic_id = academic_master.academic_year_id
and department.id = academic_master.department
and department_type.id = department.department_type
and session_info.id = academic_master.session
AND erp_elective_selection_items.students_id = erp_student_information.student_id
and erp_elective_selection_items.terms = term_master.term_id
and term_master.academic_year_id = erp_student_information.academic_id
and course_master.course_id = erp_elective_selection_items.electives
and master_ge.ge_id = erp_elective_selection_items.ge_id
and erp_student_information.stu_status != 3
and erp_student_information.stu_id = '$stu_id'
and term_master.cmn_terms like '$terms'";
$result = $this->getAdapter()
            ->fetchRow($select);
            return $result;
        
    }
       public function getAllDetailsStudents1($stu_id = "",$terms= "t1"){
        
        $select = "select academic_master.*,academic_master.department as dept_id,erp_student_information.*, department.department,department_type.department_type ,session_info.session,session_info.id as session_id,term_master.term_id from erp_student_information,academic_master,session_info,department,department_type,term_master
where erp_student_information.academic_id = academic_master.academic_year_id
and department.id = academic_master.department
and department_type.id = department.department_type
and session_info.id = academic_master.session
and term_master.academic_year_id = erp_student_information.academic_id
and erp_student_information.stu_status != 3
and erp_student_information.stu_id = '$stu_id'
and term_master.cmn_terms like '$terms'";
//echo "<pre>";print_r($select);exit;
$result = $this->getAdapter()
            ->fetchRow($select);
            return $result;
        
    }
    
    public function getMaxId($year){
        $select = $this->_db->select()
        ->from('erp_student_information', array("max(cast(substring(stu_id,8,length(stu_id))as unsigned))as max_id"))
        ->where("stu_id like ?", '%'.'F-'.$year.'%');
        $result = $this->getAdapter()
            ->fetchRow($select);
//        echo $select;die;
      return $result['max_id'];
      
    }
    public function getMaxRoll($deptType,$year){
        $select = $this->_db->select()
        ->from('erp_student_information', array('MAX(roll_no) as max_roll'))
        ->where("$this->_name.year_id =?", $year)
        ->where("$this->_name.dept_type =?", $deptType);
        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo $select;die;
      return $result['max_roll'];
      
    }
    
     public function getStudentsDetialsByRegNo($reg_id) {

        $select = $this->_db->select()
            ->from($this->_name,array('stu_fname','stu_aadhar','gender','stu_caste','stu_nationality','stu_email_id','stu_dob','blood_group','present_addr','premanent_addr','father_fname','father_mobileno','mother_fname'))
            ->where("$this->_name.reg_no=?", $reg_id);
         //   echo $select; die;
             $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    
    public function getExamRollByAcademic($academic){
        $select = "SELECT concat(RPAD(substr(academic_year.academic_year,3,2),5,'_'),LPAD(max(cast(substr(exam_roll,6,length(exam_roll)) as unsigned)+1),5,0)) as exam_roll FROM `erp_student_information`,
academic_master,
academic_year
WHERE 
academic_master.academic_year_id = erp_student_information.academic_id
and academic_year.year_id = academic_master.academic_year
and `academic_id` = $academic";
$result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    
}
//end