<?php
/* 
 Author: Kedar Kumar
 Summary: This model is used for Promotion rule.
 Date: 25 Sept. 2019
*/
class Application_Model_PromotedMasterItem extends Zend_Db_Table_Abstract {

    public $_name = 'promoted_master_item';
    protected $_id = 'id'; 
    //This function gets all promotion rule data
  
    public function getRecordById($id)
    {       
        $select=$this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.id=?", $id);			   

            $result=$this->getAdapter()
            ->fetchRow($select);    
  			  
        return $result;
    }
     public function getRecordByMasterId($id){
          $select=$this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.master_id=?", $id);			   

            $result=$this->getAdapter()
            ->fetchAll($select);    
  			  
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
    
     
	public function trashItems($id) {



        $this->_db->delete($this->_name, "master_id=$id");



    }

    
    
}
?>
