<?php
class Application_Model_FeeCollectorItems extends Zend_Db_Table_Abstract {
	public $_name = 'fee_collector_item';
	
	protected $_id = 'id';

	public function get_student_record($hid) {
		$select = $this->_db->select();
		$select->from("fee_collector_item");
		$select->joinleft(array("erp_fee_heads_master"), " erp_fee_heads_master.feehead_id=fee_collector_item.head_id ");
		$select->joinleft(array("t_history"), " t_history.id=fee_collector_item.t_history_id");
		$select->where('fee_collector_item.t_history_id=?', $hid);
		$select->where('t_history.id=?', $hid);
		//echo $select ; die();
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}
	
	
	public function get_student_record1($year, $session, $batch) {
		$select = $this->_db->select();
		$select->from("erp_student_information", array("erp_student_information.*", "student_id as stid"));
		$select->join(array("academic_master"), "academic_master.academic_year_id=erp_student_information.year_id");
		$select->join(array("department"), " department.id=academic_master.department");
		$select->join(array("degree_info"), " degree_info.id=department.degree_id");
		$select->joinleft(array("erp_fee_heads_master"), " erp_fee_heads_master.degree_id=degree_info.id AND erp_fee_heads_master.session_id=academic_master.session AND erp_fee_heads_master.degree_id=department.degree_id");
		$select->joinleft(array("erp_fee_structure_term_items"), " erp_fee_structure_term_items.fee_heads_id=erp_fee_heads_master.feehead_id");
		$select->joinleft(array("fee_collector"), " fee_collector.student_id=erp_student_information.student_id");
		// $select->where('department.degree_id=?', $degree);
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
		$select = $this->_db->select();
		$select->from('fee_collector_item' ,array("fee_collector_item.*","SUM(paid_amt) as paidamt","SUM(dues_amt) as duesamt"));
		$select->where("collector_id IN(?)", $stid);
		$select->group("head_id");
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
	
	public function getTotalfee1($stid) {
		$select = $this->_db->select();
		$select->from('fee_collector_item');
		$select->where("collector_id IN(?)", $stid);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
}