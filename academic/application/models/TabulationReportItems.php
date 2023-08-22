<?php

/* tabulation_report

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class Application_Model_TabulationReportItems extends Zend_Db_Table_Abstract {

    public $_name = 'tabulation_report_items';
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
        //echo '<pre>';print_r($term_ids);exit;
       // $term_ids=$term_ids['5'];
        $select = $this->_db->select()
        ->from($this->_name, array("student_id as col", "count(DISTINCT tr.term_id) as max_sem",'non_col_date as noncolligiate_updated_date'));
        $select->joinLeft(array("btr" => "back_tabulation_report_items"), "btr.student_id=$this->_name.student_id", array());
        $select->joinLeft(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id and tr.term_id in (".implode(',',$term_ids).")", array('added_date','tabl_id'));
        $select->joinLeft(array("tr1" => "tabulation_report"), "tr1.tabl_id=btr.tabl_id and tr1.term_id in (".implode(',',$term_ids).")", array());
        $select->joinLeft(array("btr1" => "back_tabulation_report_items"), "btr1.student_id=$this->_name.student_id and btr1.tabl_id = tr1.tabl_id and btr1.publish_date not like '0000-00-00' ", array("student_id as noncol","max(btr1.publish_date) as noncolligiate_date"));
        $select->joinLeft(array("reval" => "reval_status"), "reval.tabl_id=tr.tabl_id and reval.student_id = $student_id", array());
        $select->join(array("term" => "term_master"), "term.term_id=tr.term_id", array());
        //if(!empty($tabl_id))
        $select->where("$this->_name.student_id=?", $student_id);
        $select->order(array("$this->_name.id desc"));
        $backTablId=$this->_db->select()
		->from($select)
		->joinLeft(array("btr" => "back_tabulation_report_items"), "btr.student_id=t.noncol and btr.publish_date = t.noncolligiate_date" , array('btr.tabl_id as NonTblId'))
		->joinLeft(array("reval" => "reval_status"), "reval.student_id=t.col and (reval.tabl_id = t.tabl_id or reval.tabl_id = btr.tabl_id)", array('student_id as reval', 'tabl_id as RevalTblId','updated_date as reval_date'));
	//	->joinLeft(array("back_students" => "back_selection_items"), "back_students.students_id = btr.student_id  and back_students.publish_date = btr.publish_date", array('exam_month as exam_month_noncol'));
//	echo "<pre>".$backTablId; die;
        $result = $this->getAdapter()
            ->fetchRow($backTablId);
      //  echo "<pre>".$backTablId;die;
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
 public function checkFailCourseIDStu($student_id,$term_id) {
        //echo '<pre>';print_r($term_id);exit;
        $select = $this->_db->select()
            ->from($this->_name);
        $select->join(array("tr" => "tabulation_report"), "tr.tabl_id=$this->_name.tabl_id");   
        $select->where("$this->_name.student_id=?", $student_id);
        $select->where("$this->_name.sgpa =?", 0);
         $select->where("tr.term_id IN (?)" ,$term_id);
        $select->order(array("$this->_name.id asc"));
        $result = $this->getAdapter()
            ->fetchAll($select);
     //   echo $select;die;
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
            $iValues.="('".implode("', '", $values[$i])."')".(($i+1)!=$vAmount ? ',' : null);

        $data="INSERT INTO `".$this->_name."` (`".$iColumns."`) VALUES ".$iValues;
        $this->getAdapter()->query($data);
    }
}
}
