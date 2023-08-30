<?php/**  * @Framework Zend Framework * @Powered By TIS  * @category   ERP Product * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd. * (http://www.techintegrasolutions.com) *	Authors Kannan and Rajkumar */class Application_Model_FeeInstallment extends Zend_Db_Table_Abstract{    public $_name = 'instalment';    protected $_id = 'id';      //get details by record for edit	public function getRecord($id)    {               $select=$this->_db->select()                      ->from($this->_name)                      ->where("$this->_id=?", $id)				   					  ->where("$this->_name.status !=?", 2);        $result=$this->getAdapter()                      ->fetchRow($select);               return $result;    }        	public function getRecordbyDegreeId($id,$fund_type)    {               $select=$this->_db->select()                      ->from($this->_name)                      ->where("degree_id=?", $id)				                           ->where("fund_type=?", $fund_type)						  ->where("$this->_name.status !=?", 2);        $result=$this->getAdapter()                      ->fetchAll($select);               return $result;    }                	public function getRecordByDegreeId1($id)    {               $select=$this->_db->select()                      ->from($this->_name)                      ->where("$this->_name.degree_id=?", $id)				   					  ->where("$this->_name.status !=?", 2);        $result=$this->getAdapter()                      ->fetchAll($select);               return $result;    }    		public function getaccnameRecord($id)    {               $select=$this->_db->select()                      ->from('account_master')                      ->where("id=?", $id)				   					  ->where("account_master.status !=?", 2);        $result=$this->getAdapter()                      ->fetchRow($select);       //echo "<pre>"; print_r($result); die;        return $result;    }	//Get all records	public function getRecords()    {               $select=$this->_db->select()                      ->from($this->_name,array('group_concat(`amount`) as installment','fees' ,"$this->_name.academic_year_id"))                          ->join(array("batch"=>"academic_master"),"$this->_name.academic_year_id=batch.academic_year_id",array("short_code"))                        ->join(array("term"=>"term_master"),"term.cmn_terms = $this->_name.term_id and term.academic_year_id=$this->_name.academic_year_id",array("term_name","cmn_terms"))					  ->where("$this->_name.status !=?", 2)                   ->group(array("$this->_name.academic_year_id","$this->_name.term_id",'SUBSTRING_INDEX(SUBSTRING_INDEX(fees, "-", 2),"-", -1)'))					  ->order("$this->_id DESC");//echo $select; die;        $result=$this->getAdapter()                      ->fetchAll($select);         return $result;    }				   public function getDropDownList()	{        $select = $this->_db->select()		    ->from($this->_name,array('category_id', 'category_name'))			->where("$this->_name.status!=?",2)			->order('category_id  ASC');        $result = $this->getAdapter()->fetchAll($select);		//echo'<pre>';print_r($result);die;      $data = array();        foreach($result as $k=>$vals) {						$data[$vals['category_id']] = $vals['category_name'];			        }		        return $data;     }               public function getAccDropDownList()	{        $select = $this->_db->select()		    ->from("account_master",array('id', 'acc_name'))			->where("account_master.status!=?",2)			->order('acc_name  ASC');        $result = $this->getAdapter()->fetchAll($select);		//echo'<pre>';print_r($result);die;      $data = array();        foreach($result as $k=>$vals) {						$data[$vals['id']] = $vals['acc_name'];			        }		        return $data;     }       public function getRecordbyacadId($acad_id,$term_id){              $select=$this->_db->select()                      ->from($this->_name)                      ->where("$this->_name.academic_year_id=?", $acad_id)				                           ->where("$this->_name.term_id=?", $term_id)						  ->where("$this->_name.status !=?", 2)					  	->order('description  ASC');;        $result=$this->getAdapter()                      ->fetchAll($select);               return $result;                 }            public function getRecordbyacadfeeId($acad_id,$term_id,$fee){              $select=$this->_db->select()                      ->from($this->_name)                      ->where("$this->_name.academic_year_id=?", $acad_id)				                           ->where("$this->_name.term_id=?", $term_id)	                        ->where("md5($this->_name.fees)=?", $fee)						  ->where("$this->_name.status !=?", 2);        $result=$this->getAdapter()                      ->fetchAll($select);               return $result;                 }			public function getCategory($degree_id='')	{        $select = $this->_db->select()		    ->from($this->_name,array('category_name','category_id'))		    			//->joinleft(array("feeheads"=>"erp_fee_heads_master"),"$this->_name.category_id=feeheads.feecategory_id",array("feecategory_id"))			//->joinleft(array("feehead_items"=>"erp_fee_heads_items"),"feehead_items.feehead_id=feeheads.feehead_id",array("feehead_name"))			->where("$this->_name.status!=?",2)            ->where("$this->_name.degree_id = ?",$degree_id)			->order('category_id  ASC');	//	echo $select;die;        $result = $this->getAdapter()->fetchAll($select);		//echo'<pre>';print_r($result);die;        return $result;     }                    	public function getFeeCategory($degree_id='',$acc_name = '')	{        $select = $this->_db->select()		    ->from($this->_name,array('category_name','category_id'))		    			->join(array("acc_m"=>"account_master"),"$this->_name.fund_type=acc_m.id",array())          //  ->join(array("term_items"=>"erp_fee_structure_term_items"),"feeheads.feehead_id=term_items.fee_heads_id",array("GROUP_CONCAT(fees) as totfee"))			//->joinleft(array("feehead_items"=>"erp_fee_heads_items"),"feehead_items.feehead_id=feeheads.feehead_id",array("feehead_name"))			->where("$this->_name.status!=?",2)			->where("acc_m.acc_name = ?",$acc_name)            ->where("$this->_name.degree_id = ?",$degree_id)           // ->where("term_items.terms_id = ?",$term_master)            //->group("$this->_name.category_id")			->order("$this->_name.category_id  ASC");		//echo $select;die;        $result = $this->getAdapter()->fetchAll($select);		//echo'<pre>';print_r($result);die;        return $result;     }    		public function getCategoryIds()	{        $select = $this->_db->select()		    ->from($this->_name,'category_id')			//->joinleft(array("feeheads"=>"erp_fee_heads_master"),"$this->_name.category_id=feeheads.feecategory_id",array("feecategory_id"))			//->joinleft(array("feehead_items"=>"erp_fee_heads_items"),"feehead_items.feehead_id=feeheads.feehead_id",array("feehead_name"))			->where("$this->_name.status!=?",2)			->order('category_id  ASC');		//echo $select;die;        $result = $this->getAdapter()->fetchAll($select);		//echo'<pre>';print_r($result);die;        return $result;     }}?>