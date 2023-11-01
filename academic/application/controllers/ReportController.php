<?php

//ini_set('display_errors', '1');
/**
 * @Framework Zend Framework
 * @Powered By Finesse 
 * @category   ERP Product
 * Authors Ashutosh and Kedar
 */
class ReportController extends Zend_Controller_Action {

    private $_siteurl = null;
    private $sub_title_name = null;
    private $_db = null;
    private $_flashMessenger = null;
    private $_authontication = null;
    private $_agentsdata = null;
    private $_usersdata = null;
    private $_act = null;
    private $_adminsettings = null;
    private $_checkUser = null;
    private $accessConfig = NULL;
    private $_base_url = NULL;
    private $_month = NULL;
    private $_month_num = NULL;
    private $exam_month = NULL;

    public function init() {
        $zendConfig = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        require_once APPLICATION_PATH . '/configs/access_level.inc';

        $this->accessConfig = new accessLevel();
        $config = $zendConfig->mainconfig->toArray();
        $this->view->mainconfig = $config;
        $this->_action = $this->getRequest()->getActionName();
        $this->aeccConfig = $config_role = $zendConfig->aecc_course->toArray();
        $this->exam_month = $config_role = $zendConfig->exam_month->toArray();

        $this->_month = $this->exam_month[0];
        $this->_month_num = $this->exam_month[1];
        //access role id
		 $this->studentConfig = $zendConfig->student_holiday_controller->toArray();
        $this->holidayCategory = $holiday_category = $zendConfig->holiday_category->toArray();
        $this->roleConfig = $config_role = $zendConfig->role_administrator->toArray();
        $this->view->administrator_role = $config_role;
        $storage = new Zend_Session_Namespace("admin_login");
        $this->login_storage = $data = $storage->admin_login;
        $this->view->login_storage = $data;

        $this->_base_url = $config['host'];
        //print_r($data);exit;
        if (isset($data)) {
            $this->view->role_id = $data->role_id;
            $this->view->login_empl_id = $data->empl_id;
        }
        if ($this->_action == "login" || $this->_action == "forgot-password") {
            $this->_helper->layout->setLayout("adminlogin");
        } else {
            $this->_helper->layout->setLayout("layout");
        }
        $this->_act = new Application_Model_Adminactions();
        $this->_db = Zend_Db_Table::getDefaultAdapter();
        $this->_flashMessenger = $this->_helper->FlashMessenger;

        $this->_checkUser = $user = $_POST['username'];
        $password = $_POST['password'];

        if ($user != 'admin' && $password != 'admin@123') {
            $this->authonticate();
        }
    }

    protected function authonticate() {
        $storage = new Zend_Session_Namespace("admin_login");
        $data = $storage->admin_login;
        if ($data->role_id == 0)
            $this->_redirect("student-portal/student-dashboard");
        if (!$data && $this->_action != 'login' &&
                $this->_action != 'forgot-password') {
            $this->_redirect('index/login');
            return;
        }
        if ($this->_action != 'forgot-password') {
            $this->_authontication = $data;
            $this->_agentsdata = $storage->agents_data;
        }
    }

    //follow up
    public function reportAction() {
        $this->accessConfig->setAccess("SA_ACAD_GRADE_REPORT");

        $this->view->action_name = 'enquiry';
        $this->view->sub_title_name = 'report';
        $Report_model = new Application_Model_Report();
        $Report_form = new Application_Form_Report();
        //$Followup_id = $this->_getParam("id");
        $type = $this->_getParam("type");

        $date = new Zend_Date();
        $currentDate = $date->toString('Y-MM-d');
        $this->view->currentDate = $currentDate;
        $startYear = $date->toString('Y');
        $nextYear = $startYear + 1;
        $AcademicYear = $startYear . '-' . $nextYear;

        $NextYear1 = $nextYear + 1;
        $NextYear = $nextYear . '-' . $NextYear1;

        $this->view->AcademicYear = $AcademicYear;
        $this->view->NextYear = $NextYear;
        switch ($type) {
            case "search":
                $this->view->type = $type;
                $this->view->Report_form = $Report_form;
                // $data = $this->getRequest()->getPost();

                if ($this->getRequest()->isPost()) {
                    if ($Report_form->isValid($this->getRequest()->getPost())) {
                        $data = $Report_form->getValues();
                        $export = $this->getRequest()->getPost('export');

                        $branch = '';
                        $search_type = $data['search_type'];
                        $country = $data['country_id'];
                        $state = $data['state_id'];
                        $city = $data['city_id'];
                        $location = $data['location_id'];
                        $branch_id = $data['branch_id'];
                        if (is_array($branch_id)) {
                            $branch = implode(',', $branch_id);
                        }



                        $from_date = $data['from_date'];

                        $to_date = $data['to_date'];

                        $academic_year = $data['academic_year'];

                        $program = $data['program_id'];

                        $subprogram = $data['subprogram_id'];

                        $frequency = $data['frequency_id'];

                        $counselor = $data['counselor_id'];

                        $why_esperanza = $data['why_esperanza'];

                        $how_know_esperanza = $data['how_know_esperanza'];

                        $type_of_enquiry = $data['type_of_enquiry'];

                        $source_of_enquiry = $data['source_of_enquiry'];

                        $enquiry_mindset = $data['enquiry_mind_set'];

                        $enquiry_date = $data['enquiry_date'];

                        $occupation_id = $data['occupation_id'];

                        $company_id = $data['company_id'];

                        $reference = $data['reference'];
                        $searchResult = $Report_model->getSearchRecords($search_type, $country, $state, $city, $location, $branch, $from_date, $to_date, $academic_year, $program, $subprogram, $frequency, $counselor, $why_esperanza, $how_know_esperanza, $type_of_enquiry, $source_of_enquiry, $enquiry_mindset, $enquiry_date, $occupation_id, $company_id, $reference);
                        $val = $Report_form->populate($data);

                        $this->view->searchResult = $searchResult;
                        if (isset($export)) {
                            $exportResult = $Report_model->getExportSearchRecords($search_type, $country, $state, $city, $location, $branch, $from_date, $to_date, $academic_year, $program, $subprogram, $frequency, $counselor, $why_esperanza, $how_know_esperanza, $type_of_enquiry, $source_of_enquiry, $enquiry_mindset, $enquiry_date, $occupation_id, $company_id, $reference);

                            //echo "<pre>";print_r($exportResult);die;
                            $heading = array("Country", "State", "City", "Location", "Branch", "Counselor", "Academic Year", "Enquiry ID", "Enquiry Date & Time", "Next Followed Up Date", "Child Name", "Father Name", "Mother Name", "Fathers Mobile", "Mothers Mobile", "Fathers Email", "Mothers Email", "Subprogram", "Frequency", "Fathers Company", "Mothers Company", "Father Occupation Name", "Mother Occupation Name", "Type of Enquiry", "Source of Enquiry", "Enquiry Mindset", "Why Us", "How do you know about us", "Reference", "Comments");
                            $exceldata = $exportResult;

                            $this->_act->createExcel($heading, $exceldata, "Enquiry Details");
                        }
                    }
                } else {
                    $this->_redirect('report/report');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $this->view->Report_form = $Report_form;
                $result = $Report_model->getRecords();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function getEnquiryVewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $id = $this->_getParam("id");
            if ($id) {
                $Enquiry_Model = new Application_Model_Enquiry();
                $EnquiryItems_model = new Application_Model_EnquiryItems();
                $result = $Enquiry_Model->getEnquiryInfoForReport($id);
                $EnquiryItems_info = $EnquiryItems_model->getItemRecord($result['enquiry_id']);
                //$fees_type=$Fees_type_model->getRecords();	

                $this->view->enquiry_info = $result;
                $this->view->item_info = $EnquiryItems_info;
                //$this->view->fees_type = $fees_type;
            }
        }
    }
    public function casteCategoryReportAction() {
        $this->view->action_name = 'formFee';
        $this->view->sub_title_name = 'formFee';
        $this->accessConfig->setAccess('SA_ACAD_FORMFEECOLL');
        $student_report_form = new Application_Form_StudentsFees();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $studetails = new Application_Model_StudentPortal();
        $semFeeModel = new Application_Model_ExamformSubmissionModel();
        $NonCollsemFeeModel = new Application_Model_UgNonformSubmissionModel();
        $semFeePayModel = new Application_Model_ExamfeeSubmitModel();
        $nonCollsemFeePayModel = new Application_Model_NonColpayment();
        $feesupdation = new Application_Model_FeesUpdation();
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }
    
        public function ajaxGetCasteCategoryViewAction() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $cmn_terms = $this->_getParam("cmn_terms");
            $country = $this->_getParam("country");
            $state = $this->_getParam("state");
            $religion = $this->_getParam("religion");
            
            $this->view->castcategory = $student_model->getCasteCategory($session_id);
            if ($session_id) {
                
                $result =  $student_model->getCasteCategoryTotal(implode("','", $session_id),$cmn_terms,$country,implode("','",$state),implode("','",$religion));
                $this->view->country = $country;
                $this->view->state = implode(",",$state);
                $this->view->terms = $cmn_terms;
                $this->view->religion = implode(",",$religion);
                $this->view->paginator = $result;
            }
        }
}
    
    public function studentDetailsAction() {
        $this->view->action_name = 'examreport';
        $this->view->sub_title_name = 'examreport';
        $this->accessConfig->setAccess('SA_ACAD_SHEET');
        $student_form = new Application_Form_ElectiveSelection();
        ;
        $this->view->form = $student_form;
        $student_model = new Application_Model_StudentPortal();
        /* $result = $student_model->getRecordsfordetails();
          //echo "<pre>";print_r($result);exit;
          $this->view->paginator = $result; */
    }

    public function ajaxGetStudentByDeptAction() {
//        $this->_helper->layout->disableLayout();
//        $student_model = new Application_Model_StudentPortal();
//        $term_master = new Application_Model_TermMaster();
//        $Elective_model = new Application_Model_ElectiveSelection();
//        $course_credit_master = new Application_Model_Corecourselearning();
//        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
//        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
//            $session_id = $this->_getParam("session_id");
//            $department_id = $this->_getParam("department_id");
//            $degree_id = $this->_getParam("degree_id");
//            
//           
//            
//            if ($session_id) {
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result = $student_model->getRecordsBySession($session_id,$department_id);
//                $this->view->paginator = $result;
//            }
//        }


        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam("term_id");
            $cmn_terms = $term_id;
            $course_id = $this->_getParam("course_id");
            $col = $this->_getParam("col");
            $type = $this->_getParam("examtype");
            $attendance = $this->_getParam('attend');
            $course_code = $this->_getParam("course_code");
            $exmtype = $this->_getParam("exmtype");
            $month = $this->_getParam("month");
            $StudentPortal_model = new Application_Model_ElectiveSelectionItems();
            $backStudentElective = new Application_Model_BackSelectionItems();
            $coursede = new Application_Model_ApplicantCourseDetailModel();
            $course_model = new Application_Model_Course();
            $term_master = new Application_Model_TermMaster();

            $term_id = $term_master->getTermRecordsbycmnelective($academic_year_id, $term_id);
            $academic_year_id = implode(',', $academic_year_id);
            if ($col == 1) {
                if ($course_id != 0) {

                    $result = $StudentPortal_model->getelectivestudentDetails1($academic_year_id, $cmn_terms, explode('_', $course_id)[0], $type, $attendance);
                   // echo "<pre>";print_r($result);exit;
                } else {
                    $student_model = new Application_Model_StudentPortal();
                    $result = $student_model->getstudentsbyacademics($academic_year_id, $cmn_terms, $type, $attendance);
                   // echo "<pre>";print_r($result);exit;
                }
            } else if ($col == 2) {

                if ($course_id != 0) {
                    $result = $backStudentElective->getelectivestudentDetails1($academic_year_id, $term_id, explode('_', $course_id)[0], 1, $type, $month);
                } else {
                    $course = $course_model->getCourseCode($course_code);
                    $result = $backStudentElective->getelectivestudentDetails1($academic_year_id, $term_id, explode('_', $course_id)[1], 0, $type, $month);
                }
            } else {

                $result = $coursede->getRecordByCourse($academic_year_id);
            }
       //  echo "<pre>";print_r($result); die(); 
            $this->view->paginator = $result;
             $this->view->exmtype=$exmtype;
        }
    }

    public function studentreportAction() {
        $this->view->action_name = 'studentreport';
        $this->view->sub_title_name = 'studentreport';
        $this->accessConfig->setAccess('SA_ACAD_FINAL_GRADE');
        $student_report_form = new Application_Form_StudentReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }
    
    public function studentfailreportAction(){
   //     
        $this->view->action_name = 'studentfailreport';
        $this->view->sub_title_name = 'studentfailreport';
       // $this->accessConfig->setAccess('SA_ACAD_FINAL_GRADE');
        $student_report_form = new Application_Form_StudentFailReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
       // echo "hii"; die;
    }
    
    public function notpromotedreportAction(){
   //     
        $this->view->action_name = 'notpromotedreport';
        $this->view->sub_title_name = 'notpromotedreport';
        $this->accessConfig->setAccess('SA_ACAD_NONPROM');
        $student_report_form = new Application_Form_Notpromotedreport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
       // echo "hii"; die;
    }
    
    public function viewcgpawisetoplistAction() {
        $this->view->action_name = 'finalresult';
        $this->view->sub_title_name = 'finalresult';
        $this->accessConfig->setAccess('SA_ACAD_FINAL_GRADE');
        $student_report_form = new Application_Form_StudentReport();
        $result_model = new Application_Model_FinalResult();
        $academic_id = $this->_getParam("acad");
        $limit = $this->_getParam("limit");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
        $topresult = $result_model->getTopRecordByAcdemic($academic_id, $limit);
        $this->view->topresult = $topresult;
        // print_r($topresult);die();
    }

    public function generatefinalresultAction() {
        $this->view->action_name = 'finalresult';
        $this->view->sub_title_name = 'finalresult';
        $this->accessConfig->setAccess('SA_ACAD_FINAL_GRADE');
        $student_report_form = new Application_Form_StudentReport();
        $result_model = new Application_Model_FinalResult();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;

        switch ($type) {
            case "save":

                break;
            default:
                if ($this->getRequest()->isPost()) {
                    if (isset($_POST)) {
                        //echo count($_POST['stu_id']);
                        //  die();
                        $record = $result_model->getRecordByAcdemic($_POST['academic_year_id']);
                        if ($record) {
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Selected Academic already exist ');
                            $this->_redirect('report/generatefinalresult');
                        } else {
                            for ($i = 0; $i < count($_POST['stu_id']); $i++) {
                                $insertdata = array(
                                    'academic_year_id' => $_POST['academic_year_id'],
                                    'stu_id' => $_POST['stu_id'][$i],
                                    'stu_name' => $_POST['stu_name'][$i],
                                    'added_year' => $_POST['added_year'][$i],
                                    'added_month' => $_POST['added_month'][$i],
                                    'total_sgpc' => $_POST['total_sgpc'][$i],
                                    'total_cgpa' => $_POST['total_cgpa'][$i]
                                );
                                $result_model->insert($insertdata);
                            }
                        }
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('report/generatefinalresult');
                    }
                }
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $this->view->form = $student_report_form;
                //die();

                break;
        }
    }


