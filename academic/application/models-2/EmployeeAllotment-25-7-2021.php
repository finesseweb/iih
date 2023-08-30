<?php
/** 
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 *	Authors Kannan and Rajkumar
 */
class Application_Model_EmployeeAllotment extends Zend_Db_Table_Abstract
{
    public $_name = 'employee_allotment_master';
    protected $_id = 'ea_id';
  
    //get details by record for edit
	public function getRecord($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->joinleft(array("academic"=>"academic_master"),"academic.academic_year_id=$this->_name.academic_year_id",array("from_date","to_date","batch_code","short_code"))
                        ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_name"))
                      ->where("$this->_name.$this->_id=?", $id)				   
					  ->where("$this->_name.status !=?", 2);
        
        $result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;
    }
	
	//Get all records
	public function getRecords()
    {       
            
           
        $select=$this->_db->select()
                      ->from($this->_name) 
	//->joinleft(array("academic"=>"course_type_master"),"academic.ct_id=$this->_name.ct_id",array("ct_name"))
	->joinleft(array("academic"=>"academic_master"),"academic.academic_year_id=$this->_name.academic_year_id",array("from_date","to_date","batch_code","short_code"))
        ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_name"))
	->where("$this->_name.status !=?", 2)
	
	->order("$this->_name.$this->_id DESC");
        //echo $select; exit;
        $result = $this->getAdapter()
                      ->fetchAll($select);  
        return $result;
       // echo $select;die;
        /*$bool = true;
        if($_SESSION['admin_login']['admin_login']->empl_id)
            $bool = $this->facultyExist($_SESSION['admin_login']['admin_login']->empl_id);
        if($bool)
        return $result;
        else
            return 0;*/
    }
	public function getRecordByAcadId($acadId)
    {       
            
           
        $select=$this->_db->select()
                      ->from($this->_name) 
	->joinleft(array("academic"=>"academic_master"),"academic.academic_year_id=$this->_name.academic_year_id",array("from_date","to_date","batch_code","short_code"))
        ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_name"))
	->where("$this->_name.academic_year_id =?",$acadId )
	
	->order("$this->_name.$this->_id DESC");
        //echo $select; exit;
        $result = $this->getAdapter()
                      ->fetchAll($select);  
        return $result;
      
    }
	public function getRecordByTermId($termId)
    {       
            
           
        $select=$this->_db->select()
                      ->from($this->_name) 
	->joinleft(array("academic"=>"academic_master"),"academic.academic_year_id=$this->_name.academic_year_id",array("from_date","to_date","batch_code","short_code"))
        ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_name"))
	->where("$this->_name.term_id =?",$termId )
	
	->order("$this->_name.$this->_id DESC");
        //echo $select; exit;
        $result = $this->getAdapter()
                      ->fetchAll($select);  
        return $result;
      
    }
    //Author: Kedar Date:30 Nov 2020
    public function getRecordsByEmplId($empl_id){
        $select  = $this->_db->select()
        ->from('empl_dept',array('id','dept_id'))
       
        ->where("empl_dept.empl_id=?",$empl_id)
        ->where("empl_dept.status !=?", 2);
        
        
        $result1 = $this->getAdapter()
			->fetchAll($select);
        //echo $select;die;
        if($result1){
            $deptId=array();
            foreach ($result1 as $key => $value) {
              
                array_push($deptId, $result1[$key]['dept_id']);
            }
            //$commaSeparatedIs=implode(',', $deptId); 
             //echo '<pre>'; print_r($commaSeparatedIs);exit;
              
              
            $select  = $this->_db->select()
                ->from('academic_master',array('academic_year_id'))

                ->where("academic_master.department IN (?)",$deptId)
                ->where("academic_master.status !=?", 2);


                $result2 = $this->getAdapter()
			->fetchAll($select);
                //echo $select; die;
        }
        if($result2){
            // echo '<pre>'; print_r($result2);exit;
            $acad_id= array();
            foreach ($result2 as $key => $value) {
              
                array_push($acad_id, $result2[$key]['academic_year_id']);
            }
              $select=$this->_db->select()
                    ->from($this->_name) 
                    ->joinleft(array("academic"=>"academic_master"),"academic.academic_year_id=$this->_name.academic_year_id",array("from_date","to_date","batch_code","short_code"))
                    ->joinLeft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_name"))
                    ->where("$this->_name.academic_year_id IN (?)",$acad_id)
                    ->where("$this->_name.status !=?", 2)

                ->order("$this->_name.$this->_id DESC");
                    //echo $select; exit;
                    $result = $this->getAdapter()
                                  ->fetchAll($select);  
                    
              return $result;
        
        }
            
    }
    //End
    public function facultyExist($empl_id){
        $select=$this->_db->select()
                      ->from('employee_allocation_items_master') 
                    //    ->joinLeft(array("alot_master"=>"employee_allotment_master"),"alot_master.ea_id = employee_allocation_items_master.ea_id")
                     ->where("employee_allocation_items_master.employee_id =?", $empl_id);
                 $result = $this->getAdapter()
                      ->fetchAll($select);
                 return count($result)>0?true:false;
    }
	
