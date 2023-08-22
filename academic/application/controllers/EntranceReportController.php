<?php

//ini_set('display_errors', '1');
/*
  Author: Kedar Kumar
  Summary: This controller is used to handle The Entrance Report
  Date: 21 May 2019
 */

class EntranceReportController extends Zend_Controller_Action {

    private $_siteurl = null;
    private $_db = null;
    private $_flashMessenger = null;
    private $_authontication = null;
    private $_agentsdata = null;
    private $_usersdata = null;
    private $_act = null;
    private $_adminsettings = null;
    Private $_unit_id = null;
    private $login_storage = NULL;
    private $roleConfig = NULL;
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

    public function indexAction() {
        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_ENTRANCEREPORT');
        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        switch ($type) {

            case "edit":
                $academic_model = new Application_Model_Department();
                $department_model = new Application_Model_DepartmentType();
                $applicantCourseData = new Application_Model_ApplicantCourseDetailModel();
                //$Aeccge_course = new Application_Model_Aeccge();
                $session_id = $this->_getParam("s_id");

                $result = $academic_model->getCoreCourseByCourseId($edit_id, $session_id);

                $departmentName = $department_model->getIndividualDepartmentType($edit_id, $session_id);
                //echo '<pre>';print_r($departmentName);exit;
                foreach ($result as $key => $value) {
                    if ($session_id > 10) {

                        $pgCourseCount = $applicantCourseData->getRecordByindividualPgCourse($edit_id);
                        //echo '<pre>';print_r($pgCourseCount);exit;
                        $result[$key]['applied'] = $pgCourseCount['total'];
                    } else {

                        if ($edit_id == 10) {
                            //echo 'kk';exit;
                            $pgCourseCount = $applicantCourseData->getRecordByindividualPgCourse($edit_id);
                            $result[$key]['applied'] = $pgCourseCount['total'];
                        } else {
                            $coreCourseCount = $applicantCourseData->getRecordByindividualCourse($value['academic_year_id']);
                            //echo '<pre>';print_r($coreCourseCount);exit;
                            $result[$key]['caste'] = array(
                                'General' => $coreCourseCount['General'],
                                'BC-1(EBC)' => $coreCourseCount['BC-1(EBC)'],
                                'BC-2(OBC)' => $coreCourseCount['BC-2(OBC)'],
                                'EWS' => $coreCourseCount['EWS'],
                                'SC' => $coreCourseCount['SC'],
                                'ST' => $coreCourseCount['ST'],
                            );

                            $result[$key]['applied'] = $coreCourseCount['total'];
                            $result[$key]['max_seat'] = $coreCourseCount['max_seat'];
                            $result[$key]['Hindi'] = $coreCourseCount['Hindi'];
                            $result[$key]['English'] = $coreCourseCount['English'];
                        }
                    }//exit;
                }

                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);

                $this->view->department = $departmentName;

                break;

            default:
                
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetEntranceReportByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            $applicantCourseData = new Application_Model_SanctionSeatModel();
            $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
        }
    }

    //For Document verification Interface
    public function scrutinyAction() {

        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_SCRUTINY');

        $academic_year_form = new Application_Form_AcademicYear();

        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $acad_id = $this->_getParam("acad");
        $this->view->type = $type;
        $this->view->acad = $acad_id;
        switch ($type) {


            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $result = $paymentModel->getRecordByCouse($dept_id,$acad_id,true);
              //  echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                
                //echo '<pre>'; print_r($yearId);exit;
                $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
                //  echo '<pre>'; print_r($pgCourseCountData);exit;
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }
   public function admissionAction() {

          $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_APPLIEDAPPLICANTS');

        $academic_year_form = new Application_Form_AcademicYear();

        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        switch ($type) {


            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                  $acad_id = $this->_getParam("acad");
                $result = $paymentModel->getRecordByCouse($dept_id,$acad_id,true);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo '<pre>';print_r($result);die;
                $this->view->degree_id = $result[0]['degree_id'];
                $this->view->course_id = $result[0]['course'];
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;

            default:
                $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
       
    }
      public function ajaxGetAppliedAdmissonByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");

            $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
            $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
            $this->view->year_id = $yearId;
        }
    }
    public function ajaxGetAdmissionCardAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
             $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
             $geinfo = new Application_Model_Ge();
           
              $stu_id = $this->_getParam("stu_id");
                    
                $result = $paymentModel->getRecordByStuid($stu_id);
               // print_r($result);die();
                if($result)
                  $result['ge1'] = $geinfo->getRecord($result['ge1'])['general_elective_name'];
            
                echo json_encode($result);die;
        }
    }
  

    //ADD ON COURSE REPORT
   