public function studentProficencyReportAction(){
         $this->view->action_name = 'AdmissionReport';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_ATTENDANCE_REPORT');
         $payment_form = new Application_Form_ExamDateForm();
        $this->view->form = $payment_form;
        $result_model = new Application_Model_FinalResult();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;

        switch ($type) {
            case "save":

                break;
            default:
                if ($this->getRequest()->isPost()) {
                    if (isset($_POST)) {
                        //echo count($_POST['stu_id']);
                        //  die();
                        $record = $result_model->getRecordByAcdemic($_POST['academic_year_id']);
                        if ($record) {
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Selected Academic already exist ');
                            $this->_redirect('report/generatefinalresult');
                        } else {
                            for ($i = 0; $i < count($_POST['stu_id']); $i++) {
                                $insertdata = array(
                                    'academic_year_id' => $_POST['academic_year_id'],
                                    'stu_id' => $_POST['stu_id'][$i],
                                    'stu_name' => $_POST['stu_name'][$i],
                                    'added_year' => $_POST['added_year'][$i],
                                    'added_month' => $_POST['added_month'][$i],
                                    'total_sgpc' => $_POST['total_sgpc'][$i],
                                    'total_cgpa' => $_POST['total_cgpa'][$i]
                                );
                                $result_model->insert($insertdata);
                            }
                        }
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('report/generatefinalresult');
                    }
                }
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                //die();

                break;
        }
}

    public function studentTermReportAction() {
        $this->view->action_name = 'student-term-report';
        $this->view->sub_title_name = 'student-term-report';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_StudentReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    public function studentAttendanceReportAction() {
        $this->view->action_name = 'student-term-report';
        $this->view->sub_title_name = 'student-term-report';
        $this->accessConfig->setAccess('SA_ACAD_ATTENDANCE_REPORT');
        $student_report_form = new Application_Form_StudentReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    public function studentBackTermReportAction() {
        $this->view->action_name = 'student-term-report';
        $this->view->sub_title_name = 'studentBackReport';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_StudentReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    public function ajaxGetStudentNamesAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            if ($academic_year_id) {
                $StudentPortal_model = new Application_Model_StudentPortal();
                $student_data = $StudentPortal_model->getStudentNames($academic_year_id);
                //print_r($SubProgram);die;
                echo '<option value="">Select Student</option>';
                foreach ($student_data as $k => $val) {
                    echo '<option value="' . $k . '" >' . $val . '</option>';
                }
                die;
            }
        }
    }

    public function ajaxGetInfoAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session");
            if ($session_id) {
                $StudentPortal_model = new Application_Model_StudentPortal();
                $stu_country_info = $StudentPortal_model->getCounrtyInfo($session_id);
                $info = array();
                $info['country'] = explode(",",$stu_country_info['country']);
                $info['state'] = explode(",",$stu_country_info['state']);
                $info['religion'] = explode(",",$stu_country_info['religion']);
                echo json_encode($info);die;
            }
        }
    }

    public function ajaxValidateDirectGradeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam("term_id");
            $course_id = $this->_getParam("course_id");
            $student_id = $this->_getParam("student_id");
            if ($academic_year_id && $term_id && $course_id && $student_id) {
                $DirectFinalGrade_model = new Application_Model_DirectFinalGrade();
                echo $DirectFinalGrade_model->isGradeExist($academic_year_id, $term_id, $course_id, $student_id);

                die;
            }
        }
    }
    
    

    

    public function getAttendanceReportAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department = $this->_getParam("department");
            $course_id = $this->_getParam("course_id");
            $ge_id = $this->_getParam("ge_id");
            $cc_id = $this->_getParam("cc_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $monthFrom = $this->_getParam('monthFrom');
            $monthTo = $this->_getParam('monthTo');
            $academic_id = $this->_getParam('academic_id');
            $practical_id = $this->_getParam("practical");
            $section = $this->_getParam("section");
            $this->view->department = $department;
            $this->view->course_id = $course_id;
            $this->view->ge_id = $ge_id;
            $this->view->cc_id = $cc_id;
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $this->view->monthFrom = $monthFrom;
            $this->view->monthTo = $monthTo;
            $this->view->practical = $practical_id;
            $this->view->section = $section;

            $this->view->academic_id = $academic_id;
        }
    }
    
    
     public function getStudentFailReportAction() {
        $this->_helper->layout->disableLayout();
        $grade_allocation = new Application_Model_GradeAllocationItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session = $this->_getParam("session");
            $department = $this->_getParam("department");
            $cmn_terms_arr = $this->_getParam("cmn_terms");
            $cmn_terms = "('".implode("','",$cmn_terms_arr)."')";
            $fail_no_subject = $this->_getParam("fail_no");
            $result  = $grade_allocation->getStudentFailDetailsAll($session,$department,$cmn_terms,$fail_no_subject);
            // echo '<pre>'; print_R($result);exit;
            $this->view->session = $session;
            $this->view->department = $department;
            $this->view->terms = implode("_",$cmn_terms_arr);
            $this->view->fail_no = $fail_no_subject;
            $this->view->result = $result;
        }
    }
    
    
         public function getNotPromotedReportAction() {
        $this->_helper->layout->disableLayout();
        $TabulationReport = new Application_Model_TabulationReport();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_arr = $this->_getParam("session");
            $department_arr = $this->_getParam("department");
            $cmn_terms_arr = $this->_getParam("cmn_terms");
            $cmn_terms = implode("','",$cmn_terms_arr);
            $session = implode("','",$session_arr);
            $department = implode("','",$department_arr);
            $fail_no_subject = $this->_getParam("fail_no");
            $result  = $TabulationReport->getnotPromotedStudents($session,$department,$cmn_terms);
            // echo '<pre>'; print_R($result);exit;
            $this->view->session = $session;
            $this->view->department = $department;
            $this->view->terms = implode("_",$cmn_terms_arr);
            $this->view->result = $result;
        }
    }
    
     public function failreportAction() {
          $grade_allocation = new Application_Model_GradeAllocationItems();
           $fail_no_subject = $this->_getParam("fno");
            $session = $this->_getParam("session");
            $student_id = $this->_getParam("id");
             $cmn_terms = explode("_",$this->_getParam("terms"));
             $cmn_terms = "('".implode("','",$cmn_terms)."')";
              $department = $this->_getParam("department");
            $result  = $grade_allocation->getStudentFailDetailsAll($session,$department,$cmn_terms,$fail_no_subject,$student_id);
            $this->view->result = $result;
            $htmlcontent = $this->view->render('report/ajax-get-fail-view.phtml');
            echo $htmlcontent;die;
         
     }
     
     
     public function studentreportcategoryAction(){
       
          $student_model = new Application_Model_StudentPortal();
            $flag = $this->_getParam("fl");
            $cast_category = $this->_getParam("cc");
            $academic_id = $this->_getParam("amid");
            $cmn_terms = $this->_getParam("term");
            $country = $this->_getParam("country");
            $state = explode(",",$this->_getParam("state"));
            $religion = explode(",",$this->_getParam("religion"));
            
            if($flag == 1){
            $result  = $student_model->getstudentdetailsAll($academic_id,$cmn_terms,$country,implode("','",$state),implode("','",$religion),$cast_category,'');
            }
            else if($flag == 2)
            {
            $result  = $student_model->getstudentdetailsAll($academic_id,$cmn_terms,$country,implode("','",$state),implode("','",$religion),$cast_category,'=1');
            }
            else if($flag==3)
            {
            $result  = $student_model->getstudentdetailsAll($academic_id,$cmn_terms,$country,implode("','",$state),implode("','",$religion),$cast_category,'>1');
            }
            else
            {
              $result  = $student_model->getstudentdetailsAll($academic_id,$cmn_terms,$country,implode("','",$state),implode("','",$religion),$cast_category,'!=0');  
            }
        //    echo "<pre>";print_r($result);exit;
            $this->view->result = $result;
            $this->view->roll = 1;
            $htmlcontent = $this->view->render('report/ajax-get-appear-view.phtml');
            echo $htmlcontent;die;
         
         
     }
     
     
         public function promotionreportAction() {
          $grade_allocation = new Application_Model_GradeAllocationItems();
           $fail_no_subject = $this->_getParam("fno");
            $session = $this->_getParam("session");
            $student_id = $this->_getParam("id");
            $date = $this->_getParam("date");
             $cmn_terms = explode("_",$this->_getParam("terms"));
             $cmn_terms = "('".implode("','",$cmn_terms)."')";
              $department = $this->_getParam("department");
              
              if(!$date){
                  $prom=$fail_no_subject==1?"not":"";
                    $result = $grade_allocation->notpromotedtype1($session,$department,$cmn_terms,$prom);
                    if(!$result)
                    $result = $grade_allocation->notpromotedtype2($session,$department,$cmn_terms,$fail_no_subject);
              }
              else
              { $prom=$fail_no_subject==1?"not":"";
                   $resultPromotion = $grade_allocation->notpromotedtype1($session,$department,$cmn_terms,$fail_no_subject,$date);
                                                if(!$resultPromotion)
                                                    $resultPromotion = $grade_allocation->notpromotedtype2($session,$department,$cmn_terms,$fail_no_subject,$date);
                                               
                                                $resultPromotion2 = $grade_allocation->notpromotedtype1($session,$department,$cmn_terms,$prom);
                                                if(!$resultPromotion)
                                                $resultPromotion2 = $grade_allocation->notpromotedtype2($session,$department,$cmn_terms,$fail_no_subject);
                                               
                                                $arr = array_merge($resultPromotion,$resultPromotion2);
                                                $result =  array_unique($arr, SORT_REGULAR);
              }
            $this->view->result = $result;
            $htmlcontent = $this->view->render('report/ajax-get-promotion-view.phtml');
            echo $htmlcontent;die;
         
     }
     
     
              public function pendingreportAction() {
                          $grade_allocation = new Application_Model_GradeAllocationItems();
                          $termModel = new Application_Model_TermMaster();
                            $passFail_model = new Application_Model_TabulationReport();
                           $fail_no_subject = $this->_getParam("fno");
                            $session = $this->_getParam("session");
                            $student_id = $this->_getParam("id");
                            $date = $this->_getParam("date");
                            $acadterms = explode("_",$this->_getParam("acadterms"));
                              $department = $this->_getParam("department");
                                     
                                $year = $termModel->getRecordBysessionIdonly($session);
                                $possibleterms = $year[0]['last_year_id']? $year[0]['last_year_id']*2:false;
                                $cmn_terms = array();
                                for($termno=1; $termno<=$possibleterms; $termno++){
                                                    $cmn_terms[] = "t".$termno;}
                                                    $result=$passFail_model->getAppearStudents($acadterms[0],$acadterms[1]);
                                                    
                                                    
                                                    $students = array_column($result,'student_id');
                              if(!$date){
                                 $result = $grade_allocation->getStudentFailDetailsAllwithstudentlist($session,$department,"('".implode("','",$cmn_terms)."')",1,implode("','",$students));
                              }
                              else
                              {
                                   $result  = $grade_allocation->getStudentFailDetailsAccudeleted($session,$department,"('".implode("','",$cmn_terms)."')",$date,implode("','",$students));
                                   if(!$result){
                                        
                                                                $overallpendingdel  = $grade_allocation->getStudentFailDetailsAlldeleted($session,$department,"'".implode("','",$cmn_terms)."'",$date,implode("','",$students));
                                                               
                                                                
                                                                $overallpendingundel = $grade_allocation->getStudentFailDetailsAlludeleted($session,$department,"'".implode("','",$cmn_terms)."'",$date,implode("','",$students));
                                                                
                                                                $result=array_unique(array_merge($overallpendingdel,$overallpendingundel),SORT_REGULAR);
                                                           
                                   }
                                   
                                   
                              }
                            $this->view->result = $result;
                            $htmlcontent = $this->view->render('report/ajax-get-promotion-view.phtml');
                            echo $htmlcontent;die;
         
     }
     
     
                   public function outgoingreportAction() {
                          $grade_allocation = new Application_Model_GradeAllocationItems();
                          $termModel = new Application_Model_TermMaster();
                            $passFail_model = new Application_Model_TabulationReport();
                            $student_model = new Application_Model_StudentPortal();
                           $fail_no_subject = $this->_getParam("fno");
                            $session = $this->_getParam("session");
                            $student_id = $this->_getParam("id");
                            $date = $this->_getParam("date");
                            $acadterms = explode("_",$this->_getParam("acadterms"));
                              $department = $this->_getParam("department");
                                     
                                $year = $termModel->getRecordBysessionIdonly($session);
                                $possibleterms = $year[0]['last_year_id']? $year[0]['last_year_id']*2:false;
                                $cmn_terms = array();
                                for($termno=1; $termno<=$possibleterms; $termno++){
                                                    $cmn_terms[] = "t".$termno;}
                                                    $result=$passFail_model->getAppearStudents($acadterms[0],$acadterms[1]);
                                                    
                                                    
                                                    $students = array_column($result,'student_id');
                              if(!$date){
                                 $result = $grade_allocation->getStudentFailDetailsAllwithstudentlist($session,$department,"('".implode("','",$cmn_terms)."')",1,implode("','",$students));
                              }
                              else
                              {
                                   $result  = $grade_allocation->getStudentFailDetailsAccudeleted($session,$department,"('".implode("','",$cmn_terms)."')",$date,implode("','",$students));
                                   if(!$result){
                                        
                                                                $overallpendingdel  = $grade_allocation->getStudentFailDetailsAlldeleted($session,$department,"'".implode("','",$cmn_terms)."'",$date,implode("','",$students));
                                                               
                                                                
                                                                $overallpendingundel = $grade_allocation->getStudentFailDetailsAlludeleted($session,$department,"'".implode("','",$cmn_terms)."'",$date,implode("','",$students));
                                                                
                                                                $result=array_unique(array_merge($overallpendingdel,$overallpendingundel),SORT_REGULAR);
                                                           
                                   }
                                   
                                   
                              }
                        
                              $resultappear  = $passFail_model->getAppearsAllStudentscmnterms($session,$department,$cmn_terms[count($cmn_terms)-1]);
                            //   echo "<prE>";print_r($result);exit;
                            $appear_student = array_column($resultappear,'student_id');
                                $failed_student = array_column($result,'student_id');
                                $outgoingstudents = array_diff($appear_student,$failed_student);
                               $result =  $student_model->getStudenInfoByid($outgoingstudents);
                              //  echo "<pre>"; print_r($result);exit;
                              
                            $this->view->result = $result;
                            $this->view->outgoing = true;
                            $this->view->department = $department;
                            $htmlcontent = $this->view->render('report/ajax-get-promotion-view.phtml');
                            echo $htmlcontent;die;
         
     }
     
                 public function array_diff_assoc_recursive($array1, $array2)
                    {
                        	foreach($array1 as $key => $value)
                        	{
                        	  
                        		if(is_array($value))
                        		{
                        			if(!isset($array2[$key]))
                        			{
                        				$difference[$key] = $value;
                        			}
                        			elseif(!is_array($array2[$key]))
                        			{
                        				$difference[$key] = $value;
                        			}
                        			else
                        			{
                        		  
                        			    if(!array_key_exists($key,$array2)){
                        			        
                        			      continue;
                        			    }
                        			  
                        				$new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                        				if($new_diff != false)
                        				{
                        					$difference[$key] = $new_diff;
                        				}
                        			}
                        		}
                        		elseif(!isset($array2[$key]) || $array2[$key] != $value)
                        		{
                        			$difference[$key] = $value;
                        		}
                        	}
                        	
                        	return !isset($difference) ? 0 : $difference;
            }
                        
        public function passreportAction() {
          $grade_allocation = new Application_Model_GradeAllocationItems();
          $passFail_model = new Application_Model_TabulationReport();
           $fail_no_subject = $this->_getParam("fno");
            $session = $this->_getParam("session");
            $student_id = $this->_getParam("id");
            $date = $this->_getParam("date");
             $cmn_terms1 = explode("_",$this->_getParam("terms"));
             $cmn_terms = "('".implode("','",$cmn_terms1)."')";
              $department = $this->_getParam("department");
               if(!$date){
            $result  = $grade_allocation->getAllFailAndPassDetails($session,$department,$cmn_terms,0,'',true);
               } else
              {
                   $result1  = $grade_allocation->getStudentFailDetailsAlldeleted($session,$department,$cmn_terms,$date);
                     $result2 = $grade_allocation->getStudentFailDetailsAlludeleted($session,$department,$cmn_terms,$date);
                                    $arr = array_merge($result1,$result2);
                                       $result =  array_unique($arr, SORT_REGULAR); 
                   $res1 = array_column($result,"student_id");
                   
                   $res = "('".implode("','",$res1)."')";
                   $result = $passFail_model->getAppearsAllStudentscmnterms($session,$department,$cmn_terms1,$res1);
                                  
              }
               
            $this->view->result = $result;
            $htmlcontent = $this->view->render('report/ajax-get-pass-view.phtml');
            echo $htmlcontent;die;
         
     } 
     
     public function appearreportAction(){
         $passFail_model = new Application_Model_TabulationReport();
             $fail_no_subject = $this->_getParam("fno");
             $session = $this->_getParam("session");
             $student_id = $this->_getParam("id");
            $date = $this->_getParam("date");
             $cmn_terms1 = explode("_",$this->_getParam("terms"));
             $cmn_terms = "('".implode("','",$cmn_terms)."')";
              $department = $this->_getParam("department");
            $result  = $passFail_model->getAppearsAllStudentscmnterms($session,$department,$cmn_terms1);
            $this->view->result = $result;
            $htmlcontent = $this->view->render('report/ajax-get-appear-view.phtml');
            echo $htmlcontent;die;
     }
     
     
             public function failreportvAction() {
             $grade_allocation = new Application_Model_GradeAllocationItems();
             $fail_no_subject = $this->_getParam("fno");
             $session = $this->_getParam("session");
             $student_id = $this->_getParam("id");
            $date = $this->_getParam("date");
             $cmn_terms = explode("_",$this->_getParam("terms"));
             $cmn_terms = "('".implode("','",$cmn_terms)."')";
              $department = $this->_getParam("department");
              if(!$date){
            $result  = $grade_allocation->getAllFailAndPassDetails($session,$department,$cmn_terms,$fail_no_subject,'',false);
              }
              else
              {
                   $result1  = $grade_allocation->getStudentFailDetailsAlldeleted($session,$department,$cmn_terms,$date);
                $result2 = $grade_allocation->getStudentFailDetailsAlludeleted($session,$department,$cmn_terms,$date);
                                    $arr = array_merge($result1,$result2);
                                       $result =  array_unique($arr, SORT_REGULAR);
                                      // echo "<pre>";print_r($result1);exit;
              }
            $this->view->result = $result;
            $htmlcontent = $this->view->render('report/ajax-get-failv-view.phtml');
            echo $htmlcontent;die;
         
     } 
     
     
     
    
    

    public function getStudentReportAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $Studentreport_model = new Application_Model_StudentPortal();
        $termMaster_model = new Application_Model_TermMaster();
        $tr_model = new Application_Model_TabulationReport();
        
        //$result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $arc_status = $this->_getParam("arc_status");
            $montharchive = $this->_getParam("arc");
            $reval_status = $this->_getParam("reval_status");
            $reval_date = $this->_getParam("revalDate");

            $filter_status = $this->_getParam("filter_status");

            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $this->view->arc_status = !$arc_status ? !$reval_status ? '' : 'R' : 'B';
            $this->view->archive = !$montharchive ? !$reval_date ? '' : $reval_date : $montharchive;
            $stu_id = $this->_getParam("stu_id");

            $acadModel = new Application_Model_Academic();
            $deptModel = new Application_Model_Department();

            $getDepartMent = $acadModel->getDepartment($academic_id);
            //echo '<pre>';print_r($getDepartMent);exit;
            $getDegreeId = $deptModel->getRecord($getDepartMent['department']);
            if($term_id){
                $termId= $termMaster_model->getTermId($academic_id,$term_id);
               // echo '<pre>';print_r($academic_id);exit;
                $tablId= $tr_model->getTablIdForFilter($academic_id, $termId['term_id']);
               /// echo '<pre>';print_r($tablId);exit;
                $result = $Studentreport_model->getTermWiseFilteredStudentRecord($academic_id,$stu_id,$tablId['tabl_id'],$filter_status);
            }elseif ($year_id && !$term_id) {
                $termIds= $termMaster_model->getTermRecordsByYear($academic_id,$year_id);
               
                $termArr=array();
                foreach ($termIds as $key => $value) {
                    array_push($termArr,$value['term_id']);
                }
                 //echo '<pre>';print_r($termArr);exit;
                $tablIds= $tr_model->getTablIdForYear($academic_id, $termArr);
                //echo '<pre>';print_r($tablIds);exit;
                $yearArr=array();
                foreach ($tablIds as $key => $value) {
                    array_push($yearArr,$value['tabl_id']);
                }
                $result = $Studentreport_model->getYearWiseFilteredStudentRecord($academic_id,$stu_id,$yearArr,$filter_status);
            }  else {
                if (isset($getDegreeId['degree_id'])) {
                    $maxCountCheck = '';
                    switch ($getDegreeId['degree_id']) {
                        case 1:
                            $maxCountCheck = 6;
                            break;
                        case 2:
                            $maxCountCheck = 4;
                            break;
                        case 3:
                            $maxCountCheck = 4;
                            break;
                        case 8:
                            $maxCountCheck = 4;
                        break;
                        case 4:
                            $maxCountCheck = 2;
                            break;
                        case 5:
                            $maxCountCheck = 2;
                            break;
                        case 6:
                            $maxCountCheck = 2;
                            break;
                        default:
                            $maxCountCheck = 9;
                            break;
                    }
                }
                if(($getDepartMent['department'] == 30 && $getDepartMent['session'] == 1) || $getDepartMent['session']==2 )
                    $maxCountCheck = 6;
               // echo '<pre>';print_r($maxCountCheck);exit;
                $result = $Studentreport_model->getFilteredStudentRecord($academic_id, $stu_id, $filter_status,$maxCountCheck,$year_id);
            }
            //echo '<pre>'; print_R($result);exit;
            $this->view->corecourseresult = $result;
        }
    }

    public function getStudentResultAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $term_model = new Application_Model_TermMaster();
        $academic_model = new Application_Model_Academic();
        $final_model = new Application_Model_FinalResult();
        $grade_allocation_model =  new  Application_Model_GradeAllocationItems();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $arc_status = $this->_getParam("arc_status");
            $montharchive = $this->_getParam("arc");
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $this->view->arc_status = $arc_status;
            $this->view->archive = $montharchive;
            $stu_id = $this->_getParam("stu_id");

            if ($academic_id) {
                $getacademicrecord = $final_model->getRecordByAcdemic($academic_id);

                if (!empty($getacademicrecord)) {
                    $this->_flashMessenger->addMessage('Selected Academic CGPA Already Generated');
                    echo "<script>
                           alert('Selected Academic CGPA Already Generated');
                           window.location.href='';
                           </script>";
                    die();
                    //$this->view->corecourseresult = 'Selected Academic CGPA Already Generated'; 
                } else {
                    $allterm = $term_model->getRecordByAcademicId($academic_id);
                    $termall = count($allterm);
                    $Studentreport_model = new Application_Model_StudentPortal();
                  //  $result = $Studentreport_model->getStudentResult($academic_id, $termall);
                                $academicdetails = $academic_model->getRecord($academic_id);
                                
                $result = $grade_allocation_model->getAllFailAndPassDetails($academicdetails['session'],$academicdetails['department'],'("t1","t2","t3","t4","t5","t6")',0,'',true);
                    
                   // $result = $grade_allocation_model->getCGPAForStudentRanking($academic_id);
                    
                    $this->view->corecourseresult = $result;
                }
            }
        }
    }

    public function getStudentsListByAcademicAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_year_id");

            if ($academic_id) {
                $Studentreport_model = new Application_Model_FinalResult();
                $result = $Studentreport_model->getAllRecordByAcdemic($academic_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function ajaxGetStudentsResultListAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $limit = $this->_getParam("limit");
            $term_id = $this->_getParam("term_id");
            $arc_status = $this->_getParam("arc_status");
            $montharchive = $this->_getParam("arc");
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $this->view->arc_status = $arc_status;
            $this->view->archive = $montharchive;
            $stu_id = $this->_getParam("stu_id");

            if ($academic_id) {
                $Studentreport_model = new Application_Model_StudentPortal();
                $result = $Studentreport_model->getTopRecordByAcdemic($academic_id, $limit);
                $this->view->corecourseresult = $result;
            }
        }
    }
    
    public function ajaxGetStudentReportRecordAction(){
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $academic_id = "(".implode(",",$academic_id).")";
            if ($academic_id) {
                $Studentreport_model = new Application_Model_ApplicantPaymentDetailModel();
                $result = $Studentreport_model->getProfRecords($academic_id);
                $this->view->results = $result;
            }
        }
    }
    

    public function getBackStudentReportAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $termMaster_model = new Application_Model_TermMaster();
        $tr_model = new Application_Model_TabulationReport();
        $Studentreport_model = new Application_Model_StudentPortal();
        
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $arc_status = $this->_getParam("arc_status");
            $montharchive = $this->_getParam("arc");
            $reval_status = $this->_getParam("reval_status");
            $reval_date = $this->_getParam("revalDate");
            $filter_status = $this->_getParam("filter_status");
            
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $this->view->arc_status = !$arc_status ? !$reval_status ? '' : 'R' : 'B';
            $this->view->archive = !$montharchive ? !$reval_date ? '' : $reval_date : $montharchive;
            $stu_id = $this->_getParam("stu_id");

            if($term_id){
                $termId= $termMaster_model->getTermId($academic_id,$term_id);
                $tablId= $tr_model->getBackTablIdForFilter($academic_id, $termId['term_id']);
               // echo '<pre>';print_r($tablId);exit;
                $result = $Studentreport_model->getBackTermWiseFilteredStudentRecord($academic_id,$stu_id,$tablId['tabl_id'],$filter_status);
                $this->view->corecourseresult = $result;
                
            }
