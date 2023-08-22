<?php

/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */

class PlanController extends Zend_Controller_Action {

    private $_siteurl = null;
    private $_db = null;
    private $_flashMessenger = null;
    private $_authontication = null;
    private $_agentsdata = null;
    private $_usersdata = null;
    private $_act = null;
    private $_adminsettings = null;
    private $_auth_id = null;
    private $_role_id = null;
    private $accessConfig =NULL;

    public function init() {
        $zendConfig = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
                require_once APPLICATION_PATH . '/configs/access_level.inc';
                        
        $this->accessConfig = new accessLevel();
        $config = $zendConfig->mainconfig->toArray();
        $this->view->mainconfig = $config;
        $this->_action = $this->getRequest()->getActionName();
        //access role id
        $config_role = $zendConfig->role_administrator->toArray();
        $this->view->administrator_role = $config_role;
        $storage = new Zend_Session_Namespace("admin_login");
        $data = $storage->admin_login;
        $this->view->login_storage = $data;
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
        $this->authonticate();
        $uploadPaths = realpath(APPLICATION_PATH . '/../public/') . '/';
        $this->view->validator = new Zend_Validate_File_Exists();
        $this->view->validator->addDirectory($uploadPaths);

        //$this->_auth_id = $this->_act->auth_id();
        //$this->_role_id = $this->_act->role_id();
        //$this->view->role_id = $this->_act->role_id();
    }