public function addonCourseReportAction() {

        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AddonCourseReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_ADDONREPORT');

        $academic_year_form = new Application_Form_AddonCourse();
        $addonCourseData = new Application_Model_AddonCourseModel();
        $addonCourseItem = new Application_Model_AddonCourseItemModel();
        $academicYearModel = new Application_Model_AcademicYear();
        $HRMModel_model = new Application_Model_HRMModel();
        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $acad = $this->_getParam("acad");
        $this->view->type = $type;
        $messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
        $hoddetails = $HRMModel_model->getHodDetails();
        $this->view->hod = $hoddetails;
        switch ($type) {

            case "bulkadd":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                     $checkExistedData = $addonCourseItem->checkExistedData($data['academic_year']);
                   // echo '<pre>'; print_r($checkExistedData);exit;
                    if (empty($checkExistedData)) {
                     foreach ($data['name'] as $key => $name) {
                            $migData = array(
                            'academic_year' => $data['academic_year'],
                            'addon_mater_id' => $data['name'][$key],
                            'capacity' => $data['capacity'][$key],
                            'fee' => $data['fee'][$key],
                            'tot_credit'=>$data['tot_credit'][$key],
                            'status' => 0  
                            );
                            //echo "<pre>";print_r($migData);exit;
                            $addonCourseItem->insert($migData);
                    }
                     
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Addon Course Inserted Successfully added');
                        $this->_redirect('entrance-report/addon-course-report');
                   
                    }else {
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage('Deatils Already Exists! ');
                        $this->_redirect('entrance-report/addon-course-report');
                    }
                }



                break;
            case "add":
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                  //  echo '<pre>'; print_r($data);exit;
                    if (!empty($data['csrftoken'])) {

                        $insertData = array(
                            'name' => $data['name'],
                            'conductedby' => $data['conductedby'],
                            'code'=>$data['code'],
                            'status' => $data['status']
                        );
                        
                       $last_insert_id= $addonCourseData->insert($insertData);
                        
                         $insertItem = array(
                            'academic_year' => $data['academic_year'],
                            'addon_mater_id' => $last_insert_id,
                            'fee' => $data['fee'],
                            'capacity'=>$data['capacity'],
                            'tot_credit'=>$data['tot_credit'],
                            'empl_id' => $_POST['empl_id'],
                            'status' => $data['status']
                        );
                      if($addonCourseItem){
                       $last_insert_id= $addonCourseItem->insert($insertItem);
                      }
                      $name = trim($data['name']);
                      $name = preg_replace('/\s+/', '_', $name);
                      
                      $dirPath = realpath(APPLICATION_PATH . '/../public/images') . '/coordinator/'.$name.'/'.$_POST['empl_id'].'/';

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
                                    $file_data['filename'] = "/academic/public/images" . '/coordinator/'.$name.'/' .$_POST['empl_id'].'/'. $file_name[0];

                                    $addonCourseItem->update($file_data, array('id=?' => $last_insert_id));
                                } else {
                                    $this->_refresh(3, "/entrance-report/addon-course-report/type/edit/id/{$last_insert_id}/acad/".$data['academic_year'],'Invalid Image Extension Type  ..');
                                }
                            } else {
                                $this->_refresh(3, "/entrance-report/addon-course-report/type/edit/id/{$last_insert_id}/acad/".$data['academic_year'], 'This is not an Image ..');
                            }
                      
                        $this->_flashMessenger->addMessage('Addon Course Inserted Successfully added');
                        $this->_redirect('entrance-report/addon-course-report');
                    } else {
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage('Invalid Token! Not Added');
                        $this->_redirect('entrance-report/addon-course-report');
                    }
                }



                break;
            case "edit":
                $results = $addonCourseItem->getRecord($edit_id,$acad);
                $this->view->id = $edit_id;
               // echo "<pre>";print_r($results);exit;
                $this->view->empl_id = $results['empl_id'];
                $this->view->filename = $results['filename'];
                $academic_year_form->populate($results);

                $this->view->result = $results;
                if ($this->getRequest()->getPost()) {
                    $data = $this->getRequest()->getPost();
                    //echo '<pre>'; print_r($data);exit;
                    if (!empty($data['csrftoken'])) {
                        $data['empl_id'] = $_POST['empl_id'];
                        $updateData = array(
                            
                            'capacity' => $data['capacity'],
                            'tot_credit' => $data['tot_credit'],
                            'fee' => $data['fee'],
                            'empl_id'=> $data['empl_id'],
                            'status' => $data['status']
                        );
                        $name = trim($results['name']);
                      $name = preg_replace('/\s+/', '_', $name);
                        $dirPath = realpath(APPLICATION_PATH . '/../public/images') . '/coordinator/'.$name.'/'.$_POST['empl_id'].'/';

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
                                            $updateData['filename'] = "/academic/public/images" . '/coordinator/'.$name.'/'.$_POST['empl_id'].'/' . $file_name[0];

                                          $addonCourseItem->update($updateData, array('id=?' => $edit_id));
                                    } else {
                                        $this->_refresh(3, "/entrance-report/addon-course-report",'uploading an image file failed'); 
                                    }
                                 
                                } else {
                                    $this->_refresh(3, "/entrance-report/addon-course-report/type/edit/id/{$edit_id}/acad/$acad",'Invalid Image Extension Type  ..');
                                }
                            } else {
                                $this->_refresh(3, "/entrance-report/addon-course-report/type/edit/id/{$edit_id}/acad/$acad", 'This is not an Image ..');
                            }
                        

                        $this->_flashMessenger->addMessage('Addon Course Updated Successfully added');
                        $this->_redirect('entrance-report/addon-course-report');
                    } else {
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage('Invalid Token!  Not Updated');
                        $this->_redirect('entrance-report/addon-course-report');
                    }
                }
                break;

            case "getStudents":

                $dept_id = $this->_getParam("addon_id");
                $acad_id = $this->_getParam("acad");
                $this->view->id = $dept_id;
                $result = $addonCourseData->getRecordByAddonCourse($dept_id,$acad_id);
              //  echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $yearId = $academicYearModel->getAcadYearId();
                //echo '<pre>';print_r($yearId);exit;
                $CourseCountData = $addonCourseData->getAddonCourseCount($yearId['year_id']);
                $paidCourseCountData = $addonCourseData->getAddonCoursePaidCount($yearId['year_id']);
                foreach ($CourseCountData as $key => $value) {
                    
                   $CourseCountData[$key]['paid']= $paidCourseCountData[$key]['total_paid'];
                    
                }
                //echo '<pre>';print_r($paidCourseCountData); exit;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $CourseCountData
                );

                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->year=$yearId['academic_year'];
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;
        }
    }
    public function ajaxGetApplicantsByAddonStreamAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $stream = $this->_getParam("stream");
            $addonCourseData = new Application_Model_AddonCourseModel();
            $addOn_id = $this->_getParam("addonId");
            $result = $addonCourseData->getRecordByAddonStream($addOn_id, $stream);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    public function ajaxGetAddonCourseByYearAction() {
        $this->_helper->layout->disableLayout();
        $addonCourseData = new Application_Model_AddonCourseModel();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year");
                $CourseCountData = $addonCourseData->getAddonCourseCount($yearId);
                $paidCourseCountData = $addonCourseData->getAddonCoursePaidCount($yearId);
                foreach ($CourseCountData as $key => $value) {
                    
                   $CourseCountData[$key]['paid']= $paidCourseCountData[$key]['total_paid'];
                    
                }
               // echo '<pre>';print_r($CourseCountData); exit;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $CourseCountData
                );

                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    public function ajaxGetAddonCourseForMigAction() {
        $this->_helper->layout->disableLayout();
        $addonCourseData = new Application_Model_AddonCourseModel();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year");
                $CourseCountData = $addonCourseData->getAddonCourseCount($yearId);
              
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $CourseCountData
                );

                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    //END
    public function ajaxGetScrutinyApplicantsByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
            $academicYearModel = new Application_Model_AcademicYear();
            $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
            $this->view->year_id =  $yearId;
        }
    }

    //End
    //For principal interface
    public function verifiedStudentAction() {
        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_PRINCIPAL');

        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $sanction_seat_form = new Application_Form_SanctionedSeatMaster();
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("dept_id");
        $acad_id = $this->_getParam("acad");
        $this->view->type = $type;
        $this->view->form = $sanction_seat_form;
        $this->view->deptId = $edit_id;
        $this->view->year_id = $acad_id;
        $this->view->type = $type;
        switch ($type) {


            case "getDocumentVerifiedStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                
                $result = $paymentModel->getdocumentVerifiedRecordByCouse($dept_id,$acad_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllScrutinizedUgCourseCount($yearId);
                //echo"<pre>";print_r($ugCourseCountData);exit;
                $pgCourseCountData = $applicantCourseData->getAllScrutinizedPgCourseCount($yearId);
                // echo"<pre>";print_r($pgCourseCountData);exit;
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetVerifiedApplicantsByYearIdAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
            $academicYearModel = new Application_Model_AcademicYear();
            $ugCourseCountData = $applicantCourseData->getAllUgCourseCount1($yearId);
            $pgCourseCountData = $applicantCourseData->getAllPgCourseCountverified($yearId);
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
            $this->view->year_id = $yearId;
        }
    }

    //For Admission card
    public function admissionCardAction() {

        $app_id = $this->_getParam("a_id");
        $studentDetails = new Application_Model_SanctionSeatModel();
        $applicantDetails = $studentDetails->getStudentDetails($app_id);
       //echo "<pre>";print_r($applicantDetails);exit;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $applicantDetails;
    }

    //For Download I-Card
    public function icardprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $app_id = $this->_getParam("a_id");
        $studentDetails = new Application_Model_SanctionSeatModel();
        $applicantDetails = $studentDetails->getStudentDetails($app_id);
//echo "<pre>";print_r($applicantDetails);exit;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $applicantDetails
        );

        //echo"<pre>";print_r($applicantDetails);exit;
        $this->view->paginator = $applicantDetails;
        $htmlcontent = $this->view->render('entrance-report/icardprint.phtml');
        if ($check == 'admin' || $mode == 'view') {
            echo $htmlcontent;
            exit;
        }//======for PDF
        $this->_act->generateadmitcardPdf($pdfheader, $pdffooter, $htmlcontent, $applicantDetails['applicant_name'] . $applicantDetails['form_id'], 'P', 150);
    }

    public function appformprintAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->layout->setLayout("applicationlayout");
        $application_no = md5($this->_getParam("a_id"));

        $allFormData = new Application_Model_ApplicantCourseDetailModel();
        $paymentData = new Application_Model_ApplicantPaymentDetailModel();
        $formFilledData = $allFormData->getAllFormFilledData($application_no);
        //$paymentData = $paymentData->getsavedData($application_no);
        //echo '<pre>';print_r($formFilledData);exit;
        $this->view->paginator = $formFilledData;
        //$this->view->payment_detail = $paymentData;
    }

    //End


    public function generateSlipAction() {
        // $this->_helper->layout->disableLayout();
        //  if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $stu_id = $this->_getParam("form_id");
        //  echo $stu_id; die;
        $term_id = $this->_getParam("term_id");
        $prod = $this->_getParam("prod_id");
        $payment = new Application_Model_FeesCollection();
        $Academic_model = new Application_Model_Academic();
        $FeeCategory_model = new Application_Model_FeeCategory();
        $dept_type_details = new Application_Model_DepartmentType();
        $FeeHeads_model = new Application_Model_FeeHeads();
        //  $studetails = new Application_Model_StudentPortal();
        $dept_id_only = 0;

        $stu_details = new Application_Model_ApplicantCourseDetailModel();
        $FeeStructure_model = new Application_Model_FeeStructure();
        $dept = new Application_Model_Department();

        $StructureItems_model = new Application_Model_FeeStructureItems();

        $term_model = new Application_Model_TermMaster();

        $TermItems_model = new Application_Model_FeeStructureTermItems();

        // $details_stu = $studetails->getStudenacademicDetails($stu_id);
        $session_det = 0;
        $details_stu = $stu_details->getApplicationNumber($stu_id);
        if ($details_stu['core_course1'])
            $details_stu['academic_id'] = $details_stu['core_course1'];
        else {
            $dept_type = $details_stu['course'];
            $dept_details = $dept_type_details->getRecord($dept_type);

            $dept_id_only = $dept->getByDepartmentType($dept_type)['did'];

            $details_stu['academic_id'] = $Academic_model->getAcademicsBySD($dept_details['session_id'], $dept_id_only)['academic_year_id'];
            // echo "<pre>"; print_R(  $details_stu['academic_id']);exit;
        }

        $details_stu['semester'] = 't1';

        $acad_details = $Academic_model->getRecord($details_stu['academic_id']);
        $this->view->acad = $acad_details['academic_year'];
      //   echo "<pre>" ;print_r($acad_details);die;
        $deptname = $dept->getRecordbyAcademic($details_stu['academic_id']);
        //  echo "<pre>" ;print_r($details_stu)       ;die;
        $struct_id = $FeeStructure_model->getStructId($details_stu['academic_id']);
        if (!$struct_id) {
            echo "<div style='text-align:center;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);'>
     <img src='/academic/public//images/loader.gif' width='100px' class='loder_img1'> <br/>
     <b><span style='color:red;'>{$deptname['dpt_name']}</span> Fee is yet to be prepared..</b><br/><span style='color:green;'>This dialogue box will close in  5 sec...</span><div>";

            echo "<script type=\"text/javascript\" charset=\"utf-8\">setTimeout(function(){ window.self.close(); }, 7000);</script>";
            die;
        }

        $structure_id = $struct_id;
        // echo $structure_id; die;
        if ($structure_id) {

            $result = $TermItems_model->getItemRecordsByTerm($structure_id, $term_id);

            //    echo "<prE>";print_r($result);exit;

            $this->view->result = $result;
            $this->view->department = $deptname['dpt_name'];
            $result1 = $StructureItems_model->getStructureRecords($structure_id);
            $dept_id_only = $dept->getRecord($acad_details['department'])['department_type'];
            $this->view->result1 = $result1;
            $academic_id = $TermItems_model->getAcademicId($structure_id);
            $terms_data = $term_model->getRecordByAcademicId($academic_id['academic_id']);
            $degree_id = $Academic_model->getAcademicDegree($academic_id['academic_id']);
            $this->view->term_data = $terms_data;
            $this->view->structure_id = $structure_id;
            $this->view->details = $details_stu;
            $Category_data = $FeeCategory_model->getFeeCategory($degree_id, $prod, $acad_details['session'], $dept_id_only);
            $this->view->Category_data = $Category_data;
            $Feeheads_data = $FeeHeads_model->getFeeheads($degree_id, $acad_details['session'], $dept_id_only);
            $this->view->heads_data = $Feeheads_data;
            $this->view->prod = $prod;
            $this->view->session = $acad_details['session'];
            $htmlcontent = $this->view->render('entrance-report/generate-slip.phtml');
            echo $htmlcontent;
            exit;
        }
        //  }
    }

    //For Account interface
    public function approvedStudentsAction() {

        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_ACCOUNT');

        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $sanction_seat_form = new Application_Form_SanctionedSeatMaster();
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        $this->view->form = $sanction_seat_form;
        switch ($type) {

            case "edit":


                break;

            case "getPrincipalApprovedStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $result = $paymentModel->getapprovedRecordByCourse($dept_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $ugCourseCountData = $applicantCourseData->getAllApprovedUgCourseCount($yearId);
                //echo"<pre>";print_r($ugCourseCountData);exit;
                $pgCourseCountData = $applicantCourseData->getAllApprovedPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetApprovedApplicantsByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            $applicantCourseData = new Application_Model_SanctionSeatModel();
            $ugCourseCountData = $applicantCourseData->getAllApprovedUgCourseCount($yearId);
            //echo"<pre>";print_r($ugCourseCountData);exit;
            $pgCourseCountData = $applicantCourseData->getAllApprovedPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
        }
    }

    //End
    //For Payment Collection interface(Fee-Slip)
    public function paySlipGeneratedStudentsAction() {

        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_PAYMENT');

        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $sanction_seat_form = new Application_Form_SanctionedSeatMaster();
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        $this->view->form = $sanction_seat_form;
        switch ($type) {

            case "edit":


                break;

            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $result = $paymentModel->getSlipGeneratedRecordByCourse($dept_id,5);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getSlipGeneratedUgCourseCount($yearId);
                //echo"<pre>";print_r($ugCourseCountData);exit;
                $pgCourseCountData = $applicantCourseData->getSlipGeneratedPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetSlipGeneratedApplicantsByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            $applicantCourseData = new Application_Model_SanctionSeatModel();
            $ugCourseCountData = $applicantCourseData->getSlipGeneratedUgCourseCount($yearId);
            //echo"<pre>";print_r($ugCourseCountData);exit;
            $pgCourseCountData = $applicantCourseData->getSlipGeneratedPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
        }
    }

    //End
    //For paid applicant details
    public function applicantDetailsAction() {

        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_APPLICANTDETAILS');

        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        switch ($type) {

            case "edit":
            break;

            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $year_id = $this->_getParam("year_id");
                 //echo "<pre>";print_r($year_id);die;
                $result = $paymentModel->getPaidRecordByCourse($dept_id,$year_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo '<pre>';print_r($result);die;
                $this->view->degree_id = $result[0]['degree_id'];
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
               // print_r($yearId['year_id']); die();
                $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);
                 $this->view->yearid= $yearId['year_id'];
                break;
        }
    }

    public function ajaxGetApplicantsDetailByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            
            
            

            $applicantCourseData = new Application_Model_SanctionSeatModel();
            $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
            
            $this->view->yearid= $yearId;
        }
    }

    //End
    //For applied applicant details
    public function appliedApplicantDetailsAction() {
        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_APPLIEDAPPLICANTS');

        $academic_year_form = new Application_Form_AcademicYear();

        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $ct = $this->_getParam("ct");
        $this->view->type = $type;
        switch ($type) {


            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                  $acad_id = $this->_getParam("acad");
                  $acad = true;
                 if($ct=='pg')
                 {
                     $acad = false;
                 }
                $result = $paymentModel->getRecordByCouse($dept_id,$acad_id,$acad);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo '<pre>';print_r($result);die;
                $this->view->degree_id = $result[0]['degree_id'];
                $this->view->course_id = $result[0]['course'];
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;

            default:
                $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetAppliedApplicantsByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");

            $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
            $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
            $this->view->year_id = $yearId;
        }
    }

    //End 8 Oct 2020
    //Declaration of Result data
    public function declareResultAction() {
        $this->view->action_name = 'Addmission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_DECLARERESULT');
        $academic_year_form = new Application_Form_AcademicYear();
        $acadYearData = new Application_Model_AcademicYear();

        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $dept_id = $this->_getParam("dept_id");
        $this->view->dept_id = $dept_id;
        $this->view->type = $type;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {


            case "announceResult":

                $resultModel = new Application_Model_AnnounceResultModel();

                if ($this->getRequest()->getPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            $studentList = explode(",", trim(preg_replace('/\s\s+/', ' ', $_POST['student_lists'])));
                            //echo '<pre>'; print_r($studentList);exit;
                            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                                $ip = $_SERVER['HTTP_CLIENT_IP'];
                            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                            } else {
                                $ip = $_SERVER['REMOTE_ADDR'];
                            }
                            $insertMasterResult = array(
                                'acad_year_id' => $_POST['academic_year_list'],
                                'cutoff_list' => $_POST['cutoff_list'],
                                'submit_date' => date('Y-m-d'),
                                'ip_address' => $ip,
                                'published_by' => $this->login_storage->empl_id,
                                'department_type' => $dept_id
                            );
                            //echo '<pre>'; print_r($studentList);exit;
                            $last_insert_id = $resultModel->insert($insertMasterResult);

                            if ($last_insert_id) {

                                foreach ($studentList as $key => $stu_id) {

                                    $decalredStudentData = array(
                                        'master_id' => $last_insert_id,
                                        'stu_id' => $studentList[$key]
                                    );
                                    // echo '<pre>'; print_r($decalredStudentData); exit;
                                    $insert_id = $resultModel->insertResultItem($decalredStudentData);
                                }
                            }
                            // echo '<pre>'; print_r($insert_id);exit;
                            $checkInsertedDAta = $resultModel->checkInsertData($last_insert_id);
                            //echo '<pre>'; print_r(count($checkInsertedDAta));exit;
                            if (count($checkInsertedDAta) >= 1) {
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Result decalred ready for review.');
                                $this->_redirect('entrance-report/decalared-list');
                            } else {
                                $deleteMasterData = $dailyAttendanceMaster->dumpMasterData($last_insert_id);
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage('Result not Saved! Please try again.');
                                $this->_redirect('entrance-report/applied-applicant-details');
                            }
                        } else {
                            $this->_refresh(3, "/academic/entrance-report/declare-result/type/announceResult/dept_id/{$dept_id}", 'Invalid Token ..');
                        }
                    }
                }
                break;
            default:
                $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    //Added By Kedar: 07 Oct 2020
    public function ajaxGetDeclareRecordByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");

            $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
            $ugCourseCountData = $applicantCourseData->getAllUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
        }
    }

    public function decalaredListAction() {
        $resultModel = new Application_Model_AnnounceResultModel();
        $academicYearModel = new Application_Model_AcademicYear();
        $academic_year_form = new Application_Form_AcademicYear();

        $this->view->form = $academic_year_form;
        $yearId = $academicYearModel->getAcadYearId();
        $DeclaredList = $resultModel->getAllDeclaredList($yearId);
        $this->view->result = $DeclaredList;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $DeclaredList
        );

        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }

    public function dailyAdmCountAction() {
        $resultModel = new Application_Model_AnnounceResultModel();
        $academicYearModel = new Application_Model_AcademicYear();
        $academic_year_form = new Application_Form_AcademicYear();

        $this->view->form = $academic_year_form;
        $yearId = $academicYearModel->getAcadYearId();
        $DeclaredList = $resultModel->getAllDeclaredList($yearId);
        $this->view->result = $DeclaredList;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $DeclaredList
        );

        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }

    public function ajaxGetRecordByDateAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $resultModel = new Application_Model_SanctionSeatModel();
            $date = $this->_getParam("date");

            $recordList = $resultModel->getDailyAdmCount($date);
            $this->view->effective_date = $date;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'effective_date' => $date,
                'result' => $recordList
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function ajaxGetDeclareListByYearIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $resultModel = new Application_Model_AnnounceResultModel();
            $academicYearModel = new Application_Model_AcademicYear();
            $academic_year_form = new Application_Form_AcademicYear();
            $yearId = $this->_getParam("year_id");
            $this->view->form = $academic_year_form;
            $DeclaredList = $resultModel->getAllDeclaredList($yearId);
            $this->view->result = $DeclaredList;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $DeclaredList
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    //End 07 Oct
    public function editDeclaredResultAction() {
        $edit_id = $this->_getParam("e_id");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeclaredListItem = $resultModel->getAllDeclaredListItem($edit_id);
        $this->view->result = $DeclaredListItem;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $DeclaredListItem
        );

        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }

    public function ajaxCheckCutofflistEntryAction() {
        $dept_id = $this->_getParam("dept_id");
        $year_id = $this->_getParam("year_id");
        $cutoff_list = $this->_getParam("cutoff_list");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeclaredListItem = $resultModel->checkCutofflistEntry($dept_id, $year_id, $cutoff_list);
        if (!empty($DeclaredListItem)) {
            echo 'exists';
        } else {
            echo 'not exists';
        }die;
    }

    public function ajaxGetDeleteMasterIdAction() {
        $delete_id = $this->_getParam("delete_id");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeclaredListItem = $resultModel->getDeleteMasterId($delete_id);
        if (!empty($DeclaredListItem)) {
            echo $DeclaredListItem['id'];
        }die;
    }

    public function ajaxGetDeleteIdAction() {
        $delete_id = $this->_getParam("delete_id");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeclaredListItem = $resultModel->getDeleteId($delete_id);
        if (!empty($DeclaredListItem)) {
            echo $DeclaredListItem['id'];
        }die;
    }

    public function ajaxDeleteAnnouncedResultAction() {
        $delete_id = $this->_getParam("delete_id");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeletedItem = $resultModel->deleteAnnouncedResults($delete_id);
        if (!empty($DeletedItem)) {
            echo 'deleted';
        }die;
    }

    public function ajaxDeleteAnnounceItemResultAction() {
        $delete_id = $this->_getParam("delete_id");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeletedItem = $resultModel->deleteAnnounceItemResults($delete_id);
        if (!empty($DeletedItem)) {
            echo 'deleted';
        }die;
    }

    //Applicant Documents Details
    public function admDocAction() {
        $this->view->action_name = 'batchAttendance';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_ADMDOC');

        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
    }

    public function ajaxGetApplicantDocumentAction() {
        $this->_helper->layout->disableLayout();
        $degree_id = $this->_getParam("degree_id");
        $dept_id = $this->_getParam("dept_id");
        $year_id = $this->_getParam("yearId");
        $resultModel = new Application_Model_AnnounceResultModel();
        $DeclaredList = $resultModel->getAllApplicantDocumentList($degree_id, $dept_id, $year_id);
        $this->view->result = $DeclaredList;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $DeclaredList
        );

        //echo"<pre>";print_r($paginator_data);exit;
        $this->view->degree_id = $degree_id;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }

    //For I-card applicant details
    public function icardDetailsAction() {
        $this->view->action_name = 'Addmission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_ICARD');
        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        switch ($type) {

            case "edit":


                break;

            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $result = $paymentModel->getPaidRecordByCourse($dept_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
            case "download-icard":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $result = $paymentModel->getPaidRecordByCourse($dept_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function applicationFormAction() {
        $this->view->action_name = 'Addmission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_APPFORM');
        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $this->view->form = $multi_step_entrance_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        switch ($type) {

            case "edit":


                break;

            case "download-icard":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                $result = $paymentModel->getPaidRecordByCourse($dept_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;

            default:
                $applicantCourseData = new Application_Model_SanctionSeatModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
                $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetIcardApplicantDetailByYearIdAction() {

        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year_id");
            $applicantCourseData = new Application_Model_SanctionSeatModel();
            $ugCourseCountData = $applicantCourseData->getAllFinalUgCourseCount($yearId);
            $pgCourseCountData = $applicantCourseData->getAllFinalPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $ugCourseCountData
            );
            $pg_data = array(
                'result' => $pgCourseCountData
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            $this->view->pgData = $this->_act->pagination($pg_data);
        }
    }

    //End
    //Seating capacity controller
    public function sanctionSeatAction() {
        $this->view->action_name = 'seatingcapacity';
        $this->view->sub_title_name = 'sanctionedSeat';
        $this->accessConfig->setAccess('SS_ACAD_SANSEAT');
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $sanction_seat_form = new Application_Form_SanctionedSeatMaster();

        $type = $this->_getParam("type");
        $update_id = $this->_getParam("id");
        $this->view->type = $type;
        $this->view->form = $sanction_seat_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                $messages = $this->_flashMessenger->getMessages();

                if ($this->getRequest()->isPost()) {
                    //if ($sanction_seat_form->isValid($this->getRequest()->getPost())) {

                    $data = $_POST;
                    //echo '<pre>';print_r($data);exit;
                    $multiCore = $_POST['core_course'];
                    foreach ($multiCore as $corekey => $core_id) {
                        $insertData = array(
                            'degree_id' => $data['degree_id'],
                            'course' => $data['course'],
                            'session' => $data['session'],
                            'core_course' => $data['core_course'][$corekey],
                            'generic_elective' => $data['generic_elective'],
                            'max_seat' => $data['max_seat']
                        );
                        $sanction_seat_model->insert($insertData);
                    }
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {

                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('entrance-report/sanction-seat');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('entrance-report/sanction-seat');
                        }
                    }

                    //}
                }
                break;
            case 'edit':

                $result = $sanction_seat_model->getRecordById($update_id);
                //echo '<pre>'; print_r($result);
                $this->view->id = $update_id;
                $sanction_seat_form->populate($result);

                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {

                    $data = $_POST;

                    //echo '<pre>'; print_r($data); exit;
                    $updateData = array(
                        'degree_id' => $data['degree_id'],
                        'course' => $data['course'],
                        'session' => $data['session'],
                        'core_course' => $data['core_course'],
                        'generic_elective' => $data['generic_elective'],
                        'max_seat' => $data['max_seat']
                    );
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $_SESSION['message_class'] = 'alert-success';
                            $sanction_seat_model->update($updateData, array('id =?' => $update_id));
                            unset($_SESSION["token"]);

                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('entrance-report/sanction-seat/');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('entrance-report/sanction-seat');
                        }
                    }
                }
                break;

            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $sanction_seat_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo '<pre>';print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Ajax Area
    //To get ge Course
    public function ajaxGetGeAction() {
        $Aeccge_course = new Application_Model_Aeccge();
        $ge_course = new Application_Model_Department();
        $sanctionSeats = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        $applicantCourseData = new Application_Model_ApplicantCourseDetailModel();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $department_id = $this->_getParam("department_id");
            $course_id = $this->_getParam("course");
            //echo '<pre>'; print_r($department_id);
            //echo '<pre>'; print_r($academic_year_id);die;
            $result = $Aeccge_course->getRecordByDepartment3($department_id, $academic_year_id);
            $geName = $ge_course->getRecord($department_id);

            $academicIds = implode(",", $allAcademicIds);
            foreach ($result as $key => $value) {
                //echo"<pre>";print_r($course_id);
                $geSeatCount = $sanctionSeats->getRecordByindividualGenericElectiveSeatCount($course_id, $value['ge_id']);
                $geCount = $applicantCourseData->getRecordByindividualGenericElective($academic_year_id, $value['ge_id']);
                $result[$key]['applied'] = $geCount['total'];
                $result[$key]['max_seat'] = $geSeatCount['max_seat'];
            }
            $paginator_data = array(
                'result' => $result
            );
            $this->view->geDepartment = $geName['department'];
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    //end
    public function ajaxGetCoreCourseAction() {
        $this->_helper->layout->disableLayout();
        $applicantCourseDetailModel = new Application_Model_ApplicantCourseDetailModel();
        //$application_id= $this->_getParam("a_id");
        //echo '<pre>'; print_r($application_id);
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $c_id = $this->_getParam("c_id");
            $session_id = $this->_getParam("session_id");
            //print_r($short_code); die;
            $academic_model = new Application_Model_Department();
            $result = $academic_model->getCoreCourseByCourseId($c_id, $session_id);
            //echo "<pre>";print_r($result);
            echo '<option value="0">Select</option>';
            echo '<option value="0">Get Department GE</option>';
            foreach ($result as $k => $val) {
                //secho "<pre>";print_r($val);exit;
                echo '<option value="' . $val['academic_year_id'] . '" >' . $val['department'] . '</option>';
            }
        }die;
    }

    public function ajaxGetGeForSeatAction() {
        $Aeccge_course = new Application_Model_Aeccge();
        $batch = new Application_Model_Academic();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id_for_dept = $this->_getParam("academic_id");
            // $academic_year_id = $this->_getParam("academic_id");
            $ids = implode(',', $academic_year_id_for_dept);
            $result = $batch->getRecordByIds($ids);
            //echo '<pre>';print_r($result);exit;
            foreach ($result as $key => $value) {

                $result[$key] = $value['department'];
            }
            $department_id = implode(',', $result);
            $academic_year_id = implode(',', $this->_getParam("academic_id"));

            $result = $Aeccge_course->getRecordByDepartment3($department_id, $academic_year_id);
            //echo "<pre>";print_r($result);
            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {
                //echo "<pre>";print_r($val);
                echo '<option value="' . $val['ge_id'] . '" >' . $val['general_elective_name'] . '</option>';
            }
        }die;
    }

    public function ajaxCheckExistedEntryAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $dept = $this->_getParam("dept");
            $core_course = $this->_getParam("core_course");
            $ge_id = $this->_getParam("ge_id");

            $result = $sanction_seat_model->checkExistedEntry($dept, $core_course, $ge_id);
            if ($result['course']) {
                echo 'course';
            } elseif ($result['core_course']) {
                echo 'core';
            } elseif ($result['generic_elective']) {
                echo 'ge';
            } else {
                echo 'go';
            }
        }die;
    }

    //For Document verification
    public function ajaxGetApplicantInfoAction() {
        $courseDetailmodel = new Application_Model_ApplicantCourseDetailModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $application_no = $this->_getParam("application_no");

            $applicant_data = $courseDetailmodel->getRecordByAppID($application_no);
            //echo '<pre>';print_r($result);exit;

            $this->view->paginator = $applicant_data;
        }
    }

    //For applicant Info for pay-slip
    public function ajaxApplicantInfoForPaySlipAction() {
        $courseDetailmodel = new Application_Model_ApplicantCourseDetailModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $application_no = $this->_getParam("application_no");
            $form_id = $this->_getParam("form_id");
            $pay_mode = $this->_getParam("pay_mode");
            //echo '<pre>'; print_r($application_no);exit;
            if (!empty($pay_mode)) {
                $this->view->pay_method = $pay_mode;
                $this->view->paginator = $applicant_data;
            }
            $addons = new Application_Model_AddonCourseAssignmentModel();
            $studentAddon = $addons->getStudentAddonFee($form_id);
            $addonFee = $studentAddon['addonfee'];
            $applicant_data = $courseDetailmodel->getRecordByAppIDPaySlip($application_no, $form_id);

            $OnlineData = array(
                'Account_Name1' => !empty($applicant_data[0]['account1']) ? $applicant_data[0]['account1'] : $applicant_data[1]['account1'],
                'Account_Name2' => !empty($applicant_data[0]['account2']) ? $applicant_data[0]['account2'] : $applicant_data[1]['account2'],
                'Amount1' => !empty($applicant_data[0]['total_fee1']) ? $applicant_data[0]['total_fee1'] : $applicant_data[1]['total_fee1'],
                'Amount2' => !empty($applicant_data[0]['total_fee2']) ? $applicant_data[0]['total_fee2'] : $applicant_data[1]['total_fee2']
            );
            // echo '<pre>';print_r($applicant_data[0]);exit;
            $this->view->online_details = $OnlineData;
            $this->view->paginator = $applicant_data[0];
        }
    }

    public function ajaxGetPaymodeAction() {

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $pay_mode = $this->_getParam("pay_mode");
            //echo '<pre>'; print_r($pay_mode);exit;
            if (!empty($pay_mode)) {
                $this->view->pay_method = $pay_mode;
            }
        }
    }

    public function ajaxUpsertDocumentsAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $docArray = $this->_getParam("docArray");
            $form_id = $this->_getParam("form_id");
            $app_id = $this->_getParam("app_id");
            $course_id = $this->_getParam("course_id");
           // echo '<pre>';print_r($docArray);exit;
            if ($form_id) {
                $checkData = $sanction_seat_model->checkExistedData($form_id);
                if ($checkData['form_id']) {
                    $updateDocument_data = $sanction_seat_model->updateDocuments($docArray, $form_id, $app_id);
                    echo 'Records updated successfully';
                } else {
                    $document_data = $sanction_seat_model->insertDocuments($docArray, $form_id, $app_id, $course_id);
                    echo 'Records inserted successfuly';
                }
            }
            //$this->view->paginator =$applicant_data;
        }die;
    }

    public function ajaxInsertAddonsAction() {
        $addonModel = new Application_Model_AddonCourseAssignmentModel();
        $addonCourseModel = new Application_Model_AddonCourseModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $form_id = $this->_getParam("form_id");
            $course_id = $this->_getParam("course_id");
            $acad_id = $this->_getParam("acad_id");
            $update['status'] = 2;
            $addonModel->trashItems($form_id);
               
            if ($form_id) {
                foreach ($course_id as $val) {
                    $courseDetails = $addonCourseModel->getRecordbyacadid($val,5);
                    $data['stu_id'] = $form_id;
                    $data['addon_course_id'] = $val;
                    $data['addon_course_fee'] = $courseDetails['fee'];
                    $addonModel->insert($data);
                     $coursedetails = $addonCourseModel->getRecords($acad_id);
                }
                echo json_encode($coursedetails);
                die;
            }
            //$this->view->paginator =$applicant_data;
        }
    }

    public function ajaxUpdatePrincipalStatusAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $buttonValue = $this->_getParam("buttonValue");
            $form_id = $this->_getParam("form_id");

            //echo '<pre>';print_r($docArray);exit;

            $updatePrincipalStatus = $sanction_seat_model->updatePrincipalStatus($form_id, $buttonValue);
            echo 'ok';

            //$this->view->paginator =$applicant_data;
        }die;
    }

    public function ajaxGetRecordByPstatusAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $status_filter = $this->_getParam("status_filter");
            $course = $this->_getParam("course");
            $year_id = $this->_getParam("year_id");
            $filterData = $sanction_seat_model->getRecordByPrincipalStatus($status_filter, $course,$year_id);
            $paginator_data = array(
                'page' => $page,
                'result' => $filterData
            );
            //echo '<pre>'; print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);

            //$this->view->paginator =$filterData;
        }
    }

    public function ajaxGetRecordByAstatusAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $status_filter = $this->_getParam("status_filter");
            $course = $this->_getParam("course");

            $filterData = $sanction_seat_model->getRecordByAccountStatus($status_filter, $course);
            $paginator_data = array(
                'page' => $page,
                'result' => $filterData
            );
            //echo '<pre>'; print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);

            //$this->view->paginator =$filterData;
        }
    }

    public function ajaxUpdateForFeeSlipAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $buttonValue = $this->_getParam("buttonValue");
            $form_id = $this->_getParam("form_id");

            //echo '<pre>';print_r($buttonValue);exit;

            $updatePrincipalStatus = $sanction_seat_model->updateFeeSlipStatus($form_id, $buttonValue);
            echo 'ok';
        }die;
    }

    public function ajaxUpsertFeeSlipAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $stu_details = new Application_Model_ApplicantCourseDetailModel();
            $fund_type = $this->_getParam("fund_type");
            $form_id = $this->_getParam("form_id");
            $details_stu = $stu_details->getApplicationNumber($form_id);

            if ($details_stu['degree_id'] == 1) {
                $acad_id = $details_stu['core_course1'];
            } else {
                $department = new Application_Model_DepartmentType();
                $academic_details = $department->getAcademicDdetails($details_stu['course']);
                $acad_id = $academic_details['academic_id'];
            }
            $semester = 't1';
            //echo '<pre>';print_r($acad_id);exit;
            $feeitems = new Application_Model_FeeStructureTermItems();
            $feeStructure = new Application_Model_FeeStructure();
            $struct_id = $feeStructure->getStructId($acad_id);
            $fee = $feeitems->getFee($struct_id, $semester);

            $addons = new Application_Model_AddonCourseAssignmentModel();
            $studentAddon = $addons->getStudentAddonFee($form_id);
            $addonFee = $studentAddon['addonfee'];

            $feeData = array(
                'totalfee1' => $fee[0]['totalfee'],
                'account_name1' => $fee[0]['acc_name'],
                'totalfee2' => $fee[1]['totalfee'],
                'account_name2' => $fee[1]['acc_name']
            );
            $feeData[totalfee1] += !empty($addonFee) ? $addonFee : 0;
            $checkExistedData = $sanction_seat_model->checkData($form_id, $fund_type);
            //echo '<pre>';print_r($checkExistedData);exit;
            if (!empty($checkExistedData)) {
                $updatePaymentDetail = $sanction_seat_model->updateFeeSlip($fund_type, $checkExistedData['id'], $feeData);
            } else {
                $insertPaymentDetail = $sanction_seat_model->insertFeeSlip($form_id, $fund_type, $feeData);
            }

            echo 'ok';
        }die;
    }

    //To upsert pay details
    public function ajaxUpsertPayDetailsAction() {
        $sanction_seat_model = new Application_Model_SanctionSeatModel();
        $semFeeModel= new Application_Model_FeesCollection();
        $applicantDetails= new Application_Model_ApplicantCourseDetailModel();
        $acadMaster= new Application_Model_Academic();
        
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $docArray = $this->_getParam("docArray");
            $form_id = trim($this->_getParam("form_id"));
            $app_id = trim($this->_getParam("app_id"));
            $course_id = $this->_getParam("course_id");
            //echo '<pre>'; print_r($docArray); exit;
            
            if ($docArray[0]['pay_mode1'] != 1) {
                $result= $applicantDetails->getApplicationCourseDetails($form_id);
                $getDept= $acadMaster->getDepartment($result['core_course1']);
                //echo '<pre>';print_r($getDept);exitt;
                $checkFees= $semFeeModel->getstudentSemfeeDetails($form_id,'t1');
                $addons = new Application_Model_AddonCourseAssignmentModel();
                $studentAddon = $addons->getStudentAddonFee($form_id);
                $addonFee = $studentAddon['addonfee'];
                if(!empty($checkFees['fee'])){
                    $data = array(
                    'name' => $result['applicant_name'],
                    'stu_id' =>$form_id,
                    'exam_id' => 'N/A',
                    'class_roll' => '0',
                    'batch' => $getDept['short_code'],
                    'semester' => 't1',
                    'department' => $getDept['department'],
                    'fee' => $docArray[0]['amount1']-$addonFee,
                    'pay_mode' => $docArray[0]['pay_mode1'],
                    'bank_name' => $docArray[0]['unique_id1'],
                    'mmp_txn' => $docArray[0]['unique_id1'],
                    'email' => $result['email_id'],
                    'phone' =>$result['phone'],
                    'date' => date("l jS \of F Y h:i:s A"),
                    'description'=> 'By Admin Interface',
                    'submit_date' => date('Y-m-d'),
                    'f_code' => 'Ok',
                    'addon_fee' => !$addonFee?0:$addonFee,
                    'status' => 1
                );
                    //echo '<pre>'; print_r($data); exit;
                    $updateId = $semFeeModel->update($data, array(
                        'stu_id=?' => $form_id,
                        'status' =>1
                        ));
                    echo 'Records updated successfully In Sem Collection || ';
                }else{
                    $data = array(
                    'name' => $result['applicant_name'],
                    'stu_id' =>$form_id,
                    'exam_id' => 'N/A',
                    'class_roll' => '0',
                    'batch' => $getDept['short_code'],
                    'semester' => 't1',
                    'department' => $getDept['department'],
                    'fee' => $docArray[0]['amount1']-$addonFee,
                    'pay_mode' => $docArray[0]['pay_mode1'],
                    'bank_name' => $docArray[0]['unique_id1'],
                    'mmp_txn' => $docArray[0]['unique_id1'],
                    'email' => $result['email_id'],
                    'phone' =>$result['phone'],
                    'date' => date("l jS \of F Y h:i:s A"),
                    'description'=> 'By Admin Interface',
                    'submit_date' => date('Y-m-d'),
                    'f_code' => 'Ok',
                    'addon_fee' => !$addonFee?0:$addonFee,
                    'status' => 1
                );
                    //echo '<pre>'; print_r($data); exit;
                    $insertId = $semFeeModel->insert($data);
                     echo 'Records inserted successfuly in Sem Collection ||';
                }
                $checkData = $sanction_seat_model->checkExistedPayModeData($form_id);
                    if ($checkData['form_id']) {
                        $updateDocument_data = $sanction_seat_model->updatePayDetails($docArray, $form_id, $app_id);
                        echo 'Records updated successfully in Applicant Paymode';
                    } else {

                        $generateRoll = $sanction_seat_model->checkCourseForRoll($course_id);
                        //echo '<pre>';print_r($generateRoll) ;exit;
                        if ($generateRoll) {
                            $classRoll = 1 + $generateRoll['roll_no'];
                        } else {
                            $classRoll = 1;
                        }

                        $document_data = $sanction_seat_model->inserttPayDetails($docArray, $form_id, $course_id, $classRoll);
                        $updateScrutinyStatus = $sanction_seat_model->updateScrutinyStatus($form_id);
                        echo 'Records inserted successfuly in Applicant Paymode';
                    }
               
            } else {

                if ($form_id) {
                    $checkData = $sanction_seat_model->checkExistedPayModeData($form_id);
                    if ($checkData['form_id']) {
                        $updateDocument_data = $sanction_seat_model->updatePayDetails($docArray, $form_id, $app_id);
                        echo 'Records updated successfully';
                    } else {

                        $generateRoll = $sanction_seat_model->checkCourseForRoll($course_id);
                        //echo '<pre>';print_r($generateRoll) ;exit;
                        if ($generateRoll) {
                            $classRoll = 1 + $generateRoll['roll_no'];
                        } else {
                            $classRoll = 1;
                        }

                        $document_data = $sanction_seat_model->inserttPayDetails($docArray, $form_id, $course_id, $classRoll);
                        $updateScrutinyStatus = $sanction_seat_model->updateScrutinyStatus($form_id);
                        echo 'Records inserted successfuly';
                    }
                }
            }
        }die;
    }

    public function rejectedApplicantDetailsAction() {
        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'AdmissionReport';
        $this->accessConfig->setAccess('SA_ACAD_AR_APPLIEDAPPLICANTS');

        $academic_year_form = new Application_Form_AcademicYear();
        $edudetails = new Application_Model_ApplicantEducationalDetailModel();
        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $this->view->type = $type;
        $messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
        switch ($type) {


            case "getStudents":
                $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
                $dept_id = $this->_getParam("dept_id");
                  $acad_id = $this->_getParam("acad");
                //  $result = $paymentModel->getRecordByCouse($dept_id);
                $result = $edudetails->getAllStudentsRejectedCount($dept_id,$acad_id);
                //echo "<pre>";print_r($result);die;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                 if ($this->getRequest()->getPost()) {
                     
                    $data = $this->getRequest()->getPost();
                    
                     foreach ($data['chkdlt'] as $chkdlt) {
                         
                    
                 $filename=  realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_photo/' . $chkdlt.'.jpg';
                 $filename7=  realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_photo/' . $chkdlt.'.png';
                 $filename8=  realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_photo/' . $chkdlt.'.jpeg';
                 $filename1= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_edu_certificate/' . $chkdlt.'.jpg';
                 $filename2= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_edu_certificate/' . $chkdlt.'.pdf';
                 $filename9= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_edu_certificate/' . $chkdlt.'.png';
                 $filename10= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_edu_certificate/' . $chkdlt.'.jpeg';
                 $filename3= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_caste_certificate/' . $chkdlt.'.jpg';
                 $filename4= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_caste_certificate/' . $chkdlt.'.pdf';
                 $filename11= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_caste_certificate/' . $chkdlt.'.png';
                 $filename12= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_caste_certificate/' . $chkdlt.'.jpeg';
                 $filename5= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_baptism/' . $chkdlt.'.jpg';
                 $filename6= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_baptism/' . $chkdlt.'.pdf';
                 $filename13= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_baptism/' . $chkdlt.'.png';
                 $filename14= realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_baptism/' . $chkdlt.'.jpeg';
                   if (file_exists($filename) or file_exists($filename1) or file_exists($filename2) or file_exists($filename3) or file_exists($filename4) or file_exists($filename5) or file_exists($filename6)
                    or file_exists($filename7)
                    or file_exists($filename8)
                    or file_exists($filename9)
                    or file_exists($filename10)
                    or file_exists($filename11)
                    or file_exists($filename12)
                    or file_exists($filename13)
                    or file_exists($filename14)) {
                   unlink("$filename");
                   unlink("$filename1");
                   unlink("$filename2");
                   unlink("$filename3");
                   unlink("$filename4");
                   unlink("$filename5");
                   unlink("$filename6");
                   unlink("$filename7");
                   unlink("$filename8");
                   unlink("$filename9");
                   unlink("$filename10");
                   unlink("$filename11");
                   unlink("$filename12");
                   unlink("$filename13");
                   unlink("$filename14");
                   $updateData = array(
                       'photo'=>"deleted",
                       'casteCertificate'=>"deleted",
                       'educertificate' => "deleted"
                       );
                   $edudetails->update($updateData, array('application_no=?' => $chkdlt));
                    $message = "The file Successfully Deleted";
               } else {
                    //echo "The file $filename does not exist";
                   $message = "The file does not Exist";  
                    }       
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_photo/' . $chkdlt.'.jpg');
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_edu_certificate/' . $chkdlt.'.jpg');
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_edu_certificate/' . $chkdlt.'.pdf');
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_caste_certificate/' . $chkdlt.'.jpg');
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_caste_certificate/' . $chkdlt.'.pdf');
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_baptism/' . $chkdlt.'.jpg');
//                  unlink(realpath(APPLICATION_PATH . '/../') . '/public/images/applicant_baptism/' . $chkdlt.'.pdf');
//                  
                           
                
//                echo "<br>";
                // echo '"'.$path.$ugCourseCountData['educertificate'].'"';
            }
                   
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('entrance-report/rejected-applicant-details/');         
                    
                 }
                          
                //   echo '<pre>';print_r($result);die;
                $this->view->degree_id = $result[0]['degree_id'];
                $this->view->course_id = $result[0]['course'];
                $this->view->paginator = $this->_act->pagination($paginator_data);

                break;

            default:
                $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();
                $academicYearModel = new Application_Model_AcademicYear();
                $yearId = $academicYearModel->getAcadYearId();
                // $ugCourseCountData=$applicantCourseData->getAllUgCourseCount($yearId);
                $ugCourseCountData = $edudetails->getAllUgCourseRejectedCount();
                $pgCourseCountData = $edudetails->getAllPgCourseRejectedCount();
                //$this->view->result = $courseCountData;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $ugCourseCountData
                );
                $pg_data = array(
                    'result' => $pgCourseCountData
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
                $this->view->pgData = $this->_act->pagination($pg_data);

                break;
        }
    }

    public function ajaxGetRejectedDataByRegistrationIdAction() {
        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $r_hide = $this->_getParam("r_hide");
            $path = $this->_getParam("path");

            $edudetails = new Application_Model_ApplicantEducationalDetailModel();

            $ugCourseCountData = $edudetails->getAlldData($r_hide);
            // $applicantCourseData = new Application_Model_ApplicantPaymentDetailModel();    
            // $ugCourseCountData=$applicantCourseData->getAllUgCourseCount($yearId);
            // $pgCourseCountData=$applicantCourseData->getAllPgCourseCount($yearId);
            //$this->view->result = $courseCountData;
            //  print_r($ugCourseCountData['educertificate']);
            if (!empty($ugCourseCountData['photo'])) {
                $filename = realpath(APPLICATION_PATH . '/../') . '/' . $ugCourseCountData['photo'];
                if (file_exists($filename)) {
                    unlink("$filename");
                    echo "The file $filename Deleted";
                } else {
                    echo "The file $filename does not exist";
                }
                echo "<br>";
                // echo '"'.$path.$ugCourseCountData['educertificate'].'"';
            }
            if (!empty($ugCourseCountData['educertificate'])) {
                $filename = realpath(APPLICATION_PATH . '/../') . '/' . $ugCourseCountData['educertificate'];
                if (file_exists($filename)) {
                    unlink("$filename");
                    echo "The file $filename Deleted";
                } else {
                    echo "The file $filename does not exist";
                }
                echo "<br>";
                //echo '"'.$path.$ugCourseCountData['educertificate'].'"';
            }
            if (!empty($ugCourseCountData['casteCertificate'])) {
                $filename = realpath(APPLICATION_PATH . '/../') . '/' . $ugCourseCountData['casteCertificate'];
                if (file_exists($filename)) {
                    unlink("$filename");
                    echo "The file $filename Deleted";
                } else {
                    echo "The file $filename does not exist";
                }
                echo "<br>";
                // echo '"'.$path.$ugCourseCountData['educertificate'].'"';
            }
            if (!empty($ugCourseCountData['baptism'])) {
                $filename = realpath(APPLICATION_PATH . '/../') . '/' . $ugCourseCountData['baptism'];
                if (file_exists($filename)) {
                    unlink("$filename");
                    echo "The file $filename Deleted";
                } else {
                    echo "The file $filename does not exist";
                }
                // echo '"'.$path.$ugCourseCountData['educertificate'].'"';
            }

            //   $ugCourseCountData['casteCertificate'];
            //   $ugCourseCountData['photo'];
            //    $ugCourseCountData['baptism'];
        } die();
    }
    
    
    
