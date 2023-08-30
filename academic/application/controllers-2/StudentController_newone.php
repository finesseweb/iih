<?php

class StudentController extends Zend_Controller_Action {

    private $_siteurl = null;
    private $_db = null;
    private $_flashMessenger = null;
    private $_authontication = null;
    private $_agentsdata = null;
    private $_usersdata = null;
    private $_act = null;
    private $_adminsettings = null;
    Private $_unit_id = null;
    private $accessConfig = NULL;
    private $aeccConfig = NULL;

    public function init() {
        $zendConfig = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        require_once APPLICATION_PATH . '/configs/access_level.inc';

        $this->accessConfig = new accessLevel();
        $config = $zendConfig->mainconfig->toArray();
        $this->view->mainconfig = $config;
        $this->_action = $this->getRequest()->getActionName();
        //access role id
        $this->roleConfig = $config_role = $zendConfig->role_administrator->toArray();
        $this->aeccConfig = $config_role = $zendConfig->aecc_course->toArray();
        $this->studentConfig = $zendConfig->student_holiday_controller->toArray();
        $this->holidayCategory = $holiday_category = $zendConfig->holiday_category->toArray();
        $this->view->administrator_role = $config_role;
        $storage = new Zend_Session_Namespace("admin_login");
        $this->login_storage = $data = $storage->admin_login;
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

    public function indexAction(){
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'Student';
        $this->accessConfig->setAccess('SA_ACAD_ENROLLMENT');
        //===============[DB Models]=====================================//
        $participant_model = new Application_Model_ParticipantsLogin();
        $StudentPortal_model = new Application_Model_StudentPortal();
        $studentFeeDetails = new Application_Model_FeeDetails();
        $student_model = new Application_Model_StudentPortal();
        $alumni_model = new Application_Model_Alumni();
        $fee_details = new Application_Model_FeeDetails();
        $term_master = new Application_Model_TermMaster();
        $academic_model = new Application_Model_Academic();
        $dept_model = new Application_Model_Department();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        //==========================[END Models]=======================//
        //============ [UI Forms]========================== //     
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        //=============== [END Forms] =====================//    
        //====== [FOR BANK PURPOSE] ==================//
        $gl_trans_model = new Application_Model_GlTrans();
        $debit_credit_Acc = $gl_trans_model->getDebitCreditAccount('course-fee');
        $student_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        //===============[Erp section ends]=========//
        $this->view->type = $type;
        $this->view->form = $student_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                   
                    
                    $getDept= $academic_model->getDepartment($data['academic_id']);
                    $getDeptType=$dept_model->getRecord($getDept['department']);
                    
                     $data['year_id']= $data['academic_year_list'];
                     $data['dept_type']= $getDeptType['department_type'];
                    
                    //echo '<pre>'; print_r($data);exit;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            unset($data['csrftoken']);
                            $result2 = $StudentPortal_model->getstudentsdetailsForFirstTerm($data['academic_id']);
                            $result2['participants_name'] = $data['stu_fname'] . " " . $data['stu_lname'];
                            $result2['participants_id'] = $data['stu_id'];

                            //unset($data['session_id']);
                            unset($data['participant_username']);
                            unset($data['participant_pword']);
                            unset($data['confirm_password']);
                            unset($data['linked_in']);
                            unset($data['secondary_mail']);
                            unset($data['session']);
                            unset($data['academic_year_list']);
                            unset($data['selected_courses']);

                            unset($data['csrftoken']);

                            $aecc = $this->getRequest()->getPost('aecc');
                            $ge = $this->getRequest()->getPost('ge');

                            unset($data['ge']);
                            unset($data['aecc']);

                            if ($result2 != 0) {
                                $check = $fee_details->checkWithPdmId($result2['participants_id'], $result2['batch_id'], $result2['term_id']);
                                if ($check == 0) {
                                    $last_id = $studentFeeDetails->insert($result2);
                                    for ($gl_account = 0; $gl_account < 2; $gl_account++) {
                                        $gl_trans['type'] = 110;
                                        $gl_trans['type_no'] = $last_id;
                                        $gl_trans['tran_date'] = date('Y-m-d');
                                        $gl_trans['account'] = $debit_credit_Acc[$gl_account];
                                        $gl_trans['memo_'] = 'Tuition fee';
                                        if ($gl_account == 0) {
                                            $gl_trans['amount'] = $result2['total_fee'] - ((int) $result2['total_fee'] + (int) $result2['total_fee']);
                                        } elseif ($gl_account == 1) {
                                            $gl_trans['amount'] = (double) $result2['total_fee'];
                                        }
                                        $gl_trans['person_type_id'] = 5;
                                        //  $gl_trans_model->insert($gl_trans);
                                    }
                                } else
                                    $studentFeeDetails->update($result2, array('participants_id=?' => $result2['participants_id'], 'batch_id =?' => $result2['batch_id'], 'term_id =?' => $result2['term_id']));
                            }
                            $display_phone = $this->getRequest()->getPost('display_phone');

                            $data_save = $_POST;
                            $status = $this->getRequest()->getPost('passing_status');
                            if (empty($status))
                                $status = 0;
                            $data['passing_status'] = $status;
                            $short_code = $studentFeeDetails->getShortCode($data['academic_id']);
                            $last_insert_id = $student_model->insert($data);
                          
                            // ----------------[Auto Add into Elective Selection Items]----------------------//
                            //===============[Get Term Name Start]=================================//

                            $data['term_id'] = $term_master->getAcademicMinTerms($data['academic_id']);

                            //==================[END Terms]======================================//
                            $checkElective=$course_credit_master->getGeCourse($data['academic_id'], $data['term_id']);
                          //  echo '<pre>';print_r($checkElective);exit;
                            if(!empty($checkElective)){

                            $elective_course_id = $course_credit_master->getCoreCouseDetailByTermAcademicCourseid($data['academic_id'], $data['term_id'], $ge);

                            $credit_result = $course_credit_master->getCoreCouseDetailByTermAcademicCourse($data['academic_id'], $data['term_id'], $elective_course_id);

                            //  echo "<pre>";print_r($credit_result);exit;


                            $students_electives = $credit_result['credit_value'];
                            $data_elective['academic_year_id'] = $data['academic_id'];
                            $data_elective['student_id'] = $last_insert_id;
                            $data_elective['term_id'] = $data['term_id'];
                            //$elective_insert_id = $Elective_model->insert($data_elective);
                            
                           $elective_insert_id = $Elective_model->getStudentElectivesId($data['academic_id'], $data['term_id'], $last_insert_id);
                          // $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($data['academic_id'], $data['term_id'], $last_insert_id);
                            //echo '<pre>'; print_r($elective_insert_id);die;
                            foreach ($credit_result as $credit_results) {
                            $elective_data['elective_id'] = $elective_insert_id;
                            $elective_data['electives'] = $credit_results['course_id'];
                            $elective_data['students_id'] = $last_insert_id;
                            //$elective_data['term_ids'] = 4;
                            $elective_data['terms'] = $data['term_id'];
                            $elective_data['aecc'] = !empty($aecc)?$aecc:'0';
                            $elective_data['ge_id'] = $credit_results['ge_id'];
                            $elective_data['credit_value'] = $credit_results['credit_value'];
                            $ElectiveItems_model->insert($elective_data);
                            }
                            $elective_data['electives'] = $aecc;
                            $elective_data['aecc'] = 0;
                            $elective_data['ge_id'] = $this->aeccConfig[0];
                            
                            $ElectiveItems_model->insert($elective_data);
                        }
                            //---------------[END]-------------------------------------------//
                            // $stu_status = $this->getRequest()->getPost('stu_status');
                            $bool = $student_model->checkRecords($last_insert_id);
                            $result = $student_model->getRecordsById($last_insert_id);
                            $data2['participant_fname'] = $data_save['stu_fname'];
                            $data2['student_id'] = $last_insert_id;
                            $data2['participant_lname'] = $data_save['stu_lname'];
                            $data2['participant_email'] = $data_save['secondary_mail'];
                            $data2['participant_username'] = $data_save['participant_username'];
                            if (!empty($data_save['participant_pword']))
                                $data2['participant_pword'] = $data_save['participant_pword'];
                            $data2['participant_continue'] = $result[0]['stu_status'];
                            $data2['participant_yop'] = $result[0]['passing_year'];
                            $data2['participants_file'] = $data['filename'];
                            $data2['participant_academic'] = $result[0]['academic_id'];
                            $data2['participant_Alumni'] = $status;
                            $data2['linked_in'] = $data_save['linked_in'];
                            $data2['fa_salutation'] = $result[0]['gender'];
                            $data2['alumni_url'] = str_replace(" ", "", $result[0]['stu_fname']) . $result[0]['stu_id'];
                            $data2['roll_no'] = $result[0]['stu_id'];
                            if ($bool != 1) {
                                $last_id = $participant_model->insert($data2);
                            } else {
                                $participant_model->update($data2, array('student_id=?' => $last_insert_id));
                            }
                            unset($_SESSION["token"]);
                            if ($status == 1) {
                                $bool = $student_model->checkAlumni($last_insert_id);
                                $data3['al_email_id'] = $result[0]['stu_email_id'];
                                $data3['al_address'] = $result[0]['premanent_addr'];
                                $data3['al_url'] = str_replace(" ", "", $result[0]['stu_fname']) . $result[0]['stu_id'];
                                $data3['student_id'] = $result[0]['student_id'];
                                $data3['al_contact_no'] = $result[0]['stu_mobileno'];
                                if ($display_phone) {
                                    $data3['display_phone'] = 1;
                                } else {
                                    $data3['display_phone'] = 0;
                                }
                                if ($bool != 1) {

                                    // $data3['user_id'] = $last_id;
                                    $alumni_model->insert($data3);
                                } else {

                                    $alumni_model->update($data3, array('student_id=?' => $last_insert_id));
                                }
                            }
                            // echo "<pre>";print_r($result);echo"</pre>";exit;
                            $dirPath = realpath(APPLICATION_PATH . '/../public/images') . '/' . $last_insert_id . '/student_details/';

                            if (!file_exists($dirPath)) {
                                mkdir($dirPath, 755, true);
                            }

                            $imagetype = $_FILES['file']['type'][0];
                            $file_name = $_FILES["file"]["name"];

                            $tem_name = $_FILES["file"]["tmp_name"];
                            $image_mime = $this->getMimeType($tem_name[0]);

                            $imageFileType = strtolower(pathinfo($file_name[0], PATHINFO_EXTENSION));
                            if ($image_mime) {
                                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" && $imagetype == 'image/png' || $imagetype == 'image/jpg' || $imagetype == 'image/jpeg') {
                                    if (move_uploaded_file($tem_name[0], $dirPath . $file_name[0])) {
                                        //echo "File is valid, and was successfully uploaded"; 
                                    } else {
                                        // echo "Upload failed";  
                                    }
                                    $file_data['filename'] = "public/images/" . $last_insert_id . "/student_details/" . $file_name[0];

                                    $student_model->update($file_data, array('student_id=?' => $last_insert_id));
                                } else {
                                    $this->_refresh(5, "/academic/student/index/type/add", 'Invalid Image Extension Type  ..');
                                }
                            } else {
                                $this->_refresh(3, "/academic/student/index/type/edit/id/{$last_insert_id}", 'This is not an Image ..');
                            }
                            if ($result2 != 0) {
                                $this->_flashMessenger->addMessage('Student added Successfully');
                                $this->_redirect('student/index');
                            } else
                                $_SESSION['flash_error'] = '0';
                            $this->_flashMessenger->addMessage('Student added Successfully Please create terms and fee structure ');
                            $this->_redirect('student/index');
                            //}
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Invalid Token ! ');
                            $this->_redirect('student/index');
                        }
                    }
                }
                break;
            case 'edit':

                if ($_POST['action'] == 'cnf_tc') {

                    $ChcekTcNumber = $StudentPortal_model->getStudentTcInfo($_POST['stu_id']);
                    if (empty($ChcekTcNumber['tc_number'])) {

                        $acad_id = $_POST['academic_id'];
                        if ($acad_id) {
                            $result = $student_model->getDepartmentType($acad_id);
                        }

                        $tcUpdateData = array(
                            'effective_date' => $_POST['effective_date'],
                            'stu_status' => $_POST['stu_status'],
                            'stream' => $result['stream']
                        );

                        $update_id = $student_model->update($tcUpdateData, array('stu_id=?' => $_POST['stu_id']));

                        $getTcNumber = $student_model->getTcNumber($result['stream']);
                        //echo '<pre>'; print_r($getTcNumber);exit;
                        $tcNumber = $getTcNumber['tcNumber'] + 1;
                        $update_tc = array(
                            'tc_number' => $tcNumber,
                            'tc_status' => 1
                        );
                        //echo '<pre>'; print_r($update_tc);exit;
                        $update_id = $student_model->update($update_tc, array('stu_id=?' => $_POST['stu_id']));

                        $this->_flashMessenger->addMessage('T.C. Generated.');
                        $this->_redirect('student/index/type/edit/id/' . $student_id);
                    } else {
                        $update_tc = array(
                            'tc_status' => 1
                        );
                        //echo '<pre>'; print_r($update_tc);exit;
                        $update_id = $student_model->update($update_tc, array('stu_id=?' => $_POST['stu_id']));
                        $this->_flashMessenger->addMessage('Editing Disabled.');
                        $this->_redirect('student/index/type/edit/id/' . $student_id);
                    }
                } else if ($_POST['action'] == 'unlock_tc') {
                    $update_tc = array(
                        'tc_status' => 0
                    );
                    //echo '<pre>'; print_r($update_tc);exit;
                    $update_id = $student_model->update($update_tc, array('stu_id=?' => $_POST['stu_id']));
                    $this->_flashMessenger->addMessage('Editing Enabled.');
                    $this->_redirect('student/index/type/edit/id/' . $student_id);
                } else {
                    $messages = $this->_flashMessenger->getMessages();
                    $this->view->messages = $messages;
                    $result = $student_model->getRecord($student_id);
                    //echo '<pre>';print_r($result);exit;
                    if (empty($result['result_of_exam'])) {
                        if (!empty($result['total_credit'])) {
                            $Grade_Model = new Application_Model_GradeAllocationItems();
                            $marksDetails = $Grade_Model->getCGPAForStudent($result['academic_id'],$result['stu_id']);
                            $Actualcgpa = number_format($marksDetails['cgpa'],2);
                            $percent = 0;
                             if(!empty($result['degree_id'])){
                            if($result['degree_id']>1)
                            $percent = number_format($Actualcgpa*9.5,2);
                            else if($result['degree_id']==3)
                            $percent = number_format($Actualcgpa*9.25,2);
                            else
                            $percent = number_format($Actualcgpa*9,2);
                        }
                            
                            
                         

                            $ref_grade_item = new Application_Model_ReferenceGradeMasterItems();
                            $letter_grade = $ref_grade_item->getRecordByNumGrade1($percent, $result['degree_id'], $result['session']);

                            $result['result_of_exam'] .= 'Grade (' . $letter_grade['letter_grade'] . ')';
                            $result['result_of_exam'] .= " with CGPA: " . number_format($Actualcgpa, 2);
                        }
                    }
                    $alumni_detail = $student_model->getAlumniDetail($student_id);
                    $this->view->alumni_detail = $alumni_detail;
                    $_SESSION['StuPword'] = $alumni_detail['participant_pword'];
                    $term_id = $term_master->getAcademicMinTerms($result['academic_id']);

                    $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($result['academic_id'], $term_id, $student_id);
                   
                     if (!empty($elective_insert_id))
                    $elective_res = $ElectiveItems_model->getGEAeccforTermOne($elective_insert_id,$student_id);
                       //echo '<pre>'; print_r($elective_res); exit;  
                    $result['academic_year_list']=$result['year_id'];
                    $student_form->populate($result);
                    
                    $this->view->edit_id = $student_id;
                    $this->view->elective = $elective_res;
                    $this->view->result = $result;
                    
                    //echo '<pre>'; print_r($_POST); exit;
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            //echo '<pre>'; print_r($_POST); exit;
                            //if ($student_form->isValid($this->getRequest()->getPost())) {
                            $data = $_POST;
                            $getDept= $academic_model->getDepartment($data['academic_id']);
                            $getDeptType=$dept_model->getRecord($getDept['department']);

                            $data['year_id']= $data['academic_year_list'];
                            $data['dept_type']= $getDeptType['department_type'];
                           
                            $result2 = $StudentPortal_model->getstudentsdetailsForFirstTerm($data['academic_id']);
                            //  echo "<pre>";print_r($result2);exit;
                            $result2['participants_name'] = $data['stu_fname'] . " " . $data['stu_lname'];

                            $result2['participants_id'] = $data['stu_id'];
                            $aecc = $this->getRequest()->getPost('aecc');
                            $ge = $this->getRequest()->getPost('ge');
                           // $ge=implode(',',$ge);
                            unset($data['ge']);
                            unset($data['csrftoken']);
                            unset($data['aecc']);
                            unset($data['session']);
                            unset($data['academic_year_list']);
                            unset($data['selected_courses']);
                            
                            
                            //print_r($result2);exit;
                            if ($result2 != 0 && $result2['term_id'] != '') {
                                $check = $fee_details->checkWithPdmId($result2['participants_id'], $result2['batch_id'], $result2['term_id']);
                                if ($check == 0) {
                                    $last_id = $studentFeeDetails->insert($result2);
                                    for ($gl_account = 0; $gl_account < 2; $gl_account++) {
                                        $gl_trans['type'] = 110;
                                        $gl_trans['type_no'] = $student_id;
                                        $gl_trans['tran_date'] = date('Y-m-d');
                                        $gl_trans['account'] = $debit_credit_Acc[$gl_account];
                                        $gl_trans['memo_'] = 'Tuition fee';
                                        if ($gl_account == 0) {
                                            $gl_trans['amount'] = $result2['total_fee'] - ((int) $result2['total_fee'] + (int) $result2['total_fee']);
                                        } elseif ($gl_account == 1) {
                                            $gl_trans['amount'] = $result2['total_fee'];
                                        }
                                        $gl_trans['person_type_id'] = 5;
                                        // $gl_trans_model->insert($gl_trans);
                                    }
                                } else {
                                    $studentFeeDetails->update($result2, array('participants_id=?' => $result2['participants_id'], 'batch_id =?' => $result2['batch_id'], 'term_id =?' => $result2['term_id']));
                                }
                            }


                            $data_save = $this->getRequest()->getPost();
                            //echo "<pre>";print_r($data_save);exit;

                            $display_phone = $this->getRequest()->getPost('display_phone');
                            $status = $this->getRequest()->getPost('passing_status');
                            if (empty($status))
                                $status = 0;
                            $data['passing_status'] = $status;

                            $delete_arr = array('participant_username',
                                'participant_pword',
                                'confirm_password',
                                'linked_in',
                                'secondary_mail');
                            for ($i = 0; $i < count($delete_arr); $i++) {
                                foreach ($data as $key => $value) {
                                    if (($key = $delete_arr[$i])) {
                                        unset($data[$key]);
                                    }
                                }
                            }
                            // print_r($data);exit;
                            $dirPath = realpath(APPLICATION_PATH . '/../public/images') . '/' . $student_id . '/student_details/';

                            if (!file_exists($dirPath)) {
                                mkdir($dirPath, 755, true);
                            }

                            $imagetype = $_FILES['file']['type'][0];
                            // die();
                            $file_name = $_FILES["file"]["name"];

                            $tem_name = $_FILES["file"]["tmp_name"];
                            //===check for true image ====//
                            //echo '<pre>'; print_r($tem_name);exit;
                            $image_mime = $this->getMimeType($tem_name[0]);
                            $imageFileType = strtolower(pathinfo($file_name[0], PATHINFO_EXTENSION));

//                        $image_mime = image_type_to_mime_type(exif_imagetype($dirPath.$_FILES['file']['name'][0]));
//                        mime_content_type($dirPath.$_FILES["file"]["name"][0]);
//                        die();
                            if (!empty($_FILES['file']['name'][0])) {

//                            if($imagetype=='image/png' || $imagetype=='image/jpg' || $imagetype=='image/jpeg') {
//                                
//                                
//                            }
                                if ($image_mime) {
                                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" && $imagetype == 'image/png' || $imagetype == 'image/jpg' || $imagetype == 'image/jpeg') {

                                        if (move_uploaded_file($tem_name[0], $dirPath . $file_name[0])) {
                                            //echo "File is valid, and was successfully uploaded"; 
                                        }
                                        if (!empty($file_name[0])) {
                                            $data['filename'] = "public/images/" . $student_id . "/student_details/" . $file_name[0];
                                        } else {
                                            $data['filename'] = $result['filename'];
                                        }
                                    } else {
                                        $this->_refresh(3, "/academic/student/index/type/edit/id/{$student_id}", 'Invalid Image Extension Type  ..');
                                    }
                                } else {
                                    $this->_refresh(3, "/academic/student/index/type/edit/id/{$student_id}", 'This is not an Image ..');
                                }
                            }

                            //Added by kedar to update session
                            //$session_info = $academic_model->getRecord($data['academic_id']);
                            //$data['session'] = $session_info['session'];
                            $student_model->update($data, array('student_id=?' => $student_id));

                            // -------------[Auto Add into Elective Selection Items]-----------//
                            //===============[Get Term Name Start]=================================//

                            $data['term_id'] = $term_master->getAcademicMinTerms($data['academic_id']);

                            //==================[END Terms]======================================//
                            $checkElective=$course_credit_master->getGeCourse($data['academic_id'], $data['term_id']);
                        
                            if(!empty($checkElective)){
                            if(!$ge)
                            $this->_refresh(3, '/academic/master/aeccge/type/add', 'Redirecting to create Generic Eletive For this Department...');
                            $elective_course_id = $course_credit_master->getCoreCouseDetailByTermAcademicCourseid($data['academic_id'], $data['term_id'], $ge);
                              
                            if (!empty($elective_course_id))
                                $credit_result = $course_credit_master->getCoreCouseDetailByTermAcademicCourse($data['academic_id'], $data['term_id'], $elective_course_id);
$credits='';
 //echo '<pre>';print_r($credit_result);exit;
//foreach ($credit_result as $credit_results) {
//    $credits+=$credit_results['credit_value'];
//}
                            //echo "<pre>";print_r($data['term_id']);exit;
                            //$students_electives = $credit_result['credit_value'];
                            $students_electives = $credits;
                            $data_elective['academic_year_id'] = $data['academic_id'];
                            $data_elective['student_id'] = $student_id;
                            $data_elective['term_id'] = $data['term_id'];
                            //  $elective_insert_id = getStudentSelectedElectivesId

                            $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($data['academic_id'], $data['term_id'], $student_id);
                            //   echo $elective_insert_id; die;
                            //===[trash privious item ] Elective Code Area===================//
                            if ($_POST['stu_status'] == 1) {
                                if ($elective_insert_id)
                                    $ElectiveItems_model->trashItems($elective_insert_id);
                                if (!$elective_insert_id)
                                    $elective_insert_id = $Elective_model->insert($data_elective);
                                foreach ($credit_result as $credit_results) {
                                $elective_data['elective_id'] = $elective_insert_id;
                                $elective_data['electives'] = $credit_results['course_id'];
                                $elective_data['students_id'] = $student_id;
                                //$elective_data['term_ids'] = 4;
                                $elective_data['terms'] = $data['term_id'];
                                $elective_data['aecc'] = !empty($aecc)?$aecc:'0';
                                $elective_data['ge_id'] = $credit_results['ge_id'];
                                $elective_data['credit_value'] = $credit_results['credit_value'];
                                //echo '<pre>';print_r($elective_data);exit;
                                $ElectiveItems_model->insert($elective_data);
                                }
                                if(!empty($aecc)){
                                $elective_data['electives'] = $aecc;
                                $elective_data['aecc'] = 0;
                                $elective_data['ge_id'] = $this->aeccConfig[0];
                                $ElectiveItems_model->insert($elective_data);
                                }
                            }
                            
                            }
                            //======= END ================== //



                            $bool = $student_model->checkRecords($student_id);
                            $result = $student_model->getRecordsById($student_id);
                            //echo '<pre>'; print_r($result);exit;
                            $data2['participant_fname'] = $data_save['stu_fname'];
                            $data2['student_id'] = $student_id;
                            $data2['participant_lname'] = $data_save['stu_lname'];
                            $data2['participant_email'] = $data_save['secondary_mail'];
                            $data2['participant_username'] = $data_save['participant_username'];
                            if (!empty($data_save['participant_pword']))
                                $data2['participant_pword'] = $data_save['participant_pword'];
                            $data2['participant_continue'] = $result[0]['stu_status'];
                            $data2['participant_yop'] = $result[0]['passing_year'];
                            $data2['participants_file'] = $data['filename'];
                            $data2['participant_academic'] = $result[0]['academic_id'];
                            $data2['participant_Alumni'] = $status;
                            $data2['linked_in'] = $data_save['linked_in'];
                            $data2['fa_salutation'] = $result[0]['gender'];
                            $data2['alumni_url'] = str_replace(" ", "", $result[0]['stu_fname']) . $result[0]['stu_id'];
                            $data2['roll_no'] = $result[0]['stu_id'];
                            //echo '<pre>'; print_r($data2);exit;
                            if ($bool != 1) {
                                $last_id = $participant_model->insert($data2);
                            } else {
                                $participant_model->update($data2, array('student_id=?' => $student_id));
                            }
                            unset($_SESSION["token"]);
                            if ($status == 1) {
                                $bool = $student_model->checkAlumni($student_id);
                                $data3['al_email_id'] = $result[0]['stu_email_id'];
                                $data3['al_address'] = $result[0]['premanent_addr'];
                                $data3['al_url'] = str_replace(" ", "", $result[0]['stu_fname']) . $result[0]['stu_id'];
                                $data3['student_id'] = $result[0]['student_id'];
                                $data3['al_contact_no'] = $result[0]['stu_mobileno'];
                                if ($display_phone) {
                                    $data3['display_phone'] = 1;
                                } else {
                                    $data3['display_phone'] = 0;
                                }
                                if ($bool != 1) {

                                    // $data3['user_id'] = $last_id;
                                    $alumni_model->insert($data3);
                                } else {

                                    $alumni_model->update($data3, array('student_id=?' => $student_id));
                                    $message = 'Student Details Updated Successfully';
                                }
                            }
                            if ($result2 != 0) {
                                $this->_flashMessenger->addMessage('Student Details Updated Successfully');
                                $this->_redirect('student/index/type/edit/id/' . $student_id);
                            } else {
                                $_SESSION['admin_login']['admin_login']->flash_error = '0';
                                $this->_flashMessenger->addMessage('Student Details Updated Successfully');
                                $this->_redirect('student/index/type/edit/id/' . $student_id);
                            }
                        } else {
                            $_SESSION['admin_login']['admin_login']->flash_error = '0';
                            $this->_flashMessenger->addMessage('Invalid Token!');
                            $this->_redirect('student/index/type/edit/id/' . $student_id);
                        }
                    }
                }

                break;
            case 'delete':
                $data['status'] = 2;
                if ($student_id) {
                    $student_model->update($data, array('student_id=?' => $student_id));
                    $this->_flashMessenger->addMessage('Student Details Deleted Successfully');
                    $this->_redirect('student/index');
                }
                break;
            case 'download':
                $this->_helper->viewRenderer->setNoRender(true);
                $this->_helper->layout->disableLayout();
                $path_file = realpath(APPLICATION_PATH . '/../public/images') . '/';
                //print_r($path_file);die;
                $id = $this->_getParam("id");
                $uploaded_file = $this->_getParam("file");
                $filename = $id . '/' . 'student_details' . '/' . $uploaded_file; // of course find the exact filename....
                $file = $path_file . $filename;
                $validator = new Zend_Validate_File_Exists();
                $validator->addDirectory($path_file);

                //zfdebug(mime_content_type($file));
                if ($validator->isValid($filename)) {
                    header('Pragma: public');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Cache-Control: private', false); // required for certain browsers 
                    //header('Content-Type: '.mime_content_type($file));
                    header('Content-Disposition: attachment; filename="' . basename($file) . '";');
                    header('Content-Transfer-Encoding: binary');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                } else {
                    $this->_flashMessenger->addMessage('File does not exist');
                    $this->_redirect('student/index');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;

//                $result = $student_model->getRecords();
//                
//                //echo "<pre>";print_r($result);exit;
//                
//                foreach($result as $key => $value){
//                    
                //   $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']); 
//                   $term_id =  $term_master->getAcademicMinTerms($value['academic_id']); 
//                    
//                   
//                     $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);
//                     if(!empty($elective_insert_id)) 
//                     $elective_res =   $ElectiveItems_model->getItemsRecords($elective_insert_id);
//                     else{
//                         $elective_res[0]['ge_id'] = '--';
//                         $elective_res[0]['aecc'] = '--';
//                     }
//                     $ge_model = new Application_Model_Ge();
//                     $course = new Application_Model_Course();
//                     $cor_dept = new Application_Model_Academic();
//                     $dept_model = new Application_Model_Department();
//                      
//                     $dept = $cor_dept->getRecord($value['academic_id']);
//            
//                    // echo "<pre>";print_r($dept['department']);exit;
//                     
//                     $result[$key]['dept_name'] = $dept_model->getRecord($dept['department'])['department'];
//                        
//                        
//                     $result[$key]['ge_name'] = $ge_model->getRecord($elective_res[0]['ge_id'])['general_elective_name'];
//                    
//                                               $result[$key]['aecc_name'] = $course->getRecord($elective_res[0]['aecc'])['course_name'];
//                                               // echo "<pre>";print_r($result);exit;
//                   // echo "<pre>";print_r($result);exit;
//                
//                    
//                }
//                
                $result = array();

                $page = $this->_getParam('page', 1);

                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

     public function selectionAction() {

        $this->view->action_name = 'slection';

        $this->view->sub_title_name = 'slection';
        $slection_form = new Application_Form_Selection();
        $tuitionfeesModel = new Application_Model_FeesCollection();
        $feeStructure = new Application_Model_FeeStructure();
        $examFeeModel = new Application_Model_ExamformSubmissionModel();
        $examDateModel = new Application_Model_ExamDateModel();
        $examFeeNonColModel = new Application_Model_UgNonformSubmissionModel();
        $studentModel = new Application_Model_StudentPortal();
        $FeeWaiverModel = new Application_Model_FeeWaiver();
        $termModel = new Application_Model_TermMaster();
        $academicModel = new Application_Model_Academic();
        $this->view->form = $slection_form;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            unset($data['csrftoken']);
                            foreach ($data['fee_wave'] as $index => $dataFeetype) {
                                foreach ($data['selected_students'] as $arrindex => $stu_id) {
                                    $student_details = $studentModel->getStudenacademicDetails($stu_id);
                                   // echo "<pre>";print_r($student_details);exit;
                                    $acaddetails = $academicModel->getRecord($student_details['academic_id']);
                                    $term_details = $termModel->getTermRecordsbycmn($student_details['academic_id'], $data['term_id']);
                                    $dataStudent['fee_waiver'] = 1;
                                    $feewaiveData['stu_id'] = $stu_id;
                                    $feewaiveData['cmn_terms'] = $data['term_id'];
                                    if ($dataFeetype == 1) {
                                        $examDate = $examDateModel->getDateInfoByAdmitCardStatus($student_details['academic_id'], $data['term_id'],$dataFeetype);
                                        //echo "<pre>";print_r($examDate['id']);exit;
                                        if (empty($examDate['id'])) {
                                            $this->_message('Please Create Exmination Dates.');
                                        }
                                        $feewaiveData['type'] = 1;

                                        $examFeeData = array(
                                            'student_id' => $student_details['student_id'],
                                            'year_exam' => Date("Y", strtotime($examDate['exam_date'])),
                                            'session_id' => $acaddetails['session'],
                                            'academic_year_id' => $student_details['academic_id'],
                                            'term_id' => $term_details['term_id'],
                                            'stu_name' => $student_details['stu_fname'],
                                            'fname' => $student_details['father_fname'],
                                            'date_of_birth' => $student_details['stu_dob'],
                                            'reg_no' => $student_details['reg_no'],
                                            'examination_id' => $student_details['exam_roll'],
                                            'examination_name' => Date("M-Y", strtotime($examDate['exam_date'])),
                                            'college_name' => "Patna Women's College",
                                            'created_date' => date('Y-m-d'),
                                            'u_id' => $student_details['stu_id'],
                                            'email' => $student_details['stu_email_id'],
                                            'phone' => $student_details['father_mobileno'],
                                            'payment_activation' => 1,
                                            'payment_status' => 1,
                                            'status' => 1,
                                            'exam_month_id' => $examDate['id']
                                        );
                                        $feeExist = $examFeeModel->getPaymentByTermId($stu_id, $term_details['term_id']);
                                        if (!is_array($feeExist)) {
                                            $examFeeModel->insert($examFeeData);
                                            $FeeWaiverModel->insert($feewaiveData);
                                        }
                                    } else if ($dataFeetype == 2) {
                                        $examDate = $examDateModel->getDateInfoByAdmitCardStatus($student_details['academic_id'], $data['term_id']);
                                        if (empty($examDate['id'])) {
                                            $this->_message('Please Create Exmination Dates.');
                                        }
                                        $feewaiveData['type'] = 2;
                                        $examFeeData = array(
                                            'student_id' => $student_details['student_id'],
                                            'year_exam' => Date("Y", strtotime($examDate['exam_date'])),
                                            'session_id' => $acaddetails['session'],
                                            'academic_year_id' => $student_details['academic_id'],
                                            'term_id' => $term_details['term_id'],
                                            'stu_name' => $student_details['stu_fname'],
                                            'fname' => $student_details['father_fname'],
                                            'date_of_birth' => $student_details['stu_dob'],
                                            'reg_no' => $student_details['reg_no'],
                                            'examination_id' => $student_details['exam_roll'],
                                            'examination_name' => Date("M-Y", strtotime($examDate['exam_date'])),
                                            'college_name' => "Patna Women's College",
                                            'created_date' => date('Y-m-d'),
                                            'u_id' => $student_details['stu_id'],
                                            'email' => $student_details['stu_email_id'],
                                            'phone' => $student_details['father_mobileno'],
                                            'payment_activation' => 1,
                                            'payment_status' => 1,
                                            'status' => 1,
                                            'exam_month_id' => $examDate['id']
                                        );
                                        $feeExist = $examFeeNonColModel->getPaymentByTermId($stu_id, $term_details['term_id']);
                                        if (!is_array($feeExist)) {
                                            $examFeeNonColModel->insert($examFeeData);
                                            $FeeWaiverModel->insert($feewaiveData);
                                        }
                                    } else if ($dataFeetype == 3) {
                                        $struct_id = $feeStructure->getStructId($student_details['academic_id']);
                                        $feeitems = new Application_Model_FeeStructureTermItems();
                                        if (!$struct_id) {
                                            $this->_refresh(5, '/academic/application/tuitionfees/type/view', 'Fee not prepared...');
                                        }
                                        $fee = $feeitems->getFee($struct_id, $data['term_id']);
                                        $accname = $fee;
                                        $fee = $this->mergData($fee, array('totalfee'), count($fee));
                                        $fee = array_filter($fee, function ($value) {
                                            return ($value !== null && $value !== false && $value !== '' && $value != 0);
                                        });
                                        $sem2 = array_sum($fee);
                                        $feeamount = $sem2;
                                        $feewaiveData['type'] = 3;
                                        $FeeWaiverModel->insert($feewaiveData);
                                        $insertdata = array(
                                            'batch' => $acaddetails['short_code'],
                                            'name' => $student_details['stu_fname'],
                                            'class_roll' => $student_details['roll_no'],
                                            'exam_id' => $student_details['exam_roll'],
                                            'department' => $acaddetails['department'],
                                            'phone' => $student_details['father_mobileno'],
                                            'email' => $student_details['stu_email_id'],
                                            'semester' => $data['term_id'],
                                            'fee' => $feeamount,
                                            'stu_id' => $student_details['stu_id'],
                                            'due_amount' => 0,
                                            'submit_date' => date('Y-m-d'),
                                            'type' => 'Fee Waive',
                                            'description' => 'Fee Waive',
                                            'f_code' => 'Ok',
                                            'status' => 1,
                                            'mmp_txn' => 'FeeWaive'
                                        );
                                        $feeExist = $tuitionfeesModel->getRecordbyFidTermid($stu_id, $feewaiveData['cmn_terms']);
                                        if (!is_array($feeExist)) {
                                            $tuitionfeesModel->insert($insertdata);
                                            $FeeWaiverModel->insert($feewaiveData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                 break;
                default:
                     $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                    $waivestudents = $FeeWaiverModel->getRecords();
                     $page = $this->_getParam('page', 1);
                  $paginator_data = array(
                  'page' => $page,
                  'result' => $waivestudents
                  );
                  $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function _mime_content_type($filename) {
        $result = new finfo();

        if (is_resource($result) === true) {
            return $result->file($filename, FILEINFO_MIME_TYPE);
        }

        return false;
    }

    //Modified by Kedar : 07 Oct 2020
    public function formStudentAction() {

        $this->view->action_name = 'formStudent';

        $this->view->sub_title_name = 'formStudent';

        $this->accessConfig->setAccess('SA_ACAD_STUD');

        $razor = new Application_Model_ApplicantPaymentDetailModel();

        $academic_year_form = new Application_Form_AcademicYear();
        $this->view->form = $academic_year_form;

        $id = $this->_getParam("id");

        $type = $this->_getParam("type");

        $this->view->type = $type;

        switch ($type) {

            case 'students':
                $result = $razor->getRecordByCouse($id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;

            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $application = new Application_Model_EntranceExamScheduleModel();

                /* $result = $razor->getRecords();
                  //echo "<pre>";print_r($result);exit;

                  $page = $this->_getParam('page', 1);
                  paginator_data = array(
                  'page' => $page,
                  'result' => $result
                  );
                  $this->view->paginator = $this->_act->pagination($paginator_data);

                 */
                break;
        }
    }

    public function ajaxGetRecordByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $razor = new Application_Model_ApplicantPaymentDetailModel();
            $yearId = $this->_getParam("year_id");

            $result = $razor->getRecordByYearId($yearId);
            //  echo "<pre>";print_r($result);exit;

            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    //End 07 Oct
    //T.c. Certificate

    public function tcStudentListAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_TCLIST');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $student_report_form = new Application_Form_StudentsAdmitcard();
        $studentPortalModel = new Application_Model_StudentPortal();
        $type = $this->_getParam("type");
        $this->view->form = $student_report_form;

        if ($this->getRequest()->isPost()) {
            if (!empty($_POST['tc'])) {
                foreach ($_POST['tc'] as $value) {
                    $data['stu_status'] = 3;
                    $data['effective_date'] = $_POST['effective_date'];
                    $result = $studentPortalModel->update($data, array('stu_id=?' => $value
                    ));
                }
                $this->_redirect('student/tc-student-list');
            }
        }
    }

    //Date: 05 Oct 2020
    public function ajaxGetBatchBySessionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_Academic();
            $session = $this->_getParam("session");
            $result = $erpStudent_model->getBatchBySession($session);
            //echo '<pre>'; print_r($result); exit;
            echo "<option value = ''>--Select--</option>";
            foreach ($result as $key => $value) {
                echo "<option value='{$value["academic_year_id"]}'>{$value["short_code"]}</ >";
            }
        } die;
    }

    public function ajaxGetStudentForTcAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");

            if ($academic_id) {
                $erpStudent_model = new Application_Model_StudentPortal();
                $result = $erpStudent_model->getStudentsInfoByAcademicIdForTc($academic_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function tcStudentAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_TC');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $this->view->form = $student_report_form;
    }

    public function characterStudentAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_CHAR');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $this->view->form = $student_report_form;
    }

    public function passOutCertificateAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_CHAR');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        $passOutModel = new Application_Model_PassOutModel();
        //$academic_id = $this->_getParam("id");
        $this->view->form = $student_report_form;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "publish":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                    $student_ids = $data['stu_id'];
                    //echo '<pre>'; print_r($student_ids);exit;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            foreach ($student_ids as $key => $stu_id) {

                                $attendanceInfoData = array(
                                    'stu_id' => $data['stu_id'][$key],
                                    'academic_id' => $data['academic_year_id'],
                                    'type' => $data['type'],
                                    'stream' => $data['stream'],
                                    'session' => $data['session'],
                                    'pass_out_no' => $data['pass_out_no'][$key],
                                    'publish_date' => $data['publish_date'],
                                    'submit_date' => date('Y-m-d')
                                );
                                $insert_id = $passOutModel->insert($attendanceInfoData);
                            }
                            $this->_flashMessenger->addMessage('Result is published');
                            $this->_redirect('student/pass-out-certificate');
                        }
                    }
                }
                //echo '<pre>'; print_r($_POST);exit;
                break;
            case "download":
                break;
            default:
                break;
        }
        //echo '<pre>'; print_r($_POST); exit;
    }

    //For Addon Course
    public function addonSelectionAction() {
        $this->view->action_name = 'Addmission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_ICARD');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $this->view->form = $student_form;
        $student_model = new Application_Model_StudentPortal();
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        switch ($type) {


            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $batchModel = new Application_Model_Academic();
                $acad_id = $this->_getParam("acad_id");
                $record = $batchModel->getRecord($acad_id);
                $result = $student_model->getstudentsByStuStatus($acad_id);
                $this->view->paginator = $result;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->session = $record['session'];
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;
            default:
                break;
        }
    }

    //For Earned Credits: Kedar  : 04 March 2020
    public function earnedCreditsAction() {
        $this->view->action_name = 'gradeallocation';
        $this->view->sub_title_name = 'gradeallocation';
        $this->accessConfig->setAccess('SA_ACAD_EARNED_CREDITS');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $this->view->form = $student_form;
    }

    public function migrationStudentAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_CHAR');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $this->view->form = $student_report_form;
    }

    public function promotionStudentAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_PROMOTION');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("layout");
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $this->view->form = $student_report_form;
    }

    public function ajaxGetStudentInfoAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $result = $erpStudent_model->getStudenInfoByFormId($form_id);
            $this->view->resultData = $result;
        }
    }

    public function ajaxGetStudentInfoForCharAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $result = $erpStudent_model->getStudenInfoByFormId($form_id);
            $this->view->resultData = $result;
        }
    }

    public function ajaxGetStudentInfoForMigrationAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $result = $erpStudent_model->getStudenInfoByFormId($form_id);
            $this->view->resultData = $result;
        }
    }

    public function ajaxGetStudentInfoForPromotionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $term_id = $this->_getParam("term_id");
            $checkPromotionDocument = $erpStudent_model->checkPromotionDocumentWithStatus($form_id);
            //echo '<pre>'; print_r($checkPromotionDocument);exit;

            if (!empty($checkPromotionDocument)) {

                $this->view->promotionDownloadData = $checkPromotionDocument;
            } else {
                $result = $erpStudent_model->getStudenInfoByFormId($form_id, $term_id);
                if (!empty($result['batch'])) {
                    $this->view->resultData = $result;
                } else {
                    $result = 'not exists';
                    $this->view->resultData = $result;
                }
            }
        }
    }

    public function ajaxGetStudentInfoForMidTcAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $result = $erpStudent_model->getStudenInfoByFormId($form_id);
            $this->view->resultData = $result;
        }
    }

    public function ajaxGetStudentInfoForPassOutAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $result = $erpStudent_model->getStudenInfoByFormId($form_id);
            $this->view->resultData = $result;
        }
    }

    public function getStudentTcCardAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");

            if ($academic_id) {
                $erpStudent_model = new Application_Model_StudentPortal();
                $result = $erpStudent_model->getStudentsInfoByAcademicId($academic_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function getStudentMigCardAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");

            if ($academic_id) {
                $erpStudent_model = new Application_Model_StudentPortal();
                $result = $erpStudent_model->getStudentsInfoByAcademicId($academic_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function getStudentCharCardAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");

            if ($academic_id) {
                $erpStudent_model = new Application_Model_StudentPortal();
                $result = $erpStudent_model->getStudentsInfoByAcademicId($academic_id);
                $this->view->corecourseresult = $result;
            }
        }
    }

    //For Pass out student
    public function getStudentPassOutCardAction() {
        $this->_helper->layout->disableLayout();
        $passOut_model = new Application_Model_PassOutModel();
        $streamModel = new Application_Model_DepartmentType();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $stream = $this->_getParam("stream");
            $session = $this->_getParam("session");

            $acadModel = new Application_Model_Academic();
            $getDepartMent = $acadModel->getDepartment($academic_id);
            $getDegreeId = $streamModel->getDegreeOnStream($stream);

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
            if ($getDepartMent['department'] == 30 || $getDepartMent['session'] == 1 || $getDepartMent['session'] == 2)
                $maxCountCheck = 6;
            //echo '<pre>';print_r($maxCountCheck);exit;

            if ($stream) {
                $erpStudent_model = new Application_Model_StudentPortal();
                $result = $passOut_model->getStudentsForPassOut($stream, $session, $academic_id, $maxCountCheck);
                $this->view->corecourseresult = $result;
            }
        }
    }

    public function getStudentPassOutListAction() {
        $this->_helper->layout->disableLayout();
        $studentreport_model = new Application_Model_StudentReport();
        $passOutModel = new Application_Model_PassOutModel();
        $termMasterModel = new Application_Model_TermMaster();
        $streamModel = new Application_Model_DepartmentType();
        $result = $studentreport_model->getRecords();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_id");
            $type = $this->_getParam("type");
            $session = $this->_getParam("session");
            $stream = $this->_getParam("stream");
            $cmn_terms = $this->_getParam("cmn_terms");

            $acadModel = new Application_Model_Academic();
            $getDepartMent = $acadModel->getDepartment($academic_id);
            $getDegreeId = $streamModel->getDegreeOnStream($stream);

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
            if ($getDepartMent['department'] == 30 || $getDepartMent['session'] == 1 || $getDepartMent['session'] == 2)
                $maxCountCheck = 6;
            //echo '<pre>';print_r($maxCountCheck);exit;

            $getTermId = $termMasterModel->getTermRecordsbycmn($academic_id, $cmn_terms);

            if ($academic_id) {
                $erpStudent_model = new Application_Model_StudentPortal();
                $passOutNo = $passOutModel->checkforPassoutNo($session, $stream);
                //$checkExistedResult= $passOutModel->checkPublishedData($session,$stream,$type);
                //if(empty($checkExistedResult)){
                if ($type == 1) {
                    $result = $erpStudent_model->getStudentsInfoByAcademicIdForCollegiatePassOut($academic_id, $getTermId['term_id'], $maxCountCheck);
                } else {
                    $result = $erpStudent_model->getStudentsInfoByAcademicIdForNonCollegiatePassOut($academic_id, $getTermId['term_id'], $maxCountCheck);
                }
                $studentId = array();
                foreach ($result as $key => $value) {
                    $checkInPassout = $passOutModel->checkStudentId($value['student_id']);

                    if (empty($checkInPassout)) {
                        array_push($studentId, $value['student_id']);
                    } else {
                        $_SESSION['message'] = 'Student exists.';
                    }
                }
                //echo '<pre>'; print_r($studentId);

                if (empty($studentId)) {
                    $_SESSION['message'] = 'No Students found.';
                } else {
                    $studentData = $erpStudent_model->getStudentList($studentId);
                }


                $this->view->lastPassOutNo = $passOutNo['lastPassOutNo'];
                $this->view->corecourseresult = $studentData;
            }
        }
    }

    public function tcprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $stu_id = $this->_getParam("stu_id");
        $erpStudent_model = new Application_Model_StudentPortal();
        $applicantDetails = $erpStudent_model->getStudenInfoByFormId($stu_id);

        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($applicantDetails);exit;
        $this->view->paginator = $applicantDetails;
        $htmlcontent = $this->view->render('student/tcprint.phtml');
        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $applicantDetails['stu_fname'] . $applicantDetails['stu_id'], 'P', 150);
    }

    public function charprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $stu_id = $this->_getParam("stu_id");
        $erpStudent_model = new Application_Model_StudentPortal();
        $applicantDetails = $erpStudent_model->getStudenInfoByFormId($stu_id);

        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($applicantDetails);exit;
        $this->view->paginator = $applicantDetails;
        $htmlcontent = $this->view->render('student/charprint.phtml');

        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $applicantDetails['stu_fname'] . $applicantDetails['stu_id'], 'P', 150);
    }

    public function passoutprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $stu_id = $this->_getParam("stu_id");
        $duplicate = $this->_getParam("type");
        $cmn_terms = $this->_getParam("cmn_terms");

        $erpStudent_model = new Application_Model_StudentPortal();
        $trItemsModel = new Application_Model_TabulationReportItems();
        $exam_date_model = new Application_Model_ExamDateModel();
        $Grade_Model = new Application_Model_GradeAllocationItems();
        $term_Model = new Application_Model_TermMaster();
        $examDateModel = new Application_Model_ExamDateModel();
        $trModel = new Application_Model_TabulationReport();
        
        $applicantDetails = $erpStudent_model->getStudenInfoByFormIdForPassoutCert($stu_id);
        $termArr=$term_Model->getRecordByAcademicId($applicantDetails['academic_id']);
        $termIds=array();
        foreach ($termArr as $key => $value) {
          
        array_push($termIds,$value['term_id']);
        
        }
        $cmn_terms = '';
        switch ($applicantDetails['degree']) {
            case 1:
                $cmn_terms = 't6';
                break;
            case 2:
                $mcaThreeYrs = array("49", "50");
                if (in_array($applicantDetails['academic_id'], $mcaThreeYrs)) {
                    $cmn_terms = 't6';
                } else {
                    $cmn_terms = 't4';
                }
                break;
            case 3:
                $cmn_terms = 't4';
                break;
            case 4:
                $cmn_terms = 't2';
                break;
            case 5:
                $cmn_terms = 't2';
                break;
            case 6:
                $cmn_terms = 't2';
                break;
            default:
                break;
        }
        
         $added_date=$trItemsModel->getRecordByStudentId($applicantDetails['student_id'],$termIds);
        //echo '<pre>';print_r($added_date);exit;
        
        $requiredData = array(
            'acad_id' => $applicantDetails['academic_id'],
            'term' => $cmn_terms,
            'session' => $applicantDetails['session_id'],
            'exam_type' => 1
        );
    //echo '<pre>';print_r($requiredData);exit;
    $examinationDates = $examDateModel->getRecordByAcadId($requiredData);
        $revalD = date("Y-m-d", strtotime($added_date['reval_date']));
        $NonCollegiateD = $added_date['noncolligiate_date'];
    // echo '<pre>';print_r($added_date);exit;
    $finalDate = Date('Y-m-d', strtotime($examinationDates['result_publish_date']));