    protected function authonticate() {
        $storage = new Zend_Session_Namespace("admin_login");
        $data = $storage->admin_login;
        //print_r($data); die;
        if ($data->role_id == 0)
            $this->_redirect('student-portal/student-dashboard');
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

    /* 	public function indexAction() { 

      $zendConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
      $config = $zendConfig->mainconfig->toArray();
      $this->view->mainconfig = $config;

      } */

    public function durationAction(){
        $this->view->action_name = 'duration';
        $this->view->sub_title_name = 'duration';
        $this->accessConfig->setAccess('SS_ACAD_DURATION');
        $Credit_model = new Application_Model_Duration();
        $Credit_form = new Application_Form_Duration();
        //s print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        $data['created_date'] = date('Y-m-d');
                        $data['duration_from'] = date('H:i', strtotime($data['duration_from']));
                        $data['duration_to'] = date('H:i', strtotime($data['duration_to']));
                        $bool = $Credit_model->getDuration($data['duration_from'], $data['duration_to']);

                        if (count($bool) == 0) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Duration Added successfully';
                            $Credit_model->insert($data);
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'Duration from"' . $data['duration_from'] . '-' . $data['duration_to'] . ' already exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/duration');
                    }
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);
                $result['duration_from'] = date('h:i A', strtotime($result['duration_from']));
                $result['duration_to'] = date('h:i A', strtotime($result['duration_to']));
                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        $data['last_modified_date'] = date('Y-m-d');
                        $data['duration_from'] = date('H:i', strtotime($data['duration_from']));
                        $data['duration_to'] = date('H:i', strtotime($data['duration_to']));
                        $Credit_model->update($data, array('id=?' => $credit_id));
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/duration');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Credit_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

        public function ajaxGetTimeSlotAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $date = $this->_getParam("date");

            $room_no = new Application_Model_Operation();
            $result = $room_no->getTimeSlot($date);
           // echo "<pre>";print_r($result);die();
            echo '<option value="">Select</option>';
            foreach ($result as $key => $row) { 
                echo '<option value="' . $row['duration'] . '" >' . $row['duration_from'] .'-'. $row['duration_to']  . ' </option>';

            }
           
        }
         exit;
    }
       

         public function ajaxGetRoomNoAction() { 

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $date = $this->_getParam("room_number");          
            $room_no = new Application_Model_Operation();             
            $result = $room_no->getRoomNo($date);  
            echo '<option value="">Select</option>';
            foreach ($result as $key => $row) {  
                
                echo '<option value="' . $row['id'] . '" >'.$row['room_number']  . ' </option>';
            }
           
        }
         exit;
    }

        public function ajaxGetAllScheduleSeatiingPlanViewAction() { 

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $date = $this->_getParam("date");
             $room = $this->_getParam("room");
             $time = $this->_getParam("time");

            $room_no = new Application_Model_Operation();    
            //===========[y-m-d format]===================//
            
            /*$date = explode('/',$date);*/
            $result = $room_no->getAllExamSchedule($date,$time,$room); 


// foreach ($result as $key => $row){



//             $course_master = new Application_Model_Course(); 

//             $result_course_by_id = $course_master->getRecord($row['course_id']);
//              foreach ($result_course_by_id as $keys => $rows)
//              {
//                echo ($rows['course_name']);
//              }

//         } 


     //  print_r($result);die();
        $this->view->plans=$result;
    }
}



    public function ajaxGetAllBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {


            $department = new Application_Model_Academic();
            $result = $department->getRecords();

            echo '<option value="">Select</option>';
            foreach ($result as $row) {
                echo '<option value="' . $row['academic_year_id'] . '" >' . $row['short_code'] . ' </option>';
            }
        }
        exit;
    }

    public function ajaxGetBatchByDepartmentIdAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $department_id = $this->_getParam("department");
            $department = new Application_Model_Academic();
            $result = $department->getRecordsByDepartment($department_id);

            foreach ($result as $key => $row) {
                $arr[$key] = $row['academic_year_id'];
            }
        }
        echo implode(',', $arr);
        exit;
    }

    public function ajaxGetCourseAction() {
        $course_details = new Application_Model_Attendance();
        $course_master = new Application_Model_Course();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            $term_ids = new Application_Model_TermMaster();
            $term_res = $term_ids->getRecordByCmnTerms($term_id);
            $term_res = $this->mergData($term_res, array('term_id'), count($term_res));
            $batch_id = $this->_getParam('academic_year_id');
            $result = $course_details->getCourseDetailsIn($term_res, $batch_id);
            $main_result = array_merge(explode(',',$result['paper']),explode(',',$result['back_paper']));
            $unique_course = array_unique($main_result);
            $unique_course = array_filter($unique_course, function($value){return $value != '';});
            $result = array();
            foreach($unique_course as $key => $value){
               $result[$value] =   $course_master->getCourseCodeById($value)['course_code'];
            }
            echo '<option value="">Select</option>';
            foreach ($result as $key => $value) {
                echo '<option value="' . $key . '" >' . $value. '</option>';
            }
        }die;
    }

    public function ajaxGetBatchLeftStudentsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department_id = $this->_getParam("department");
            $course_id = $this->_getParam('course_id');
            $date = $this->_getParam('date');
            $duration = $this->_getParam('duration');
            if (!$date) {
                echo '<script>alert("please select booking date !");</script>';
            } else {
                $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
            }
            $department = new Application_Model_ExamBatch();
            $student = new Application_Model_Student();
            $result = $department->getBatch('', $department_id);

            echo '<option value="">Select</option>';
            foreach ($result as $row) {

                $studentLeft = $student->getStudentCount($department_id, $row['id'], $course_id, $date,$duration);
                if ($studentLeft != 0){
                    echo '<option value="' . $row['id'] . '" >' . $row['batch'] . ' | Student Left ' . $studentLeft . ' </option>';
                }
            }
        }
        exit;
    }

    public function ajaxGetBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department_id = $this->_getParam("department");

            $department = new Application_Model_ExamBatch();
            $result = $department->getBatch('', $department_id);
            //echo "<pre>";print_r($department_id);exit;
            echo '<option value="">Select </option>';
            foreach ($result as $row) {
                echo '<option value="' . $row['id'] . '" >' . $row['batch'] . '</option>';
            }
        }
        exit;
    }

    public function ajaxGetDeptAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department_id = $this->_getParam("department");
            $course_id = $this->_getParam('course_id');
            $date = $this->_getParam('date');
            $batch = $this->_getParam('batch');
            $duration = $this->_getParam('duration');
            $department = new Application_Model_Student();
         //   $student = new Application_Model_ExamBatch();
           // $result = $student->getBatch('', $department_id);

            if (!$date) {
                echo '<script>alert("please select booking date !");</script>';
            } else {
                $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
            }
            $result = $department->getDropDownList1($department_id, $course_id, $date,$batch,$duration);
          //  echo "<pre>"; print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $row) {
                echo '<option value="' . $row['application_id'] . '" >' . $row['application_id'] .' - '. $row['stu_name'].'</option>';
            }
        }
        exit;
    }

    public function ajaxGetUpdatedRoomAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $date = $this->_getParam("date");
            $duration = $this->_getParam("duration");
            $batch = $this->_getParam("batch");
            $department = $this->_getParam("department");
            $course = $this->_getParam("course");

            $room_no = new Application_Model_Room();
            $data = $room_no->getDropDownList(date('Y-m-d', strtotime(str_replace('/', '-', $date))), $duration, $department, $batch,$course);

            echo $data;
            exit;
        }
    }

    public function operationAction() {

        $this->view->action_name = 'operation';
        $this->view->sub_title_name = 'operation';
        $this->accessConfig->setAccess('SS_ACAD_OPERATION');
        //print_r('hello');exit;
        $Credit_model = new Application_Model_Operation();
        $Credit_form = new Application_Form_Operation();
        $registration = new Application_Model_Student();
        $room = new Application_Model_Room();

        //s print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    $data = $Credit_form->getValues();
                    $no_of_rooms = count($_POST['hiddenroll']);
                    $data['booking_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['booking_date'])));
                    $data['department'] = $_POST['department'];
                    $data['batch'] = $_POST['batch'];
                    $data['duration'] = $_POST['duration'];
                    $data['room_no'] = $_POST['room_no'];
                    $data['roll_start'] = $_POST['roll_start'];
                    $data['roll_end'] = $_POST['roll_end'];
                    $data['created_date'] = date('Y-m-d');
                    $data['term_id'] = $_POST['cmn_terms'];
                    $data['course_id'] = $_POST['course_id'];
                    $data['selected_roll'] = implode(',', $_POST['hiddenroll']);
                    
                   // echo "<pre>";print_r($_POST);exit;
                    unset($data['cmn_terms']);
                    unset($data['hiddenroll']);



                    $allRegistration = $registration->getBtweenMinAndMaxId($data['roll_start'], $data['roll_end'], $data['department']);

                    if (count($allRegistration) == 0) {
                        $_SESSION['message_class'] = 'alert-danger';
                        $message = 'The Range you have Selected required and Should not be greater than End';
                    } else {
                        // $bool = $Credit_model->getStudent($data['_no'], $data['department'], $data['batch']);
                        // echo "<pre>"; print_r($allRegistration);exit;
                        $data1['alocated'] = 1;
                        $data1['date'] = $data['booking_date'];
                        $data1['duration'] = $data['duration']; 
                        $prev_alloc = $Credit_model->prevRoom($data['booking_date'], $data['duration'], $data['department'], $data['batch'], $data['room_no'],$data['course_id']);
                        $prev_details = $Credit_model->prevDetails($data['booking_date'], $data['duration'], $data['department'], $data['batch'], $data['room_no'], $data['course_id']);
                        $res = $room->getRecord($data['room_no']);
                        // print_r($prev_alloc);exit;
                        $room_no['allocated_seat'] = $no_of_rooms + $prev_alloc;
                        if ($res['seating_capacity'] >= $room_no['allocated_seat']) {
                            foreach ($allRegistration as $key => $value) {
                                $registration->update($data1, array('registration_no=?' => $value['application_id'], 'department=?' => $value['department'],'batch=?'=>$data['batch']));
                            }
                            // print_r($data['room_no']);exit;
                            $check_id = 0;
                            if (!$prev_alloc) {
                                $insert_id = $Credit_model->insert($data);
                            } 
                            else
                                {
                                $room_no['selected_roll'] = $data['selected_roll'] . ',' . $prev_details['selected_roll'];
                                $room_no['roll_end'] = $_POST['hiddenroll'][count($_POST['hiddenroll'])-1];
                                $Credit_model->update($room_no, array('booking_date=?' => $data['booking_date'], 'duration=?' => $data['duration'], 'department' => $data['department'], 'batch' => $data['batch'], 'room_no' => $data['room_no'], 'course_id' => $data['course_id']));
                                $_SESSION['message_class'] = 'alert-success';
                                $message = 'Plan Added Successfully';
                                $check_id = 1;
                            }
                            if ($insert_id) {
                                $Credit_model->update($room_no, array('id=?' => $insert_id));

                                $_SESSION['message_class'] = 'alert-success';
                                $message = 'Plan Added Successfully';
                            } else {
                                if ($check_id == 0) {
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $message = 'problem in adding !';
                                }
                            }
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'There is no Room !';
                        }
                    }

                    $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/operation');
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);
                $_SESSION['plan']['batch'] = $result['batch'];
                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {

                    $data = $Credit_form->getValues();
                    $data['department'] = $_POST['department'];
                    $data['batch'] = $_POST['batch'];
                    $data['registration_no'] = $_POST['registration_no'];
                    $data['status'] = $_POST['status'];
                    $data['created_date'] = date('Y-m-d');
                    $data['last_modified_date'] = date('Y-m-d');
                    $Credit_model->update($data, array('id=?' => $credit_id));
                    $_SESSION['message_class'] = 'alert-success';
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('plan/student');
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;

                $result = $Credit_model->getRecords();
                
               
                
                $department = new Application_Model_Department();
                $result_dept = $department->getActiveRecords();
                
                
                  $duration = new Application_Model_Duration();
                $result_dur = $duration->getActiveRecords();
                
                $Exam_batch = new Application_Model_ExamBatch();
                $result_batch = $Exam_batch->getAllBatch();
                
                
                $room = new Application_Model_Room();
                $result_room = $room->getRecords();
                $room_arr = array();
                
               
                $format_result = array();
                $room_format = array();
                $total_no_student = array();
              
                foreach($result_dur as $dur_key => $dur_value){
                    foreach($result_dept as $dept_key => $dept_value){
                          $resist_duplicate_booking = array();
                            foreach($result as $main_key => $value){
                                
                                $dur_val = $dur_value['duration_from'] .' - '.$dur_value['duration_to'];
                                if($dur_val == $value['duration'] && $dept_value['id'] == $value['department']){
                                    $total_no_student[$value['department_name']][$dur_val][$value['booking_date']]+= $value['allocated_seat'];
                                    $value['total_student'] = $total_no_student[$value['department_name']][$dur_val][$value['booking_date']];
                                    $format_result[$value['department_name']][$dur_val][$value['booking_date']][] = $value;
                                    
                                    if(!in_array($value['booking_date'], $resist_duplicate_booking)){
                                        $resist_duplicate_booking[] = $value['booking_date'];
                                    $room_arr[$value['department_name']][$dur_val][] = $value['booking_date'];
                                    }
                                    $room_format[$value['department_name']][$dur_val][$value['room']][$value['booking_date']][] = $value;
                                    
                                }
                           
                        }
                        
                    }
                }
                
                //$this->view->room = $room_arr;
                //$this->view->room_format = $room_format;
                //$this->view->main_result = $result;
                $this->view->result = $format_result;
                //$this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    public function operation1Action() {

        $this->view->action_name = 'operation';
        $this->view->sub_title_name = 'operation';
        $this->accessConfig->setAccess('SS_ACAD_OPERATION');
        //print_r('hello');exit;
        $Credit_model = new Application_Model_Operation();
        $Credit_form = new Application_Form_Operation();
        $registration = new Application_Model_Student();
        $room = new Application_Model_Room();

        //s print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    $data = $Credit_form->getValues();
                    $no_of_rooms = count($_POST['hiddenroll']);
                    $data['booking_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['booking_date'])));
                    $data['department'] = $_POST['department'];
                    $data['batch'] = $_POST['batch'];
                    $data['duration'] = $_POST['duration'];
                    $data['room_no'] = $_POST['room_no'];
                    $data['roll_start'] = $_POST['roll_start'];
                    $data['roll_end'] = $_POST['roll_end'];
                    $data['created_date'] = date('Y-m-d');
                    $data['term_id'] = $_POST['cmn_terms'];
                    $data['course_id'] = $_POST['course_id'];
                    $data['selected_roll'] = implode(',', $_POST['hiddenroll']);
                    
                   // echo "<pre>";print_r($_POST);exit;
                    unset($data['cmn_terms']);
                    unset($data['hiddenroll']);



                    $allRegistration = $registration->getBtweenMinAndMaxId($data['roll_start'], $data['roll_end'], $data['department']);

                    if (count($allRegistration) == 0) {
                        $_SESSION['message_class'] = 'alert-danger';
                        $message = 'The Range you have Selected required and Should not be greater than End';
                    } else {
                        // $bool = $Credit_model->getStudent($data['_no'], $data['department'], $data['batch']);
                        // echo "<pre>"; print_r($allRegistration);exit;
                        $data1['alocated'] = 1;
                        $data1['date'] = $data['booking_date'];
                        $data1['duration'] = $data['duration']; 
                        $prev_alloc = $Credit_model->prevRoom($data['booking_date'], $data['duration'], $data['department'], $data['batch'], $data['room_no'],$data['course_id']);
                        $prev_details = $Credit_model->prevDetails($data['booking_date'], $data['duration'], $data['department'], $data['batch'], $data['room_no'], $data['course_id']);
                        $res = $room->getRecord($data['room_no']);
                        // print_r($prev_alloc);exit;
                        $room_no['allocated_seat'] = $no_of_rooms + $prev_alloc;
                        if ($res['seating_capacity'] >= $room_no['allocated_seat']) {
                            foreach ($allRegistration as $key => $value) {
                                $registration->update($data1, array('registration_no=?' => $value['application_id'], 'department=?' => $value['department'],'batch=?'=>$data['batch']));
                            }
                            // print_r($data['room_no']);exit;
                            $check_id = 0;
                            if (!$prev_alloc) {
                                $insert_id = $Credit_model->insert($data);
                            } 
                            else
                                {
                                $room_no['selected_roll'] = $data['selected_roll'] . ',' . $prev_details['selected_roll'];
                                $room_no['roll_end'] = $_POST['hiddenroll'][count($_POST['hiddenroll'])-1];
                                $Credit_model->update($room_no, array('booking_date=?' => $data['booking_date'], 'duration=?' => $data['duration'], 'department' => $data['department'], 'batch' => $data['batch'], 'room_no' => $data['room_no'], 'course_id' => $data['course_id']));
                                $_SESSION['message_class'] = 'alert-success';
                                $message = 'Plan Added Successfully';
                                $check_id = 1;
                            }
                            if ($insert_id) {
                                $Credit_model->update($room_no, array('id=?' => $insert_id));

                                $_SESSION['message_class'] = 'alert-success';
                                $message = 'Plan Added Successfully';
                            } else {
                                if ($check_id == 0) {
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $message = 'problem in adding !';
                                }
                            }
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'There is no Room !';
                        }
                    }

                    $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/operation');
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);
                $_SESSION['plan']['batch'] = $result['batch'];
                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {

                    $data = $Credit_form->getValues();
                    $data['department'] = $_POST['department'];
                    $data['batch'] = $_POST['batch'];
                    $data['registration_no'] = $_POST['registration_no'];
                    $data['status'] = $_POST['status'];
                    $data['created_date'] = date('Y-m-d');
                    $data['last_modified_date'] = date('Y-m-d');
                    $Credit_model->update($data, array('id=?' => $credit_id));
                    $_SESSION['message_class'] = 'alert-success';
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('plan/student');
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;

                $result = $Credit_model->getRecords();
                
               
                
                $department = new Application_Model_Department();
                $result_dept = $department->getActiveRecords();
                
                
                  $duration = new Application_Model_Duration();
                $result_dur = $duration->getActiveRecords();
                
                $Exam_batch = new Application_Model_ExamBatch();
                $result_batch = $Exam_batch->getAllBatch();
                
                
                $room = new Application_Model_Room();
                $result_room = $room->getRecords();
                $room_arr = array();
                
               
                $format_result = array();
                $room_format = array();
                $total_no_student = array();
              
                foreach($result_dur as $dur_key => $dur_value){
                    foreach($result_dept as $dept_key => $dept_value){
                          $resist_duplicate_booking = array();
                            foreach($result as $main_key => $value){
                                
                                $dur_val = $dur_value['duration_from'] .' - '.$dur_value['duration_to'];
                                if($dur_val == $value['duration'] && $dept_value['id'] == $value['department']){
                                    $total_no_student[$value['department_name']][$dur_val][$value['booking_date']]+= $value['allocated_seat'];
                                    $value['total_student'] = $total_no_student[$value['department_name']][$dur_val][$value['booking_date']];
                                    $format_result[$value['department_name']][$dur_val][$value['booking_date']][] = $value;
                                    
                                    if(!in_array($value['booking_date'], $resist_duplicate_booking)){
                                        $resist_duplicate_booking[] = $value['booking_date'];
                                    $room_arr[$value['department_name']][$dur_val][] = $value['booking_date'];
                                    }
                                    $room_format[$value['department_name']][$dur_val][$value['room']][$value['booking_date']][] = $value;
                                    
                                }
                           
                        }
                        
                    }
                }
                
                //$this->view->room = $room_arr;
                //$this->view->room_format = $room_format;
                //$this->view->main_result = $result;
                $this->view->result = $format_result;
                //$this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
        
        
        public function examattemptAction () {
       // die("hi");
           $this->accessConfig->setAccess('SA_ACAD_EXAMDATE');
        $this->view->action_name = 'exam_dates';
        $this->view->sub_title_name = 'exam_dates';
        //print_r('hello');exit;
        $Cheker_model = new Application_Model_Examchecker();
        $Cheker_form = new Application_Form_Attempt();
        //  print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        
        $_SESSION['stuDent_id'] = $credit_id;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Cheker_form;
 if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                 
                if ($this->getRequest()->isPost()) {
                    $data = $_POST;
                                        
                                        
                                           
                                          
                                            $bool = $Cheker_model->getPreviousattemptyear($data['sem'], $data['session']);
                                        if ($bool['last_attempt_year']) {
                                            $_SESSION['message_class'] = 'alert-danger';
                                            $message = 'Sorry student  exist\'s"';
                                            
                                           
                                        } else {
                                            $message = 'Student Added successfully';
                                            $_SESSION['message_class'] = 'alert-success';
                                            $Cheker_model->insert($data);
                                        }
                                      
                                        $this->_flashMessenger->addMessage($message);
                                        $this->_redirect('plan/examattempt');
                            
                                        
                    
                }
                break;
            case 'edit':
                $result = $Cheker_model->getRecord($credit_id);
                $Cheker_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                  $data = $_POST;
                         
                                    
                                    
                                    
                                            $Cheker_model->update($data, array('id=?' => $credit_id));
                                            $_SESSION['message_class'] = 'alert-success';
                                    
                                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                                    $this->_redirect('plan/examattempt');
                                    
                            
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Cheker_model->getRecords();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
            
        }



    public function studentAction() {

        $this->view->action_name = 'student';
        $this->view->sub_title_name = 'student';
        $this->accessConfig->setAccess('SS_ACAD_STUDENT');
        //print_r('hello');exit;
        $Credit_model = new Application_Model_Student();
        $Credit_form = new Application_Form_Student();
        //s print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        
        $_SESSION['stuDent_id'] = $credit_id;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {

                    $data['department'] = $_POST['department'];
                    $data['batch'] = $_POST['batch'];
                    $reg_no_arr= $_POST['registration_no_box'];
                    $data['status'] = $_POST['status'];
                    $data['created_date'] = date('Y-m-d');
                    
                        foreach($reg_no_arr as $key => $value){
                    $bool = $Credit_model->getStudent($value, $data['department'], $data['batch']);
                    $data['registration_no'] = $value;
                    if (count($bool) == 0) {
                        $_SESSION['message_class'] = 'alert-success';
                        $message = 'Student Added successfully';
                        $Credit_model->insert($data);
                    } else {
                      //  $_SESSION['message_class'] = 'alert-danger';
                       // $message = 'Sorry student  exist\'s"';
                    }
                  }
                    $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/student');
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);
                $_SESSION['plan']['batch'] = $result['batch'];
                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {

                    $data = $Credit_form->getValues();
                    $data['department'] = $_POST['department'];
                    $data['batch'] = $_POST['batch'];
                    $reg_no_arr= $_POST['registration_no_box'];
                    $data['status'] = $_POST['status'];
                    $data['created_date'] = date('Y-m-d');
                    $data['last_modified_date'] = date('Y-m-d');
                    
                    foreach($reg_no_arr as $key => $value){
                        $data['registration_no'] = $value;
                            $Credit_model->update($data, array('id=?' => $credit_id));
                            $_SESSION['message_class'] = 'alert-success';
                    }
                    
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('plan/student');
                    
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Credit_model->getRecords();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    
    

    

    //room Action
    public function roomAction() {

        $this->view->action_name = 'room';
        $this->view->sub_title_name = 'room';
        $this->accessConfig->setAccess('SA_ACAD_ROOM');
        $Credit_model = new Application_Model_Room();
        $Credit_form = new Application_Form_Room();
        //s print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;
       if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                       // $data['department'] = 0;
                         $insertData=array(
                        'room_no'=> $data['room_no'],
                        'seating_capacity'=> $data['seating_capacity'],
                        'seating_capacity_exam'=> $data['seating_capacity_exam'],
                        'department'=> 0,
                        'created_date' =>date('Y-m-d'),
                        'status'=>$data['status']
                    );
                       // echo "<pre>";print_r($data);die;
                         if(!empty($_POST['csrftoken'])) {
                       if($_POST['csrftoken']===$token ){
                       
                        $bool = $Credit_model->getRoom($data['room_no'],$data['department']);
                        if (count($bool) == 0) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Room number Added successfully';
                            $Credit_model->insert($insertData);
                            unset($_SESSION["token"]);
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'Room no "' . $data['room_number'] . ' exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/room');
                          }  else {
                                  $message="Invalid Token";
                                  $_SESSION['message_class'] = 'alert-danger';
                                  $this->_flashMessenger->addMessage($message);
                                  $this->_redirect('plan/room');
                                                  }
                                                      }	
                    }
                }
               
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);

                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                       // $data['last_modified_date'] = date('Y-m-d');
                        //echo '<pre>'; print_r($data); exit;
                        if(!empty($_POST['csrftoken'])) {
                       if($_POST['csrftoken']===$token ){
                         $updateData=array(
                        'room_no'=> $data['room_no'],
                        'seating_capacity'=> $data['seating_capacity'],
                        'seating_capacity_exam'=> $data['seating_capacity_exam'],
                        'department'=> 0,
                        'last_modified_date' =>date('Y-m-d'),
                        'status'=>$data['status']
                    );
                        $Credit_model->update($updateData, array('id=?' => $credit_id));
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/room');
                         }  else {
                                  $message="Invalid Token";
                                  $_SESSION['message_class'] = 'alert-danger';
                                  $this->_flashMessenger->addMessage($message);
                                  $this->_redirect('plan/room');
                                                  }
                                                      }	 
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Credit_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }



//room mapping add by raushan///

     public function roomMappingAction() {

        $this->view->action_name = 'roommapping';
        $this->view->sub_title_name = 'roommapping';
        $this->accessConfig->setAccess('SA_ACAD_ROOMMAP');

        $Credit_model = new Application_Model_RoomMapping();

        $Credit_form = new Application_Form_RoomMapping();
        //s print_r("hello");exit;
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;
if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "mapping":
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                       // echo "<pre>";print_r($data);die;
                        //$data['created_date'] = date('Y-m-d');
                        
                         $insertData=array(
                        'department_id'=> $data['department_id'],
                        'room_id'=>$data['room_id'],
                        'status'=>$data['status'],
                        'created_date'=>date('Y-m-d')
                    );
                       if(!empty($_POST['csrftoken'])) {
                       if($_POST['csrftoken']===$token ){
                        $bool = $Credit_model->getRoom($data['room_id'],$data['department_id']);
                       // echo "<pre>";print_r($bool);die;
                        if (count($bool) == 0) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Room number Added successfully';
                            $Credit_model->insert($insertData);
                            unset($_SESSION["token"]);
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'Room no "' . $data['room_id'] . ' exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/room-mapping');
                         }  else {
                                     $message="Invalid Token";
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $this->_flashMessenger->addMessage($message);
                                     $this->_redirect('plan/room-mapping');
                                                  }
                                                      }	
                    }
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);

                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        $updateData=array(
                        'department_id'=> $data['department_id'],
                        'room_id'=>$data['room_id'],
                        'status'=>$data['status'],
                        'created_date'=>date('Y-m-d')
                    );
                         if(!empty($_POST['csrftoken'])) {
                       if($_POST['csrftoken']===$token ){
                        $data['last_modified_date'] = date('Y-m-d');
                        $Credit_model->update($updateData, array('id=?' => $credit_id));
                        
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/room-mapping');
                         }  else {
                                     $message="Invalid Token";
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $this->_flashMessenger->addMessage($message);
                                     $this->_redirect('plan/room-mapping');
                                                  }
                                                      }	
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/credit');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $room_model = new Application_Model_Room();
                $department_model = new Application_Model_Department();
               $result = $Credit_model->getRecords();

                foreach($result as $key => $value){
                    $result[$key]['room_id'] = $room_model->getRecord($value['room_id'])['room_no'];
                     $result[$key]['department_id'] = $department_model->getRecord($value['department_id'])['department'];
                }
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo '<pre>'; print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //room mapping//


     //Course Category Master
    public function departmentAction() {
        $this->view->action_name = 'department';
        $this->view->sub_title_name = 'department';
      
        $this->accessConfig->setAccess('SA_ACAD_DEPARTMENT');
        $Coursecategory_model = new Application_Model_Department();
        $Coursecategory_form = new Application_Form_Department();
        $academic = new Application_Model_Academic();
        $cc_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Coursecategory_form;
  if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost();

                        $data['created_date'] = date('Y-m-d');
                        //echo '<pre>'; print_r($data); exit;
                       $insertData=array(
                         'degree_id'=> $data['degree_id'],
                         'department_type'=> $data['department_type'],
                         'department'=> $data['department'],
                         'description'=> $data['description'],
                         'status'=>$data['status'],
                         'created_date'=>$data['created_date']
                        );
                       if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                        $bool = $Coursecategory_model->getDepartment1($data['department'],$data['department_type'],$data['degree_id']);
                        if (count($bool) == 0) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Department Added successfully';
                             unset($data['hons_type']);
                            $last_id = $Coursecategory_model->insert($insertData);
                            
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'Department "' . $data['department'] . ' already exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/department');
                }
                else {
                     $message="Invalid Token";
                     $_SESSION['message_class'] = 'alert-danger';
                     $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/department');
                }
                    }
                }
                break;
            case 'edit':
                 
                $result = $Coursecategory_model->getRecord($cc_id);
                $_SESSION['update']['batch_id'] = json_encode($result['batch_id']);

                $Coursecategory_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost();
                        $batch_id = $_POST['batchBox'];
                        
                        $data['last_modified_date'] = date('Y-m-d');
                         $updateData=array(
                            'department'=> $data['department'],
                            'description'=> $data['description'],
                            'department_type'=> $data['department_type'],
                            'degree_id'=> $data['degree_id'],
                            'last_modified_date'=> $data['last_modified_date'],
                            'status'=>$data['status']
                        );
                        //echo '<pre>'; print_r($updateData);exit;
                         if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                            $bool = $Coursecategory_model->getDepartment1($updateData['department'],$updateData['department_type'],$updateData['degree_id']);
                        if (count($bool) > 0) {
                              unset($updateData['department']);
                               unset($updateData['department_type']);
                                unset($updateData['degree_id']);
                        }
                        $Coursecategory_model->update($updateData, array('id=?' => $cc_id));
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/department');
                        }
                else {
                     $message="Invalid Token";
                     
                     $_SESSION['message_class'] = 'alert-danger';
                     $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/department');
                }
                    }
                   
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($cc_id) {
                    $Coursecategory_model->update($data, array('cc_id=?' => $cc_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/coursecategory');
                }
                break;
            default:
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result = $Coursecategory_model->getRecords();
//                
//                $degree_model = new Application_Model_Degree();
//                foreach($result as $key => $value){
//                        $result[$key]['degree_id'] = $degree_model->getRecord($value['degree_id'])['degree'];
//                }
//                $page = $this->_getParam('page', 1);
//                $paginator_data = array(
//                    'page' => $page,
//                    'result' => $result
//                );
//                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    
    public function ajaxGetHonsCourseAction(){
        $this->_helper->layout->disableLayout();
        $re_model = new Application_Model_Department();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $stream = $this->_getParam("stream");
            $result = $re_model->getRecordByStream($stream);
                
            $degree_model = new Application_Model_Degree();
            foreach($result as $key => $value){
                    $result[$key]['degree_id'] = $degree_model->getRecord($value['degree_id'])['degree'];
            }
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);   
        }
    }
    
    public function departmentTypeAction() {
        $this->view->action_name = 'department';
        $this->view->sub_title_name = 'department_type';
      
        $this->accessConfig->setAccess('SA_ACAD_DEPARTMENT');
        $departType_model = new Application_Model_DepartmentType();
        $Coursecategory_form = new Application_Form_DepartmentType();
        $academic = new Application_Model_Academic();
        $cc_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Coursecategory_form;

       if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        
        //die();
        switch ($type) {
            case "add":
//              if (empty($_SESSION['token'])) {
//                    $_SESSION['token'] = bin2hex(random_bytes(32));
//              }
//                      $token = $_SESSION['token'];
//                     // echo $token ;
//                     $this->view->csrftokenval = $token;
                if ($this->getRequest()->isPost()) {

                    $data = $this->getRequest()->getPost();
                  //  echo "<pre>";print_r($data);exit;
//                   echo '<pre>'; print_r($data['csrftoken']);
//                   echo "<br>";
//                   echo $token ;
//                   exit;
                   
                    $insertData=array(
                        'department_type'=> $data['department'],
                        'degree_id'=> $data['degree_id'],
                        //'session_id'=>$data['session_id'],
                        'status'=>$data['status']
                    );
                    
                    if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                          
                    $bool = $departType_model->getDepartmentSession($data['department'],$data['degree_id'],$data['session_id']);
                    if (count($bool) == 0) {
                        $_SESSION['message_class'] = 'alert-success';
                        $message = 'Department Type Added successfully';
                        $last_id = $departType_model->insert($insertData);
                     // ;
                    } else {
                        $_SESSION['message_class'] = 'alert-danger';
                        $message = 'Department "' . $data['department'] . ' already exist\'s"';
                    }
                    $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/department-type');
                  
                }
                else {
                     $message="Invalid Token";
                      $_SESSION['message_class'] = 'alert-danger';
                     $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/department-type');
                }
                    }
                }
                break;
            case 'edit':
                
                $result = $departType_model->getRecord($cc_id);
                $result['department']=$result['department_type'];
               
                $Coursecategory_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                    $updateData=array(
                        'department_type'=> $data['department'],
                        'degree_id'=> $data['degree_id'],
                        'session_id'=>$data['session_id'],
                        'status'=>$data['status']
                    );
                     if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                            $bool = $departType_model->getDepartmentSession($updateData['department_type'],$updateData['degree_id'],$updateData['session_id']);
                    if (count($bool) > 0) {
                   unset($updateData['department_type']);
                   unset($updateData['degree_id']);
                   unset($updateData['session_id']);
                    }
                     $departType_model->update($updateData, array('id=?' => $cc_id));
                    
                    $_SESSION['message_class'] = 'alert-success';
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('plan/department-type');
                        } else {
                     $message="Invalid Token";
                      $_SESSION['message_class'] = 'alert-danger';
                     $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/department-type');
                } 
                        }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($cc_id) {
                    $departType_model->update($data, array('cc_id=?' => $cc_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('plan/department-type');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $departType_model->getRecords();
            //    echo "<prE>";print_r($result);exit;
                
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    //Teacher Department
    public function teacherDeptAction() {
        $this->view->action_name = 'teacher_department';
        $this->view->sub_title_name = 'teacher_dept';
      
        $this->accessConfig->setAccess('SA_ACAD_TCHRDEPT');
        $departType_model = new Application_Model_DepartmentType();
        $department_form = new Application_Form_Department();
        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $department_form;
          if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
         $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost();
                       
                        $insertData= array(
                            'empl_id'=>$data['employee_id'],
                            'dept_id'=>$data['department_list'],
                            'status' =>!$data['status']?0:1,
                        );
                        
                        $bool = $departType_model->getTeacherDepartment($insertData);
                            // echo '<pre>'; print_r($bool);exit;
                        if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                        if (empty($bool)) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Teacher Department Added successfully';
                            $last_id = $departType_model->insertTeacherDept($insertData);
                             unset($_SESSION["token"]);
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = "Employee already assigned to this department.";
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/teacher-dept');
                        }
                        else {
                     $message="Invalid Token";
                      $_SESSION['message_class'] = 'alert-danger';
                     $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/teacher-dept');
                }
                    }
                    
                }
                break;
            case 'edit':
                 
                $result = $departType_model->getEmplDeptRecord($id);
                //echo '<pre>'; print_r($result);
                $populateResult= array(
                    'employee_id'=>$result['empl_id'],
                    'department_list'=>$result['dept_id'],
                    'status'=>$result['status']
                );
                $department_form->populate($populateResult);
                $this->view->result = $populateResult;
                if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost();
                        $updateData= array(
                            'empl_id'=>$data['employee_id'],
                            'dept_id'=>$data['department_list'],
                            'status' =>!$data['status']?0:1,
                        );
                        if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                        $departType_model->updateEmplDept($updateData,$id);
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/teacher-dept');
                        } else {
                        $message="Invalid Token";
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/department-type');
                } 
                        }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($cc_id) {
                    $departType_model->update($data, array('id=?' => $cc_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('plan/department-type');
                }
                break;
            default:
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result = $departType_model->getEmplDeptRecords();
//                //echo '<pre>'; print_r($result);exit;
//                
//                $page = $this->_getParam('page', 1);
//                $paginator_data = array(
//                    'page' => $page,
//                    'result' => $result
//                );
//                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    
    
    public function ajaxGetTeacherByDeptAction(){
        $departType_model = new Application_Model_DepartmentType();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $id = $this->_getParam('id');
            $result = $departType_model->getEmplDeptRecordsByStream($id);
                //echo '<pre>'; print_r($result);exit;
                
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
    
    public function ajaxGetStreamByDegreeAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree = $this->_getParam("degree");
            //print_r($short_code); die;
            $req_model = new Application_Model_DepartmentType();
            $result = $req_model->getRecordByDegreeId($degree);

            //echo '<pre>'; print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['department_type'] . '</option>';
            }
        }die;

    }
    
    
    public function getCourseCategoryAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $Coursecategory_model = new Application_Model_Coursecategory();
            $course_name = $this->_getParam("course_name");
            //print_r($course_name);die;
            $result = $Coursecategory_model->getCourseCategory($course_name);
            print_r($result);
            die;
        }
    }
    
    public function ajaxGetStudentOnDeptAction(){
        $academic = new Application_Model_Academic(); 
        $application = new Application_Model_Application(); 
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department_id = $this->_getParam('department');
            $batch = $this->_getParam('batch');
            $term = $this->_getParam('term');
            $paper = $this->_getParam('paper');
            
            //==============[commented as per workplan5819]
           // $result_batch =  $academic->getRecordsByDepartment($department_id);
            //$result_batch = $this->mergData($result_batch, array('academic_year_id'), count($result_batch));
        
                         $result = $application->getStudentInBatchAndTerm($batch,$term,$paper);
            echo '<option value="">Select</option>';
            foreach ($result as $value) {
                echo '<option value="' . $value['application_id'] . '" >' . $value['stu_name'] . '</option>';
            }
        }die;
    }
    
    
    public function ajaxGetStudentOnDept1Action(){
        $academic = new Application_Model_Academic(); 
        $application = new Application_Model_Application(); 
        $student_model = new Application_Model_Student(); 
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department_id = $this->_getParam('department');
           
            $result_batch =  $academic->getRecordsByDepartment($department_id);
            $result_batch = $this->mergData($result_batch, array('academic_year_id'), count($result_batch));
        
                         $result = $application->getStudentInBatch($result_batch);
                         $already_student_result = $student_model->getRecord($_SESSION['stuDent_id']);
                                     
            echo '<option value="">Select</option>';
            foreach ($result as $value) {
                if($value['application_id'] == $already_student_result['registration_no'])
                echo '<option value="' . $value['application_id'] . '" >' . $value['stu_name'] . '</option>';
            }
        }die;
    }
    
     

    public function ajaxGetFacultyAction() {
        $employee_model = new Application_Model_HRMModel();
        $faculty = new Application_Model_Attendance();
        $term_id = $this->_getParam('term_id');
        $batch_id = $this->_getParam('batch_id');
        $course_id = $this->_getParam('course_id');
        $result = $faculty->getFaculty($term_id, $batch_id, $course_id);

        // print_r($course_cordinatior);exit;
        $faculty_id = explode(',', $result[0]['faculty_id']);
        $visiting_faculty = explode(',', $result[0]['visiting_faculty_id']);
        //======[MERGING BOTH FACULTY ARRAY]=======//
        $faculty_arr = array_merge($faculty_id, $visiting_faculty);
        // $faculty_rr = array_merge($faculty_arr);
        // print_r($result[0]['employee_id']);exit;
        //====={MAKING ARRAY UNIQUE}==============//
        $faculty_arr[count($faculty_arr)] = $result[0]['employee_id'];

        $all_unique_faculty = array_unique($faculty_arr);

        //print_r($all_unique_faculty);exit;
        $i = 0;
        foreach ($all_unique_faculty as $key => $value) {

            if ($value != 'NA') {
                if ($value)
                    $empl_name[$i] = $employee_model->getAllEmployee1($value)[0];
            }
            $i++;
        }
        //======[GETTING NAME OF AL THE EMPLYOEE]=======//
        //   print_r($empl_name);exit;
        //=========[SETTING SELECT BOX]=========//
        //  echo '<option value="'.$_SESSION['admin_login']['admin_login']->empl_id.'">'.$_SESSION['admin_login']['admin_login']->real_name.'</option>';

        if (count($empl_name) > 0) {
            foreach ($empl_name as $key => $value) {
                echo "<option value='" . $value['empl_id'] . "'>" . $value['name'] . "</option>";
            }die;
        }

        die;
    }