public function valueAddedCoursesAction() {

        $this->view->action_name = 'Admission Report';
        $this->view->sub_title_name = 'valueaddedcourse';
        $this->accessConfig->setAccess('SA_ACAD_AR_ADDONREPORT');

        $academic_year_form = new Application_Form_ValueAddedCourse();
        $valueCourseData = new Application_Model_ValueAddedCourseModel();
       
        $academicYearModel = new Application_Model_AcademicYear();
        
        $this->view->form = $academic_year_form;
        $type = $this->_getParam("type");
        $edit_id = $this->_getParam("id");
        $acad = $this->_getParam("acad");
        $this->view->type = $type;
        $messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
        //$hoddetails = $HRMModel_model->getHodDetails();
       // $this->view->hod = $hoddetails;
        switch ($type) {

            case "bulkadd":
            if ($this->getRequest()->getPost()) {
            $data = $this->getRequest()->getPost();
                   // echo '<pre>'; print_r($data);exit;
            $checkExistedData = $valueCourseData->checkExistedData($data['academic_year_mig']);
             //echo '<pre>'; print_r($data);exit;
            if (empty($checkExistedData)) {
            foreach ($data['course_name'] as $key => $name) {
            $migData = array(
            'academic_year' => $data['academic_year_mig'],
            'session_id' => $data['session_id_mig'],
            'course_name' => $data['course_name'][$key],
            'course_code' => $data['course_code'][$key],
            'course_description' => $data['course_description'][$key],
            'capacity' => $data['capacity'][$key],
            'tot_credit'=>$data['tot_credit'][$key],
            'countable'=>$data['countable'][$key],
            'conductedby'=>$data['conductedby'][$key],
            'semester'=>$data['semester'][$key],
            'status' => 0  
                );
               // echo "<pre>";print_r($migData);exit;
                $valueCourseData->insert($migData);
            }
                     
           $_SESSION['message_class'] = 'alert-success';
           $this->_flashMessenger->addMessage('Value Added Course Inserted Successfully added');
           $this->_redirect('entrance-report/value-added-courses');
           }else {
            $_SESSION['message_class'] = 'alert-danger';
            $this->_flashMessenger->addMessage('Deatils Already Exists! ');
            $this->_redirect('entrance-report/value-added-coursest');
                    }
                }
           break;
    case "add":
    if ($this->getRequest()->getPost()) {
    $data = $this->getRequest()->getPost();
    //echo '<pre>'; print_r($data);exit;
    if (!empty($data['csrftoken'])) {
            
    $insertItem = array(
                'academic_year' => $data['academic_year'],
                'session_id' => $data['session_id'],
                'semester' => $data['semester'],
                'course_name'=>$data['course_name'],
                'course_code'=>$data['course_code'],
                'course_description' => $_POST['course_description'],
                'capacity' => $_POST['capacity'],
                'conductedby' => $_POST['conductedby'],
                'tot_credit' => $_POST['tot_credit'],
                'countable' => $_POST['countable'],
                'status' => $data['status']
    );
                
    $last_insert_id= $valueCourseData->insert($insertItem);
    $this->_flashMessenger->addMessage('Addon Course Inserted Successfully added');
    $this->_redirect('entrance-report/value-added-courses');
    } else {
    $_SESSION['message_class'] = 'alert-danger';
    $this->_flashMessenger->addMessage('Invalid Token! Not Added');
    $this->_redirect('entrance-report/value-added-courses');
    }
    }



    break;
    case "edit":
    $results = $valueCourseData->getRecord($edit_id);
    $this->view->id = $edit_id;
             
    $academic_year_form->populate($results);
    $this->view->result = $results;
    
    if ($this->getRequest()->getPost()) {
    $data = $this->getRequest()->getPost();
    
    //echo '<pre>'; print_r($data);exit;
     if (!empty($data['csrftoken'])) {
         
    
     $updateData = array(
    'academic_year' => $data['academic_year'],
    'session_id' => $data['session_id'],
    'semester' => $data['semester'],
    'course_name'=>$data['course_name'],
    'course_code'=>$data['course_code'],
    'course_description' => $_POST['course_description'],
    'capacity' => $_POST['capacity'],
    'conductedby' => $_POST['conductedby'],
    'tot_credit' => $_POST['tot_credit'],
    'countable' => $_POST['countable'],
    'status' => $data['status'],
    
    );
     $last_insert_id= $valueCourseData->update($updateData,array('id=?' => $edit_id));
     
      $this->_flashMessenger->addMessage('Addon Course Updated Successfully added');
      $this->_redirect('entrance-report/value-added-courses');
    } else {
      $_SESSION['message_class'] = 'alert-danger';
      $this->_flashMessenger->addMessage('Invalid Token!  Not Updated');
      $this->_redirect('entrance-report/value-added-courses');
        }
        }
        break;
        default:
        $yearId = $academicYearModel->getAcadYearId();
                //echo '<pre>';print_r($yearId);exit;
        $CourseCountData = $valueCourseData->getRecords();
                //$paidCourseCountData = $valueCourseData->getAddonCoursePaidCount($yearId['year_id']);
               // foreach ($CourseCountData as $key => $value) {
                    
                //   $CourseCountData[$key]['paid']= $paidCourseCountData[$key]['total_paid'];
                    
              //  }
                //echo '<pre>';print_r($paidCourseCountData); exit;
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
                    'page' => $page,
                    'result' => $CourseCountData
                );

                //echo"<pre>";print_r($paginator_data);exit;
       //    $this->view->year=$yearId['academic_year'];
        $this->view->paginator = $this->_act->pagination($paginator_data);

        break;
        }
    }    
    
