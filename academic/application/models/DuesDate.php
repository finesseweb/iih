<?php
class Application_Model_DuesDate extends Zend_Db_Table_Abstract {
	public $_name = 'dues_date';
	protected $_id = 'id';

	
	
	

	
	public function get_student_record3($year, $session, $batch,$sem) {
		
		$select="SELECT SUM(erp_fee_structure_term_items.fees) as totfeess, erp_student_information.stu_fname,erp_student_information.academic_id,
		         erp_student_information.student_id,cast_category.name as castname,cast_category.id as castid,erp_fee_structure_items.* FROM 
		        `erp_student_information`,`erp_fee_structure_master_cast`,`erp_fee_structure_term_items`,`cast_category`,`academic_master`,`erp_fee_structure_items` WHERE 
				erp_student_information.academic_id=erp_fee_structure_master_cast.academic_id  
				AND erp_student_information.cast_category=erp_fee_structure_master_cast.cast_category 
				AND erp_fee_structure_items.structure_id=erp_fee_structure_master_cast.structure_id
				AND erp_fee_structure_term_items.structure_id=erp_fee_structure_master_cast.structure_id 
				AND erp_student_information.cast_category=cast_category.id AND erp_student_information.academic_id=academic_master.academic_year_id AND  erp_fee_structure_term_items.term_id='$sem' 
				AND erp_student_information.academic_id='$batch' AND erp_student_information.year_id='$year'
				AND academic_master.session='$session' GROUP by erp_student_information.student_id ORDER by erp_student_information.stu_fname";
		/*$select = $this->_db->select();
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
		$select->where('erp_student_information.cast_category=?', $cast);
		$select->where('academic_master.session=?', $session);
		$select->where('erp_student_information.academic_id=?', $batch);
		$select->group('erp_student_information.student_id');*/
		
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
		$select = $this->_db->select('dues_date');
		$select->from('dues_date');
		$select->where("stu_id=?", $stid);
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
		$select->from('fee_collector',array("id","discount","dues_date","SUM(total_paid) as totalpaid"));
		$select->where("student_id=?", $stid);
		$select->where("sem_year=?", $term_id);
		$result = $this->getAdapter()->fetchRow($select);
        return $result;	
	}
	
	
	
	public function getTotalpaidfeebystu($stid,$term_id,$acad,$session) {
		
		
		$select = $this->_db->select();
		$select->from('dues_date');
		$select->where("stu_id=?", $stid);
		$select->where("academic_id=?", $acad);
		$select->where("session=?", $session);
		$select->where("term_id=?", $term_id);
		$result = $this->getAdapter()->fetchRow($select);
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