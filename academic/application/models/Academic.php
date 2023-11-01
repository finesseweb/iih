<?php

/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */
class Application_Model_Academic extends Zend_Db_Table_Abstract {

    public $_name = 'academic_master';
    protected $_id = 'academic_year_id';

    //get details by record for edit
    public function getRecord($id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.$this->_id=?", $id)
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }
    
        


    public function getRecordByIds($values) {
        $select = $this->_db->select()
            ->from($this->_name, array('department'))
            ->where("$this->_name.$this->_id IN(?)", explode(',', $values))
            //->where("$this->_name.$this->_id=?", $id)				   
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id DESC");
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getRecordBySessionId($session) {
        //  echo $session; exit;
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id as academic_id', 'short_code'))
            ->where("$this->_name.session in (?)", $session)
            ->where("$this->_name.status !=?", 2);
        //echo $select; 
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getRecordsByDepartment($department) {
        $select = $this->_db->select('academic_year_id')
            ->from($this->_name)
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.department =?", $department);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getBatchDetails($id) {

        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'from_date', 'to_date', 'short_code'))
            ->where("$this->_name.status !=?", 2)
            ->where("$this->_name.$this->_id=?", $id);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getDropDownList() {
       
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'session', 'from_date', 'to_date', 'short_code'));
            
            $select->where("$this->_name.status!=?", 2);
            $select->order('academic_year_id  ASC');
            
