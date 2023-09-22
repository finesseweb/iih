<?php
/* 
 Author: Kedar Kumar
 Summary: This model is used for Promotion rule.
 Date: 25 Sept. 2019
*/
class Application_Model_PromotedMaster extends Zend_Db_Table_Abstract {

    public $_name = 'promoted_master';
    protected $_id = 'promo_id'; 
    //This function gets all promotion rule data
  
    public function getRecordById($id)
    {       
        $select=$this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.promo_id=?", $id);			   

            $result=$this->getAdapter()
            ->fetchRow($select);    
  			  
        return $result;
    }
     public function getRecordByMasterId($id='',$batch='',$session='',$stu_id){
         $select=$this->_db->select()
            ->from($this->_name)
			 ->join(array("promoted_master_item") , "promoted_master_item.promoted_id=$this->_name.promo_id",array("promoted_value"))
            ->where("$this->_name.prev_term=?", $batch)
			->where("$this->_name.academic_id=?", $id)
            ->where("$this->_name.session=?", $session)	
			->where("promoted_master_item.stu_id=?", $stu_id)	;	

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
            ->where("$this->_name.degree_id=?", $degree_id)	
            ->where("$this->_name.semester=?", $cmn_term)
            ->where("$this->_name.session=?", $session_id);	
            $result=$this->getAdapter()
            ->fetchAll($select);  
            //echo $select;die;
            //echo"<pre>";print_r($result);die;	  
        return $result;
    }
    
    public function GetRecords($degree_id='',$session_id='',$batch='',$cmn_term=''){       
        $select=$this->_db->select()
            ->from(array($this->_name)) 
             ->join(array("academic_master") , "academic_master.academic_year_id=$this->_name.academic_id")
			 ->join(array("academic_year") , "academic_year.year_id=$this->_name.academic_year")
			 ->join(array("session_info") , "session_info.id=$this->_name.session")
			 ->join(array("promoted_master_item") , "promoted_master_item.promoted_id=$this->_name.promo_id",array("count(stu_id) as tottalstudent"))
            ->where("$this->_name.academic_year	=?", $degree_id)	
            ->where("$this->_name.prev_term=?", $cmn_term)
			->where("$this->_name.academic_id=?", $batch)
            ->where("$this->_name.session=?", $session_id)
			->group("$this->_name.promo_id");	
            $result=$this->getAdapter()
            ->fetchAll($select);  
            //echo $select;die;
            //echo"<pre>";print_r($result);die;	  
        return $result;
    }
	
	public function trashItems($id) {



        $this->_db->delete($this->_name, "master_id=$id");



    }

    
    
}
?>