	public function getDropDownList(){
        $select = $this->_db->select()
     ->from($this->_name, array('elc_id','elc_name'))				
				->where("$this->_name.status!=?",2)
                ->order('elc_id  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
		
        foreach ($result as $val) {
			
			$data[$val['elc_id']] = $val['elc_name'];
			
           // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
			//print_r($data);die;
        }
        return $data;
    }
	
	
	//same name validation
	
	
	public function getcomponenetname($componentname) {

        $select = $this->_db->select()
                ->from($this->_name,array("elc_name","elc_id"))	
				->where("$this->_name.elc_name =?", $componentname)
				->where("$this->_name.status!=?", 2);
		
        $result = $this->getAdapter()
                ->fetchRow($select);
		return $result;
		

    }
	
	
	public function getprogram($ccl_id) {

        $select = $this->_db->select()
                ->from($this->_name)
				->joinleft(array("term"=>"term_master"),"term.term_id=$this->_name.term_id",array("term_name"))
				 ->joinleft(array("course"=>"course_master"),"course.course_id=$this->_name.course_id",array("course_name"))
				 ->joinleft(array("cc"=>"course_category_master"),"cc.cc_id=$this->_name.cc_id",array("cc_name"))
				 ->joinleft(array("credit"=>"credit_master"),"credit.credit_id=$this->_name.credit_id",array("credit_value"))
				->where("$this->_name.academic_year_id =?", $ccl_id)
				->where("$this->_name.status!=?", 2);
		
        $result = $this->getAdapter()
                ->fetchAll($select);
		
		
				
		return $result;
		

    }
    
    

	 public function getEmployeeTerms($academic_year_id,$department_id,$employee_id,$term_id,$course_id){
            
             if(!$course_id){
                 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))                                     
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("$this->_name.status != 2")
                                        ->where("$this->_name.term_id = ?", $term_id)
                                        ->where("allocation_items.employee_id=?",$employee_id);
					
		$result = $this->getAdapter()
			->fetchAll($select);
                 
             }else{
		 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))                                      ->where("course.course_id=?", $course_id)
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("$this->_name.status != 2")
                                        ->where("$this->_name.term_id = ?", $term_id)
                                        ->where("allocation_items.employee_id=?",$employee_id);
		//echo $select;die;			
		$result = $this->getAdapter()
			->fetchAll($select);
             }
		//print_r($result); die;
		return $result;
	 }
         
         
	 public function getEmployeeTermsNew1($academic_year_id,$department_id,$employee_id,$term_id,$course_id,$cc_id){
           
             if(!$course_id){
                 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))                                     
					->joinRight(array("eval_component"=>"evaluation_components_master"),"eval_component.course_id=allocation_items.course_id",array('term_id as no_pr','academic_year_id as no_pr'))                                     
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("course.course_category_id=?",$cc_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("$this->_name.status != 2")
                                        ->where("$this->_name.term_id = ?", $term_id)
                                        ->where("allocation_items.employee_id=?",$employee_id);	
		$result = $this->getAdapter()
			->fetchAll($select);
                
                
                 
             }else{
		 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))                                      ->where("course.course_id=?", $course_id)
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("$this->_name.status != 2")
                                        ->where("$this->_name.term_id = ?", $term_id)
                                        ->where("allocation_items.employee_id=?",$employee_id);
					
		$result = $this->getAdapter()
			->fetchAll($select);
             }
		//echo "<pre>";print_r($result); die;
		return $result;
	 }
         
         
         
         
         
         
         
	 public function getEmployeeTermsNew($department_id,$employee_id,$course_id=''){
            
             if(!$course_id){
                 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))                                     
					
					->where("allocation_items.department_id=?",$department_id)
                     ->order('course.course_name  ASC')
					->where("$this->_name.status != 2")
                    ->where("allocation_items.employee_id=?",$employee_id);
		//echo $select;die;			
		$result = $this->getAdapter()
			->fetchAll($select);
                 
             }else{
		 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))                                      ->where("course.course_id=?", $course_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("$this->_name.status != 2")
                                        ->where("allocation_items.employee_id=?",$employee_id);
		//echo $select;die;			
		$result = $this->getAdapter()
			->fetchAll($select);
             }
		//print_r($result); die;
		return $result;
	 }
         
         
         
         public function getEmployeeAllTerms($academic_year_id,$department_id,$employee_id){
		 
		 $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))	
					//->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("$this->_name.status != 2")
                                        ->where("allocation_items.employee_id=?",$employee_id);
		//echo $select;die;			
		$result = $this->getAdapter()
			->fetchAll($select);
	//	print_r($result); die;
		return $result;
	 }
	 
	 public function getTerms($academic_year_id,$department_id,$employee_id){
		 
		  $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id);
					
			$result = $this->getAdapter()
			->fetchAll($select);
			$data = array();
          foreach($result as $val){
				$data[$val['term']] = $val['term_name'];

		  }	
		return $data;		  
	 }
	 public function getCourses($academic_year_id,$department_id,$employee_id,$term_id){
		 
		  $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id)	
					->where("allocation_items.term_id=?",$term_id);						
		 		
			$result = $this->getAdapter()
			->fetchAll($select);
			$data = array();
          foreach($result as $val){
				$data[$val['course']] = $val['course_name'];

		  }	
		return $data;	
	 }
	

