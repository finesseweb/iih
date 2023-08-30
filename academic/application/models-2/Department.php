<?php

class Application_Model_Department extends Zend_Db_Table_Abstract {

    public $_name = 'department';
    protected $_id = 'id';

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id =?", $id);
               // ->where("status=?",0);
        $result = $this->getAdapter()
                ->fetchRow($select);
        //$result['batch_id'] = $this->academic($id);
        return $result;
    }
    
    public function getRecordbyAcademic($id) {
        $select = $this->_db->select()
                ->from($this->_name,array("id as department_id","department as dpt_name"))
                ->joinLeft(array('acad'=>'academic_master'),"acad.department = $this->_name.id")
                
                ->where("acad.academic_year_id =?", $id);
               
                // ->where("status=?",0);r
        $result = $this->getAdapter()
                ->fetchRow($select);
        //$result['batch_id'] = $this->academic($id);
       // echo '<pre>'; print_r($result); exit;
        return $result;
    }
    
    public function academic($id){
            
     $select = $this->_db->select()
                ->from('academic_master')
                ->where("department like ?", "%$id%")
               ->where("status=?",0);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    public function getDepartment($department)
    {
       
          $select = $this->_db->select()
                ->from($this->_name)
                ->where('department = ?',$department);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    public function getDepartment1($department,$degree_id,$department_type)
    {
       
          $select = $this->_db->select()
                ->from($this->_name)
                ->where('department like ?',trim($department))
                ->where('degree_id like ?',trim($degree_id))
                ->where('department_type like ?',trim($department_type));
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    
      public function getByDepartmentType($department)
    {
       
          $select = $this->_db->select()
                ->from($this->_name, array("group_concat(id) as did"))
                ->where('department_type = ?',$department)
                ->group("department_type");
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    public function getRecordByDegreeId($degree)
    {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('degree_id = ?',$degree)
             ->order('department  ASC');;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
     public function getRecordByEmplId($empl_id)
    {
         //echo '<pre>'; print_r($empl_id);exit;
         
        $select = $this->_db->select()
                ->from($this->_name,array('id','department'))
                ->join(array("empl_dept"),"empl_dept.dept_id=$this->_name.id",array('dept_id'))
                ->where('empl_dept.empl_id = ?',$empl_id);
                //->where('degree_id = ?',$degree);
        $result = $this->getAdapter()
            
                ->fetchAll($select);
        //echo $select;die;
        //echo '<pre>'; print_r($result);exit;
        if($result){
                $select = $this->_db->select()
                ->from("academic_master",array("academic_year_id","short_code"))
                ->where("academic_master.department in (?)",$result['dept_id']);

                $result1 = $this->getAdapter()->fetchRow($select);
               
            } 
            $result['academic_year_id'] = $result1['academic_year_id'];
            $result['short_code'] = $result1['short_code'];
            
            echo '<pre>'; print_r($result);exit;
            // echo $select;die;
        return $result;
    }
     public function getRecordByDegreeIdEmpl($degree,$empl_id)
    {
       
          $select = $this->_db->select()
                ->from($this->_name,array('id','department'))
                ->join(array("empl_dept"),"empl_dept.dept_id=$this->_name.id",array('dept_id'))
                ->where('empl_dept.empl_id = ?',$empl_id)
                ->where('degree_id = ?',$degree);
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getRecords() {

        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("department_type"),"department_type.id=$this->_name.department_type",array("department_type.department_type"));
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    public function getRecordByStream($stream) {

        $select = $this->_db->select()
                ->from($this->_name)
                ->joinLeft(array("department_type"),"department_type.id=$this->_name.department_type",array("department_type.department_type"))
            ->where("$this->_name.department_type=?",$stream);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
        public function getActiveRecords() {

        $select = $this->_db->select()
                ->from($this->_name)
                ->where('status=?',0);
            
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    
    	public function getDropDownList(){
            
             
        $select = $this->_db->select()
		->from($this->_name, array('id','department'));	
                 $select->joinLeft(array("department_type"),"department_type.id=$this->_name.department_type",array("department_type.department_type"));
				$select->where("$this->_name.status =?",0);
				 $select->where("department_type.status=?",0);
                $select->order("$this->_name.department  ASC");
        $result = $this->getAdapter()->fetchAll($select);
       
        $data = array();
		$st_year ='';
		$end_year='';
        foreach ($result as $val) {
			
			$data[$val['id']] = $val['department'];
			
           // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
			//echo "<pre>";print_r($data);
        }
        return $data;
    }
    
    	public function getDropDownListForRoutine(){
            if ($_SESSION['admin_login']['admin_login']->empl_id)
            $empl_id = $_SESSION['admin_login']['admin_login']->empl_id;
             
        $select = $this->_db->select()
		->from($this->_name, array('id','department',));	
                if ($empl_id !== 'superAdmin'   && !empty($empl_id)) {
                $select->join(array("empl_dept"),"empl_dept.dept_id=$this->_name.id",array('dept_id'));
                $select->where('empl_dept.empl_id = ?',$empl_id);
                }else if($empl_id === 'superAdmin' ){
                    
                }
                else{
                    $acadInfo= new Application_Model_Academic();
                    $dept= $acadInfo->getDepartment( $_SESSION['admin_login']['admin_login']->participant_academic);
                    //echo '<pre>'; print_r($dept);exit;
                    $select->where("$this->_name.id =?",$dept['department']);
                }
				$select->where("$this->_name.status =?",0);
                $select->order("$this->_name.department  ASC");
        $result = $this->getAdapter()->fetchAll($select);
        //echo $select;die;
        $data = array();
		$st_year ='';
		$end_year='';
        foreach ($result as $val) {
			
			$data[$val['id']] = $val['department'];
			
           // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
			//echo "<pre>";print_r($data);
        }
        return $data;
    }
    
    public function getFeesActiveDropDownList(){
        $select = $this->_db->select();
	$select->from($this->_name, array('id','department',));	
        $select->join(array("tuition_fees"),"tuition_fees.department=$this->_name.id",array());
	$select->where("tuition_fees.status =?",0);
//        if($degree){
//                   $select->where("$this->_name.degree_id =?",$degree) ;  
//                }
        $select ->order('department  ASC');
         
        $result = $this->getAdapter()->fetchAll($select);
        $select ->group($this->_name.id);
        //echo $select;die;
        $data = array();
		$st_year ='';
		$end_year='';
        foreach ($result as $val) {
			
			$data[$val['id']] = $val['department'];
			
           // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
			//echo "<pre>";print_r($data);
        }
        return $data;
    }
    public function getFeesActiveDegreeId($degree)
    {
        $select = $this->_db->select()
                ->from($this->_name,array('id','department'))
               ->join(array("tuition_fees"),"tuition_fees.department=$this->_name.id",array())
                ->where("$this->_name.degree_id = ?",$degree)
                ->where("tuition_fees.status =?",0)
                ->group("$this->_name.id")
                ->order("$this->_name.department ASC");
              //  echo $select; die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    public function getFeeDropDownList(){
        $select = $this->_db->select();
		$select->from($this->_name, array('id','department',));	
		 $select->joinLeft(array("erp_fee_structure_master"),"erp_fee_structure_master.department=$this->_name.id",array());
	
		$select->where("erp_fee_structure_master.structure_id is Null");
				$select->where("$this->_name.status =?",0);
                $select->order('erp_fee_structure_master.department  ASC');
            // echo $select; die;
        $result = $this->getAdapter()->fetchAll($select);
        //echo $select;die;
        $data = array();
		$st_year ='';
		$end_year='';
        foreach ($result as $val) {
			
			$data[$val['id']] = $val['department'];
			
           // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
			//echo "<pre>";print_r($data);
        }
        return $data;
    }
    
    	public function getDepartmentType(){
        $select = $this->_db->select()
		->from('department_type')			
				->where("status !=?",2)
                ->order('department_type  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        //echo $select;die;
        $data = array();
        foreach ($result as $val) {
			
			$data[$val['id']] = $val['department_type'];
        }
        return $data;
    }
     //Added by Kedar 27 Dec 2019
    public function getCoreCourseByCourseId($c_id,$session_id='',$cmn_terms='',$deg=''){
        $select = $this->_db->select()
        ->from($this->_name, array('id','department'));
        $select->joinleft(array("academic_master"),"academic_master.department=$this->_name.id",array("academic_year_id","short_code","session"));
        $select->joinleft(array("term_master"),"term_master.academic_year_id=academic_master.academic_year_id",array("term_id","cmn_terms"));
        $select->join(array("department_type"),"department_type.id=$this->_name.department_type",array("department_type"));
            if(!empty($session_id))
        $select->where("academic_master.session =?",$session_id);
            if(!empty($cmn_terms))
        $select->where("term_master.cmn_terms =?",$cmn_terms);
            if(!empty($deg))
        $select->where("$this->_name.degree_id =?",$deg);
        $select->where("$this->_name.status!=?",2);
        if(!empty($c_id))
       $select->where("$this->_name.department_type in (?)",$c_id);
       $select->group('academic_master.academic_year_id');
      //  echo  "<pre>".$select; die;
        $result = $this->getAdapter()->fetchAll($select);
        
       
        //echo '<pre>';print_r($result);exit;
        return $result;
    }
    
     public function getCoreCourseByCourseIdpassfail($c_id,$session_id='',$cmn_terms='',$deg=''){
        $select = $this->_db->select()
        ->from($this->_name, array('id','department'));
        $select->joinleft(array("academic_master"),"academic_master.department=$this->_name.id",array("academic_year_id","short_code","session"));
        $select->joinleft(array("term_master"),"term_master.academic_year_id=academic_master.academic_year_id",array("term_id","cmn_terms"));
        $select->join(array("department_type"),"department_type.id=$this->_name.department_type",array("department_type"));
            if(!empty($session_id))
        $select->where("academic_master.session =?",$session_id);
            if(!empty($cmn_terms))
        $select->where("term_master.cmn_terms =?",$cmn_terms);
            if(!empty($deg))
        $select->where("$this->_name.degree_id =?",$deg);
        $select->where("$this->_name.status!=?",2);
        
       $select->group('academic_master.academic_year_id');
      //  echo  "<pre>".$select; die;
        $result = $this->getAdapter()->fetchAll($select);
        
       
        //echo '<pre>';print_r($result);exit;
        return $result;
    }
    //End
    
}
