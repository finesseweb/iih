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
		
		//echo $select; die();
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
	
	public function getFullTrans($stid,$term_id) {
		
		
		$select = $this->_db->select();
		$select->from('t_history');
		$select->joinleft(array("fee_collector"), "fee_collector.id=t_history.collect_id",array("sem_year"));
		//$select->joinleft(array("erp_student_information"), "erp_student_information.student_id=t_history.s_id");
	    $select->joinleft(array("term_master"), "term_master.term_id=fee_collector.sem_year",array("term_name"));
		$select->where("s_id=?", $stid);
		$select->where("fee_collector.sem_year=?", $term_id);
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
	public function getFullTrans1($stid,$term_id) {
		
		
		$select = $this->_db->select();
		$select->from('t_history');
		$select->joinleft(array("fee_collector"), "fee_collector.id=t_history.collect_id",array("sem_year"));
		$select->joinleft(array("dues_date"), "dues_date.history_id=t_history.id",array("dues_date"));
	    $select->joinleft(array("term_master"), "term_master.term_id=fee_collector.sem_year",array("term_name"));
		$select->where("s_id=?", $stid);
		$select->where("fee_collector.sem_year=?", $term_id);
		
		//echo $select; die();
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}	
	
	public function getUserTrans($empl_id,$f_date='',$to_date='') {
		
		
		$select = $this->_db->select();
		$select->from('t_history',array("SUM(paid) as Totalpaid"));
		$select->joinleft(array("fee_collector"), "fee_collector.id=t_history.collect_id",array("sem_year","academic_year_id"));
		$select->joinleft(array("academic_master"), "academic_master.academic_year_id=fee_collector.academic_year_id");
		$select->joinleft(array("term_master"), "term_master.term_id=fee_collector.sem_year",array("term_name"));
		
		if($f_date && $to_date){
			$select->where("paid_date >= ?",  $f_date);
            $select->where("paid_date <= ?",  $to_date);
		}
		
		if($f_date){ 
		
		$select->where("paid_date = ?",  $f_date);
		}
		
		
		$select->where("admin_id=?", $empl_id);
		$select->group('fee_collector.academic_year_id');
		
		//$select->where("fee_collector.sem_year=?", $term_id);
		
		//echo $select; die();
		$result = $this->getAdapter()->fetchAll($select);
        return $result;	
	}
	
	
	public function getDropDownList() {
		
		
		
	$select=	"SELECT nep_erp.fa_kv_empl_info.empl_id,nep_erp.fa_kv_empl_info.empl_firstname,nep_erp.fa_kv_empl_info.empl_lastname FROM nep.t_history INNER JOIN nep_erp.fa_kv_empl_info ON nep.t_history.admin_id = nep_erp.fa_kv_empl_info.empl_id group by nep.t_history.admin_id";

        //$select = $this->_db->select()
        //    ->from($this->_name)
       //     ->group("$this->_name.admin_id");
        $result = $this->getAdapter()
            ->fetchAll($select);
       // print_r( $result);
       // die();
        $data = array();

        foreach ($result as $k => $val) {

            $data[$val['empl_id']] = $val['empl_firstname'].$val['empl_lastname'];
        }

        return $data;
    }
	
	
	
}