//            if ($academic_id) {
//                
//                $Studentreport_model = new Application_Model_StudentPortal();
//                $result = $Studentreport_model->getStudentPCRecord($academic_id, $stu_id);
//                $this->view->corecourseresult = $result;
//            }
        }
    }

    public function studentreportPdfAction() {
        $this->view->close = '';
        $st_id = $this->_getParam("id");
        $academic_id = $this->_getParam("academic_id");
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecord($st_id);
        $this->view->result = $result;
        $Academic_model = new Application_Model_Academic();
        $academic_result = $Academic_model->getRecord($academic_id);
        $this->view->academic_result = $academic_result;

        $pdfheader = $this->view->render('report/pdfheader.phtml');
        $pdffooter = $this->view->render('report/pdffooter.phtml');
        $htmlcontent = $this->view->render('report/studentreport-pdf.phtml');
        $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, "Student Provisional Report");
    }

    public function studentgradesheetreportPdfAction() {
        $this->view->close = '';
        $stu_id = $this->_getParam("id");
        $this->view->stu_id = $stu_id;
        $academic_id = $this->_getParam("acd_id");
        $this->view->academic_id = $academic_id;
        $year_id = $this->_getParam("year");
        $this->view->year_id = $year_id;
        $CourseGradeAfterpenalties_model = new Application_Model_CourseGradeAfterpenalties();
        $result = $CourseGradeAfterpenalties_model->getGradeSheetRecord($academic_id, $year_id, $stu_id);
        //echo'<pre>';print_r($result);die;
        $this->view->grade_result = $result;

        $Ele_result = $CourseGradeAfterpenalties_model->getGradeSheetElectivesRecord($academic_id, $year_id, $stu_id);
        //echo'<pre>';print_r($Ele_result);die;
        $this->view->Ele_result = $Ele_result;

        $studentreport_model = new Application_Model_StudentReport();
        $stu_result = $studentreport_model->getRecord($stu_id);
        $this->view->stu_result = $stu_result;

        $Academic_model = new Application_Model_Academic();
        $academic = $Academic_model->getRecord($academic_id);
        $this->view->academic_data = $academic;

        $ExprCourseGradeAftrPenalties_model = new Application_Model_ExprCourseGradeAftrPenalties();
        $ExprCourseGradeAftrPenaltyItems_model = new Application_Model_ExprCourseGradeAftrPenaltyItems();

        $ExperientialLearning_model = new Application_Model_ExperientialLearning();
        $Experiential_data = $ExperientialLearning_model->getExperRecords($academic_id, $year_id);
        $this->view->Experiential_data = $Experiential_data;

        // $ExprCourse_data = $ExprCourseGradeAftrPenalties_model->getGradeSheetRecords($academic_id,$year_id,$stu_id);
        //echo'<pre>';print_r($ExprCourse_data);die;
        // $this->view->ExprCourse_data = $ExprCourse_data;
        //$pdfheader = $this->view->render('report/pdfheader.phtml');
        //$pdffooter = $this->view->render('report/pdffooter.phtml');				
        $htmlcontent = $this->view->render('report/studentgradesheetreport-pdf.phtml');
        $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, "Student Report Details");
    }

    public function directFinalGradeAction() {
        $this->view->action_name = 'direct-final-grade';
        $this->view->sub_title_name = 'direct-final-grade';
        $this->accessConfig->setAccess('SA_ACAD_DIRECT_FINAL_GRADE');
        $DirectFinalGrade_model = new Application_Model_DirectFinalGrade();
        $Corecourselearning_form = new Application_Form_DirectFinalGrade();
        $ccl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Corecourselearning_form;
        $cur_datetime = date('Y-m-d H:i:s');
        $user_id = $this->login_storage->id;
        $ip = $_SERVER['REMOTE_ADDR'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Corecourselearning_form->isValid($this->getRequest()->getPost())) {
                        $final_grade = $this->getRequest()->getPost('final_grade');
                        $data = $Corecourselearning_form->getValues();
                        $Corecourselearning_model = new Application_Model_Corecourselearning();
                        $course_detail = $Corecourselearning_model->getCoreCouseDetailByTermAcademicCourse($data['academic_year_id'], $data['term_id'], $data['course_id']);
                        //print_r($data);exit;
                        $data['final_grade'] = $final_grade;
                        $data['credit_value'] = $course_detail['credit_value'];
                        $data['grade_credit_multiplied'] = $final_grade * $course_detail['credit_value'];
                        $data['added_on'] = $cur_datetime;
                        $data['added_by'] = $user_id;
                        $data['updated_on'] = $cur_datetime;
                        $data['updated_by'] = $user_id;
                        $data['added_by_ip'] = $ip;
                        $data['updated_by_ip'] = $ip;

                        $DirectFinalGrade_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('report/direct-final-grade');
                    }
                }
                break;
            case 'edit':
                $result = $DirectFinalGrade_model->getRecordDetail($ccl_id);
                $this->view->final_grade_detail = $result;
                if ($this->getRequest()->isPost()) {
                    $data['final_grade'] = $this->getRequest()->getPost('final_grade');
                    $Corecourselearning_model = new Application_Model_Corecourselearning();
                    $course_detail = $Corecourselearning_model->getCoreCouseDetailByTermAcademicCourse($result['academic_year_id'], $result['term_id'], $result['course_id']);
                    $data['credit_value'] = $course_detail['credit_value'];
                    $data['grade_credit_multiplied'] = $final_grade * $course_detail['credit_value'];
                    $data['updated_on'] = $cur_datetime;
                    $data['updated_by'] = $user_id;
                    $data['updated_by_ip'] = $ip;
                    //print_r($data);echo $ccl_id;exit;
                    $DirectFinalGrade_model->update($data, array('id=?' => $ccl_id));

                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('report/direct-final-grade');
                }

                break;
            case 'delete':
                $data['deleted'] = 1;
                if ($ccl_id) {
                    $DirectFinalGrade_model->update($data, array('id=?' => $ccl_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('report/direct-final-grade');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $DirectFinalGrade_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function secondyeargradesheetreportAction() {
       // echo "<pre>";print_r($this->_act);exit;
        $this->view->close = '';
        $check = $_POST['username'];
        $stu_id = $this->_getParam("id");
        $academic_id = $this->_getParam("acd_id");
        $year_id = $this->_getParam("year");
        $mode = $this->_getParam("mode");
        $term_id = $this->_getParam("term");
        $arc = $this->_getParam("arc");
        $type = $this->_getParam("type");
        $cmn_terms = $term_id;
        $session = 0;
        //echo '<pre>'; print_r($arc); exit;
        $term_master = new Application_Model_TermMaster();
        if ($term_id)
            $term_id = $term_master->getTermRecordsbycmn($academic_id, $term_id)['term_id'];
        $this->view->term_id = $term_id;
        $this->view->year_id = $year_id;
        $academic_master = new Application_Model_Academic();
        if ($year_id) {
            $term_result = $term_master->getTermRecordsByYear($academic_id, $year_id);
        } else {
            $term_result = $term_master->getRecordByAcademicId($academic_id);
        }
        //    $term_result = $term_master->getTermRecordsByYear($academic_id, $year_id);
        $core_course_master = new Application_Model_Corecourselearning();

        $filename = 'Grade Report';
        $stuname = 'no student';
        $prom_text = array();
        $term_iterator = array();
        $single = false;
        $pge_height = 150;
        $publishDate = "";
        $last_term_id = 0;
        $dateterm_id = '';
        if (in_array($academic_id, array(63, 65))) {
            $publishDate = "2019-06-22";
        }
        //============QR COde Generator url link for studenr=====================//
        $url = $this->_base_url . "application/secondyeargradesheetreport/id/$stu_id/acd_id/$academic_id/year/$year_id/mode/view";
        //------------------[bulk term_id]---------------//  
        if (empty($term_id)) {


            $pge_height = 0;
            //echo '<pre>';print_r($term_result);exit;

            foreach($term_result as $key => $value){
           
                    $result = $this->getReports($stu_id,$academic_id,$year_id,$value['term_id']);
                  
                    
                    
                      
                    if($result){
                            $student_course_marks[$value['term_id']] = $result['student_course_marks'];
                            $get_student_sgpa[$value['term_id']] = $result['get_student_sgpa']['sgpa'];
                            $get_student_fail_in[$value['term_id']] = $result['get_student_sgpa']['fail_in_ct_ids'];
                            $tabl_date = $result['get_student_sgpa']['added_date'];
                            $get_student_back_date_arr['back_dates'][] = $result['noncoldate'];
                            $get_student_back_id_arr['back_id'][] = $result['bid'];
                            $get_student_added_date_arr['date'][] = $result['get_student_sgpa']['added_date'];
                            $prom_text[$value['term_id']] = $result['get_student_sgpa']['promotion_text']=='--'?'Not Promoted':$result['get_student_sgpa']['promotion_text'];
                            $student_details = $result['student_details'];
                            $academic_details[$value['term_id']] = $result['academic_details'];
                            $session = $result['academic_details']['session'];
                            $formated_result[$value['term_id']] = $result['formated_result'];
                            $core_course_span[$value['term_id']] = count($result['core_course_span']);
                            $max[$value['term_id']] = $result['max_num'];
                            $term_details[$value['term_id']] = $result['term_details'];
                            $term_iterator[] = $value['term_id'];
                            $stuname = $result['student_details']['stu_fname'].''.$result['student_details']['stu_id'];
                            $tbl_id = $result['tabulation_id'];
                            $dateterm_id = !isset($result['dateTerm_id'])?$dateterm_id:$result['dateTerm_id'];
                        
          $course_ids = $this->mergData($student_course_marks[$value['term_id']], array('course_id'), count($student_course_marks[$value['term_id']]));
        //   if($value['term_id']=="639"){
        //     echo '<pre>';print_r($course_ids);exit;    
        // }
          //echo '<pre>';print_r($course_ids);exit;
          $course_credit_info[$value['term_id']]['sgpa_span'] = count($core_course_master->getCoreCousecreditCountno($academic_id, $value['term_id'], $course_ids));
          
            //echo "<pre>"; print_r($course_credit_info[$value['term_id']]['sgpa_span']);exit;
                            $pge_height+=120;
                            $last_term_id =  $value['term_id'];
                    }
                        //print_r($dateterm_id); die(); 
                }
               
        }
        else if (!empty($term_id)) {

            $value['term_id'] = $term_id;
            $term_iterator[] = $term_id;
            $result = $this->getReports($stu_id, $academic_id, $year_id, $value['term_id'], $arc, $type);
            
            if ($result) {
                $student_course_marks[$value['term_id']] = $result['student_course_marks'];
                $get_student_sgpa[$value['term_id']] = $result['get_student_sgpa']['sgpa'];
                $tabl_date = $result['get_student_sgpa']['added_date'];
                $get_student_fail_in[$value['term_id']] = $result['get_student_sgpa']['fail_in_ct_ids'];
                $student_details = $result['student_details'];
                $get_student_back_date_arr['back_dates'][] = $result['noncoldate'];
                            $get_student_back_id_arr['back_id'][] = $result['bid'];
                            $get_student_added_date_arr['date'][] = $result['get_student_sgpa']['added_date'];
                $prom_text = $result['get_student_sgpa']['promotion_text'] == '--' ? 'Not Promoted' : $result['get_student_sgpa']['promotion_text'];
                $academic_details[$value['term_id']] = $result['academic_details'];
                $session = $result['academic_details']['session'];
                $formated_result[$value['term_id']] = $result['formated_result'];
                $core_course_span[$value['term_id']] = count($result['core_course_span']);
                $max[$value['term_id']] = $result['max_num'];
                $term_details[$value['term_id']] = $result['term_details'];
                $stuname = $result['student_details']['stu_fname'].''.$result['student_details']['stu_id'];
                $filename = '-' . $term_details[$value['term_id']]['term_name'] . '-Grade-Report';
                $tbl_id = $result['tabulation_id'];
                $dateterm_id = !isset($result['dateTerm_id']) ? $dateterm_id : $result['dateTerm_id'];
                //$pge_height+=count($result['core_course_span'])*20;
                $pge_height += 80;
   // echo "<pre>"; print_r($student_course_marks);exit;
                $course_ids = $this->mergData($student_course_marks[$term_id], array('course_id'), count($student_course_marks[$term_id]));
          
                $course_credit_info[$value['term_id']]['sgpa_span'] = count($core_course_master->getCoreCousecreditCountno($academic_id, $term_id, $course_ids));
            }
            $single = true;
        }

//       //---------------------[END]-------------------------// 
//        
//        $pge_height+=150;
        

        //---------------------[END]-------------------------// 

        $pge_height += 150;

        $degree_id = $academic_master->getAcademicDegree($academic_id);

        if (!empty($degree_id))
            $passpercent = $this->getPasspercent($degree_id, $session);

        $this->view->passpercent = $passpercent;

         //   echo '<pre>';print_r($student_course_marks);exit;    
        
        $this->view->student_marks_details = $student_course_marks;
        $this->view->stu_sgpa = $get_student_sgpa;
        $this->view->stu_fail_in = $get_student_fail_in;
        $this->view->stu_details = $student_details;
        $this->view->stu_term_details = $term_details;
        $this->view->stu_academic_details = $academic_details;
        $this->view->stu_course = $formated_result;
        $this->view->header_component = $max;
        $this->view->corespan = $core_course_span;
        $this->view->term_marks = $term_iterator;
        $this->view->single = $single;
        $this->view->prom = $prom_text;
        $this->view->sgpaspan = $course_credit_info;
        $this->view->publish_dates = $tabl_date;
        $this->view->cmn_terms = $cmn_terms;
        $this->view->archive = $arc;
        $this->view->tabldetails = array('tabl_id' => $tbl_id, 'term_id' => $dateterm_id);
                           $this->view->back_dates = $get_student_back_date_arr['back_dates'];
                           $this->view->back_ids =  $get_student_back_id_arr['back_id']; 
                           $this->view->added_date = $get_student_added_date_arr['date'];
       // print_r($this->view->tabldetails);EXIT;
        if ($publishDate) {
            $this->view->publish_dates = $publishDate;
        } else {
            $this->view->publish_dates = $tabl_date;
        }

        if ($term_id)
            $this->view->term_id = $term_id;
        else if ($last_term_id)
            $this->view->term_id = $last_term_id;
        else
            $this->view->term_id = 0;

        $this->view->url = $url;

        //===================[GRADE SHEET NUMBER]===============================//
        if ($term_id) {
            $GradeSheet_model = new Application_Model_GradeSheet();
            $gradesheet_number = $GradeSheet_model->getGradeSheetNumber($academic_id, $year_id, $stu_id);
            $this->view->gradesheet_number = $gradesheet_number;
            $htmlcontent = $this->view->render('application/ajax-get-grade-view.phtml');
        } else {

            if ($year_id) {
                $GradeSheet_model = new Application_Model_GradeSheet();
                $gradesheet_number = $GradeSheet_model->getGradeSheetNumber($academic_id, $year_id, $stu_id);
            } else {
                $GradeSheet_model = new Application_Model_PassOutModel();
                $gradesheet_number = $GradeSheet_model->getGradeSheetNumber($academic_id, $stu_id, 0);
            }
            $this->view->gradesheet_number = $gradesheet_number;
            $htmlcontent = $this->view->render('report/secondyeargradesheetreport.phtml');
        }
        //------------------------------[Print Option According to Mode]-------------------//
        //echo '<pre>'; print_r($year_id); exit;
        //echo '<pre>';print_r($result['student_details']);exit;
        if (empty($term_id)) {
            $backcontent = $this->view->render('report/backpage.phtml');
        } else if ($term_id) {
            $pge_height = 320;
        } else {
            $backcontent = "";
        }
        if ($check == 'admin' || $mode == 'view') {

            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, $stuname . '-' . $filename, 'L', $pge_height, $backcontent,300,$year_id);
        //-----------------------[END]--------------------//      
    }

    public function attendancereportAction() {

        $this->view->close = '';
        $check = $_POST['username'];
        $stu_id = $this->_getParam("id");
        $academic_id = $this->_getParam("acd_id");
        $year_id = $this->_getParam("year");
        $mode = $this->_getParam("mode");
        $term_id = $this->_getParam("term");
        $monthFrom = $this->_getParam('from');
        $monthTo = $this->_getParam('to');
        $pge_height = 150;
        $department_id = $this->_getParam("department");
        $course_id = $this->_getParam("course_id");
        $ge_id = $this->_getParam("ge_id");
        $cc_id = $this->_getParam("cc_id");
        $practical_id = $this->_getParam("p");
        $section = $this->_getParam("section");
        $this->view->pract_id = $practical_id;
        $this->view->term_id = $term_id;
        $this->view->year_id = $year_id;
        $this->view->section = $section;

        $ge_master = new Application_Model_Ge();
        $term_master = new Application_Model_TermMaster();
        $academic_master = new Application_Model_Academic();
        $attendance_info = new Application_Model_BatchAttendance();
        $department = new Application_Model_Department();
        $session = new Application_Model_Session();
        $course_details = new Application_Model_Course();
        if ($ge_id) {
            $ge_name = $ge_master->getRecord($ge_id);
        }

        /* $semesterName= $term_master->getTermRecordsbycmn($academic_id,$term_id);
          //echo '<pre>'; print_r($semesterName); exit;
          $course_code = $course_details->getRecord($course_id);
          $academic_details    = $academic_master->getRecord($academic_id);
          $department_name = $department->getRecord($academic_details['department'])['department'];
          $session_name = $session->getRecord($academic_details['session'])['session']; */
        //$term_result = $term_master->getTermRecordsByTerm($academic_id, $term_id);
        // $selected_cmn_terms = $this->selectData($term_result, array('cmn_terms'), count($term_result));
        //$term_arr = $this->mergData($selected_cmn_terms, array('cmn_terms'), count($selected_cmn_terms));
        //$filename = $academic_details['short_code'];
        $attendance_result = $attendance_info->getAttendanceOnMonthRange1($department_id, $course_id, $ge_id, $cc_id, $term_id, $monthFrom, $monthTo, $section);

        $ids = $this->mergData($attendance_result, array('attendance_master_id'), count($attendance_result));

        $attendance_result = $attendance_info->getAttendanceOnMonthRange2($ids);

        $u_ids = $this->selectData($attendance_result, array('u_id'), count($attendance_result));

        $attendance_result_new = $attendance_info->getAttendanceOnMonthRange($ids);
        //echo "<pre>";print_r($attendance_result_new);exit;
        $pge_height = $pge_height + count($attendance_result_new) * 12;
        $distinct_date = $attendance_info->distinctDate($department_id, $course_id, $ge_id, $cc_id, $term_id, $monthFrom, $monthTo, $section);
        //  echo "<pre>";print_r($distinct_date);exit;
        $parentMonth = $this->selectData($distinct_date, array('month'), count($distinct_date));

        $distinct_date = $this->stackData($parentMonth, $distinct_date);
        $data = $this->stackData($u_ids, $attendance_result_new);

        $monthFrom = explode('-', $monthFrom);
        $monthTo = explode('-', $monthTo);
        $month_arr = $monthFrom;
        $monthTo_arr = $monthTo;
        $monthFrom = "$month_arr[1]-$month_arr[0]";
        $monthTo = "$monthTo_arr[1]-$monthTo_arr[0]";

        $date1 = new DateTime($monthFrom . '-20');
        $date2 = new DateTime($monthTo . '-20');
        $diff = $date1->diff($date2);
        $month_diff = (($diff->format('%y') * 12) + $diff->format('%m'));

        $this->view->attendanceInfo = $attendance_result;
        $this->view->monthDiff = $month_diff;
        $this->view->month = $monthTo_arr[0];
        $this->view->startYear = $month_arr[1];
        $this->view->monthTo = $monthTo;
        $this->view->endYear = $monthTo_arr[1];
        $this->view->course_code = $course_code;
        $this->view->sem_name = $semesterName;
        $this->view->ge_name = $ge_name;
        $this->view->cc_id = $cc_id;
        $this->view->monthFrom = $month_arr[0];
        $this->view->batch = $attendance_result_new[0]['batch'];
        $this->view->data = $data;
        $this->view->distinctdate = $distinct_date;

        //------------------------------[Print Option According to Mode]-------------------//
        $htmlcontent = $this->view->render('report/attendancereport.phtml');
        echo '<pre>';
        print_r($htmlcontent);
        exit;
        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, 'Attendance-report-for' . '-' . $filename, 'L', $pge_height);
        //-----------------------[END]--------------------//     
    }

    public function attendancereportViewAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $this->view->close = '';
            $check = $_POST['username'];
            $stu_id = $this->_getParam("id");
            $academic_id = $this->_getParam("acd_id");
            $year_id = $this->_getParam("year");
            $mode = $this->_getParam("mode");
            $term_id = $this->_getParam("term");
            $monthFrom = $this->_getParam('from');
            $monthTo = $this->_getParam('to');
            $pge_height = 150;
            $department_id = $this->_getParam("department");
            $course_id = $this->_getParam("course_id");
            $ge_id = $this->_getParam("ge_id");
            $cc_id = $this->_getParam("cc_id");
            $practical_id = $this->_getParam("practical");
            $section = $this->_getParam("section");
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            //echo '<pre>';print_r($section);
            $term_master = new Application_Model_TermMaster();
            $academic_master = new Application_Model_Academic();
            $attendance_info = new Application_Model_BatchAttendance();
            $department = new Application_Model_Department();
            $session = new Application_Model_Session();

            $attendance_result = $attendance_info->getAttendanceOnMonthRange1($department_id, $course_id, $ge_id, $cc_id, $term_id, $monthFrom, $monthTo, $section);
            if (empty($attendance_result)) {
                echo '<pre>';
                print_r('<b style="color:red">Record Not Found Between Selected Date!</b>');
                exit;
            } else {


                $ids = $this->mergData($attendance_result, array('attendance_master_id'), count($attendance_result));

                $attendance_result = $attendance_info->getAttendanceOnMonthRange2($ids);

                $u_ids = $this->selectData($attendance_result, array('u_id'), count($attendance_result));

                $attendance_result_new = $attendance_info->getAttendanceOnMonthRange($ids);
                //echo "<pre>";print_r($attendance_result_new);die;
                $pge_height = $pge_height + count($attendance_result_new) * 12;

                $distinct_date = $attendance_info->distinctDate($department_id, $course_id, $ge_id, $cc_id, $term_id, $monthFrom, $monthTo, $section);
                //echo "<pre>";print_r($distinct_date);
                $parentMonth = $this->selectData($distinct_date, array('month'), count($distinct_date));
                // echo "<pre>";print_r($parentMonth);
                $distinct_date = $this->stackData($parentMonth, $distinct_date);
                $data = $this->stackData($u_ids, $attendance_result_new);

                $monthFrom = explode('-', $monthFrom);
                $monthTo = explode('-', $monthTo);
                $month_arr = $monthFrom;
                $monthTo_arr = $monthTo;
                $monthFrom = "$month_arr[1]-$month_arr[0]";
                $monthTo = "$monthTo_arr[1]-$monthTo_arr[0]";

                $date1 = new DateTime($monthFrom . '-20');
                $date2 = new DateTime($monthTo . '-20');
                $diff = $date1->diff($date2);
                $month_diff = (($diff->format('%y') * 12) + $diff->format('%m'));
                //echo '<pre>';print_r($data); exit;
                $this->view->attendanceInfo = $attendance_result;
                $this->view->monthDiff = $month_diff;
                $this->view->month = $monthTo_arr[0];
                $this->view->startYear = $month_arr[1];
                $this->view->monthTo = $monthTo;
                $this->view->endYear = $monthTo_arr[1];

                $this->view->department = $department_name;
                $this->view->practical = $practical_id;
                $this->view->cc_id = $cc_id;
                $this->view->monthFrom = $month_arr[0];
                $this->view->batch = $academic_details['short_code'];
                $this->view->session = $session_name;
                $this->view->data = $data;
                $this->view->distinctdate = $distinct_date;
            }
        }
    }

    public function backPaperReportAction() {
        // die;

        $this->view->close = '';
        $check = $_POST['username'];
        $stu_id = $this->_getParam("id");
        $academic_id = $this->_getParam("acd_id");
        $year_id = $this->_getParam("year");
        $mode = $this->_getParam("mode");
        $session = 0;
        $term_id = $this->_getParam("term");
        $arc = $this->_getParam("arc");
        $type = $this->_getParam("type");
        $cmn_terms = $term_id;
        $term_master = new Application_Model_TermMaster();
        $term_id = $term_master->getTermRecordsbycmn($academic_id, $term_id)['term_id'];
        $this->view->term_id = $term_id;

        //echo '<pre>';print_r($cmn_terms);exit;
        $this->view->year_id = $year_id;
        $academic_master = new Application_Model_Academic();

        $term_result = $term_master->getTermRecordsByYear($academic_id, $year_id);
        $core_course_master = new Application_Model_Corecourselearning();
        $filename = 'Grade Report';
        $stuname = 'no student';
        $term_iterator = array();
        $single = false;
        $pge_height = 400;
        $last_term_id = 0;
        $dateterm_id = '';
        //============QR COde Generator url link for studenr=====================//
        $url = $this->_base_url . "application/back-paper-report/id/$stu_id/acd_id/$academic_id/year/$year_id/mode/view";
        //------------------[bulk term_id]---------------//  

        if (empty($term_id)) {


            $pge_height = 0;
            foreach ($term_result as $key => $value) {

                $result = $this->getBackReports($stu_id, $academic_id, $year_id, $value['term_id']);

                if ($result) {
                    $student_course_marks[$value['term_id']] = $result['student_course_marks'];
                    $get_student_sgpa[$value['term_id']] = $result['get_student_sgpa']['sgpa'];
                    $tabl_date[$value['term_id']] = $result['get_student_sgpa']['added_date'];
                    $get_student_fail_in[$value['term_id']] = $result['get_student_sgpa']['fail_in_ct_ids'];
                    $student_details = $result['student_details'];
                    $academic_details[$value['term_id']] = $result['academic_details'];
                    $session = $result['academic_details']['session'];
                    $formated_result[$value['term_id']] = $result['formated_result'];
                    $core_course_span[$value['term_id']] = count($result['core_course_span']);
                    $max[$value['term_id']] = $result['max_num'];
                    $term_details[$value['term_id']] = $result['term_details'];
                    $term_iterator[] = $value['term_id'];
                    $stuname = $result['student_details']['stu_fname'];
                    $tbl_id = $result['tabulation_id'];
                    $dateterm_id = !isset($result['dateTerm_id']) ? $dateterm_id : $result['dateTerm_id'];
                    $course_ids = $this->mergData($student_course_marks[$term_id], array('course_id'), count($student_course_marks[$term_id]));

                    if (empty($course_ids)) {
                        $this->_message('She is not in Non Collegiate group..');
                    }
                    $course_credit_info[$value['term_id']]['sgpa_span'] = count($core_course_master->getCoreCousecreditCountno($academic_id, $term_id, $course_ids));
                    $pge_height += 300;
                }
            }
        } else if (!empty($term_id)) {
            $value['term_id'] = $term_id;
            $term_iterator[] = $term_id;
            $result = $this->getBackReports($stu_id, $academic_id, $year_id, $value['term_id'], $arc, $type);
            if ($result) {
                $get_student_sgpa[$value['term_id']] = $result['get_student_sgpa']['sgpa'];
                $student_course_marks[$value['term_id']] = $result['student_course_marks'];
                $get_student_sgpa[$value['term_id']] = $result['get_student_sgpa']['sgpa'];
                $get_student_fail_in[$value['term_id']] = $result['get_student_sgpa']['fail_in_ct_ids'];
                $tabl_date[$value['term_id']] = $result['get_student_sgpa']['added_date'];
                $student_details = $result['student_details'];
                $academic_details[$value['term_id']] = $result['academic_details'];
                $session = $result['academic_details']['session'];
                $formated_result[$value['term_id']] = $result['formated_result'];
                $core_course_span[$value['term_id']] = count($result['core_course_span']);
                $max[$value['term_id']] = $result['max_num'];
                $term_details[$value['term_id']] = $result['term_details'];
                $stuname = $result['student_details']['stu_fname'];
                $tbl_id = $result['tabulation_id'];
                $dateterm_id = !isset($result['dateTerm_id']) ? $dateterm_id : $result['dateTerm_id'];

                $course_ids = $this->mergData($student_course_marks[$term_id], array('course_id'), count($student_course_marks[$term_id]));
               // echo "<pre>";print_r($course_ids);die;
                if (empty($course_ids)) {
                    $this->_message('She is not in Non Collegiate group..');
                }
                 
                $course_credit_info[$value['term_id']]['sgpa_span'] = count($core_course_master->getCoreCousecreditCountno($academic_id, $term_id, $course_ids));
               // echo "<pre>";print_r($course_credit_info[$value['term_id']]['sgpa_span']); die();
                $filename = $academic_details[$value['term_id']] . '-' . $term_details[$value['term_id']]['term_name'] . '-Grade-Report';
            }
            $single = true;
        }
        //---------------------[END]-------------------------// 
        $degree_id = $academic_master->getAcademicDegree($academic_id);
        if (!empty($degree_id))
            $passpercent = $this->getPasspercent($degree_id, $session);
            
            
        $this->view->passpercent = $passpercent;
        $this->view->student_marks_details = $student_course_marks;
        $this->view->stu_sgpa = $get_student_sgpa;
        $this->view->stu_fail_in = $get_student_fail_in;
        $this->view->stu_details = $student_details;
        $this->view->stu_term_details = $term_details;
        $this->view->stu_academic_details = $academic_details;
        $this->view->stu_course = $formated_result;
        $this->view->header_component = $max;
        $this->view->corespan = $core_course_span;
        $this->view->term_marks = $term_iterator;
        $this->view->single = $single;
        $this->view->sgpaspan = $course_credit_info;
        $this->view->publish_dates = $tabl_date;
        $this->view->cmn_terms = $cmn_terms;
        $this->view->url = $url;
        $this->view->tabldetails = array('tabl_id' => $tbl_id, 'term_id' => $dateterm_id);
        //===================[GRADE SHEET NUMBER]===============================//

        $GradeSheet_model = new Application_Model_GradeSheet();
        $gradesheet_number = $GradeSheet_model->getGradeSheetNumber($academic_id, $year_id, $stu_id);
        $this->view->gradesheet_number = $gradesheet_number;

        //------------------------------[Print Option According to Mode]-------------------//
        $htmlcontent = $this->view->render('application/ajax-get-back-grade-view.phtml');
        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }
        
        //======for PDF
        $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, $stuname . '-' . $filename, 'L', $pge_height);
        echo "hii"; die;
        //-----------------------[END]--------------------//       
    }

    public function getPasspercent($degree_id = '', $session = '') {
        try {
            if (!empty($degree_id)) {
                $ReferenceGradeMasterItems_model = new Application_Model_ReferenceGradeMasterItems();
                $ref_grades = $ReferenceGradeMasterItems_model->getRecordsByAcademicId(0, $degree_id, $session);

                $arr_ref_number_grade_all = $this->mergData($ref_grades, array('number_grade'), count($ref_grades));
                $arr_ref_number_grade_all = array_filter($arr_ref_number_grade_all, function ($value) {
                    return $value > 0;
                });
                $min_pass_percent = min($arr_ref_number_grade_all);

                $min_pass_percent = count($ref_grades) == 0 ? 0 : $min_pass_percent;

                $range = $ReferenceGradeMasterItems_model->getRecordsByNumgrade($min_pass_percent, $degree_id, $session);

                $min_pass_percent = count($ref_grades) == 0 ? 0 : min($range);

                return $min_pass_percent;
            }
            throw new Exception('$degree_id should not be empty !');
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    //==================get fail pass student details===========================//  
    public function getReports($stu_id, $academic_id, $year_id, $term_id, $arc_status = false, $type = "") {
        
      
        

        $result = array();
        $student_info = new Application_Model_StudentPortal();
        $tabulation_report = new Application_Model_TabulationReport();
        $eval_component = new Application_Model_EvaluationComponentsItems();
        $term_details = new Application_Model_TermMaster();
        $academic_details = new Application_Model_Academic();
        $Corecourselearning_model = new Application_Model_Corecourselearning();

//        $term_id = $term_details->getTermRecordsbycmn($academic_id,$term_id)['term_id'];

        $result['core_course_span'] = $Corecourselearning_model->getcorecourse($academic_id, $term_id);

        $cc_id = $Corecourselearning_model->getOnCC($academic_id, $term_id);

        $course_type_result = $this->geStudentCourse($academic_id, $term_id, $stu_id);
        
        $course_type_result = array_values($course_type_result);

        $course_ids = $this->selectData($course_type_result, array('course_id'), count($course_type_result));

        $compo_count = array();
        $key_val = array();
        foreach ($course_ids as $key => $value) {
            $component_res = $eval_component->getRecordsByCourse($value['course_id']);
            $compo_count[] = count($component_res);
            $key_val[count($component_res)] = $component_res;
        }


        $result['max_num'] = $key_val[max($compo_count)];

        $result['formated_result'] = $this->stackData($cc_id, $course_type_result);
        $result['get_student_sgpa'] = $tabulation_report->fetchStudentSgpa($academic_id, $term_id, $stu_id);
        
       //print_r( $result['get_student_sgpa']); die();

        if ($result['get_student_sgpa']['btbl_id']) {
            $result['btabulation_id'] = $result['get_student_sgpa']['tabl_id'];
            $result['dateTerm_id'] = $term_id;
            $result['noncoldate'] = $result['get_student_sgpa']['publish_date'];
            $result['bid'] = $result['get_student_sgpa']['btbl_id'];
        } else {

            $result['tabulation_id'] = $result['get_student_sgpa']['tabl_id'];
        }

        $result['tabulation_id'] = $result['btabulation_id'] ? $result['btabulation_id'] : $result['get_student_sgpa']['tabl_id'];
        if (!$result['tabulation_id']) {
            return false;
        }

        $result['student_course_marks'] = $this->getStudentMarks($academic_id, $result['tabulation_id'], $stu_id, $term_id, $arc_status, $type);
        // if($term_id == '639'){
        //     echo "<pre>";print_r($result['student_course_marks']);exit;
        // }
      //  echo "<prE>";print_r($result['student_course_marks']);exit;

        $result['student_details'] = $student_info->getRecord($stu_id);
        $result['term_details'] = $term_details->getRecord($term_id);
        $result['academic_details'] = $academic_details->getRecord($academic_id);
       
        return $result;

       
     
       
   }
 

    //==================get fail pass student details===========================//  
    public function getBackReports($stu_id, $academic_id, $year_id, $term_id, $arc = false, $type = "") {
        
       // echo $term_id;
     //    exit;
        $result = array();
        $student_info = new Application_Model_StudentPortal();

        $tabulation_report = new Application_Model_TabulationReport();
        $eval_component = new Application_Model_EvaluationComponentsItems();
        $term_details = new Application_Model_TermMaster();
        $academic_details = new Application_Model_Academic();
        $Corecourselearning_model = new Application_Model_Corecourselearning();

        $result['core_course_span'] = 0;
//             $term_id = $term_details->getTermRecordsbycmn($academic_id,$term_id)['term_id'];
        $cc_id = $Corecourselearning_model->getOnCC($academic_id, $term_id);

        $course_type_result = $this->geStudentBackPaperCourse($academic_id, $term_id, $stu_id);
 //echo "<pre>";print_r($course_type_result);exit;
        $course_type_result = array_values($course_type_result);
        $course_ids = $this->selectData($course_type_result, array('course_id'), count($course_type_result));

        $compo_count = array();
        foreach ($course_ids as $key => $value) {
            $component_res = $eval_component->getRecordsByCourse($value['course_id']);
            $compo_count[] = count($component_res);
            $key_val[count($component_res)] = $component_res;
        }
        $result['max_num'] = $key_val[max($compo_count)];
        $result['formated_result'] = $this->stackData($cc_id, $course_type_result);
        // echo "<pre>"; print_r($result);exit;
        $result['get_student_sgpa'] = $tabulation_report->fetchStudentSgpa($academic_id, $term_id, $stu_id);

        if ($result['get_student_sgpa']['btbl_id']) {
            $result['btabulation_id'] = $result['get_student_sgpa']['btbl_id'];
            $result['dateTerm_id'] = $term_id;
        } else {

            $result['tabulation_id'] = $result['get_student_sgpa']['tabl_id'];
        }

        $result['tabulation_id'] = $result['btabulation_id'] ? $result['btabulation_id'] : $result['get_student_sgpa']['tabl_id'];
        if (!$result['tabulation_id']) {
            return false;
        }
        $result['student_course_marks'] = $this->getBackStudentMarks($academic_id, $result['tabulation_id'], $stu_id, $term_id, $arc, $type);
       // echo "<pre>";print_r($result['student_course_marks']);exit;
        //   echo $academic_id;die;
        $result['student_details'] = $student_info->getRecord($stu_id);
        $result['term_details'] = $term_details->getRecord($term_id);
        $result['academic_details'] = $academic_details->getRecord($academic_id);
        //echo "<pre>";print_r($result);exit;
        return $result;
    }

    public function secondyeargradesheetreportNEWAction() {

        $this->view->close = '';
        $check = $_POST['username'];
        $stu_id = $this->_getParam("id");
        $academic_id = $this->_getParam("acd_id");
        $year_id = $this->_getParam("year");
        $mode = $this->_getParam("mode");
        $term_id = $this->_getParam("term");
        $this->view->term_id = $term_id;
        $this->view->year_id = $year_id;

        $student_info = new Application_Model_StudentPortal();
        $tabulation_report = new Application_Model_TabulationReport();
        $eval_component = new Application_Model_EvaluationComponentsItems();
        $term_details = new Application_Model_TermMaster();
        $academic_details = new Application_Model_Academic();
        $Corecourselearning_model = new Application_Model_Corecourselearning();
        $core_course_span = $Corecourselearning_model->getcorecourse($academic_id, $term_id);

        $cc_id = $Corecourselearning_model->getOnCC($academic_id, $term_id);

        $course_type_result = $this->geStudentCourse($academic_id, $term_id, $stu_id);

        $course_ids = $this->selectData($course_type_result, array('course_id'), count($course_type_result));
        $compo_count = array();
        $key_val = array();
        foreach ($course_ids as $key => $value) {
            $component_res = $eval_component->getRecordsByCourse($value['course_id']);
            $compo_count[] = count($component_res);
            $key_val[count($component_res)] = $component_res;
        }

        $max_num = max($compo_count);

        $formated_result = $this->stackData($cc_id, $course_type_result);

        $get_student_sgpa = $tabulation_report->fetchStudentSgpa($academic_id, $term_id, $stu_id);

        $tabulation_id = $get_student_sgpa['tabl_id'];

        $student_course_marks = $this->getStudentMarks($academic_id, $tabulation_id, $stu_id, $term_id);

        $student_details = $student_info->getRecord($stu_id);
        $term_details = $term_details->getRecord($term_id);
        $academic_details = $academic_details->getRecord($academic_id);

        $this->view->student_marks_details = $student_course_marks;
        $this->view->stu_sgpa = $get_student_sgpa['sgpa'];
        $this->view->stu_fail_in = $get_student_sgpa['fail_in_ct_ids'];
        $this->view->stu_details = $student_details;
        $this->view->stu_term_details = $term_details;
        $this->view->stu_academic_details = $academic_details;
        $this->view->stu_course = $formated_result;
        $this->view->header_component = $key_val[$max_num];
        $this->view->corespan = count($core_course_span);

        $htmlcontent = $this->view->render('report/secondyeargradesheetreport.phtml');
        //

        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }
        $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, $student_details['stu_fname'] . '-' . $academic_details['short_code'] . '-' . $term_details['term_name'] . '-Gradde-Report');
    }

    public function geStudentCourse($academic_id, $term_id, $stu_id) {
        $Corecourselearning_model = new Application_Model_Corecourselearning();
        $core_courses = $Corecourselearning_model->getcorecourse($academic_id, $term_id);
        //echo "<pre>";print_r($core_courses);exit;
        $student_ge = $Corecourselearning_model->getStudentGE($academic_id, $term_id, $stu_id);
// if($term_id == 639){
//         echo "<pre>";print_r($student_ge);exit;
//         }
        foreach ($student_ge as $key => $value) {
            $checkarr = false;
            foreach ($core_courses as $keycore => $valuecore) {
                if ($valuecore['ge_id'] != 0 && $valuecore['ge_id'] != 35 && $valuecore['ge_id'] != 36) {
                    if ($valuecore['course_id'] == $value['course_id']) {
                        $checkarr = TRUE;
                    } else {
                        $checkarr = $keycore;
                    }
                }
                else if (($valuecore['ge_id'] == 35 || $valuecore['ge_id'] == 36) || ($value['ge_id'] == 35 || $value['ge_id'] == 36)) 
                {
                    $student_ge[$key]['ge_id'] = 0;
                    $student_ge[$key]['cc_name'] = "Core Course (CC)";
                    
                }
            }
            if ($checkarr !== TRUE and $checkarr !== FALSE)
                unset($core_courses[$checkarr]);
        }

        $course_type_result = array_merge($core_courses, $student_ge);

        return $course_type_result;
    }

    public function geStudentBackPaperCourse($academic_id, $term_id, $stu_id) {
        $Corecourselearning_model = new Application_Model_Corecourselearning();
        $examDateModel = new Application_Model_ExamDateModel();
        $academic_model = new Application_Model_Academic();
        $term_Model = new Application_Model_TermMaster();
        $acad_details = $academic_model->getRecord($academic_id);
        $term_details = $term_Model->getRecord($term_id);
        $requiredData = array(
            'acad_id' => $academic_id,
            'term' => $term_details['cmn_terms'],
            'session' => $acad_details['session'],
            'exam_type' => 2
        );

        $examinationDates = $examDateModel->getRecordByAcadId($requiredData);
        $this->_month_num = date("m-Y", strtotime($examinationDates['exam_date']));

        if ($this->_month_num == "01-1970") {
            $this->_message('Dates not available.');
        }
        
      // echo "<pre>";print_r($this->_month_num);exit;
        //$core_courses = $Corecourselearning_model->getcorecourse($academic_id, $term_id);
        //$student_ge = $Corecourselearning_model->getBackStudentGE($academic_id, $term_id,$stu_id,$this->_month_num);
        $student_ge = $Corecourselearning_model->getBackStudentGE($academic_id, $term_id, $stu_id,$this->_month_num);
        
        foreach ($student_ge as $key => $value) {
           
             if ($value['ge_id'] == 35 || $value['ge_id'] == 36) 
                {
                    $student_ge[$key]['ge_id'] = 0;
                    $student_ge[$key]['cc_name'] = "Core Course (CC)";
                    
                }
        }

        $course_type_result = $student_ge;
        return $course_type_result;
    }

    public function getStudentMarks($academic_id, $tabulation_id, $stu_id, $term_id, $arc_status = false, $type = "") {


        $GradeAllocationReport = new Application_Model_GradeAllocationReportItems();
        $GradeMaster = new Application_Model_GradeAllocation();
        $getStudent_course_details = $GradeAllocationReport->getMarksDetailsWithCourse($tabulation_id, $stu_id, $term_id);
        
        foreach ($getStudent_course_details as $key => $value) {
            $getStudent_course_details[$key]['number_value'] = '';
            $getStudent_course_details[$key]['grade_value'] = '';
            if ($arc_status) {
                if ($type === 'B') {
                    $getStudent_course_details[$key]['number_value'] = $GradeMaster->getdeletedGradeRecordson($academic_id, $term_id, $value['course_id'], $stu_id, $arc_status)['number_value'];
                    $getStudent_course_details[$key]['grade_value'] = $GradeMaster->getdeletedGradeRecordson($academic_id, $term_id, $value['course_id'], $stu_id, $arc_status)['grade_value'];
                } else if ($type === 'R') {
                    $getStudent_course_details[$key]['number_value'] = $GradeMaster->getdeletedRevalGradeRecordson($academic_id, $term_id, $value['course_id'], $stu_id, $arc_status)['number_value'];
                    $getStudent_course_details[$key]['grade_value'] = $GradeMaster->getdeletedRevalGradeRecordson($academic_id, $term_id, $value['course_id'], $stu_id, $arc_status)['grade_value'];
                }
            }
            if (empty($getStudent_course_details[$key]['number_value'])) {
                $getStudent_course_details[$key]['number_value'] = $GradeMaster->getGradeRecordsOn($academic_id, $term_id, $value['course_id'], $stu_id)['number_value'];
                $getStudent_course_details[$key]['grade_value'] = $GradeMaster->getGradeRecordsOn($academic_id, $term_id, $value['course_id'], $stu_id)['grade_value'];
            }
        }
               
       // echo "<pre>";print_r($getStudent_course_details);exit;

        return $getStudent_course_details;
    }

    public function getBackStudentMarks($academic_id, $tabulation_id, $stu_id, $term_id, $arc_status = false, $type = "") {

        $GradeAllocationReport = new Application_Model_BackGradeAllocationReportItems();
        $GradeMaster = new Application_Model_GradeAllocation();
        
        $getStudent_course_details = $GradeAllocationReport->getMarksDetailsWithCourse($tabulation_id, $stu_id, $term_id);
        $examDateModel = new Application_Model_ExamDateModel();
        $academic_model = new Application_Model_Academic();
        $term_Model = new Application_Model_TermMaster();
        $acad_details = $academic_model->getRecord($academic_id);
        $term_details = $term_Model->getRecord($term_id);
        
        $requiredData = array(
            'acad_id' => $academic_id,
            'term' => $term_details['cmn_terms'],
            'session' => $acad_details['session'],
            'exam_type' => 2
        );

     
        $examinationDates = $examDateModel->getRecordByAcadId($requiredData);
        $this->_month = date("M-Y", strtotime($examinationDates['exam_date']));
        
      //  echo "<pre>";print_r($getStudent_course_details);exit;
        if ($this->_month == "01-1970") {
            $this->_message('Dates not available.');
        }
        foreach ($getStudent_course_details as $key => $value) {
            if ($arc_status) {
                if ($type === 'R') {
                    $getStudent_course_details[$key]['number_value'] = $GradeMaster->getdeletedBackRevalGradeRecordson($academic_id, $term_id, $value['course_id'], $stu_id, $arc_status)['number_value'];
                    $getStudent_course_details[$key]['grade_value'] = $GradeMaster->getdeletedBackRevalGradeRecordson($academic_id, $term_id, $value['course_id'], $stu_id, $arc_status)['grade_value'];
                }
            } else {
                $getStudent_course_details[$key]['number_value'] = $GradeMaster->getGradeRecordsOnBack($academic_id, $term_id, $value['course_id'], $stu_id, $this->_month)['number_value'];
                $getStudent_course_details[$key]['grade_value'] = $GradeMaster->getGradeRecordsOnBack($academic_id, $term_id, $value['course_id'], $stu_id, $this->_month)['grade_value'];
            }
            if (empty($getStudent_course_details[$key]['number_value']) && empty($getStudent_course_details[$key]['grade_value']))
                unset($getStudent_course_details[$key]);
        }
   // echo "<pre>";print_r($getStudent_course_details);die;
        return array_values($getStudent_course_details);
    }

    public function ajaxGetTodoListReportAction() {
        $empl_id = $this->_getParam('empl_id');
        $toDo_model = new Application_Model_ToDo();
        $not_started_in_percent = $in_progress_in_percent = $completed_in_percent = 0;

        if ($empl_id) {
            $not_started = $toDo_model->getTodoData($empl_id, 1);
            $completed = $toDo_model->getTodoData($empl_id, 3);
            $in_progress = $toDo_model->getTodoData($empl_id, 2);

            $total = $not_started + $completed + $in_progress;
            //coverting in percentage 
            $not_started_in_percent = round(($not_started / $total) * 100);
            $in_progress_in_percent = round(($in_progress / $total) * 100);
            $completed_in_percent = round(($completed / $total) * 100);
        } else {
            $not_started = $toDo_model->getTodoDataByStatus(1);
            $completed = $toDo_model->getTodoDataByStatus(3);
            $in_progress = $toDo_model->getTodoDataByStatus(2);
            $total = $not_started + $completed + $in_progress;
            $not_started_in_percent = round(($not_started / $total) * 100);
            $in_progress_in_percent = round(($in_progress / $total) * 100);
            $completed_in_percent = round(($completed / $total) * 100);
        }
        echo json_encode(array('in_progress' => $in_progress_in_percent,
            'not_started' => $not_started_in_percent,
            'completed' => $completed_in_percent,
            'not_started_in_no' => $not_started,
            'in_progress_in_no' => $in_progress,
            'completed_in_no' => $completed, 'total' => $total));

        exit;
    }

    public function ajaxGetMonthlyAttendanceAction() {
        $academicModel = new Application_Model_Academic();
        $termModel = new Application_Model_TermMaster();

        $acadId = $this->_getParam('acadId');
        $termId = $this->_getParam('termId');
        $sessionDept = $academicModel->getDepartment($acadId);
        $cmnTerm = $termModel->getRecord($termId);
        $requiredData = array(
            'session' => $sessionDept['session'],
            'department' => $sessionDept['department'],
            'cmn_terms' => $cmnTerm['cmn_terms']
        );

        $attendanceModel = new Application_Model_BatchAttendance();

        $getRecord = $attendanceModel->getRecordforDashBoard($requiredData);

        $month = $totalClass = 0;
        $dateData = array();
        $classData = array();

//        foreach ($getRecord as $key => $value) {
//            array_push($dateData,$value['effective_date']);
//            
//        }
//        foreach ($getRecord as $key => $value) {
//            array_push($classData,$value['conducted_class']);
//        }
//           
        //echo '<pre>';print_r($getRecord);exit;
        echo json_encode($getRecord);
        exit;
    }

    public function studentCgpaReportAction() {
        $this->view->action_name = 'student-cgpa-report';
        $this->view->sub_title_name = 'Participants GPA/CGPA Report';
        $this->accessConfig->setAccess('SA_ACAD_CGPA_GPA');
        $student_report_form = new Application_Form_StudentReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    private function filterGPA($grades, $exp_grades, $c_type, $term_id, $student_id, $is_gpa) {
        $rs = 0;
        if ($c_type == 'term') {//If current grade is term
            //echo $batch_id. $c_type. $term_id. $student_id. $is_gpa;exit;
            //print_r($grades);
            //print_r($exp_grades);exit;
            foreach ($grades as $row) {
                if (($term_id == $row['term_id']) && $student_id == $row['student_id']) {
                    if ($is_gpa) {
                        $rs = $row['final_grade'];
                    } else {
                        $rs = $row['cgpa'];
                    }
                    break;
                }
            }
        } elseif ($c_type == 'el') {

            foreach ($exp_grades as $row) {
                if (($term_id == $row['course_id']) && $student_id == $row['student_id']) {
                    if ($is_gpa) {
                        $rs = $row['final_grade_point'];
                    } else {
                        $rs = $row['cgpa'];
                    }
                    break;
                }
            }
        }
        return $rs;
    }

    public function ajaxStudentCgpaReportAction() {
        $this->_helper->layout->disableLayout();
        $academic_year_id = $this->_getParam("academic_id");
        $academic_model = new Application_Model_Academic();
        $batch_map = $academic_model->getAcademicDesignOrderByDate($academic_year_id);
        $this->view->batch_map = $batch_map;
        //print_r($batch_map);exit;

        $CourseGradeAfterpenalties_model = new Application_Model_CourseGradeAfterpenalties();
        $grades = $CourseGradeAfterpenalties_model->getAllGradesByBatch($academic_year_id);

        $expGradeAllocation_model = new Application_Model_ExperientialGradeAllocation();
        $exp_grades = $expGradeAllocation_model->getAllGradesByBatch($academic_year_id);

        $StudentPortal_model = new Application_Model_StudentPortal();
        $students = $StudentPortal_model->getStudentsSortByName($academic_year_id);

        $student_grades = array();
        foreach ($students as $student) {
            $student_grade = array();
            //$student_grade['student_id'] = $student['student_id'];
            $student_grade['stu_id'] = $student['stu_id'];
            $student_grade['stu_name'] = $student['stu_fname'] . ' ' . $student['stu_lname'];
            foreach ($batch_map as $map) {//GPA
                $student_grade[$map['c_type'] . $map['id']] = $this->filterGPA($grades, $exp_grades, $map['c_type'], $map['id'], $student['student_id'], TRUE);
            }
            foreach ($batch_map as $map) {//CGPA
                $student_grade[$map['c_type'] . $map['id'] . 'cgpa'] = $this->filterGPA($grades, $exp_grades, $map['c_type'], $map['id'], $student['student_id'], FALSE);
            }
            $student_grades[] = $student_grade;
        }
        $this->view->student_grades = $student_grades;
    }

    public function ajaxGetRecentTermAndBatchAction() {

        $academic_name = '';
        $start_date = '';
        $end_date = '';
        $my_date = $this->_getParam('my_date');
        $date = date_create($my_date);
        $term = new Application_Model_TermMaster();
        $result = $term->getTermOnDate($my_date);

        foreach ($result as $key) {
            $term_start = explode("/", $key['start_date']);
            $term_end = explode("/", $key['end_date']);
            $start = date_create($term_start[2] . "-" . $term_start[1] . "-" . $term_start[0]);
            $end = date_create($term_end[2] . "-" . $term_end[1] . "-" . $term_end[0]);

            if (strtotime(date_format($date, "Y-m-d")) >= strtotime(date_format($start, "Y-m-d")) && strtotime(date_format($date, "Y-m-d")) <= strtotime(date_format($end, "Y-m-d"))) {
                $term_id = $key['term_id'];
                $academic_year_id = $key['academic_year_id'];
                $start_date = date_format($start, "Y-m-d");
                $end_date = date_format($end, "Y-m-d");
                $term_name = $key['term_name'];
                $academic_name = $key['academic_name'];
                break;
            }
        }
        $result['recent']['batch_id'] = $academic_year_id;
        $result['recent']['term_id'] = $term_id;

        echo json_encode($result['recent']);
        exit;
    }

// get batchscheduleSessions
    public function ajaxGetBatchSceduleSessionsAction() {
        $term_id = '';
        $term_id = $this->_getParam('term_id');
        $academic_year_id = $this->_getParam('batch_id');
        $limit = (int) $this->_getParam('top_id');
        $academic_name = '';
        $start_date = '';
        $end_date = '';
        $course_details = new Application_Model_Attendance();

        $term = new Application_Model_TermMaster();
        $result = $term->getTermOnDat1($term_id, $academic_year_id);

        $term_start = explode("/", $result[0]['start_date']);
        $term_end = explode("/", $result[0]['end_date']);
        $start = $term_start[2] . "-" . $term_start[1] . "-" . $term_start[0];
        $end = $term_end[2] . "-" . $term_end[1] . "-" . $term_end[0];

        //getting all the courses 

        $courses = $course_details->getCourseDetails($term_id, $academic_year_id);

        $version_id = $term->getMaxVersion(date('d-m-Y', strtotime($start)));

        //   print_r($start); exit;
        if (count(Courses) > 0) {
            $result['course_details'] = $this->getCourseNames($courses, $start, $end, $academic_year_id, $term_id, $version_id['version'], $limit);
            // print_r($result['course_count']);exit;
        } else {
            echo 'No Courses';
            exit;
        }
        foreach ($result['course_details'] as $key => $value) {
            $result['course_details'][$key]['course_count'] = $result['course_details']['course_count'][$key];
        }
        echo json_encode($result['course_details']);
        exit;
    }

    //function to get course names
    public function getCourseNames(array $courses, $start_date, $end_date, $batch_id, $term_id, $version, $limit = '3') {
        $details = new Application_Model_Attendance();
        $course_name = new Application_Model_TermMaster();
        $class_master = new Application_Model_ClassMaster();
        $result = array();
        $i = 0;
        $no_of_classes = $class_master->getRecordByTermIdAndBatch($term_id, $batch_id);
        //========[CLASS FIELD NAME FROM DATABASE ATTENDANCE]=========//
        $join_arr[] = 'class';
        $join_arr[] = 'faculty';
        foreach ($join_arr as $key => $value) {
            for ($dcl = 1; $dcl <= $no_of_classes; $dcl++)
                $class_arr[] = $value . "_$dcl";
            $faculty_arr[] = $value . "_$dcl";
        }
        $all_arr = array();
        foreach ($courses as $key) {
            $result[$key['course_id']] = $course_name->getCourseName($key['course_id']);
            $result1[$key['course']] = $details->getCourseCoordinator($key['course_id'], $batch, $term_id);
            foreach ($class_arr as $key1 => $value) {
                if ($details->getClass($value, $key['course_id']) > 0) {
                    $all_arr[$key['course_id']]['course_name'] = $result[$key['course_id']]['course_code'];
                    $all_arr[$key['course_id']]['DMI_Faculty'] += $details->getFacultyId($faculty_arr[$key1], 'EMP-F', $value, $result1[$key['course']]['employee_id'], $key['course_id']);
                    $all_arr[$key['course_id']]['Visiting_Faculty'] += $details->getFacultyId($faculty_arr[$key1], 'VF', $value, '', $key['course_id']);
                    $all_arr[$key['course_id']]['course_coodinator'] += $details->getFacultyId($faculty_arr[$key1], $result1[$key['course']]['employee_id'], $value, '', $key['course_id']);
                    $all_arr[$key['course_id']]['average'] = ((int) $all_arr[$key['course_id']]['DMI Faculty'] + (int) $all_arr[$key['course_id']]['Visiting Faculty']) + (int) $all_arr[$key['course_id']]['course_coodinator'] / 2;
                } else {
                    $all_arr[$key['course_id']]['course_name'] = $result[$key['course_id']]['course_code'];
                    $all_arr[$key['course_id']]['DMI_Faculty'] += 0;
                    $all_arr[$key['course_id']]['Visiting_Faculty'] += 0;
                    $all_arr[$key['course_id']]['course_coodinator'] += 0;
                }
            }
        }


        //==========[REPORT FOR PANALTIES]===========//
        $penalities_student = array();
        $Suffled_penalty_value = array();
        $result_sorted = array();
        $max_penalties_value = array();
        foreach ($courses as $key) {
            $result[$key['course_id']] = $course_name->getCourseName($key['course_id']);
            $penalties_student = $course_name->getPenalties($key['course_id'], $term_id);
            foreach ($penalties_student as $penalty_key => $penalty) {
                $temp = array_map('floatVal', explode(',', $penalty['academic_grades']));
                $Suffled_penalty_value[$key['course_id']][$penalty_key] = $temp[$penalty['courses_position'] - 1];
                asort($Suffled_penalty_value[$key['course_id']]);
                $Suffled_penalty_value[$key['course_id']] = array_reverse($Suffled_penalty_value[$key['course_id']]);
                $result_sorted[$key['course_id']]['top'] = array_slice(array_unique($Suffled_penalty_value[$key['course_id']]), 0, $limit);
                $result_sorted[$key['course_id']]['course_name'] = $result[$key['course_id']]['course_code'];
            }
        }
        // 

        foreach ($result_sorted as $key => $value) {

            if (count($value['top']) < $limit) {
                for ($i = count($value['top']); $i <= ((int) $limit - count($value['top'])); $i++) {
                    $result_sorted[$key]['top'][$i] = 0;
                }
            }
        }

        // echo "<pre>"; print_r($result_sorted);exit;

        $result['faculty_sessions'] = $all_arr;
        $result['student_penalties'] = $result_sorted;
        return $result;
    }

    public function ajaxGetBatchSceduleSessions1Action() {
        $term_id = '';
        $term_id = $this->_getParam('term_id');
        $academic_year_id = $this->_getParam('batch_id');
        $empl_id = $this->_getParam('empl');
        $limit = (int) $this->_getParam('top_id');
        $academic_name = '';
        $start_date = '';
        $end_date = '';
        $course_details = new Application_Model_Attendance();
        $term = new Application_Model_TermMaster();
        $result = $term->getTermOnDat1($term_id, $academic_year_id);

        $term_start = explode("/", $result[0]['start_date']);
        $term_end = explode("/", $result[0]['end_date']);
        $start = date_create($term_start[2] . "-" . $term_start[1] . "-" . $term_start[0]);
        $end = date_create($term_end[2] . "-" . $term_end[1] . "-" . $term_end[0]);

        //getting all the courses 

        $courses = $course_details->getCourseDetails($term_id, $academic_year_id, $empl_id);
        //print_r($courses);exit;
        $version_id = $term->getMaxVersion(date_format($start, "d-m-Y"));

        if (count(Courses) > 0) {
            $result['course_details'] = $this->getCourseNames1($courses, date_format($start, "Y-m-d"), date_format($end, "Y-m-d"), $academic_year_id, $term_id, $version_id['version'], $limit);
            // print_r($result['course_count']);exit;
        } else {
            echo 'No Courses';
            exit;
        }
        foreach ($result['course_details'] as $key => $value) {
            $result['course_details'][$key]['course_count'] = $result['course_details']['course_count'][$key];
        }
        echo json_encode($result['course_details']);
        exit;
    }

    //function to get course names
    public function getCourseNames1(array $courses, $start_date, $end_date, $batch_id, $term_id, $version, $limit = '3') {

        $course_name = new Application_Model_TermMaster();
        $result = array();
        $i = 0;
        foreach ($courses as $key) {
            $result[$key['course_id']] = $course_name->getCourseName($key['course_id']);
        }

        foreach ($result as $key => $value) {
            $result['course_count'][$key] = (int) $course_name->getCourseReport1($value['course_code'], $batch_id, $term_id, $version);
        }

        return $result;
    }

    public function getCourseNameOnlyAction() {
        $course_id = $this->_getParam('course_id');
        $result[$course_id] = $course_name->getCourseName($course_id);
        echo json_encode($course_id);
        exit;
    }

    public function ajaxGetRatingInstructorAction() {
        $course = $this->_getParam('course');
        $instructor = $this->_getParam('instructor');
        $question_model = new Application_Model_Questionnaire();
        $rating_model = new Application_Model_RatingMaster();
        $student_feed_model = new Application_Model_StudentFeed();
        $instructor_feed = new Application_Model_InstructorFeed();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam('term_id');
            $batch_id = $this->_getParam('academic_year_id');
            $course_id = $this->_getParam('course_id');
            $instructor = $this->_getParam('instructor_id');

            $result['rating_five_no'] = $rating_five = $instructor_feed->getRatingCount($term_id, $batch_id, $instructor, $course_id, 5);
            $result['rating_four_no'] = $rating_four = $instructor_feed->getRatingCount($term_id, $batch_id, $instructor, $course_id, 4);
            $result['rating_three_no'] = $rating_three = $instructor_feed->getRatingCount($term_id, $batch_id, $instructor, $course_id, 3);
            $result['rating_two_no'] = $rating_two = $instructor_feed->getRatingCount($term_id, $batch_id, $instructor, $course_id, 2);
            $result['rating_one_no'] = $rating_one = $instructor_feed->getRatingCount($term_id, $batch_id, $instructor, $course_id, 1);

            $result['rating_five_label'] = ucfirst($student_feed_model->getRatingLabel(5));
            $result['rating_four_label'] = ucfirst($student_feed_model->getRatingLabel(4));
            $result['rating_three_label'] = ucfirst($student_feed_model->getRatingLabel(3));
            $result['rating_two_label'] = ucfirst($student_feed_model->getRatingLabel(2));
            $result['rating_one_label'] = ucfirst($student_feed_model->getRatingLabel(1));

            //==[toal number of ratings]=======//
            $result['total_no'] = $total_rating = $rating_one + $rating_two + $rating_three + $rating_four + $rating_five;
            //=====[finding percentage]=======//
            $result['rating_five_percent'] = $rating_five_percent = round(($rating_five / $total_rating) * 100) . "%";
            $result['rating_four_percent'] = $rating_four_percent = round(($rating_four / $total_rating) * 100) . "%";
            $result['rating_three_percent'] = $rating_three_percent = round(($rating_three / $total_rating) * 100) . "%";
            $result['rating_two_percent'] = $rating_two_percent = round(($rating_two / $total_rating) * 100) . "%";
            $result['rating_one_percent'] = $rating_one_percent = round(($rating_one / $total_rating) * 100) . "%";

            echo json_encode($result);
            exit;
        }
    }

    public function ajaxGetRatingAction() {
        $course = $this->_getParam('course');
        $instructor = $this->_getParam('instructor');
        $question_model = new Application_Model_Questionnaire();
        $rating_model = new Application_Model_RatingMaster();
        $student_feed_model = new Application_Model_StudentFeed();
        $instructor_feed = new Application_Model_InstructorFeed();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam('term_id');
            $batch_id = $this->_getParam('academic_year_id');
            $course_id = $this->_getParam('course_id');
            $instructor = $this->_getParam('instructor_id');

            $result['rating_five_no'] = $rating_five = $student_feed_model->getRatingCount($term_id, $batch_id, $course_id, 5);
            $result['rating_four_no'] = $rating_four = $student_feed_model->getRatingCount($term_id, $batch_id, $course_id, 4);
            $result['rating_three_no'] = $rating_three = $student_feed_model->getRatingCount($term_id, $batch_id, $course_id, 3);
            $result['rating_two_no'] = $rating_two = $student_feed_model->getRatingCount($term_id, $batch_id, $course_id, 2);

            $result['rating_one_no'] = $rating_one = $student_feed_model->getRatingCount($term_id, $batch_id, $course_id, 1);

            $result['rating_five_label'] = ucfirst($student_feed_model->getRatingLabel(5));
            $result['rating_four_label'] = ucfirst($student_feed_model->getRatingLabel(4));
            $result['rating_three_label'] = ucfirst($student_feed_model->getRatingLabel(3));
            $result['rating_two_label'] = ucfirst($student_feed_model->getRatingLabel(2));
            $result['rating_one_label'] = ucfirst($student_feed_model->getRatingLabel(1));
            //==[toal number of ratings]=======//
            $result['total_no'] = $total_rating = $rating_one + $rating_two + $rating_three + $rating_four + $rating_five;
            //=====[finding percentage]=======//
            $result['rating_five_percent'] = $rating_five_percent = round(($rating_five / $total_rating) * 100) . "%";
            $result['rating_four_percent'] = $rating_four_percent = round(($rating_four / $total_rating) * 100) . "%";
            $result['rating_three_percent'] = $rating_three_percent = round(($rating_three / $total_rating) * 100) . "%";
            $result['rating_two_percent'] = $rating_two_percent = round(($rating_two / $total_rating) * 100) . "%";
            $result['rating_one_percent'] = $rating_one_percent = round(($rating_one / $total_rating) * 100) . "%";

            echo json_encode($result);
            exit;
            $this->view->result = $result;
        }
    }

    public function ajaxGetCourseAction() {
        $course_details = new Application_Model_Attendance();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            $batch_id = $this->_getParam('academic_year_id');
            $result = $course_details->getCourseDetails($term_id, $batch_id);
            // print_r($result);exit;
            foreach ($result as $value) {
                echo '<option value="' . $value['course_id'] . '" >' . $value['course_code'] . '</option>';
            }
        }die;
    }

    public function ajaxGetQuestionAction() {
        $ratings1 = new Application_Model_RatingMaster();

        $questions = new Application_Model_Questionnaire();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            $batch_id = $this->_getParam('batch_id');
            $course_id = $this->_getParam('course');
            $empl_id = $this->_getParam('empl');

            $ratings = $ratings1->getRecords1();
            $result['question_array'] = array();
            $result['feed_question'] = $questions->getAllQuestionByEmpl($batch_id, $term_id, $course_id, $empl_id);
            foreach ($ratings as $rating_key => $rating_value) {
                foreach ($result['feed_question'] as $ques_key => $ques_value) {
                    $question = $ques_value['question'];
                    $result['question_array'][$questions->getAllQuestionName($question)][0] = $questions->getAllQuestionName($question);
                }
            }
            foreach ($ratings as $rating_key => $rating_value) {
                $feed = $rating_value['rating_value'];
                foreach ($result['feed_question'] as $ques_key => $ques_value) {
                    $question = $ques_value['question'];

                    $result['feed'][$ratings1->getRecordsByRatings($feed)][$questions->getAllQuestionName($question)] = $questions->getAllQuestionByEmplFeed($batch_id, $term_id, $course_id, $empl_id, $feed, $question);
                }
            }

            foreach ($result['feed'] as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    foreach ($result['question_array'] as $ques_key => $ques_value) {
                        if ($key1 === $ques_key) {
                            $result['question_array'][$ques_key][count($result['question_array'][$ques_key])] = $value1;
                        }
                    }
                }
            }


            foreach ($result['question_array'] as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    if ($key1 == count($result['question_array'][$key]) - 1)
                        $result['question_array'][$key][count($result['question_array'][$key])] = '';
                }
            }

            //   echo "<pre>";print_r($result['question_array']);exit;
            $result['all_question'] = $questions->getAllQuestionByQuestionType(2);
            echo json_encode($result);
            exit;
        }
    }

    public function ajaxGetFacultyAction() {
        $employee_model = new Application_Model_HRMModel();
        $faculty = new Application_Model_Attendance();
        $class_master = new Application_Model_ClassMaster();
        $term_id = $this->_getParam('term_id');
        $batch_id = $this->_getParam('academic_year_id');
        $course_id = $this->_getParam('course_id');
        /* $result = $faculty->getFaculty($term_id, $batch_id, $course_id); */
        $no_of_classes = $class_master->getRecordByTermIdAndBatch($term_id, $batch_id);
        echo '<pre>';
        print_r($no_of_classes);
        exit;

        $result = $faculty->getFeedFaculty($term_id, $batch_id, $course_id, $no_of_classes);
        $index = 0;
        $facultyFeed = array();
        foreach ($result as $key => $value) {
            foreach ($value as $new_key => $new_value) {
                if ($new_value == $course_id) {
                    $fac = explode('_', $new_key);
                    $facultyFeed[$index] = $value['faculty_' . $fac[1]];
                    $index++;
                }
            }
        }


        $uniqfaculty = array_unique($facultyFeed);
        //======[GETTING NAME OF AL THE EMPLYOEE]=======//
        for ($i = 0; $i < count($uniqfaculty); $i++) {
            $empl_name[$i] = $employee_model->getAllEmployee($uniqfaculty[$i])[0];
        }
        //=========[SETTING SELECT BOX]=========//


        echo '<option value="">Select</option>';
        if (count($empl_name) > 0) {
            foreach ($empl_name as $key => $value) {
                echo "<option value='" . $value['empl_id'] . "'>" . $value['name'] . "</option>";
            }die;
        }

        die;
    }

    ///  admit card added by raushan
    public function admitcardAction() {
        // http_response_code(500);
        // die();
        $this->view->action_name = 'admitcard';
        $this->view->sub_title_name = 'admitcard';
        $this->accessConfig->setAccess('SA_ACAD_ADMIT_CARD');
        $EvaluationComponents_model = new Application_Model_EvaluationComponents();
        $elective_selection = new Application_Model_ElectiveSelectionItems();
        $course_learning = new Application_Model_Corecourselearning();
        $assignment_model = new Application_Model_StudentPortal();
        $allow_model = new Application_Model_BatachSemesterAttendance();
        // $assignment_form = new Application_Form_AdmitCardView();
        $academic_details = new Application_Model_Academic();
        $admit_form = new Application_Form_AdmitCard();
        $dept_model = new Application_Model_Department();
        $fee_model = new Application_Model_Coursefee();

        $student_exam_form = new Application_Model_ExamformSubmissionModel();
        $examschedule_model = new Application_Model_ExamScheduleModel();
        $ec_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $admit_form;
        //$this->view->form = $assignment_form;

        switch ($type) {
            case "view":

                $assignment_form = new Application_Form_AdmitCardView();
                $this->view->form = $assignment_form;
                if ($this->getRequest()->isPost()) {
                    if (isset($_POST)) {
                        // print_r($_POST);
                        // die();
                        $stu_id = md5(trim($_POST['stu_id']));

                        $getvalue = $allow_model->getRecordforadmit($_POST['stu_id'], $_POST['semester']);
                        if (empty($getvalue)) {
                            echo "<script>
                          alert('You enter Invalid Form Id OR you Choose Wrong Semester');
                          window.location.href='application/admitcard';
                          </script>";
                            die();
                        }
                        $this->view->fid = $_POST['stu_id'];
                        $result = $student_exam_form->getRecordbyfid($stu_id);
                        $checkk = $allow_model->checkRecordByUid($stu_id);
                        $this->view->stu_allow = $checkk;
                        // echo "<pre>"; print_r($result);exit;
                        $stu_image = $assignment_model->getImage($stu_id);
                        if ($result == '') {

                            $this->redirectExamform('You not submit your fill your form or payment Due');
                        } else {
                            $sem_id = $allow_model->getTermIdByFid($_POST['stu_id'], $result['academic_year_id']);
                            // echo "<pre>"; print_r($sem_id);exit;
                            $ac_details = $academic_details->getRecord($result['academic_year_id']);
                            $this->view->semester = $sem_id[0]['term_name'];
                            //$this->view->semester = '2nd Semes';

                            $this->view->payactivaion = $result['payment_status'];
                            $acad_term_arr['batch_id'] = $result['academic_year_id'];
                            $acad_term_arr['term_id'] = $result['term_id'];
                            $term_obj = new Application_Model_TermMaster();
                            $term_details = $term_obj->getTermRecords($acad_term_arr['batch_id'], $acad_term_arr['term_id']);

                            $result['year'] = date('Y');
                            $result['exam_year'] = date('Y');
                            $result['college'] = 'Patna Women\'s College';
                            $result['examination'] = 'October ' . $result['exam_year'];
                            if (!$ac_details['department']) {
                                echo "Please Fill the form first ";
                                die;
                            }
                            $dept_id = $dept_model->getRecord($ac_details['department']);
                            $fee_pay = $fee_model->getRecordByDepartment($dept_id['id']);
                            //print_r($fee_pay);
                            //die();
                            $this->view->feeamount = $fee_pay['examFee'];
                            $currentdate = date('Y-m-d');

                            /*
                             * stu_id[primary key id] 
                             *   batch_id[id]
                             *   term_id[id]
                             *
                             *
                             */

                            $course_details_arr = $course_learning->getcourseTypeOn($acad_term_arr['batch_id'], $acad_term_arr['term_id']);
                            $course_details_arr = $this->geStudentCourse($acad_term_arr['batch_id'], $acad_term_arr['term_id'], $result['student_id']);
                            $core_course_name_arr = $this->mergData($course_details_arr, array('cc_name'), count($course_details_arr));
                            $ge_arr = $this->mergData($course_details_arr, array('ge_id'), count($course_details_arr));

                            $core_course_name_arr = array_values(array_unique($core_course_name_arr));
                            $ge_arr = array_values(array_unique($ge_arr));
                            $selectge = $elective_selection->getCouseDetailByStudentId($acad_term_arr['batch_id'], $acad_term_arr['term_id'], $result['student_id']);
                            $this->view->course_cat = $core_course_name_arr;
                            $this->view->ge_arr = $ge_arr;
                            $this->view->core_details_arr = $course_details_arr;
                            //$this->view->std_name = $result['stu_fname']. ' ' .$result['stu_lname'];
                            $this->view->exam_roll = $result['examination_id'];
                            $this->view->stu_pic_path = $stu_image['filename'];
                            $this->view->stu_roll = $stu_image['roll_no'];
                            $this->view->course_val = $selectge;
                            $this->view->ge_id = $this->aeccConfig[0];
                            $this->view->stu_name = $result['stu_name'];
                            $this->view->stu_fname = $result['fname'];

                            $this->view->semester = $term_details[0]['term_name'];
                            if (!$ac_details || !$ac_details['department']) {
                                echo "please fill you form first";
                                die;
                            }
                            $this->view->dept_id = $dept_model->getRecord($ac_details['department'])['department'];
                            // echo "<pre>"; print_r($ac_details);exit;
                            $result['exam_roll'] = $result['examination_id'];
                            $result['semester'] = $term_details[0]['term_name'];
                            $result['registration_no'] = $result['reg_no'];

                            //echo "<pre>"; print_r($result['session_id']);exit;
                            //echo $acad_term_arr['batch_id'];
                            // die();

                            $exam_schedule = $examschedule_model->getRecordBysession($result['session_id'], $acad_term_arr['batch_id']);
                            $this->view->exam_sch = $course_details_arr;

                            //echo "<pre>";  print_r($course_details_arr);
                            //echo $exam_schedule[0]['course_id'];
                            //die();
                            $result['comm_exam'] = date('d-m-Y', strtotime($exam_schedule[0]['exam_date']));
                            $paymentdesc = new Application_Model_ExamfeeSubmitModel();
                            $fetchdetail = $paymentdesc->getRecordbyfid($stu_id);
                            //echo "<pre>"; print_r($fetchdetail);exit;
                            $this->view->payment_details = $fetchdetail;
                            $this->view->transaction = $fetchdetail['mmp_txn'];
                            $this->view->bankname = $fetchdetail['bank_name'];

                            $assignment_form->populate($result);
                        }
                    }
                }


                break;

            case 'delete':
                $data['status'] = 2;
                if ($ec_id) {
                    $EvaluationComponents_model->update($data, array('ec_id=?' => $ec_id));
                    $EvaluationComponentsItems_model->update($data, array('eci_id=?' => $eci_id));
                    $this->_flashMessenger->addMessage('Evaluation Component Deleted Successfully');
                    $this->_redirect('application/index');
                }
                break;

            default:
                $admit_form = new Application_Form_AdmitCard();

                break;
        }
    }

    public function admitcardnoncollegiateAction() {
        //       http_response_code(500);
        // die();
        $this->view->action_name = 'admitcard';
        $this->view->sub_title_name = 'admitcard';
        $this->accessConfig->setAccess('SA_ACAD_ADMIT_CARD');
        $EvaluationComponents_model = new Application_Model_EvaluationComponents();
        $elective_selection = new Application_Model_ElectiveSelectionItems();
        $course_learning = new Application_Model_Corecourselearning();
        $assignment_model = new Application_Model_StudentPortal();
        $allow_model = new Application_Model_BatachSemesterAttendance();
        // $assignment_form = new Application_Form_AdmitCardView();
        $academic_details = new Application_Model_Academic();
        $admit_form = new Application_Form_AdmitCard();
        $dept_model = new Application_Model_Department();
        $fee_model = new Application_Model_Coursefee();

        $student_exam_form = new Application_Model_UgNonformSubmissionModel();
        $examschedule_model = new Application_Model_ExamScheduleModel();
        $ec_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $admit_form;
        //$this->view->form = $assignment_form;

        switch ($type) {
            case "admitcard":
                ///die();
                $assignment_form = new Application_Form_AdmitCardView();
                $this->view->form = $assignment_form;
                if ($this->getRequest()->isPost()) {
                    if (isset($_POST)) {
                        //print_r($_POST);
                        //die();
                        $stu_id = md5(trim($_POST['stu_id']));
                        $this->view->fid = $_POST['stu_id'];
                        $result = $student_exam_form->getNonRecordbyfid($_POST['stu_id']);
                        //print_r($result);
                        //die();
                        $stu_image = $assignment_model->getImage($stu_id);
                        if ($result == '') {


                            $this->redirectExamform('You not submit your fill your form or payment Due', 1);
                        } else {
                            $sem_id = $allow_model->getTermIdByFid($stu_id, $result['academic_year_id']);
                            // echo $result['academic_year_id']."server down !"; exit;
                            $ac_details = $academic_details->getRecord($result['academic_year_id']);

                            $this->view->payactivaion = $result['payment_status'];
                            $acad_term_arr['batch_id'] = $result['academic_year_id'];
                            $acad_term_arr['term_id'] = $result['term_id'];

                            $result['year'] = date('Y');
                            $result['exam_year'] = date('Y');
                            $result['college'] = 'Patna Women\'s College';
                            $result['examination'] = 'October ' . $result['exam_year'];
                            $this->view->feeamount = $fee_pay['examFee'];
                            $currentdate = date('Y-m-d');

                            $this->view->exam_roll = $result['examination_id'];
                            $this->view->stu_pic_path = $stu_image['filename'];
                            $this->view->stu_roll = $stu_image['roll_no'];
                            $this->view->ge_id = $this->aeccConfig[0];
                            $this->view->stu_name = $result['stu_name'];
                            $this->view->stu_fname = $result['fname'];
                            $this->view->semester = '2nd Semester';
                            if (!$ac_details || !$ac_details['department']) {
                                echo 'You have to fill your form first !';
                            }
                            $this->view->dept_id = $dept_model->getRecord($ac_details['department'])['department'];

                            $result['exam_roll'] = $result['examination_id'];
                            $result['registration_no'] = $result['reg_no'];

//echo "<pre>"; print_r($result['session_id']);exit;
                            $paymentdesc = new Application_Model_NonColpayment();
                            $fetchdetail = $paymentdesc->getRecordbyfid($stu_id);
                            //echo "<pre>"; print_r($fetchdetail);exit;
                            $this->view->transaction_detail = $fetchdetail;
                            $this->view->transaction = $fetchdetail['mmp_txn'];
                            $this->view->bankname = $fetchdetail['bank_name'];
                            $exam_schedule = $examschedule_model->getRecordBysession($result['session_id'], $acad_term_arr['batch_id']);
                            $this->view->exam_sch = $course_details_arr;
                            //echo "<pre>";  print_r($exam_schedule);
                            //echo $exam_schedule[0]['course_id'];
                            //die();
                            $nonsubject = new Application_Model_NonCollegiateModel();
                            $getsub = $nonsubject->getStuRecords($stu_id);
                            $this->view->subjectdetail = $getsub;
                            //echo "<pre>";  print_r($getsub);
                            $result['comm_exam'] = date('d-m-Y', strtotime($exam_schedule[0]['exam_date']));

                            $assignment_form->populate($result);
                        }
                    }
                }


                break;

            default:
                $admit_form = new Application_Form_AdmitCard();

                break;
        }
    }

    public function studentTermAdmitcardAction() {
        $this->view->action_name = 'student-term-admitcard';
        $this->view->sub_title_name = 'student-term-admitcard';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    public function studentNonugAdmitcardAction() {
        $this->view->action_name = 'student-nonug-admitcard';
        $this->view->sub_title_name = 'student-nonug-admitcard';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_NonUgAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    public function studentNonpgAdmitcardAction() {
        $this->view->action_name = 'student-nonpg-admitcard';
        $this->view->sub_title_name = 'student-nonpg-admitcard';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_NonPgAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }

    public function ajaxGetStudentDetailsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            if ($academic_year_id) {
                $StudentPortal_model = new Application_Model_StudentPortal();
                $student_data = $StudentPortal_model->getStudentDetails($academic_year_id);
                //print_r($SubProgram);die;
                echo '<option value="">Select </option>';
                foreach ($student_data as $k => $val) {
                    echo '<option value="' . $k . '" >' . $val . '</option>';
                }
                die;
            }
        }
    }

    public function ajaxGetNonugDetailsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            if ($academic_year_id) {
                $StudentPortal_model = new Application_Model_StudentPortal();
                $student_data = $StudentPortal_model->getNonugDetails($academic_year_id);
                //print_r($SubProgram);die;
                echo '<option value="">Select </option>';
                foreach ($student_data as $k => $val) {
                    echo '<option value="' . $k . '" >' . $val . '</option>';
                }
                die;
            }
        }
    }

    public function ajaxGetNonpgDetailsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            if ($academic_year_id) {
                $StudentPortal_model = new Application_Model_StudentPortal();
                $student_data = $StudentPortal_model->getNonpgDetails($academic_year_id);
                //print_r($SubProgram);die;
                echo '<option value="">Select </option>';
                foreach ($student_data as $k => $val) {
                    echo '<option value="' . $k . '" >' . $val . '</option>';
                }
                die;
            }
        }
    }

    public function getStudentAdmitcardAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
         $feeCollection = new Application_Model_FeesCollection();
            $feeStr = new Application_Model_FeeStructure();
            $examfeeStr = new Application_Model_Coursefee();
            $feeStrItem = new Application_Model_FeeStructureItems();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $this->view->term_id = $term_id;
            $session_id  = $this->_getParam("session_id");
            $this->view->year_id = $year_id;
            $stu_id = $this->_getParam("stu_id");
            $pay = 1;
            $attendance = 0;
            $sem = $term_id;
            if ($academic_id) {
             
                  $totexamfee = $examfeeStr->getEndFee($academic_id, $sem, $session_id);
 //  echo '<pre>';print_r($totexamfee);exit;
           $strId = $feeStr->getStructIdAll($academic_id);
              
            $allTermFee = $feeStrItem->getStructureRecordsAll($strId);
            $semFee = array();
            foreach($allTermFee as $key => $value){
                    switch ($sem) {
                        case "t1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "t2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "t3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "t4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "t5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "t6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
            }
            // echo '<pre>';print_r($result);exit;

            $result = $feeCollection->getStudentForEndSemRecords($academic_id, $sem, $attendance);
           

            }
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;

            $this->view->corecourseresult = $result;
            
        }
    }

    public function getNonugAdmitcardAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $stu_id = $this->_getParam("stu_id");

            if ($academic_id) {
                $Studentreport_model = new Application_Model_StudentPortal();
                $result = $Studentreport_model->getNonugadmitRecord($academic_id, $stu_id,$term_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function getNonpgAdmitcardAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
            $stu_id = $this->_getParam("stu_id");

            if ($academic_id) {
                $Studentreport_model = new Application_Model_StudentPortal();
                $result = $Studentreport_model->getNonpgadmitRecord($academic_id, $stu_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function admitcardprintAction() {
        $this->view->action_name = 'admitcard';
        $this->view->sub_title_name = 'admitcard';
        $this->accessConfig->setAccess('SA_ACAD_ADMIT_CARD');
        $EvaluationComponents_model = new Application_Model_EvaluationComponents();
        $elective_selection = new Application_Model_ElectiveSelectionItems();
        $course_learning = new Application_Model_Corecourselearning();
        $assignment_model = new Application_Model_StudentPortal();
        $allow_model = new Application_Model_BatachSemesterAttendance();
        // $assignment_form = new Application_Form_AdmitCardView();
        $academic_details = new Application_Model_Academic();
        $admit_form = new Application_Form_AdmitCard();
        $dept_model = new Application_Model_Department();
        $fee_model = new Application_Model_Coursefee();

        $student_exam_form = new Application_Model_ExamformSubmissionModel();
        $examschedule_model = new Application_Model_ExamScheduleModel();
        $ec_id = $this->_getParam("id");
        $st_id = $this->_getParam("uid");
        $semester = $this->_getParam("term_id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $admit_form;
        //$this->view->form = $assignment_form;



        $assignment_form = new Application_Form_AdmitCardView();
        $this->view->form = $assignment_form;
        //if ($this->getRequest()->isPost()) {
        //   if (isset($_POST)) {
        // print_r($_POST);
        // die();
        $stu_id = md5(trim($st_id));

        $getvalue = $allow_model->getRecordforadmit($st_id, $semester);
        if (empty($getvalue)) {
            echo "<script>
                          alert('You enter Invalid Form Id OR you Choose Wrong Semester');
                          window.location.href='application/admitcard';
                          </script>";
            die();
        }
        $this->view->fid = $st_id;
        $result = $student_exam_form->getRecordbyfid($stu_id);
        $exam_roll = $result['examination_id'];
        //  echo "<pre>"; print_r($result);exit;
        $checkk = $allow_model->checkRecordByUid($stu_id);
        $this->view->stu_allow = $checkk;
        // echo "<pre>"; print_r($result);exit;
        $stu_image = $assignment_model->getImage($stu_id);
        if ($result == '') {

            $this->redirectExamform('You not submit your fill your form or payment Due');
        } else {
            $sem_id = $allow_model->getTermIdByFid($st_id, $result['academic_year_id']);
            // echo "<pre>"; print_r($sem_id);exit;
            $ac_details = $academic_details->getRecord($result['academic_year_id']);
            $this->view->semester = $sem_id[0]['term_name'];

            $this->view->payactivaion = $result['payment_status'];
            $acad_term_arr['batch_id'] = $result['academic_year_id'];
            $acad_term_arr['term_id'] = $result['term_id'];
            $term_obj = new Application_Model_TermMaster();
            $term_details = $term_obj->getTermRecords($acad_term_arr['batch_id'], $acad_term_arr['term_id']);

            $result['year'] = date('Y');
            $result['exam_year'] = date('Y');
            $result['college'] = 'Patna Women\'s College';
            $result['examination'] = 'October' . $result['exam_year'];
            if (!$ac_details['department']) {
                echo "Please Fill the form first ";
                die;
            }
            $dept_id = $dept_model->getRecord($ac_details['department']);
            $fee_pay = $fee_model->getRecordByDepartment($dept_id['id']);
            //print_r($fee_pay);
            //die();
            $this->view->feeamount = $fee_pay['examFee'];
            $currentdate = date('Y-m-d');

            /*
             * stu_id[primary key id] 
             *   batch_id[id]
             *   term_id[id]
             *
             *
             */

            $course_details_arr = $course_learning->getcourseTypeOn($acad_term_arr['batch_id'], $acad_term_arr['term_id']);
            $course_details_arr = $this->geStudentCourse($acad_term_arr['batch_id'], $acad_term_arr['term_id'], $result['student_id']);
            $core_course_name_arr = $this->mergData($course_details_arr, array('cc_name'), count($course_details_arr));
            $ge_arr = $this->mergData($course_details_arr, array('ge_id'), count($course_details_arr));

            $core_course_name_arr = array_values(array_unique($core_course_name_arr));
            $ge_arr = array_values(array_unique($ge_arr));
            $selectge = $elective_selection->getCouseDetailByStudentId($acad_term_arr['batch_id'], $acad_term_arr['term_id'], $result['student_id']);
            $this->view->course_cat = $core_course_name_arr;
            $this->view->ge_arr = $ge_arr;
            $this->view->core_details_arr = $course_details_arr;
            //$this->view->std_name = $result['stu_fname']. ' ' .$result['stu_lname'];
            $this->view->exam_roll = $result['examination_id'];
            $this->view->stu_pic_path = $stu_image['filename'];
            $this->view->stu_roll = $stu_image['roll_no'];
            $this->view->course_val = $selectge;
            $this->view->ge_id = $this->aeccConfig[0];
            $this->view->stu_name = $result['stu_name'];
            $this->view->stu_fname = $result['fname'];

            $this->view->semester = $term_details[0]['term_name'];
            if (!$ac_details || !$ac_details['department']) {
                echo "please fill you form first";
                die;
            }
            $this->view->dept_id = $dept_model->getRecord($ac_details['department'])['department'];
            // echo "<pre>"; print_r($ac_details);exit;
            $result['exam_roll'] = $result['examination_id'];
            $result['semester'] = $term_details[0]['term_name'];
            $result['registration_no'] = $result['reg_no'];

            //echo "<pre>"; print_r($result['session_id']);exit;
            //echo $acad_term_arr['batch_id'];
            // die();

            $exam_schedule = $examschedule_model->getRecordBysession($result['session_id'], $acad_term_arr['batch_id']);
            $this->view->exam_sch = $course_details_arr;

            //echo "<pre>";  print_r($course_details_arr);
            //echo $exam_schedule[0]['course_id'];
            //die();
            $result['comm_exam'] = date('d-m-Y', strtotime($exam_schedule[0]['exam_date']));
            $paymentdesc = new Application_Model_ExamfeeSubmitModel();
            $fetchdetail = $paymentdesc->getRecordbyfid($stu_id);
          //  echo "<pre>"; print_r($fetchdetail);exit;
            $this->view->payment_details = $fetchdetail;
            $this->view->transaction = $fetchdetail['mmp_txn'];
            $this->view->bankname = $fetchdetail['bank_name'];

            $assignment_form->populate($result);
            $htmlcontent = $this->view->render('application/admitcardprint.phtml');
            if ($check == 'admin' || $mode == 'view') {
                echo $htmlcontent;
                exit;
            }//======for PDF
            $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $exam_roll . $filename, 'P', 100);
        }

        //}
        //}
    }

    public function admitcardnoncollegiateprintAction() {

        $this->view->action_name = 'admitcard';
        $this->view->sub_title_name = 'admitcard';
        $this->accessConfig->setAccess('SA_ACAD_ADMIT_CARD');
        $EvaluationComponents_model = new Application_Model_EvaluationComponents();
        $elective_selection = new Application_Model_ElectiveSelectionItems();
        $course_learning = new Application_Model_Corecourselearning();
        $assignment_model = new Application_Model_StudentPortal();
        $allow_model = new Application_Model_BatachSemesterAttendance();
        // $assignment_form = new Application_Form_AdmitCardView();
        $academic_details = new Application_Model_Academic();
        $admit_form = new Application_Form_AdmitCard();
        $dept_model = new Application_Model_Department();
        $fee_model = new Application_Model_Coursefee();

        $student_exam_form = new Application_Model_UgNonformSubmissionModel();
        $examschedule_model = new Application_Model_ExamScheduleModel();
        $ec_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $s_id = $this->_getParam("uid");
        $term = $this->_getParam("term_id");
        $this->view->type = $type;
        $this->view->form = $admit_form;
        //$this->view->form = $assignment_form;
        ///die();
        $assignment_form = new Application_Form_AdmitCardView();
        $this->view->form = $assignment_form;
        //if ($this->getRequest()->isPost()) {
        //if (isset($_POST)) {
        //print_r($_POST);
        //die();
        $stu_id = md5(trim($s_id));
        $this->view->fid = $s_id;
        $result = $student_exam_form->getNonRecordbyfid($s_id);
        $exam_roll = $result['examination_id'];
        //print_r($result);
        //die();
        $stu_image = $assignment_model->getImage($stu_id);
        if ($result == '') {


            $this->redirectExamform('You not submit your fill your form or payment Due', 1);
        } else {
            $sem_id = $allow_model->getTermIdByFid($stu_id, $result['academic_year_id']);
            // echo $result['academic_year_id']."server down !"; exit;
            $ac_details = $academic_details->getRecord($result['academic_year_id']);

            $this->view->payactivaion = $result['payment_status'];
            $acad_term_arr['batch_id'] = $result['academic_year_id'];
            $acad_term_arr['term_id'] = $result['term_id'];

            $result['year'] = date('Y');
            $result['exam_year'] = date('Y');
            $result['college'] = 'Patna Women\'s College';
            $result['examination'] = 'Oct. ' . $result['exam_year'];
            $this->view->feeamount = $fee_pay['examFee'];
            $currentdate = date('Y-m-d');

            $this->view->exam_roll = $result['examination_id'];
            $this->view->stu_pic_path = $stu_image['filename'];
            $this->view->stu_roll = $stu_image['roll_no'];
            $this->view->ge_id = $this->aeccConfig[0];
            $this->view->stu_name = $result['stu_name'];
            $this->view->stu_fname = $result['fname'];
            $this->view->semester = '2nd Semester';
            if (!$ac_details || !$ac_details['department']) {
                echo 'You have to fill your form first !';
            }
            $this->view->dept_id = $dept_model->getRecord($ac_details['department'])['department'];

            $result['exam_roll'] = $result['examination_id'];
            $result['registration_no'] = $result['reg_no'];

//echo "<pre>"; print_r($result['session_id']);exit;
            $paymentdesc = new Application_Model_NonColpayment();
            $fetchdetail = $paymentdesc->getRecordbyfid($stu_id);
            //echo "<pre>"; print_r($fetchdetail);exit;
            $this->view->transaction_detail = $fetchdetail;
            $this->view->transaction = $fetchdetail['mmp_txn'];
            $this->view->bankname = $fetchdetail['bank_name'];
            $exam_schedule = $examschedule_model->getRecordBysession($result['session_id'], $acad_term_arr['batch_id']);
            $this->view->exam_sch = $course_details_arr;
            //echo "<pre>";  print_r($exam_schedule);
            //echo $exam_schedule[0]['course_id'];
            //die();
            $nonsubject = new Application_Model_NonCollegiateModel();
            $getsub = $nonsubject->getStuRecords($stu_id);
            $this->view->subjectdetail = $getsub;
            //echo "<pre>";  print_r($getsub);
            $result['comm_exam'] = date('d-m-Y', strtotime($exam_schedule[0]['exam_date']));

            $assignment_form->populate($result);

            $htmlcontent = $this->view->render('application/admitcardnoncollegiateprint.phtml');
            if ($check == 'admin' || $mode == 'view') {
                echo $htmlcontent;
                exit;
            }//======for PDF
            $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $exam_roll . $filename, 'P', 100);
        }

//                    }
//                }
    }

    public function admitcardpgnoncollegiateprintAction() {
        $this->view->action_name = 'admitcard';
        $this->view->sub_title_name = 'admitcard';
        $this->accessConfig->setAccess('SA_ACAD_ADMIT_CARD');
        $EvaluationComponents_model = new Application_Model_EvaluationComponents();
        $elective_selection = new Application_Model_ElectiveSelectionItems();
        $course_learning = new Application_Model_Corecourselearning();
        $assignment_model = new Application_Model_StudentPortal();
        $allow_model = new Application_Model_BatachSemesterAttendance();
        // $assignment_form = new Application_Form_AdmitCardView();
        $academic_details = new Application_Model_Academic();
        $admit_form = new Application_Form_AdmitCard();
        $dept_model = new Application_Model_Department();
        $fee_model = new Application_Model_Coursefee();
        $student_exam_form = new Application_Model_NonPgDataModel();
        $examschedule_model = new Application_Model_ExamScheduleModel();
        $ec_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $st_id = $this->_getParam("uid");
        $this->view->type = $type;
        $this->view->form = $admit_form;
        //$this->view->form = $assignment_form;


        $assignment_form = new Application_Form_AdmitCardView();
        $this->view->form = $assignment_form;
        //if ($this->getRequest()->isPost()) {
        //if (isset($_POST)) {
        //print_r($_POST);
        //die();
        $stu_id = md5(trim($st_id));

        $result = $student_exam_form->getNonRecordbyfid($st_id);
        $exam_roll = $result['examination_id'];
        // print_r($result);
        // die();

        if (empty($result)) {
            //echo "hii";
            //die();
            echo "<script>
                     alert('Application form Not submitted');
                     </script>";
            $this->redirectExamform("Your Exam Form does not Submit Or Payment Not Completed", 'pg');
        } else {
            $this->view->fid = $st_id;
            $stu_image = $assignment_model->getImage($stu_id);
            $ac_details = $academic_details->getRecord($result['academic_year_id']);

            $this->view->payactivaion = $result['payment_status'];
            $acad_term_arr['batch_id'] = $result['academic_year_id'];
            $acad_term_arr['term_id'] = $result['term_id'];

            $result['year'] = date('Y');
            $result['exam_year'] = date('Y');
            $result['college'] = 'Patna Women\'s College';
            $result['examination'] = 'Oct ' . $result['exam_year'];
            $this->view->feeamount = $fee_pay['examFee'];
            $currentdate = date('Y-m-d');

            $this->view->exam_roll = $result['examination_id'];
            $this->view->stu_pic_path = $stu_image['filename'];
            $this->view->stu_roll = $stu_image['roll_no'];
            $this->view->ge_id = $this->aeccConfig[0];
            $this->view->stu_name = $result['stu_name'];
            $this->view->stu_fname = $result['fname'];
            $this->view->semester = 'Semester 1';
            //echo "<pre>";print_r($ac_details);die;
            $deprt = $dept_model->getRecord($ac_details['department']);
            //print_r($deprt[department]);
            // die();
            $this->view->dept_id = $deprt[department];

            $result['exam_roll'] = $result['examination_id'];
            $result['registration_no'] = $result['reg_no'];

//echo "<pre>"; print_r($result['session_id']);exit;
            $paymentdesc = new Application_Model_NonpgPaymentModel();
            $fetchdetail = $paymentdesc->getpayRecordbyfid($stu_id);
            //echo "<pre>"; print_r($fetchdetail);exit;
            $this->view->transaction_detail = $fetchdetail;
            $this->view->transaction = $fetchdetail['mmp_txn'];
            $this->view->bankname = $fetchdetail['bank_name'];
            $exam_schedule = $examschedule_model->getRecordBysession($result['session_id'], $acad_term_arr['batch_id']);
            $this->view->exam_sch = $course_details_arr;
            //echo "<pre>";  print_r($exam_schedule);
            //echo $exam_schedule[0]['course_id'];
            //die();
            $nonsubject = new Application_Model_NonPgCollegiateModel();
            $getsub = $nonsubject->getStuRecords($stu_id);
            $this->view->subjectdetail = $getsub;
            //echo "<pre>";  print_r($getsub);
            $result['comm_exam'] = date('d-m-Y', strtotime($exam_schedule[0]['exam_date']));

            $assignment_form->populate($result);
            $htmlcontent = $this->view->render('application/admitcardpgnoncollegiateprint.phtml');
            if ($check == 'admin' || $mode == 'view') {
                echo $htmlcontent;
                exit;
            }//======for PDF
            $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $exam_roll . $filename, 'P', 100);
        }

        //}
        // }
    }

    /* =======start 07-01-2018 public function ajaxGetFacultyAction() {
      $employee_model = new Application_Model_HRMModel();
      $faculty = new Application_Model_Attendance();
      $term_id = $this->_getParam('term_id');
      $batch_id = $this->_getParam('academic_year_id');
      $course_id = $this->_getParam('course_id');
      $result = $faculty->getFaculty($term_id, $batch_id, $course_id);

      $result[0]['faculty_id'] .= ',' . $result[0]['employee_id'];
      // print_r($course_cordinatior);exit;
      $faculty_id = explode(',', $result[0]['faculty_id']);
      $visiting_faculty = explode(',', $result[0]['visiting_faculty_id']);

      //======[MERGING BOTH FACULTY ARRAY]=======//
      $faculty_arr = array_merge($faculty_id, $visiting_faculty);

      //====={MAKING ARRAY UNIQUE}==============//
      $all_unique_faculty = array_unique($faculty_arr);

      //======[GETTING NAME OF AL THE EMPLYOEE]=======//
      for ($i = 0; $i < count($all_unique_faculty); $i++) {
      if ($all_unique_faculty[$i] != 'NA')
      $empl_name[$i] = $employee_model->getAllEmployee($all_unique_faculty[$i])[0];
      }
      //=========[SETTING SELECT BOX]=========//

      if (count($empl_name) > 0) {
      foreach ($empl_name as $key => $value) {
      echo "<option value='" . $value['empl_id'] . "'>" . $value['name'] . "</option>";
      }die;
      }

      die;
      } *///=======End 07-01-2018 by ashutosh 

    //Payment Transaction repert : Date: 27 Oct 2020 : Kedar
    public function paymentTxnReportAction() {
        $this->view->action_name = 'direct-final-grade';
        $this->view->sub_title_name = 'txn_details';
        $this->accessConfig->setAccess('SA_ACAD_TXN_DETAILS');
        $payment_form = new Application_Form_PayManager();
        $this->view->form = $payment_form;
    }

    public function ajaxGetTxnRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $to_date = $this->_getParam("to_date");
            $from_date = $this->_getParam("from_date");
            $dept = $this->_getParam("department");
            $sem = $this->_getParam("sem");

            $result = $feeCollection->getPayRecordsByMerSingleForFilterData($to_date, $from_date, $dept, $sem);
            $paginator_data = array(
                'result' => $result
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function studentFeeInstallmentAction() {
        $this->view->action_name = 'direct-final-grade';
        $this->view->sub_title_name = 'direct-final-grade';
        $this->accessConfig->setAccess('SA_ACAD_FEE_INSDETAIL');
        $payment_form = new Application_Form_ExamDateForm();
        $this->view->form = $payment_form;
    }
    
        public function studentTcFeeAction() {
        $this->view->action_name = 'direct-final-grade';
        $this->view->sub_title_name = 'direct-final-grade';
        $this->accessConfig->setAccess('SA_ACAD_FEE_INSDETAIL');
        $payment_form = new Application_Form_ExamDateForm();
        $this->view->form = $payment_form;
    }

    public function studentRegistrationAction() {
        $this->view->action_name = 'direct-final-grade';
        $this->view->sub_title_name = 'direct-final-grade';
        $this->accessConfig->setAccess('SA_ACAD_FEE_INSDETAIL');
        $payment_form = new Application_Form_ExamDateForm();
        $this->view->form = $payment_form;
    }
    public function endSemFormPaymentAction() {
        $this->view->action_name = 'semester-form-payment';
        $this->view->sub_title_name = 'semester-form-payment';
        $this->accessConfig->setAccess('SA_ACAD_SEMFORMFEE');
        $payment_form = new Application_Form_ExamDateForm();
        $this->view->form = $payment_form;
    }

    public function nonCollegiateFormPaymentAction() {
        $this->view->action_name = 'noncollegiate-form-payment';
        $this->view->sub_title_name = 'noncollegiate-form-payment';
        $this->accessConfig->setAccess('SA_ACAD_SEMFORMFEE');
        $payment_form = new Application_Form_ExamDateForm();
        $this->view->form = $payment_form;
    }

    public function ajaxGetFeesInstallmentRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id"); 
            $sem = $this->_getParam("sem");
          
            $strId = $feeStr->getStructIdAll($academic_id);
              
            $allTermFee = $feeStrItem->getStructureRecordsAll($strId);
            $semFee = array();
            foreach($allTermFee as $key => $value){
                    switch ($sem) {
                        case "t1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "t2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "t3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "t4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "t5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "t6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
            }
            //echo '<pre>';print_r($semFee);exit;
            $result = $feeCollection->getStudentFeeInstallmentRecords($academic_id, $sem);
            // echo '<pre>'; print_r($result);exit;
            $paginator_data = array(
                'result' => $result,
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->semFee = $semFee;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
    
        public function ajaxGetFeesTcRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_TcFeeCollection();
            $academic_id = $this->_getParam("academic_id"); 
            $type = $this->_getParam("type");
           
            $result = $feeCollection->getStudentFeeTcRecords($academic_id, $type);
            // echo '<pre>'; print_r($result);exit;
           
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->semFee = $semFee;
            $this->view->paginator = $result;
        }
    }
    
    
 public function ajaxGetFeesRegistrationRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_RegistrationPayment();
             $student = new Application_Model_StudentPortal();
                                     
            $academic_id = $this->_getParam("academic_id");
            $result = $feeCollection->getRecordByacademic($academic_id);
            $students = $student->getStudentsSortByNameAll($academic_id);
            $paginator_data = array(
                'result' => $result,
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $result['cmn_terms'];
            $this->view->semFee = $result['amt'];
            $this->view->students = $students;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    public function ajaxGetEndSemesterRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $feeStr = new Application_Model_FeeStructure();
            $examfeeStr = new Application_Model_Coursefee();
            $feeStrItem = new Application_Model_FeeStructureItems();
            
            $academic_id = $this->_getParam("academic_id");
            $sem = $this->_getParam("sem");
            $pay = $this->_getParam("pay");
            $attendance = $this->_getParam("attend");
            $session_id = $this->_getParam("session_id");

            $totexamfee = $examfeeStr->getEndFee($academic_id, $sem, $session_id);

           $strId = $feeStr->getStructIdAll($academic_id);
              
            $allTermFee = $feeStrItem->getStructureRecordsAll($strId);
            $semFee = array();
            foreach($allTermFee as $key => $value){
                    switch ($sem) {
                        case "t1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "t2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "t3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "t4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "t5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "t6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
            }
            // echo '<pre>';print_r($semFee);exit;

            $result = $feeCollection->getStudentForEndSemRecords($academic_id, $sem, $attendance);
            $paginator_data = array(
                'result' => $result,
            );

            // echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function ajaxGetNonCollegiateFormRecordAction() {
        
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $backitem = new Application_Model_BackSelectionItems();
            $feeStr = new Application_Model_FeeStructure();
            $examfeeStr = new Application_Model_Coursefee();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $sem = $this->_getParam("sem");
            $pay = $this->_getParam("pay");
            $attendance = $this->_getParam("attend");
            $session_id = $this->_getParam("session_id");
            $exam_date = $this->_getParam("exam_date");

            $totexamfee = $examfeeStr->getNonEndFee($academic_id, $sem, $session_id);

            $strId = $feeStr->getStructIdAll($academic_id);
              
            $allTermFee = $feeStrItem->getStructureRecordsAll($strId);
            $semFee = array();
            foreach($allTermFee as $key => $value){
                    switch ($sem) {
                        case "t1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "t2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "t3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "t4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "t5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "t6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
            }
            // echo '<pre>';print_r($semFee);exit;

            $result = $backitem->getStudentForNonColRecords($academic_id, $sem, $exam_date,$pay);
            // echo "<pre>";print_r($result);die();
            $paginator_data = array(
                'result' => $result,
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;
            //$this->view->examdate=$exam_date;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    //For Pass Fail Report in semester
    public function passFailReportAction(){
        $this->view->action_name = 'studentreport';
        $this->view->sub_title_name = 'passfail';
        $this->accessConfig->setAccess('SA_ACAD_PASSFAIL');
        $multi_step_entrance_form = new Application_Form_ExamDateForm();
        $termModel = new Application_Model_TermMaster();
        $this->view->form = $multi_step_entrance_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $session = $this->_getParam("session");
        $cmnTerms = $this->_getParam("term");
        $degree = $this->_getParam("degree");
        $this->view->degree = $degree;
        $this->view->type = $type;
        switch ($type) {

            case "edit":
               
                $academic_model = new Application_Model_Department();
                $result = $academic_model->getCoreCourseByCourseIdpassfail($edit_id, $session, $cmnTerms,$degree);
                $year = $termModel->getRecordBysessionIdonly($session);
                $possibleterms = $year[0]['last_year_id']? $year[0]['last_year_id']*2:false;
                $lastcmnterms ="t".$possibleterms;
                $isLastterm = $lastcmnterms==$cmnTerms?true:false;
                $infoData = array(
                    'Stream' => $edit_id,
                    'session' => $session,
                    'term' => $cmnTerms
                );
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->infoData = $infoData;
                $this->view->department = $departmentName;
                $this->view->islastterm = $isLastterm;
                $this->view->termno = $possibleterms;
 
                break;
        case "grade":
                $academic_model = new Application_Model_Department();
                $refrence_model = new Application_Model_ReferenceGradeMaster();
                $dept_model = new Application_Model_TabulationReport();
                $result = $academic_model->getCoreCourseByCourseIdpassfail($edit_id, $session, $cmnTerms,$degree);
                $department = array_column($result,"id");
                // echo "<pre>";print_r($result);exit;
                // $this->view->degree = $result[0]['degree'];
               $student_details =  $dept_model->getAppearsAllStudentscmnterms($session,$department,$cmnTerms);
               $stu_ids = array_column($student_details,"stu_id");
                 $grade_Model = new Application_Model_GradeAllocationItems();
               $grade_result  = $grade_Model->getCGPAForStudentdegree("",implode("','",$stu_ids),"'t1','t2','t3','t4','t5','t6'",$degree,$session);
                $refrencegrade =  $refrence_model->getRefrenceRecord($degree,$session);
            //    echo "<pre>";print_r($refrencegrade);exit;
                 
                $year = $termModel->getRecordBysessionIdonly($session);
                $possibleterms = $year[0]['last_year_id']? $year[0]['last_year_id']*2:false;
                $lastcmnterms ="t".$possibleterms;
                $isLastterm = $lastcmnterms==$cmnTerms?true:false;
                $infoData = array(
                    'Stream' => $edit_id,
                    'session' => $session,
                    'term' => $cmnTerms
                );
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->infoData = $infoData;
                $this->view->grade_result = $grade_result;
                $this->view->department = $departmentName;
                $this->view->islastterm = $isLastterm;
                $this->view->termno = $possibleterms;
              
                $this->view->degree = $degree;
                $this->view->refrence = $refrencegrade;

                break;
            default:
                /* $streamModel = new Application_Model_DepartmentType();
                  $ugStream=$streamModel->getAllUgStream();
                  $pgStream=$streamModel->getAllPgStream();
                  $page = $this->_getParam('page', 1);
                  $paginator_data = array(
                  'page' => $page,
                  'result' => $ugStream
                  );
                  $pg_data = array(
                  'result' => $pgStream
                  );
                  //echo"<pre>";print_r($paginator_data);exit;
                  $this->view->paginator = $this->_act->pagination($paginator_data);
                  $this->view->pgData = $this->_act->pagination($pg_data);
                 */

                break;
        }
    }

    public function ajaxGetStreamAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $streamModel = new Application_Model_DepartmentType();
            $sem = $this->_getParam("term");
            $session = $this->_getParam("session");
            $degree = $this->_getParam("degree_id");
            $ugStream = $streamModel->getAllStreamByDegreeId($degree);
            //$pgStream=$streamModel->getAllPgStream();
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugStream
            );

            //echo"<pre>";print_r($ugStream);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->term = $sem;
            $this->view->session = $session;
        }
    }
    
    public function ajaxGetprevpassfailAction(){
         $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
         $academic_model = new Application_Model_Department();
          $cmnTerms = $this->_getParam("cmn_term");
            $session = $this->_getParam("session");
            $edit_id = $this->_getParam("department");
            $isLastterm = $this->_getParam("islast");
            $possibleterms = $this->_getParam("termno");
            $date = $this->_getParam("date");
                $result = $academic_model->getCoreCourseByCourseIdpassfail($edit_id, $session, $cmnTerms);
                $infoData = array(
                    'Stream' => $edit_id,
                    'session' => $session,
                    'term' => $cmnTerms
                );
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->infoData = $infoData;
                $this->view->department = $departmentName;
                $this->view->date = $date;
                $this->view->islastterm = $isLastterm;
                $this->view->termno = $possibleterms;
    }
    
    }
    public function ajaxGetFeesSemesterRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $strId = $feeStr->getStructId1($academic_id);
              //print_r($strId);die();
            $allTermFee = $feeStrItem->getStructureRecords1($strId);
           
            $semFee = '';
             $term = explode('_',$sem);
            switch ($term[1]) {
                case "t1":
                    $semFee .= $allTermFee['grand_term1_result'];
                    break;
                case "t2":
                    $semFee .= $allTermFee['grand_term2_result'];
                    break;
                case "t3":
                    $semFee .= $allTermFee['grand_term3_result'];
                    break;
                case "t4":
                    $semFee .= $allTermFee['grand_term4_result'];
                    break;
                case "t5":
                    $semFee .= $allTermFee['grand_term5_result'];
                    break;
                case "t6":
                    $semFee .= $allTermFee['grand_term6_result'];
                    break;
                default:
                    echo "n/a";
            }
         
        //    echo '<pre>';print_r($semFee);exit;
            $result = $feeCollection->getSemesterFeeInstallmentRecords($academic_id,$academic_year,$session,$sem);
            $paginator_data = array(
                'result' => $result,
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->semFee = $semFee;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
      public function ajaxGetCSVFeesRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $imported_files = $this->_getParam("imported_files");
          $dirPath = realpath(APPLICATION_PATH . '/../public/images/').'/excelfile/';
           $csvFile = fopen($dirPath.$imported_files, 'r');
           $csv = array();
while ($line = fgetcsv($csvFile)) {
  //$line is an array of the csv elements
  array_push($csv,$line);
}
                   echo json_encode($csv);die;
        }
    }
    public function ajaxDeleteCsvRecordsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $file_name = $this->_getParam("file_name");
            $dirPath = realpath(APPLICATION_PATH . '/../public/images/').'/excelfile/';
           if(unlink($dirPath.$file_name))
           {
               echo 1; die;
           }
           else
           {
               die;
           }
        }
    }
    public function ajaxFetchAtomfeesRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
                          $ch = curl_init();
                $data = http_build_query($dataArray);
                $getUrl = 'http://localhost:3000/12-10-2022_12-10-2022';
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                 
                $response = curl_exec($ch);
                 
                if(curl_error($ch)){
                	echo 'Request Error:' . curl_error($ch);
                }
                else
                {
                	echo $response;
                }
                 
                curl_close($ch);die;
        }
    }
    
    
    
    public function ajaxGetFeesSemlatefineRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_Latefine();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
           // $strId = $feeStr->getStructId($academic_id);
           // $allTermFee = $feeStrItem->getStructureRecords($strId);
           // print_r($allTermFee);
