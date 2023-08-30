<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_Seminarassociation extends Zend_Db_Table_Abstract {

    public $_name = 'seminar_association';
    protected $_id = 'id';

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name,array('aeccge_id', 'department', 'ge_id', 'aecc_id', 'status', 'degree_id as degree'))
                ->joinleft(array("dept"=>"department"),"dept.id=$this->_name.department",array('department as department_name'))
                ->joinleft(array("aecc"=>"master_aecc"),"aecc.aecc_id=$this->_name.aecc_id")
		->joinLeft(array("ge"=>"master_ge"),"ge.ge_id=$this->_name.ge_id")
                ->where("$this->_name.status !=?", 2)
                ->order("$this->_name.$this->_id DESC");
        $result = $this->getAdapter()
                ->fetchAll($select);
            //echo $select;die;
            //echo '<pre>'; print_r($result);exit;
        return $result;
    }

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id)
                ->where("$this->_name.status !=?", 2);
    //    echo $select; die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    
    
    
    public function getRecordByEmailID($id,$mob){
            
                   $select = $this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.email=?", $id)
                      ->where("$this->_name.number=?", $mob)
                       ->where("$this->_name.status !=?", 1);
            $result = $this->getAdapter()
                      ->fetchRow($select);
         //  echo $select;die();
           return $result;
    
    }
    public function getRecordByPaid($id,$mob){
            
                   $select = $this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.email=?", $id)
                      ->where("$this->_name.number=?", $mob)
                       ->where("$this->_name.status =?", 1);
            $result = $this->getAdapter()
                      ->fetchRow($select);
         //  echo $select;die();
           return $result;
    
    }
    
    public function getDropDownList($id){
        
            $select = $this->_db->select()
                      ->from('core_course_master')
                      ->where("core_course_master.ge_id=?", $id)
                      ->joinLeft(array("course"=>"course_master"),"course.course_id=core_course_master.course_id",array('course_id','course_name'))
                      ->where("core_course_master.status !=?", 2);
           $result = $this->getAdapter()
                      ->fetchAll($select);
           
           
           $data = array();
          foreach ($result as $val) {
            $data[$val['course_id']] = $val['course_name'];
        }
        return $data;
    }
    
     public function getAlumniRecords($f_date,$to_date){
        
            $select = $this->_db->select()
                      ->from($this->_name)
                       ->where ("$this->_name.create_date between '$f_date' and '$to_date'");
           $result = $this->getAdapter()
                      ->fetchAll($select);
             // echo $select;die();
         return $result;
    }
    //end
}