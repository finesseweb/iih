<?phpclass Application_Model_BackTabulationReportItems extends Zend_Db_Table_Abstract{    public $_name = 'back_tabulation_report_items';    protected $_id = 'id';      //get details by record for edit	public function getRecord($id)    {               $select=$this->_db->select()                      ->from($this->_name)                      ->where("$this->_name.$this->_id=?", $id)				   					  ->where("$this->_name.status !=?", 2);        $result=$this->getAdapter()                      ->fetchRow($select);               return $result;    }		//Get all records	public function getRecords()    {               $select=$this->_db->select()                      ->from($this->_name) 					  ->where("$this->_name.status !=?", 2)					  ->order("$this->_name.$this->_id DESC");        $result=$this->getAdapter()                      ->fetchAll($select);               return $result;    }	public function saveRows($array) {        $vAmount    = count($array);        $values     = array();        $columns    = array();    if($vAmount>0){        foreach ($array as $colval) {            foreach ($colval as $column=>$value) {                array_push($values,$value);                !in_array($column,$columns) ? array_push($columns,$column) : null;            }        }        $cAmount    = count($columns);        $values     = array_chunk($values, $cAmount);        $iValues    = '';        $iColumns   = implode("`, `", $columns);        for($i=0; $i<$vAmount;$i++)            $iValues.="('".implode("', '", $values[$i])."')".(($i+1)!=$vAmount ? ',' : null);        $data="INSERT INTO `".$this->_name."` (`".$iColumns."`) VALUES ".$iValues;        $this->getAdapter()->query($data);    }}		}