//    echo '<pre>';print_r($added_date); 
//    echo '<pre>';print_r($finalDate); 
//    exit;
   
        if (!empty($added_date['NonTblId']) || !empty($added_date['RevalTblId'])) {
            if (!empty($added_date['reval_date']) && $revalD > $NonCollegiateD) {

                $followupDate = $revalD;
                $cmnTerms = $trModel->getTermIdByTablId($added_date['RevalTblId']);
            } else {
                $followupDate = $NonCollegiateD;
                $cmnTerms = $trModel->getTermIdByTablId($added_date['NonTblId']);
            }
            $this->tabldetails['term_id'] = $cmnTerms['term_id'];
            // echo '<pre>';print_r($cmnTerms);exit;
            $revalDates = $examDateModel->getRevalDatesByAcadId($applicantDetails['academic_id'], $followupDate, $this->tabldetails['term_id']);

            

            if ($revalD > $NonCollegiateD) {
                $passOutDate = Date('d-m-Y', strtotime($revalDates['reval_date']));
               

            } else {

                $passOutDate = Date('d-m-Y', strtotime($revalDates['result_publish_date']));
               
            }
        } else {
            //echo '<pre>';print_r($examinationDates);exit;
            $passOutDate = Date('d-m-Y', strtotime($examinationDates['result_publish_date']));
            
         } 

        //echo '<pre>';print_r($passOutDate);exit;
        
        $marksDetails = $Grade_Model->getCGPAForStudent($applicantDetails['academic_id'],$stu_id);
        $applicantDetails['cgpa'] = $marksDetails['cgpa'];
        $applicantDetails['percent'] = $marksDetails['percentage'];
        // echo '<pre>';print_r($cmn_terms);exit;
        $getExamDate = $exam_date_model->getRecordByBatchAndTerm($applicantDetails['academic_id'], $cmn_terms);
        $applicantDetails['exam_month'] = $getExamDate['examination_month'];
        //echo '<pre>';print_r($applicantDetails);exit;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($applicantDetails);exit;
        $this->view->duplicate = $duplicate;
        $this->view->passOutDate = $passOutDate;
        $this->view->paginator = $applicantDetails;
        $htmlcontent = $this->view->render('student/passoutprint.phtml');

        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $applicantDetails['stu_fname'] . $applicantDetails['stu_id'], 'P', 150);
    }

    public function migrationprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $stu_id = $this->_getParam("stu_id");
        $erpStudent_model = new Application_Model_StudentPortal();
        $applicantDetails = $erpStudent_model->getStudenInfoByFormId($stu_id);

        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($applicantDetails);exit;
        $this->view->paginator = $applicantDetails;
        $htmlcontent = $this->view->render('student/migrationprint.phtml');
        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $applicantDetails['stu_fname'] . $applicantDetails['stu_id'], 'P', 150);
    }

    public function promotionprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $stu_id = $this->_getParam("stu_id");
        $erpStudent_model = new Application_Model_StudentPortal();
        $applicantDetails = $erpStudent_model->getStudenInfoByFormId($stu_id);

        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($applicantDetails);exit;
        $this->view->paginator = $applicantDetails;
        $htmlcontent = $this->view->render('student/promotionprint.phtml');
        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $applicantDetails['stu_fname'] . $applicantDetails['stu_id'], 'P', 150);
    }

    public function ajaxUpdateTcStatusAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $acd_id = $this->_getParam("academic_id");
            $form_id = $this->_getParam("form_id");
            if (!empty($acd_id)) {
                //echo '<pre>'; print_r('kk');exit;
                $data = array(
                    'stu_status' => 3,
                    'effective_date' => date('d/m/Y')
                );
                $result = $erpStudent_model->update($data, array(
                    'academic_id=?' => $acd_id,
                    'stu_status !=?' => 3
                ));
            }
            if (!empty($form_id)) {
                //echo '<pre>'; print_r('sm');exit;
                $data = array(
                    'stu_status' => 3,
                    'effective_date' => date('d/m/Y')
                );
                $result = $erpStudent_model->update($data, array(
                    'stu_id=?' => $form_id,
                    'stu_status !=?' => 3
                ));
                echo 'Record Updated Successfully';
            }
        }die;
    }

    public function ajaxUpdateMidTcAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $term = $this->_getParam("term");
            $form_id = $this->_getParam("form_id");
            $date = $this->_getParam("effective_date");
            $data = array(
                'leaving_sem' => $term,
                'effective_date' => $date
            );
            $result = $erpStudent_model->update($data, array(
                'stu_id=?' => $form_id
            ));
            echo 'Record Updated Successfully';
            //$this->view->resultData=$result;
        }die;
    }

    public function followUpPromotionCertStudentAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $checkPromotionDocument = $erpStudent_model->checkPromotionDocument($form_id);
            if (!empty($checkPromotionDocument)) {
                $result = $erpStudent_model->updatePromotionStudents($form_id);
                echo 'update';
            } else {
                $date = date('d/m/Y');
                $data = array(
                    'form_id' => $form_id,
                    'status' => 1,
                    'date' => $date
                );
                $result = $erpStudent_model->insertPromotionStudents($data);
                echo 'insert';
            }
        }die;
    }

    public function unblockFollowUpPromotionCertStudentAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $erpStudent_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $checkPromotionDocument = $erpStudent_model->checkPromotionDocument($form_id);
            if (!empty($checkPromotionDocument)) {
                $result = $erpStudent_model->updateBlockStatusPromotionStudents($form_id);
                echo 'update';
            }
        }die;
    }

    //End
    public function studentDetailsAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'student_detail';
        $this->accessConfig->setAccess('SA_ACAD_STUDENT_DETAIL');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $this->view->form = $student_form;
        $student_model = new Application_Model_StudentPortal();
        $type = $this->_getParam("type");
        $this->view->type = $type;

        switch ($type) {

            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $acad_id = $this->_getParam("acad_id");
                $result = $student_model->getstudentsByStuStatus($acad_id);
                //echo "<pre>";print_r($result);exit;
                $this->view->paginator = $result;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;
            case "downloads":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $stu_id = $this->_getParam("stu_id");
                $result = $student_model->getRecordbyUid($stu_id);
            
                $photoArr= explode("/", $result['filename']);
               
                $photo=$photoArr[3];
                $ext= explode('.', $photo);
                $downloadFile=$stu_id.'.'.$ext[1];
                //echo '<pre>';print_r($downloadFile); print_r($result);die;
                
                 if($photoArr[2] =='applicant_photo'){
                    $dirPath1 = realpath(APPLICATION_PATH . '/../public/images') .'/applicant_photo/';
                 
                 }else{
                    $dirPath1 = realpath(APPLICATION_PATH . '/../public/images') .'/student_pic/';
                 }
                $file= $dirPath1.$photo;
                 //echo '<pre>';print_r($file);die;
                //echo '<pre>';print_R(filesize($file));exit;
                if(file_exists($file)){
                    header("Content-type: image/jpg");
                    header('Content-Disposition: attachment; filename="'. basename($downloadFile).'"');
                    header("Content-Transfer-Encoding: binary"); 
                    header('Expires: 0');
                    header('Pragma: no-cache');
                    header("Content-Length: ". filesize($file));
                    readfile($file);
                    exit;
                }
                
                break;
            default:
                break;
        }
    }

    public function sectionAllotmentAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'section_allotment';
        $this->accessConfig->setAccess('SA_ACAD_SECTION_ALLOTMENT');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $this->view->form = $student_form;
        $sectionAllot_model = new Application_Model_SectionAllotment();
        $type = $this->_getParam("type");
        $this->view->type = $type;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {

            case "add":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $batchModel = new Application_Model_Academic();
                            $termModel = new Application_Model_TermMaster();
                            $batchAttendanceModel = new Application_Model_DailyAttendanceModel();
                            $getDept = $batchModel->getDepartment($data['academic_id'], $data['session']);
                            $getterm = $termModel->getTermName($data['term_id']);
                            //echo '<pre>'; print_r($getDept);exit;
//                        $checkExistedData= $batchAttendanceModel->checkAttendanceData($data['session'],$getterm['cmn_terms'],$getDept['department'],$data['section']);
//                        //echo '<pre>'; print_r($checkExistedData);exit;
//                        if(!empty($checkExistedData)){
//                            $_SESSION['message_class'] = 'alert-danger';
//                            $this->_flashMessenger->addMessage('Sorrry this Semester attendace is already marked. Now section allocation is not allowed.');
//                            $this->_redirect('student/section-allotment');  
//                        }

                            foreach ($data['stu_id'] as $key => $stu_id) {

                                $insertData = array(
                                    'academic_year_list' => $data['academic_year_list'],
                                    'session' => $data['session'],
                                    'term_id' => $data['term_id'],
                                    'academic_id' => $data['academic_id'],
                                    'stu_id' => $data['stu_id'][$key],
                                    'section' => $data['section']
                                );
                                //echo '<pre>'; print_r($insertData); exit;
                                $insert_id = $sectionAllot_model->insert($insertData);
                            }

                            unset($_SESSION["token"]);

                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Student Alloted Successfully added');
                            $this->_redirect('student/section-allotment');
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Invalid Token! Attendance Not added');
                            $this->_redirect('student/section-allotment');
                        }
                    }
                }

                break;
            case "edit":


                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    public function nonCreditAllotmentAction() {
        $this->view->action_name = 'studentinfo';
        $this->view->sub_title_name = 'credit_allotment';
        $this->accessConfig->setAccess('SA_ACAD_CREDIT_ALLOTMENT');
        $student_form = new Application_Form_StudentPortal($this->aeccConfig[0]);
        $this->view->form = $student_form;
        $sectionAllot_model = new Application_Model_SectionAllotment();
        $type = $this->_getParam("type");
        $this->view->type = $type;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {

            case "add":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $batchModel = new Application_Model_Academic();
                            $termModel = new Application_Model_TermMaster();
                            $batchAttendanceModel = new Application_Model_DailyAttendanceModel();
                            $getDept = $batchModel->getDepartment($data['academic_id'], $data['session']);
                            $getterm = $termModel->getTermName($data['term_id']);
                            //echo '<pre>'; print_r($getDept);exit;
//                        $checkExistedData= $batchAttendanceModel->checkAttendanceData($data['session'],$getterm['cmn_terms'],$getDept['department'],$data['section']);
//                        //echo '<pre>'; print_r($checkExistedData);exit;
//                        if(!empty($checkExistedData)){
//                            $_SESSION['message_class'] = 'alert-danger';
//                            $this->_flashMessenger->addMessage('Sorrry this Semester attendace is already marked. Now section allocation is not allowed.');
//                            $this->_redirect('student/section-allotment');  
//                        }

                            foreach ($data['stu_id'] as $key => $stu_id) {

                                $insertData = array(
                                    'academic_year_list' => $data['academic_year_list'],
                                    'session' => $data['session'],
                                    'term_id' => $data['term_id'],
                                    'academic_id' => $data['academic_id'],
                                    'stu_id' => $data['stu_id'][$key],
                                    'section' => $data['section']
                                );
                                //echo '<pre>'; print_r($insertData); exit;
                                $insert_id = $sectionAllot_model->insert($insertData);
                            }

                            unset($_SESSION["token"]);

                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Student Alloted Successfully added');
                            $this->_redirect('student/section-allotment');
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Invalid Token! Attendance Not added');
                            $this->_redirect('student/section-allotment');
                        }
                    }
                }

                break;
            case "edit":


                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    public function ajaxInsertCreditCourseAction() {
        $addonModel = new Application_Model_NonAcademicCreditCourseAllotmentModel();
        $addonCourseModel = new Application_Model_NonAcademicCourse();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $form_id = $this->_getParam("form_id");
            $course_id = $this->_getParam("course_id");
            //echo '<pre>'; print_r($course_id);exit;
            $update['status'] = 2;
            $addonModel->trashItems($form_id);

            if ($form_id) {
                foreach ($course_id as $val) {
                    $courseDetails = $addonCourseModel->getRecord($val);
                    //echo '<pre>'; print_r($courseDetails);exit;
                    $data['stu_id'] = $form_id;
                    $data['credit_course_id'] = $val;
                    $data['status'] = 0;
                    $addonModel->insert($data);
                }
                echo 'Added';die;
            }
            //$this->view->paginator =$applicant_data;
        }
    }

    public function ajaxGetStudentsByBatchForSectionAction() {
        $this->_helper->layout->disableLayout();
        $acad_id = $this->_getParam("batch");
        $term_id = $this->_getParam("term");
        $section = $this->_getParam("section");
        $student_model = new Application_Model_StudentPortal();
        $section_model = new Application_Model_SectionAllotment();
//        $checkExistedData= $section_model->checkBatchSection($acad_id,$term_id,$section);
//            //echo '<pre>'; print_r($checkExistedData);exit;
//            if(!empty($checkExistedData)){
//                echo "<b style='color:red'>Section already defined.</b>"; exit;
//            }
        $result = $student_model->getStudentDetailByAcadIdForSectionAllotment($acad_id, $term_id);
        $paginator_data = array(
            'page' => $page,
            'result' => $result
        );
        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }
    public function ajaxGetStudentsByBatchForCreditAction() {
        $this->_helper->layout->disableLayout();
        $acad_id = $this->_getParam("batch");
        $session = $this->_getParam("session");
        $student_model = new Application_Model_StudentPortal();
        $section_model = new Application_Model_SectionAllotment();
//        $checkExistedData= $section_model->checkBatchSection($acad_id,$term_id,$section);
//            //echo '<pre>'; print_r($checkExistedData);exit;
//            if(!empty($checkExistedData)){
//                echo "<b style='color:red'>Section already defined.</b>"; exit;
//            }
        $result = $student_model->getstudents($acad_id);
        $paginator_data = array(
            'page' => $page,
            'result' => $result
        );
        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
        $this->view->session = $session;
    }

    public function ajaxGetRecordByBatchForSectionAction() {
        $this->_helper->layout->disableLayout();
        $acad_id = $this->_getParam("batch");
        $section = $this->_getParam("section");
        $req_model = new Application_Model_SectionAllotment();
        $result = $req_model->getFilterRecord($acad_id, $section);
        $paginator_data = array(
            'page' => $page,
            'result' => $result
        );
        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }

