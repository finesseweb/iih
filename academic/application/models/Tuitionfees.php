<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_Tuitionfees extends Zend_Db_Table_Abstract
{
    public $_name = 'tuition_fees';
    protected $_id = 'id';
  
    //get details by record for edit
	public function getRecord($id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.$this->_id=?", $id)	;			   
		    // ->where("$this->_name.status !=?", 1);
        $result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;
    }
	
	public function getRecordByTerm($id,$dept)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.cmn_terms=?", $id)
                     ->where("$this->_name.department=?", $dept)
		      ->where("$this->_name.status !=?", 1);
		    //  echo $select; die;
        $result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;
    }
    public function getRecordByTermsession($id,$dept,$session)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.cmn_terms=?", $id)
                     ->where("$this->_name.department=?", $dept)
                     ->where("$this->_name.session_id=?", $session)
		      ->where("$this->_name.status !=?", 1);
		    //  echo $select; die;
        $result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;
    }
    
	
	//Get all records
	public function getRecords()
    {       
        $select=$this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term"=>"term_master"),"term.cmn_terms=$this->_name.cmn_terms",array("term_description"))    
             ->where("$this->_name.status !=?", 1)
              ->group("$this->_name.cmn_terms")  
            ->order("$this->_name.$this->_id desc");
            $result=$this->getAdapter()
            ->fetchAll($select);   
           
        return $result;
    }
 public function getFeesRecords()
    {       
        $select=$this->_db->select()
            ->from($this->_name)
            ->joinleft(array("term"=>"declared_terms"),"term.term_des=$this->_name.cmn_terms",array("term_name"))
            ->joinleft(array("degree_info"),"degree_info.id=$this->_name.degree_id",array("degree"))
            ->joinleft(array("department"),"department.id=$this->_name.department",array("department"))
            ->where("$this->_name.status !=?", 2)
            ->order("$this->_name.$this->_id desc");
            $result=$this->getAdapter()
            ->fetchAll($select);       
        return $result;
    }
 public function getFilterFeesRecords($session='',$term='',$degree='',$dept='')
    {       
        $select=$this->_db->select()
            ->from($this->_name);
            $select->joinleft(array("term"=>"declared_terms"),"term.term_des=$this->_name.cmn_terms",array("term_name"));
            $select->joinleft(array("degree_info"),"degree_info.id=$this->_name.degree_id",array("degree"));
            $select->joinleft(array("department"),"department.id=$this->_name.department",array("department"));
            if(!empty($session))
            $select->where("$this->_name.session_id =?", $session);
            if(!empty($degree))
            $select->where("$this->_name.degree_id =?", $degree);
            if(!empty($term))
            $select->where("$this->_name.cmn_terms =?", $term);
            if(!empty($dept))
            $select->where("$this->_name.department =?", $dept);
            $select->where("$this->_name.status !=?", 2);
            $select->order("$this->_name.$this->_id desc");
            $result=$this->getAdapter()
            ->fetchAll($select); 
        //echo $select;die;
        return $result;
    }
    	public function getFeedate($term,$session_id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name,array("max(feeForm_start_date) as start_date","max(feeForm_end_date) as end_date","max(feeForm_extended_date) as extended_date"))                      				   
					  ->where("$this->_name.cmn_terms =?", $term)
					  ->where("$this->_name.session_id in (?)", $session_id)
					  ->where("$this->_name.status !=?", 2);
        $result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result;
    }
	public function isRecordExists($term,$degree,$batch,$session_id)
    {       
        $select=$this->_db->select()
                      ->from($this->_name)                      				   
					  ->where("$this->_name.cmn_terms =?", $term)
					  ->where("$this->_name.degree_id =?", $degree)
					  ->where("$this->_name.department =?", $batch)
					  ->where("$this->_name.session_id =?", $session_id);
        $result=$this->getAdapter()
                      ->fetchAll($select);       
        return count($result);
    }
    
	public function getFee($term, $batch, $paper)
    {       
        $select=$this->_db->select()
                      ->from($this->_name,array('fee'))                      				   
					  ->where("$this->_name.status !=?", 2)
					  ->where("$this->_name.batch =?", $batch)
					  ->where("$this->_name.term =?", $term)
					  ->where("$this->_name.paper =?", $paper);
        $result=$this->getAdapter()
                      ->fetchRow($select);       
        return $result['fee'];
    }
    
    
    
    
}