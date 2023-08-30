<?php

/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */
class Application_Model_EvaluationComponents extends Zend_Db_Table_Abstract {

    public $_name = 'evaluation_components_master';
    protected $_id = 'ec_id';

    //get details by record for edit
    public function getRecord($id) {
        if ($id) {
            $select = $this->_db->select()
                    ->from($this->_name)
                    ->where("$this->_name.$this->_id=?", $id)
                    ->where("$this->_name.status !=?", 2);
            $result = $this->getAdapter()
                    ->fetchRow($select);
        } else {
            $result = array();
        }
//print_r($result);die;					  
        return $result;
    }
//To Check Existed Data
    public function checkExistedData($courseId) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.course_id=?", $courseId)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    public function getClassRoomRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
                ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_id as course", "course_name"))
                ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                ->where("$this->_name.$this->_id=?", $id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
//print_r($result);die;					  
        return $result;
    }

    public function getClassRoomRecordNew($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_id as course", "course_name"))
                ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                ->where("$this->_name.$this->_id=?", $id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        // echo $select;die;
//print_r($result);die;					  
        return $result;
    }

    public function getExpLearningRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("course_master" => "experiential_learning_components_master"), "course_master.elc_id=$this->_name.course_id", array("elc_id as course_id", "elc_name as course_name"))
                ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                ->where("$this->_name.$this->_id=?", $id)
                ->where("$this->_name.status !=?", 2);
        //echo $select;exit;
        $result = $this->getAdapter()
                ->fetchRow($select);
//print_r($result);die;					  
        return $result;
    }

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("components_items" => "evaluation_components_items_master"), "components_items.ec_id=$this->_name.ec_id", array("term_id", "GROUP_CONCAT(components_items.course_id) as courses", "GROUP_CONCAT(concat(component_name,' = ',weightage)) as components", "course_id", "component_id"))
                ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                ->where("$this->_name.status !=?", 2)
                ->group("$this->_name.ec_id")
                //->group("components_items.course_id")
                ->order("$this->_name.$this->_id DESC");

        $result = $this->getAdapter()
                ->fetchAll($select);
        // echo "<pre>";print_r($result);exit;
        return $result;
    }

    public function getRecordsByFacultyId($faculty_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("components_items" => "evaluation_components_items_master"), "components_items.ec_id=$this->_name.ec_id", array("term_id", "GROUP_CONCAT(components_items.course_id) as courses", "course_id", "component_id"))
                ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id =$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                ->where("$this->_name.status !=?", 2)
                ->where("$this->_name.employee_id =?", $faculty_id . " group by $this->_name.ec_id")
                //->group("$this->_name.ec_id")
                //->group("components_items.course_id")
                ->order("$this->_name.$this->_id DESC");

        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        if ($value['ec_id']) {
            foreach ($result as $key => $value) {
                $result[$key]['courses'] = $this->getCourses($value['ec_id']);
            }
        }
        return $result;
    }

    public function getCourses($ec_id) {

        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("components_items" => "evaluation_components_items_master"), "components_items.ec_id=$this->_name.ec_id", array("term_id", "course_id"))
                ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                ->where("$this->_name.status !=?", 2)
                ->where("$this->_name.ec_id =?", $ec_id)
                //->group("components_items.course_id")
                ->order("$this->_name.$this->_id DESC");
        $result = $this->getAdapter()
                ->fetchAll($select);

        foreach ($result as $key => $vslue) {
            $courses_arr[] = $vslue['course_id'];
        }
        return implode(',', $courses_arr);
    }

    //View purpose

    public function getcorecourselearning($corecourselearn) {

        $select = $this->_db->select()
                ->from($this->_name)
                ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
                ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name"))
                ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
                ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
                ->where("$this->_name.academic_year_id =?", $corecourselearn)
                ->where("$this->_name.status!=?", 2);

        $result = $this->getAdapter()
                ->fetchAll($select);

        return $result;
    }

    public function getItemRecords($eval_component_id) {

        if ($eval_component_id) {

            $select = $this->_db->select()
                    ->from($this->_name)
                    ->joinInner(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("term_id", "course_id", "component_name", "weightage", "remaining_weightage"))
                    ->joinLeft(array("term" => "term_master"), "term.term_id=component_items.term_id", array("term_name"))
                    ->joinLeft(array("course" => "course_master"), "course.course_id=component_items.course_id", array("course_id as course", "course_name"))
                    ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date", "short_code"))
                    ->where("$this->_name.status != 2")
                    ->where("$this->_name.ec_id=?", $eval_component_id);

            $result = $this->getAdapter()
                    ->fetchAll($select);
        } else {
            $result = array(0);
        }

        return $result;
    }

    public function getItemRecordsNew($eval_component_id) {

        if ($eval_component_id) {

            $select = $this->_db->select()
                    ->from($this->_name)
                    ->joinInner(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("term_id", "course_id", "component_name", "weightage", "remaining_weightage"))
                    //->joinLeft(array("term"=>"term_master"),"term.term_id=component_items.term_id",array("term_name"))
                    ->joinLeft(array("course" => "course_master"), "course.course_id=component_items.course_id", array("course_id as course", "course_name"))
                    // ->joinleft(array("academic"=>"academic_master"),"academic.academic_year_id=$this->_name.academic_year_id",array("from_date","to_date","short_code"))
                    ->where("$this->_name.status != 2")
                    ->where("$this->_name.ec_id=?", $eval_component_id);

            $result = $this->getAdapter()
                    ->fetchAll($select);
        } else {
            $result = array(0);
        }

        return $result;
    }

    public function getExperientialEvaluationComponentsItemRecords($eval_component_id) {
        if ($eval_component_id) {
            $select = $this->_db->select()
                    ->from($this->_name)
                    ->joinInner(array("component_items" => "experiential_evaluation_components_items"), "component_items.ec_id=$this->_name.ec_id", array("course_id", "component_name", "weightage", "remaining_weightage"))
                    ->joinLeft(array("course" => "experiential_learning_components_master"), "course.elc_id=component_items.course_id", array("elc_id as course", "elc_name"))
                    ->where("$this->_name.status != 2")
                    ->where("$this->_name.ec_id=?", $eval_component_id);

            $result = $this->getAdapter()
                    ->fetchAll($select);
        } else {
            $result = array();
        }

        return $result;
    }

    public function getComponents($academic_year_id, $department_id, $employee_id, $term_id, $course_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage"))
                //->joinLeft(array("com_grades"=>"component_grades"),"component_items.eci_id=com_grades.component_id",array("component_id"))
                ->where("$this->_name.status != 2")
                //->where("com_grades.component_id IS NULL")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("component_items.term_id=?", $term_id)
                ->where("component_items.course_id=?", $course_id);

        $result = $this->getAdapter()
                ->fetchAll($select);
        $data = array();
        foreach ($result as $val) {

            $data[$val['eci_id']] = $val['component_name'];
        }
        return $data;
    }

    public function getAddComponents($academic_year_id, $department_id, $employee_id, $term_id, $course_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage"))
                ->joinLeft(array("com_grades" => "component_grades"), "component_items.eci_id=com_grades.component_id", array("component_id"))
                ->where("$this->_name.status != 2")
                ->where("com_grades.component_id IS NULL")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("component_items.term_id=?", $term_id)
                ->where("component_items.course_id=?", $course_id);

        $result = $this->getAdapter()
                ->fetchAll($select);
        $data = array();
        foreach ($result as $val) {

            $data[$val['eci_id']] = $val['component_name'];
        }
        return $data;
    }

    public function getGradeAddComponents($academic_year_id, $department_id, $employee_id, $term_id, $course_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage"))
                ->joinLeft(array("grade_allocation" => "grade_allocation_master"), "component_items.eci_id=grade_allocation.component_id", array("component_id"))
                ->where("$this->_name.status != 2")
                ->where("grade_allocation.component_id IS NULL")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("component_items.term_id=?", $term_id)
                ->where("component_items.course_id=?", $course_id);

        $result = $this->getAdapter()
                ->fetchAll($select);
        $data = array();
        foreach ($result as $val) {
            $data[$val['eci_id']] = $val['component_name'];
        }
        return $data;
    }

    public function getAllComponents($academic_year_id, $department_id, $employee_id, $term_id, $course_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage", "component_id"))
                ->where("$this->_name.status != 2")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("component_items.term_id=?", $term_id)
                ->where("component_items.course_id=?", $course_id);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }

    public function getAllComponentsonTerms($academic_year_id, $term_id, $course_id) {

        $error = new Application_Model_Error();
        if (empty($course_id)) {
            die;
        }

        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage", "component_id"))
                ->where("$this->_name.status != 2")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("component_items.term_id=?", $term_id)
                ->where("component_items.course_id=?", $course_id);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }

    public function getAllComponentsonTerms1($academic_year_id, $term_id, $course_id) {



        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage", "component_id"))
                ->joinLeft(array("core" => "core_course_master"), "core.course_id=$this->_name.course_id", array("ge_id"))
                ->joinLeft(array("course_master" => "course_master"), "course_master.course_id=$this->_name.course_id", array('ct_id'))
                ->where("$this->_name.status != 2")
                ->where("core.academic_year_id=?", $academic_year_id)
                ->where("core.term_id=?", $term_id)
                // ->group('component_items.course_id')
                ->order("core.ge_id");
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }

    public function getEvlComponentCount($academic_year_id, $department_id, $employee_id, $course_type, $term_id, $course_id) {

        if ($course_type == 2) {
            $term_id = 0;
        }
        $select = $this->_db->select()
                ->from($this->_name)

                //->where("$this->_name.employee_id IS NULL")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("$this->_name.course_id=?", $course_id)
                ->where("$this->_name.term_id=?", $term_id)
                ->where("$this->_name.cc_id=?", $course_type)
                ->where("$this->_name.status != 2");
        //echo $select;die;		
        $result = $this->getAdapter()
                ->fetchRow($select);
        //print_r($result);die;		
        return $result;
    }

    public function getEvlComponentCountNew($academic_year_id, $department_id, $employee_id, $course_type, $term_id, $course_id) {

        if ($course_type == 2) {
            $term_id = 0;
        }
        $select = $this->_db->select()
                ->from($this->_name)

                //->where("$this->_name.employee_id IS NULL")
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("$this->_name.course_id=?", $course_id)
                ->where("$this->_name.cc_id=?", $course_type)
                ->where("$this->_name.status != 2");
        //echo $select;die;		
        $result = $this->getAdapter()
                ->fetchRow($select);
        //print_r($result);die;		
        return $result;
    }

    //rajesh code for weightage
    public function getweightages($academic_year_id, $department_id, $employee_id, $course_id, $component_id, $term_id) {

        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("component_items" => "evaluation_components_items_master"), "component_items.ec_id=$this->_name.ec_id", array("eci_id", "term_id", "course_id", "component_name", "weightage"))
                //->where("$this->_name.employee_id IS NULL")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.department_id=?", $department_id)
                ->where("$this->_name.employee_id=?", $employee_id)
                ->where("component_items.course_id=?", $course_id)
                ->where("component_items.term_id=?", $term_id)
                ->where("component_items.eci_id=?", $component_id)
                ->where("$this->_name.status != 2");
        //echo $select;die;		
        $result = $this->getAdapter()
                ->fetchRow($select);
        //print_r($result);die;		
        return $result;
    }

    public function getComponentsView($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array('components_items' => 'evaluation_components_items_master'), "components_items.ec_id=$this->_name.ec_id", array("term_id", "course_id", "GROUP_CONCAT(component_name) as cmp_name", "GROUP_CONCAT(weightage) as weighs", "GROUP_CONCAT(remaining_weightage) as remain_weighs", "eci_id"))
                ->joinLeft(array('term' => 'term_master'), "term.term_id=components_items.term_id", array("term_name"))
                ->joinLeft(array('course' => 'course_master'), "course.course_id=components_items.course_id", array("course_name"))
                ->where("$this->_name.ec_id=?", $id)
                ->group("components_items.term_id")
                ->group("components_items.course_id")
                ->where("$this->_name.status != 2");

        $result = $this->getAdapter()
                ->fetchAll($select);

        return $result;
    }

}

?>