//    public function ajaxUpdateStudentSectionAction(){
//       $this->_helper->layout->disableLayout();
//       
//        $acad_id = $this->_getParam("academic_id");
//        $session = $this->_getParam("session");
//        $student_id = $this->_getParam("student_id");
//        $section = $this->_getParam("SectionId");
//        $termId =  $this->_getParam("termId");
//        
//        $req_model = new Application_Model_SectionAllotment();
//        $acad_model = new Application_Model_Academic();
//        
//        $checkDailykAttendData= new Application_Model_DailyAttendanceModel();
//        $checkMonthlyAttendData= new Application_Model_BatchAttendance();
//        
//        $getDepartment= $acad_model->getDepartment($acad_id, $session);
//        echo '<pre>'; print_r($getDepartment);exit;
//        
//        $update_Data= array(
//            'section'=>$section
//        );
//        $updtaeSection=$req_model->update($update_Data, array(
//            "term_id=?" => $termId,
//            "stu_id=?" => $student_id,
//            ));
//        if($updtaeSection){
//            echo 'Success'; die;
//        }
//        
//      
//    }
    public function auto_generate_pdmid_cells_ex($batch_id, $short_code) {
        
        $academic_model = new Application_Model_Academic();
        $session_model = new Application_Model_Session();
        $erpStuModel= new Application_Model_StudentPortal();
        $session = $academic_model->getAcademicDegreeForSession($batch_id);
        $SessionString=$session_model->getRecord($session['session']);
        $sessionStrtYear= explode('-', $SessionString['session']);
       
        $maxId = $erpStuModel->getMaxId($sessionStrtYear[0]);
//        $getFormId=$erpStuModel->getStudenInfo($studentid_result);
//        $lastId= explode('-', $getFormId['stu_id']);
        
        $newId=(int)$maxId +1;
        
        $newFormId='F-'.$sessionStrtYear[0].'-'.$newId;
        
        return $newFormId;
    }

    public function ajaxGetMaxIdAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            $short_code = $this->_getParam("short_code");
            $id = $this->auto_generate_pdmid_cells_ex($batch_id, $short_code);
            //Changes by kedar 13 -09-2019
            echo $id;
            die;
        }
    }
    public function ajaxGetMaxRollAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            $short_code = $this->_getParam("short_code");
            
            $academic_model = new Application_Model_Academic();
            $dept_model = new Application_Model_Department();
            $session_model = new Application_Model_Session();
            $erpStuModel= new Application_Model_StudentPortal();
            $getDept= $academic_model->getDepartment($batch_id);
            $getDeptType=$dept_model->getRecord($getDept['department']);
            
            
            
            $maxRoll = $erpStuModel->getMaxRoll($getDeptType['department_type'],$getDept['academic_year']);
            //echo '<pre>'; print_r($maxRoll);exit;

            $RollNo=(int)$maxRoll +1;
            echo $RollNo;
            die;
        }
    }

    public function fetchDiscontinuedStudentDetailAction() {
        $this->_helper->layout->disableLayout();
        $stu_id = $this->_getParam("participant_id");
        $student_model = new Application_Model_StudentPortal();
        $stu_pre_detail = $student_model->fetchDiscontinuedStudentDetailById($stu_id);
        if (is_array($stu_pre_detail) && !empty($stu_pre_detail)) {
            echo json_encode($stu_pre_detail);
        } else {
            echo '0';
        }
        exit;
    }

    //===========[STUDENT DASHBOARD]=================//
    //================[RESULT COMMAND]==============//
    public function resultAction() {
        $this->view->action_name = 'result';
        $this->view->sub_title_name = 'Student Result';
        $student_model = new Application_Model_StudentPortal();
        $student_form = new Application_Form_StudentPortal();
        $participant_model = new Application_Model_ParticipantsLogin();
        $alumni_model = new Application_Model_Alumni();
        $student_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    
                }
                break;
            case 'edit':
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecord($student_id);
                $alumni_detail = $student_model->getAlumniDetail($student_id);
                $this->view->alumni_detail = $alumni_detail;
                $student_form->populate($result);
                // print_r($result);exit;
                $this->view->result = $result;

                break;
            case 'delete':
                $data['status'] = 2;

                break;

            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecords();
                //echo "<prE>";print_r($result);exit;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //====================[ATTENDANCE COMMAND]============//    

    public function attendanceAction() {
        $this->view->action_name = 'attendance';
        $this->view->sub_title_name = 'Student Attendance';
        $atendence_saver_model = new Application_Model_Attendance();
        $employee_model = new Application_Model_HRMModel();
        $present = 0;
        $absent = 0;
        $leave = 0;
        $result = $atendence_saver_model->getRecordByStudentId($_SESSION['admin_login']['admin_login']->student_id);

        foreach ($result as $key => $value) {
            if ($result[$key]['class_1'] != '0' && $result[$key]['class_1'] != 'Absent' && $result[$key]['class_1'] != 'Leave') {
                $present += 1;
            } else if ($result[$key]['class_1'] == 'Absent') {
                $absent += 1;
            } else if ($result[$key]['class_1'] == 'Leave') {
                $leave += 1;
            }



            if ($result[$key]['class_2'] != '0' && $result[$key]['class_2'] != 'Absent' && $result[$key]['class_2'] != 'Leave') {
                $present += 1;
            } else if ($result[$key]['class_2'] == 'Absent') {
                $absent += 1;
            } else if ($result[$key]['class_2'] == 'Leave') {
                $leave += 1;
            }


            if ($result[$key]['class_3'] != '0' && $result[$key]['class_3'] != 'Absent' && $result[$key]['class_3'] != 'Leave') {
                $present += 1;
            } else if ($result[$key]['class_3'] == 'Absent') {
                $absent += 1;
            } else if ($result[$key]['class_3'] == 'Leave') {
                $leave += 1;
            }


            if ($result[$key]['class_4'] != '0' && $result[$key]['class_4'] != 'Absent' && $result[$key]['class_4'] != 'Leave') {
                $present += 1;
            } else if ($result[$key]['class_4'] == 'Absent') {
                $absent += 1;
            } else if ($result[$key]['class_4'] == 'Leave') {
                $leave += 1;
            }

            if ($result[$key]['class_5'] != '0' && $result[$key]['class_5'] != 'Absent' && $result[$key]['class_5'] != 'Leave') {
                $present += 1;
            } else if ($result[$key]['class_5'] == 'Absent') {
                $absent += 1;
            } else if ($result[$key]['class_5'] == 'Leave') {
                $leave += 1;
            }

            $result[$key]['faculty_1'] = $employee_model->getAllEmployee($result[$key]['faculty_1'])[0]['name'];
            $result[$key]['faculty_2'] = $employee_model->getAllEmployee($result[$key]['faculty_2'])[0]['name'];
            $result[$key]['faculty_3'] = $employee_model->getAllEmployee($result[$key]['faculty_3'])[0]['name'];
            $result[$key]['faculty_4'] = $employee_model->getAllEmployee($result[$key]['faculty_4'])[0]['name'];
            $result[$key]['faculty_5'] = $employee_model->getAllEmployee($result[$key]['faculty_5'])[0]['name'];
        }

        $result[0]['present'] = $present;
        $result[0]['absent'] = $absent;
        $result[0]['leave'] = $leave;
        $result[0]['total'] = $present + $absent + $leave;
        $result[0]['percent'] = round(($present / $result[0]['total']) * 100);
        $this->view->result = $result;
    }

    //==============[ASSIGNMENTS]==============//

    public function assignmentsAction() {
        $this->view->action_name = 'assignments';
        $this->view->sub_title_name = 'Student Assignments';
    }

    //------------- Added by Kedar 23 sept. 2019----------------//
    public function ajaxGetStudentBySessionAction() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $department_id = $this->_getParam("department_id");
            $degree_id = $this->_getParam("degree_id");

            /* if($degree_id){
              $department_model = new Application_Model_Department();
              $results = $department_model->getDepartmentByDegreeId($degree_id);
              foreach ($results as $k => $val) {
              //return $val;
              //echo "<pre>";print_r(substr($val));
              }
              //echo "<pre>"; print_r($results);
              } */

            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id, $department_id);

                foreach ($result as $key => $value) {

                    $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']);
                    // echo "<pre>";print_r([$key]['term_name']);exit;
                    $term_id = $term_master->getAcademicMinTerms($value['academic_id']);

                    $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);
                    if ($elective_insert_id)
                        $elective_res = $ElectiveItems_model->getGEAeccforTermOne($elective_insert_id,$value['student_id']);

                    $ge_model = new Application_Model_Ge();
                    $course = new Application_Model_Course();
                    $cor_dept = new Application_Model_Academic();
                    $dept_model = new Application_Model_Department();
                    //echo "<pre>";print_r($value['academic_id']);exit;
                    $dept = $cor_dept->getRecord($value['academic_id']);

                
                        
                    $result[$key]['dept_name'] = $dept_model->getRecord($dept['department'])['department'];
                        $result[$key]['ge_name'] = '--';
                        $result[$key]['aecc_name'] = '--';
                    if ($elective_insert_id && $elective_res) {
                        if($elective_res[0]['ge_id']!=5)
                        $result[$key]['ge_name'] = $ge_model->getRecord(explode(',',$elective_res[0]['ge_id']))['general_elective_name_ad'];
                        else
                        $result[$key]['aecc_name'] = $ge_model->getRecord(explode(',',$elective_res[0]['ge_id']))['general_elective_name_ad'];
                        
                        if($elective_res[0]['aecc'])
                        $result[$key]['aecc_name'] = $course->getRecord($elective_res[0]['aecc'])['course_name'];
                        
                    } 
                    //echo "<pre>";print_r($result);exit;
                }


                $this->view->paginator = $result;
            }
        }
    }

    public function ajaxGetStudentBySessionForCreditsAction() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $department_id = $this->_getParam("department_id");
            $degree_id = $this->_getParam("degree_id");

            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id, $department_id, $flag = 'A');
                //echo '<pre>';print_r($result);exit;
                $this->view->paginator = $result;
                $this->view->total_credit = $result[0]['credit_number'];
            }
        }
    }

    public function ajaxGetStudentByDeptAction() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $department_id = $this->_getParam("department_id");
            $degree_id = $this->_getParam("degree_id");

            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id, $department_id);
                $this->view->paginator = $result;
            }
        }
    }

    public function ajaxGetStudentBySession1Action() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $cc_id = 2;
            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id);

                //echo "<pre>";print_r($result);die;

                foreach ($result as $key => $value) {

                    $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']);
                    $term_id = $term_master->getAcademicMinTerms($value['academic_id']);

                    $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);
                    $student_all_course_result = $this->geStudentCourse($value['academic_id'], $term_id, $value['student_id']);
                    $cc_ids = $this->selectData($student_all_course_result, array('cc_id'), count($student_all_course_result));
                    $formated_course_output = $this->stackData($cc_ids, $student_all_course_result);

                    $Student_course_details = $formated_course_output[$cc_id];
                    $elective_res = $ElectiveItems_model->getItemsRecords($elective_insert_id);
                    $ge_model = new Application_Model_Ge();
                    $course = new Application_Model_Course();
                    $cor_dept = new Application_Model_Academic();
                    $dept_model = new Application_Model_Department();

                    $dept = $cor_dept->getRecord($value['academic_id']);

                    // echo "<pre>";print_r($dept['department']);exit;

                    $result[$key]['dept_name'] = $dept_model->getRecord($dept['department'])['department'];

                    //$result[$key]['ge_name'] = $ge_model->getRecord($elective_res[0]['ge_id'])['general_elective_name'];
                    //$result[$key]['ge_id'] = $ge_model->getRecord($elective_res[0]['ge_id'])['ge_id'];
                    $coursemaster = new Application_Model_Course();
                    $result[$key]['ge_name'] = !empty($Student_course_details[0]['course_id']) ? $coursemaster->getRecord($Student_course_details[0]['course_id'])['course_name'] : 'NA';
                    $result[$key]['ge_id'] = $Student_course_details[0]['course_id'];

                    //$result[$key]['aecc_name'] = $course->getRecord($elective_res[0]['aecc'])['course_name'];
                    //$result[$key]['aecc_id'] = $course->getRecord($elective_res[0]['aecc'])['course_id'];
                    // echo "<pre>";print_r($result);exit;
                    //echo "<pre>";print_r($result);exit;
                }


                $this->view->paginator = $result;
            }
        }
    }

    public function ajaxGetStudentBySession2Action() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            //======[CC_id is to be passed]
            $cc_id = 3;
            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id);

                //echo "<pre>";print_r($result);die;

                foreach ($result as $key => $value) {

                    $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']);
                    $term_id = $term_master->getAcademicMinTerms($value['academic_id']);

                    $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);

                    $student_all_course_result = $this->geStudentCourse($value['academic_id'], $term_id, $value['student_id']);
                    $cc_ids = $this->selectData($student_all_course_result, array('cc_id'), count($student_all_course_result));
                    $formated_course_output = $this->stackData($cc_ids, $student_all_course_result);

                    $Student_course_details = $formated_course_output[$cc_id];
                    $elective_res = $ElectiveItems_model->getItemsRecords($elective_insert_id);
                    $ge_model = new Application_Model_Ge();
                    $course = new Application_Model_Course();
                    $cor_dept = new Application_Model_Academic();
                    $dept_model = new Application_Model_Department();

                    $dept = $cor_dept->getRecord($value['academic_id']);

                    // echo "<pre>";print_r($dept['department']);exit;

                    $result[$key]['dept_name'] = $dept_model->getRecord($dept['department'])['department'];

                    $result[$key]['ge_name'] = $ge_model->getRecord($elective_res[0]['ge_id'])['general_elective_name'];
                    // $result[$key]['ge_id'] = $ge_model->getRecord($elective_res[0]['ge_id'])['general_elective_name'];


                    $coursemaster = new Application_Model_Course();
                    $result[$key]['aecc_name'] = !empty($Student_course_details[0]['course_id']) ? $coursemaster->getRecord($Student_course_details[0]['course_id'])['course_name'] : 'NA';
                    $result[$key]['aecc_id'] = $Student_course_details[0]['course_id'];

                    // echo "<pre>";print_r($result);exit;
                    //echo "<pre>";print_r($result);exit;
                }
                $this->view->paginator = $result;
            }
        }
    }

    public function geStudentCourse($academic_id, $term_id, $stu_id) {
        $Corecourselearning_model = new Application_Model_Corecourselearning();
        $core_courses = $Corecourselearning_model->getcorecourse($academic_id, $term_id);
        $student_ge = $Corecourselearning_model->getStudentGE($academic_id, $term_id, $stu_id);
        $course_type_result = array_merge($core_courses, $student_ge);
        return $course_type_result;
    }

    public function ajaxGetStudentBySession3Action() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $cc_id = 1;
            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id);

                //echo "<pre>";print_r($result);die;

                foreach ($result as $key => $value) {

                    $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']);
                    $term_id = $term_master->getAcademicMinTerms($value['academic_id']);

                    $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);

                    $student_all_course_result = $this->geStudentCourse($value['academic_id'], $term_id, $value['student_id']);
                    $cc_ids = $this->selectData($student_all_course_result, array('cc_id'), count($student_all_course_result));
                    $formated_course_output = $this->stackData($cc_ids, $student_all_course_result);
                    $Student_course_details = $formated_course_output[$cc_id];

                    $elective_res = $ElectiveItems_model->getItemsRecords($elective_insert_id);
                    $ge_model = new Application_Model_Ge();
                    $course = new Application_Model_Course();
                    $cor_dept = new Application_Model_Academic();
                    $dept_model = new Application_Model_Department();

                    $dept = $cor_dept->getRecord($value['academic_id']);

                    // echo "<pre>";print_r($dept['department']);exit;

                    $result[$key]['dept_name'] = $dept_model->getRecord($dept['department'])['department'];

                    // $result[$key]['ge_name'] = $ge_model->getRecord($elective_res[0]['ge_id'])['general_elective_name'];
                    // $result[$key]['aecc_name'] = $course->getRecord($elective_res[0]['aecc'])['course_name'];
                    // echo "<pre>";print_r($result);exit;
                    //echo "<pre>";print_r($result);exit;
