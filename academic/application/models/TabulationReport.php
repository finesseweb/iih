<?php

/* tabulation_report
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_TabulationReport extends Zend_Db_Table_Abstract {

    public $_name = 'tabulation_report';
    protected $_id = 'tabl_id';

    //get details by record for edit
    public function getRecord($id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.$this->_id=?", $id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    public function trashItems($tabl_id) {
        $this->_db->delete("tabulation_report_items", "tabl_id=$tabl_id");
    }

    public function trashBackItems($tabl_id) {
        $this->_db->delete("back_tabulation_report_items", "tabl_id=$tabl_id");
    }

    //Get all records
    public function getRecords() {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where("$this->_name.status !=?", 2)
                ->order("$this->_name.$this->_id DESC");
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }

    public function getRecordsAcademicTerm($academic_id, $term_id, $paper = 'R') {
        $select = $this->_db->select()
                ->from($this->_name, array('tabl_id'))
                ->where("$this->_name.academic_id =?", $academic_id)
                ->where("$this->_name.term_id =?", $term_id)
                ->where("$this->_name.flag =?", $paper)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

     public function fetchStudentSgpa($academic_id, $term_id, $stu_id) {
        $select = $this->_db->select()
                ->from($this->_name, array('added_date'))
                ->joinLeft(array('btabl_items' => 'back_tabulation_report_items'), "btabl_items.tabl_id = $this->_name.tabl_id", array("GROUP_CONCAT(btabl_items.tabl_id) as btbl_id","GROUP_CONCAT(publish_date) as publish_date"))
                ->joinLeft(array('tabl_items' => 'tabulation_report_items'), "tabl_items.tabl_id = $this->_name.tabl_id")
                ->where("$this->_name.academic_id =?", $academic_id)
                ->where("$this->_name.term_id =?", $term_id)
                ->where("$this->_name.status !=?", 2)
                ->where("(tabl_items.student_id =?", $stu_id)
                ->orWhere("btabl_items.student_id =?)", $stu_id);
        $result = $this->getAdapter()
                ->fetchRow($select);
                if(empty($result['tabl_id'])){
                    $tabresult = $this->getTablIdRegular($academic_id, $term_id,$stu_id);
                     $result['tabl_id'] = $tabresult[0]['tabl_id'];
                     $result['promotion_text'] = $tabresult[0]['promotion_text'];
                     $result['fail_in_ct_ids'] = $tabresult[0]['fail_in_ct_ids'];
                }
        return $result;
    }
    
   

    public function fetchBackStudentSgpa($academic_id, $term_id, $stu_id) {
        $select = $this->_db->select()
                ->from($this->_name, array('tabl_id', 'added_date'))
                ->joinLeft(array('tabl_items' => 'back_tabulation_report_items'), "tabl_items.tabl_id = $this->_name.tabl_id")
                ->where("$this->_name.academic_id =?", $academic_id)
                ->where("$this->_name.term_id =?", $term_id)
                ->where("$this->_name.flag =?", 'B')
                ->where("tabl_items.student_id =?", $stu_id)
                ->where("$this->_name.status !=?", 2);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    //Added by kedar to get term
    public function getTermIdByTablId($tablId) {
        $select = $this->_db->select();
        $select->from($this->_name, array('term_id', 'added_date'));

        $select->where("$this->_name.tabl_id =?", $tablId);

        $select->where("$this->_name.status !=?", 2);
        // echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    public function getTablId($acad, $termId) {
        $select = $this->_db->select();
        $select->from($this->_name, array('tabl_id', 'added_date', 'flag'));

        $select->where("$this->_name.academic_id =?", $acad);
        $select->where("$this->_name.term_id =?", $termId);
        //$select->where("$this->_name.flag =?", 'R');

        $select->where("$this->_name.status !=?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
     public function getTablIdRegular($acad, $termId,$stu_id) {
        $select = $this->_db->select();
        $select->from($this->_name, array('tabl_id', 'added_date', 'flag'));
        if($stu_id){
         $select->joinLeft(array('tabl_items' => 'tabulation_report_items'), "tabl_items.tabl_id = $this->_name.tabl_id",array("promotion_text"));
        $select->where("tabl_items.student_id =?", $stu_id);
        }
        $select->where("$this->_name.academic_id =?", $acad);
        $select->where("$this->_name.term_id =?", $termId);
        $select->where("$this->_name.flag =?", 'R');

        $select->where("$this->_name.status !=?", 2);
       // echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    public function getTablIdForFilter($acad, $termId) {
        $select = $this->_db->select();
        $select->from($this->_name, array('tabl_id', 'added_date', 'flag'));

        $select->where("$this->_name.academic_id =?", $acad);
        $select->where("$this->_name.term_id =?", $termId);
        $select->where("$this->_name.flag =?", 'R');

        $select->where("$this->_name.status !=?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }
    public function getTablIdForYear($acad, $termArr) {
        $select = $this->_db->select();
        $select->from($this->_name, array('tabl_id', 'added_date', 'flag'));

        $select->where("$this->_name.academic_id =?", $acad);
        $select->where("$this->_name.term_id in(?)", $termArr);
        $select->where("$this->_name.flag =?", 'R');
        $select->where("$this->_name.status !=?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    public function getBackTablIdForFilter($acad, $termId) {
        $select = $this->_db->select();
        $select->from($this->_name, array('tabl_id', 'added_date', 'flag'));

        $select->where("$this->_name.academic_id =?", $acad);
        $select->where("$this->_name.term_id =?", $termId);
        $select->where("$this->_name.flag =?", 'B');

        $select->where("$this->_name.status !=?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    public function getMaxDate($nonTbl = '', $revalTbl = '') {
        //echo '<pre>';print_r($revalTbl);exit;
        $select = $this->_db->select()
                ->from($this->_name, array("max(added_date) as followupdate"));
        if (!empty($nonTbl)) {
            $select->orwhere("$this->_name.tabl_id=?", $nonTbl);
        }
        if (!empty($revalTbl)) {
            $select->orwhere("$this->_name.tabl_id=?", $revalTbl);
        }
        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchRow($select);

        return $result;
    }

    //Pass Fail Report : Date: 09 April 2021 : Kedar
    public function getFailStudents($term_id, $acad_id) {
        $stu_status = ['1', '6'];
        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("student_id", 'sgpa', "Group_Concat(distinct(tr_items.student_id)) as students"))
                ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
                ->where("$this->_name.term_id=?", $term_id)
                ->where("$this->_name.academic_id=?", $acad_id)
                //->where("erp_student.stu_status IN(?)", $stu_status)
                ->where("$this->_name.flag like ?", 'R')
                ->where("tr_items.sgpa  =?", 0.0)
                ->group("tr_items.student_id");
        //->where("$this->_name.status !=?", 2);
        //echo $select;die;
        $result = $this->getAdapter()
                ->fetchAll($select);

        //secho '<pre>';print_r($result);exit;

        return $result;
    }

    public function getPassStudents($term_id, $acad_id) {
        $stu_status = ['1', '6'];
        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("student_id", 'sgpa', "Group_Concat(distinct(tr_items.student_id)) as students"))
                ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
                ->where("$this->_name.term_id=?", $term_id)
                ->where("$this->_name.academic_id=?", $acad_id)
                //->where("erp_student.stu_status IN(?)", $stu_status)
                ->where("$this->_name.flag like ?", 'R')
                ->where("tr_items.sgpa != ?", 0.0)
                ->group("tr_items.student_id");

        //->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
                ->fetchAll($select);
        //echo $select;die;


        return $result;
    }
    public function getAppearStudents($term_id, $acad_id) {
        $stu_status = ['1', '6'];
        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("student_id", 'sgpa', "Group_Concat(distinct(tr_items.student_id)) as students"))
                ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
                ->where("$this->_name.term_id=?", $term_id)
                ->where("$this->_name.academic_id=?", $acad_id)
                //->where("erp_student.stu_status IN(?)", $stu_status)
                ->where("$this->_name.flag like ?", 'R')
               // ->where("tr_items.sgpa != ?", 0.0)
                ->group("tr_items.student_id");
        //->where("$this->_name.status !=?", 2);

        $result = $this->getAdapter()
                ->fetchAll($select);
      //  echo "<pre>".$select;die;


        return $result;
    }
    
    
     public function getAppearsAllStudentscmnterms($session,$department,$cmn_terms,$students_id = array()) {
        $select = $this->_db->select();
            $select->from($this->_name);
            $select->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array());
            $select->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array("erp_student.*"));
            $select->join(array("batch" => "academic_master"), "batch.academic_year_id = $this->_name.academic_id");
            $select->join(array("depart" => "department"), "depart.id = batch.department", array("depart.short_code"));
            $select->join(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array());
            $select->where("term.cmn_terms in (?)", $cmn_terms);
            $select->where("batch.session = ?", $session);
            $select->where("batch.department in (?)", $department);
            if($students_id)
            $select->where("tr_items.student_id not in (?)", $students_id);
            $select->where("$this->_name.flag like ?", 'R');
            $select->order("$this->_name.academic_id ASC");
           // echo "<pre>".$select; die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    public function getTotalStudents($cmn_terms, $acad_id) {
        $cmn_terms = $cmn_terms != 't1' ? (int) substr($cmn_terms, (strlen($cmn_terms) - 1)) : 1;
        $cmn_terms = $cmn_terms == 1 ? 't1' : "t" . ($cmn_terms - 1);
        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("count(erp_student.student_id) as active_students"))
                ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
                ->join(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array())
                ->where("term.cmn_terms = ?", $cmn_terms)
                ->where("$this->_name.academic_id in (?)", $acad_id)
                ->where("$this->_name.flag like ?", 'R');

        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    public function getPassStudentscmnterms($cmn_terms, $acad_id) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("count(erp_student.student_id) as pass_students"))
                ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
                ->join(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array())
                ->where("term.cmn_terms = ?", $cmn_terms)
                ->where("$this->_name.academic_id in (?)", $acad_id)
                ->where("$this->_name.flag like ?", 'R')
                ->where("tr_items.sgpa != ?", 0.0);
        $result = $this->getAdapter()
                ->fetchRow($select);
        return $result;
    }

    public function getPassAllStudentscmnterms($cmn_terms, $acad_id) {
        $select = $this->_db->select()
            ->from($this->_name)
            ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("count(erp_student.student_id) as pass_students"))
            ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
            ->join(array("batch" => "academic_master"), "batch.academic_year_id = $this->_name.academic_id")
            ->join(array("depart" => "department"), "depart.id = batch.department", array("depart.short_code"))
            ->join(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array())
            ->where("term.cmn_terms = ?", $cmn_terms)
            ->where("$this->_name.academic_id in (?)", $acad_id)
            ->where("$this->_name.flag like ?", 'R')
            ->where("tr_items.sgpa != ?", 0.0)
            ->group("$this->_name.academic_id")->order("$this->_name.academic_id ASC");
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }

    public function getTop3Students($cmn_terms, $acad_id) {
        $acad_id = implode(',', $acad_id);
        $sql = "select t.*,department.short_code,erp_student_information.filename,erp_student_information.stu_fname from (select student_id,tabl_id, sgpa,
       (@num:=if(@group = `tabl_id`, @num +1, if(@group := `tabl_id`, 1, 1))) row_number 
        from tabulation_report_items x
       CROSS JOIN (select @num:=0, @group:=null) c ORDER BY x.tabl_id,x.`sgpa` desc) as t
  join tabulation_report on tabulation_report.tabl_id = t.tabl_id
  join erp_student_information on erp_student_information.student_id = t.student_id
  join term_master on term_master.term_id = tabulation_report.term_id
  join academic_master on academic_master.academic_year_id = tabulation_report.academic_id
  join department on department.id = academic_master.department
  where t.row_number <= 1  and term_master.cmn_terms like '$cmn_terms' and academic_master.academic_year_id in ($acad_id) ";

        $stmt = $this->_db->query($sql);

        $rows = $stmt->fetchAll();
        return $rows;
    }

    public function getTop($session, $cmn_terms, $department_type, $limit = 3) {



        $sql = "select t.*,department.short_code from (select student_id,tabl_id, sgpa,
       (@num:=if(@group = `tabl_id`, @num +1, if(@group := `tabl_id`, 1, 1))) row_number 
        from tabulation_report_items x
       CROSS JOIN (select @num:=0, @group:=null) c ORDER BY x.tabl_id,x.`sgpa` desc) as t
  join tabulation_report on tabulation_report.tabl_id = t.tabl_id
  join term_master on term_master.term_id = tabulation_report.term_id
  join academic_master on academic_master.academic_year_id = tabulation_report.academic_id
  join department on department.id = academic_master.department
  where t.row_number <= ?  and term_master.cmn_terms like ? and department.department_type = ? and academic_master.session = ?";

        $stmt = $this->_db->query($sql, array($limit, $cmn_terms, $department_type, $session));
        $rows = $stmt->fetchAll();
        return $rows;
    }

    public function getFailStudentscmnterms($cmn_terms, $acad_id) {
        $select = $this->_db->select()
                        ->from($this->_name)
                        ->join(array("tr_items" => "tabulation_report_items"), "tr_items.tabl_id=$this->_name.tabl_id", array("count(erp_student.student_id) as fail_students"))
                        ->join(array("erp_student" => "erp_student_information"), "erp_student.student_id=tr_items.student_id", array())
                        ->join(array("batch" => "academic_master"), "batch.academic_year_id = $this->_name.academic_id", array())
                        ->join(array("depart" => "department"), "depart.id = batch.department", array("depart.short_code"))
                        ->join(array("term" => "term_master"), "term.term_id=$this->_name.term_id", array())
                        ->where("term.cmn_terms = ?", $cmn_terms)
                        ->where("$this->_name.academic_id in (?)", $acad_id)
                        ->where("$this->_name.flag like ?", 'R')
                        ->where("tr_items.sgpa = ?", 0.0)
                        ->group("$this->_name.academic_id")->order("$this->_name.academic_id ASC");
        // echo $select; die;
        $result = $this->getAdapter()
                ->fetchAll($select);
        return $result;
    }
    
    public function getnotPromotedStudents($session,$department,$cmn_terms){
        $select = "SELECT
    academic_master.short_code,
    erp_student_information.stu_fname,
    erp_student_information.stu_id,
    erp_student_information.exam_roll
FROM
    tabulation_report_items,
    erp_student_information,
    academic_master
WHERE
    erp_student_information.student_id = tabulation_report_items.student_id AND academic_master.academic_year_id = erp_student_information.academic_id AND tabulation_report_items.tabl_id IN(
    SELECT
        *
    FROM
        (
        SELECT
            tabulation_report.tabl_id
        FROM
            `academic_master`,
            tabulation_report,
            term_master
        WHERE
            tabulation_report.academic_id = academic_master.academic_year_id AND tabulation_report.term_id = term_master.term_id AND academic_master.`session` IN('$session') AND flag = 'r' AND term_master.cmn_terms IN('$cmn_terms') AND academic_master.department IN('$department')
    ) AS newtb
) AND tabulation_report_items.final_remarks LIKE 'F'";
   $result=$this->getAdapter()
                      ->fetchAll($select);  
            return $result;

    }

}
