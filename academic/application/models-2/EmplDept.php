<?php

class Application_Model_EmplDept extends Zend_Db_Table_Abstract {

    public $_name = 'empl_dept';
    protected $_id = 'id';

    public function getRecord($id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.$this->_id =?", $id)
            ->where("status=?", 0);
        $result = $this->getAdapter()
            ->fetchRow($select);
        //$result['batch_id'] = $this->academic($id);
        return $result;
    }

    public function getDropDownList() {
        $empl_id='';
        if ($_SESSION['admin_login']['admin_login']->empl_id)
            $empl_id = $_SESSION['admin_login']['admin_login']->empl_id;
        //echo '<pre>';print_r($empl_id);exit;
        $select = $this->_db->select()
            ->from($this->_name, array('id', 'dept_id'));
        if ($empl_id !== 'superAdmin' && !empty($empl_id)) {
            // '<pre>';print_r('LOve');exit;

            $select->where('empl_dept.empl_id = ?', $empl_id);
        }else if($empl_id === 'superAdmin' ){
            
        }else{
            $acadInfo= new Application_Model_Academic();
            $dept= $acadInfo->getDepartment( $_SESSION['admin_login']['admin_login']->participant_academic);
            
        }
        $select->where("status =?", 0)
            ->order('id  ASC');
        //echo $select;die;
        $result = $this->getAdapter()->fetchRow($select);
        //echo '<pre>'; print_r($result);die;
        if ($result) {
            $select = $this->_db->select()
                ->from($this->_name, array('id', 'empl_id'));
            if ($empl_id !== 'superAdmin' && !empty($empl_id)) {

                $select->where('empl_dept.dept_id = ?', $result['dept_id']);
            }else if($empl_id === 'superAdmin' ){
                
            }
            else{
                $select->where('empl_dept.dept_id = ?', $dept['department']);
            }
            $select->where("status =?", 0)
                ->order('id  ASC');
            $result1 = $this->getAdapter()->fetchAll($select);
        }

        //echo $select;die;
        $data = array();
       //echo '<pre>'; print_r($result1);die;
        foreach ($result1 as $val) {
            $emplyeeData = new Application_Model_HRMModel();
                                      
            $EmplData= $emplyeeData->getEmployeeData($val['empl_id']);
            

            $data[$val['empl_id']] = $EmplData['empl_firstname'];

            // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
           // echo "<pre>";print_r($data);die;
        }
        return $data;
    }

    public function getEmplDeptRecords() {
        $select = $this->_db->select()
            ->from('empl_dept')
            ->joinleft(array("dept" => "department"), "dept.id=empl_dept.dept_id", array("department"))
            ->where('empl_dept.status = ?', 0);
        //->joinleft(array("fa_users"=>"fa_kv_empl_info"),"fa_users.empl_id=empl_dept.empl_id",array("empl_firstname"));
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

    public function getEmplDeptRecordsByStream($id) {
        $select = $this->_db->select()
            ->from('empl_dept')
            ->joinleft(array("dept" => "department"), "dept.id=empl_dept.dept_id", array("department"))
            ->where('empl_dept.dept_id = ?', $id)
            ->where('empl_dept.status = ?', 0);
        //->joinleft(array("fa_users"=>"fa_kv_empl_info"),"fa_users.empl_id=empl_dept.empl_id",array("empl_firstname"));
        $result = $this->getAdapter()
            ->fetchAll($select);
        //echo $select;die;
        return $result;
    }

}
