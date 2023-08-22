<?php

/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */
class Application_Model_AddonLearningModel extends Zend_Db_Table_Abstract {

    public $_name = 'core_addon_master';
    protected $_id = 'ccl_id';

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

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name", "course_code"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("short_code", "from_date", "to_date"))
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id DESC");
        // ->limit(100);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    //Filter record by Course Group
    public function getRecordsByCourseGroup($session_id = '', $course_group = '') {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name", "course_code"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("short_code", "from_date", "to_date"))
            ->where("academic.session =?", $session_id)
            ->where("$this->_name.ge_id =?", $course_group)
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id ASC");
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo"<pre>";print_r($result);die;
        return $result;
    }

//------------------
    public function getcredit() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id", array("from_date", "to_date"))
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id DESC");
        $result = $this->getAdapter()
            ->fetchAll($select);
//print_r($result); die;					  
        return $result;
    }

    //View purpose

    public function getcorecourselearning($academic_year_id = '', $term_id = '') {
        //if( !empty( $academic_year_id ) || !empty( $term_id )) {
        if (!empty($academic_year_id) && (!empty($term_id))) {
            $select = $this->_db->select()
                ->from($this->_name)
                ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
                ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name"))
                ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
                ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
                ->where("$this->_name.academic_year_id =?", $academic_year_id)
                ->where("$this->_name.term_id =?", $term_id)
                ->where("$this->_name.status!=?", 2);
        } else {

            $select = $this->_db->select()
                ->from($this->_name)
                ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
                ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name"))
                ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
                ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
                ->where("$this->_name.academic_year_id =?", $academic_year_id)
                ->where("$this->_name.status!=?", 2);
        }
        //}
        $result = $this->getAdapter()
            ->fetchAll($select);


        return $result;
    }

    public function getGeCourses($academic_year_id = '', $term_id = '') {

        $select = $this->_db->select()
            ->from($this->_name, array('ge_id'))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_id", "course_code as course_name"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("tm" => "term_master"), "tm.term_id=$this->_name.term_id", array(""))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id in(?)", $academic_year_id)
            ->where("tm.cmn_terms =?", $term_id)
            ->where("$this->_name.ge_id !=?", 0)
            ->where("$this->_name.status!=?", 2)
            ->group("$this->_name.course_id");
        $result = $this->getAdapter()
            ->fetchAll($select);


        return $result;
    }

    public function getGeCourses1($academic_year_id = '', $term_id = '') {

        $select = $this->_db->select()
            ->from($this->_name, array('ge_id'))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_id", "course_code as course_name"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array())
            ->joinleft(array("tm" => "term_master"), "tm.term_id=$this->_name.term_id", array(""))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array())
            ->where("$this->_name.academic_year_id in(?)", $academic_year_id)
            ->where("tm.cmn_terms =?", $term_id)
            ->where("$this->_name.ge_id =?", 0)
            ->where("$this->_name.status!=?", 2)
            ->group("$this->_name.course_id");
        $result = $this->getAdapter()
            ->fetchAll($select);


        return $result;
    }

    public function getGeCoursesEdit($academic_year_id = '', $term_id = '') {

        $select = $this->_db->select()
            ->from($this->_name, array('ge_id'))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_id", "course_name"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id =?", $academic_year_id)
            ->where("$this->_name.term_id =?", $term_id)
            ->where("$this->_name.ge_id !=?", 0)
            ->where("$this->_name.status!=?", 2);
        //   echo $select; die;
        $result = $this->getAdapter()
            ->fetchAll($select);


        return $result;
    }

    public function getprogram($ccl_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name", "year_id"))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id =?", $ccl_id)
            ->where("term.year_id=?", 1)
            ->where("$this->_name.status!=?", 2);
        $result = $this->getAdapter()
            ->fetchAll($select);



        return $result;
    }

    public function getprogramByYearTerm($acadecic_year_id, $term_id='') {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name", "year_id","term_description","term_id","cmn_terms as cmn_term"))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name", "course_code"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id =?", $acadecic_year_id)
           ->where("$this->_name.term_id =?", $term_id)
            ->where("$this->_name.status!=?", 2);
          //echo $select;die;
        $result = $this->getAdapter()
      
            ->fetchAll($select);



        return $result;
    }

   public function checkExistedData($acad_id){
       $select = $this->_db->select()
            ->from($this->_name)
            
            ->where("$this->_name.academic_year =?", $acad_id)
           // ->where("$this->_name.term_id =?", $termId)
            ->where("$this->_name.status!=?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
      
            ->fetchRow($select);



        return $result;
   }

    public function getSecondyearCourses($academic_year_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name", "year_id"))
            ->joinleft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name"))
            ->joinleft(array("cc" => "course_category_master"), "cc.cc_id=$this->_name.cc_id", array("cc_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id =?", $academic_year_id)
            ->where("term.year_id=?", 2)
            ->where("$this->_name.status!=?", 2);

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getErpCoreCouseDetailByTermAcademicCourse($academic_year_id, $term_id, $course_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.course_id IN (?)", $course_id)
            ->where("$this->_name.status !=?", 2)
            ->where("credit.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchAll($select);
           // echo $select; die();
        return $result;
    }
public function getCoreCouseDetailByTermAcademicCourse($academic_year_id, $term_id, $course_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.course_id=?", $course_id)
            ->where("$this->_name.status !=?", 2)
            ->where("credit.status !=?", 2);

        $result = $this->getAdapter()
            ->fetchRow($select);
           // echo $select; die();
        return $result;
    }

    public function getCoreCousecreditCountno($academic_year_id, $term_id, $course_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.course_id in (?)", $course_id)
            ->where("$this->_name.count_id =?", 0)
            ->where("$this->_name.status !=?", 2)
            ->where("credit.status !=?", 2)
            ->group("$this->name.course_id");
       // echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);

        //  echo "<pre>";print_r($result);exit;
        return $result;
    }
public function getCoreCouseDetailByTermAcademicCourseid($academic_year_id, $term_id, $ge_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('course_id'))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.ge_id=?", $ge_id)
            ->where("$this->_name.status !=?", 2);
         //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result['course_id'];
    }
    public function getErpCoreCouseDetailByTermAcademicCourseid($academic_year_id, $term_id, $ge_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('course_id'))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.ge_id IN (?)", $ge_id )
            ->where("$this->_name.status !=?", 2);
        // echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
         return $result;
       // return $result['course_id'];
    }
    public function getGeCourse($academic_year_id, $term_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('course_id'))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.ge_id !=?", 0)
            ->where("$this->_name.status !=?", 2);
         //echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result['course_id'];
    }

    public function getNoNcontables($term_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.count_id=?", 1)
            ->where("$this->_name.term_id=?", $term_id);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getRecordsByTermId($term_id) {
        $select = $this->_db->select()
            ->from($this->_name, array("count(*) as len"))
            ->joinLeft(array("erp_elective_selection_items" => "erp_elective_selection_items"), "erp_elective_selection_items.electives=$this->_name.course_id")
            ->where("$this->_name.term_id=?", $term_id)
            ->where("erp_elective_selection_items.terms=?", $term_id)
            ->where("$this->_name.ge_id!=?", 0)
            ->group("erp_elective_selection_items.students_id");
        //  echo $select; die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        $len = $this->corecoursecount($term_id);
        // echo $term_id; die;
        return (int) $result['len'] + (int) $len;
    }

    public function corecoursecount($term_id) {
        $select = $this->_db->select()
            ->from($this->_name, array("count(*) as len"))
            ->where("$this->_name.ge_id=?", 0)
            ->where("$this->_name.term_id=?", $term_id);
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result['len'];
    }

    public function getCoreCouseDetailByTermAcademicCourseidAll($academic_year_id, $term_id, $cc_id, $ge_id = '', $cmn_term = '') {
        $select = $this->_db->select();
        $select->from($this->_name, array('course_id'));
        $select->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array('course_name'));
        $select->where("$this->_name.academic_year_id=?", $academic_year_id);
        $select->joinLeft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array(""));
        $select->where("term.cmn_terms=?", $cmn_term);
        $select->where("$this->_name.cc_id=?", $cc_id);
        if (!empty($ge_id))
            $select->where("$this->_name.ge_id=?", $ge_id);
        $select->where("$this->_name.status !=?", 2);
        $select->group("$this->_name.course_id");
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    //Added By: Kedar :Date: 24-11-2020
    public function getGeCouseDetailByEmployee($employee_id, $term_id, $cc_id, $ge_id = '', $cmn_term = '') {
        $select = $this->_db->select();
        $select->from($this->_name, array('course_id'));
        $select->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array('course_name'));
        $select->join(array("allocation_items" => "employee_allocation_items_master"), "allocation_items.course_id=$this->_name.course_id", array('employee_id'));
        $select->joinLeft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array(""));
        $select->where("term.cmn_terms=?", $cmn_term);
        $select->where("allocation_items.faculty_id like?", '%' . $employee_id . '%');
        $select->where("$this->_name.cc_id=?", $cc_id);
        if (!empty($ge_id))
            $select->where("$this->_name.ge_id=?", $ge_id);
        $select->where("$this->_name.status !=?", 2);
        $select->group("$this->_name.course_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
        // echo $select; die;

        return $result;
    }

    // End

    public function getcorecourses($academic_year_id, $term_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("course_name","course_code"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->where("$this->_name.status != 2")
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id);

        $result = $this->getAdapter()
            ->fetchAll($select);
//echo "<pre>";print_r($result);exit;
        return $result;
    }

    public function getcorecoursesid($term_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.status != 2")
            ->where("$this->_name.course_id=?", $term_id)
            ->group("$this->_name.cc_id");
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

//public function getcourseTypeOn($academic_year_id,$term_id){
//                $select =  $this->_db->select()
//					->from($this->_name,array('ge_id','course_id'))
//                    ->joinLeft(array("course"=>"course_master"),"course.course_id=$this->_name.course_id",array("ct_id"))
//                    ->joinleft(array("credit"=>"credit_master"),"credit.credit_id=$this->_name.credit_id",array("credit_value"))
//                    ->joinleft(array("ct"=>"course_type_master"),"ct.ct_id=course.ct_id",array("ct_name"))
//                    ->where("$this->_name.status != 2")
//					->where("$this->_name.academic_year_id=?",$academic_year_id)
//	                 ->where("$this->_name.term_id=?",$term_id)
//                      ->group("course.ct_id")
//                        ->order("$this->_name.ge_id");
//
//                $result = $this->getAdapter()
//					->fetchAll($select);
//
//            return $result;
//						
//
//		
//
//	}
    public function getcourseTypeOn1($academic_year_id, $term_id) {
//                $select =  $this->_db->select()
//					->from($this->_name,array('distinct(ge_id) as ge_id'))

        $select = $this->_db->select()
            ->from($this->_name, array('ge_id', 'course_id', 'count_id'))
            ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("ct_id"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->joinleft(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array("ct_name"))
            ->where("$this->_name.status != 2")
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id);
        //->group("course.ct_id");

        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getTerm($academic_year_id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinLeft(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array("term_name"))
            ->where("$this->_name.academic_year_id=?", $academic_year_id);


        $result = $this->getAdapter()
            ->fetchAll($select);


        $data = array();

        foreach ($result as $val) {
            $data[$val['term_id']] = $val['term_name'];
        }

        return $data;
    }

    public function getCourseRecord($academic_year_id, $category_id, $course_id, $term_id) {
        $select = $this->_db->select()
            ->from($this->_name, array("count(course_id) as course_count"))
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.cc_id=?", $category_id)
            ->where("$this->_name.course_id=?", $course_id);
        //      echo $select; die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }

    public function getcourseTypeOn($academic_year_id, $addon_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('course_id','count_id'))
            ->joinLeft(array("course" => "addon_course_master"), "course.course_id=$this->_name.course_id", array("course_code", "course_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
        //    ->joinleft(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array("ct_name"))
        //    ->joinleft(array("cat" => "course_category_master"), "cat.cc_id=course.course_category_id", array("cc_name"))
            ->where("$this->_name.status != 2")
            ->where("$this->_name.academic_year=?", $academic_year_id)
            ->where("$this->_name.addon_course_list=?", $addon_id);
           
 //echo "<pre>".$select; die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getcorecourse($academic_year_id, $term_id) {
        $select = $this->_db->select()
            ->from($this->_name, array('ge_id', 'course_id'))
            ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("ct_id", "course_category_id as cc_id", "course_code", "course_name"))
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->joinleft(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array("ct_name"))
            ->joinleft(array("cat" => "course_category_master"), "cat.cc_id=course.course_category_id", array("cc_name"))
            ->where("$this->_name.status != 2")
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("$this->_name.ge_id in (?)", array(0, 35, 36))
            ->group("course.ct_id")
            ->order(array("ct.sort_order", "ct.ct_name"));

        //->order("$this->_name.ge_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }
    
    
    public function studentCorecourse($academic, $term){
                   $select = 'SELECT addon_course_master.course_id,addon_course_master.course_code from
            core_addon_master
            ,addon_course_master
           ,addon_course_mater
            where core_addon_master.addon_course_list  = '.$term
            .' and core_addon_master.academic_year = '.$academic
            .'  and addon_course_master.course_id = core_addon_master.course_id
              and addon_course_master.addon_course_id = addon_course_mater.id
              order by addon_course_mater.id';
                   
          ///  echo "<pre>" .$select; die();      
$result = $this->getAdapter()
            ->fetchAll($select);
return $result;
}
    
    public function studentGe($stu_id,$term){
             $select ='SELECT erp_student_information.student_id,course_master.course_code,course_master.course_id from 
             erp_student_information
            ,erp_elective_selection
            ,erp_elective_selection_items
            ,course_master
            ,core_course_master
            ,term_master
            ,course_type_master
            where erp_student_information.stu_id="'.$stu_id.'" 
            AND term_master.term_id  = '.$term.'
            and erp_elective_selection_items.ge_id not in(0,35,36)
            and erp_elective_selection.student_id = erp_student_information.student_id
            and erp_elective_selection.academic_year_id= erp_student_information.academic_id
            and erp_elective_selection_items.elective_id = erp_elective_selection.elective_id
            and course_master.course_id = erp_elective_selection_items.electives
            and course_type_master.ct_id = course_master.ct_id
            and core_course_master.course_id = erp_elective_selection_items.electives
            and core_course_master.term_id = erp_elective_selection_items.terms
            and term_master.term_id = erp_elective_selection_items.terms
            and term_master.academic_year_id = erp_elective_selection.academic_year_id
            order by course_type_master.sort_order,course_type_master.ct_name';
            $result = $this->getAdapter()
            ->fetchAll($select);
            return $result;

}

    public function getStudentGE($academic_year_id, $term_id, $student_id, $ge_id = '', $core_courses = array(35, 36)) {
        $select = $this->_db->select()
            ->from($this->_name, array('ge_id'))
            ->join(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("ct_id", "course_category_id as cc_id", "course_code", "course_name", "course_id"))
            ->join(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"))
            ->join(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array("ct_name"))
            ->join(array("cat" => "course_category_master"), "cat.cc_id=course.course_category_id", array("cc_name"))
            ->join(array("selection_item" => "erp_elective_selection_items"), "selection_item.ge_id=$this->_name.ge_id", array())
            ->where("$this->_name.status != 2")
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("selection_item.students_id=?", $student_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->where("selection_item.terms=?", $term_id)
            ->order(array("ct.sort_order", "ct.ct_id", "ct.ct_name"));



        $result = $this->getAdapter()
            ->fetchAll($select);
        $course_arr = array();
        foreach ($result as $key => $value) {

//                   if(!in_array($value['ge_id'],$core_courses)){
            $re = $this->getElective($student_id, $value['ge_id'], $term_id, $value['course_id']);
            if (in_array($value['course_id'], $course_arr))
                unset($result[$key]);
            if ($result[$key]['course_id'] == $re[0]['electives'])
                $course_arr[] = $result[$key]['course_id'];
            else
                unset($result[$key]);
//                   }
        }
        //echo $select; die();
        return $result;
    }

    public function getBackStudentGE($academic_year_id, $term_id, $student_id, $month="") {
        $select = $this->_db->select();
            $select->from($this->_name, array('ge_id'));
            $select->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("ct_id", "course_category_id as cc_id", "course_code", "course_name", "course_id"));
            $select->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"));
            $select->joinleft(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array("ct_name", "sort_order"));
            $select->joinleft(array("cat" => "course_category_master"), "cat.cc_id=course.course_category_id", array("cc_name"));
            $select->joinleft(array("selection_item" => "back_selection_items"), "selection_item.ge_id=$this->_name.ge_id and selection_item.electives = $this->_name.course_id", array(""));
            $select->where("$this->_name.status != 2");
            $select->where("$this->_name.academic_year_id=?", $academic_year_id);
            $select->where("selection_item.students_id=?", $student_id);
            if($month)
            $select->where("selection_item.exam_month=?", $month);
            $select->where("$this->_name.term_id=?", $term_id);
            $select->where("selection_item.terms=?", $term_id);
            $select->order(array("ct.sort_order", "course.course_code"));
            $select->group("course.course_id");
        //->order("$this->_name.ge_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
//  foreach($result as $key => $value){
//                   
//                    if($value['ge_id'] != 0){
//                        $re = $this->getBackElective($student_id, $value['ge_id'], $term_id);
//                        $result[$key]['course_id'] = $re[0]['electives'];
//                        break;
//                    }
//                }

        $course_arr = array();
        foreach ($result as $key => $value) {


            $re = $this->getBackElective($student_id, $value['ge_id'], $term_id, $value['course_id']);
            if (in_array($value['course_id'], $course_arr))
                unset($result[$key]);
            if ($result[$key]['course_id'] == $re[0]['electives'])
                $course_arr[] = $result[$key]['course_id'];
            else
                unset($result[$key]);
        }
        //   echo "<pre>";print_r($result);exit;
        return $result;
    }

    public function getElective($student_id, $ge_id, $term_id, $course_id) {

        $select = $this->_db->select()
            ->from('erp_elective_selection_items', array('electives'))
            ->where("erp_elective_selection_items.students_id=?", $student_id)
            ->where("erp_elective_selection_items.terms=?", $term_id)
            ->where("erp_elective_selection_items.ge_id=?", $ge_id)
            ->where("erp_elective_selection_items.electives=?", $course_id);
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getBackElective($student_id, $ge_id, $term_id, $course_id) {

        $select = $this->_db->select()
            ->from('back_selection_items', array('electives'))
            ->where("back_selection_items.students_id=?", $student_id)
            ->where("back_selection_items.terms=?", $term_id)
            ->where("back_selection_items.ge_id=?", $ge_id)
            ->where("back_selection_items.electives=?", $course_id);
        //   echo $select; die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getOnCC($academic_year_id, $term_id) {
        $select = $this->_db->select()
            ->from($this->_name, array())
            ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array())
            ->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array())
            ->joinleft(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array())
            ->joinleft(array("cat" => "course_category_master"), "cat.cc_id=course.course_category_id", array("distinct(cc_name) as cc_name"))
            ->where("$this->_name.status != 2")
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->where("$this->_name.term_id=?", $term_id)
            ->group(array("cat.cc_id"));
        //->order("$this->_name.ge_id");
        $result = $this->getAdapter()
            ->fetchAll($select);

        return $result;
    }

    public function getCourseRecordbyCcId($academic_year_id, $category_id, $term_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->joinLeft(array("ge" => "master_ge"), "ge.ge_id=$this->_name.ge_id", array("general_elective_name"))
            ->where("$this->_name.cc_id=?", $category_id)
            ->where("ge.status=?", 0)
            ->group("ge.ge_id")
            ->where("$this->_name.term_id=?", $term_id);
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getCourseRecordbyCcIdEmpl($academic_year_id, $category_id, $term_id, $empl_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.academic_year_id=?", $academic_year_id)
            ->join(array("ge" => "master_ge"), "ge.ge_id=$this->_name.ge_id", array("general_elective_name"))
            ->join(array("academic" => "academic_master"), "academic.academic_year_id=$this->_name.academic_year_id")
            ->join(array("empl_dept" => "empl_dept"), "empl_dept.dept_id=academic.department")
            ->where("$this->_name.cc_id=?", $category_id)
            ->where("ge.status=?", 0)
            ->group("ge.ge_id")
            ->where("$this->_name.term_id=?", $term_id);
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getCourseRecordbyCcIdEmpForDaily($empl_id, $degree_id) {
        $select = $this->_db->select()
            ->from('empl_dept')
            ->join(array("master_ge"), "master_ge.department=empl_dept.dept_id", array('ge_id', 'general_elective_name'))
            ->where("empl_id=?", $empl_id);
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo"<pre>";print_r($result);die;	  
        return $result;
        return $result;
    }

    //Added by kedar: 29 oct.
    public function getAcademicOnCoreCourse($ct_id) {
        $select = $this->_db->select();
        $select->from($this->_name, array('academic_year_id'));


        if (!empty($ct_id)) {
            $select->where("$this->_name.cc_id=?", $ct_id);
        }
        //echo $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }
 public function getcourseTypeOn2($academic_year_id, $term_id,$cmn_term='') {
        
       // echo $cmn_term; die();
        $select = $this->_db->select();
            $select->from($this->_name, array('ge_id', 'course_id','count_id','term_id'));
           $select ->joinLeft(array("course" => "course_master"), "course.course_id=$this->_name.course_id", array("ct_id", "course_category_id as cc_id", "course_code", "course_name"));
            $select->joinleft(array("credit" => "credit_master"), "credit.credit_id=$this->_name.credit_id", array("credit_value"));
            $select->joinleft(array("ct" => "course_type_master"), "ct.ct_id=course.ct_id", array("ct_name"));
            $select->joinleft(array("cat" => "course_category_master"), "cat.cc_id=course.course_category_id", array("cc_name"));
            $select->where("$this->_name.status != 2");
           $select ->where("$this->_name.academic_year_id=?", $academic_year_id);
                if($cmn_term=='t2'){
          $select->where("$this->_name.	cmn_terms in (?)", array('t1','t2')) ;
                }elseif($cmn_term=='t4') {
         $select->where("$this->_name.cmn_terms in (?)", array('t1','t2','t3','t4')) ;
                }else {
           $select->where("$this->_name.term_id=?", $term_id);
                }
            $select->group(array("course.ct_id","$this->_name.cmn_terms"));
            $select->order(array("ct.sort_order", "course.course_code"));
//echo $select; die;
        $result = $this->getAdapter()
            ->fetchAll($select);
          //echo "<pre>" ; print_r($result); die();
        return $result;
    }
       
            
public function getCourseCodeByCT($course_id,$year) {

        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array("addon_course_master"), "addon_course_master.course_id=$this->_name.course_id")
               ->join(array("addon_course_mater"), "addon_course_mater.id=$this->_name.addon_course_list")
                ->join(array("credit_master"), "credit_master.credit_id=$this->_name.credit_id")
                ->where("$this->_name.addon_course_list =?", $course_id)
                ->where("$this->_name.academic_year =?", $year)
		->where("$this->_name.status!=?", 2);
	//echo $select; die();			                              
        $result = $this->getAdapter()
                ->fetchAll($select);
		return $result;
		

    }
    
    
    public function getRecordByID($id) {
             $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.addon_course_list = ?", $id)
                ->where("$this->_name.status != ?", 2)
                ->order("$this->_name.ccl_id  DESC");
        $result = $this->getAdapter()
                ->fetchRow($select);

        return $result;
    }
}

?>