//Exam Schedule By KEdar Date:21 Oct. 2009
    public function examscheduleAction() {
        $this->accessConfig->setAccess('SS_ACAD_EXAMSCHEDULE');
        $this->view->action_name = 'examSchedule';
        $this->view->sub_title_name = 'examSchedule';
        
        $examSchedule_model = new Application_Model_ExamScheduleModel();
        $examSchedule_form = new Application_Form_ExamScheduleForm();
        $ccl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $examSchedule_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($examSchedule_form->isValid($this->getRequest()->getPost())) {
                        $data = $examSchedule_form->getValues();
                        //echo "<pre>";print_r($data);die;
                        $exam_date = explode('/',$data['exam_date']);
                        
                        $exam_start_date = $exam_date[2]."/".$exam_date[1]."/".$exam_date[0];
                        
                        $data['course_id'] = $this->getRequest()->getPost('course_id');

                        $origDate = $data['exam_date'];
                        $date = str_replace('/', '-', $origDate );
                         $newDate = date("Y-m-d", strtotime($date));
                         
                         //echo $newDate;

                       
                        $insertData = array(
                            'session_id' => $data['session_id'],
                            'cmn_terms' => $data['cmn_terms'],
                            'degree_id' => $data['degree_id'],
                            'cc_id' =>$data['cc_id'],
                            'ge_id' =>$data['ge_id'],
                            'department_id' => $data['department_id'],
                            'course_id' => $data['course_id'],
                            'employee_id' => $data['employee_id'],
                            'component_paper' => $data['component_paper'],

                            'exam_date' => $newDate,

                            'exam_date' => $data['exam_date'],
                            'exam_date' => $exam_start_date,
                            'time_from' => $data['time_from'],
                            'time_to' => $data['time_to']
                        );
                        
                        //echo"<pre>"; print_r($insertData);die;
                       
                        $examSchedule_model->insert($insertData);
                       
                        $this->_flashMessenger->addMessage($message);
                       
                        $this->_redirect('plan/examschedule');
                    }
                }
                break;
            case 'edit':
                $result = $examSchedule_model->getRecord($ccl_id);
                $start_date = date_create($result['exam_date']);
                $result['exam_date'] = date_format($start_date,"d/m/Y"); 
                //echo "<pre>"; print_r($result);
                $this->view->course_id = $result['course_id'];
               
                $examSchedule_form->populate($result);
                $this->view->result = $result;
                // echo "<pre>"; print_r($result);


                if ($this->getRequest()->isPost()) {
                    if ($examSchedule_form->isValid($this->getRequest()->getPost())) {
                        $data = $examSchedule_form->getValues();
                         //echo"<pre>"; print_r($data);
                        //die();
                        $origDate = $data['exam_date'];
                        $date = str_replace('/', '-', $origDate );
                        $newDate = date("Y-m-d", strtotime($date));
                        $course_id= $this->getRequest()->getPost('course_id');
                        $data['course_id']=$course_id;
                        $updateData = array (
                            'session_id' => $data['session_id'],
                            'cmn_terms' => $data['cmn_terms'],
                            'degree_id' => $data['degree_id'],
                            'cc_id' =>$data['cc_id'],
                            'ge_id' =>$data['ge_id'],
                            'department_id' => $data['department_id'],
                            'course_id' => $data['course_id'],
                            'employee_id' => $data['employee_id'],
                            'component_paper' => $data['component_paper'],
                            'exam_date' => $newDate,
                            'time_from' => $data['time_from'],
                            'time_to' => $data['time_to']
                             
            
                        );
                        
                           //echo"<pre>"; print_r($updateData);
                        //die;
                        $examSchedule_model->update($updateData, array('id=?' => $ccl_id));
                       
                        //echo "<pre>"; print_r($data);die;
                        $examSchedule_model->update($data, array('id=?' => $ccl_id));
                        $course_id= $this->getRequest()->getPost('course_id');
                        $exam_date = explode('/',$data['exam_date']);
                        $exam_end_date= $exam_date[2]."/".$exam_date[1]."/".$exam_date[0];
                        $data['exam_date']= $exam_end_date;
                        $data['course_id']=$course_id;
                        //echo "<pre>"; print_r($data);die;
                        $examSchedule_model->update($data, array('id=?' => $ccl_id));
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/examschedule');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($ccl_id){
                    $Corecourselearning_model->update($data, array('ccl_id=?' => $ccl_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/examschedule');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $examSchedule_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
//Core Course Learning 
    public function exambatchAction() {
        $this->accessConfig->setAccess('SS_ACAD_EXAMBATCH');
        $this->view->action_name = 'ebatch';
        $this->view->sub_title_name = 'ebatch';
        
        $Corecourselearning_model = new Application_Model_ExamBatch();
        $Corecourselearning_form = new Application_Form_ExamBatch();
        $ccl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Corecourselearning_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Corecourselearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $Corecourselearning_form->getValues();
                        $data['created_date'] = date('Y-m-d');

                        $bool = $Corecourselearning_model->getbatch($data['batch'], $data['department']);

                        if (count($bool) == 0) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Batch Added successfully';
                            $Corecourselearning_model->insert($data);
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'Batch no "' . $data['batch'] . ' already exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('plan/exambatch');
                    }
                }
                break;
            case 'edit':
                $result = $Corecourselearning_model->getRecord($ccl_id);

                $this->view->last_result = $last_record_result;
                $Corecourselearning_form->populate($result);
                $this->view->result = $result;



                if ($this->getRequest()->isPost()) {
                    if ($Corecourselearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $Corecourselearning_form->getValues();
                        $data['last_modified_date'] = date('Y-m-d');
                        $Corecourselearning_model->update($data, array('id=?' => $ccl_id));
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/exambatch');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($ccl_id) {
                    $Corecourselearning_model->update($data, array('ccl_id=?' => $ccl_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/corecourselearning');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Corecourselearning_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
//Check already existed exam schedule 
public function ajaxGetDataExistAction(){
   
    $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $examSchedule_model = new Application_Model_ExamScheduleModel();
            $course_id = $this->_getParam("course_id");
            $exam_date = $this->_getParam("exam_date");
            $result= $examSchedule_model->getDataExists($course_id,$exam_date);
            
            echo $result;
        }die;
}
//ajax term name
    public function ajaxGetTermNameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            // print_r($academic_year_id); die;
            // $Corecourselearning_model= new Application_Model_Corecourselearning();
            $TermMaster_model = new Application_Model_TermMaster();

            $result = $TermMaster_model->getCoreCourseTerms($academic_year_id);

            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }die;
    }

    public function ajaxGetBatchStudentsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            // print_r($academic_year_id); die;
            // $Corecourselearning_model= new Application_Model_Corecourselearning();
            $student_model = new Application_Model_StudentPortal();

            $result = $student_model->getstudentsdetails($academic_year_id);

            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['student_id'] . '" >' . $val['students'] . '</option>';
            }
        }die;
    }

    //ajax elective term name
    public function ajaxGetElectiveTermNameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            // print_r($academic_year_id); die;
            // $Corecourselearning_model= new Application_Model_Corecourselearning();
            $TermMaster_model = new Application_Model_TermMaster();

            $result = $TermMaster_model->getCoreCourseTerms($academic_year_id);

            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }die;
    }

    public function ajaxGetTermAcademicAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");

            $term_id = $this->_getParam("term_id");

            $ccl_id = $this->_getParam("ccl_id");

            $TermMaster_model = new Application_Model_TermMaster();


            //if(!empty($ccl_id))
            //{
            // $result= $TermMaster_model->getRemainingTermCredits($academic_year_id,$term_id,$ccl_id);
            //}else{

            $result = $TermMaster_model->getTermCredits($academic_year_id, $term_id);
            //}

            echo json_encode($result);
            die;
        }
    }

    //CORE COURSE LEARNING VIEW

    public function corecourselearningviewAction() {
        $this->view->action_name = 'corecourselearningview';
        $this->view->sub_title_name = 'corecourselearningview';
        $ccl_view_form = new Application_Form_CoreCourseLearningView();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ccl_view_form;
    }

    //CORE COURSE LEARNING VIEW
    //ELECTIVE COURSE LEARNING VIEW

    public function electivecourselearningviewAction() {
        $this->view->action_name = 'electivecourselearningview';
        $this->view->sub_title_name = 'electivecourselearningview';
        $ElectiveCourseLearningView_form = new Application_Form_ElectiveCourseLearningView();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ElectiveCourseLearningView_form;
    }

    //CORE COURSE LEARNING VIEW

    public function gradeallocationviewAction() {
        $this->view->action_name = 'gradealloctionview';
        $this->view->sub_title_name = 'gradealloctionview';
        $ccl_view_form = new Application_Form_GradeAllocationView();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ccl_view_form;
    }

    // PROGRAM DESIGN VIEW AJAX
    public function getGradeAllocationViewAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $department_id = $this->_getParam("department_id");
            $academic_year_id = $this->_getParam("academic_year_id");


            if ($department_id) {

                $EmployeeAllotment_model = new Application_Model_EmployeeAllotment();
                $result = $EmployeeAllotment_model->getEmployeeTerms($academic_year_id, $department_id);
                //	print_r($result);die;
                $this->view->corecourseresult = $result;
            }
        }
    }

    // PROGRAM DESIGN VIEW AJAX
    public function getCoreCourseLearningViewAction() {

        $this->_helper->layout->disableLayout();
        //  $Corecourselearning_model = new Application_Model_Corecourselearning();
        //$result = $Corecourselearning_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $academic_year_id = $this->_getParam("academic_year_id");
            //print_r($academic_year_id);
            $term_id = $this->_getParam("term_id");
            //print_r($term_id);die;

            if ($academic_year_id) {
                $Corecourselearning_model = new Application_Model_Corecourselearning();
                $result = $Corecourselearning_model->getcorecourselearning($academic_year_id, $term_id);
                //print_r($result);die;
                $this->view->corecourseresult = $result;
            }
        }
    }

    //Course Type Master

    public function coursetypeAction() {
        $this->view->action_name = 'coursetype';
        $this->view->sub_title_name = 'coursetype';
        $Coursetype_model = new Application_Model_Coursetype();
        $Coursetype_form = new Application_Form_Coursetype();
        $ct_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Coursetype_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Coursetype_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursetype_form->getValues();
                        //print_r($data);die;
                        $Coursetype_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/coursetype');
                    }
                }
                break;
            case 'edit':
                $result = $Coursetype_model->getRecord($ct_id);
                $Coursetype_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Coursetype_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursetype_form->getValues();

                        $Coursetype_model->update($data, array('ct_id=?' => $ct_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/coursetype');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($ct_id) {
                    $Coursetype_model->update($data, array('ct_id=?' => $ct_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/coursetype');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Coursetype_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Program Master

    public function programmasterAction() {
        $this->view->action_name = 'Program Master';
        $this->view->sub_title_name = 'Program Master';
        $ProgramMaster_model = new Application_Model_ProgramMaster();
        $ProgramMaster_form = new Application_Form_ProgramMaster();
        $pm_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ProgramMaster_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($ProgramMaster_form->isValid($this->getRequest()->getPost())) {
                        $data = $ProgramMaster_form->getValues();
                        //print_r($data);die;
                        $ProgramMaster_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/programmaster');
                    }
                }
                break;
            case 'edit':
                $result = $ProgramMaster_model->getRecord($pm_id);
                $ProgramMaster_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($ProgramMaster_form->isValid($this->getRequest()->getPost())) {
                        $data = $ProgramMaster_form->getValues();

                        $ProgramMaster_model->update($data, array('pm_id=?' => $pm_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/programmaster');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($pm_id) {
                    $ProgramMaster_model->update($data, array('pm_id=?' => $pm_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/programmaster');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $ProgramMaster_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Course Type Same Name Action

    public function getCoursetypeSameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $coursetype_model = new Application_Model_Coursetype();
            $coursetype = $this->_getParam("coursetype");
            $result = $coursetype_model->getcoursetype($coursetype);
            print_r($result);
            die;
        }
    }

    //Academic Master
    
     public function academicYearAction() {
        $this->view->action_name = 'Academic';
        $this->view->sub_title_name = 'Academic';
        $Academic_model = new Application_Model_AcademicYear();

        $Academic_form = new Application_Form_AcademicYear();
        $academic_year_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Academic_form;
       
        $this->view->Academic_form = $Academic_form;


        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                      	
                    $data = $_POST;
                       // print_r($data);die;
                        
                      $insertData = array(
                            'academic_year' => $data['academic_year'],
                            'active_year' => $data['active_year'],
                            'status' => $data['status']
                            
                        );
                            
                            $Academic_model->insert($insertData);
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('plan/academic-year');
                        }
                    
                
                break;
            case 'edit':
                $result = $Academic_model->getRecordById($academic_year_id);
                $Academic_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                   
                       $data = $_POST;
                       // print_r($data);die;
                        
                      $data = array(
                            'academic_year' => $data['academic_year'],
                            'active_year' => $data['active_year'],
                            'status' => $data['status']
                            
                        );

                        $Academic_model->update($data, array('year_id=?' => $academic_year_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('plan/academic-year');
                   
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($academic_year_id) {
                    $Academic_model->update($data, array('academic_year_id=?' => $academic_year_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/academic');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Academic_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    } 
    
    public function academicAction() {
        $this->view->action_name = 'Academic';
        $this->view->sub_title_name = 'Academic';
        $Academic_model = new Application_Model_Academic();

        $Academic_form = new Application_Form_Academic();
        $academic_year_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Academic_form;
        $this->view->increment_id = $Academic_model->getIncrementID();
        $this->view->Academic_form = $Academic_form;


        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Academic_form->isValid($this->getRequest()->getPost())) {
                        $data = $Academic_form->getValues();
                        $academic_year_id = $data['from_date'] . ' ' . '-' . ' ' . $data['to_date'];
                        //	print_r($data);die;
                        if ($academic_year_id) {
                            $Academic_model = new Application_Model_Academic();
                            $academic_data = $Academic_model->getValidateAcademic($academic_year_id);
                            $this->view->academic_data = $academic_data;

                            /* if(!empty($academic_data)){

                              $this->_flashMessenger->addMessage('This Academic Year is Already Existed');
                              $this->_redirect('master/academic');
                              }
                              else{ */
                            $Academic_model->insert($data);
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('master/academic');
                        }
                    }
                }
                break;
            case 'edit':
                $result = $Academic_model->getRecord($academic_year_id);
                $Academic_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Academic_form->isValid($this->getRequest()->getPost())) {
                        $data = $Academic_form->getValues();

                        $Academic_model->update($data, array('academic_year_id=?' => $academic_year_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/academic');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($academic_year_id) {
                    $Academic_model->update($data, array('academic_year_id=?' => $academic_year_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/academic');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Academic_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    // PROGRAM DESIGN MASTER
    public function programdesignAction() {
        $this->view->action_name = 'ProgramDesign';
        $this->view->sub_title_name = 'ProgramDesign';
        $programdesign_model = new Application_Model_ProgramDesign();
        $programdesign_form = new Application_Form_ProgramDesign();
        $pd_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $programdesign_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($programdesign_form->isValid($this->getRequest()->getPost())) {
                        $data = $programdesign_form->getValues();
//print_r($data);die;			
                        $data['academic_year_id'] = $data['short_code'];
                        //print_r($data['academic_year_id']);die;
                        $data['no_days'] = $this->getRequest()->getPost('no_days');
                        $data['no_weeks'] = $this->getRequest()->getPost('no_weeks');
                        $programdesign_model->insert($data);

                        $this->_flashMessenger->addMessage('Program Design Successfully added');

                        $this->_redirect('master/programdesign');
                    }
                }

                break;
            case 'edit':
                $result = $programdesign_model->getRecord($pd_id);
                $programdesign_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($programdesign_form->isValid($this->getRequest()->getPost())) {
                        $data = $programdesign_form->getValues();
                        $data['academic_year_id'] = $data['short_code'];
                        $data['no_days'] = $this->getRequest()->getPost('no_days');
                        $data['no_weeks'] = $this->getRequest()->getPost('no_weeks');

                        $programdesign_model->update($data, array('pd_id=?' => $pd_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/programdesign');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($pd_id) {
                    $programdesign_model->update($data, array('pd_id=?' => $pd_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/programdesign');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $programdesign_model->getRecords();
                //echo '<pre>'; print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    // BATCH MASTER
    public function batchAction() {
        $this->view->action_name = 'batch';
        $this->view->sub_title_name = 'batch';
        $batch_model = new Application_Model_Batch();
        $batch_form = new Application_Form_Batch();
        $batch_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $batch_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($batch_form->isValid($this->getRequest()->getPost())) {
                        $data = $batch_form->getValues();
                        $batch_no = $data['batch_no'];
                        if ($batch_no) {
                            $Batch_model = new Application_Model_Batch();
                            $group_data = $Batch_model->getValidateBatchNo($batch_no);
                            $this->view->group_data = $group_data;
                            if (!empty($group_data)) {
                                $this->_flashMessenger->addMessage('This Batch Number is Already Existed');
                                $this->_redirect('master/batch');
                            } else {
                                $batch_model->insert($data);

                                $this->_flashMessenger->addMessage('Batch Master Successfully added');

                                $this->_redirect('master/batch');
                            }
                        }
                    }
                }

                break;
            case 'edit':
                $result = $batch_model->getRecord($batch_id);
                $batch_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($batch_form->isValid($this->getRequest()->getPost())) {
                        $data = $batch_form->getValues();

                        $batch_model->update($data, array('batch_id=?' => $batch_id));
                        $this->_flashMessenger->addMessage('Batch Master Updated Successfully');
                        $this->_redirect('master/batch');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($batch_id) {
                    $batch_model->update($data, array('batch_id=?' => $batch_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/batch');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $batch_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function gradeAction() {
        $this->view->action_name = 'Masterdata';
        $this->view->sub_title_name = 'Compound';
        //unit id
//	$unit_id = $this->_unit_id;
//	$ErpCompoundMaster_model		 = new Application_Model_ErpCompoundMaster();
        $Grade_model = new Application_Model_Grade();
        $ErpItem_model = new Application_Model_ErpItemsMaster();
//	$this->view->items_name	 = $ErpItem_model->getDropDownLists($unit_id);
        $com_id = $this->_getParam("id");
        $type = $this->_getParam("type");

        switch ($type) {

            case "add":
                $Grade_form = new Application_Form_Grade();
                $this->view->type = $type;
                $this->view->Grade_form = $Grade_form;
                if ($this->getRequest()->isPost()) {
                    if ($Grade_form->isValid($this->getRequest()->getPost())) {
                        //		$data			 = $Grade_form->getValues();
                        //		$data['unit_id'] = $unit_id;
                        //		$last_id		 = $ErpCompoundMaster_model->insert($data);
                        $items = $this->_getParam("items");
                        //		
                        //print_r($items['letter_grade']); die;
                        $data = array(
                            'letter_grade' => $items['letter_grade'],
                            'number_grade' => $items['number_grade'],
                        );
                        //	print_r($data); die;
                        //		foreach ( array_filter($items['grade_id']) as $key=>$grade_id) {
                        //			$data = array(
                        //	'erp_com_id'		 => $last_id,
                        //			'grade_id'	 => $grade_id,
                        //			'letter_grade'	 => $items['letter_grade'][$key]				
                        //	    'number_grade'	 => $items['number_grade'][$key]				
                        //		    );
                        //	print_r($data); die;
                        $Grade_model->insert($data);
                        //		}

                        $this->_flashMessenger->addMessage('Compound Master Added Successfully ');
                        $this->_redirect('master/grade');
                    }
                }

                break;
            /*    case 'edit':
              $ErpCompoundMaster_form		 = new Application_Form_ErpCompoundMaster();
              $this->view->type		 = $type;
              $this->view->ErpCompoundMaster_form	 = $ErpCompoundMaster_form;
              $result				 = $ErpCompoundMaster_model->getRecord($com_id);
              //print_r($result);die;
              $ErpCompoundMaster_form->populate($result);
              $results_view			 = $ErpCompoundItemMaster_model->findall($result['id']);
              //print_r($results_view);die;
              $this->view->results_view	 = $results_view;

              if ($this->getRequest()->isPost()) {
              if ($ErpCompoundMaster_form->isValid($this->getRequest()->getPost())) {
              $data = $ErpCompoundMaster_form->getValues();
              $ErpCompoundMaster_model->update($data, array('id=?' => $com_id));
              $ErpCompoundItemMaster_model->delete(array('erp_com_id=?'=>$com_id));
              //echo $com_id;die;
              $items = $this->_getParam("items");
              foreach ( array_filter($items['item_master_id']) as $key=>$item_master_id) {
              $data = array(
              'erp_com_id'		 => $com_id,
              'item_master_id'	 => $item_master_id,
              'item_quantity'	 => $items['item_quantity'][$key]
              );
              $ErpCompoundItemMaster_model->insert($data);
              }
              $this->_flashMessenger->addMessage('Compound Master  Updated Successfully');
              $this->_redirect('Compound/master');
              }
              }
              break; */
            case 'delete':
                $data['status'] = 2;
                if ($grade_id)
                    $Grade_model->update($data, array('grade_id=?' => $grade_id));
                $this->_flashMessenger->addMessage('Grade Master Deleted Successfully');
                $this->_redirect('master/grade');
                break;

            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Grade_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    // PROGRAM DESIGN SAME NAME 

    public function getProgramDesignSameNameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $programdesign_model = new Application_Model_ProgramDesign();
            $pd = $this->_getParam("pd");
            $result = $programdesign_model->getProgramDesign($pd);
            //print_r($result);die;
        }
    }

// PROGRAM Master SAME NAME 

    public function getProgramMasterSameNameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $ProgramMaster_model = new Application_Model_ProgramMaster();
            $pd = $this->_getParam("pd");
            $result = $ProgramMaster_model->getProgramMaster($pd);
            print_r($result);
            die;
        }
    }

//Based On Short Code need to display Academic Year

    /* public function ajaxGetAcademicAction(){
      $this->_helper->layout->disableLayout();
      if ($this->_request->isPost () && $this->getRequest ()->isXmlHttpRequest ()) {
      $short_id = $this->_getParam("short_id");
      //print_r($short_code); die;
      $Academic_model= new Application_Model_Academic();
      $result= $Academic_model->getAcademic($short_id);


      //echo '<option value="">Select</option>';
      foreach($result as $k => $val){

      echo $val;


      }

      }die;
      } */

    public function ajaxGetAcademicAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $short_id = $this->_getParam("short_id");
            //print_r($short_code); die;
            $Academic_model = new Application_Model_Academic();
            $result = $Academic_model->getAcademic($short_id);

            /* //echo '<option value="">Select</option>';
              foreach($result as $k => $val){
              echo $val['batch_code'];
              } */
            echo json_encode($result);
        }die;
    }

//Based On Short Code need to display Program Name	

    public function ajaxGetProgramNameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $short_id = $this->_getParam("short_id");
            //print_r($short_code); die;
            $ProgramMaster_model = new Application_Model_ProgramMaster();
            $result = $ProgramMaster_model->getProgramName($short_id);


            //echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }die;
    }

    public function ajaxGetProgramNameDisplayAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $short_id = $this->_getParam("short_id");
            //print_r($short_code); die;
            $ProgramMaster_model = new Application_Model_ProgramMaster();
            $result = $ProgramMaster_model->getProgramNameDisplay($short_id);


            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }die;
    }

    //PROGRAM DESIGN VIEW

    public function programdesignviewAction() {
        $this->view->action_name = 'ProgramDesign';
        $this->view->sub_title_name = 'ProgramDesignView';
        $pd_view_form = new Application_Form_ProgramDesignView();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $pd_view_form;
    }

    // PROGRAM DESIGN VIEW AJAX
    public function getProgramViewAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $pd_id = $this->_getParam("pm_name");
            $short_id = $this->_getParam("short_id");

            if ($pd_id) {

                $programdesign_model = new Application_Model_ProgramDesign();
                $result = $programdesign_model->getProgram($short_id, $pd_id);
                //print_r($result);die;
                $this->view->academicresult = $result;
            }
        }
    }

    //Term Master View	

    public function termmasterviewAction() {
        $this->view->action_name = 'Termmasterview';
        $this->view->sub_title_name = 'Termmasterview';
        $TermMasterView_form = new Application_Form_TermMasterView();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $TermMasterView_form;
    }

    //Term Master View
    public function getTermViewAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $term_id = $this->_getParam("academicid");



            if ($term_id) {

                $TermMasterView_model = new Application_Model_TermMasterView();
                $result = $TermMasterView_model->getprogram($term_id);
                //print_r($result);die;
                $this->view->academicresult = $result;
            }
        }
    }

    //PROGRAM SAME NAME 
    public function getProgramAction() {

        $pd_id = $this->_getParam("id");

        $type = $this->_getParam("type");
        if ($type) {

            $programdesign_model = new Application_Model_ProgramDesign();
            $result = $programdesign_model->getRecord($pd_id);
            $this->view->result = $result;

            $htmlcontent = $this->view->render('Master/ajax-get-employee-print.phtml');
            //print_r($htmlcontent); die;

            $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, "Employee Details");
        }
    }

//Elective Course Learning Master

    public function electivecourselearningAction() {
        $this->view->action_name = 'electivecourselearning';
        $this->view->sub_title_name = 'electivecourselearning';
        $electivecourselearning_model = new Application_Model_ElectiveCourseLearning();
        $electivecourselearning_form = new Application_Form_ElectiveCourseLearning();
        $ecrl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $electivecourselearning_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($electivecourselearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $electivecourselearning_form->getValues();
                        $electivecourselearning_model->insert($data);

                        $this->_flashMessenger->addMessage('Details Successfully added');

                        $this->_redirect('master/electivecourselearning');
                    }
                }


                break;
            case 'edit':
                $result = $electivecourselearning_model->getRecord($ecrl_id);
                $electivecourselearning_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($electivecourselearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $electivecourselearning_form->getValues();

                        $electivecourselearning_model->update($data, array('ecrl_id=?' => $ecrl_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/electivecourselearning');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($ecrl_id) {
                    $electivecourselearning_model->update($data, array('ecrl_id=?' => $ecrl_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/electivecourselearning');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $electivecourselearning_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //COURSE Master	
    public function courseAction() {
        $this->view->action_name = 'course';
        $this->view->sub_title_name = 'course';
        $course_model = new Application_Model_Course();
        $course_form = new Application_Form_Course();
        $course_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $course_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($course_form->isValid($this->getRequest()->getPost())) {
                        $data = $course_form->getValues();
                        $course_model->insert($data);
                        //echo '<pre>';  print_r($data); die;
                        $this->_flashMessenger->addMessage('Course Successfully added');

                        $this->_redirect('master/course');
                    }
                }


                break;
            case 'edit':
                $result = $course_model->getRecord($course_id);
                $course_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($course_form->isValid($this->getRequest()->getPost())) {
                        $data = $course_form->getValues();

                        $course_model->update($data, array('course_id=?' => $course_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/course');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($course_id) {
                    $course_model->update($data, array('course_id=?' => $course_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/course');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $course_model->getRecords();
                //echo '<pre>'; print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Course Name same 


    public function getCourseCodeSameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $coursename_model = new Application_Model_Course();
            $course_code = $this->_getParam("course_code");
            $result = $coursename_model->getCourseCode($course_code);
            print_r($result);
            die;
        }
    }

    //Experiential Learning Components Master	
    public function experientiallearningcomponentsAction() {
        $this->view->action_name = 'experientiallearningcomponents';
        $this->view->sub_title_name = 'experientiallearningcomponents';
        $ExperientialLearningComponents_model = new Application_Model_ExperientialLearningComponents();
        $ExperientialLearningComponents_form = new Application_Form_ExperientialLearningComponents();
        $elc_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ExperientialLearningComponents_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($ExperientialLearningComponents_form->isValid($this->getRequest()->getPost())) {
                        $data = $ExperientialLearningComponents_form->getValues();

                        $ExperientialLearningComponents_model->insert($data);

                        $this->_flashMessenger->addMessage('Details Successfully added');

                        $this->_redirect('master/experientiallearningcomponents');
                    }
                }


                break;
            case 'edit':
                $result = $ExperientialLearningComponents_model->getRecord($elc_id);
                $ExperientialLearningComponents_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($ExperientialLearningComponents_form->isValid($this->getRequest()->getPost())) {
                        $data = $ExperientialLearningComponents_form->getValues();

                        $ExperientialLearningComponents_model->update($data, array('elc_id=?' => $elc_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/experientiallearningcomponents');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($elc_id) {
                    $ExperientialLearningComponents_model->update($data, array('elc_id=?' => $elc_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/experientiallearningcomponents');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $ExperientialLearningComponents_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //same name validation
    public function getComponentSameAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $ExperientialLearningComponents_model = new Application_Model_ExperientialLearningComponents();
            $componentname = $this->_getParam("componentname");
            $result = $ExperientialLearningComponents_model->getcomponenetname($componentname);
            //print_r($result);die;
        }
    }

    //Experiential Learning Master	
    public function experientiallearningAction() {
        $this->view->action_name = 'experientiallearning';
        $this->view->sub_title_name = 'experientiallearning';
        $ExperientialLearning_model = new Application_Model_ExperientialLearning();
        $ExperientialLearning_form = new Application_Form_ExperientialLearning();
        $el_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ExperientialLearning_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($ExperientialLearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $ExperientialLearning_form->getValues();
                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
//echo '<pre>';  print_r($data); die;						
                        $ExperientialLearning_model->insert($data);

                        $this->_flashMessenger->addMessage('Details Successfully added');

                        $this->_redirect('master/experientiallearning');
                    }
                }


                break;
            case 'edit':
                $result = $ExperientialLearning_model->getRecord($el_id);
                $ExperientialLearning_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($ExperientialLearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $ExperientialLearning_form->getValues();
                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];

                        $ExperientialLearning_model->update($data, array('el_id=?' => $el_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/experientiallearning');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($el_id) {
                    $ExperientialLearning_model->update($data, array('el_id=?' => $el_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/experientiallearning');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $ExperientialLearning_model->getRecords();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Experiential Learning View
    public function experientiallearningdesignviewAction() {
        $this->view->action_name = 'experientiallearningview';
        $this->view->sub_title_name = 'experientiallearningview';
        $el_view_form = new Application_Form_ExperientialLearningView();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $el_view_form;
    }

    //Experiential Learning View Ajax
    public function ajaxExperientialViewAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $el_id = $this->_getParam("academicid");



            if ($el_id) {

                $ExperientialLearning_model = new Application_Model_ExperientialLearning();
                $result = $ExperientialLearning_model->getprogram($el_id);
                //print_r($result);die;
                $this->view->academicresult = $result;
            }
        }
    }

    //Evaluation Components
    public function evaluationcomponentsAction() {
        $this->view->action_name = 'evaluationcomponents';
        $this->view->sub_title_name = 'evaluationcomponents';
        $EvaluationComponents_model = new Application_Model_EvaluationComponents();
        $EvaluationComponentsItems_model = new Application_Model_EvaluationComponentsItems();
        $EvaluationComponents_form = new Application_Form_EvaluationComponents();
        $ec_id = $this->_getParam("id");
        //print_r($ec_id);die;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $EvaluationComponents_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($EvaluationComponents_form->isValid($this->getRequest()->getPost())) {
                        $data = $EvaluationComponents_form->getValues();

                        $last_insert_id = $EvaluationComponents_model->insert($data);



                        $courses = $this->getRequest()->getPost('courses'); //Get AddMore Fields From View
                        echo '<pre>';
                        print_r($courses);
                        foreach (array_filter($courses['eci_name']) as $key => $eci_name) {
                            //print_r($eci_name); die;
                            $employee_data = array("ec_id" => $last_insert_id,
                                "eci_name" => $eci_name, //Employee Field Name
                            );
                            //print_r($employee_data); die;
                            $EvaluationComponentsItems_model->insert($employee_data); //insert data into sub model table	
                        }

                        $this->_flashMessenger->addMessage('Details Successfully added');

                        $this->_redirect('master/evaluationcomponents');
                    }
                }


                break;
            case 'edit':
                $result = $EvaluationComponents_model->getRecord($ec_id);
                $item_result = $EvaluationComponentsItems_model->getRecords($ec_id);
                //print_r($item_result);die;
                $this->view->item_result = $item_result;
                $EvaluationComponents_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($EvaluationComponents_form->isValid($this->getRequest()->getPost())) {
                        $data = $EvaluationComponents_form->getValues();

                        $EvaluationComponents_model->update($data, array('ec_id=?' => $ec_id));

                        $courses = $this->getRequest()->getPost('courses');
                        //print_r($courses);die;
                        $EvaluationComponentsItems_model->trashItems($ec_id); //Delete Fields in Company						

                        foreach (array_filter($courses['eci_name']) as $key => $eci_name) {

                            $employee_data = array("ec_id" => $ec_id,
                                "eci_name" => $eci_name, //employee Field Name
                            );
                            //print_r($employee_data);die;
                            $EvaluationComponentsItems_model->insert($employee_data);
                        }


                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/evaluationcomponents');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($ec_id) {
                    $EvaluationComponents_model->update($data, array('ec_id=?' => $ec_id));
                    $EvaluationComponentsItems_model->update($data, array('eci_id=?' => $eci_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/evaluationcomponents');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $EvaluationComponents_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Empolyee Allotment
    public function employeeallotmentAction() {
        $this->view->action_name = 'employeeallotment';
        $this->view->sub_title_name = 'employeeallotment';
        $EmployeeAllotment_model = new Application_Model_EmployeeAllotment();
        $EmployeeAllocationItems_model = new Application_Model_EmployeeAllocationItems();
        $EmployeeAllotment_form = new Application_Form_EmployeeAllotment();

        $ea_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $EmployeeAllotment_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($EmployeeAllotment_form->isValid($this->getRequest()->getPost())) {
                        $data = $EmployeeAllotment_form->getValues();

                        $last_insert_id = $EmployeeAllotment_model->insert($data);

                        $employee_allocation = $this->getRequest()->getPost('employee');
                        //print_r($employee_allocation);die;
                        foreach ($employee_allocation['term_id'] as $key => $term_id) {
                            $item_data['ea_id'] = $last_insert_id;
                            $item_data['term_id'] = $term_id;
                            $item_data['cc_id'] = $employee_allocation['cc_id'][$key];
                            $item_data['course_id'] = $employee_allocation['course_id'][$key];
                            $item_data['credit_id'] = $employee_allocation['credit_id'][$key];
                            $item_data['department_id'] = $employee_allocation['department_id'][$key];
                            $item_data['employee_id'] = $employee_allocation['employee_id'][$key];
                            $course_id = $item_data['course_id'];
                            $emp_ids = trim(implode(',', $employee_allocation['faculty_id'][$course_id]), ',');
                            $emp_ids1 = trim(implode(',', $employee_allocation['visiting_faculty_id'][$course_id]), ',');
                            $item_data['faculty_id'] = $emp_ids;
                            $item_data['visiting_faculty_id'] = $emp_ids1;
                            $item_data['remarks'] = $employee_allocation['remarks'][$key];

                            //print_r($item_data['employee_id']);die;
                            $EmployeeAllocationItems_model->insert($item_data);

                            //print_r($item_data);die;
                        }

                        $this->_flashMessenger->addMessage('Employee Successfully added');

                        $this->_redirect('master/employeeallotment');
                    }
                }


                break;
            case 'edit':
                $result = $EmployeeAllotment_model->getRecord($ea_id);
                $this->view->emp_allotment_id = $ea_id;
                $item_result = $EmployeeAllocationItems_model->getRecords($ea_id);
                //print_r($item_result);die;
                $this->view->item_result = $item_result;
                $EmployeeAllotment_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($EmployeeAllotment_form->isValid($this->getRequest()->getPost())) {
                        $emp_allotment_ids = $this->getRequest()->getPost('ead_id');
                        //print_r($emp_allotment_ids);exit;
                        //$data = $EmployeeAllotment_form->getValues();
                        //$EmployeeAllotment_model->update($data, array('ea_id=?' => $ea_id));
                        //$ea_id = $EmployeeAllotment_model->insert($data);
                        $employee_allocation = $this->getRequest()->getPost('employee');
                        //print_r($employee_allocation);exit;
                        //print_r($employee_allocation);die;
                        $EmployeeAllocationItems_model->trashItems($ea_id);
                        foreach ($emp_allotment_ids as $key => $ead_id) {
                            $item_data['ea_id'] = $ea_id;
                            $item_data['term_id'] = $employee_allocation['term_id'][$key];
                            $item_data['cc_id'] = $employee_allocation['cc_id'][$key];
                            $item_data['course_id'] = $employee_allocation['course_id'][$key];
                            $item_data['credit_id'] = $employee_allocation['credit_id'][$key];
                            $item_data['department_id'] = $employee_allocation['department_id'][$key];
                            $item_data['employee_id'] = $employee_allocation['employee_id'][$key];
                            $course_id = $item_data['course_id'];
                            $emp_ids = trim(implode(',', $employee_allocation['faculty_id'][$course_id]), ',');
                            $emp_ids1 = trim(implode(',', $employee_allocation['visiting_faculty_id'][$course_id]), ',');

                            $item_data['faculty_id'] = $emp_ids;
                            $item_data['visiting_faculty_id'] = $emp_ids1;
                            $item_data['remarks'] = $employee_allocation['remarks'][$key];
                            //print_r($item_data['employee_id']);die;
                            //print_r($item_data);
                            $error = $EmployeeAllocationItems_model->insert($item_data);

                            //print_r($item_data);die;
                        }



                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/employeeallotment');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($ea_id) {
                    $EmployeeAllotment_model->update($data, array('ea_id=?' => $ea_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/employeeallotment');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $EmployeeAllotment_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function ajaxStudentListViewAction() {
        $student_list = new Application_Model_Attendance();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            $batch_id = $this->_getParam('batch_id');
            $course_id = $this->_getParam("course_id");
            $date_val = $this->_getParam("date_val");
            // print_r($date_val);exit;
            //$date_str = date("d-m-Y",strtotime($date_val));
            $attendance_details = $student_list->getAttendanceResult($term_id, $batch_id, $course_id, $date_val);

            $no_of_classes = $student_list->connectBatchSheduler($term_id, $batch_id, $course_id, $date_val);
            $result = $student_list->getStudentList($term_id, $batch_id, $course_id);
            //print_r($result);exit;
            $result[count($result) - 1]['class_no'] = $no_of_classes;
            $result[count($result) - 1]['course_id'] = $course_id;
            $result[count($result) - 1]['attendance_details'] = $attendance_details;
            $this->view->result = $result;
        }
    }

    public function classalotmentAction() {
        $this->view->action_name = 'Class Allotment';
        $this->view->sub_title_name = 'Class Allotment';
        $atendence_saver_model = new Application_Model_Attendance();
        $attendance_form = new Application_Form_Attendance();
        $employee_model = new Application_Model_HRMModel();
        $mobile_message = new Application_Model_Mobile();
        $classalotment = new Application_Model_Classalotment();
        $termDetails = new Application_Model_TermMaster();
        $batchDetailc = new Application_Model_Academic();
        $course_code = new Application_Model_Course();
        $ec_id = $this->_getParam("id");
        //print_r($ec_id);die;


        $type = $this->_getParam("type");
        $this->view->type = $type;
        // $this->view->result = "hello";
        $this->view->form = $attendance_form;
        switch ($type) {
            case "add":

                if ($this->getRequest()->isPost()) {
                    if ($attendance_form->isValid($this->getRequest()->getPost())) {
                        $parrents_number = array('mother_no', 'father_no');

                        $batch_id = $this->getRequest()->getPost('academic_year_id');
                        $term_id = $this->getRequest()->getPost('term_id');
                        $date = $this->getRequest()->getPost('date');
                        $course_id = $this->getRequest()->getPost('course_id');
                        $class_no = $this->getRequest()->getPost('class_no');
                        $faculty = $this->getRequest()->getPost('faculty');

                        $data = array(
                            'class_no' => $class_no,
                            'term_id' => $term_id,
                            'batch_id' => $batch_id,
                            'course_id' => $course_id,
                            'date' => date('Y-m-d', strtotime($date)),
                            'faculty_id' => $faculty
                        );
                        $bool = $this->check1($date, $course_id, $batch_id, $class_no, $term_id);
                        if (count($bool) != 0) {
                            $empl_name = $employee_model->getAllEmployee1($bool[0]['faculty_id'])[0]['name'];
                            if ($bool[0]['faculty_id'] == $_SESSION['admin_login']['admin_login']->empl_id) {
                                $this->_flashMessenger->addMessage("You are already Registered !");
                            } else {
                                $this->_flashMessenger->addMessage("$empl_name is already Registered !");
                            }
                        } else {
                            $classalotment->insert($data);
                            $this->_flashMessenger->addMessage('Class has Alotted Successfully !');
                        }
                    }
                    $this->_redirect('master/classalotment');
                }

                break;
            case 'edit':
                $result = $classalotment->getRecordById($ec_id);
                $result['academic_year_id'] = $result[0]['batch_id'];
                $result['term_id'] = $result[0]['term_id'];
                $_SESSION['classalotment']['course_id'] = $result[0]['course_id'];
                $_SESSION['classalotment']['date'] = date('d-m-Y', strtotime($result[0]['date']));
                $_SESSION['classalotment']['faculty'] = $result[0]['faculty_id'];
                $_SESSION['classalotment']['class_no'] = $result[0]['class_no'];

                $academic_year_id = $result['academic_year_id'];
                $TermMaster_model = new Application_Model_TermMaster();
                $term_result = $TermMaster_model->getTermDropDownList($academic_year_id);

                $attendance_form->getElement('term_id')->setAttrib('style', array('display:initial'));
                $employee_id = $attendance_form->createElement('select', 'term_id');
                $employee_id->setAttrib('class', array('form-control', 'chosen-select'));
                $employee_id->removeDecorator("htmlTag");
                $employee_id->addMultiOptions(array('' => 'Select'));
                $employee_id->addMultiOptions($term_result);
                $employee_id->setRegisterInArrayValidator(false);
                $attendance_form->addElement($employee_id);


                $attendance_form->populate($result);
                $this->view->result = $result;

                if ($this->getRequest()->isPost()) {
                    if ($this->getRequest()->getPost()) {
                        $batch_id = $this->getRequest()->getPost('academic_year_id');
                        $term_id = $this->getRequest()->getPost('term_id');
                        $date = $this->getRequest()->getPost('date');
                        $course_id = $this->getRequest()->getPost('course_id');
                        $class_no = $this->getRequest()->getPost('class_no');
                        $faculty = $this->getRequest()->getPost('faculty');
                        $data = array(
                            'class_no' => $class_no,
                            'term_id' => $term_id,
                            'batch_id' => $batch_id,
                            'course_id' => $course_id,
                            'date' => date('Y-m-d', strtotime($date)),
                            'faculty_id' => $faculty
                        );

                        $classalotment->update($data, array('id=?' => $ec_id));


                        $this->_flashMessenger->addMessage('Class Updated Successfully');
                        $this->_redirect('master/classalotment');
                    }
                }



                //print_r($result);exit;
                //print_r($result);exit;
                //  if ($this->getRequest()->isPost()){
                //  if ($attendance_form->isValid($this->getRequest()->getPost())) {
                //  $data = $EvaluationComponents_form->getValues();
                // $this->_flashMessenger->addMessage('Evaluation Components Updated Successfully');
                //$this->_redirect('evaluation-components/index');

                break;
            case 'delete':
                $data['status'] = 2;
                if ($ec_id) {
                    $atendence_saver_model->update($data, array('ec_id=?' => $ec_id));
                    $EvaluationComponentsItems_model->update($data, array('eci_id=?' => $eci_id));
                    $this->_flashMessenger->addMessage('Evaluation Component Deleted Successfully');
                    $this->_redirect('evaluation-components/index');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;


                //print_r($this->login_storage);exit;
                //Show only components for the logged in faculty
                $role_id = $this->login_storage->role_id;
                $empl_id = $this->login_storage->empl_id;
                $result = $classalotment->getRecords();

                $i = 0;
                foreach ($result as $key => $value) {
                    // print_r($value['faculty_id']);exit;
                    $empl_name = $employee_model->getAllEmployee1($value['faculty_id']);
                    $result[$i]['faculty_id'] = $empl_name[0]['name'];
                    $result[$i]['term_id'] = $termDetails->getTermName($value['term_id'])['term_name'];
                    $result[$i]['batch_id'] = $batchDetailc->getBatchDetails($value['batch_id'])[0]['short_code'];
                    $result[$i]['course_id'] = $course_code->getCourseCodeById($value['course_id'])['course_code'];

                    $i++;
                }
                // print_r($result);exit;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );

                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }



    //Term Master
    public function termmasterAction() {
        $this->view->action_name = 'Term';
        $this->view->sub_title_name = 'Termmaster';
        $Term_model = new Application_Model_TermMaster();
        $Term_form = new Application_Form_TermMaster();
        //$Termdate_model = new Application_Model_Termdate();
        $term_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Term_form;

        switch ($type) {
            case "add":

                $this->view->type = $type;
                $this->view->form = $Term_form;

                if ($this->getRequest()->isPost()) {
                    //echo '<pre>';print_r($_POST);die;
                    if ($Term_form->isValid($this->getRequest()->getPost())) {
                        $data = $Term_form->getValues();
                        $term_name = $data['term_name'];
                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
                        //	print_r($data); die; 
                        if ($term_name) {
                            $Term_model = new Application_Model_TermMaster();
                            $term_data = $Term_model->getValidateTermName($term_name);
                            $this->view->term_data = $term_data;

                            $electives_credits = $this->getRequest()->getPost('electives_credits');
                            if (!empty($electives_credits)) {
                                $data['electives_credits'] = $electives_credits;
                            } else {
                                $data['electives_credits'] = 0;
                            }
                            /* if(!empty($term_data)){

                              $this->_flashMessenger->addMessage('This Term Name is Already Existed');
                              $this->_redirect('master/termmaster');
                              } */

                            //else{

                            $Term_model->insert($data);

                            $this->_flashMessenger->addMessage(' Added Successfully ');
                            $this->_redirect('master/termmaster');
                            //}
                        }
                    }
                }

                break;
            case "edit":

                $this->view->type = $type;
                $this->view->form = $Term_form;
                //echo "hi";die;
                $result = $Term_model->getRecord($term_id);
                //print_r($result);die;

                $this->view->result = $result;
                $Term_form->populate($result);


                if ($this->getRequest()->isPost()) {
                    if ($Term_form->isValid($this->getRequest()->getPost())) {
                        //echo 'dsd'; die;
                        $data = $Term_form->getValues();
                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
                        //print_r($data);die;
                        $data['electives_credits'] = $this->getRequest()->getPost('electives_credits');
                        //print_r($data['electives_credits']); die;
                        $Term_model->update($data, array('term_id=?' => $term_id));
                        $this->_flashMessenger->addMessage(' Updated Successfully');
                        $this->_redirect('master/termmaster');
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($term_id) {
                    $Term_model->update($data, array('term_id=?' => $term_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/termmaster');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Term_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function getTermAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_model = new Application_Model_TermMaster();
            $term = $this->_getParam("term");
            $result = $term_model->getTerm($term);
            //	print_r($result);die;
        }
    }
    
    //attendance sheet 
    public function attendancesheetAction(){
         $this->view->action_name = 'attendancesheet';
         $this->view->sub_title_name = 'attendancesheet';
         $this->accessConfig->setAccess('SA_ACAD_GE');
         $examAttendance_form = new Application_Form_ExamAttendance();
         $this->view->form = $examAttendance_form;
           $participant_model = new Application_Model_ParticipantsLogin();
        $StudentPortal_model = new Application_Model_StudentPortal();
        $studentFeeDetails = new Application_Model_FeeDetails();
        $student_model = new Application_Model_StudentPortal();
        $alumni_model = new Application_Model_Alumni();
        $fee_details = new Application_Model_FeeDetails();
        $term_master = new Application_Model_TermMaster();
        $academic_model = new Application_Model_Academic();
        $Elective_model = new Application_Model_ElectiveSelection();
       
        $course_credit_master = new Application_Model_Corecourselearning();
   
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
         $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecords();
                
                //echo "<pre>";print_r($result);exit;
                
                foreach($result as $key => $value){
                    
                    $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']); 
                   $term_id =  $term_master->getAcademicMinTerms($value['academic_id']); 
                    
                   
                     $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);
                      
                     $elective_res =   $ElectiveItems_model->getItemsRecords($elective_insert_id);
                     $ge_model = new Application_Model_Ge();
                     $course = new Application_Model_Course();
                     $cor_dept = new Application_Model_Academic();
                     $dept_model = new Application_Model_Department();
                      
                     $dept = $cor_dept->getRecord($value['academic_id']);
            
                    // echo "<pre>";print_r($dept['department']);exit;
                     
                     $result[$key]['dept_name'] = $dept_model->getRecord($dept['department'])['department'];
                        
                        
                     $result[$key]['ge_name'] = $ge_model->getRecord($elective_res[0]['ge_id'])['general_elective_name'];
                    
                     $result[$key]['aecc_name'] = $course->getRecord($elective_res[0]['aecc'])['course_name'];
                                               // echo "<pre>";print_r($result);exit;
                   // echo "<pre>";print_r($result);exit;
                
                    
                }
                
                $page = $this->_getParam('page', 1);

                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
    }
    
          
    //Credit Master
    public function creditmasterAction() {
        $this->view->action_name = 'Credit';
        $this->view->sub_title_name = 'Creditmaster';
        $Credit_model = new Application_Model_CreditMaster();
        $Credit_form = new Application_Form_CreditMaster();
        //$Termdate_model = new Application_Model_Termdate();
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":

                $this->view->type = $type;
                $this->view->form = $Credit_form;

                if ($this->getRequest()->isPost()) {
                    //echo '<pre>';print_r($_POST);die;
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        $credit_value = $data['credit_value'];
                        if ($credit_value) {
                            $Credit_model = new Application_Model_CreditMaster();
                            $term_data = $Credit_model->getValidateCreditValue($credit_value);
                            $this->view->term_data = $term_data;

                            if (!empty($term_data)) {

                                $this->_flashMessenger->addMessage('This Credit value is Already Existed');
                                $this->_redirect('master/creditmaster');
                            } else {

                                $Credit_model->insert($data);
                                //print_r($data); die; 
                                $this->_flashMessenger->addMessage(' Added Successfully ');
                                $this->_redirect('master/creditmaster');
                            }
                        }
                    }
                }

                break;
            case "edit":

                $this->view->type = $type;
                $this->view->form = $Credit_form;
                //echo "hi";die;
                $result = $Credit_model->getRecord($credit_id);
                //print_r($result);die;

                $this->view->result = $result;
                $Credit_form->populate($result);
                //$data['credit_value'] = $result['credit_value'];

                $Credit_form->getElement("credit_value")
                        ->setAttrib('readonly', 'readonly')
                        ->setAttrib('class', array('form-control'))
                        ->setValue($result['credit_value']);
                //->setMultiOptions($data);
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        //echo 'dsd'; die;
                        $data = $Credit_form->getValues();



                        //print_r($data);die;
                        $Credit_model->update($data, array('credit_id=?' => $credit_id));
                        $this->_flashMessenger->addMessage(' Updated Successfully');
                        $this->_redirect('master/creditmaster');
                    }
                }

                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/creditmaster');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Credit_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Fee Head Master
    public function feeheadAction() {
        $this->view->action_name = 'feehead';
        $this->view->sub_title_name = 'Feehead';
        $FeeHead_model = new Application_Model_FeeHead();
        $FeeHead_form = new Application_Form_FeeHead();
        $feehead_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $FeeHead_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($FeeHead_form->isValid($this->getRequest()->getPost())) {
                        $data = $FeeHead_form->getValues();
                        //print_r($data);die;
                        $FeeHead_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/feehead');
                    }
                }
                break;
            case 'edit':
                $result = $FeeHead_model->getRecord($feehead_id);
                $FeeHead_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($FeeHead_form->isValid($this->getRequest()->getPost())) {
                        $data = $FeeHead_form->getValues();

                        $FeeHead_model->update($data, array('feehead_id=?' => $feehead_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/feehead');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($feehead_id) {
                    $FeeHead_model->update($data, array('feehead_id=?' => $feehead_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/feehead');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $FeeHead_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

//Reference Grade Master
    public function referenceGradeAction() {
        $this->view->action_name = 'Reference Grade Master';
        $this->view->sub_title_name = 'Reference Grade Master';
        $ReferenceGradeMaster_model = new Application_Model_ReferenceGradeMaster();
        $ReferenceGradeMaster_form = new Application_Form_ReferenceGradeMaster();
        $ReferenceGradeMasterItems_model = new Application_Model_ReferenceGradeMasterItems();
        $reference_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ReferenceGradeMaster_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($ReferenceGradeMaster_form->isValid($this->getRequest()->getPost())) {
                        $data = $ReferenceGradeMaster_form->getValues();
                        $last_insert_id = $ReferenceGradeMaster_model->insert($data);
                        $grade = $this->getRequest()->getPost('grade');

                        foreach (array_filter($grade['letter_grade']) as $k => $letter_grade) {
                            $grade_data['reference_id'] = $last_insert_id;
                            $grade_data['letter_grade'] = $letter_grade;
                            $grade_data['number_grade'] = $grade['number_grade'][$k];

                            $ReferenceGradeMasterItems_model->insert($grade_data);
                        }
                        $this->_flashMessenger->addMessage('Grades Added Successfully ');
                        $this->_redirect('master/reference-grade');
                    }
                }
                break;
            case 'edit':
                $result = $ReferenceGradeMaster_model->getRecord($reference_id);
                $ReferenceGradeMaster_form->populate($result);
                $this->view->result = $result;
                $item_result = $ReferenceGradeMasterItems_model->getRecords($reference_id);
                $this->view->item_result = $item_result;
                if ($this->getRequest()->isPost()) {
                    if ($ReferenceGradeMaster_form->isValid($this->getRequest()->getPost())) {
                        $data = $ReferenceGradeMaster_form->getValues();

                        $ReferenceGradeMaster_model->update($data, array('reference_id=?' => $reference_id));
                        $grade = $this->getRequest()->getPost('grade');
                        $ReferenceGradeMasterItems_model->trashItems($reference_id);
                        foreach (array_filter($grade['letter_grade']) as $k => $letter_grade) {
                            $grade_data['reference_id'] = $reference_id;
                            $grade_data['letter_grade'] = $letter_grade;
                            $grade_data['number_grade'] = $grade['number_grade'][$k];
                            $ReferenceGradeMasterItems_model->insert($grade_data);
                        }
                        $this->_flashMessenger->addMessage('Grades Updated Successfully');
                        $this->_redirect('master/reference-grade');
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($reference_id) {
                    $ReferenceGradeMaster_model->update($data, array('reference_id=?' => $reference_id));
                    $this->_flashMessenger->addMessage('Grades Deleted Successfully');
                    $this->_redirect('master/reference-grade');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $ReferenceGradeMaster_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

   
    //To maintain Exam Dates and result publish date Interface..!
    public function examDatesAction() {
        $this->view->action_name = 'exam_dates';
        $this->view->sub_title_name = 'exam_dates';
      
        $this->accessConfig->setAccess('SA_ACAD_EXAMDATE');
        $Req_model = new Application_Model_ExamDateModel();
        $Req_form = new Application_Form_ExamDateForm();
        $cc_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $update_id = $this->_getParam("update_id");
        $this->view->type = $type;
        $this->view->form = $Req_form;
if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {

                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                 
                   
                    $multiAcad=$data['academic_id'];
                    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    }else{
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }
                    $ExamdateFormat= explode('/', $data['exam_date']);
                    $examDate=$ExamdateFormat[2].'-'.$ExamdateFormat[1].'-'.$ExamdateFormat[0];
                    
                    $EndFormat= explode('/', $data['end_date']);
                    $endDate=$EndFormat[2].'-'.$EndFormat[1].'-'.$EndFormat[0];
                    
                    $PublishdateFormat= explode('/', $data['result_publish_date']);
                    $result_publish_date=$PublishdateFormat[2].'-'.$PublishdateFormat[1].'-'.$PublishdateFormat[0];
                    
                    $RevaldateFormat= explode('/', $data['reval_date']);
                    $reval_date=$RevaldateFormat[2].'-'.$RevaldateFormat[1].'-'.$RevaldateFormat[0];
                    //echo '<pre>'; print_r($reval_date);exit;
                    foreach ($multiAcad as $acadkey => $acad_id) { 
                        
                        $data['acad_id']= $data['academic_id'][$acadkey];
                        $data['exm_date']= $examDate;
                          $row= $Req_model->getRecordByAcadIddup($data);
                           if (!empty($row)) {
                             $this->_refresh(3,'/academic/plan/exam-dates/','Record Already exits as per Your Selection..!');
                             //echo '<pre>';print_r($row);exit;
                          }
                        
                    $insertData=array(
                        'academic_year'=> $data['academic_year'],
                        'session'=> $data['session'],
                        'academic_id'=> $data['academic_id'][$acadkey],
                        'cmn_terms'=> $data['cmn_terms'],
                        'exam_type'=> $data['exam_type'],
                        'exam_date'=> $examDate,
                        'result_publish_date'=> $result_publish_date,
                        'reval_date'=> $reval_date,
                        'end_date'=>$endDate,
                        'ip'=> $ip,
                        'status'=>$data['status']
                    );
                    //echo '<pre>';print_r($data);exit;
                    $last_id = $Req_model->insert($insertData);
                    }
                     if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){ 
//                    $bool = $Req_model->getExamDate($data);
//                    //echo '<pre>';print_r($bool);exit;
//                    
//                    if (count($bool) == 0) {
//                        $_SESSION['message_class'] = 'alert-success';
//                        $message = 'Examination Dates Added successfully';
//                        //$last_id = $Req_model->insert($insertData);
//                    } else {
//                        $_SESSION['message_class'] = 'alert-danger';
//                        $message = 'Records already exists!';
//                    }
                    $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/exam-dates');
                     }else {
                        $message="Invalid Token";
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/exam-dates');
                }
                    }
                  
                }
                break;
            case 'edit':
                 
                $result = $Req_model->getRecord($cc_id);
                
                $ExamdateFormat= explode('-', $result['exam_date']);
                $examDate=$ExamdateFormat[2].'/'.$ExamdateFormat[1].'/'.$ExamdateFormat[0];
               
                $PublishdateFormat= explode('-', $result['result_publish_date']);
                $result_publish_date=$PublishdateFormat[2].'/'.$PublishdateFormat[1].'/'.$PublishdateFormat[0];

                $RevaldateFormat= explode('-', $result['reval_date']);
                $reval_date=$RevaldateFormat[2].'/'.$RevaldateFormat[1].'/'.$RevaldateFormat[0];
                
                $EndFormat= explode('-', $result['end_date']);
                    $endDate=$EndFormat[2].'/'.$EndFormat[1].'/'.$EndFormat[0];
                
                $result['exam_date']=$examDate;
                $result['result_publish_date']=$result_publish_date;
                $result['reval_date']=$reval_date;
                $result['end_date']=$endDate;
                //echo '<pre>'; print_r($result);exit;
                $Req_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    $data = $this->getRequest()->getPost();
                    $multiAcad=$data['academic_id'];
                    //echo '<pre>'; print_r($data);exit;
                    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    }else{
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }
                    $ExamdateFormat= explode('/', $data['exam_date']);
                    $examDate=$ExamdateFormat[2].'-'.$ExamdateFormat[1].'-'.$ExamdateFormat[0];
                    
                    $PublishdateFormat= explode('/', $data['result_publish_date']);
                    $result_publish_date=$PublishdateFormat[2].'-'.$PublishdateFormat[1].'-'.$PublishdateFormat[0];
                    
                    $EndFormat= explode('/', $data['end_date']);
                    $endDate=$EndFormat[2].'-'.$EndFormat[1].'-'.$EndFormat[0];
                    
                    $RevaldateFormat= explode('/', $data['reval_date']);
                    $reval_date=$RevaldateFormat[2].'-'.$RevaldateFormat[1].'-'.$RevaldateFormat[0];
                    foreach ($multiAcad as $acadkey => $acad_id) { 
                        $updateData=array(
                            'academic_year'=> $data['academic_year'],
                            'session'=> $data['session'],
                            'academic_id'=> $data['academic_id'][$acadkey],
                            'cmn_terms'=> $data['cmn_terms'],
                            'exam_type'=> $data['exam_type'],
                            'exam_date'=> $examDate,
                            'end_date'=>$endDate,
                            'result_publish_date'=> $result_publish_date,
                            'reval_date'=> $reval_date,
                            'ip'=> $ip,
                            'status'=>$data['status']
                        );
                    $Req_model->update($updateData, array('id=?' => $cc_id));
                    
                    }
                     if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){ 
                    $Req_model->update($updateData, array('id=?' => $cc_id));

                    $_SESSION['message_class'] = 'alert-success';
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('plan/exam-dates');
                    }else {
                     $message="Invalid Token";
                    $_SESSION['message_class'] = 'alert-danger';
                     $this->_flashMessenger->addMessage($message);
                    $this->_redirect('plan/exam-dates');
                }
                    }
                }
                break;
                case 'lock_marksheet':
               
                if ($update_id != 1) {
                    $data['mark_sheet_status'] = 1;
                    //echo '<pre>'; print_r($data);exit;
                    $Req_model->update($data, array('id=?' => $cc_id));
                    $_SESSION['message_class'] = 'alert-success';
                    $this->_flashMessenger->addMessage('Mark-Sheet Status Unlocked Successfully');
                    $this->_redirect('plan/exam-dates');
                }
                if($update_id == 1){
                    $data['mark_sheet_status'] = 0;
                    // echo '<pre>'; print_r($data);exit;
                    $Req_model->update($data, array('id=?' => $cc_id));
                    $_SESSION['message_class'] = 'alert-danger';
                    $this->_flashMessenger->addMessage('Mark-Sheet Status Locked Successfully');
                    $this->_redirect('plan/exam-dates');
                }
                break;
                case 'lock_admitcard':
               
                if ($update_id != 1) {
                    $data['admit_card_status'] = 1;
                    //echo '<pre>'; print_r($data);exit;
                    $Req_model->update($data, array('id=?' => $cc_id));
                    $_SESSION['message_class'] = 'alert-success';
                    $this->_flashMessenger->addMessage('Admit Card Status Unlocked Successfully');
                    $this->_redirect('plan/exam-dates');
                }
                if($update_id == 1){
                    $data['admit_card_status'] = 0;
                    // echo '<pre>'; print_r($data);exit;
                    $Req_model->update($data, array('id=?' => $cc_id));
                    $_SESSION['message_class'] = 'alert-danger';
                    $this->_flashMessenger->addMessage('Admit Card Status Locked Successfully');
                    $this->_redirect('plan/exam-dates');
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($cc_id) {
                    $departType_model->update($data, array('cc_id=?' => $cc_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('plan/department-type');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    //End
    public function ajaxUpdateMarkSheetStatusAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $Req_model = new Application_Model_ExamDateModel();
            $id = $this->_getParam("id");
            $update_id = $this->_getParam("status_id");
            if ($update_id != 1) {
                $data['mark_sheet_status'] = 1;
                //echo '<pre>'; print_r($data);exit;
                $Req_model->update($data, array('id=?' => $id));
                echo 'Unlocked';
            }
            if($update_id == 1){
                $data['mark_sheet_status'] = 0;
                //echo '<pre>'; print_r($data);exit;
                $Req_model->update($data, array('id=?' => $id));
                echo 'Locked';
            }
        }die;
    }
    public function ajaxUpdateStuMarkSheetStatusAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $Req_model = new Application_Model_ExamDateModel();
            $id = $this->_getParam("id");
            $update_id = $this->_getParam("status_id");
            if ($update_id != 1) {
                $data['stu_mark_sheet_status'] = 1;
                //echo '<pre>'; print_r($data);exit;
                $Req_model->update($data, array('id=?' => $id));
                echo 'Unlocked';
            }
            if($update_id == 1){
                $data['stu_mark_sheet_status'] = 0;
                //echo '<pre>'; print_r($data);exit;
                $Req_model->update($data, array('id=?' => $id));
                echo 'Locked';
            }
        }die;
    }
    public function ajaxUpdateAdmitCardStatusAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $Req_model = new Application_Model_ExamDateModel();
            $id = $this->_getParam("id");
            $update_id = $this->_getParam("status_id");
            if ($update_id != 1) {
                $data['admit_card_status'] = 1;
                //echo '<pre>'; print_r($data);exit;
                $Req_model->update($data, array('id=?' => $id));
                echo 'Unlocked';
            }
            if($update_id == 1){
                $data['admit_card_status'] = 0;
                //echo '<pre>'; print_r($data);exit;
                $Req_model->update($data, array('id=?' => $id));
                echo 'Locked';
            }
        }die;
    }
    //---------------------------------------------- Ajax Code Area -------------------------------------------------  //
    public function ajaxGetFilterRecordAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $year_id = $this->_getParam("year_id");
            $session= $this->_getParam("session");
            $sem = $this->_getParam("sem");
            $type = $this->_getParam("type");
            
            $reqModel = new Application_Model_ExamDateModel();
            $result = $reqModel->getFilterRecords($year_id,$session,$sem,$type);
            $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
            //echo json_encode($result);
        }
        
    }
     public function ajaxGetExistingYearAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_year_id");
            $ReferenceGradeMaster_model = new Application_Model_ReferenceGradeMaster();
            $result = $ReferenceGradeMaster_model->getExitstingRecord($academic_id);
            echo json_encode($result);
        }die;
    }

    public function ajaxGetTermsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $TermMaster_model = new Application_Model_TermMaster();
            $term_result = $TermMaster_model->getTermDropDownList($academic_year_id);
            echo '<option value="">Select </option>';
            foreach ($term_result as $k => $val) {
                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }
        exit;
    }

    public function ajaxGetTermsDefaultAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $TermMaster_model = new Application_Model_TermMaster();
            $term_result = $TermMaster_model->getTermDropDownList($academic_year_id);
            foreach ($term_result as $k => $val) {
                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }
        exit;
    }

    public function ajaxGetExperientialLearningAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $ExperientialLearning_model = new Application_Model_ExperientialLearning();
            $el_result = $ExperientialLearning_model->getProgram($academic_year_id);
            echo '<option value="">Select </option>';
            foreach ($el_result as $k => $val) {
                echo '<option value="' . $val['elc_id'] . '" >' . $val['elc_name'] . '</option>';
            }
        }
        exit;
    }

    public function ajaxIsGradeAllocatedAction() {
        $this->_helper->layout->disableLayout();
        $batch_id = $this->_getParam("batch_id");
        $term_id = $this->_getParam("term_id");
        $course_id = $this->_getParam("course_id");
        $faculty_id = $this->_getParam("faculty_id");
        $GradeAllocation = new Application_Model_GradeAllocation();
        $isGradeAllocated = $GradeAllocation->isGradeAllocated($batch_id, $faculty_id, $term_id, $course_id);
        if ($isGradeAllocated) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function ajaxIsElGradeAllocatedAction() {
        $this->_helper->layout->disableLayout();
        $batch_id = $this->_getParam("batch_id");
        $course_id = $this->_getParam("course_id");
        $faculty_id = $this->_getParam("faculty_id");
        $ELAllocation_model = new Application_Model_ExperientialGradeAllocation();
        $isGradeExist = $ELAllocation_model->isGradeAllocated($batch_id, $faculty_id, $course_id);
        if ($isGradeExist) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function ajaxGetTermYearBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            $year_id = $this->_getParam("year_id");
            $Term_model = new Application_Model_TermMaster();
            $result = $Term_model->getTermRecordsByYear($batch_id, $year_id);
            echo '<option value="">Select </option>';
            foreach ($result as $row) {
                echo '<option value="' . $row['term_id'] . '" >' . $row['term_name'] . '</option>';
            }
        }
        exit;
    }
    
    
    public function ajaxGetTotalCreditAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $term_id = $this->_getParam("term_id");
            if ($academic_id && $term_id) {
                $TermMaster_model = new Application_Model_TermMaster();
                $result = $TermMaster_model->getTotalAllotedCredits($academic_id, $term_id);
                echo json_encode($result);
            }die;
        }
    }

    public function ajaxGetResultAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $course_id = $this->_getParam("course_id");
            if ($academic_id && $course_id) {
                $ElectiveCourseLearning_model = new Application_Model_ElectiveCourseLearning();
                $data = $ElectiveCourseLearning_model->GetCourseCount($academic_id, $course_id);

                echo json_encode($data);
            }
        }die;
    }

// ramesh  date disable	  
    public function ajaxGetTermLastdateAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            //print_r($academic_id);die;
            $term_model = new Application_Model_TermMaster();
            $lastdate_record = $term_model->getlastdateRecord($academic_id);
            echo json_encode($lastdate_record);
        }die;
    }

//Sailaja date edit	 
    public function ajaxGetTermLastdateEditAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $term_id = $this->_getParam("term_id");
            //print_r($academic_id);die;
            $term_model = new Application_Model_TermMaster();
            $lastdate_record = $term_model->getPreviousidRecord($academic_id, $term_id);
            echo json_encode($lastdate_record);
        }die;
    }

    public function ajaxGetAcademicYearAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $Academic_model = new Application_Model_Academic();
            $batch_year = $Academic_model->getyearRecord($academic_id);
            echo json_encode($batch_year);
        }die;
    }
    public function getCourseTermsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $year_id = $this->_getParam("year_id");
            $academic_year_id = $this->_getParam("academic_year_id");
            if ($year_id) {
                $Term_Model = new Application_Model_TermMaster();
                $term_data = $Term_Model->getYearTerms($year_id, $academic_year_id);
                //print_r($term_data);die;
                echo '<option value="">Select </option>';
                foreach ($term_data as $k => $val) {
                    echo '<option value="' . $k . '" >' . $val . '</option>';
                }
            }
        }die;
    }

    public function ajaxGetCoursesAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $cc_id = $this->_getParam("cc_id");
            //$academic_year_id = $this->_getParam("academic_year_id");
            if ($cc_id) {
                $Course_model = new Application_Model_Course();
                $course_data = $Course_model->getCoursesDropDownList($cc_id);
                echo '<option value="">Select</option>';
                foreach ($course_data as $k => $val) {
                    echo '<option value="' . $k . '">' . $val . '</option>';
                }
            }
        }die;
    }

    public function ajaxGetElectiveCoursesAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $course_category_id = $this->_getParam('course_category_id');
            if ($course_category_id) {
                $course_model = new Application_Model_Course();
                $elective_course_data = $course_model->getElectiveCoursesDropDownList($course_category_id);
                echo '<option value="">Select</option>';
                foreach ($elective_course_data as $k => $val) {
                    echo '<option value="' . $k . '">' . $val . '</option>';
                }
            }
        }die;
    }

    public function ajaxGetTermCoursesAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam('term_id');
            if ($term_id) {
                $course_model = new Application_Model_Corecourselearning();
                $elective_course_data = $course_model->getcorecourses($academic_year_id, $term_id);
                //print_r($elective_course_data);
                echo '<option value="">Select</option>';
                foreach ($elective_course_data as $k => $val) {
                    echo '<option value="' . $val['course_id'] . '">' . $val['course_name'] . '</option>';
                }
            }
        }die;
    }

    public function ajaxFacultyTermCoursesAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam('term_id');
            $employee_id = $this->_getParam("employee_id");
            $department_id = $this->_getParam('department_id');
            if ($term_id) {
                $course_model = new Application_Model_Corecourselearning();
                $elective_course_data = $course_model->getcorecourses($academic_year_id, $term_id);

                $employeeAllotmentModel = new Application_Model_EmployeeAllotment();
                $emp_courses = $employeeAllotmentModel->getEmployeeTerms($academic_year_id, $department_id, $employee_id, $term_id);
                $course_ids = array();
                foreach ($emp_courses as $row) {
                    $course_ids[] = $row['course_id'];
                }
                $filtered_emp_courses = array();
                foreach ($elective_course_data as $key => $row) {
                    if (in_array($row['course_id'], $course_ids)) {
                        $filtered_emp_courses[] = $row;
                    }
                }
                //print_r($filtered_emp_courses);
                echo '<option value="">Select</option>';
                foreach ($filtered_emp_courses as $k => $val) {
                    echo '<option value="' . $val['course_id'] . '">' . $val['course_name'] . '</option>';
                }
            }
        }die;
    }

    public function ajaxGetCourseDataAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $cc_id = $this->_getParam("cc_id");
            $course_id = $this->_getParam("course_id");
            $Corecourselearning_model = new Application_Model_Corecourselearning();
            $data = $Corecourselearning_model->getCourseRecord($academic_year_id, $cc_id, $course_id);
            echo json_encode($data);
        }die;
    }

    public function ajaxGetCreditidValueAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $credit_id = $this->_getParam("credit_id");
            $CreditMaster_model = new Application_Model_CreditMaster();
            $credit_record = $CreditMaster_model->getRecord($credit_id);
            echo json_encode($credit_record);
        }die;
    }

    public function ajaxGetBatchCodeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $Academic_model = new Application_Model_Academic();
            $batch_record = $Academic_model->getBatchCodeRecord($academic_id);
            echo json_encode($batch_record);
        }die;
    }
        public function ajaxEmployeeDataViewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam('term_id');
            //$year_id = $this->_getParam("year_id");
            //echo $academic_year_id;die;
            $EmployeeAllotment_model = new Application_Model_EmployeeAllotment();
            $grade_result = $EmployeeAllotment_model->getValidFacultyRecord($academic_year_id, $term_id);
            $counts = count($grade_result['ea_id']);
            //print_r($counts);die;
            echo json_encode($counts);
            die;
            $this->view->grade_result = $grade_result;
        }
    }

    public function ajaxGetBatchTermsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            if ($batch_id) {
                $Term_Model = new Application_Model_TermMaster();
                $term_data = $Term_Model->getBatchTerms($batch_id);
                //print_r($SubProgram);die;
                echo '<option value="">Select </option>';
                foreach ($term_data as $k => $val) {
                    echo '<option value="' . $k . '" >' . $val . '</option>';
                }
            }
        }die;
    }
    
    public function check() {
        $class_alotment = new Application_Model_Classalotment();
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {


            $date = $this->_getParam("date");
            $course_id = $this->_getParam("course_id");
            $batch = $this->_getParam("batch_id");
            $class = $this->_getParam('class_no');
            $term = $this->_getParam('term_id');


            $result = $class_alotment->check($course_id, $date, $class, $batch, $term);
            echo $result;
            exit;
        }
    }
    
    
    public function otpmanageAction() {
        
            $opt_obj = new Application_Model_OtpModel();
            $getotp = $opt_obj->getRecordsbyotp();
            $this->view->studata = $getotp;
            //print_r($getotp );
           //die();
               
               
    }

    public function check1($date, $course_id, $batch, $class, $term) {
        $class_alotment = new Application_Model_Classalotment();
        $result = $class_alotment->check($course_id, $date, $class, $batch, $term);
        return $result;
    }

    //ajax employee allotment
    public function ajaxEmployeeAllotmentAction() {

        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $academic_id = $this->_getParam("academic_year_id");

            $Course_model = new Application_Model_Course();
            $data = $Course_model->getDropDownList();

            $this->view->DropDownCourse = $data;
            $Course_model = new Application_Model_Course();
            $termwisecourses = $Course_model->getDropDownList1($academic_id);
            echo '<div class="row" style="">';

            echo '<div class="col-sm-2" style="height: 100px;overflow-y: scroll;margin-top:20px;">';
            echo '<label  class="control-label">Term</label></br>';
            foreach ($termwisecourses as $k => $DropDownCourse) {
                echo '<label class="label-checkbox" style="padding-left:50px; margin:0px;" >';

                echo '<span class="custom-checkbox" style="float:left;"></span> </label>' . $k . '';

                foreach ($DropDownCourse as $key => $value) {
                    echo '<label class="label-checkbox" style="padding-left:50px; margin:0px;" >';
                    echo '<input type="checkbox" name="course_name[]" id="course_name" class="checkbox1" 
										value=' . $key . ' /> ';
                    echo '<span class="custom-checkbox" style="float:left;"></span> </label> ' . $value . '';
                }
            }
            echo '</div></div> ';
        } die;
    }

    //Employee Details View Ajax
    public function ajaxEmployeeDetailsViewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam("term_id");
            $emp_allotment = $this->_getParam("emp_allotment");
            $EmployeeAllocationItems_model = new Application_Model_EmployeeAllocationItems();
            //echo $emp_allotment;die;
            if (!empty($emp_allotment)) {

                $item_result = $EmployeeAllocationItems_model->getItemsRecords($emp_allotment);
                $term_id = $item_result[0]['term_id'];
                $this->view->item_result = $item_result;
                $Corecourselearning_model = new Application_Model_Corecourselearning();
                $result = $Corecourselearning_model->getprogramByYearTerm($academic_year_id, $term_id);
                //print_r($result);die;
                $this->view->employee_result = $result;
                //$HRMModel_model = new Application_Model_HRMModel();
                //$department = $HRMModel_model->getDepartments();
                //print_r($department);die;
                // $this->view->department = $department;
                $HRMModel_model = new Application_Model_HRMModel();
                $employee = $HRMModel_model->getOrgFacultyIds();
                //print_r($department);die;
                $this->view->employee = $employee;

                $visitingemployee = $HRMModel_model->getVisitingEmployeeIds();
                $this->view->visitingemployees = $visitingemployee;
            } else {
                if ($academic_year_id && $term_id) {
                    $Corecourselearning_model = new Application_Model_Corecourselearning();
                    $result = $Corecourselearning_model->getprogramByYearTerm($academic_year_id, $term_id);
                    //print_r($result);die;
                    $this->view->employee_result = $result;
                    // $HRMModel_model = new Application_Model_HRMModel();
                    // $department = $HRMModel_model->getDepartments();
                    //print_r($department);die;
                    // $this->view->department = $department;
                    $HRMModel_model = new Application_Model_HRMModel();
                    $employee = $HRMModel_model->getEmployeeIds();
                    //print_r($department);die;
                    $this->view->employee = $employee;

                    $visitingemployee = $HRMModel_model->getVisitingEmployeeIds();
                    $this->view->visitingemployees = $visitingemployee;
                }
            }
        }
    }
    
    
     public function ajaxExamMonthGetDataAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $exam_id = $this->_getParam("examId");
            $reqModel = new Application_Model_ExamDateModel();
            $result = $reqModel->getRecord($exam_id);
            echo date('M-Y',strtotime($result['exam_date']));
          
            //echo json_encode($result);
        } 
         die;
    } 

}