public function ajaxGetValueCourseByYearAction() {
        $this->_helper->layout->disableLayout();
      $valueCourseData = new Application_Model_ValueAddedCourseModel();
      
    if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        
        $yearId = $this->_getParam("year");
        $session = $this->_getParam("session");
        $CourseCountData = $valueCourseData->getValueAddedCourse($yearId,$session);
        
        
               // echo '<pre>';print_r($CourseCountData); exit;
         $page = $this->_getParam('page', 1);
         $paginator_data = array(
           'page' => $page,
            'result' => $CourseCountData
                );

                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    } 
    
   
public function ajaxGetValueCourseAddedMigAction() {
        $this->_helper->layout->disableLayout();
        $addonCourseData = new Application_Model_ValueAddedCourseModel();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $yearId = $this->_getParam("year");
            $session = $this->_getParam("session");
            
                $CourseCountData = $addonCourseData->getValueAddedCourse($yearId,$session);
              
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $CourseCountData
                );

                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
        }
}    


public function ajaxGetSessionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $year_id = $this->_getParam("year");
            //print_r($short_code); die;
            $session_model = new Application_Model_Session();
            $result = $session_model->getSessionRecordByYearId($year_id);

            //echo '<pre>'; print_r($result);
            echo '<option value="">Select Session</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['session'] . '</option>';
            }
        }die;
    }    
}

?>