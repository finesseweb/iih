<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_NonAcademicCreditCourseAllotmentModel extends Zend_Db_Table_Abstract {

    public $_name = 'non_credit_course_allotment';
    protected $_id = 'id';

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name, array('credit_course', "id"))
                ->joinleft(array('session_info'),"session_info.id = $this->_name.session",array('session'))
                //->joinleft(array('department'),"department.id=academics.department",array('department'))
                ->where("$this->_name.status !=?", 2)
                ->order("$this->_name.$this->_id DESC");
         // echo $select;die;
        $result = $this->getAdapter()
                
                ->fetchAll($select);
      
        return $result;
    }

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    
      public function getRecordbystuId($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array('non_academic_course'),"non_academic_course.id = $this->_name.credit_course_id",array('GROUP_CONCAT(credit_course ORDER BY non_academic_course.id SEPARATOR "/") as credit_course'))
                ->where("$this->_name.stu_id=?", $id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    
    public function trashItems($stu_id='') {
        $this->_db->delete($this->_name, "stu_id = '$stu_id'");
    }
    
    public function getStudentRecords($stu_id){
     $select = $this->_db->select()

                ->from($this->_name)
                ->where("$this->_name.stu_id = ?",$stu_id)
                ->where("$this->_name.status != ?",2);

        $result = $this->getAdapter()

                ->fetchAll($select);

        return $result;
}

}
