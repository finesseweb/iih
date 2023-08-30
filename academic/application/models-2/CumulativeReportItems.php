<?php

/* tabulation_report

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class Application_Model_CumulativeReportItems extends Zend_Db_Table_Abstract {

    public $_name = 'cumulative_marks';
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

    public function getRecordByStudentId($student_id,$term_ids) {
        //echo '<pre>';print_r($tabl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array("student_id as col", "count(DISTINCT tr.term_id) as max_sem","non_col_date as noncolligiate_date"));
        $select->joinLeft(array("btr" => "back_tabulation_report_items"), "btr.student_id=$this->_name.student_id", array());
        $select->joinLeft(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id", array('added_date','tabl_id'));
        $select->joinLeft(array("tr1" => "tabulation_report"), "tr1.tabl_id=btr.tabl_id and tr1.term_id in (".implode(',',$term_ids).")", array());
        $select->joinLeft(array("btr1" => "back_tabulation_report_items"), "btr1.student_id=$this->_name.student_id and btr1.tabl_id = tr1.tabl_id", array("student_id as noncol", 'tabl_id as NonTblId'));
        $select->joinLeft(array("reval" => "reval_status"), "reval.student_id=$this->_name.student_id and reval.tabl_id = tr.tabl_id", array('student_id as reval', 'tabl_id as RevalTblId','updated_date as reval_date'));
        $select->join(array("term" => "term_master"), "term.term_id=tr.term_id", array());
        //if(!empty($tabl_id))
        $select->where("tr.term_id in (?)",$term_ids);
        $select->where("$this->_name.student_id=?", $student_id);
        $select->order(array("$this->_name.id desc"));
        $result = $this->getAdapter()
            ->fetchRow($select);
        // echo $select;die;
        return $result;
    }
    public function getRecordByStudentIdCollTerm($student_id,$term_id,$regTabl,$backTabl) {
        //echo '<pre>';print_r($tabl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array("student_id as col", "count(DISTINCT tr.term_id) as max_sem"));
        $select->joinLeft(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id", array('added_date'));
        //if(!empty($tabl_id))
        $select->where("$this->_name.tabl_id=?",$regTabl);
        $select->where("$this->_name.student_id=?", $student_id);
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    public function getRecordByStudentIdForCollegiate($student_id,$tabl_id) {
        //echo '<pre>';print_r($tabl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array("student_id as col", "count(DISTINCT tr.term_id) as max_sem"));
        $select->joinLeft(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id", array('added_date'));
       
        $select->where("$this->_name.student_id=?", $student_id);
        $select->where("$this->_name.tabl_id=?", $tabl_id);
        $select->order(array("$this->_name.id desc"));
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    public function getRecordByStudentIdForNonCollegiate($student_id,$tabl_id) {
        //echo '<pre>';print_r($tabl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array("student_id as col", "count(DISTINCT tr.term_id) as max_sem"));
        $select->joinLeft(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id", array('added_date'));
        $select->joinLeft(array("btr" => "back_tabulation_report_items"), "btr.student_id=$this->_name.student_id", array("student_id as noncol", 'tabl_id as NonTblId',"publish_date"));
        $select->where("$this->_name.student_id=?", $student_id);
        $select->where("btr.tabl_id=?", $tabl_id);
        $select->order(array("$this->_name.id desc"));
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    public function getRecordByStudentIdForColNonColReval($student_id,$regularTablId,$BackTablId) {
        //echo '<pre>';print_r($tabl_id);exit;
        $inData= array();
        array_push($inData,$regularTablId,$BackTablId);
        //$inIds=$regularTablId."'".','."'".$BackTablId;
        $select = $this->_db->select()
            ->from('reval_status', array("student_id as reval","updated_date as reval_date","tabl_id"));
        $select->where("reval_status.student_id=?", $student_id);
        $select->where("reval_status.tabl_id IN (?)", $inData);
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    public function getRecordByStudentIdForNonCollegiateReval($student_id,$tabl_id) {
        //echo '<pre>';print_r($tabl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array("student_id as col", "count(DISTINCT tr.term_id) as max_sem"));
        $select->joinLeft(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id", array('added_date'));
        $select->joinLeft(array("reval" => "reval_status"), "reval.student_id=$this->_name.student_id", array('student_id as reval', 'tabl_id as RevalTblId','updated_date as reval_date'));
        $select->where("$this->_name.student_id=?", $student_id);
        $select->where("reval.tabl_id=?", $tabl_id);
        $select->order(array("$this->_name.id desc"));
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }

    public function checkSessionPassoutStudent($student_id, $maxCount) {
        //echo '<pre>';print_r($tabl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array("student_id as col"));


        $select->where("$this->_name.student_id=?", $student_id);
        $select->where("$this->_name.sgpa !=?", 0);
        $select->having("count($this->_name.student_id)=$maxCount");
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    public function checkYearPassoutStudent($student_id,$nonTbl='',$revalTbl='') {
        if(!empty($nonTbl)){
        $select = $this->_db->select()
           ->from('tabulation_report');
        
            $select->where("tabulation_report.tabl_id=?", $nonTbl);
        $result = $this->getAdapter()
            ->fetchRow($select);
        }
        
        //echo '<pre>';print_r($result);exit;
        if($result['term_id']){
            $select = $this->_db->select()
           ->from('tabulation_report');
        
            $select->where("tabulation_report.term_id=?", $result['term_id']);
            $select->where("tabulation_report.flag=?", 'R');
            $result1 = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        }
            $inData= array();
            if(!empty($result1['tabl_id']))
            array_push($inData,$result1['tabl_id']);
            if(!empty($revalTbl))
            array_push($inData,$revalTbl);    
            $select = $this->_db->select()
                ->from($this->_name, array("student_id as col"));
           
            $select->where("$this->_name.student_id=?", $student_id);
            if(!empty($result1['tabl_id']) && !empty($revalTbl)){
                $select->where("$this->_name.tabl_id IN (?)", $inData);
            }else{
                if(!empty($revalTbl))
                $select->where("$this->_name.tabl_id=?", $revalTbl);
                if(!empty($result1['tabl_id']))
                $select->where("$this->_name.tabl_id=?", $result1['tabl_id']);
            
            }
//             if(!empty($inData))
//            $select->where("$this->_name.tabl_id IN (?)", $inData);
            $select->where("$this->_name.sgpa !=?", 0);
            $result = $this->getAdapter()
                ->fetchRow($select);
            //echo $select;die;
            return $result;
        
    }
    
    
     public function getGradeFinalRecordsOn($academic_year_id, $term_id, $course_id, $student_id) {

        $select = $this->_db->select()
                ->from($this->_name)
               // ->joinLeft(array("allocation_items" => "grade_allocation_items"), "allocation_items.grade_allocation_id=$this->_name.grade_id", array("student_id", "grade_value", "component_id", "sum_with_seperator(number_value) as number_value"))
             //   ->join(array("components"=>"evaluation_components_items_master"), "components.course_id = $this->_name.course_id",array("sum_with_seperator(GROUP_CONCAT(components.weightage)) as total_weightage"))
               // ->where("$this->_name.status != 2")
                ->where("$this->_name.academic_year_id=?", $academic_year_id)
                ->where("$this->_name.term_id=?", $term_id)
             //   ->where("$this->_name.flag=?", 'R')
                ->where("$this->_name.course_id=?", $course_id)
                //->where("allocation_items.component_id=?",$component_id)
                ->where("$this->_name.stu_id=?", $student_id);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

}