//                      $coursemaster = new Application_Model_Course();
//                    $result[$key]['dept_name'] = !empty($Student_course_details[0]['course_id'])?$coursemaster->getRecord($Student_course_details[0]['course_id'])['course_name']:'NA';
//                    $result[$key]['core_id'] = $Student_course_details[0]['course_id'];
                }


                $this->view->paginator = $result;
            }
        }
    }

    //-------------------  End ---------------------------------//
    //===============[CLASS_SECHEDULE CODE GOES HERE]===========// 
    public function classScheduleAction() {
        $this->view->action_name = 'class-schedule';
        $this->view->sub_title_name = 'Student Batch Schedule';
        $student_model = new Application_Model_StudentPortal();
        $student_form = new Application_Form_StudentElement();
        $participant_model = new Application_Model_ParticipantsLogin();
        $alumni_model = new Application_Model_Alumni();
        $student_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    
                }
                break;
            case 'edit':
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecord($student_id);
                $alumni_detail = $student_model->getAlumniDetail($student_id);
                $this->view->alumni_detail = $alumni_detail;
                $student_form->populate($result);
                // print_r($result);exit;
                $this->view->result = $result;

                break;
            case 'delete':
                $data['status'] = 2;

                break;

            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //===========[FESS CODE GOES HERE]==============//
    public function feeStatusAction() {
        $this->view->action_name = 'fee-status';
        $this->view->sub_title_name = 'Student Fee Status';
        $student_model = new Application_Model_StudentPortal();
        $student_form = new Application_Form_StudentPortal();
        $participant_model = new Application_Model_ParticipantsLogin();
        $alumni_model = new Application_Model_Alumni();
        $student_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $student_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    
                }
                break;
            case 'edit':
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecord($student_id);
                $alumni_detail = $student_model->getAlumniDetail($student_id);
                $this->view->alumni_detail = $alumni_detail;
                $student_form->populate($result);
                // print_r($result);exit;
                $this->view->result = $result;

                break;
            case 'delete':
                $data['status'] = 2;

                break;

            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    ///=============[DMI HOLIDAY GOES HERE]===============// 
    public function holidayAction() {
        $this->view->action_name = 'holiday';
        $this->view->sub_title_name = 'Student Holiday';
        $holidayList = new Application_Model_DmiHoliday();
        $all_holiday = $holidayList->getHolidayList($this->holidayCategory[0]);

        $this->view->result = $all_holiday;
    }

    public function ajaxScheduleComponentsViewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            $batch_id = $this->_getParam('batch_id');

            $termDetails = new Application_Model_BatchSchedule();
            $result = $termDetails->getTermDetails($batch_id, $term_id);
            $allDetails = new Application_Model_BatchSchedule();
            $resultDetails = $allDetails->allDetail($batch_id, $term_id);
            $result['class_value'] = $resultDetails;

            //  $terms_count = strlen($result['term_name']);
            // $term_val = substr($result['term_name'],$terms_count-1);

            $course_result = $termDetails->getCourseDetails($batch_id, $term_id);
            $holidayList = new Application_Model_DmiHoliday();
            $all_holiday = $holidayList->getHolidayList($this->holidayCategory);
            //getting record from studentAttendance      
            //print_r($resultDetails);exit;
            $allRecordsFromStudentAttendance = new Application_Model_Attendance();
            $studentAttendance = $allRecordsFromStudentAttendance->getRecordByBatchAndTerm($term_id, $batch_id);
            $result['Attendance_result'] = $studentAttendance;
            //$holidayList = new Application_Model_DmiHoliday();
            //$all_holiday = $holidayList->getHolidayList();
            //  print($result['start_date']."_".$result['end_date']);
            $term_start = explode("/", $result['start_date']);
            $term_end = explode("/", $result['end_date']);
            //$start = strtr($result['start_date'], '/', '-');
            //$end = strtr($result['end_date'], '/', '-');
            $start = $term_start[2] . "-" . $term_start[1] . "-" . $term_start[0];
            $end = $term_end[2] . "-" . $term_end[1] . "-" . $term_end[0];
            // print($start."_".$end);
            // print_r($end);exit;
            // $start = date("Y-m-d", strtotime($start));
            // $end = date("Y-m-d", strtotime($end));
            $result['day_diff'] = $this->date_diff2($start, $end);
            //echo $result['day_diff'];exit;
            $result['course_result'] = $course_result;
            $result['holidays'] = $all_holiday;
            $this->view->result = $result;
        }
    }

    function date_diff2($date1 = '', $date2 = '') {


        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff ) / (60 * 60 * 24));
        return (int) $days;
    }

    public function ajaxGetStudentsByBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            if ($batch_id) {
                $StudentPortal_model = new Application_Model_StudentPortal();
                $students = $StudentPortal_model->getDistincetStudentsByBatchId($batch_id);

                echo '<option value="">Select </option>';
                foreach ($students as $k => $val) {
                    echo '<option value="' . $val['stu_id'] . '" >' . $val['students'] . ' (' . $val['stu_id'] . ')</option>';
                }
            }
        }
        die;
    }

    //==============[GET GE COURSES]===================//      
    public function Action() {
        $geCourseDb = new Application_Model_Aeccge();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $ge_id = $this->_getParam("ge_id");
            $result = $geCourseDb->getRecordByGe($ge_id);
            if (empty($result)) {
                echo 0;
                die;
            }
            echo "<option value =''>--Select--</option>";
            foreach ($result as $key => $value) {
                echo "<option value='{$value['course_id']}'>{$value['course_name']}</option>";
            }die;
        }
    }

    //=====================[END]======================//
    //============[Feed BAck Action]==========//

    public function feedBackAction() {
        $this->view->action_name = 'FeedBack';
        $this->view->sub_title_name = 'Student FeedBack';
        $student_feed_form = new Application_Form_StudentFeedElement();
        $student_feed_model = new Application_Model_StudentFeed();
        $instructor_feed = new Application_Model_InstructorFeed();
        $this->view->form = $student_feed_form;

        if ($this->getRequest()->isPost()) {
            if ($this->getRequest()->getPost()) {
                $data['course'] = $this->getRequest()->getPost('course');
                $data['instructor'] = $this->getRequest()->getPost('instructor');
                $data['batch'] = $this->getRequest()->getPost('batch');
                $data['term'] = $this->getRequest()->getPost('term');
                $len = $this->getRequest()->getPost('count');
                $len1 = $this->getRequest()->getPost('count1');
                $bool = $student_feed_model->hasRated($_SESSION['admin_login']['admin_login']->student_id, $data['course'], $data['term'], $data['batch']);
                $bool1 = $instructor_feed->hasRated($_SESSION['admin_login']['admin_login']->student_id, $data['instructor'], $data['term'], $data['batch']);

                if ($bool == 0) {
                    for ($i = 1; $i <= count($len); $i++) {
                        $arr = explode("-", $this->getRequest()->getPost("rate_$i"));
                        $data['feed'] = $arr[1];
                        $data['question_no_c'] = $arr[0];
                        $data['student_id'] = $_SESSION['admin_login']['admin_login']->student_id;
                        $student_feed_model->insert($data);
                    }
                }

                if ($bool > 0) {
                    for ($i = 1; $i <= count($len); $i++) {
                        $arr = explode("-", $this->getRequest()->getPost("rate_$i"));
                        $data['feed'] = $arr[1];
                        $data['question_no_c'] = $arr[0];
                        $data['student_id'] = $_SESSION['admin_login']['admin_login']->student_id;
                        $student_feed_model->update($data, array('student_id =?' => $_SESSION['admin_login']['admin_login']->student_id, 'course=?' => $data['course'], 'question_no_c=?' => $arr[0], 'term=?' => $data['term'], 'batch=?' => $data['batch']));
                    }
                }


                if ($bool1 > 0) {
                    for ($i = 1; $i <= count($len1); $i++) {
                        $arr = explode("-", $this->getRequest()->getPost("rate_I$i"));
                        $data['feed'] = $arr[1];
                        $data['question_no_c'] = $arr[0];
                        $data['student_id'] = $_SESSION['admin_login']['admin_login']->student_id;
                        $instructor_feed->update($data, array('student_id =?' => $_SESSION['admin_login']['admin_login']->student_id, 'instructor=?' => $data['instructor'], 'question_no_c=?' => $arr[0], 'term=?' => $data['term'], 'batch=?' => $data['batch']));
                    }
                }


                if ($bool1 == 0) {
                    for ($i = 1; $i <= count($len1); $i++) {
                        $arr = explode("-", $this->getRequest()->getPost("rate_I$i"));
                        $data['feed'] = $arr[1];
                        $data['question_no_c'] = $arr[0];
                        $data['student_id'] = $_SESSION['admin_login']['admin_login']->student_id;
                        $instructor_feed->insert($data);
                    }
                }
            }
        }
    }

    public function ajaxGetCourseAction() {
        $course_details = new Application_Model_Attendance();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            $batch_id = $this->_getParam('academic_year_id');
            $result = $course_details->getCourseDetails($term_id, $batch_id);
            //  print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $value) {
                echo '<option value="' . $value['course_id'] . '" >' . $value['course_code'] . '</option>';
            }
        }die;
    }

    public function ajaxGetSemesterBySessionAction() {
        $course_details = new Application_Model_TermMaster();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam('session_id');
            $result = $course_details->getRecordByAcademicId($batch_id);
            //  print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $value) {
                echo '<option value="' . $value['term_id'] . '" >' . $value['term_name'] . '</option>';
            }
        }die;
    }

    public function ajaxGetCourseBySemesterAction() {
        $course_details = new Application_Model_Corecourselearning();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam('session_id');
            $term_id = $this->_getParam('semester_id');
            $result = $course_details->getcorecourses($batch_id, $term_id);
            //  print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $value) {
                echo '<option value="' . $value['course_id'] . '" >' . $value['course_name'] . '</option>';
            }
        }die;
    }

    public function ajaxGetCoreidByCourseidAction() {
        $course_detail = new Application_Model_Corecourselearning();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam('course_id');
            $result = $course_detail->getcorecoursesid($term_id);
            //print_r($result);exit;

            foreach ($result as $value) {
                echo $value['cc_id'];
            }
        }die;
    }

    public function ajaxGetFacultyAction() {
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

        echo '<option value="">Select</option>';

        if (count($empl_name) > 0) {
            foreach ($empl_name as $key => $value) {
                echo "<option value='" . $value['empl_id'] . "'>" . $value['name'] . "</option>";
            }die;
        }

        die;
    }

    public function ajaxGetRatingViewAction() {
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
            if (!empty($course_id)) {
                $result['course'] = $question_model->getAllQuestionByQuestionType1(1, $term_id, $batch_id);
            }
            if (!empty($instructor)) {
                $result['instructor'] = $question_model->getAllQuestionByQuestionType1(2, $term_id, $batch_id);
            }
            $i = 0;
            foreach ($result['course'] as $key => $value) {
                $arr = explode(',', $value['selected_question']);
                foreach ($arr as $key1 => $value1) {
                    $result['course'][$key]['questions'][$i++] = $question_model->getAllQuestionByQuestionType2(1, $value1);
                }
            }
            $i = 0;
            foreach ($result['instructor'] as $key => $value) {
                $arr = explode(',', $value['selected_question']);
                foreach ($arr as $key1 => $value1) {
                    $result['instructor'][$key]['questions'][$i++] = $question_model->getAllQuestionByQuestionType2(2, $value1);
                }
            }

            $result['course_value'] = $student_feed_model->ratedValue($_SESSION['admin_login']['admin_login']->student_id, $course_id, $term_id, $batch_id);
            $result['rating'] = $rating_model->getRecords1();

            $this->view->result = $result;
        }
    }

    public function ajaxGetRatingInstructorViewAction() {
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
            if (!empty($course_id)) {
                $result['course'] = $question_model->getAllQuestionByQuestionType1(1, $term_id, $batch_id);
            }
            if (!empty($instructor)) {
                $result['instructor'] = $question_model->getAllQuestionByQuestionType1(2, $term_id, $batch_id);
            }
            $i = 0;
            foreach ($result['course'] as $key => $value) {
                $arr = explode(',', $value['selected_question']);
                foreach ($arr as $key1 => $value1) {
                    $result['course'][$key]['questions'][$i++] = $question_model->getAllQuestionByQuestionType2(1, $value1);
                }
            }
            $i = 0;
            foreach ($result['instructor'] as $key => $value) {
                $arr = explode(',', $value['selected_question']);
                foreach ($arr as $key1 => $value1) {
                    $result['instructor'][$key]['questions'][$i++] = $question_model->getAllQuestionByQuestionType2(2, $value1);
                }
            }
            $result['instructor_value'] = $instructor_feed->ratedValue($_SESSION['admin_login']['admin_login']->student_id, $instructor, $term_id, $batch_id);

            $result['rating'] = $rating_model->getRecords1();

            $this->view->result = $result;
        }
    }

    //PROGRAM DESIGN VIEW


    public function gradeSheetAction() {
        $this->view->action_name = 'GradeSheet';
        $this->view->sub_title_name = 'Student GradeSheet';
    }

    public function ajaxGradeSheetAction() {
        $this->view->close = '';
        $check = '';
        $stu_id = $this->_getParam("id");

        $academic_id = $this->_getParam("acd_id");

        $year_id = $this->_getParam("year");
        $term_id = $this->_getParam("term");
        $this->view->term_id = $term_id;
        $this->view->year_id = $year_id;

        $student_model = new Application_Model_StudentPortal();
        $stu_pre_details = $student_model->fetchDiscontinuedBatchesOfStudent($stu_id);

        if (is_array($stu_pre_details) && !empty($stu_pre_details)) {
            //Find out all Batch Id and student id in each batch
            $batch_arr = array();
            $student_ids = array();
            $student_first_batch = array(); //It will store student detail of First Batch
            $stu_pre_details1 = $student_model->fetchAllBatchesOfStudent($stu_id); //Fetching all batches detail of student
            foreach ($stu_pre_details1 as $row) {
                $batch_arr[] = $row['academic_id'];
                $student_ids[] = $row['student_id'];
                if (empty($student_first_batch)) {//Since, data is coming in ascending order of Student id, so the first row will be the detail of first batch of student
                    $student_first_batch = $row;
                }
            }
            $this->view->student_ids = $student_ids;
            $this->view->batch_arr = $batch_arr;
            ############################# [START] Fetching Experiential Courses and grades ####################################
            //Fetch all Experiential Learning Courses by Batch id and First/Second year
            $ExperientialLearning_model = new Application_Model_ExperientialLearning();
            $el_result1 = $ExperientialLearning_model->getExperRecordsByBatches($batch_arr, $year_id);
            /*
              $elc_ids = array();
              foreach($el_result1 as $row_el){
              $elc_ids[] = $row_el['elc_id'];
              }
             * 
             */

            //Fetch all grades of experiential learning courses
            $ExperientialGradeAllocation_model = new Application_Model_ExperientialGradeAllocation();
            $exp_course_grades_after_penalties = $ExperientialGradeAllocation_model->getExpGradesByBatches($batch_arr, $student_ids);
            $this->view->exp_course_grades_after_penalties = $exp_course_grades_after_penalties;
            //print_r($exp_course_grades_after_penalties);exit;
            //Filter only those Experiential Courses in which student appeared,
            $exp_course_result = array();
            foreach ($exp_course_grades_after_penalties as $row) {
                foreach ($el_result1 as $row_exp_course) {
                    if (($row_exp_course['elc_id'] == $row['course_id']) && ($row_exp_course['academic_year_id'] == $row['academic_id'])) {
                        $exp_course_result[] = $row_exp_course;
                    }
                }
            }
            //print_r($exp_course_result);exit;
            ############################# [END] Fetching Experiential Courses and grades ####################################        
            ############################# [START] Fetching Core Courses and grades ##########################################   
            //Select all Terms of First/Second year of Student. We will fetch all Terms of student from 'ourse_grade_after_penalties_items' table. If 'final_grade' column's value is ZERO, it meas student didn't appeared in the term and we will not fetch these rows.
            //Fetching list of all terms of all batches
            $TermMaster_model = new Application_Model_TermMaster();
            $term_result1 = $TermMaster_model->getTermsByBatchesYear($batch_arr, $year_id);
            $term_ids = array();
            foreach ($term_result1 as $row) {
                $term_ids[] = $row['term_id'];
            }

            $CourseGradeAfterpenalties_model = new Application_Model_CourseGradeAfterpenalties();
            $course_grades_after_penalties = $CourseGradeAfterpenalties_model->getStudentGradesByBatches($batch_arr, $term_ids, $student_ids);
            $this->view->course_grades_after_penalties = $course_grades_after_penalties;
            //Filter only those Terms in which student appeared,
            $term_result = array();
            foreach ($course_grades_after_penalties as $row) {
                foreach ($term_result1 as $row_term) {
                    if ($row_term['term_id'] == $row['term_id']) {
                        $term_result[] = $row_term;
                    }
                }
            }
            //print_r($term_result);exit;
            ############################# [END] Fetching Core Courses and grades #################################### 

            $Academic_model = new Application_Model_Academic();
            $academic = $Academic_model->getRecord($student_first_batch['academic_id']);
            $this->view->academic_data = $academic;

            $this->view->stu_id = $student_first_batch['stu_id'];
            $this->view->academic_id = $student_first_batch['academic_id'];
            $this->view->term_result = $term_result;
            $this->view->stu_result = $student_first_batch;

            $this->view->expr_result = $exp_course_result;
            if ($check != 'admin' && empty($this->view->term_id)) {
                //Genering New Number/Counter of Gradesheet to be added on top right corner of gradesheet
                $student_model1 = new Application_Model_StudentPortal();
                $student_detail1 = $student_model1->getRecord($stu_id);
                $GradeSheet_model = new Application_Model_GradeSheet();
                $gradesheet_number = $GradeSheet_model->getGradeSheetNumber($academic_id, $year_id, $student_detail1['stu_id']);
                $this->view->gradesheet_number = $gradesheet_number;
            }
            $htmlcontent = $this->view->render('report/secondyeargradesheetreport_discontinued_student.phtml');
            print_r($htmlcontent);
            exit;
            //Genering New Number/Counter of Gradesheet to be added on top right corner of gradesheet
            $student_model1 = new Application_Model_StudentPortal();
            $student_detail1 = $student_model1->getRecord($stu_id);
            $GradeSheet_model = new Application_Model_GradeSheet();
            $gradesheet_number = $GradeSheet_model->getGradeSheetNumber1($academic_id, $year_id, $student_detail1['stu_id']);
            $this->view->gradesheet_number = $gradesheet_number;
            $this->_act->generatePdf($pdfheader, $pdffooter, $htmlcontent, $student_first_batch['stu_fname'] . '-' . $academic['short_code'] . '- Second Year Grade Report Details');
        } else {

            $this->view->stu_id = $stu_id;
            $this->view->academic_id = $academic_id;

            $TermMaster_model = new Application_Model_TermMaster();
            $term_result = $TermMaster_model->getTerms($academic_id, $year_id);

            $this->view->term_result = $term_result;

            $studentreport_model = new Application_Model_StudentReport();
            $stu_result = $studentreport_model->getRecord($stu_id);
            $this->view->stu_result = $stu_result;

            $Academic_model = new Application_Model_Academic();
            $academic = $Academic_model->getRecord($academic_id);

            $this->view->academic_data = $academic;
            if ($check != 'admin' && empty($this->view->term_id)) {

                //Genering New Number/Counter of Gradesheet to be added on top right corner of gradesheet
                $student_model1 = new Application_Model_StudentPortal();
                $student_detail1 = $student_model1->getRecord($stu_id);

                $GradeSheet_model = new Application_Model_GradeSheet();
                $gradesheet_number = $GradeSheet_model->getGradeSheetNumber1($academic_id, $year_id, $student_detail1['stu_id']);

                $this->view->gradesheet_number = $gradesheet_number;
            }
            $htmlcontent = $this->view->render('report/secondyeargradesheetreport.phtml');
            print_r($htmlcontent);
            exit;
        }
    }

    public function ajaxGetExportBySessionAction() {

        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        $term_master = new Application_Model_TermMaster();
        $Elective_model = new Application_Model_ElectiveSelection();
        $course_credit_master = new Application_Model_Corecourselearning();
        $ElectiveItems_model = new Application_Model_ElectiveSelectionItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");

            if ($session_id) {

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getRecordsBySession($session_id);

                //echo "<pre>";print_r($result);die;

                foreach ($result as $key => $value) {

                    $result[$key]['term_name'] = $term_master->getAcademicMinTerms1($value['academic_id']);
                    $term_id = $term_master->getAcademicMinTerms($value['academic_id']);

                    $elective_insert_id = $Elective_model->getStudentSelectedElectivesId($value['academic_id'], $term_id, $value['student_id']);

                    $elective_res = $ElectiveItems_model->getItemsRecords($elective_insert_id);
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
                    //echo "<pre>";print_r($result);exit;
                }


                $this->view->paginator = $result;
            }
        }
    }

    //Summary:Get department list by degree and count of students in that department: Author : Kedar Kumar : 27 Nov 2020
    public function ajaxGetDeptWiseStudentCountAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            //print_r($short_code); die;
            $Academic_model = new Application_Model_Academic();
            $result = $Academic_model->getRecordBySession($session_id);
            $this->view->paginator = $result;
        }
    }

    public function ajaxGetDeptWiseStudentForAddonCourseAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            //print_r($short_code); die;
            $Academic_model = new Application_Model_Academic();
            $result = $Academic_model->getRecordBySession($session_id);
            $this->view->paginator = $result;
        }
    }

    //Update Transaction List: Kedar : 14 Dec 2020
    public function semesterFeeCollectionAction() {
        $this->view->action_name = 'SEMFEECOLL';
        $this->view->sub_title_name = 'SEMFEECOLL';
        $this->accessConfig->setAccess('SA_ACAD_SEMFEECOLL');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $studetails = new Application_Model_StudentPortal();
        $semFeeModel = new Application_Model_FeesCollection();
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $sem = $_POST['semester'];

                $semFeeDetails = $semFeeModel->getPayRecords(trim($_POST['stu_id']), $sem);
                //echo '<pre>'; print_r($semFeeDetails); exit;
                $studDetails = $studetails->getStudenInfoByStuIdForSemFee(trim($_POST['stu_id']));

                $this->view->stud_info = $studDetails;
                $this->view->pay_info = $semFeeDetails;
                $this->view->sem = $sem;
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
                //echo '<pre>'; print_r($submitDate); exit;
                $data = array(
                    'name' => $_POST['name'],
                    'stu_id' => $_POST['stu_id'],
                    'pay_mode' => $_POST['pay_mode'],
                    'exam_id' => $_POST['exam_id'],
                    'class_roll' => $_POST['class_roll'],
                    'batch' => $_POST['batch'],
                    'semester' => $_POST['semester'],
                    'department' => $_POST['department'],
                    'fee' => $_POST['fee'],
                    'pay_mode' => $_POST['pay_mode'],
                    'bank_name' => $_POST['bank_txn'],
                    'mmp_txn' => $_POST['mmp_txn'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'date' => date("l jS \of F Y h:i:s A"),
                    'description'=> $_POST['pay_mode'],
                    'submit_date' => $submitDate,
                    'f_code' => 'Ok',
                    'status' => 1
                );
                //echo '<pre>'; print_r($data); exit;
                $insertId = $semFeeModel->insert($data);
                $this->_flashMessenger->addMessage('Semester fees succesfully submited.');
                $this->_redirect('student/semester-fee-collection');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }

    //End Sem Form Payment
    public function formFeeCollectionAction() {
        $this->view->action_name = 'formFee';
        $this->view->sub_title_name = 'formFee';
        $this->accessConfig->setAccess('SA_ACAD_FORMFEECOLL');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $studetails = new Application_Model_StudentPortal();
        $semFeeModel = new Application_Model_ExamformSubmissionModel();
        $NonCollsemFeeModel = new Application_Model_UgNonformSubmissionModel();
        $semFeePayModel = new Application_Model_ExamfeeSubmitModel();
        $nonCollsemFeePayModel = new Application_Model_NonColpayment();
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $sem = $_POST['semester'];
                $examType = $_POST['examType'];

                $studDetails = $studetails->getStudenInfoByStuIdForSemFee(trim($_POST['stu_id']), $sem);

                if ($_POST['examType'] === 'ET-C') {
                    $formFeeDetails = $semFeeModel->getAllPaidRecordbyfid(trim($_POST['stu_id']), $sem);
                } else {
                    $formFeeDetails = $NonCollsemFeeModel->getPaymentRecordbyfid(trim($_POST['stu_id']), $sem);
                }


                //echo '<pre>';print_r($formFeeDetails);exit;

                $this->view->stud_info = $studDetails;
                $this->view->pay_info = $formFeeDetails;
                $this->view->sem = $sem;
                $this->view->examType = $examType;
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
              ///  echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    'student_id' => $_POST['student_id'],
                    'year_exam' => date('Y'),
                    'stu_name' => $_POST['name'],
                    'academic_year_id' => $_POST['academic_year_id'],
                    'session_id' => $_POST['session'],
                    'term_id' => $_POST['term_id'],
                    'stu_name' => $_POST['name'],
                    'fname' => $_POST['father_fname'],
                    'date_of_birth' => $_POST['stu_dob'],
                    'examination_id' => $_POST['exam_id'],
                    'examination_name' => $_POST['exam_month'],
                    'reg_no' => $_POST['reg_no'],
                    'college_name' => "Patna Women's college",
                    'created_date' => $submitDate,
                    'status' => 1,
                    'payment_status' => 1,
                    'u_id' => $_POST['stu_id'],
                    'payment_activation' => 1,
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'pay_mode' => $_POST['pay_mode'],
                    'exam_month_id' => $_POST['exam_month_id']
                     
                );
                //echo '<pre>'; print_r($data); exit;
                if ($_POST['examType'] === 'ET-C') {
                    //echo 'test cooll';die;
                    $insertId = $semFeeModel->insert($data);
                } else {
                    //echo 'test nc';die;
                    $data['non_collegiate_status'] = 1;
                    $insertId = $NonCollsemFeeModel->insert($data);
                }

                //echo '<pre>';print_r($insertId);exit;
                if ($insertId) {
                    $paymentData = array(
                        'stu_name' => $_POST['name'],
                        'u_id' => $_POST['stu_id'],
                        'acad_id' => $_POST['academic_year_id'],
                        'total_fee' => $_POST['fee'],
                        'exam_fee' => $_POST['fee'],
                        'late_fine' => !empty($_POST['late_fine']) ? $_POST['late_fine'] : '0',
                        'exam_id' => $_POST['exam_id'],
                        'mmp_txn' => $_POST['mmp_txn'],
                        'mer_txn' => $_POST['bank_txn'],
                        'bank_txn' => $_POST['bank_txn'],
                        'bank_name' => $_POST['bank_txn'],
                        'prod' => $_POST['email'],
                        'f_code' => 'Ok',
                        'clientcode' => 53243,
                        'merchant_id' => 53243,
                        'submit_date' => $submitDate,
                        'date' => $submitDate,
                        'payment_id' => $insertId,
                        'status' => 1,
                        'non_collegiate_status' => 0
                    );
                    //echo '<pre>'; print_r($paymentData); exit; $nonCollsemFeePayModel
                    if ($_POST['examType'] === 'ET-C') {
                        //echo 'test cooll';die;
                        $insertId = $semFeePayModel->insert($paymentData);
                    } else {
                        //echo 'test nc';die;
                        $insertId = $nonCollsemFeePayModel->insert($paymentData);
                    }
                }
                $this->_flashMessenger->addMessage('Form fees succesfully submited.');
                $this->_redirect('student/form-fee-collection');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }

    //End Sem Form Payment
    public function entranceFormFeeCollectionAction() {
        $this->view->action_name = 'EntranceFee';
        $this->view->sub_title_name = 'Entrance_Fee';
        $this->accessConfig->setAccess('SA_ACAD_ENTRANCEFEECOLL');
        $student_report_form = new Application_Form_StudentsAdmitcard();
        //$academic_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $studetails = new Application_Model_ApplicantCourseDetailModel();
        $this->view->type = $type;
        $this->view->form = $student_report_form;

        switch ($type) {

            case "view":

                $studDetails = $studetails->getAllFormFilledData(trim(md5($_POST['stu_id'])));
                //echo '<pre>'; print_r($studDetails); exit;

                $this->view->stud_info = $studDetails;

                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
                //echo '<pre>'; print_r($_POST); exit;
                $insertData = array(
                    'application_no' => $_POST['application_no'],
                    'applicant_name' => $_POST['name'],
                    'form_id' => $_POST['form_id'],
                    'payment_mode' => $_POST['pay_mode'],
                    'course' => $_POST['course'],
                    'form_fee' => $_POST['fee'],
                    'payment_mode' => $_POST['pay_mode'],
                    'email_id' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'college_account_name' => "",
                    'submit_date' => $submitDate,
                    'payment_status' => 1
                );

                $applicantPaymentDetailModel = new Application_Model_ApplicantPaymentDetailModel();
                $applicationrecord = new Application_Model_ApplicationFeesSubmit();
                $checkPrev = $applicantPaymentDetailModel->checkRow2($insertData['form_id']);

                if (!empty($checkPrev)) {
                    $this->_flashMessenger->addMessage('Payment Exists..');
                    $this->_redirect('student/entrance-form-fee-collection');
                    //echo '<pre>'; print_r($upsert); exit;
                } else {

                    $insertData['payment_status'] = 1;
                    if ($insertData['payment_status'] == 1) {
                        $generateRoll = $applicantPaymentDetailModel->checkCourseForRoll($insertData['course']);
                        //echo '<pre>';print_r($generateRoll) ;exit;
                        if ($generateRoll) {
                            $insertData['roll_no'] = 1 + $generateRoll['roll_no'];
                        } else {
                            $insertData['roll_no'] = 1;
                        }
                    }
                    // echo '<pre>'; print_r($data);exit;
                    $last_id = $applicantPaymentDetailModel->insert($insertData);
                    if ($last_id) {
                        $paymentData = array(
                            'application_id' => $insertData['application_no'],
                            'stu_name' => $insertData['applicant_name'],
                            'form_id' => $_POST['form_id'],
                            'exam_fee' => $_POST['fee'],
                            'mmp_txn' => $_POST['mmp_txn'],
                            'bank_name' => $_POST['bank_txn'],
                            'f_code' => 'Ok',
                            'submit_date' => date('Y-m-d'),
                            'prod' => 'PRINCIPAL_PWC',
                            'payment_id' => $last_id
                        );

                        $applicationrecord->insert($paymentData);
                    }
                }


                $this->_flashMessenger->addMessage('Entrance Form fees succesfully submited.');
                $this->_redirect('student/entrance-form-fee-collection');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }

    //End
    public function ajaxDeleteSemFeeDataAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $delete_id = $this->_getParam("delete_id");
            //print_r($short_code); die;
            $semFeeModel = new Application_Model_FeesCollection();
            $updateData = array(
                'status' => 0,
                'f_code' => 0
            );
            $updateId = $semFeeModel->update($updateData, array('id=?' => $delete_id));
            echo $updateId;
            die;
        }
    }

    public function ajaxDeleteFormFeeDataAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $delete_id = $this->_getParam("delete_id");
            $examType = $this->_getParam("examType");
            //print_r($short_code); die;
            if ($_POST['examType'] === 'ET-C') {
                $formFeeeeModel = new Application_Model_ExamformSubmissionModel();
                $updateData = array(
                    'status' => 0,
                    'payment_status' => 0
                );
                $updateId = $formFeeeeModel->update($updateData, array('id=?' => $delete_id));
            } else {
                $formFeeeeModel = new Application_Model_UgNonformSubmissionModel();
                $updateData = array(
                    'status' => 0,
                    'payment_status' => 0
                );
                $updateId = $formFeeeeModel->update($updateData, array('id=?' => $delete_id));
            }
            echo $updateId;
            die;
        }
    }
