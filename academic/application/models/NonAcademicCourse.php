<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_NonAcademicCourse extends Zend_Db_Table_Abstract {

    public $_name = 'non_academic_course';
    protected $_id = 'id';

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name, array('credit_course', "id"))
                ->joinleft(array('session_info'),"session_info.id = $this->_name.session",array('session'))
                //->joinleft(array('department'),"department.id=academics.department",array('department'))
                ->where("$this->_name.status !=?", 2)
                ->order("$this->_name.$this->_id DESC");
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
    public function getRecordsBySession($id) {
        $select = $this->_db->select()
                ->from($this->_name, array('credit_course', "id"))
                ->joinleft(array('session_info'),"session_info.id = $this->_name.session",array('session'))
                ->where("$this->_name.session=?", $id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo $select;die;
        return $result;
        //echo '<pre>';print_R($result);die;
    }
    public function getRecordsBySessionforBackPage($id) {
        $select = $this->_db->select()
              
                ->from($this->_name, array('GROUP_CONCAT(credit_course ORDER BY non_academic_course.id SEPARATOR "/") as credit_course','count(*) as total'))
                ->joinleft(array('session_info'),"session_info.id = $this->_name.session",array('session'))
                ->where("$this->_name.session=?", $id)
                ->where("$this->_name.status !=?", 2)
                ->group('session');
        //echo $select;die;
        $result = $this->getAdapter()
                
                ->fetchRow($select);
              //  echo "<pre>";print_r($result);exit;
        return $result;
    }

 

    public function checkExistedData($session) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.session=?", $session)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

 public function dumpdata($mig_session){
        $this->_db->delete("$this->_name",
            array(
                "session =?" => $mig_session
            ) 
            
        );
    }
   

}
