<?php

class Application_Model_Room extends Zend_Db_Table_Abstract {

    public $_name = 'room';
    protected $_id = 'id';

    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id);
              
        $result = $this->getAdapter()
                ->fetchRow($select);
        //echo $select;die;
        return $result;
    }

    public function getRecords() {

        $select = $this->_db->select()
                ->from($this->_name);
             
     
        $result = $this->getAdapter()
                ->fetchAll($select);
//            echo $select;die;
        return $result;
    }
    
    
    
    public function getCourseRoomWise(){
        
    }
    public function getRoomDepartmentWise($id)
    {

        $select = $this->_db->select()
                ->from($this->_name);
             
     
        $result = $this->getAdapter()
                ->fetchAll($select);

        return $result;
        
    }
    
    
    
     
    
    
    public function getRoom($room_no,$department){
            $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.room_no=?", $room_no);
                //->where("$this->_name.department=?", $department);
             
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    public function getRoomByDepartmentId($department){
            $select = $this->_db->select()
                ->from($this->_name,array('id as room_id','room_number','seating_capacity','dept.*'))
                    ->joinLeft(array('dept'=>'department'),"dept.id = $this->_name.department")
                ->where("$this->_name.department=?", $department)
                ->where("$this->_name.status =?", 0);
             //echo $select; die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    public function getDropDownList($date,$duration,$department,$batch,$course){
       
        $select = $this->_db->select()
		->from($this->_name, array('id','room_number','seating_capacity'))	
                 ->joinLeft(array("opp" => "seating_operation"), "opp.room_no=$this->_name.id",array('sum(allocated_seat) as allocated'))
                    ->where("opp.booking_date = ?",$date)
                 ->where("opp.duration = ?",$duration)
               ->where("opp.batch = ?",$batch)
              // ->where("opp.course_id = ?",$course)
                 ->where("opp.department = ?",$department)
                  ->where("$this->_name.status =?",0)
                ->group('opp.room_no')
                ->order("$this->_name.seating_capacity  ASC");
   
        $result = $this->getAdapter()->fetchAll($select);
        $id = array();
        $allocated = array();
        $data = '<option value="">--Select Room--</option>';
		$st_year ='';
		$end_year='';
                
                $newarr = array();
                $i =0;
        foreach ($result as $val) {
                $id[] = $val['id'];
                $data.='<option value="' . $val['id'] . '" >Room no. '. $val['room_number'].' | Seat Left Out '.($val['seating_capacity'] - $val['allocated']). ' </option>';      
        }
  
       
     
        $select = $this->_db->select()
		->from($this->_name, array('id','room_number','seating_capacity'))	
                 //->joinLeft(array("opp" => "seating_operation"), "opp.room_no=$this->_name.id",array('allocated_seat'))
                   // ->where("opp.booking_date != ?",$date)
                  ->where("$this->_name.status =?",0)
                ->order("$this->_name.seating_capacity  ASC");
        $result = $this->getAdapter()->fetchAll($select);
        
         foreach ($result as $val) {
             if(!in_array($val['id'],$id))
                $data.='<option value="' . $val['id'] . '" >Room no. '. $val['room_number'].' | Seat Left Out '.($val['seating_capacity']). ' </option>';
        }
      
        
        return $data;
    }
    
    public function getDropDownRoomList(){
        $select = $this->_db->select()
        ->from($this->_name, array('id','room_no',))             
                ->where("status =?",0)
                ->order('room_no  ASC');
        $result = $this->getAdapter()->fetchAll($select);
        $data = array();
        $st_year ='';
        $end_year='';
        foreach ($result as $val) {
            
            $data[$val['id']] = $val['room_no'];
            
           // $data[$val['academic_id']] = substr($val['from_date']).'-'.substr($val['to_date']);
            //print_r($data);die;
        }
        return $data;
    }
    
}
