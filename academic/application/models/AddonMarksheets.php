<?php

/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */
class Application_Model_AddonMarksheets extends Zend_Db_Table_Abstract {

    public $_name = 'addon_marks_sheets';
    protected $_id = 'id';

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
    
        


    public function getRecordAcademicYear($session,$course) {
        $select = $this->_db->select()
            ->from($this->_name,array('slno', 'name', 'form_id', 'registration_no', 'examination_roll_no', 'session', 'department_of_student', 'conducted_by_department', 'course_name', 'paper_i', 'paper_name_i', 'paper_code_i', 'credits_i', 'full_marks_i', 'obtained_marks_i', 'paper_ii', 'paper_name_ii', 'paper_code_ii', 'credits_ii', 'full_marks_ii', 'obtained_marks_ii', 'paper_iii', 'paper_name_iii', 'paper_code_iii', 'credits_iii', 'full_marks_iii', 'obtained_marks_iii', 'paper_iv', 'paper_name_iv', 'paper_code_iv', 'credits_iv', 'full_marks_iv', 'obtained_marks_iv', 'total_credits', 'grade', 'gr_total', 'obtained_gr_total', 'date_of_result', 'gradesheet_refrence'))
            ->where("$this->_name.course_name like (?)", "%".$course."%")	
             ->where("$this->_name.session like (?)", $session)	;
           //  echo"<pre>". $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        
        return $result;
    }
    
    public function getRecordAcademicYearAll($session,$course) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.course_name like (?)", "%".$course."%")	
             ->where("$this->_name.session like (?)", $session)	;
           //  echo"<pre>". $select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        
        return $result;
    }
    
        public function getRefrencegradeAddons($flag="Default") {
        $select = $this->_db->select()
            ->from(array("refgrade"=>"addons_ref_grade_manual"),array('Level of Performance', 'Grade', '`Grading Scale (%)`'))
            ->where("refgrade.flag like (?)", "%".$flag."%");
        $result = $this->getAdapter()
            ->fetchAll($select);
        
        return $result;
    }


    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->order("$this->_name.$this->_id DESC");
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
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
            $iValues.='("'.implode('", "', $values[$i]).'")'.(($i+1)!=$vAmount ? ',' : null);

        $data="INSERT INTO `".$this->_name."` (`".$iColumns."`) VALUES ".$iValues;
       // echo "<pre>".$data; die;
     $this->getAdapter()->query($data);
     
     return 1;
    }
}
}

?>