<?php
class Application_Model_FeeCollector extends Zend_Db_Table_Abstract {
	public $_name = 'fee_collector';
	public $student_table = 'erp_student_information';
	protected $_id = 'id';

	public function get_student_record($year, $session, $batch,$sem) {
		$select = $this->_db->select();
		$select->from("erp_student_information", array("erp_student_information.*", "student_id as stid"));
		$select->join(array("academic_master"), "academic_master.academic_year=erp_student_information.year_id");
		$select->join(array("department"), " department.id=academic_master.department");
		$select->join(array("degree_info"), " degree_info.id=department.degree_id");
		$select->joinleft(array("erp_fee_heads_master"), " erp_fee_heads_master.degree_id=degree_info.id AND erp_fee_heads_master.session_id=academic_master.session AND erp_fee_heads_master.degree_id=department.degree_id");
		$select->joinleft(array("erp_fee_structure_term_items"), " erp_fee_structure_term_items.fee_heads_id=erp_fee_heads_master.feehead_id");
		
		
	   /// $select->where('fee_collector.sem_year=?', $sem);
		$select->where('erp_student_information.year_id=?', $year);
		$select->where('academic_master.session=?', $session);
		$select->where('erp_student_information.academic_id=?', $batch);
		$select->group('erp_student_information.student_id');
		
		//echo $select; die();
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}
	
	public function get_student_record1($year, $session, $batch,$sem,$yearcm='') {
		$select = $this->_db->select();
		$select->from("erp_student_information", array("erp_student_information.*", "student_id as stid"));
		$select->join(array("academic_master"), "academic_master.academic_year=erp_student_information.year_id");
		$select->join(array("department"), " department.id=academic_master.department");
		$select->join(array("degree_info"), " degree_info.id=department.degree_id");
		$select->joinleft(array("erp_fee_heads_master"), " erp_fee_heads_master.degree_id=degree_info.id AND erp_fee_heads_master.session_id=academic_master.session AND erp_fee_heads_master.degree_id=department.degree_id");
		$select->joinleft(array("erp_fee_structure_term_items"), " erp_fee_structure_term_items.fee_heads_id=erp_fee_heads_master.feehead_id");
		if($yearcm!='f1') {
		$select->joinleft(array("promoted_master_item"), " promoted_master_item.stu_id=erp_student_information.student_id");
		$select->joinleft(array("promoted_master"), " promoted_master.promo_id=promoted_master_item.promoted_id");
		}
		if($yearcm!='f1') { 
		 $select->where('promoted_master_item.promoted_value=?', 0);
		 $select->where('promoted_master.next_term=?', $sem);
		 $select->where('promoted_master.academic_id=?', $batch);
		 $select->where('promoted_master.session=?', $session);
		 $select->where('promoted_master.academic_year=?', $year);
		}
	   /// $select->where('fee_collector.sem_year=?', $sem);
		$select->where('erp_student_information.year_id=?', $year);
		$select->where('academic_master.session=?', $session);
		$select->where('erp_student_information.academic_id=?', $batch);
		$select->group('erp_student_information.student_id');
		
		//echo $select; die();
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
	
	public function getRecord($id) {
		$select = $this->_db->select();
		$select->from('fee_collector');
		$select->where("id=?", $id);
		$result = $this->getAdapter()->fetchRow($select);
        return $result;	
	}
	
	public function get_student_paid($stid,$term_id) {
		$select = $this->_db->select();
		$select->from('fee_collector',array("id","discount","SUM(total_paid) as totalpaid"));
		$select->where("student_id=?", $stid);
		$select->where("sem_year=?", $term_id);
		$result = $this->getAdapter()->fetchRow($select);
        return $result;	
	}
	
	
	
	public function getTotalpaidfeebystu($stid,$term_id,$acad) {
		
		
		$select = $this->_db->select();
		$select->from('fee_collector',array("id","discount"));
		$select->where("student_id=?", $stid);
		$select->where("sem_year=?", $term_id);
		$select->where("academic_year_id=?", $acad);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
	
	public function GetTransactionDetails($s_id,$collect,$hid) {
		
		
		$select = $this->_db->select();
		$select->from('fee_collector');
	    $select->joinleft(array("t_history"), " t_history.collect_id=fee_collector.id");
		$select->joinleft(array("term_master"), "term_master.term_id=fee_collector.sem_year");
		//$select->joinleft(array("account_master"), "account_master.id=t_history.bank_id");
        $select->joinleft(array("erp_student_information"), "erp_student_information.student_id=t_history.s_id");
        $select->where("erp_student_information.student_id=?", $s_id);
		$select->where("t_history.collect_id=?", $collect);
		$select->where("t_history.id=?", $hid);
		
		$result = $this->getAdapter()->fetchRow($select);

        return $result;	
	}
}