//            $semFee = '';
//             $term = explode('_',$sem);
//            switch ($term[1]) {
//                case "t1":
//                    $semFee .= $allTermFee['grand_term1_result'];
//                    break;
//                case "t2":
//                    $semFee .= $allTermFee['grand_term2_result'];
//                    break;
//                case "t3":
//                    $semFee .= $allTermFee['grand_term3_result'];
//                    break;
//                case "t4":
//                    $semFee .= $allTermFee['grand_term4_result'];
//                    break;
//                case "t5":
//                    $semFee .= $allTermFee['grand_term5_result'];
//                    break;
//                case "t6":
//                    $semFee .= $allTermFee['grand_term6_result'];
//                    break;
//                default:
//                    echo "n/a";
//            }
         
            //echo '<pre>';print_r($semFee);exit;
            $result = $feeCollection->getSemesterFeeInstallmentRecords($academic_id,$academic_year,$session,$sem);
            $paginator_data = array(
                'result' => $result,
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->semFee = $semFee;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
        public function ajaxGetSemFeesRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
              $tuition_fee = new Application_Model_Tuitionfees();
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $dates = $tuition_fee->getFeedate($sem,$session);
          //  echo "<pre>";print_r($dates);exit;
            if(!empty($dates['start_date']) && !empty($dates['extended_date']))
            $result = $feeCollection->getsemfeebysubmitdate($dates['start_date'],$dates['extended_date'],$sem);
            //$result = $feeCollection->getEndExamFeeRecords(str_replace(",","','",$academic_id),$academic_year,implode("','",$session),$sem);
             echo json_encode(array_column($result,'stu_id'));die;
        }
    }
    
    
    public function ajaxGetFeesEndsemRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_ExamformSubmissionModel();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $trms = $this->_getParam("trms");
            $exam_date = $this->_getParam("exam_date");

            $result = $feeCollection->getEndExamFeeRecords(str_replace(",","','",$academic_id),$academic_year,implode("','",$session),$sem);
             echo json_encode(array_column($result,'u_id'));die;
        }
    }
    
     public function ajaxGetFeesNonendsemRecordAction() {
         //die("hii");
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_UgNonformSubmissionModel();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $terms = $this->_getParam("trms");
            $exam_date = $this->_getParam("exam_date");
            //  echo "<pre>"; print_r($exam_date);exit;
            $result = $feeCollection->getNonFeeRecord(str_replace(",","','",$academic_id),$academic_year,implode("','",$session),$sem,implode("','",$exam_date));
           
           echo json_encode(array_column($result,'u_id'));die;
        }
    }
    
     public function ajaxGetPublishDateAction(){
          $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
               $feeCollection = new Application_Model_UgNonformSubmissionModel();
            $examDate = new Application_Model_ExamDateModel();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $terms = $this->_getParam("trms");
            $type = $this->_getParam("type");
            
           $result = $examDate->getDateInfoByAcadId(explode(",",$academic_id),$sem,$type);
          $result = array_unique(array_column($result,'exam_date'));
              echo '<option value="">Select </option>';
            foreach ($result as $k => $val) {
                echo '<option value="' . Date('Y-m-d',strtotime($val)) . '" >' . Date('d/m/Y',strtotime($val)) . '</option>';
            }die;
        }
    }
    
    
    public function ajaxGetFeesRegistrationokRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_NonColpayment();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $terms = $this->_getParam("trms");
            $exam_date = $this->_getParam("exam_date");
            
            
         
            //echo '<pre>';print_r($semFee);exit;
            $result = $feeCollection->getRegistrationFeeRecords(str_replace(",","','",$academic_id),$academic_year,implode("','",$session),$sem);
            echo json_encode(array_column($result,'u_id'));die;
        }
    }
    
    
    
    
    public function ajaxUpdateFeeRecordsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            
            $stu_obj = new Application_Model_StudentPortal();
            $savingdata = $this->_getParam("savingdata");
            $type = $this->_getParam("fees_type");
            $fidindex = $this->_getParam("fidindex");
            $sem = $this->_getParam("sem");
            $lastinsertId = false;
            $checkarra = array();
            if($type==3){
                 $regmodel = new Application_Model_RegistrationPayment();
                 $feeCollection = new Application_Model_NonColpayment();
            }
          else if($type==1){
                $regmodel = new Application_Model_ExamformSubmissionModel();
                $feeCollection = new Application_Model_ExamfeeSubmitModel();
          }
          else if($type==2){
                $regmodel = new Application_Model_UgNonformSubmissionModel();
                $feeCollection = new Application_Model_NonColpayment();
          }
           else if($type==4){
             
              $lastinsertId = $this->updatesemfeerecords($savingdata,$type,$fidindex,$sem);
           echo  $lastinsertId ; die();
          } 
            
           foreach($savingdata as $key => $value){
             //  echo "<prE>"; print_r($value);exit;
              $matches = array();
                 preg_match('/F-\d{4}-\d{1,}/', $value[$fidindex], $matches);
                           
                $result = $stu_obj->getAllDetailsStudents1($matches[0],$sem);
                if(!$result)
                continue;
                if(in_array($matches[0],$checkarra))
                continue;
                
              $ge = explode(",",$result['ge1']);
              $aecc = explode(",",$result['course']);
              $result['ge1'] = $ge[0];
              $result['aecc1'] = $aecc[1];
              $result['year'] = date('Y'); 
              $result['exam_year'] = date('M').'-'.date('Y'); 
              $result['college'] = 'Patna Women\'s college';
               
              $data = array(
                    'student_id' => $result['student_id'],
                    'year_exam' => $result['year'],
                    'stu_name' => $result['stu_fname'],
                    'academic_year_id' => $result['academic_id'],
                    'session_id' => $result['session_id'],
                    'term_id' => $result['term_id'],
                    'fname' => $result['father_fname'],
                    'date_of_birth' => $result['stu_dob'],
                    'examination_id' => $result['exam_roll'],
                    'examination_name' => $result['exam_year'],
                    'reg_no' => $result['reg_no'],
                    'college_name' => "Patna Women's college",
                    'created_date' => date('Y-m-d'),
                    'payment_status' => 1,
                    'u_id' => $result['stu_id'],
                    'payment_activation' => 1,
                    'email' => $value[24],
                    'phone' => $value[25],
                    'pay_mode' => 'Bulk update'
                     
                );
              //  echo "<pre>";print_r($data);exit;
                if($type == 1 || $type == 2){
                    $examform =$regmodel->getAllRecordbyfid($result['stu_id'],$sem);
                    $data['exam_month_id']  = $examform['exam_month_id'];
                    if($type==1)
                    $data['non_collegiate_status']  = 0;
                    else
                    $data['non_collegiate_status']  = 1;
                }
                else
                {
                   $data['roll_no']  = $result['roll_no']; 
                }
                $null=array_filter($data,function($a){
                    return trim($a)=="";
                });
                if($null){
                    $null['u_id'] = $data['u_id'];
                    $null['exam_roll'] = $data['examination_id'];
                 continue;
                }
              
                $insertId = $regmodel->insert($data);
                  
                  if ($insertId) {
                    $paymentData = array(
                        'stu_name' => $result['stu_fname'],
                        'u_id' => $result['stu_id'],
                        'acad_id' => $result['academic_id'],
                        'total_fee' => $value[5],
                        'exam_fee' => $value[5],
                        'late_fine' => !empty($_POST['late_fine']) ? $_POST['late_fine'] : '0',
                        'exam_id' => $result['exam_roll'],
                        'mmp_txn' => $value[3],
                        'mer_txn' => $value[4],
                        'bank_txn' => $value[13],
                        'bank_name' => $value[10],
                        'prod' => $value[8],
                        'term_id' => $sem,
                        'f_code' => ucfirst(strtolower($value[11])),
                        'clientcode' => 53243,
                        'merchant_id' => 53243,
                        'submit_date' => date("Y-m-d",strtotime($value[7])),
                        'date' => $value[7],
                        'payment_id' => $insertId,
                    ); 
                      if($type == 3){
                      $paymentData['type'] = 3;
                      $paymentData['non_collegiate_status'] = 0;   
                      }
                     else if($type==2){
                         $paymentData['non_collegiate_status'] = 1; 
                      }
                      
                    $checkarra[] = $result['stu_id'];
                    $lastinsertId = $feeCollection->insert($paymentData);
            }    
   }
            
         
            echo $lastinsertId; die;
        }
    }
    
    
        public function ajaxInsertAddonRecordsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            
            $stu_obj = new Application_Model_AddonMarksheets();
            $savingdata = $this->_getParam("savingdata");
            $headers = $this->_getParam("headers");
            $type = $this->_getParam("fees_type");
            $fidindex = $this->_getParam("fidindex");
            $sem = $this->_getParam("sem");
            $lastinsertId = false;
            $checkarra = array();
            $resultheaders = array();
            
            
            if($stu_obj->saveRows($savingdata['data'])){
                echo  1; die;}
            else{
                echo 0; die;
            }
        }
    }
    
    
    
    
      public function updatesemfeerecords($savingdata,$type,$fidindex,$sem) {
     
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $stu_obj = new Application_Model_StudentPortal();
            $feeCollection = new Application_Model_FeesCollection();
            $lastinsertId = false;
            $checkarra = array();
           $tstarr = array();
           foreach($savingdata as $key => $value){
             //  echo "<prE>"; print_r($value);exit;
                 $matches = array();
                 preg_match('/F-\d{4}-\d{1,}/', $value[$fidindex], $matches);
                 $payrecord = $feeCollection->getPayTotRecords($matches[0],$sem,0);          
                $result = $stu_obj->getAllDetailsStudents1($matches[0],$sem);
                if(!$result)
                continue;
                if(in_array($matches[0],$checkarra))
                continue;
                
                $data = $payrecord[0]; 
                $data['f_code'] = ucfirst(strtolower($value[11]));
                $data['mmp_txn'] = $value[3];
                $data['mer_txn'] =$value[4];
                $data['bank_txn'] =$value[13];
                $data['bank_name'] =$value[10];
                $data['prod'] =$value[8];
                $data['merchant_id'] =53243;
                $data['clientcode'] =53243;
                $data['status'] =1;
                $tstarr[] = $data;
                
             $checkarra[] = $result['stu_id'];
         $lastinsertId = $feeCollection->insert($data);
             }
    //    $feeCollection->saveRows($tstarr);
           return $lastinsertId; 
        
    }
    
    
    public function ajaxGetFeesTcmigrationRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_TcFeeCollection();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $academic_id = $this->_getParam("academic_id");
            $academic_year = $this->_getParam("academic_year");
            $session = $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $type_of_fees = $this->_getParam("type_of_fees");
            if($type_of_fees=='tc'){
                $semFee='500';
            }
            else {
                 $semFee='200';
            }
            
         
            //echo '<pre>';print_r($semFee);exit;
            $result = $feeCollection->getTcMigrationFeeRecords($academic_id,$type_of_fees);
            $paginator_data = array(
                'result' => $result,
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->semFee = $semFee;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
    public function ajaxUpdateSemesterFeesStatusAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
            $mmp_txn = $this->_getParam("mmp_txn");
            $stu_fid = $this->_getParam("stu_fid");
            $mer_txn = $this->_getParam("mer_txn");
            $bank_name= $this->_getParam("bank_name");
            $bank_txn = $this->_getParam("bank_txn");
            $date_txn = $this->_getParam("date_txn");
            $sem = $this->_getParam("sem");
            $atom_amount = $this->_getParam("atom_amount");
            $table_id = $this->_getParam("table_id");
            
            
            //$strId = $feeStr->getStructId($academic_id);
           // $allTermFee = $feeStrItem->getStructureRecords($strId);
           // print_r($allTermFee);
            
                $tcUpdateData = array(
                            'mmp_txn' => $mmp_txn,
                            'mer_txn' => $mer_txn,
                            'bank_name' => $bank_name,
                            'bank_txn' => $bank_txn,
                            'prod'=> 'PRINCIPAL_PWC',
                    	    'f_code'=> 'Ok',
                    	    'clientcode'=> '53243',
                            'merchant_id'=> '53243',
                            'status'=> '1',
                            'date'=> $date_txn,
                        );

          $update_id = $feeCollection->update($tcUpdateData, array('stu_id=?' => $stu_fid,'semester=?'=>$sem,'fee=?'=>$atom_amount,'id=?'=>$table_id));
               
                if($update_id){
                    echo "Update successfully";
                }
        } die();
    }
    
    
     public function ajaxUpdateSemesterLatefineStatusAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_Latefine();
            
            $mmp_txn = $this->_getParam("mmp_txn");
            $stu_fid = $this->_getParam("stu_fid");
            $mer_txn = $this->_getParam("mer_txn");
            $bank_name= $this->_getParam("bank_name");
            $bank_txn = $this->_getParam("bank_txn");
            $date_txn = $this->_getParam("date_txn");
            $sem = $this->_getParam("sem");
            $atom_amount = $this->_getParam("atom_amount");
            $table_id = $this->_getParam("table_id");
            //echo $sem;
           // die();
            //$strId = $feeStr->getStructId($academic_id);
           // $allTermFee = $feeStrItem->getStructureRecords($strId);
           // print_r($allTermFee);
            
                $tcUpdateData = array(
                            'mmp_txn' => $mmp_txn,
                            'mer_txn' => $mer_txn,
                            'bank_name' => $bank_name,
                            'bank_txn' => $bank_txn,
                            'prod'=> 'PRINCIPAL_PATNA_WOMENS',
                    	    'f_code'=> 'Ok',
                    	    'clientcode'=> '53243',
                            'merchant_id'=> '53243',
                            'status'=> '1',
                            'date'=> $date_txn,
                        );

          $update_id = $feeCollection->update($tcUpdateData, array('stu_id=?' => $stu_fid,'term=?'=>$sem,'id=?'=>$table_id));
               
                if($update_id){
                    echo "Update successfully";
                }
        } die();
    }
    
     public function ajaxUpdateEndexamFeesStatusAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_ExamformSubmissionModel();
            $submitmodel = new Application_Model_ExamfeeSubmitModel();
            
            $mmp_txn = $this->_getParam("mmp_txn");
            $stu_fid = $this->_getParam("stu_fid");
            $mer_txn = $this->_getParam("mer_txn");
            $bank_name= $this->_getParam("bank_name");
            $bank_txn = $this->_getParam("bank_txn");
            $date_txn = $this->_getParam("date_txn");
            $sem = $this->_getParam("sem");
            $pay_id = $this->_getParam("pay");
            $atom_amount = $this->_getParam("atom_amount");
          
            //echo $sem;
           // die();
            //$strId = $feeStr->getStructId($academic_id);
           // $allTermFee = $feeStrItem->getStructureRecords($strId);
           // print_r($allTermFee);
            
                $examsubmissionData = array(
                          'payment_status'=> '1',
                        );
                $paymentupdateData = array(
                            'mmp_txn' => $mmp_txn,
                            'mer_txn' => $mer_txn,
                            'bank_name' => $bank_name,
                            'bank_txn' => $bank_txn,
                            'prod'=> 'PWC_REMITTANCE',
                    	    'f_code'=> 'Ok',
                    	    'clientcode'=> '53243',
                            'merchant_id'=> '53243',
                            'status'=> '1',
                            'date'=> $date_txn,
                        );

          $update_id = $feeCollection->update($examsubmissionData, array('u_id=?' => $stu_fid,'term_id=?'=>$sem,'id=?'=>$pay_id));
          $updatepay_id = $submitmodel->update($paymentupdateData, array('u_id=?' => $stu_fid,'payment_id=?'=>$pay_id));
               
                if($updatepay_id){
                    echo "Update successfully";
                }
        } die();
    }
    
    
       public function ajaxUpdateNonEndexamFeesStatusAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_UgNonformSubmissionModel();
            $submitmodel = new Application_Model_NonColpayment();
            
            $mmp_txn = $this->_getParam("mmp_txn");
            $stu_fid = $this->_getParam("stu_fid");
            $mer_txn = $this->_getParam("mer_txn");
            $bank_name= $this->_getParam("bank_name");
            $bank_txn = $this->_getParam("bank_txn");
            $date_txn = $this->_getParam("date_txn");
            $sem = $this->_getParam("sem");
            $pay_id = $this->_getParam("pay");
            $exam_id = $this->_getParam("exam_date");
            $atom_amount = $this->_getParam("atom_amount");
            //echo $sem;
           // die();
            //$strId = $feeStr->getStructId($academic_id);
           // $allTermFee = $feeStrItem->getStructureRecords($strId);
           // print_r($allTermFee);
            
                $examsubmissionData = array(
                          'payment_status'=> '1',
                        );
                $paymentupdateData = array(
                            'mmp_txn' => $mmp_txn,
                            'mer_txn' => $mer_txn,
                            'bank_name' => $bank_name,
                            'bank_txn' => $bank_txn,
                            'prod'=> 'PWC_REMITTANCE',
                    	    'f_code'=> 'Ok',
                    	    'clientcode'=> '53243',
                            'merchant_id'=> '53243',
                            'status'=> '1',
                            'date'=> $date_txn,
                        );

          $update_id = $feeCollection->update($examsubmissionData, array('u_id=?' => $stu_fid,'term_id=?'=>$sem,'exam_month_id=?'=>$exam_id,'id=?'=>$pay_id));
          $updatepay_id = $submitmodel->update($paymentupdateData, array('u_id=?' => $stu_fid,'payment_id=?'=>$pay_id));
               
                if($updatepay_id){
                    echo "Update successfully";
                }
        } die();
    }
    
    public function ajaxUpdateTcmigrationStatusAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_TcFeeCollection();
           // $submitmodel = new Application_Model_NonColpayment();
            
            $mmp_txn = $this->_getParam("mmp_txn");
            $stu_fid = $this->_getParam("stu_fid");
            $mer_txn = $this->_getParam("mer_txn");
            $bank_name= $this->_getParam("bank_name");
            $bank_txn = $this->_getParam("bank_txn");
            $date_txn = $this->_getParam("date_txn");
            $acad_id = $this->_getParam("acad_id");
            $pay_id = $this->_getParam("pay");
            //$exam_id = $this->_getParam("exam_date");
            $atom_amount = $this->_getParam("atom_amount");
            //echo $sem;
           // die();
            //$strId = $feeStr->getStructId($academic_id);
           // $allTermFee = $feeStrItem->getStructureRecords($strId);
           // print_r($allTermFee);
            
              
                $paymentupdateData = array(
                            'mmp_txn' => $mmp_txn,
                            'mer_txn' => $mer_txn,
                            'bank_name' => $bank_name,
                            'bank_txn' => $bank_txn,
                            'prod'=> 'PRINCIPAL_PWC',
                    	    'f_code'=> 'Ok',
                    	    'clientcode'=> '53243',
                            'merchant_id'=> '53243',
                            'status'=> '1',
                            'amount'=> $atom_amount,
                            'date'=> $date_txn,
                        );

         // $update_id = $feeCollection->update($examsubmissionData, array('u_id=?' => $stu_fid,'term_id=?'=>$sem,'exam_month_id=?'=>$exam_id));
          $updatepay_id = $feeCollection->update($paymentupdateData, array('stu_id=?' => $stu_fid,'acad_id=?'=>$acad_id,'id=?'=>$pay_id));
               
                if($updatepay_id){
                    echo "Update successfully";
                }
        } die();
    }
    
 public function alumniFeeUpdationAction() {
        $this->view->action_name = 'AlUMNIUP';
        $this->view->sub_title_name = 'AlUMNIUP';
        $this->accessConfig->setAccess('SA_ALUM_FEE_UP');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $alumini_model = new Application_Model_Aluminiassociation();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
               
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/alumini-fee-updation');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    public function alumniListAction() {
        $this->view->action_name = 'ALUMNILIST';
        $this->view->sub_title_name = 'ALUMNILIST';
        $this->accessConfig->setAccess('SA_ALUM_REG_DT');
        $student_report_form = new Application_Form_StudentsAdmitcard();
       
        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
          // echo '<pre>'; print_r($id); exit;
        $alumini_model = new Application_Model_Aluminiassociation();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
               
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_name'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/alumini-fee-updation');

                break;
            case "edit":
               $row= $alumini_model->getRecord($id);
                 $this->view->row = $row;
                   if ($this->_request->isPost() && $this->getRequest()) {
                       
                   
                     $dirPath1 = realpath(APPLICATION_PATH . '/../public/alumini') .'/doc/';
              $extensions=array("jpeg","jpg","png","pdf");    
                $file_name = $_FILES['document']['name'];
                $file_size =$_FILES['document']['size'];
                $file_tmp =$_FILES['document']['tmp_name'];
                $file_type=$_FILES['document']['type'];
                $file_ext=explode('.',$_FILES['document']['name']);
               
              if(!empty($_FILES['document']['name']) && in_array($file_ext[1], $extensions)){
                  
                  move_uploaded_file($_FILES["document"]["tmp_name"], $dirPath1.$file_name) ;
                   
              }

       // print_r($data); die();
              if($_POST['pay_mode']!='Online'){
                  
                    $data = $this->getRequest()->getPost();
                    //$data['document']=$file_name;
                    $data['status']='1';
                    $data['f_code']='Ok';
                    $data['mer_txn']=$data['bank_txn'];
                    $data['clientcode']='53243';
                    $data['merchant_id']='53243';
                    
                //   $data = array(
                    
                    
                //     'mmp_txn' => $_POST['mmp_txn'],
                //     'mer_txn' => $_POST['bank_txn'],
                //     'bank_txn' => $_POST['bank_txn'],
                //     'bank_name' => $_POST['bank_name'],
                //     'prod' => 'PRINCIPAL_PWC',
                //     'date' => $_POST['date'],
                //     'f_code' => 'Ok',
                //     'clientcode' => '53243',
                //     'merchant_id'=> '53243',
                //     'pay_mode' => $_POST['pay_mode'],
                //     'document'=>$file_name,
                //     'status' => 1
                // );
                  
                  
              }    
           
                $last_insert_id= $alumini_model->update($data, array('id=?'=>$id))  ;   
                  if($last_insert_id) {
                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                 $this->_redirect('report/alumni-list');
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
               $_SESSION['message_class'] = 'alert-danger';
               $this->_flashMessenger->addMessage('Not Insert ');
                $this->_redirect('report/alumni-list');
                
            }
                   }
                 
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    
      public function ajaxGetAlumniRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
           $alumini_model = new Application_Model_Aluminiassociation();
           
            $f_date = $this->_getParam("f_date");
            $to_date = $this->_getParam("to_date");
            

            

            $result = $alumini_model->getAlumniRecords($f_date, $to_date);
            //echo '<PRE>';            print_r($result);DIE;
            $paginator_data = array(
                'result' => $result,
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;
            //$this->view->examdate=$exam_date;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
     public function contributorListAction() {
        $this->view->action_name = 'CONTRIILIST';
        $this->view->sub_title_name = 'CONTRIILIST';
        $this->accessConfig->setAccess('SA_ALUM_REG_DT');
        $student_report_form = new Application_Form_StudentsAdmitcard();
       
        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
          // echo '<pre>'; print_r($id); exit;
        $alumini_model = new Application_Model_Contribution();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
               
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_name'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/alumini-fee-updation');

                break;
            case "edit":
               $row= $alumini_model->getRecord($id);
                 $this->view->row = $row;
                   if ($this->_request->isPost() && $this->getRequest()) {
                       
                    
                     $dirPath1 = realpath(APPLICATION_PATH . '/../public/alumini') .'/doc/';
              $extensions=array("jpeg","jpg","png","pdf");    
                $file_name = $_FILES['document']['name'];
                $file_size =$_FILES['document']['size'];
                $file_tmp =$_FILES['document']['tmp_name'];
                $file_type=$_FILES['document']['type'];
                $file_ext=explode('.',$_FILES['document']['name']);
               
              if(!empty($_FILES['document']['name']) && in_array($file_ext[1], $extensions)){
                  
                  move_uploaded_file($_FILES["document"]["tmp_name"], $dirPath1.$file_name) ;
                   
              }

        // die();
              if($_POST['pay_mode']!='Online'){
                  
                   $data = $this->getRequest()->getPost();
                    
                    $data['status']='1';
                    $data['f_code']='Ok';
                    $data['mer_txn']=$data['bank_txn'];
                    $data['clientcode']='53243';
                    $data['merchant_id']='53243';
//                   $data = array(
//                    
//                    
//                    'mmp_txn' => $_POST['mmp_txn'],
//                    'mer_txn' => $_POST['bank_txn'],
//                    'bank_txn' => $_POST['bank_txn'],
//                    'bank_name' => $_POST['bank_name'],
//                    'prod' => 'PRINCIPAL_PWC',
//                    'date' => $_POST['date'],
//                    'f_code' => 'Ok',
//                    'clientcode' => '53243',
//                    'merchant_id'=> '53243',
//                    'pay_mode' => $_POST['pay_mode'],
//                    'document'=>$file_name,
//                    'status' => 1
//                );
//                  
                  
              }  
              
                $last_insert_id= $alumini_model->update($data, array('id=?'=>$id))  ;   
                  if($last_insert_id) {
                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                 $this->_redirect('report/contributor-list');
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
               $_SESSION['message_class'] = 'alert-danger';
               $this->_flashMessenger->addMessage('Not Insert ');
                $this->_redirect('report/contributor-list');
                
            }
                   }
                 
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    
    public function ajaxGetContributorRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
           $alumini_model = new Application_Model_Contribution();
           
            $f_date = $this->_getParam("f_date");
            $to_date = $this->_getParam("to_date");
            

            

            $result = $alumini_model->getAlumniRecords($f_date, $to_date);
            //echo '<PRE>';            print_r($result);DIE;
            $paginator_data = array(
                'result' => $result,
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;
            //$this->view->examdate=$exam_date;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
     public function contributorFeeUpdationAction() {
        $this->view->action_name = 'CONTRIUP';
        $this->view->sub_title_name = 'CONTRIUP';
        $this->accessConfig->setAccess('SA_ALUM_FEE_UP');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $alumini_model = new Application_Model_Contribution();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
              
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_name'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/contributor-fee-updation');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    //=================================][seminar][============================//
     public function seminarFeeUpdationAction() {
        $this->view->action_name = 'SEMINARUP';
        $this->view->sub_title_name = 'SEMINARUP';
        $this->accessConfig->setAccess('SA_SEMINAR_FEE_UP');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $alumini_model = new Application_Model_Seminarassociation();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":
                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
              // echo "<pre>";print_r($semFeeDetails);exit;
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/seminar-fee-updation');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    public function seminarListAction() {
        $this->view->action_name = 'SEMINARLIST';
        $this->view->sub_title_name = 'SEMINARLIST';
        $this->accessConfig->setAccess('SA_SEMINAR_REG_DT');
        $student_report_form = new Application_Form_StudentsAdmitcard();
       
        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
          // echo '<pre>'; print_r($id); exit;
        $alumini_model = new Application_Model_Seminarassociation();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
               
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
                //echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_name'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/alumini-fee-updation');

                break;
            case "edit":
               $row= $alumini_model->getRecord($id);
                 $this->view->row = $row;
                   if ($this->_request->isPost() && $this->getRequest()) {
                       
                   
                     $dirPath1 = realpath(APPLICATION_PATH . '/../public/alumini') .'/doc/';
              $extensions=array("jpeg","jpg","png","pdf");    
                $file_name = $_FILES['document']['name'];
                $file_size =$_FILES['document']['size'];
                $file_tmp =$_FILES['document']['tmp_name'];
                $file_type=$_FILES['document']['type'];
                $file_ext=explode('.',$_FILES['document']['name']);
               
              if(!empty($_FILES['document']['name']) && in_array($file_ext[1], $extensions)){
                  
                  move_uploaded_file($_FILES["document"]["tmp_name"], $dirPath1.$file_name) ;
                   
              }

       // print_r($data); die();
              if($_POST['pay_mode']!='Online'){
                  
                    $data = $this->getRequest()->getPost();
                    //$data['document']=$file_name;
                    $data['status']='1';
                    $data['f_code']='Ok';
                    $data['mer_txn']=$data['bank_txn'];
                    $data['clientcode']='53243';
                    $data['merchant_id']='53243';
                    
                //   $data = array(
                    
                    
                //     'mmp_txn' => $_POST['mmp_txn'],
                //     'mer_txn' => $_POST['bank_txn'],
                //     'bank_txn' => $_POST['bank_txn'],
                //     'bank_name' => $_POST['bank_name'],
                //     'prod' => 'PRINCIPAL_PWC',
                //     'date' => $_POST['date'],
                //     'f_code' => 'Ok',
                //     'clientcode' => '53243',
                //     'merchant_id'=> '53243',
                //     'pay_mode' => $_POST['pay_mode'],
                //     'document'=>$file_name,
                //     'status' => 1
                // );
                  
                  
              }    
           
                $last_insert_id= $alumini_model->update($data, array('id=?'=>$id))  ;   
                  if($last_insert_id) {
                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                 $this->_redirect('report/alumni-list');
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
               $_SESSION['message_class'] = 'alert-danger';
               $this->_flashMessenger->addMessage('Not Insert ');
                $this->_redirect('report/alumni-list');
                
            }
                   }
                 
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    
      public function ajaxGetSeminarRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
           $alumini_model = new Application_Model_Seminarassociation();
           
            $f_date = $this->_getParam("f_date");
            $to_date = $this->_getParam("to_date");
            

            

            $result = $alumini_model->getAlumniRecords($f_date, $to_date);
          //  echo '<PRE>';            print_r($result);DIE;
            $paginator_data = array(
                'result' => $result,
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;
            //$this->view->examdate=$exam_date;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
     public function contributorSeminarListAction() {
        $this->view->action_name = 'CONTRIILIST';
        $this->view->sub_title_name = 'CONTRIILIST';
        $this->accessConfig->setAccess('SA_SEMINAR_REG_DT');
        $student_report_form = new Application_Form_StudentsAdmitcard();
       
        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
          // echo '<pre>'; print_r($id); exit;
        $alumini_model = new Application_Model_Contribution();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
               
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_name'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/alumini-fee-updation');

                break;
            case "edit":
               $row= $alumini_model->getRecord($id);
                 $this->view->row = $row;
                   if ($this->_request->isPost() && $this->getRequest()) {
                       
                    
                     $dirPath1 = realpath(APPLICATION_PATH . '/../public/alumini') .'/doc/';
              $extensions=array("jpeg","jpg","png","pdf");    
                $file_name = $_FILES['document']['name'];
                $file_size =$_FILES['document']['size'];
                $file_tmp =$_FILES['document']['tmp_name'];
                $file_type=$_FILES['document']['type'];
                $file_ext=explode('.',$_FILES['document']['name']);
               
              if(!empty($_FILES['document']['name']) && in_array($file_ext[1], $extensions)){
                  
                  move_uploaded_file($_FILES["document"]["tmp_name"], $dirPath1.$file_name) ;
                   
              }

        // die();
              if($_POST['pay_mode']!='Online'){
                  
                   $data = $this->getRequest()->getPost();
                    
                    $data['status']='1';
                    $data['f_code']='Ok';
                    $data['mer_txn']=$data['bank_txn'];
                    $data['clientcode']='53243';
                    $data['merchant_id']='53243';
//                   $data = array(
//                    
//                    
//                    'mmp_txn' => $_POST['mmp_txn'],
//                    'mer_txn' => $_POST['bank_txn'],
//                    'bank_txn' => $_POST['bank_txn'],
//                    'bank_name' => $_POST['bank_name'],
//                    'prod' => 'PRINCIPAL_PWC',
//                    'date' => $_POST['date'],
//                    'f_code' => 'Ok',
//                    'clientcode' => '53243',
//                    'merchant_id'=> '53243',
//                    'pay_mode' => $_POST['pay_mode'],
//                    'document'=>$file_name,
//                    'status' => 1
//                );
//                  
                  
              }  
              
                $last_insert_id= $alumini_model->update($data, array('id=?'=>$id))  ;   
                  if($last_insert_id) {
                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                 $this->_redirect('report/contributor-list');
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
               $_SESSION['message_class'] = 'alert-danger';
               $this->_flashMessenger->addMessage('Not Insert ');
                $this->_redirect('report/contributor-list');
                
            }
                   }
                 
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    
    public function ajaxGetContributorSeminarRecordAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
           $alumini_model = new Application_Model_Contribution();
           
            $f_date = $this->_getParam("f_date");
            $to_date = $this->_getParam("to_date");
            

            

            $result = $alumini_model->getAlumniRecords($f_date, $to_date);
            //echo '<PRE>';            print_r($result);DIE;
            $paginator_data = array(
                'result' => $result,
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;
            //$this->view->examdate=$exam_date;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
     public function contributorSeminarFeeUpdationAction() {
        $this->view->action_name = 'CONTRIUP';
        $this->view->sub_title_name = 'CONTRIUP';
        $this->accessConfig->setAccess('SA_ALUM_FEE_UP');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $alumini_model = new Application_Model_Contribution();
       
        
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $email = $_POST['email'];
                $mobile= $_POST['mobile'];
                $semFeeDetails = $alumini_model->getRecordByEmailID(trim($email), $mobile);
               $payDetails = $alumini_model->getRecordByPaid(trim($email), $mobile);
              
                $this->view->stud_info = $semFeeDetails;
                $this->view->pay_info=$payDetails;
                
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
               // echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    
                    
                    'mmp_txn' => $_POST['mmp_txn'],
                    'mer_txn' => $_POST['bank_txn'],
                    'bank_txn' => $_POST['bank_txn'],
                    'bank_name' => $_POST['bank_name'],
                    'prod' => $_POST['prod_name'],
                    'date' => $submitDate,
                    'f_code' => 'Ok',
                    'clientcode' => '53243',
                    'merchant_id'=> '53243',
                    'pay_mode' => $_POST['pay_mode'],
                    'status' => 1
                );
               // echo '<pre>'; print_r($data); exit;
                $insertId = $alumini_model->update($data,array('id=?'=>$_POST['id']));
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('report/contributor-fee-updation');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
	
	
	public function holidayAction() {
        $this->view->action_name = 'holiday';
        $this->view->sub_title_name = 'Student-Holiday';
		$holiday_form = new Application_Form_Holiday();
        $holidayList = new Application_Model_DmiHoliday();
		$this->view->form = $holiday_form;
        $all_holiday = $holidayList->getHolidayListAll($this->holidayCategory[0]);

        $this->view->result = $all_holiday;
    }
	
	
	
	
	public function getHolidayListAction() {
        $this->view->action_name = 'holiday';
        $this->view->sub_title_name = 'Student-Holiday';
		$holiday_form = new Application_Form_Holiday();
        $holidayList = new Application_Model_DmiHoliday();
		$this->view->form = $holiday_form;
		
		 $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
           $alumini_model = new Application_Model_Contribution();
           
            $year = $this->_getParam("pd");
            
		
        $all_holiday = $holidayList->getholidaylistyear($year);
        
        $this->view->result = $all_holiday;
		
		}
    }
	
public function collectionWiseReportAction() {
        $this->view->action_name = 'student-term-report';
        $this->view->sub_title_name = 'student-term-report';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_CollectionReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }



public function getCollectionReportAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $Studentreport_model = new Application_Model_StudentPortal();
		
	    $collectionmodel = new Application_Model_FeeCollector();
        $termMaster_model = new Application_Model_TermMaster();
        $tr_model = new Application_Model_TabulationReport();
        
        //$result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $year_id = $this->_getParam("year_id");
            $term_id = $this->_getParam("term_id");
            $arc_status = $this->_getParam("arc_status");
            $montharchive = $this->_getParam("arc");
            $reval_status = $this->_getParam("reval_status");
            $reval_date = $this->_getParam("revalDate");

            $filter_status = $this->_getParam("filter_status");

            $this->view->term_id = $term_id;
            $this->view->year_id = $year_id;
			$this->view->filter_status = $filter_status;
            $this->view->arc_status = !$arc_status ? !$reval_status ? '' : 'R' : 'B';
            $this->view->archive = !$montharchive ? !$reval_date ? '' : $reval_date : $montharchive;
            $stu_id = $this->_getParam("stu_id");

            $acadModel = new Application_Model_Academic();
            $deptModel = new Application_Model_Department();

            $getDepartMent = $acadModel->getDepartment($academic_id);
          //  echo '<pre>';print_r($term_id);exit;
            $getDegreeId = $deptModel->getRecord($getDepartMent['department']);
            if($term_id){
                //$termId= $termMaster_model->getTermId($academic_id,$term_id);
               // echo '<pre>';print_r($academic_id);exit;
                //$tablId= $tr_model->getTablIdForFilter($academic_id, $termId['term_id']);
               /// echo '<pre>';print_r($tablId);exit;
                $result = $collectionmodel->getCollectionWiseFilteredStudentRecord($academic_id,$term_id,$filter_status);
            }
            //echo '<pre>'; print_R($result);exit;
            $this->view->corecourseresult = $result;
        }
    }

public function userWiseReportAction() {
        $this->view->action_name = 'student-term-report';
        $this->view->sub_title_name = 'student-term-report';
        $this->accessConfig->setAccess('SA_ACAD_TERM_GRADE_SHEET');
        $student_report_form = new Application_Form_UserCollectionReport();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_report_form;
    }	
	
public function getUserWiseReportAction() {
        $this->_helper->layout->disableLayout();
        $fee_hsitroy = new Application_Model_FeeHistroy();
     
        
        //$result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $empl_id = $this->_getParam("empl_id");
            $f_date = $this->_getParam("f_date");
            $to_date = $this->_getParam("to_date");
            
                $result = $fee_hsitroy->getUserTrans($empl_id,$f_date,$to_date);
          
            //echo '<pre>'; print_R($result);exit;
            $this->view->corecourseresult = $result;
        }
    }	
	
	
}
