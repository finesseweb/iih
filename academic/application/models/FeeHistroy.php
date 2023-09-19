<?php
class Application_Model_FeeHistroy extends Zend_Db_Table_Abstract {
	public $_name = 't_history';
	
	protected $_id = 'id';

	public function get_student_record($year, $session, $batch,$sem) {
		$select = $this->_db->select();
		$select->from("erp_student_information", array("erp_student_information.*", "student_id as stid"));
		$select->join(array("academic_master"), "academic_master.academic_year_id=erp_student_information.year_id");
		$select->join(array("department"), " department.id=academic_master.department");
		$select->join(array("degree_info"), " degree_info.id=department.degree_id");
		$select->joinleft(array("erp_fee_heads_master"), " erp_fee_heads_master.degree_id=degree_info.id AND erp_fee_heads_master.session_id=academic_master.session AND erp_fee_heads_master.degree_id=department.degree_id");
		$select->joinleft(array("erp_fee_structure_term_items"), " erp_fee_structure_term_items.fee_heads_id=erp_fee_heads_master.feehead_id");
		//$select->joinleft(array("fee_collector"), " fee_collector.student_id=erp_student_information.student_id");
	   /// $select->where('fee_collector.sem_year=?', $sem);
		$select->where('erp_student_information.year_id=?', $year);
		$select->where('academic_master.session=?', $session);
		$select->where('erp_student_information.academic_id=?', $batch);
		$select->group('erp_student_information.student_id');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}

	public function getSessionOnYear ($academic_year_id) {
		$select = $this->_db->select();
		$select->from('session_info');
		$select->where("acad_year_id=?", $academic_year_id);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;
	}

	public function getAdacemicIdOnSession ($session) {
		$select = $this->_db->select();
		$select->from('academic_master');
		$select->where("session=?", $session);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;
	}

	public function getStudents ($degree, $year, $session, $batch) {
		$select = $this->_db->select();
		$select->from('academic_master');
		$select->where("session=?", $session);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;
	}

	public function getTotalfee($stid) {
		$select = $this->_db->select('total_due');
		$select->from('fee_collector');
		$select->where("student_id=?", $stid);
		$result = $this->getAdapter()->fetchRow($select);
        return $result;	
	}
	
	public function getRecords($id) {
		$select = $this->_db->select();
		$select->from('t_history');
		//$select->join(array("account_master"), "account_master.id=t_history.bank_id");
		$select->where("collect_id=?", $id);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
	
	public function get_student_paid($stid,$term_id) {
		$select = $this->_db->select();
		$select->from('fee_collector',array("id","SUM(total_paid) as totalpaid"));
		$select->where("student_id=?", $stid);
		$select->where("sem_year=?", $term_id);
		$result = $this->getAdapter()->fetchRow($select);
        return $result;	
	}
	
	
	
	public function getTotalpaidfeebystu($stid,$term_id,$acad) {
		
		
		$select = $this->_db->select();
		$select->from('fee_collector',array("id"));
		$select->where("student_id=?", $stid);
		$select->where("sem_year=?", $term_id);
		$select->where("academic_year_id=?", $acad);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
	
	function getNextSlipNo(){
        $select = 'SELECT max(slip_no) as nextslip  FROM `t_history`';
$result=$this->getAdapter()
            ->fetchRow($select);
            return $result;
        
    }
}