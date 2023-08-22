<?php

/**

 * @Framework Zend Framework

 * @Powered By TIS 

 * @category   ERP Product

 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.

 * (http://www.techintegrasolutions.com)

 *	Authors Kannan and Rajkumar

 */

class Application_Model_FeeWaiver extends Zend_Db_Table_Abstract

{

    public $_name = 'fee_waiver';
    protected $_id = 'id';


public function getRecord($id)
{       
    $select=$this->_db->select()
    ->from($this->_name)
    ->where("$this->_id=?",$id);
    $result=$this->getAdapter()
    ->fetchRow($select);       
    return $result;
    }

    //get details for show

public function getRecords()
        {
        $select=$this->_db->select()
        ->from($this->_name,array("group_concat(distinct type) as waivetype","$this->_name.*")) 
        ->join("erp_student_information","erp_student_information.stu_id = $this->_name.stu_id",array("erp_student_information.stu_id as uid","erp_student_information.stu_fname as Name","erp_student_information.roll_no as roll_no","erp_student_information.academic_id as academic","erp_student_information.exam_roll as examid"))
        ->join("academic_master","academic_master.academic_year_id = erp_student_information.academic_id",array("academic_master.short_code as batch","academic_master.session as session_id"))
        ->where("$this->_name.status!=2")
        ->group(array("stu_id","cmn_terms"));
        $result=$this->getAdapter()
        ->fetchAll($select);
         return $result;

    }
    
    
    public function getRecordsByAcid($year_id)
        {
        $select=$this->_db->select()
        ->from($this->_name,array("group_concat(distinct type) as waivetype","$this->_name.*")) 
        ->join("erp_student_information","erp_student_information.stu_id = $this->_name.stu_id",array("erp_student_information.stu_id as uid","erp_student_information.stu_fname as Name","erp_student_information.roll_no as roll_no","erp_student_information.academic_id as academic","erp_student_information.exam_roll as examid"))
        ->join("academic_master","academic_master.academic_year_id = erp_student_information.academic_id",array("academic_master.short_code as batch","academic_master.session as session_id"))
        ->where("$this->_name.status!=2")
        ->where("erp_student_information.academic_id=?",$year_id)
        ->group(array("stu_id","cmn_terms"));
        $result=$this->getAdapter()
        ->fetchAll($select);
         return $result;

    }
    
    
	public function trashItems($id) {



        $this->_db->delete($this->_name, "id=$id");



    }


}