//Admission card from participant enrollment
    public function admissionCardAction() {

        $app_id = md5($this->_getParam("a_id"));
        //echo '<pre>';print_r($app_id);exit;
        $studentDetails = new Application_Model_StudentPortal();
        $geModel = new Application_Model_Ge();
        $applicantDetails = $studentDetails->getStudenFullInfo($app_id);
        // echo '<pre>';print_r($applicantDetails);exit;
        $geName=$geModel->getRecord($applicantDetails['ge_id']);
        //echo '<pre>';print_r($geName);exit;
        

        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->aecc = $applicantDetails['aecc'];
        $this->view->ge = $geName['general_elective_name'];
        $this->view->paginator = $applicantDetails;
    }
    public function feesUpdationAction() {
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

        switch ($type) {

            case "add":
                    $dirPath = realpath(APPLICATION_PATH . '/../public/images/').'/excelfile/';

                if ($this->getRequest()->getPost()) {
                  
                     $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
                   if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
                  
                     $name =$_FILES["file"]["name"];
                     $type= $_FILES["file"]["type"];
                     $size= $_FILES["file"]["size"];
                     $tmpname= $_FILES["file"]["tmp_name"];
                     $name1=$name.rand(100,1000);
                     if(file_exists($_FILES['file']['tmp_name'])){
                    if(!empty($name)){
                       // move_uploaded_file($tmpname, $dirPath . $name);
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $dirPath.$name1)) 
                    {   
                        $feesupdation->delete();
                    $csvFile = fopen($dirPath.$name1, 'r');
                     fgetcsv($csvFile);
                     $line = fgetcsv($csvFile);
                     //print_r($line);
                    // die();
                        while(($line = fgetcsv($csvFile)) !== FALSE){
                           
                          
                          $form_id   = $line[0];
                          $mmp_txn  = $line[1];
                          $mer_txn  = $line[2];
                          $bank_txn= $line[3];  
                          $bank_name  = $line[4];
                          $prod  = $line[5];
                          $date  = $line[6];
                          $f_code = $line[7]; 
                          $clientcode = $line[8]; 
			  $atm = $line[9]; 
						
                          
                          $insrtdata = array(
                          'form_id' => $form_id,  
                          'mmp_txn' =>  $mmp_txn , 
                          'mer_txn' => $mer_txn , 
                          'bank_txn' =>   $bank_txn,
                          'bank_name' =>  $bank_name, 
                          'prod' =>$prod ,
                          'date' => $date ,
                          'f_code' => $f_code ,
                          'clientcode'  =>  $clientcode,
			  'atom_amount' => $atm 
                         
                          );
                          
                          $insertId = $feesupdation->insert($insrtdata);
                        
                        }
                         
                     $this->_flashMessenger->addMessage('Form fees succesfully submited.');
                $this->_redirect('student/fees-updation');
                    }

                }
                }
                   }
                  }
                break;
            case "save":
                $splitdate = explode("/", $_POST['submit_date']);
                $submitDate = $splitdate[2] . "-" . $splitdate[1] . "-" . $splitdate[0];
              ///  echo '<pre>'; print_r($_POST); exit;
                $data = array(
                    'student_id' => $_POST['student_id'],
                    'year_exam' => date('Y'),
                    'stu_name' => $_POST['name'],
                    'academic_year_id' => $_POST['academic_year_id'],
                    'session_id' => $_POST['session'],
                    'term_id' => $_POST['term_id'],
                    'stu_name' => $_POST['name'],
                    'fname' => $_POST['father_fname'],
                    'date_of_birth' => $_POST['stu_dob'],
                    'examination_id' => $_POST['exam_id'],
                    'examination_name' => $_POST['exam_month'],
                    'reg_no' => $_POST['reg_no'],
                    'college_name' => "Patna Women's college",
                    'created_date' => $submitDate,
                    'status' => 1,
                    'payment_status' => 1,
                    'u_id' => $_POST['stu_id'],
                    'payment_activation' => 1,
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'pay_mode' => $_POST['pay_mode'],
                    'exam_month_id' => $_POST['exam_month_id']
                     
                );
                //echo '<pre>'; print_r($data); exit;
                if ($_POST['examType'] === 'ET-C') {
                    //echo 'test cooll';die;
                    $insertId = $semFeeModel->insert($data);
                } else {
                    //echo 'test nc';die;
                    $data['non_collegiate_status'] = 1;
                    $insertId = $NonCollsemFeeModel->insert($data);
                }

                //echo '<pre>';print_r($insertId);exit;
                if ($insertId) {
                    $paymentData = array(
                        'stu_name' => $_POST['name'],
                        'u_id' => $_POST['stu_id'],
                        'acad_id' => $_POST['academic_year_id'],
                        'total_fee' => $_POST['fee'],
                        'exam_fee' => $_POST['fee'],
                        'late_fine' => !empty($_POST['late_fine']) ? $_POST['late_fine'] : '0',
                        'exam_id' => $_POST['exam_id'],
                        'mmp_txn' => $_POST['mmp_txn'],
                        'mer_txn' => $_POST['bank_txn'],
                        'bank_txn' => $_POST['bank_txn'],
                        'bank_name' => $_POST['bank_txn'],
                        'prod' => $_POST['email'],
                        'f_code' => 'Ok',
                        'clientcode' => 53243,
                        'merchant_id' => 53243,
                        'submit_date' => $submitDate,
                        'date' => $submitDate,
                        'payment_id' => $insertId,
                        'status' => 1,
                        'non_collegiate_status' => 0
                    );
                    //echo '<pre>'; print_r($paymentData); exit; $nonCollsemFeePayModel
                    if ($_POST['examType'] === 'ET-C') {
                        //echo 'test cooll';die;
                        $insertId = $semFeePayModel->insert($paymentData);
                    } else {
                        //echo 'test nc';die;
                        $insertId = $nonCollsemFeePayModel->insert($paymentData);
                    }
                }
                $this->_flashMessenger->addMessage('Form fees succesfully submited.');
                $this->_redirect('student/form-fee-collection');

                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                break;
        }
    }
    
    
    
    public function ajaxGetStuDetailsAction() {
        $this->_helper->layout->disableLayout();
        $student_model = new Application_Model_StudentPortal();
        
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $reg_id = $this->_getParam("reg");
            

            if ($reg_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $student_model->getStudentsDetialsByRegNo($reg_id);
              // echo '<pre>';print_r($result);exit;
               echo json_encode($result);
              // echo $result;
                //$this->view->paginator = $result;
              
            }
        }die;
    }
}
