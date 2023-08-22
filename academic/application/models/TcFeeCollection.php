<?php
/* 
    Author: Raushan Kumar
    Date: 25  Oct. 2019
    Summary: This model is made for exam Form Submit Record
*/
class Application_Model_TcFeeCollection extends Zend_Db_Table_Abstract {

    public $_name = 'tc_fee_collection';
    protected $_id = 'id';

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id);
          //  echo $select; die;  
        $result = $this->getAdapter()
                ->fetchRow($select);
            
        return $result;
    }
    
    public function getStudentFeeTcRecords($academic_id, $type){
      
           $select = $this->_db->select();
               
                $select->from(array("semester_fee_collection"=>"tc_fee_collection"),array('fee_type',"sum(IF(semester_fee_collection.status = '1' ,semester_fee_collection.status, 0)) as total_installment"," SUM(IF(semester_fee_collection.status = '1' , amount, 0)) AS paid_fees") );
                
                $select->joinleft(array("erp_student_information"=>"erp_student_information"),"semester_fee_collection.stu_id=erp_student_information.stu_id",array('stu_fname','stu_id','roll_no','exam_roll','academic_id'));
               
                $select->where("erp_student_information.academic_id in (?)",$academic_id);
                 $select->where("semester_fee_collection.fee_type like (?)","%".$type."%");
                $select->group("erp_student_information.stu_id");
              //  echo '<pre>'.$select;exit;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
        
    }
    
     public function getStudentFeeTcRecordsstuid($stu_id, $type){
      
           $select = $this->_db->select();
               
                $select->from(array("semester_fee_collection"=>"tc_fee_collection") );
                
                
               
                $select->where("semester_fee_collection.stu_id in (?)",$stu_id);
                $select->where("semester_fee_collection.status in (?)",1);
                 $select->where("semester_fee_collection.fee_type like (?)","%".$type."%");
              //  echo '<pre>'.$select;exit;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
        
    }
    public function getRecordbyfid($id) {
        $select = $this->_db->select()
                ->from($this->_name)
              
                ->where("$this->_name.id=?", $id)
                ->where("$this->_name.status=?", 1)
                ->where("$this->_name.f_code !=?", 'F')
                ->where("$this->_name.mmp_txn !=?",'')
                ->where("$this->_name.mmp_txn !=?",0)
               
                ->order("$this->_name.id  DESC");
              
        $result = $this->getAdapter()
                ->fetchRow($select);
         //echo"<pre>";print_r($result);die;
        return $result;
    }
    
    
    
    public function getTRecordb($id) {
        $select = $this->_db->select()
                ->from($this->_name)
              
                ->where("$this->_name.stu_id=?", $id)
                ->where("$this->_name.mmp_txn !=?",'')
                ->where("$this->_name.mmp_txn !=?",0)
               
                ->order("$this->_name.id  DESC");
              
        $result = $this->getAdapter()
                ->fetchAll($select);
         //echo"<pre>";print_r($result);die;
        return $result;
    }
    public function getMigNo(){
        $feeType='migration';
        $select = $this->_db->select()
            
            ->from($this->_name,array('max(mig_no) as migNumber'))
            ->where("$this->_name.fee_type=?", $feeType)
            ->where("$this->_name.status=?", 1);

        $result = $this->getAdapter()
            ->fetchRow($select);
        //echo $select;die;
        return $result;
    }
    
}