public function getComponentCourses($academic_year_id,$department_id,$employee_id,$term_id,$department = '',$paper_flg = 'R',$month=""){
		 
		  $select = $this->_db->select()
					->from($this->_name)
	->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id = $this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
	->joinLeft(array("course"=>"course_master"),"course.course_id = allocation_items.course_id",array("course_id as course","course_name"))
	->joinLeft(array("acad"=>"academic_master"),"acad.academic_year_id = $this->_name.academic_year_id",array("department"))
					//->joinLeft(array("grade_allocation"=>"grade_allocation_master"),"grade_allocation.course_id=allocation_items.course_id",array("course_id"))
					//->joinLeft(array("grade_allocation"=>"grade_allocation_master"),"grade_allocation.academic_id=$this->_name.academic_year_id",array("course_id"))
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					//->where("grade_allocation.academic_id=?",$academic_year_id)
					//->where("allocation_items.department_id=?",$department_id)
					//->where("allocation_items.employee_id=?",$employee_id)
					//->orwhere("allocation_items.visiting_faculty_id like?",'%'.$employee_id.'%')
					->where("allocation_items.term_id=?",$term_id);
                    //->where("grade_allocation.course_id IS  NULL");
			$result = $this->getAdapter()
			->fetchAll($select);
		
			$data = array();
          foreach($result as $val){
			  $select1 = $this->_db->select();
			             $select1->from("grade_allocation_master");
						 $select1->where("grade_allocation_master.academic_id=?",$val['academic_year_id']);
						 $select1->where("grade_allocation_master.department_id=?",$val['department_id']);
			        	//->where("grade_allocation_master.employee_id=?",$val['employee_id']);
				        
				        if(!empty($department))
						$select1->where("grade_allocation_master.department=?",$department);
                                       // else
                                         //    $select1->where("grade_allocation_master.employee_id=?",$val['employee_id']);
						
						 $select1->where("grade_allocation_master.term_id=?",$val['term_id']);
						 $select1->where("grade_allocation_master.course_id=?",$val['course_id']);
						 if($paper_flg == "B"){
						    $select1->where("grade_allocation_master.exam_month=?",$month); 
						 }
						 $select1->where("grade_allocation_master.flag=?",$paper_flg);
                                                 $select1->where("grade_allocation_master.status !=?",2);
                                                 //echo $select1; die;
						 $result1 = $this->getAdapter()
						           ->fetchRow($select1);
							if($result1['grade_id'] == ''){
				                $data[$val['course']] = $val['course_name'];
							}

		  }
          //echo '<pre>'; print_r($data); exit;
		return $data;	
	 }
     //Added By : Kedar : Date: 23 Nov 2020
public function getComponentCoursesByEmployee($academic_year_id,$department_id,$employee_id,$term_id,$department = '',$paper_flg = 'R'){
		 
		  $select = $this->_db->select()
					->from($this->_name)
	->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id = $this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
	->joinLeft(array("course"=>"course_master"),"course.course_id = allocation_items.course_id",array("course_id as course","course_name"))
	->joinLeft(array("acad"=>"academic_master"),"acad.academic_year_id = $this->_name.academic_year_id",array("department"))
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id)
					->orwhere("allocation_items.faculty_id like?",'%'.$employee_id.'%')
					->where("allocation_items.term_id=?",$term_id);
			$result = $this->getAdapter()
			->fetchAll($select);
           //echo $select; die;
			
		return $result;	
	 }