            //echo $select;die;
        $result = $this->getAdapter()->fetchAll($select);
        //echo '<pre>'; print_r($result);exit;
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {
            $data[$val['academic_year_id']] = $val['short_code'];
        }
        return $data;
    }
    
    public function getDropDownListForRoutine() {
        //echo '<pre>'; print_r($_SESSION);exit;
        if ($_SESSION['admin_login']['admin_login']->empl_id)
        $empl_id = $_SESSION['admin_login']['admin_login']->empl_id;
        
         
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'session', 'from_date', 'to_date', 'short_code'));
            if ($empl_id !== 'superAdmin'  && !empty($empl_id)) {
                $select->join(array("empl_dept"),"empl_dept.dept_id=$this->_name.department",array('dept_id'));
                $select->where('empl_dept.empl_id = ?',$empl_id);
            }else if($empl_id === 'superAdmin' ){
                
            }
            else{
                $select->where("academic_year_id =?", $_SESSION['admin_login']['admin_login']->participant_academic);
            }
            $select->where("$this->_name.status!=?", 2);
            $select->order('academic_year_id  ASC');
            
            //echo $select;die;
        $result = $this->getAdapter()->fetchAll($select);
        //echo '<pre>'; print_r($result);exit;
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {
            $data[$val['academic_year_id']] = $val['short_code'];
        }
        return $data;
    }

    public function getDropDownNonugList() {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'session', 'from_date', 'to_date', 'short_code'))
            ->join(array("nonug" => "non_collegiate_data"), "nonug.academic_id=$this->_name.academic_year_id")
            ->where("$this->_name.status!=?", 2)
            ->where("nonug.status=?", 0)
            ->order('academic_year_id  ASC');
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

    public function getDropDownNonpgList() {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'session', 'from_date', 'to_date', 'short_code'))
            ->join(array("nonpg" => "department"), "nonpg.id=$this->_name.department", array())
           // ->join(array("nonpg" => "non_collegiate_stu_data"), "nonpg.academic_id=$this->_name.academic_year_id")
            ->where("$this->_name.status!=?", 2)
            ->where("nonpg.status=?", 0)
            ->where("nonpg.degree_id != ?", 1)
            ->order('academic_year_id  ASC');
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

    public function getCourseByDegreeId($degree_id) {
        $select = $this->_db->select()
            ->from('department_type')
            ->where("department_type.status=?", 0)
            ->where("department_type.degree_id=?", $degree_id);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getCoreCourseByCourseId($c_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'session', 'from_date', 'to_date', 'short_code'))
            ->joinleft(array("course_by_degree"), "course_by_degree.id=$this->_name.c_id", array("session"))
            ->where("$this->_name.status!=?", 2)
            ->where("$this->_name.c_id =?", $c_id)
            ->order('academic_year_id  ASC');
        $result = $this->getAdapter()->fetchAll($select);

        return $result;
    }

    public function getSessionByCourseId($degree_id) {
        $select = $this->_db->select()
            ->from('department_type')
            ->where("department_type.degree_id=?", $degree_id)
            ->group('session');
        $result = $this->getAdapter()->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getDropDownList1() {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'short_code'))
            ->where("$this->_name.status!=?", 2)
            ->order('academic_year_id  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {

            $data[$val['academic_year_id']] = $val['short_code'];

            // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
            //print_r($data);die;
        }
        return $data;
    }

    public function getDropDownList2($batch_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'short_code'))
            ->where("$this->_name.status!=?", 2)
            ->where("academic_year_id =?", $batch_id)
            ->order('academic_year_id  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {

            $data[$val['academic_year_id']] = $val['short_code'];

            // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
            //print_r($data);die;
        }
        return $data;
    }

    public function getValidateAcademic($academic_year_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'from_date', 'to_date'))
            //->where("$this->_name.term_name =?", $term_id)
            ->where("$this->_name.status!=?", 2)
            ->order('academic_year_id  ASC');
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }

    public function getIncrementID() {
        $select = "SELECT `academic_master`.`academic_year_id` FROM `academic_master` WHERE (status !=2) ORDER BY `academic_year_id` DESC";

        $result = $this->getAdapter()->fetchRow($select);

        //if( !empty($result['waybill_no']) )
        //{
        $data = $result['academic_year_id'] + 1;
        //	print_r($data);die;
        if (strlen($data) == 1) {
            $data = "0" . $data . @(SHORTCODE_PREFIX);
        } else
        if (strlen($data) == 2) {
            $data = "0" . $data . @(SHORTCODE_PREFIX);
        } else
        if (strlen($data) == 3) {
            $data = "0" . $data . @(SHORTCODE_PREFIX);
            $data = "" . $data . @(SHORTCODE_PREFIX);
        }

        return $data;
    }

    //Drop Down For Short Code

    public function getDropDownListShortCode() {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'short_code'))
            ->where("$this->_name.status!=?", 2)
            ->order('academic_year_id  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        //echo'<pre>';print_r($result);die;
        $data = array();
        foreach ($result as $k => $vals) {

            $data[$vals['academic_year_id']] = $vals['short_code'];
        }

        return $data;
    }
    
    public function getAcademicDegree($academic_id = '') {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("dept" => "department"), "dept.id=$this->_name.department", array('degree_id'))
            ->where("$this->_name.academic_year_id=?", $academic_id)
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result['degree_id'];
    }
    
     public function getAcademicdepartment($academic_id = '') {
        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("dept" => "department"), "dept.id=$this->_name.department", array('department'))
            ->join(array("dept_type" => "department_type"), "dept_type.id=dept.department_type", array('department_type'))
            ->where("$this->_name.academic_year_id in (?)", $academic_id)
            ->where("$this->_name.status !=?", 2);
            //echo $select; die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }
    
     
    public function getAcademicDegreeForSession($academic_id = '') {
        $select = $this->_db->select()
            ->from($this->_name,array('session'))
            ->joinLeft(array("dept" => "department"), "dept.id=$this->_name.department")
            ->where("$this->_name.academic_year_id=?", $academic_id)
            ->where("$this->_name.status !=?", 2);
    //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }
    

    public function getAcademics($session = '', $degree_id = '') {

        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id'))
            ->joinLeft(array("dept" => "department"), "dept.id=$this->_name.department", array())
            ->where("$this->_name.session=?", $session)
            ->where("dept.degree_id=?", $degree_id)
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getCourses($session_id, $dept, $term_id, $ge_id) {

        $select = $this->_db->select()
            ->from($this->_name, array(''))
            ->joinLeft(array("cc_master" => "core_course_master"), "cc_master.academic_year_id=$this->_name.academic_year_id", array('course_id'))
            ->where("$this->_name.session=?", $session_id)
            ->where("$this->_name.department=?", $dept)
            ->where("cc_master.ge_id=?", $ge_id)
            ->where("cc_master.cmn_terms=?", $term_id)
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getAcademicsBySD($session = '', $degree_id = '') {

        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id'))
            ->where("$this->_name.session=?", $session)
            ->where("$this->_name.department=?", $degree_id)
            ->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }

    //Added by kedar: date :03 june  3212
    public function getDepartment($acadId = '', $session = '') {

        $select = $this->_db->select()
            ->from($this->_name, array('department','session','academic_year','short_code'));
            if(!empty($session))
            $select->where("$this->_name.session=?", $session);
            $select->where("$this->_name.academic_year_id=?", $acadId);
            $select->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter() 
            
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }

    //end
    public function getAcademicOnDept($dept_id = '',$sesion='', $degree_id = '', $not_in_dept = '', $academic_id = '') {
        $select = $this->_db->select();
        $select->from($this->_name, array('academic_year_id', 'from_date', 'to_date', 'short_code as batch_code'));
        $select->joinLeft(array("dept" => "department"), "dept.id=$this->_name.department", array());


        if (!empty($dept_id)) {
            $select->where("$this->_name.department in (?)", explode(',', $dept_id));
        }


        if (!empty($not_in_dept)) {
            $select->where("$this->_name.department not in (?)", explode(',',$not_in_dept));
        }

        if (!empty($degree_id)) {
            $select->where("dept.degree_id=?", $degree_id);
        }
        if (!empty($academic_id)) {
            $select->where("$this->_name.academic_year_id=?", $academic_id);
        }
        if (!empty($sesion)) {
            $select->where("$this->_name.session=?", $sesion);
        }
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getAcademicOnDept1($dept_id = '', $academic_id = '') {
        $select = $this->_db->select();
        $select->from($this->_name, array('academic_year_id', 'from_date', 'to_date', 'short_code as batch_code'));


        if (!empty($dept_id)) {
            $select->where("$this->_name.department=?", $dept_id);
        }
        if (!empty($session_id)) {
            $select->where("$this->_name.academic_year_id=?", $academic_id);
        }
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getAcademic($short_id) {

        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'from_date', 'to_date', 'batch_code'))
            //->joinLeft(array("empl_job"=>"fa_kv_empl_job"),"empl_job.empl_id=$this->_name.empl_id",array("department","desig_group","desig"))
            ->where("$this->_name.academic_year_id=?", $short_id);

        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }

    //==========================================================================26-04-19 satyam =====================
    public function getlastdateRecord($academic_id) {
        $select = "SELECT start_date, end_date FROM program_design_master  Where  academic_year_id='$academic_id' and status !=2  order by pd_id DESC LIMIT 1";
        $result = $this->getAdapter()
            ->fetchRow($select);
        //print_r($result);die;
        return $result;
    }

    //===============================================================================================================

    public function getBatchCodeRecord($academic_year_id) {
        if ($academic_year_id) {
            $select = $this->_db->select()
                ->from($this->_name, array('short_code', 'batch_code'))
                ->where("$this->_name.academic_year_id =?", $academic_year_id)
                ->where("$this->_name.status!=?", 2);
            //->order('academic_year_id  ASC');
            //echo $select;die;
            $result = $this->getAdapter()
                ->fetchRow($select);
        } else {
            $result = array();
        }
        return $result;
    }
    
    
      public function getRecordByAcadyear($academic_year,$department) {
       
            $select = $this->_db->select()
                ->from($this->_name, array('short_code', 'batch_code','session','academic_year_id'))
                ->join(array("department"=>"department"),"department.id=$this->_name.department",array("id"))
                ->where("$this->_name.academic_year =?", $academic_year)
                 ->where("department.department =?", $department)
                ->where("$this->_name.status!=?", 2);
            //->order('academic_year_id  ASC');
            //echo $select;die;
            $result = $this->getAdapter()
                ->fetchRow($select);
      
        return $result;
    }
    
    public function getRecordByDeptyear($academic_year,$department) {
       
            $select = $this->_db->select()
                ->from($this->_name, array('academic_year_id'))
                ->where("$this->_name.department =?", $department)
                ->where("$this->_name.academic_year =?", $academic_year)
                ->where("$this->_name.status!=?", 2);
            //->order('academic_year_id  ASC');
            //echo $select;die;
            $result = $this->getAdapter()
                ->fetchRow($select);
      
        return $result['academic_year_id'];
    }

// ramesh for enabled between dates in year 
    public function getyearRecord($academic_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('from_date', 'to_date'))
            ->where("$this->_name.academic_year_id =?", $academic_id)
            ->where("$this->_name.status!=?", 2);
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }

    public function getAcademicDesignOrderByDate($academic_year_id) {
        $select = "SELECT id, c_type, term_name, tot_no_of_credits FROM ( SELECT term_id as id, 'term' as c_type, term_name,	tot_no_of_credits, start_date_type, end_date_type FROM term_master t WHERE status != 2 AND academic_year_id = $academic_year_id UNION SELECT ec.elc_id as id, 'el' as c_type, ec.elc_name, cr.credit_value as tot_no_of_credits, start_date_type, end_date_type FROM experiential_learning_master e JOIN experiential_learning_components_master ec ON ec.elc_id = e.elc_id JOIN credit_master cr ON cr.credit_id = e.credit_id WHERE e.status != 2 AND e.academic_year_id = $academic_year_id AND ec.status != 2 ) AS p ORDER BY p.start_date_type;";

        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }

    public function getFeeDropDownList() {
        $select = $this->_db->select();
        $select->from($this->_name, array('academic_year_id', 'short_code',));
        $select->joinLeft(array("erp_fee_structure_master"), "erp_fee_structure_master.academic_id=$this->_name.academic_year_id", array());

        $select->where("erp_fee_structure_master.structure_id is Null");
        $select->where("$this->_name.status =?", 0);
      //  $select->order('erp_fee_structure_master.department  ASC');
        // echo $select; die;
        $result = $this->getAdapter()->fetchAll($select);
        //echo $select;die;
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {

            $data[$val['academic_year_id']] = $val['short_code'];

            // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
            //echo "<pre>";print_r($data);
        }
        return $data;
    }
	
	
	public function getFeeDropDownList1() {
        $select = $this->_db->select();
        $select->from($this->_name, array('academic_year_id', 'short_code',));
        $select->where("$this->_name.status =?", 0);
      //  $select->order('erp_fee_structure_master.department  ASC');
        // echo $select; die;
        $result = $this->getAdapter()->fetchAll($select);
        //echo $select;die;
        $data = array();
        $st_year = '';
        $end_year = '';
        foreach ($result as $val) {

            $data[$val['academic_year_id']] = $val['short_code'];

            // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
            //echo "<pre>";print_r($data);
        }
        return $data;
    }

    //Date : 05 oct 2020
    public function getBatchBySession($session) {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'short_code'))
            ->joinLeft(array("dept" => "department"), "dept.id=$this->_name.department", array())
            ->where("$this->_name.session=?", $session)
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getAcademicId($dept_id, $session) {
       $select  = $this->_db->select()
        ->from($this->_name,array('academic_year_id',"group_concat(academic_year_id) as batch_ids"))
        ->joinLeft(array("dept"=>"department"),"dept.id=$this->_name.department",array())
        ->where("$this->_name.department in (?)",$dept_id)
        ->where("$this->_name.session=?",$session)
        ->where("$this->_name.status !=?", 2);
		
		//echo $select ; die();
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
    }
    
   

    // Author: Kedar Date : 27 Nov 2020
    public function getRecordBySession($session_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('academic_year_id', 'department','academic_year'))
            ->joinLeft(array("dept" => "department"), "dept.id=$this->_name.department", array('department as dept_name'))
            ->joinLeft(array("dept_type" => "department_type"), "dept_type.id=dept.department_type", array('dept_type.department_type as hons_name','dept_type.id'))
            ->joinleft(array("erp_stud" => "erp_student_information"), "erp_stud.academic_id=$this->_name.academic_year_id", array('count(academic_id) as total_count', 'count(case stu_status when 1 then 1 else null end) as active_stud_count', 'count(case when stu_status != 1 then 1 end) as tc_stud_count'))
            ->where("$this->_name.session=?", $session_id)
            ->group("dept_type.id")
            ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

}

?>