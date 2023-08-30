<?php
class Application_Model_FeeCollector extends Zend_Db_Table_Abstract {
	public $_name = 'fee_collector';
	public $student_table = 'erp_student_information';
	protected $_id = 'id';

	public function get_student_record() {
		$select = $this->_db->select();
		$select->from('erp_student_information');
		$select->join(array("academic_master"), "academic_master.academic_year_id=erp_student_information.academic_id");
		$select->join(array("department"), " department.id=academic_master.department");
		$select->join(array("degree_info"), " degree_info.id=department.degree_id");
		$select->joinleft(array("erp_fee_heads_master"), " erp_fee_heads_master.degree_id=degree_info.id AND erp_fee_heads_master.session_id=academic_master.session AND erp_fee_heads_master.degree_id=department.degree_id");
		$select->joinleft(array("erp_fee_structure_term_items"), " erp_fee_structure_term_items.fee_heads_id=erp_fee_heads_master.feehead_id");
		$select->joinleft(array("fee_collector"), " fee_collector.student_id=erp_student_information.student_id");
		echo $select; die;
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}
}