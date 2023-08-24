<?php 
class Application_Model_DmiHoliday extends Application_Model_GlobalDbModel
{
	
	
    protected $_name = 'fa_kv_holiday_master';
    public  function __construct(){
        parent::__construct('erp');
        }
    
    
    public function getHolidayList($holiday_category){
        
        $select = $this->_db->select()
				->from($this->_name)
				->where("category IN(?)",$holiday_category)
				->where("deleted IS NULL")
				->order('start');
				$result = $this->getAdapter()                         ->fetchAll($select);  
                       return $result;
    }
    
    
    
      public function getHolidayListForStudents(){
        
        $select = $this->_db->select()
				->from($this->_name)
				->where("category IN(?)",array(38,39))
				->where("deleted IS NULL")
				->order('start');
				$result = $this->getAdapter()         
                                ->fetchAll($select);  
                       return $result;
    }
    
    public function getHolidayListAll()     {                $select = $this->_db->select()				->from($this->_name)				->order('from_date');				$result = $this->getAdapter()                                         ->fetchAll($select);                         return $result;    }
    
 public function getDropDownList(){        $select = $this->_db->select()		->from($this->_name, array('holiday_id','cal_yearc'))			->group('cal_yearc')        ->order('holiday_id  ASC');        $result = $this->getAdapter()->fetchAll($select);        $data = array();		$st_year ='';		$end_year='';        foreach ($result as $val) {			//==============[changed due to data is comming from excel as text]========================//			$data[$val['cal_yearc']] = $val['cal_yearc'];        }        return $data;    }   
   public function getholidaylistyear($year){          $select = $this->_db->select()                ->from($this->_name)                ->where("cal_yearc =?",$year);				//echo  $select; die();        $result = $this->getAdapter()->fetchAll($select);  				        return $result;    }  
}