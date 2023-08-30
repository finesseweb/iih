<?php
/* 
 Author: Kedar Kumar
 Summary: This model is used for pwc entrance exam Applicant Information for Educational details.
 Date: 15 Jan. 2020
*/
//ini_set('display_errors', '1');
class Application_Model_ApplicantEducationalDetailModel extends Zend_Db_Table_Abstract {

    public $_name = 'applicant_educational_details';
    protected $_id = 'id'; 
    //This function gets all promotion rule data
    public function getRecords(){       
       
       
    } 
    public function getRecordById($id)
    {       
        $select=$this->_db->select()
            ->from($this->_name)
            ->where("$this->_name.id=?", $id);			   

            $result=$this->getAdapter()
            ->fetchRow($select);    
  		//echo"<pre>";print_r($result);die;	  
        return $result;
    }
    public function getsavedData($conditions){       
        $select=$this->_db->select()
            ->from(array($this->_name))   
            ->where("md5($this->_name.application_no)=?", $conditions);	 
            $result=$this->getAdapter()
            ->fetchRow($select);    
            //echo $select;die;
            //echo"<pre>";print_r($result);	  
        return $result;
    }
    
    public function trashItems($deleteId='') {
            $condition = array(
                'application_no = ?' => $deleteId,
            );
            $n = $this->_db->delete('applicant_educational_details', $condition);
            
        } 
        
        
         public function getAllUgCourseRejectedCount($year_id='',$dept_id=''){  
             $where='';
            
            $where="newdb.photo != 'deleted' and followup IS NULL AND applicant_course_details.degree_id=1";
            
            if($dept_id) {
              //  echo "hi";
              //  die();
                $where.= " AND applicant_course_details.course=$dept_id";
            }
            if($year_id) {
              //  echo "hi";
              //  die();
                $where.= " AND applicant_course_details.acad_year_id=$year_id";
            }
          $select="SELECT applicant_course_details.course,COUNT(newdb.application_no) from (SELECT applicant_documents_followup.application_no as followup,applicant_educational_details.application_no as edu, applicant_educational_details.*,applicant_documents_followup.course FROM `applicant_educational_details` LEFT JOIN applicant_documents_followup on applicant_documents_followup.application_no=applicant_educational_details.application_no ) as newdb LEFT
          JOIN applicant_course_details ON applicant_course_details.application_no=newdb.edu WHERE $where group by applicant_course_details.course";
            //$select->from(array($this->_name));  
          // $select->joinLeft(array('record'=>'applicant_documents_followup'),"record.application_no =$this->_name.application_no",array());
            
           // $select->joinleft(array("dept"=>"applicant_course_details"),"dept.course=record.course");
           
           // $select->where("record.application_no IS NULL");
            //$select->where("dept.course=?",1);
           // $select->group(array('applicant_payement_details.course'));
           // $select->order(array('department_type.degree_id'));
          ////  $result=$this->getAdapter()
            //->fetchAll($select); 
           $result = $this->getAdapter()
            ->fetchAll($select);
         // echo $select; die();
            return $result;
         
    }
    
    public function getAllStudentsRejectedCount($dept_id='',$acad_id="5"){  
             $where='';
           $acad_id =  empty($acad_id)?5:$acad_id;
            $where="newdb.photo != 'deleted' and followup IS NULL AND applicant_course_details.degree_id!=0";
            
            if($dept_id) {
              //  echo "hi";
              //  die();
                $where.= " AND applicant_course_details.course=$dept_id";
            }
          $select="SELECT * from (SELECT applicant_documents_followup.application_no as followup,applicant_educational_details.application_no as edu, applicant_educational_details.*,applicant_documents_followup.course FROM `applicant_educational_details` LEFT JOIN applicant_documents_followup on applicant_documents_followup.application_no=applicant_educational_details.application_no ) as newdb LEFT
          JOIN applicant_course_details ON applicant_course_details.application_no=newdb.edu WHERE $where ";
            //$select->from(array($this->_name));  
          // $select->joinLeft(array('record'=>'applicant_documents_followup'),"record.application_no =$this->_name.application_no",array());
            
           // $select->joinleft(array("dept"=>"applicant_course_details"),"dept.course=record.course");
           
           // $select->where("record.application_no IS NULL");
            //$select->where("dept.course=?",1);
           // $select->group(array('applicant_payement_details.course'));
           // $select->order(array('department_type.degree_id'));
          ////  $result=$this->getAdapter()
            //->fetchAll($select); 
            //echo $select; die();
           $result = $this->getAdapter()
            ->fetchAll($select);
         
            return $result;
         
    }
    
    
     public function getAlldData($application_no){       
        $select=$this->_db->select()
            ->from(array($this->_name))   
            ->where("$this->_name.application_no=?", $application_no);	 
            $result=$this->getAdapter()
            ->fetchRow($select);    
            //echo $select;die;
            //echo"<pre>";print_r($result);	  
        return $result;
    }
    
     public function getAllPgCourseRejectedCount($year_id='',$dept_id=''){  
             $where='';
            
            $where="newdb.photo != 'deleted' and followup IS NULL AND applicant_course_details.degree_id!=1";
            
            if($dept_id) {
              //  echo "hi";
              //  die();
                $where.= " AND applicant_course_details.course=$dept_id";
            }
          $select="SELECT applicant_course_details.course,COUNT(newdb.application_no) from (SELECT applicant_documents_followup.application_no as followup,applicant_educational_details.application_no as edu, applicant_educational_details.*,applicant_documents_followup.course FROM `applicant_educational_details` LEFT JOIN applicant_documents_followup on applicant_documents_followup.application_no=applicant_educational_details.application_no ) as newdb LEFT
          JOIN applicant_course_details ON applicant_course_details.application_no=newdb.edu WHERE $where group by applicant_course_details.course";
            //$select->from(array($this->_name));  
          // $select->joinLeft(array('record'=>'applicant_documents_followup'),"record.application_no =$this->_name.application_no",array());
            
           // $select->joinleft(array("dept"=>"applicant_course_details"),"dept.course=record.course");
           
           // $select->where("record.application_no IS NULL");
            //$select->where("dept.course=?",1);
           // $select->group(array('applicant_payement_details.course'));
           // $select->order(array('department_type.degree_id'));
          ////  $result=$this->getAdapter()
            //->fetchAll($select); 
           $result = $this->getAdapter()
            ->fetchAll($select);
         // echo $select; die();
            return $result;
         
    }
    }

?>