/*  public function getComponentCourses($academic_year_id,$department_id,$employee_id,$term_id){
		 
		  $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))
					->joinLeft(array("grade_allocation"=>"grade_allocation_master"),"grade_allocation.course_id=allocation_items.course_id",array("course_id"))
					
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id)	
					->where("allocation_items.term_id=?",$term_id)
                                        ->where("grade_allocation.course_id IS  NULL");
	
				
		 		
			$result = $this->getAdapter()
			->fetchAll($select);
			$data = array();
          foreach($result as $val){
				$data[$val['course']] = $val['course_name'];

		  }	
		return $data;	
	 }   */


	  public function getEditComponentCourses($academic_year_id,$department_id,$employee_id,$term_id){
		 
		  $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))
					
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id)	
						->orwhere("allocation_items.visiting_faculty_id like?",'%'.$employee_id.'%')
					->where("allocation_items.term_id=?",$term_id);						
		 		
			$result = $this->getAdapter()
			->fetchAll($select);
			$data = array();
          foreach($result as $val){
				$data[$val['course']] = $val['course_name'];

		  }	
		return $data;	
	 }
         
	  public function getEditComponentCoursesNew($academic_year_id,$department_id,$employee_id,$term_id,$cc_id){
		 
		  $select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items.course_id",array("course_id as course","course_name"))
					
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("course.course_category_id=?",$cc_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id)	
					->where("allocation_items.term_id=?",$term_id);						
		 		
			$result = $this->getAdapter()
			->fetchAll($select);
			$data = array();
          foreach($result as $val){
				$data[$val['course']] = $val['course_name'];

		  }	
		return $data;	
	 }
         

	  public function getEmployeeDropDownList($academic_year_id,$department_id,$employee_id) {
       
		
		$select = $this->_db->select()
                ->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items_master"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','department_id','employee_id'))
					->joinLeft(array("term"=>"term_master"),"term.term_id=allocation_items.term_id",array("term_id as term","term_name"))
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items.department_id=?",$department_id)
					->where("allocation_items.employee_id=?",$employee_id);
        $result = $this->getAdapter()->fetchAll($select);
        $data1 = array();
        foreach ($result as $val) {
				$select1 = $this->_db->select()
					->from($this->_name)	
					->joinLeft(array("allocation_items1"=>"employee_allocation_items_master"),"allocation_items1.ea_id=$this->_name.ea_id",array('course_id','department_id','employee_id','term_id'))
					->joinLeft(array("course"=>"course_master"),"course.course_id=allocation_items1.course_id",array("course_id as course","course_name"))					
					->where("$this->_name.academic_year_id=?",$academic_year_id)
					->where("allocation_items1.department_id=?",$department_id)
					->where("allocation_items1.employee_id=?",$employee_id)
					->where("allocation_items1.term_id=?",$val['term_id']);
					$result1 = $this->getAdapter()->fetchAll($select1);
					$data = array();
					foreach ($result1 as $pval) {
						$data[$pval['course']] = $pval['course_name'];
					}
			$data1[$val['term_name']] = $data;
        }
		//print_r($data1); die;
        return $data1;		
    } 
     
	/* public function getEmployeeCourses($academic_year_id,$department_id,$employee_id){
		
		$select = $this->_db->select()
					->from($this->_name)
					->joinLeft(array("allocation_items"=>"employee_allocation_items"),"allocation_items.ea_id=$this->_name.ea_id",array('term_id','course_id','department_id','employee_id'))
                    ->joinLeft(array())		
	} */
	
	
	
	public function getValidFacultyRecord($academic_year_id, $term_id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.academic_year_id =?", $academic_year_id)
                      ->where("$this->_name.term_id =?", $term_id)
                      ->where("$this->_name.status !=?", 2);
					 // ->where("$this->_name.year_id =?", $year_id);	
        //echo $select;die;					  
        $result=$this->getAdapter()
                      ->fetchRow($select);    
    //print_r($result);die;					  
        return $result;
    }
	public function getExistedFaculty($academic_year_id,$term_id,$cc_id,$course_id)
	{
		$select = $this->_db->select()
				  ->from($this->_name)
				  ->joinLeft(array("allotment_items"=>"employee_allocation_items_master"),"allotment_items.ea_id=$this->_name.ea_id",array("term_id","cc_id","course_id","employee_id","faculty_id","visiting_faculty_id","remarks","ead_id"))
				  ->where("$this->_name.academic_year_id=?",$academic_year_id)
				  ->where("allotment_items.term_id=?",$term_id)
				  ->where("allotment_items.cc_id=?",$cc_id)
				  ->where("allotment_items.course_id=?",$course_id)
				  ->where("$this->_name.status != 2");			  
		$result = $this->getAdapter()
		           ->fetchRow($select);
				   
		return $result;		   
				  
	}
}
?>