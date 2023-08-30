<?php

class Application_Model_ExamDateModel extends Zend_Db_Table_Abstract {

    public $_name = 'examination_dates';
    protected $_id = 'id';

    public function getRecords() {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("session" => "session_info"), "session.id=$this->_name.session", array("session"))
            ->joinleft(array("term" => "declared_terms"), "term.term_des=$this->_name.cmn_terms", array("term_name"))
            ->joinleft(array("batch" => "academic_master"), "batch.academic_year_id=$this->_name.academic_id", array("short_code"))
            ->where("$this->_name.status !=?", 2)
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }
    public function getFilterRecords($year_id,$session,$sem,$type){
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("session" => "session_info"), "session.id=$this->_name.session", array("session"))
            ->joinleft(array("term" => "declared_terms"), "term.term_des=$this->_name.cmn_terms", array("term_name"))
            ->joinleft(array("batch" => "academic_master"), "batch.academic_year_id=$this->_name.academic_id", array("short_code"))
            ->where("$this->_name.academic_year =?", $year_id)
            ->where("$this->_name.session in (?)", $session)
            ->where("$this->_name.cmn_terms =?", $sem)
            ->where("$this->_name.exam_type =?", $type)
            ->order('examination_dates.id desc');
//echo "<pre>".$select;die;
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }
    public function getRecord($id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.$this->_id=?", $id);
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }

   public function getRecordByAcadId($data) {
        $select = $this->_db->select()
            ->from($this->_name);
        $select->where("$this->_name.academic_id=?", $data['acad_id']);
        $select->where("$this->_name.session=?", $data['session']);
        $select->where("$this->_name.cmn_terms=?", $data['term']);
        $select->where("$this->_name.exam_type=?", $data['exam_type']);
        $select->where("$this->_name.mark_sheet_status=?",1);
     //   echo "<pre>".$select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
     public function getRecordByAcadIdstu($data) {
        $select = $this->_db->select()
            ->from($this->_name);
        $select->where("$this->_name.academic_id=?", $data['acad_id']);
        $select->where("$this->_name.session=?", $data['session']);
        $select->where("$this->_name.cmn_terms=?", $data['term']);
        $select->where("$this->_name.exam_type=?", $data['exam_type']);
        $select->where("$this->_name.stu_mark_sheet_status=?",1);
        //echo "<pre>".$select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
     public function getRecordByAcadIddup($data) {
        //print_r($data); die();
        
        $select = $this->_db->select()
            ->from($this->_name);
        $select->where("$this->_name.academic_id=?", $data['acad_id']);
        $select->where("$this->_name.session=?", $data['session']);
        $select->where("$this->_name.cmn_terms=?", $data['cmn_terms']);
        $select->where("$this->_name.exam_type=?", $data['exam_type']);
        $select->where("$this->_name.exam_date=?", $data['exm_date']);
        $select->where("$this->_name.mark_sheet_status=?",1);
        $result = $this->getAdapter()
            ->fetchRow($select);
        
        return $result;
    }

    public function getRecordByTerm($term,$id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.exam_type=?", 1)
            ->where("$this->_name.admit_card_status=?", 1)
            ->where("$this->_name.cmn_terms=?", $term)
            ->where("$this->_name.id=?", $id);
          //  echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    
        public function getRecordBForColor($term,$id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.exam_type=?", 1)
            ->where("$this->_name.cmn_terms=?", $term)
            ->where("$this->_name.academic_id=?", $id);
          //  echo $select;die;
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }
    
    public function getNonRecordByTerm($id) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.exam_type=?", 2)
            ->where("$this->_name.admit_card_status=?", 1)
            ->where("$this->_name.id=?", $id);
        $result = $this->getAdapter()
            ->fetchRow($select);

        return $result;
    }

    public function getExamDate($data) {
        $splitDate= explode('/',$data['exam_date']);
        $reqDate= $splitDate[2].'-'.$splitDate[1];
        //echo '<pre>';print_r($data);exit;
        
        $select = $this->_db->select()
            ->from($this->_name)
            //->where("$this->_name.academic_id=?", $data['academic_id'])
            ->where("$this->_name.exam_type=?", $data['exam_type'])
            ->where("$this->_name.cmn_terms=?", $data['cmn_terms'])
            ->where("DATE_FORMAT($this->_name.exam_date,'%Y-%m') = ?",$reqDate);
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getRecordByType($type,$session='',$cmn_terms='') {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("batch" => "academic_master"), "batch.academic_year_id=$this->_name.academic_id", array("academic_year_id", "short_code"))
            ->where("$this->_name.exam_type =?", $type)
            ->where("$this->_name.session =?", $session)
            ->where("$this->_name.cmn_terms =?", $cmn_terms)
            ->where("$this->_name.mark_sheet_status =?", 1)
            ->group('examination_dates.academic_id')
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }
    public function getRecordByTypeForStudent($type,$session='',$cmn_terms='') {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("batch" => "academic_master"), "batch.academic_year_id=$this->_name.academic_id", array("academic_year_id", "short_code"))
            ->where("$this->_name.exam_type =?", $type)
            ->where("$this->_name.session =?", $session)
            ->where("$this->_name.cmn_terms =?", $cmn_terms)
            ->where("$this->_name.mark_sheet_status =?", 1)
            ->where("$this->_name.stu_mark_sheet_status =?", 1)
            ->group('examination_dates.academic_id')
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getRecordByBatch($batch_id, $type) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "declared_terms"), "term.term_des=$this->_name.cmn_terms", array("term_name"))
            ->where("$this->_name.academic_id =?", $batch_id)
            ->where("$this->_name.exam_type =?", $type)
            ->where("$this->_name.mark_sheet_status =?", 1)
            ->group('examination_dates.cmn_terms')
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getRecordByBatchAndTerm($batch_id, $term) {
        $select = $this->_db->select()
            ->from($this->_name, array('id','exam_date as examination_month',"result_publish_date"))
            ->where("$this->_name.academic_id =?", $batch_id)
            ->where("$this->_name.cmn_terms =?", $term)
            ->where("$this->_name.exam_type =?", 1);

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
 public function getRecordByBatchAndTerm2($batch_id, $term) {
        $select = $this->_db->select()
            ->from($this->_name, array('id','exam_date as examination_month',"result_publish_date"))
            ->where("$this->_name.academic_id =?", $batch_id)
            ->where("$this->_name.cmn_terms =?", $term)
             ->where("$this->_name.mark_sheet_status =?", 1)
                 ->where("$this->_name.status =?", 1)
            ->where("$this->_name.exam_type =?", 2);

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    public function getSemcolRecord() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.cmn_terms=$this->_name.cmn_terms", array("term_description"))
            ->where("$this->_name.status =?", 1)
            ->where("$this->_name.exam_type =?", 1)
            ->where("$this->_name.admit_card_status =?", 1)
            ->group("$this->_name.cmn_terms");
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }

    public function getSemnonclRecord() {
        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term" => "term_master"), "term.cmn_terms=$this->_name.cmn_terms", array("term_description"))
            ->where("$this->_name.status =?", 1)
            ->where("$this->_name.exam_type =?", 2)
           ->where("$this->_name.admit_card_status =?", 1)
            ->group("$this->_name.cmn_terms");
        $result = $this->getAdapter()
            ->fetchAll($select);
        return $result;
    }
 
    public function getRevalDates($termId,$followupDate,$flag='') {
        
        $inData= array();
        array_push($inData,"1","2");
        
        $splitDate= explode('-',$followupDate);
        $reqDate= $splitDate[0].'-'.$splitDate[1];
        //echo '<pre>';print_r($reqDate);exit;
        $select = $this->_db->select()
           ->from('term_master');
        
            $select->where("term_master.term_id=?", $termId);
        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        if($result['cmn_terms']) {   
            //echo '<pre>';print_r($reqData);exit;
        $select = $this->_db->select()
           ->from($this->_name);
        
            $select->where("$this->_name.academic_id=?", $result['academic_year_id']);
            if($flag == 'NC'){
            $select->where("$this->_name.exam_type=?", 2);
            }else{
                $select->where("$this->_name.exam_type IN (?)", $inData);
            }
            $select->where("$this->_name.cmn_terms=?", $result['cmn_terms']);
            $select->where("DATE_FORMAT($this->_name.result_publish_date,'%Y-%m') = ?",$reqDate);
            $select->orwhere("DATE_FORMAT($this->_name.reval_date,'%Y-%m') = ?",$reqDate);
        $result1 = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result1;
        }
    }
    
    public function getDateByAcadId($acadId,$term_id,$type=2){
        $select = $this->_db->select()
           ->from($this->_name,array("result_publish_date","id"));
           $select->join(array("term" => "term_master"), "term.cmn_terms=$this->_name.cmn_terms", array("term_description"));
            $select->where("$this->_name.academic_id=?", $acadId);
            $select->where("$this->_name.exam_type = ?", $type);
            $select->where("$this->_name.result_publish_date != ?", "0000-00-00");
            $select->where("term.term_id =?", $term_id);
            //echo $select;die;
        $result1 = $this->getAdapter()
        
            ->fetchAll($select);
        return $result1;
    
        
    }
    public function getDateInfoByAcadId($acadId,$cmn_terms,$type=''){
        $select = $this->_db->select()
           ->from($this->_name,array("exam_date","id","result_publish_date"));
            $select->where("$this->_name.academic_id in (?)", $acadId);
            if(!empty($type)){
            $select->where("$this->_name.exam_type = ?", $type);
            } else {
               $select->where("$this->_name.exam_type = ?", 2); 
            }
            
            $select->where("$this->_name.cmn_terms =?", $cmn_terms);  
        $result1 = $this->getAdapter()
        
            ->fetchAll($select);
        
        return $result1;
    
        
    }
    
    
    public function getRevalDatesByAcadId($acadId,$followupDate,$term_id) {
        
        $inData= array();
        array_push($inData,"1","2");
        
        $splitDate= explode('-',$followupDate);
        $reqDate= $splitDate[0].'-'.$splitDate[1];
        //echo '<pre>';print_r($followupDate);exit;
        $select = $this->_db->select()
           ->from($this->_name);
           $select->join(array("term" => "term_master"), "term.cmn_terms=$this->_name.cmn_terms", array("term_description"));
            $select->where("$this->_name.academic_id=?", $acadId);
            $select->where("$this->_name.exam_type IN (?)", $inData);
            $select->where("term.term_id =?", $term_id);
            $select->where("(DATE_FORMAT($this->_name.reval_date,'%Y-%m') = ?",$reqDate);
            $select->orwhere("DATE_FORMAT($this->_name.result_publish_date,'%Y-%m') = ?)",$reqDate);
           // echo $select; die();
        $result = $this->getAdapter()
            ->fetchRow($select);
        return $result;
        
    }
        
        public function getDateInfoByAdmitCardStatus($acadId,$cmn_terms,$type=''){
        $select = $this->_db->select()
           ->from($this->_name,array("exam_date","id"));
            $select->where("$this->_name.academic_id=?", $acadId);
            if(!empty($type)){
            $select->where("$this->_name.exam_type = ?", $type);
            } else {
               $select->where("$this->_name.exam_type = ?", 2);
               $select->where("$this->_name.admit_card_status =?", 1);
            }
            
            $select->where("$this->_name.cmn_terms =?", $cmn_terms);
            
            
        $result1 = $this->getAdapter()
        
            ->fetchRow($select);
      //  echo $select;die;
        return $result1;
    
        
    }
    
    public function getNoncollExamSch($acad,$sem) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("session" => "session_info"), "session.id=$this->_name.session", array("session"))
            ->joinleft(array("term" => "declared_terms"), "term.term_des=$this->_name.cmn_terms", array("term_name"))
            ->joinleft(array("batch" => "academic_master"), "batch.academic_year_id=$this->_name.academic_id", array("short_code"))
            ->where("$this->_name.status =?", 1)
            ->where("$this->_name.admit_card_status =?", 1)
            ->where("$this->_name.exam_type =?", 2)
            ->where("$this->_name.academic_id =?", $acad)
            ->where("$this->_name.cmn_terms =?", $sem)
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchRow($select);
       // echo "<pre>".$select;die;
        return $result;
    }
    
    public function getcollExamSch($acad,$sem) {

        $select = $this->_db->select()
            ->from($this->_name)
            ->joinleft(array("session" => "session_info"), "session.id=$this->_name.session", array("session"))
            ->joinleft(array("term" => "declared_terms"), "term.term_des=$this->_name.cmn_terms", array("term_name"))
            ->joinleft(array("batch" => "academic_master"), "batch.academic_year_id=$this->_name.academic_id", array("short_code"))
            ->where("$this->_name.status =?", 1)
            ->where("$this->_name.admit_card_status =?", 1)
            ->where("$this->_name.academic_id =?", $acad)
            ->where("$this->_name.cmn_terms =?", $sem)
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchRow($select);
     //   echo $select;die;
        return $result;
    }
    
    
     public function getRecordBySessionType($session='',$cmn_terms='',$batch_id=NULL,$type = 2) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.exam_type =?", $type)
            ->where("$this->_name.session =?", $session)
            ->where("$this->_name.cmn_terms =?", $cmn_terms)
            ->where("$this->_name.academic_id =?", $batch_id)    
            ->where("$this->_name.status =?", 1)
            ->where("$this->_name.mark_sheet_status =?", 1)
            ->group('examination_dates.exam_date')
            ->order('examination_dates.id desc');

        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

}
