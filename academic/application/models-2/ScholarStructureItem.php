<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_ScholarStructureItem extends Zend_Db_Table_Abstract {

     public $_name = 'promotion_master';
    protected $_id = 'id';
    
    
    public function getItemRecords($structure_id)  //company_id is main Company Id
    {       
        $select=$this->_db->select()
                      ->from($this->_name)
                      ->where("$this->_name.id=?",$structure_id);
        $result=$this->getAdapter()
                      ->fetchAll($select);  
//print_r($result); die;					  
        return $result;
    }
    
    
    
    
}

