<?php
/** 
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 *	Authors Kannan and Rajkumar
 */
class Application_Model_ComplainModel extends Application_Model_GlobalDbModel
{
	    protected $_name = 'complain_mail';
         protected $_Id = 'id'; 
            
    function __construct() {
        parent::__construct('main_web');
    }
	

    	public function getRecords()

    {   
        $select=$this->_db->select()
                      ->from($this->_name)
                       ->order("id  Desc")
                       ->limit(10);
        $result=$this->getAdapter()
        
                      ->fetchAll($select); 
        return $result;

    }

   
    
}
?>