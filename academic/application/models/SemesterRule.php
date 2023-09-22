<?php
/* 
 Author: Kedar Kumar
 Summary: This model is used for Promotion rule.
 Date: 25 Sept. 2019
*/
class Application_Model_SemesterRule extends Zend_Db_Table_Abstract {

    public $_name = 'promotion_master';
    protected $_id = 'id'; 
    //This function gets all promotion rule data
    public function getRecords(){       
        $select=$this->_db->select()
            ->from($this->_name)
            //->join(array("term"=>"declared_terms" ),"term.term_des=$this->_name.semester",array("term_name"))
           // ->join(array("terms"=>"declared_terms"),"terms.term_des=$this->_name.nextSem",array("term_name as next_sem"))
            ->join(array("degree"=>"degree_info"),"degree.id=$this->_name.degree_id",array("degree as degree_name"))
            ->join(array("session"=>"session_info"),"session.id=$this->_name.session",array("session"))
         //   ->joinLeft(array("sep"=>"promotion_seperate_items"),"sep.master_id = $this->_name.id and $this->_name.seperate_status = 0",array("GROUP_CONCAT(sep.cmn_terms ORDER by sep.cmn_terms) as sep_terms","GROUP_CONCAT(sep.semester_paper_count ORDER by sep.cmn_terms) as sep_count"))
            ->join(array("academic"=>"academic_year"),"academic.year_id=$this->_name.academic_year_list",array("academic_year"))
            ->where("$this->_name.status !=?",2)
            ->group("$this->_name.id");
           // echo "<pre>".$select; die;
            $result=$this->getAdapter()
            ->fetchAll($select);  
            //echo"<pre>";print_r($result);die;
        return $result;
    } 
    public function getRecordById($id)
    {       
        $select=$this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.id=?", $id);			   

            $result=$this->getAdapter()
            ->fetchRow($select);    
  			  
        return $result;
    }
    public function checkRow($degree_id='',$cmn_term=''){       
        $select=$this->_db->select()
            ->from(array($this->_name))   
            ->where("$this->_name.degree_id=?", $degree_id)	
            ->where("$this->_name.semester=?", $cmn_term);
            $result=$this->getAdapter()
            ->fetchAll($select);  
            //echo $select;die;
            //echo"<pre>";print_r($result);die;	  
        return $result;
    }
    
    
    public function checkRecords($degree_id='',$cmn_term='',$session_id=''){       
        $select=$this->_db->select()
            ->from(array($this->_name))   
            ->joinLeft(array("sep"=>"promotion_seperate_items"),"sep.master_id = $this->_name.id and $this->_name.seperate_status = 0",array("GROUP_CONCAT(sep.cmn_terms ORDER by sep.cmn_terms) as sep_terms","GROUP_CONCAT(sep.semester_paper_count ORDER by sep.cmn_terms) as sep_count"))
            ->where("$this->_name.degree_id=?", $degree_id)	
            ->where("$this->_name.semester=?", $cmn_term)
            ->where("$this->_name.session=?", $session_id)
            ->group("$this->_name.id");	
            $result=$this->getAdapter()
            ->fetchAll($select);  
            //echo $select;die;
            //echo"<pre>";print_r($result);die;	  
        return $result;
    }
    
    
 
    public function checkpromRule($batch='',$degree_id='',$session_id='',$cmn_term=''){       
        $select=$this->_db->select()
            ->from(array($this->_name))   
            ->where("$this->_name.degree_id=?", $degree_id)	
            ->where("$this->_name.nextyear=?", $cmn_term)
            ->where("$this->_name.session=?", $session_id)
			->where("$this->_name.academic_id=?", $batch)
            ->group("$this->_name.id");	
            $result=$this->getAdapter()
            ->fetchRow($select);  
            //echo $select;die;
            //echo"<pre>";print_r($result);die;	  
        return $result['fees'];
    }
    
    
}
?>
