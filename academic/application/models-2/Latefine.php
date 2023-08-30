<?php



class Application_Model_Latefine extends Zend_Db_Table_Abstract {



    public $_name = 'late_fine';

    protected $_id = 'id';


 public function getRecord($id) {

        $select = $this->_db->select()

                ->from($this->_name)

                ->where("$this->_name.$this->_id =?", $id);

             

        $result = $this->getAdapter()

                ->fetchRow($select);

        return $result;

    }

    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name);
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;

    }

    public function isFine($stu_id,$academic_id,$term){
          $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.stu_id =?", $stu_id)
                ->where("$this->_name.term =?", $term)
                  ->where("$this->_name.f_code like?", 'ok')
                ->where("$this->_name.academic_id =?", $academic_id);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;

    }
    public function getPayRecords($id,$sem){
          $select = $this->_db->select()
                ->from($this->_name)
                 ->joinleft(array("declared_terms"),"declared_terms.term_des=$this->_name.term",array("term_name"))
                ->where("$this->_name.stu_id=?", $id)
                ->where("$this->_name.term=?", $sem)
                ->where("$this->_name.status=?", 1)
                ->order("id desc");
              
        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo $select;die;
          //echo"<pre>";print_r($result);die;
        return $result;
    }  
  public function getSemesterFeeInstallmentRecords($academic_id,$academic_year,$session,$sem){
      
      $select= "SELECT late_fine.*,atom_tb.*,erp_student_information.*,late_fine.id as lateid from late_fine JOIN atom_tb on atom_tb.form_id=late_fine.stu_id JOIN erp_student_information ON erp_student_information.stu_id=late_fine.stu_id WHERE late_fine.stu_id NOT IN(SELECT stu_id FROM `late_fine` WHERE `status` = 1 AND term='$sem') AND late_fine.term='$sem' AND late_fine.status=0 AND erp_student_information.stu_status=1 AND erp_student_information.academic_id IN ($academic_id) GROUP by late_fine.stu_id";

      
      
//            $select = $this->_db->select();
//                
//                $select->from('erp_student_information',array('stu_fname','stu_id','roll_no','exam_roll'));
//                $select->joinleft(array("late_fine"),"$this->_name.stu_id=erp_student_information.stu_id and $this->_name.term = '$sem'");
//                $select->join(array("atom_tb"),"$this->_name.stu_id=atom_tb.form_id");
//                $select->where("erp_student_information.academic_id =?",$academic_id);
//                $select->where("erp_student_information.stu_status =?",1);
//                $select->where("late_fine.status =?",0);
//                $select->group("erp_student_information.stu_id");
                //$select->order("$this->_name.id",'desc');
                //$select->limit("$this->_name.id",2);
        $result = $this->getAdapter()
                ->fetchAll($select);
      // echo $select;die;
            //echo"<pre>";print_r($result);die;
        return $result;
    }
}

