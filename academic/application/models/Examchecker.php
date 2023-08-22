<?php
/** 
 * @Framework Zend Framework
 * @category   ERP Product
 *	Authors     Kedar Kumar
 */
class Application_Model_Examchecker extends Zend_Db_Table_Abstract
{
    public $_name = 'examchecker';
    protected $_id = 'id';
  
    //get details by record for edit
public function getRecords()
    {       
       $select=$this->_db->select()
       ->from($this->_name,array('examchecker.id as mid','sem','last_attempt_year'))			   
       ->join(array("acad"=>"academic_year"),"acad.year_id=$this->_name.academic_year")
       ->join(array("session"=>"session_info"),"session.id=$this->_name.session");
        $result=$this->getAdapter()
        ->fetchAll($select);       
        return $result;
    }
    
    public function getRecord($id)
    {       
        $select=$this->_db->select()
        ->from($this->_name)
       
        ->where("$this->_name.$this->_id=?", $id);				   
	//->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
        ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    public function getAcademicYear($id,$acad,$term)
    {       
        $select=$this->_db->select()
        ->from($this->_name)
        ->where("$this->_name.session=?", $id)	
        ->where("$this->_name.not_attempt_year <= ?", $acad)
        ->where("$this->_name.sem=?", $term);
	//->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
        ->fetchRow($select);    
        //echo $select;die;
        return $result;
    }
    
    public function getRecordByIds($id,$term,$stu_id="")
    {       $notstuarr = array('F-2019-10665','F-2019-10640','F-2019-10502');
   // echo $stu_id; die;
   $result['last_attempt_year'] = date("Y");
     if(!in_array($stu_id,$notstuarr)){
        $select=$this->_db->select()
        ->from($this->_name)
        ->where("$this->_name.session=?", $id)	
       // ->where("$this->_name.year=?", $acad)
        ->where("$this->_name.sem=?", $term);
	//->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
        ->fetchRow($select);    
     //   echo $select;die;
       
     }
     return $result;
    }
    public function getDropDownList(){
        $select = $this->_db->select()
	->from($this->_name, array('year_id','academic_year','active_year'))				
	->where("$this->_name.status!=?",2)
        ->order('year_id  DESC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
        foreach ($result as $val) {
	$data[$val['year_id']] = $val['academic_year'];
         }
        return $data;
    }
	
public function getPreviousattemptyear($sem,$session) {
         
                $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.sem=?", $sem)
                ->where("$this->_name.session =?", $session);  
                
                $result = $this->getAdapter()

                ->fetchRow($select);

//echo $select; exit;

        return $result;

    }
    
   public function getPreviousrecord($sem,$session='',$acad,$stu_id) {
     // echo "<pre>";print_r($sem);exit;
                    $notstuarr = array('F-2019-10665','F-2019-10640','F-2019-10502');
                     if ($sem != 't1') {
                                $term_id_arr = explode('t', $sem);
                                for($i=1;$i<$term_id_arr[1];$i++){
                                $term_id[] = 't' . $i;
                                }
                            }
                            else
                            {
                               $term_id[] = $sem;
                            }
                           
                            if(!in_array($stu_id,$notstuarr)){
                           $select = "SELECT `examchecker`.*, grade_allocation_master.term_id,last_attempt_year,grade_allocation_items.* FROM `examchecker`,
            grade_allocation_master,
            grade_allocation_items
             WHERE 
             grade_allocation_master.cmn_terms = examchecker.sem and grade_allocation_master.session = examchecker.session
             and grade_allocation_items.grade_allocation_id = grade_allocation_master.grade_id
             and (examchecker.sem in ('".implode("','",$term_id)."')) 
             AND (examchecker.session =$session)
             AND (grade_allocation_items.student_id =$stu_id) 
             AND (grade_allocation_master.academic_id =$acad) 
             and (grade_allocation_items.grade_value REGEXP '(F|NA|Ab)')
             AND (examchecker.last_attempt_year < DATE_FORMAT(now(),'%Y'))";
 //add single quote in stu_id date 27-03-2023 raushan///
 
//  if($stu_id=="1502"){
   //  echo "<pre>".$select;
//  }
// echo "<pre>".$select;die;
                $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
                }
                else
                return "" ;

    }   	
	

    

}
?>