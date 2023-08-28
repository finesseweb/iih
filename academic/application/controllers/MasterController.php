<?php

//ini_set('display_errors', '1');
/**
 * @Framework Zend Framework
 * @Powered By TIS 
 * @category   ERP Product
 * @copyright  Copyright (c) 2014-2015 Techintegrasolutions Pvt Ltd.
 * (http://www.techintegrasolutions.com)
 * 	Authors Kannan and Rajkumar
 */
class MasterController extends Zend_Controller_Action {

    private $_siteurl = null;
    private $_db = null;
    private $_flashMessenger = null;
    private $_authontication = null;
    private $_agentsdata = null;
    private $_usersdata = null;
    private $_act = null;
    private $_adminsettings = null;
    private $login_storage = NULL;
    private $_auth_id = null;
    private $_role_id = null;
    private $accessConfig = null;

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

 

    public function totalEarnedCreditsAction() {
        $this->view->action_name = 'studentcredit';
        $this->view->sub_title_name = 'studentcredit';
        $this->accessConfig->setAccess("SA_ACAD_EAR_CREDIT");
        $Credit_model = new Application_Model_TotalEarnedCredits();
        $Credit_form = new Application_Form_TotalEarnedCredits();
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
        if (!empty($data['csrftoken'])) {
        if ($data['csrftoken'] === $token) {
        unset($_SESSION["token"]);
        unset($data['csrftoken']);
        $Credit_model->insert($data);
        $_SESSION['message_class'] = 'alert-success';
        $this->_flashMessenger->addMessage('Details Added Successfully ');
        $this->_redirect('master/total-earned-credits');
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
        $data = $_POST;
        if (!empty($data['csrftoken'])) {
                        //echo '<pre>';print_r($data['csrftoken']);exit;
        if ($data['csrftoken'] === $token) {
        unset($_SESSION["token"]);
        unset($data['csrftoken']);
        $Credit_model->update($data, array('id=?' => $credit_id));
        $_SESSION['message_class'] = 'alert-success';
        $this->_flashMessenger->addMessage('Details Updated Successfully');
        $this->_redirect('master/total-earned-credits');
        } else {
        $_SESSION['message_class'] = 'alert-danger';
        $this->_flashMessenger->addMessage('Token Mismatch');
        $this->_redirect('master/total-earned-credits');
        }
        }
        }
        break;
        case 'delete':
        $data['status'] = 2;
        if ($credit_id) {
        $Credit_model->update($data, array('credit_id=?' => $credit_id));
        $this->_flashMessenger->addMessage('Details Deleted Successfully');
        $this->_redirect('master/total-earned-credits');
        }
        break;
        default:
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result = $Credit_model->getRecords();
//                $page = $this->_getParam('page', 1);
//                $paginator_data = array(
//                    'page' => $page,
//                    'result' => $result
//                );
//                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    public function nonAcademicCourseAction() {
        $this->view->action_name = 'studentcredit';
        $this->view->sub_title_name = 'creditcourse';
        $this->accessConfig->setAccess("SA_ACAD_EAR_CREDITCOURSE");
        $Credit_model = new Application_Model_NonAcademicCourse();
        $Credit_form = new Application_Form_TotalEarnedCredits();
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
//                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $_POST;
                        //echo '<pre>'; print_r($data); exit;
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                unset($_SESSION["token"]);
                                unset($data['csrftoken']);
                                $Credit_model->insert($data);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                $this->_redirect('master/non-academic-course');
                            }
                        }
                    //}
                }
                break;
            case "bulkadd":
                if ($this->getRequest()->isPost()) {
//                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $_POST;
                        //echo '<pre>'; print_r($data); exit;
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                unset($_SESSION["token"]);
                                unset($data['csrftoken']);
                                $dumpexistedData= $Credit_model->dumpdata($data['mig_session']);
                                //echo 'delete';die;
                                foreach ($data['credit_course'] as $key => $credit_course) {
                                    $bulk_data = array(
                                    "academic_year" => $data['mig_academic_year'],
                                    "session" => $data['mig_session'],
                                    "credit_course" => $data['credit_course'][$key]
                                    
                                );
                                        $Credit_model->insert($bulk_data);
                                }
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Data Added Successfully ');
                                $this->_redirect('master/non-academic-course');
                            }
                        }
                    //}
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);
                //echo '<pre>';print_r($result);exit;
                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    $data = $_POST;
                    if (!empty($data['csrftoken'])) {
                        //echo '<pre>';print_r($data['csrftoken']);exit;
                        if ($data['csrftoken'] === $token) {
                            unset($_SESSION["token"]);
                            unset($data['csrftoken']);

                            $Credit_model->update($data, array('id=?' => $credit_id));
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('master/non-academic-course');
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Token Mismatch');
                            $this->_redirect('master/total-earned-credits');
                        }
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($credit_id) {
                    $Credit_model->update($data, array('credit_id=?' => $credit_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/total-earned-credits');
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
    

    public function ajaxGetEarnedCreditBySessionAction() {
        $Credit_model = new Application_Model_TotalEarnedCredits();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $id = $this->_getParam('session');
            $result = $Credit_model->getRecordsBySession($id);
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    public function ajaxGetNonAcademicCourseBySessionAction() {
        $Credit_model = new Application_Model_NonAcademicCourse();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $id = $this->_getParam('session');
            $result = $Credit_model->getRecordsBySession($id);
            //echo '<pre>'; print_r($result);exit;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    public function ajaxGetNonAcademicCourseForBulkaddAction() {
        $Credit_model = new Application_Model_NonAcademicCourse();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $id = $this->_getParam('session');
            $result = $Credit_model->getRecordsBySession($id);
            //echo '<pre>'; print_r($result);exit;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function earnedCreditMigrationAction() {
        $this->view->action_name = 'studentcredit';
        $this->view->sub_title_name = 'studentcredit';
        $this->accessConfig->setAccess("SA_ACAD_EAR_CREDIT");
        $Credit_model = new Application_Model_TotalEarnedCredits();
        $Credit_form = new Application_Form_TotalEarnedCredits();
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        if ($this->getRequest()->isPost()) {
            //echo "<pre>"; print_r($_POST);exit;
            if (!empty($_POST['csrftoken'])) {
                if ($_POST['csrftoken'] === $token) {

                    $data = $_POST;

                    unset($data['csrftoken']);
                    unset($data['academic_year']);
                    $checkExistedData = $Credit_model->checkExistedData($data['session']);
                    //echo '<pre>'; print_r($data);exit;
                    if (empty($checkExistedData)) {
                        foreach ($data['academic_id'] as $key => $value) {
                            $migData = array(
                                'status' => $data['status'],
                                'session' => $data['session'],
                                'credit_number' => $data['credit_number'][$key],
                                'academic_id' => $data['academic_id'][$key],
                            );
                            //echo "<pre>";print_r($migData);exit;
                            $Credit_model->insert($migData);
                        }
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/total-earned-credits');
                    } else {
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage('Deatils Already Exists! ');
                        $this->_redirect('master/total-earned-credits');
                    }
                }
            }
        }
    }

    //Credit Master
    public function creditAction() {
        $this->view->action_name = 'masterdata-addmission';
        $this->view->sub_title_name = 'credit';
        $Credit_model = new Application_Model_Credit();
        $Credit_form = new Application_Form_Credit();
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        //print_r($data);die;
                        $Credit_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/credit');
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

                        $Credit_model->update($data, array('credit_id=?' => $credit_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/credit');
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

    //General Electives
    public function generalElectivesAction() {
        $this->view->action_name = 'GE';
        $this->view->sub_title_name = 'GE';
        $this->accessConfig->setAccess("SA_ACAD_GE");
        $Credit_model = new Application_Model_Ge();
        $Credit_form = new Application_Form_Ge();
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
                        $insertData = array(
                            'general_elective_name' => $data['general_elective_name'],
                            'department' => $data['department'],
                            'degree_id' => $data['degree_id'],
                            'status' => $data['status']
                        );
                        // print_r($data);die;
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Credit_model->insert($insertData);
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                $this->_redirect('master/general-electives');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/general-electives');
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
                        //echo '<pre>'; print_r($data);exit;
                        $updateData = array(
                            'general_elective_name' => $data['general_elective_name'],
                            'department' => $data['department'],
                            'degree_id' => $data['degree_id'],
                            'status' => $data['status']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Credit_model->update($updateData, array('ge_id=?' => $credit_id));
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/general-electives');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/general-electives');
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

    public function componentmasterAction() {
        $this->view->action_name = 'componentmaster';
        $this->view->sub_title_name = 'componentmaster';
        $this->accessConfig->setAccess("SA_ACAD_COMPONENT_MASTER");
        $Component_model = new Application_Model_Component();
        $Component_form = new Application_Form_Component();
        $Component_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Component_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Component_form->isValid($this->getRequest()->getPost())) {
                        $data = $Component_form->getValues();

                        $bool = $Component_model->getcomponent($data['component']);

                        if (count($bool) == 0) {
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Component Added successfully';
                            $last_id = $Component_model->insert($data);
                        } else {
                            $_SESSION['message_class'] = 'alert-danger';
                            $message = 'Component "' . $data['component'] . ' already exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('master/componentmaster');
                    }
                }
                break;
            case 'edit':
                $result = $Component_model->getRecord($Component_id);

                $Component_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Component_form->isValid($this->getRequest()->getPost())) {
                        $data = $Component_form->getValues();

                        $Component_model->update($data, array('ge_id=?' => $Component_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/componentmaster');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($Component_id) {
                    $Component_model->update($data, array('Component_id=?' => $Component_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/Component');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Component_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    //Credit Master
    public function aeccAction() {
        $this->view->action_name = 'AECC';
        $this->view->sub_title_name = 'AECC';
        $this->accessConfig->setAccess("SA_ACAD_AECC");
        $Credit_model = new Application_Model_Aecc();
        $Credit_form = new Application_Form_Aecc();
        $credit_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Credit_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        //print_r($data);die;
                        $Credit_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/aecc');
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

                        $Credit_model->update($data, array('aecc_id=?' => $credit_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/aecc');
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

    //Credit Master
    public function aeccgeAction() {
        $this->view->action_name = 'AECCGE';
        $this->view->sub_title_name = 'AECCGE';
        $this->accessConfig->setAccess("SA_ACAD_AECC_GE");
        $Credit_model = new Application_Model_Aeccge();
        $Credit_form = new Application_Form_Aeccge();
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
                    $data = $this->getRequest()->getPost();
                    //  print_r($data);die;
                    $insertData = array(
                        'degree_id' => $data['degree_id'],
                        'ge_id' => $data['ge_id'],
                        'department' => $data['department'],
                        'status' => $data['status']
                    );
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $Credit_model->insert($insertData);
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('master/aeccge');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/aeccge');
                        }
                    }
                }
                break;
            case 'edit':
                $result = $Credit_model->getRecord($credit_id);

                $Credit_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    $data = $this->getRequest()->getPost();
                    $updateData = array(
                        'degree_id' => $data['degree_id'],
                        'ge_id' => $data['ge_id'],
                        'department' => $data['department'],
                        'status' => $data['status']
                    );
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $Credit_model->update($updateData, array('aeccge_id=?' => $credit_id));
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('master/aeccge');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/aeccge');
                        }
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
                //echo '<pre>';print_r($result);exit;
                $degree_model = new Application_Model_Degree();
                foreach ($result as $key => $value) {
                    $result[$key]['degree_id'] = $degree_model->getRecord($value['degree'])['degree'];
                }
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function sectionAction() {
        $this->view->action_name = 'sectionmaster';
        $this->view->sub_title_name = 'sectionmaster';
        $this->accessConfig->setAccess("SA_ACAD_SECTION");
        $section_model = new Application_Model_Section();
        $section_form = new Application_Form_Section();
        $id = $this->_getParam("id");

        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $section_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($section_form->isValid($this->getRequest()->getPost())) {
                        $data = $section_form->getValues();
                        // print_r($data);die;
                        //$bool = $section_model->getSection($data);

                        $insertData = array(
                            'year_id' => $data['year_id'],
                            'session' => $data['session'],
                            'academic_year_id' => $data['academic_year_id'],
                            'term_id' => $data['term_id'],
                            'name' => $data['name'],
                            'status' => $data['status']
                        );
                        if (!empty($_POST['csrftoken'])) {
                            if ($_POST['csrftoken'] === $token) {
                                $section_model->insert($insertData);
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                $this->_redirect('master/section');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/section');
                            }
                        }
                    }
                }
                break;
            case 'edit':
                $result = $section_model->getRecord($id);

                $section_form->removeElement('term_id');
                $term_model = new Application_Model_TermMaster();
                $data = $term_model->getDropDownListAcademic($result['academic_year_id']);
                $term_id = $section_form->createElement('select', 'term_id')
                    ->removeDecorator('label')
                    ->setAttrib('class', array('form-control', 'chosen-select'))
                    ->setAttrib('required', 'required')
                    ->removeDecorator("htmlTag")
                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data);
                $section_form->addElement($term_id);


                $section_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($section_form->isValid($this->getRequest()->getPost())) {
                        $data = $section_form->getValues();
                        //  print_r($data);die;
                        $updateData = array(
                            'year_id' => $data['year_id'],
                            'session' => $data['session'],
                            'academic_year_id' => $data['academic_year_id'],
                            'term_id' => $data['term_id'],
                            'name' => $data['name'],
                            'status' => $data['status']
                        );
                        if (!empty($_POST['csrftoken'])) {
                            if ($_POST['csrftoken'] === $token) {
                                $section_model->update($updateData, array('id=?' => $id));
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/section');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/section');
                            }
                        }
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($cc_id) {
                    $section_model->update($data, array('id=?' => $id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/section');
                }
                break;
            default:
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result = $section_model->getRecords();
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

    //To get filter section records
    public function ajaxGetFilterSectionRecordsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $section_model = new Application_Model_Section();
            $batch_id = $this->_getParam("batch_id");
            $result = $section_model->getRecordByBatchId($batch_id);

            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function coursefeeAction() {
        $this->view->action_name = 'Entrance';
        $this->view->sub_title_name = 'coursefee';
        $this->accessConfig->setAccess('SA_ACAD_FEE_HEADS');
        $exam_fee_form = new Application_Form_Coursefee();
        $student_assignment_model = new Application_Model_SubmitAssignment();
        $exam_fee_model = new Application_Model_Coursefee();
        $ec_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $status = $this->_getParam("update");
        $this->view->type = $type;
        $this->view->form = $exam_fee_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {

//                    if ($exam_fee_form->isValid($this->getRequest()->getPost())) {
                    $data = $_POST;
                    
                    $multidepts = $this->getRequest()->getPost('department');

                    $start_date = explode('/', $data['feeForm_start_date']);
                    $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];

                    $end_date = explode('/', $data['feeForm_end_date']);
                    $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];

                    $extend_date = explode('/', $data['feeForm_extended_date']);
                    $feeForm_extend_date = $extend_date[2] . "/" . $extend_date[1] . "/" . $extend_date[0];
                    $examdate = date('Y-m-d', strtotime($data['feeForm_extended_date']));
                       $row=$exam_fee_model->getPreSemFeeRecords($data['session_id'],$data['cmn_terms'],$multidepts,$data['academic_year'],$feeForm_start_date);
                       if(!empty($row)) {
                              $this->_refresh(5, '/academic/master/coursefee/', 'Department fees Schedule already created .!');
                           
                       } else {
                           
                   // echo "<pre>";print_r($row);die;
                    
                   // unset($data['academic_year']);
                    foreach ($multidepts as $deptkey => $dept_id) {
                        $insertData = array(
                            'academic_year' => $data['academic_year'],
                            'session_id' => $data['session_id'],
                            'cmn_terms' => $data['cmn_terms'],
                            'degree_id' => $data['degree_id'],
                            'department' => $data['department'][$deptkey],
                            //date_format($date,"d/m/Y");
                            'feeForm_start_date' => $feeForm_start_date,
                            'feeForm_end_date' => $feeForm_end_date,
                            'feeForm_extended_date' => $feeForm_extend_date,
                            'exam_date' => $examdate,
                            'examFee' => $data['examFee'],
                            'product_id' => $data['product_id'],
                            'account_no' => $data['account_no'],
                            'fineFee' => $data['fineFee'],
                            'exam_type' => $data['exam_type'],
                            'perday' => $data['perday']
                        );
                        $result = $exam_fee_model->insert($insertData);
                    }
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {

                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Application form has successfully submitted';

                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/coursefee');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/coursefee');
                        }
                    }
                       }
                }


                break;
            case 'edit':
                $result = $exam_fee_model->getRecord($ec_id);

                $start_date = date_create($result['feeForm_start_date']);
                $result['feeForm_start_date'] = date_format($start_date, "d/m/Y");

                $end_date = date_create($result['feeForm_end_date']);
                $result['feeForm_end_date'] = date_format($end_date, "d/m/Y");
                if ($result['feeForm_extended_date'] != '0000-00-00') {
                    $extend_date = date_create($result['feeForm_extended_date']);
                    $result['feeForm_extended_date'] = date_format($extend_date, "d/m/Y");
                } else {
                    $result['feeForm_extended_date'] = '';
                }
                if ($result['exam_date'] != '0000-00-00') {
                    $extend_date = date_create($result['exam_date']);
                    $result['exam_date'] = date_format($extend_date, "d/m/Y");
                } else {
                    $result['exam_date'] = '';
                }
                $exam_fee_form->populate($result);


                $this->view->result = $result;
                //echo "<pre>";print_r($result);die;
                if ($this->getRequest()->isPost()) {
                    if ($exam_fee_form->isValid($this->getRequest()->getPost())) {

                        $multidepts = $this->getRequest()->getPost('department');
                        $data = $exam_fee_form->getValues();
                        $start_date = explode('/', $data['feeForm_start_date']);
                        $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];

                        $end_date = explode('/', $data['feeForm_end_date']);
                        $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];

                        $extend_date = explode('/', $data['feeForm_extended_date']);
                        $feeForm_extend_date = $extend_date[2] . "/" . $extend_date[1] . "/" . $extend_date[0];
                        $extend_date = explode('/', $data['exam_date']);
                        $exam_date = $extend_date[2] . "/" . $extend_date[1] . "/" . $extend_date[0];

                        //echo "<pre>";print_r($feeForm_start_date);
                        $data['feeForm_start_date'] = $feeForm_start_date;
                        $data['feeForm_end_date'] = $feeForm_end_date;
                        $data['feeForm_extended_date'] = $feeForm_extend_date;
                        foreach ($multidepts as $deptkey => $dept_id) {
                        $updateData = array(
                            'academic_year' => $data['academic_year'],
                            'session_id' => $data['session_id'],
                            'cmn_terms' => $data['cmn_terms'],
                            'degree_id' => $data['degree_id'],
                            'department' => $data['department'][$deptkey],
                            //date_format($date,"d/m/Y");
                            'feeForm_start_date' => $feeForm_start_date,
                            'feeForm_end_date' => $feeForm_end_date,
                            'feeForm_extended_date' => $feeForm_extend_date,
                            'examFee' => $data['examFee'],
                            'exam_date' => $exam_date,
                            'product_id' => $data['product_id'],
                            'account_no' => $data['account_no'],
                            'fineFee' => $data['fineFee'],
                            'exam_type' => $data['exam_type'],
                            'perday' => $data['perday']
                        );
                        $exam_fee_model->update($updateData, array('id=?' => $ec_id));
                        }
                        // echo "<pre>";print_r($data['csrftoken']); echo $token;die;
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                
                                unset($_SESSION["token"]);

                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Examination Fee Form has been Successfully updated !');
                                $this->_redirect('master/coursefee');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/coursefee');
                            }
                        }
                    }
                }

                break;
            case 'delete':
                if ($status == 0) {
                    $data['status'] = '1';
                } else {
                    $data['status'] = '0';
                }
                if ($ec_id) {
                    $exam_fee_model->update($data, array('id=?' => $ec_id));

                    $this->_flashMessenger->addMessage('Examination Fee Form has been Successfully deleted ');
                    $this->_redirect('master/coursefee');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result1 = array();
                $result = $exam_fee_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );

                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function ajaxLockUnlockExamFeeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $exam_fee_model = new Application_Model_Coursefee();
            $id = $this->_getParam("id");
            $status = $this->_getParam("status_id");

            if ($status == 1) {
                $data['status'] = 0;
                //echo '<pre>'; print_r($data);exit;
                $exam_fee_model->update($data, array('id=?' => $id));
                echo 'Unlocked';
            } else {
                $data['status'] = 1;
                //echo '<pre>'; print_r($data);exit;
                $exam_fee_model->update($data, array('id=?' => $id));
                echo 'Locked';
            }
        }die;
    }

    public function ajaxGetCourseFeeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $feeCollection = new Application_Model_FeesCollection();
            $examfeeStr = new Application_Model_Coursefee();
            $academic_id = $this->_getParam("academic_id");
            $sem = $this->_getParam("sem");
            $pay = $this->_getParam("pay");
            $attendance = $this->_getParam("attend");
            $session_id = $this->_getParam("session_id");
            $type = $this->_getParam("type");
            $result = $examfeeStr->getSemFeeRecords($session_id, $sem,"",$type);
            $paginator_data = array(
                'result' => $result,
            );

            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->semester = $sem;
            $this->view->payment = $pay;
            $this->view->semFee = $semFee;
            $this->view->examFee = $totexamfee;

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function createtuitionfeesAction() {
        $this->view->action_name = 'Entrance';
        $this->view->sub_title_name = 'createtuitionfees';
        $this->accessConfig->setAccess('SA_ACAD_FEE_HEADS');

        $exam_fee_form = new Application_Form_Tuitionfees();

        $exam_fee_model = new Application_Model_Tuitionfees();
        $ec_id = $this->_getParam("id");
        $status = $this->_getParam("update");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $exam_fee_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {

//                    if ($exam_fee_form->isValid($this->getRequest()->getPost())) {

                    $data = $_POST;
                    //echo "<pre>";print_r($data);die;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $multidepts = $this->getRequest()->getPost('department');
//                                $checkvalues = $exam_fee_model->isRecordExists($data['cmn_terms'], $data['degree_id'], $data['department'], $data['session_id']);
//                                if ($checkvalues) {
//                                    $this->_refresh(5, '/academic/master/createtuitionfees/', 'Depatment Schedule already created .!');
//                                } else {
                            $start_date = explode('/', $data['feeForm_start_date']);
                            $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];

                            $end_date = explode('/', $data['feeForm_end_date']);
                            $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];

                            $extend_date = explode('/', $data['feeForm_extended_date']);
                            $feeForm_extend_date = $extend_date[2] . "/" . $extend_date[1] . "/" . $extend_date[0];
                            unset($data['academic_year']);
                            foreach ($multidepts as $deptkey => $dept_id) {
                                $insertData = array(
                                    'session_id' => $data['session_id'],
                                    'cmn_terms' => $data['cmn_terms'],
                                    'degree_id' => $data['degree_id'],
                                    'department' => $data['department'][$deptkey],
                                    'feeForm_start_date' => $feeForm_start_date,
                                    'feeForm_end_date' => $feeForm_end_date,
                                    'feeForm_extended_date' => $feeForm_extend_date,
                                    'fineFee' => $data['fineFee'],
                                    'perday_number' => $data['perday_number'],
                                    'product_id' => $data['product_id'],
                                    'account_number' => $data['account_number']
                                );

                                //echo "<pre>";print_r($insertData);die;
                                $result = $exam_fee_model->insert($insertData);
                            }
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $message = 'Tuition fees has successfully submitted';

                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/createtuitionfees');
                            //}
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/createtuitionfees');
                        }
                    }
                    //}
                }


                break;
            case 'edit':
                $result = $exam_fee_model->getRecord($ec_id);

                $start_date = date_create($result['feeForm_start_date']);
                $result['feeForm_start_date'] = date_format($start_date, "d/m/Y");

                $end_date = date_create($result['feeForm_end_date']);
                $result['feeForm_end_date'] = date_format($end_date, "d/m/Y");

                $extend_date = date_create($result['feeForm_extended_date']);
                $result['feeForm_extended_date'] = date_format($extend_date, "d/m/Y");

                $exam_fee_form->populate($result);


                $this->view->result = $result;

                //echo "<pre>";print_r($_POST);die;
                if ($this->getRequest()->isPost()) {
                    $data = $_POST;
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {

                            $multidepts = $this->getRequest()->getPost('department');

                            $start_date = explode('/', $data['feeForm_start_date']);
                            $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];

                            $end_date = explode('/', $data['feeForm_end_date']);
                            $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];

                            $extend_date = explode('/', $data['feeForm_extended_date']);
                            $feeForm_extend_date = $extend_date[2] . "/" . $extend_date[1] . "/" . $extend_date[0];

                            //echo "<pre>";print_r($feeForm_start_date);
                            $data['feeForm_start_date'] = $feeForm_start_date;
                            $data['feeForm_end_date'] = $feeForm_end_date;
                            $data['feeForm_extended_date'] = $feeForm_extend_date;
                            //echo "<pre>";print_r($data);die;
                            unset($data['academic_year']);
                            foreach ($multidepts as $deptkey => $dept_id) {
                            $updateData = array(
                                'session_id' => $data['session_id'],
                                'cmn_terms' => $data['cmn_terms'],
                                'degree_id' => $data['degree_id'],
                               'department' => $data['department'][$deptkey],
                                //date_format($date,"d/m/Y");
                                'feeForm_start_date' => $feeForm_start_date,
                                'feeForm_end_date' => $feeForm_end_date,
                                'feeForm_extended_date' => $feeForm_extend_date,
                                'fineFee' => $data['fineFee'],
                                'perday_number' => $data['perday_number'],
                                'product_id' => $data['product_id'],
                                'account_number' => $data['account_number']
                            );
                            $exam_fee_model->update($updateData, array('id=?' => $ec_id));
                            unset($_SESSION["token"]);
                            }
//                        }

                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Tuition Fee has been Successfully updated !');
                            $this->_redirect('master/createtuitionfees');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/createtuitionfees');
                        }
                    }
                    // }
                }


                break;
            case 'delete':

                if ($status == 0) {
                    $data['status'] = '1';
                } else {
                    $data['status'] = '0';
                }

                if ($ec_id) {
                    $exam_fee_model->update($data, array('id=?' => $ec_id));

                    $this->_flashMessenger->addMessage('Schedule Deactive Successfully');
                    $this->_redirect('master/createtuitionfees');
                }
                break;
            default:
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result1 = array();
//                $result = $exam_fee_model->getFeesRecords();
//                $page = $this->_getParam('page', 1);
//                $paginator_data = array(
//                    'page' => $page,
//                    'result' => $result
//                );
//
//                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function ajaxLockUnlockTuitionFeeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $exam_fee_model = new Application_Model_Tuitionfees();
            $id = $this->_getParam("id");
            $status = $this->_getParam("status_id");

            if ($status == 1) {
                $data['status'] = 0;
                //echo '<pre>'; print_r($data);exit;
                $exam_fee_model->update($data, array('id=?' => $id));
                echo 'Unlocked';
            } else {
                $data['status'] = 1;
                //echo '<pre>'; print_r($data);exit;
                $exam_fee_model->update($data, array('id=?' => $id));
                echo 'Locked';
            }
        }die;
    }

    public function ajaxFilterTuitionFeesAction() {
        $this->_helper->layout->disableLayout();
        $re_model = new Application_Model_Tuitionfees();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree = $this->_getParam("degree");
            $session = $this->_getParam("session");
            $term = $this->_getParam("cmn_term");
            $result = $re_model->getFilterFeesRecords($session, $term, $degree);
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );

            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function entranceExamScheduleAction() {
        $this->view->action_name = 'Entrance';
        $this->view->sub_title_name = 'entrance';
        $this->accessConfig->setAccess('SA_ACAD_FEE_HEADS');

        $exam_fee_form = new Application_Form_EntranceExamSchedule();
        $exam_schedule_model = new Application_Model_EntranceExamScheduleModel();

        $ec_id = $this->_getParam("id");
        $status = $this->_getParam("update");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $exam_fee_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($exam_fee_form->isValid($this->getRequest()->getPost())) {
                        $data = $_POST;
                        //echo "<pre>";print_r($data);die;
                        $multidepts = $this->getRequest()->getPost('department');
                        $start_date = explode('/', $data['feeForm_start_date']);
                        $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];

                        $end_date = explode('/', $data['feeForm_end_date']);
                        $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];

                        $exm_date = explode('/', $data['exam_date']);
                        $exam_date = $exm_date[2] . "/" . $exm_date[1] . "/" . $exm_date[0];
                        foreach ($multidepts as $deptkey => $dept_id) {
                            $insertData = array(
                                'session_id' => $data['session_id'],
                                'degree_id' => $data['degree_id'],
                                'department' => $data['department'][$deptkey],
                                'feeForm_start_date' => $feeForm_start_date,
                                'feeForm_end_date' => $feeForm_end_date,
                                'exam_date' => $exam_date,
                                'examFee' => $data['examFee'],
                                'product_id' => $data['product_id'],
                                'account_no' => $data['account_no'],
                                'examtime_start' => $data['examtime_start'],
                                'examtime_end' => $data['examtime_end']
                            );

                            //echo "<pre>";print_r($data);die;
                            $result = $exam_schedule_model->insert($insertData);
                        }
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {

                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $message = 'Application form has successfully submitted';

                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/entrance-exam-schedule');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/entrance-exam-schedule');
                            }
                        }
                    }
                }


                break;
            case 'edit':
                $result = $exam_schedule_model->getRecord($ec_id);

                $start_date = date_create($result['feeForm_start_date']);
                $result['feeForm_start_date'] = date_format($start_date, "d/m/Y");

                $end_date = date_create($result['feeForm_end_date']);
                $result['feeForm_end_date'] = date_format($end_date, "d/m/Y");

                $extend_date = date_create($result['exam_date']);
                $result['exam_date'] = date_format($extend_date, "d/m/Y");

                $exam_fee_form->populate($result);


                $this->view->result = $result;
                //echo "<pre>";print_r($result);die;
                if ($this->getRequest()->isPost()) {
                    if ($exam_fee_form->isValid($this->getRequest()->getPost())) {


                        $data = $exam_fee_form->getValues();
                        $multidepts = $this->getRequest()->getPost('department');
                        $start_date = explode('/', $data['feeForm_start_date']);
                        $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];

                        $end_date = explode('/', $data['feeForm_end_date']);
                        $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];

                        $exm_date = explode('/', $data['exam_date']);
                        $exam_date = $exm_date[2] . "/" . $exm_date[1] . "/" . $exm_date[0];
                        //echo "<pre>";print_r($data);
                        //die;
                        // echo "<pre>";print_r($_POST);
                        foreach ($multidepts as $deptkey => $dept_id) {
                        $updateData = array(
                            'session_id' => $data['session_id'],
                            'degree_id' => $data['degree_id'],
                            'department' => $data['department'][$deptkey],
                            'feeForm_start_date' => $feeForm_start_date,
                            'feeForm_end_date' => $feeForm_end_date,
                            'exam_date' => $exam_date,
                            'examFee' => $data['examFee'],
                            'product_id' => $data['product_id'],
                            'account_no' => $data['account_no'],
                            'examtime_start' => $data['examtime_start'],
                            'examtime_end' => $data['examtime_end']
                        );
                        $exam_schedule_model->update($updateData, array('id=?' => $ec_id));
                        }
                        //echo "<pre>";print_r($data);die;
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Examination Fee Form has been Successfully updated !');
                                $this->_redirect('master/entrance-exam-schedule');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/entrance-exam-schedule');
                            }
                        }
                    }
                }

                break;
            case 'delete':
                
                //echo $status;
               // die();
                if ($status == 0) {
                    $data['allow_reg'] = '1';
                } else {
                    $data['allow_reg'] = '0';
                }
                if ($ec_id) {
                    $exam_schedule_model->update($data, array('id=?' => $ec_id));

                    $this->_flashMessenger->addMessage('Evaluation Component Deleted Successfully');
                    $this->_redirect('master/entrance-exam-schedule');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result1 = array();
                $result = $exam_schedule_model->getRecords();
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );

                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    //Bulk Update for entrance start date
    public function ajaxUpdateEntranceStartDateAction(){
        $exam_schedule_model = new Application_Model_EntranceExamScheduleModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $startDate = $this->_getParam("startDate");
            $start_date = explode('/', $startDate);
            $feeForm_start_date = $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0];
            
            $exam_schedule_model->updateFormStartDate($feeForm_start_date);
            echo 'Updated'; die;
        }
        
    }
    public function ajaxUpdateEntranceEndDateAction(){
        $exam_schedule_model = new Application_Model_EntranceExamScheduleModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $endDate = $this->_getParam("endDate");
            $end_date = explode('/', $endDate);
            $feeForm_end_date = $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0];
            
            $exam_schedule_model->updateFormEndDate($feeForm_end_date);
            echo 'Updated'; die;
        }
        
    }
    public function ajaxUpdateEntranceExamDateAction(){
        $exam_schedule_model = new Application_Model_EntranceExamScheduleModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $examDate = $this->_getParam("examDate");
            $exam_date = explode('/', $examDate);
            $feeForm_exam_date = $exam_date[2] . "/" . $exam_date[1] . "/" . $exam_date[0];
            
            $exam_schedule_model->updateFormExamDate($feeForm_exam_date);
            echo 'Updated'; die;
        }
        
    }
    //Session MAster
    public function sessionAction() {
        $this->view->action_name = 'session';
        $this->view->sub_title_name = 'session';
        $this->accessConfig->setAccess('SA_ACAD_COURSE_CAT');
        $Coursecategory_model = new Application_Model_Session();
        $Coursecategory_form = new Application_Form_Session();
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
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();
                        //print_r($data); die();
                        $insertData = array(
                            'session' => $data['session'],
                            'acad_year_id' => $data['acad_year_id'],
                            'status' => $data['status'],
                            'created_date' => date('Y-m-d')
                        );
                        // $data['created_date'] = date('Y-m-d');
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $bool = $Coursecategory_model->getSession($data['session']);
                                if (count($bool) == 0) {
                                    $_SESSION['message_class'] = 'alert-success';
                                    $message = 'Session Added successfully';

                                    $last_id = $Coursecategory_model->insert($insertData);
                                    
                                } else {
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $message = 'Session "' . $data['session'] . ' already exist\'s"';
                                }
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/session');
                            }
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/session');
                        }
                    }
                }
                break;
            case 'edit':

                $result = $Coursecategory_model->getRecord($cc_id);
                $result['academic_year_list'] = $result['acad_year_id'];
                $Coursecategory_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();
                        $updateData = array(
                            'session' => $data['session'],
                            'acad_year_id' => $data['acad_year_id'],
                            'status' => $data['status'],
                            'last_modified_date' => date('Y-m-d')
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
 $bool = $Coursecategory_model->getSession($updateData['session']);
                                if (count($bool) > 0) {
                                
                                unset($updateData['session']);
                               
                                }
                               
                                $Coursecategory_model->update($updateData, array('id=?' => $cc_id));
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/session');
                                
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/session');
                            }
                        }
                    } else {
                        
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
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Coursecategory_model->getRecords();



                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    //Account MAster
    public function accountAction() {
        $this->view->action_name = 'accounts';
        $this->view->sub_title_name = 'accounts';
        $this->accessConfig->setAccess('SA_ACAD_ACC');
        $Coursecategory_model = new Application_Model_Account();
        $Coursecategory_form = new Application_Form_Account();
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
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();

                        // $data['created_date'] = date('Y-m-d');
                        // echo '<pre>'; print_r($data);  die();
                        $insertData = array(
                            'acc_name' => $data['acc_name'],
                            'acc_number' => $data['acc_number'],
                            'created_date' => date('Y-m-d'),
                            'status' => $data['status']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {

                                $bool = $Coursecategory_model->getSession($data['acc_number']);
                                if (count($bool) == 0) {
                                    $_SESSION['message_class'] = 'alert-success';
                                    $message = 'Department Added successfully';

                                    $last_id = $Coursecategory_model->insert($insertData);
                                    unset($_SESSION["token"]);
                                } else {
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $message = 'Department "' . $data['department'] . ' already exist\'s"';
                                }
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/account');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/account');
                            }
                        }
                    }
                }
                break;
            case 'edit':

                $result = $Coursecategory_model->getRecord($cc_id);
///print_r($result) ;die();
                $Coursecategory_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();

                        //  $data['last_modified_date'] = date('Y-m-d');
                        $updateData = array(
                            'acc_name' => $data['acc_name'],
                            'acc_number' => $data['acc_number'],
                            'last_modified_date' => date('Y-m-d'),
                            'status' => $data['status']
                        );
                        // $data1 = array('department' => 0);
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Coursecategory_model->update($updateData, array('id=?' => $cc_id));
                                unset($_SESSION["token"]);
                                //$academic->update($data1, array('department =?' => $cc_id));

                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/account');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/account');
                            }
                        }
                    } else {
                        
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
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Coursecategory_model->getRecords();



                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

  //Degree MAster
    public function degreeAction() {
        $this->view->action_name = 'degree';
        $this->view->sub_title_name = 'degree';
        $this->accessConfig->setAccess('SA_ACAD_COURSE_CAT');
        $Degree_model = new Application_Model_Degree();
        $Degree_form = new Application_Form_Degree();
        $cc_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Degree_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Degree_form->isValid($this->getRequest()->getPost())) {
                        $data = $Degree_form->getValues();

                        $data['created_date'] = date('Y-m-d');


                        $bool = $Degree_model->getDegree($data['degree']);
                        if (count($bool) == 0) {
                            $_degree['message_class'] = 'alert-success';
                            $message = 'Degree Added successfully';

                            $last_id = $Degree_model->insert($data);
                        } else {
                            $_degree['message_class'] = 'alert-danger';
                            $message = 'Degree "' . $data['degree'] . ' already exist\'s"';
                        }
                        $this->_flashMessenger->addMessage($message);
                        $this->_redirect('master/degree');
                    }
                }
                break;
            case 'edit':

                $result = $Degree_model->getRecord($cc_id);

                $Degree_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Degree_form->isValid($this->getRequest()->getPost())) {
                        $data = $Degree_form->getValues();

                        $data['last_modified_date'] = date('Y-m-d');
                        // $data1 = array('department' => 0);
                        $bool = $Degree_model->getDegree($data['degree']);
                     
                        if (count($bool) > 0) {
                        unset($data['degree']);
                        }
$Degree_model->update($data, array('id=?' => $cc_id));
                        //$academic->update($data1, array('department =?' => $cc_id));

                        $_degree['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/degree');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($cc_id) {
                    $Degree_model->update($data, array('cc_id=?' => $cc_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/degree');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Degree_model->getRecords();



                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    //Course Category Master
    public function coursecategoryAction() {
        $this->view->action_name = 'coursecategory';
        $this->view->sub_title_name = 'coursecategory';
        $this->accessConfig->setAccess('SA_ACAD_COURSE_CAT');
        $Coursecategory_model = new Application_Model_Coursecategory();
        $Coursecategory_form = new Application_Form_Coursecategory();
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
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();
                        $insertData = array(
                            'cc_name' => $data['cc_name'],
                            'cc_description' => $data['cc_description'],
                            'degree_id' => $data['degree_id'],
                            'status' => $data['status']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                // print_r($data);die;
                                $Coursecategory_model->insert($insertData);
                                unset($_SESSION["token"]);
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                $this->_redirect('master/coursecategory');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/coursecategory');
                            }
                        }
                    }
                }
                break;
            case 'edit':
                $result = $Coursecategory_model->getRecord($cc_id);
                $Coursecategory_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();
                        $updateData = array(
                            'cc_name' => $data['cc_name'],
                            'cc_description' => $data['cc_description'],
                            'degree_id' => $data['degree_id'],
                            'status' => $data['status']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Coursecategory_model->update($updateData, array('cc_id=?' => $cc_id));
                                unset($_SESSION["token"]);
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/coursecategory');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/coursecategory');
                            }
                        }
                    } else {
                        
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
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Coursecategory_model->getRecords();
                $degree_model = new Application_Model_Degree();
                foreach ($result as $key => $value) {
                    $result[$key]['degree_id'] = $degree_model->getRecord($value['degree_id'])['degree'];
                }

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function roommasterAction() {
        $this->view->action_name = 'roommaster';
        $this->view->sub_title_name = 'roommaster';
        $Coursecategory_model = new Application_Model_Coursecategory();
        $Coursecategory_form = new Application_Form_Coursecategory();
        $cc_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Coursecategory_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();
                        //print_r($data);die;
                        $Coursecategory_model->insert($data);
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/coursecategory');
                    }
                }
                break;
            case 'edit':
                $result = $Coursecategory_model->getRecord($cc_id);
                $Coursecategory_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Coursecategory_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursecategory_form->getValues();

                        $Coursecategory_model->update($data, array('cc_id=?' => $cc_id));
                        $this->_flashMessenger->addMessage('Details Updated Successfully');
                        $this->_redirect('master/coursecategory');
                    } else {
                        
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
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Coursecategory_model->getRecords();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
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
 public function getCourseCategoryIdAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $Coursecategory_model = new Application_Model_Coursecategory();
            $degree_id = $this->_getParam("degree_id");
            //print_r($course_name);die;
            $result = $Coursecategory_model->getRecordByDegreeId($degree_id);
            foreach($result as $key => $value){
                echo '<option value ="'.$value['cc_id'].'" label = "'.$value['cc_name'].'">'.$value['cc_name'].'</option>';
            }
           // print_r($result);
            die;
        }
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

    public function ajaxAddTimeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $time = $this->_getParam('time');
            $hour = $this->_getParam('minutes');
            $time = date('H:i', strtotime($time));
            $time = date('h:i A', strtotime("+$hour minutes", strtotime($time)));
            echo $time;
            die;
        }
    }

    public function classmasterAction() {
        $this->view->action_name = 'classmaster';
        $this->view->sub_title_name = 'classmaster';
        $this->accessConfig->setAccess('SA_ACAD_CLASS');
        $ClassMaster_model = new Application_Model_ClassMaster();
        $CLassMaster_form = new Application_Form_ClassMaster();
        $class_id = $this->_getParam("id");
        $type = $this->_getParam("type");

        $this->view->type = $type;
        $this->view->form = $CLassMaster_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                $messages = $this->_flashMessenger->getMessages();


                if (is_array($_POST)) {
                    if (count($_POST['class_name']) > 0) {
                        $class_name = $_POST['class_name'];
                        $status = $_POST['status'];
                        $time = $_POST['time'];
                        $hours = $_POST['hours'];
                        $data['academic_year_id'] = 0;
                        $data['term_id'] = 0;
                        unset($data['ccl_id']);
                        for ($i = 0; $i < count($class_name); $i++) {
                            $data['class_name'] = $class_name[$i];
                            $data['time'] = $time[$i];
                            $data['status'] = $status[$i];
                            $data['hours'] = $hours[$i];
                            $ClassMaster_model->insert($data);
                        }

                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/classmaster');
                    }
                }
                break;
            case 'edit':

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $ClassMaster_model->getRecordByTermID(0);


                $this->view->classes = $result;

///echo '<pre>'; print_r($_POST['csrftoken']);  die();

                if (is_array($_POST)) {
                    if (count($_POST['class_name']) > 0) {
                        unset($_POST['count_val']);
                        if (!empty($_POST['csrftoken'])) {
                            if ($_POST['csrftoken'] === $token) {
                                // echo "<pre>";print_r($_POST); exit;
                                $data = array();

                                foreach ($_POST as $field_name => $field_arr) {
                                    foreach ($field_arr as $key => $value) {
                                        $data[$key][$field_name] = $value;
                                        $data[$key]['class_id'] = $key;
                                        $data[$key]['academic_year_id'] = 0;
                                        $data[$key]['term_id'] = 0;
                                    }
                                }
                                unset($data['credit_val']);
                                foreach ($data as $key => $value) {
                                    $result = $ClassMaster_model->getRecord($value['class_id']);
                                    unset($value['electives']);
                                    $class_id = $value['class_id'];
                                    if (!empty($result)) {
                                        unset($value['class_id']);
                                        $ClassMaster_model->update($value, array('class_id=?' => $class_id));
                                        unset($_SESSION["token"]);
                                    } else {
                                        $ClassMaster_model->insert($value);
                                        unset($_SESSION["token"]);
                                    }
                                }
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');

                                $this->_redirect('master/classmaster/type/edit');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/classmaster/type/edit');
                            }
                        }
                    } else {
                        
                    }
                }

                break;

            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $ClassMaster_model->getRecords();
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
    public function corecourselearningAction() {
        $this->view->action_name = 'corecourselearning';
        $this->view->sub_title_name = 'corecourselearning';
        $this->accessConfig->setAccess('SA_ACAD_CORE_COURSE');
        $Corecourselearning_model = new Application_Model_Corecourselearning();
        $Corecourselearning_form = new Application_Form_Corecourselearning();
        $ccl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $bulktype = $this->_getParam("bulktype");
        $this->view->type = $type;
        $this->view->bulktype = $bulktype;
        $this->view->form = $Corecourselearning_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "bulkadd":
                if ($this->getRequest()->isPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            echo "<pre>";
                            print_r($data);
                            exit;

                            $data = $Corecourselearning_form->getValues();
                            $data = $_POST;
                            $data['re_credit'] = $this->getRequest()->getPost('re_credit');
                            //    unset($data['ge_id']);
                            unset($data['csrftoken']);
                            unset($data['academic_year']);
                            unset($data['tot_credit']);
                            $Corecourselearning_model->insert($data);
                            unset($_SESSION["token"]);
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('master/corecourselearning');
                        }
                    }
                }
                break;
            case "add":
                if ($this->getRequest()->isPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            // echo "<pre>";print_r($data);exit;

                            $data = $Corecourselearning_form->getValues();
                            $data = $_POST;
                            $data['re_credit'] = $this->getRequest()->getPost('re_credit');
                            //    unset($data['ge_id']);
                            unset($data['csrftoken']);
                            unset($data['academic_year']);
                            unset($data['tot_credit']);
                            $Corecourselearning_model->insert($data);
                            unset($_SESSION["token"]);
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('master/corecourselearning');
                        }
                    }
                }
                break;
            case 'edit':

                // echo "<pre>";print_r($data);exit;
                $result = $Corecourselearning_model->getRecord($ccl_id);
                $last_id = $ccl_id;
                $last_record_result = $Corecourselearning_model->getRecord($last_id);
                $Term_model = new Application_Model_TermMaster();
                $data = $Term_model->getTermDropDownList($last_record_result['academic_year_id']);
                //print_r($data); die;
                $Corecourselearning_form->getElement('term_id')->setAttrib('style', array("display", "initial"));
                $employee_id = $Corecourselearning_form->createElement('select', 'term_id');
                $employee_id->setAttrib('class', array('form-control', 'chosen-select'));
                $employee_id->setAttrib('required', 'required');
                //$employee_id->removeDecorator("htmlTag");
                $employee_id->addMultiOptions(array('' => 'Select'));
                $employee_id->setRegisterInArrayValidator(false);
                $employee_id->addMultiOptions($data);
                $Corecourselearning_form->addElement($employee_id);

                $this->view->last_result = $last_record_result;
                $Corecourselearning_form->populate($result);
                $this->view->result = $result;
                $course_model = new Application_Model_Course();
                $data = $course_model->getDropDownList();
                $course_result = $course_model->getRecord($result['course_id']);
                $data[$result['course_id']] = $course_result['course_code'];
                // ksort($data);
                $Corecourselearning_form->getElement("course_id")
                    ->setAttrib('readonly', 'readonly')
                    ->setAttrib('class', array('form-control'))
                    ->setMultiOptions($data);


                if ($this->getRequest()->isPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            $data = $Corecourselearning_form->getValues();

                            $data['re_credit'] = $this->getRequest()->getPost('re_credit');
                            $data = $_POST;
                            //echo '<pre>';print_r($data);exit;
                            unset($data['csrftoken']);
                            unset($data['academic_year']);
                            unset($data['tot_credit']);
                            $Corecourselearning_model->update($data, array('ccl_id=?' => $ccl_id));
                            unset($_SESSION["token"]);
                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('master/corecourselearning');
                        }
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
                $batchAttendance_form = new Application_Form_BatchAttendance();
                $this->view->form = $batchAttendance_form;
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                /* $result = $Corecourselearning_model->getRecords();
                  $page = $this->_getParam('page', 1);
                  $paginator_data = array(
                  'page' => $page,
                  'result' => $result
                  );
                  //echo "<pre>";print_r($paginator_data);die;
                  $this->view->paginator = $this->_act->pagination($paginator_data); */
                break;
        }
    }

    public function courseMigrationAction() {
        $this->view->action_name = 'corecourselearning';
        $this->view->sub_title_name = 'corecourselearning';
        $this->accessConfig->setAccess('SA_ACAD_CORE_COURSE');
        $Corecourselearning_model = new Application_Model_Corecourselearning();
        $Corecourselearning_form = new Application_Form_Coursemigration();
        $departmentModel = new Application_Model_Department();
        $termModel = new Application_Model_TermMaster();
        $this->view->type = $type;
        $this->view->bulktype = $bulktype;
        $this->view->form = $Corecourselearning_form;
        $messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        if ($this->getRequest()->isPost()) {
            //echo "<pre>"; print_r($_POST);exit;
            if (!empty($_POST['csrftoken'])) {
                if ($_POST['csrftoken'] === $token) {

                    $data = $_POST;

                    unset($data['csrftoken']);
                    unset($data['academic_year']);
                    unset($data['tot_credit']);
                    $notaddeddepartment = False;
                    //echo "<pre>";print_r($data['mig_academic_id']);exit;
                    foreach($data['mig_academic_id'] as $migkey => $migval){
                        $data['mig_academic_id']  = $migval;
                        $deptres = $departmentModel->getRecordbyAcademic($migval);
                        $dept_id = $deptres['department_id'];
                        foreach($data['mig_term_id'] as $migtermkey => $migtermval){
                        $term_res = $termModel->getTermRecordsbycmn($migval,$migtermval);
                        
                        if(!$term_res['term_id'])
                        continue;
                        
                    
                        foreach ($data['course_id'][$dept_id][$migtermval] as $key => $course) {
                            $checkExistedData = $Corecourselearning_model->checkExistedDatabycourseid($data['mig_academic_id'], $term_res['term_id'],$data['course_id'][$dept_id][$migtermval][$key]);
                            if (empty($checkExistedData)) {
                          //  echo "<pre>"; print_r($course);exit();
                            $migData[] = array(
                                'academic_year_id' => $data['mig_academic_id'],
                                'term_id' => $term_res['term_id'],
                                'course_id' => $data['course_id'][$dept_id][$migtermval][$key],
                                'course_code' => $data['course_code'][$dept_id][$migtermval][$key],
                                'cc_id' => $data['cc_id'][$dept_id][$migtermval][$key],
                                'credit_id' => $data['credit_id'][$dept_id][$migtermval][$key],
                                're_credit' => $data['re_credit'][$dept_id][$migtermval][$key],
                                'ge_id' => $_POST['ge_id'][$dept_id][$migtermval][$key],
                                'count_id' => $_POST['count_id'][$dept_id][$migtermval][$key],
                                'cmn_terms' => $_POST['cmn_terms'][$dept_id][$migtermval][$key],
                                'degree_id' => $_POST['degree_id'][$dept_id][$migtermval][$key]
                                
                            );
                            
                            //$Corecourselearning_model->insert($migData);
                        }
                        else
                        continue;
                        
                    }
                    unset($_SESSION["token"]);
                    }
                }
                if($migData){
                $Corecourselearning_model->saveRows($migData);
                }
                if($notaddeddepartment){
                
                   $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage(implode(",",array_unique($notaddeddepartment)).' Batch Already Exists! ');
                        $this->_redirect('master/course-migration');
                }
                else
                {
                    $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/corecourselearning'); 
                }
                
                }
            }
        }
    }

    public function ajaxGetCoreCourseMasterAction() {
        $cclModel = new Application_Model_Corecourselearning();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_id");
            $term_id = $this->_getParam("term_id");

            $result = $cclModel->getCourseAll($academic_year_id, $term_id);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    //get Data by session and course group in core course learning
    public function ajaxGetStudentByCourseGroupAction() {

        $this->_helper->layout->disableLayout();
        $coreCourseLearning = new Application_Model_Corecourselearning();


        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $course_group = $this->_getParam("course_group");


            if ($session_id) {
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;

                $result = $coreCourseLearning->getRecordsByCourseGroup($session_id, $course_group);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
            }
        }
    }

//ajax get Department
    public function ajaxGetGeAction() {
        $Aeccge_course = new Application_Model_Aeccge();
        $batch = new Application_Model_Academic();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_id");
            $term_id = $this->_getParam("term_id");
            $geid = $this->_getParam("electid");
            
             $geid=explode(',',$geid); 
             //print_r($geid);

            $result = $batch->getRecord($academic_year_id);

            $department_id = $result['department'];
             // echo $department_id;die;
            $result = $Aeccge_course->getRecordByDepartment($department_id, $academic_year_id);
          
            echo '<option value ="" label="Select">Select</optional>';
            $isExist = array();
            foreach ($result as $key => $value) {
               
                
                if (!in_array($value['ge_id'], $isExist)) {
                    
                    $isExist[] = $value['ge_id']; ?>
                    <option value ="<?php echo $value['ge_id'] ?>" label ="<?php echo $value['general_elective_name']?>" <?php for($i=0;$i<count($geid);$i++){ if($value['ge_id']==$geid[$i]) { echo "selected";}}?>><?php echo $value['general_elective_name']?> </option>
               <?php }
            }
               
        }die;
    }

    public function ajaxGetGe2Action() {
        $Aeccge_course = new Application_Model_Aeccge();
        $batch = new Application_Model_Academic();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_id");
            $term_id = $this->_getParam("term_id");
            $cc_id = $this->_getParam('cc_id');

            $result = $batch->getRecord($academic_year_id);

            $department_id = $result['department'];
            //  echo $department_id;die;
            $result = $Aeccge_course->getRecordByDepartment($department_id, $academic_year_id, $term_id, $cc_id);

            echo '<option value ="" label="Select">Select</optional>';
            $isExist = array();
            foreach ($result as $key => $value) {
                if (!in_array($value['ge_id'], $isExist)) {
                    $isExist[] = $value['ge_id'];
                    echo '<option value ="' . $value['ge_id'] . '" label = "' . $value['general_elective_name'] . '">' . $value['general_elective_name'] . '</option>';
                }
            }
        }die;
    }

    public function ajaxGetGe1Action() {
        $Aeccge_course = new Application_Model_Aeccge();
        $batch = new Application_Model_Academic();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_id");
            $degree_id = $this->_getParam("degree_id");

            $result = $batch->getRecord($academic_year_id);

            $department_id = $result['department'];
            // echo $department_id;die;
            $result = $Aeccge_course->getRecordByDepartment1($department_id, $degree_id);

            echo '<option value ="" label="Select">Select</optional>';
            $isExist = array();
            foreach ($result as $key => $value) {
                if (!in_array($value['ge_id'], $isExist)) {
                    $isExist[] = $value['ge_id'];
                    echo '<option value ="' . $value['ge_id'] . '" label = "' . $value['general_elective_name'] . '">' . $value['general_elective_name'] . '</option>';
                }
            }die;
        }
//    public function ajaxGetGeidAddedToCreditAction(){
//        $Aeccge_course = new Application_Model_Aeccge();
//        $batch = new Application_Model_Academic();
//         $this->_helper->layout->disableLayout();
//        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
//            $academic_year_id = $this->_getParam("academic_id");
//            
//            $result = $batch->getRecord($academic_year_id);
//            
//            $department_id = $result['department'];
//            
//            $result = $Aeccge_course->getRecordByDepartment($department_id);
//            
//            echo '<option value ="" label="Select">Select</optional>';
//            foreach($result as $key => $value){
//                echo '<option value ="'.$value['ge_id'].'" label = "'.$value['general_elective_name'].'">'.$value['general_elective_name'].'</option>';
//            }
//            
//        }die;
//    }
    }

    public function ajaxGetSavedResultAction() {
        $student_db = new Application_Model_StudentPortal();

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $id = $this->_getParam("id");
            $reg_no = $this->_getParam("reg_no");
            $exam_roll = $this->_getParam("exam_no");
            $roll = $this->_getParam("roll");
            $earned_credit = $this->_getParam("earned_credit");
            if (!empty($reg_no))
                $data['reg_no'] = $reg_no;
            if (!empty($exam_roll))
                $data['exam_roll'] = $exam_roll;
                 if (!empty($roll))
                $data['roll_no'] = $roll;
                $data['earned_credit'] = $earned_credit;
            if ($student_db->update($data, array('student_id=?' => $id))) {

                echo 1;
                die;
            } else
                echo 0;die;
        }
    }

    //Kedar 25 Oct. 2019
    public function ajaxCheckExistedResultAction() {
        $student_db = new Application_Model_StudentPortal();

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $id = $this->_getParam("id");
            $reg_no = $this->_getParam("reg_no");
            $exam_roll = $this->_getParam("exam_no");

            $data['reg_no'] = $reg_no;
            $data['exam_roll'] = $exam_roll;

            $bool = $student_db->getDataExists($reg_no, $exam_roll);

            if ($bool) {
                echo 1;
            } else {
                $result = $student_db->update($data, array('student_id=?' => $id));
                echo 0;
            }
        }die;
    }

    public function ajaxGetBulkSavedResultAction() {

        $student_db = new Application_Model_StudentPortal();

        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            
            $exam_roll = $this->_getParam("exam_roll");
            $exam_roll_id = $this->_getParam("exam_roll_id");
            
            $reg_no = $this->_getParam("reg_no");
            $reg_id = $this->_getParam("reg_id");
            
            $roll_no = $this->_getParam("roll_no");
            $roll_id = $this->_getParam("roll_id");
            foreach ($exam_roll as $key => $value) {
                $data = array();

                $data['exam_roll'] = $value;
                $student_db->update($data, array('student_id=?' => $exam_roll_id[$key]));
            }
            
             foreach ($reg_no as $key => $value) {
                $data = array();

                $data['reg_no'] = $value;
                $student_db->update($data, array('student_id=?' => $reg_id[$key]));
            }
            
            foreach ($roll_no as $key => $value) {
                $data = array();

                $data['roll_no'] = $value;
                $student_db->update($data, array('student_id=?' => $roll_id[$key]));
            }
            die;
        }
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

//ajax academic according to department
    public function ajaxGetAcademicwithdeptAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $department = $this->_getParam("department");
            //echo $department; die;
            $academic_model = new Application_Model_Academic();

            $result = $academic_model->getAcademicOnDept($department);
            //   echo "<pre>";print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {
                echo '<option value="' . $val['academic_year_id'] . '" >' . $val['batch_code'] . '</option>';
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
            $ge_id = $this->_getParam("ge_id");
            $TermMaster_model = new Application_Model_TermMaster();


            //if(!empty($ccl_id))
            //{
            // $result= $TermMaster_model->getRemainingTermCredits($academic_year_id,$term_id,$ccl_id);
            //}else{
            $result = $TermMaster_model->getTermCredits($academic_year_id, $term_id, $ge_id);
            //}

            echo json_encode($result);
            die;
        }
    }

    //CORE COURSE LEARNING VIEW

    public function corecourselearningviewAction() {
        $this->view->action_name = 'corecourselearningview';
        $this->view->sub_title_name = 'corecourselearningview';
        $this->accessConfig->setAccess("SA_ACAD_CORE_COURSE_LEARN");
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
        $this->accessConfig->setAccess('SA_ACAD_COURSE_TYPE');
        $Coursetype_model = new Application_Model_Coursetype();
        $Coursetype_form = new Application_Form_Coursetype();
        $ct_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Coursetype_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Coursetype_form->isValid($this->getRequest()->getPost())) {
                        $data = $Coursetype_form->getValues();
                        //print_r($data);die;

                        $insertData = array(
                            'ct_name' => $data['ct_name'],
                            'ct_description' => $data['ct_description'],
                            'degree_id' => $data['degree_id'],
                            'status' => $data['status'],
                           //'course_category' => $data['course_category'],
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Coursetype_model->insert($insertData);
                                unset($_SESSION["token"]);
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_redirect('master/coursetype');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/coursetype');
                            }
                        }
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
                        $updateData = array(
                            'ct_name' => $data['ct_name'],
                            'ct_description' => $data['ct_description'],
                            'degree_id' => $data['degree_id'],
                            'status' => $data['status'],
                            'course_category' => $data['course_category']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Coursetype_model->update($updateData, array('ct_id=?' => $ct_id));
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/coursetype');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/coursetype');
                            }
                        }
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
//                $messages = $this->_flashMessenger->getMessages();
//                $this->view->messages = $messages;
//                $result = $Coursetype_model->getRecords();
//                $degree_model = new Application_Model_Degree();
//                foreach ($result as $key => $value) {
//                    $result[$key]['degree_id'] = $degree_model->getRecord($value['degree_id'])['degree'];
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

    public function ajaxFilterCourseTypeAction() {
        $this->_helper->layout->disableLayout();
        $Coursetype_model = new Application_Model_Coursetype();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree = $this->_getParam("degree");
            $result = $Coursetype_model->getRecordByDegree($degree);
            $degree_model = new Application_Model_Degree();
            foreach ($result as $key => $value) {
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


    //Program Master

    public function programmasterAction() {
        $this->view->action_name = 'Program Master';
        $this->view->sub_title_name = 'Program Master';
        $this->accessConfig->setAccess('SA_ACAD_PROG_DESIGN');
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
    public function academicAction() {
        $this->view->action_name = 'Academic';
        $this->view->sub_title_name = 'Academic';
        $this->accessConfig->setAccess('SA_ACAD_BATCH');
        $Academic_model = new Application_Model_Academic();

        $Academic_form = new Application_Form_Academic();
        $academic_year_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Academic_form;
        $this->view->increment_id = $Academic_model->getIncrementID();
        $this->view->Academic_form = $Academic_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Academic_form->isValid($this->getRequest()->getPost())) {
                        $data = $Academic_form->getValues();
                        $academic_year_id = $data['from_date'] . ' ' . '-' . ' ' . $data['to_date'];
                        //print_r($data);die;
                        $insertData = array(
                            'from_date' => $data['from_date'],
                            'to_date' => $data['to_date'],
                            'batch_code' => $data['batch_code'],
                            'short_code' => $data['short_code'],
                            'department' => $data['department_type'],
                            'academic_year' => $data['academic_year'],
                            'session' => $data['session'],
							'frequency' => $data['frequency']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                if ($academic_year_id) {
                                    $Academic_model = new Application_Model_Academic();
                                    $academic_data = $Academic_model->getValidateAcademic($academic_year_id);
                                    $this->view->academic_data = $academic_data;

//                           if(!empty($academic_data)){
//
//                              $this->_flashMessenger->addMessage('This Academic Year is Already Existed');
//                              $this->_redirect('master/academic');
//                              }
//                              else{ 
                                    $Academic_model->insert($insertData);
                                    unset($_SESSION["token"]);
                                    $this->_flashMessenger->addMessage('Details Added Successfully ');
                                    $this->_redirect('master/academic');
                                    // }
                                }
                            }
                        } else {
                            $this->_flashMessenger->addMessage('Invalid Token ');
                            $this->_redirect('master/academic');
                        }
                    }
                }
                break;
            case 'edit':
                $result = $Academic_model->getRecord($academic_year_id);
                
                $result['department_type']=$result['department'];
                $Academic_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Academic_form->isValid($this->getRequest()->getPost())) {
                        $data = $Academic_form->getValues();
                        $insertData = array(
                            'from_date' => $data['from_date'],
                            'to_date' => $data['to_date'],
                            'batch_code' => $data['batch_code'],
                            'short_code' => $data['short_code'],
                            'department' => $data['department_type'],
                            'academic_year' => $data['academic_year'],
                            'session' => $data['session'],
							'frequency' => $data['frequency']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Academic_model->update($insertData, array('academic_year_id=?' => $academic_year_id));
                                unset($_SESSION["token"]);
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/academic');
                            }
                        } else {
                            $this->_flashMessenger->addMessage('Invalid Token');
                            $this->_redirect('master/academic');
                        }
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
                $session_model = new Application_Model_Session();
                foreach ($result as $key => $value) {
                    $sess_res = $session_model->getRecord($value['session']);
                    $result[$key]['session'] = $sess_res['session'];
                }


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
        $this->accessConfig->setAccess('SA_ACAD_PROG_CAL_YEAR');
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
                        // print_r($data['academic_year_id']);die;                      
                        //Edited by satyam 25-04-2019
                        $data['no_days'] = $this->getRequest()->getPost('no_days');
                        $data['start_date'] = $this->getRequest()->getPost('start_date');

                        $data['end_date'] = $this->getRequest()->getPost('end_date');
                        //print_r($data['start_date'].$data['end_date']); die;
                        // echo "<pre>"; print_r($data); 
//                         echo $v1; exit;
                        $data['no_weeks'] = $this->getRequest()->getPost('no_weeks');
                        $result = $programdesign_model->getRecords();
                        //print_r($data['start_date'].$data['end_date']); echo "<br>";
                        $startdate = $data['start_date'];
                        //  echo "<pre>"; print_r($result[0]['start_date']); 

                        $i = 0;
                        while ($i < 10) {

                            if (in_array($startdate, $result[$i++])) {
                                // echo "Match found";
                                // die;
                            } else {
                                // echo "match not found";
                                //die;
                            }
                        }
                        // die;




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
                //==================================Edited by satyam 25-04-2019=========================
//                echo '<pre>'; print_r($result);die;
                $i = 0;
                while ($i < 10) {
                    // echo '<pre>';
                    GLOBAL $v1;
                    $v1 = $result[$i]['academic_year_id'];
                    $v2 = $result[$i]['start_date'];
                    //echo $v1. $v2;
                    $i++;
                }// die;
                // echo $v1; exit;

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

    public function ajaxGetStateAction() {
        $placement = new Application_Model_placement();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $country_id = $this->_getParam("country_id");
            $result = $placement->getState($country_id);
            echo "<option>--Select--</option>";
            foreach ($result as $value) {
                echo "<option value ='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }die;
        }
    }

    public function ajaxGetCityAction() {
        $placement = new Application_Model_placement();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $state_id = $this->_getParam("state_id");
            $result = $placement->getCity($state_id);
            echo "<option>--Select--</option>";
            foreach ($result as $key => $value) {
                echo "<option value ='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }die;
        }
    }

    public function placementRegisterationFormAction() {

        $this->view->action_name = 'placement';
        $this->view->sub_title_name = 'placement';
        $this->accessConfig->setAccess('SA_ACAD_MASTER_PLACEMENT');
        $placement_model = new Application_Model_placement();
        $placement_form = new Application_Form_placement();

        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $placement_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();

                        $id = $data['registration_id'];
                        if ($id) {


                            $group_data = $placement_model->getValidateRegistrationNo($id);
                            $this->view->group_data = $group_data;
                            if (!empty($group_data)) {
                                $this->_flashMessenger->addMessage('This Registeration Number is Already Existed');
                                $this->_redirect('master/placement-registeration-form');
                            } else {
                                $placement_model->insert($data);

                                $this->_flashMessenger->addMessage('Details Added Successfully');

                                $this->_redirect('master/placement-registeration-form');
                            }
                        }
                    }
                }

                break;
            case 'edit':
                $result = $placement_model->getRecord($id);
                $placement_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();

                        $placement_model->update($data, array('id=?' => $id));
                        $this->_flashMessenger->addMessage('Registeration Master Updated Successfully');
                        $this->_redirect('master/placement-registeration-form');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = Inactive;

                if (@$id) {
                    $placement_model->update($data, array('id=?' => $id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/placement-registeration-form');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $placement_model->getRecords_selection_process();
                //  echo "<pre>"; print_r($result);exit;
                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function placementSelectionProcessAction() {

        $this->view->action_name = 'placement';
        $this->view->sub_title_name = 'MasterSelectionProcess';
        $this->accessConfig->setAccess('SA_ACAD_MASTER_SELECTION_PROCESS');
        $placement_models = new Application_Model_MasterSelectionProcess();
        $placement_form = new Application_Form_SelectionProcess();


        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $placement_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();
                        $id = $data['selection_id'];
                        if ($id) {


                            // $group_data = $placement_models->getValidateRegistrationNo($id);
                            //$this->view->group_data = $group_data;
                            if (!empty($group_data)) {
                                $this->_flashMessenger->addMessage('This Registeration Number is Already Existed');
                                $this->_redirect('master/placement-selection-process');
                            } else {

                                $placement_models->insert($data);

                                $this->_flashMessenger->addMessage('Details Added Successfully');

                                $this->_redirect('master/placement-selection-process');
                            }
                        }
                    }
                }

                break;
            case 'edit':
                $result = $placement_models->getRecord($id);
                $placement_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();

                        $placement_models->update($data, array('id=?' => $id));
                        $this->_flashMessenger->addMessage('Details Added Successfully');
                        $this->_redirect('master/placement-selection-process');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = Inactive;

                if ($id) {
                    $placement_models->update($data, array('id=?' => $id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/placement-selection-process');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $placement_models->getRecords_selection_process();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function configurationSelectionProcessAction() {

        $this->view->action_name = 'placement';
        $this->view->sub_title_name = 'MasterConfigureSelectionProcess';
        $this->accessConfig->setAccess('SA_ACAD_MASTER_CONFIGURE_SELETION_PROCESS');
        $placement_models = new Application_Model_ConfigureSelectionProcess();
        $placement_form = new Application_Form_ConfigurationSelectionProcess();


        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $placement_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();
                        $id = $data['selection_id'];
                        if ($id) {


                            // $group_data = $placement_models->getValidateRegistrationNo($id);
                            //$this->view->group_data = $group_data;
                            if (!empty($group_data)) {
                                $this->_flashMessenger->addMessage('This Registeration Number is Already Existed');
                                $this->_redirect('master/configuration-selection-process');
                            } else {

                                $placement_models->insert($data);

                                $this->_flashMessenger->addMessage('Details Added Successfully');

                                $this->_redirect('master/configuration-selection-process');
                            }
                        }
                    }
                }

                break;
            case 'edit':
                $result = $placement_models->getRecord($id);
                $placement_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();

                        $placement_models->update($data, array('id=?' => $id));
                        $this->_flashMessenger->addMessage('Details Added Successfully');
                        $this->_redirect('master/configuration-selection-process');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = Inactive;

                if ($id) {
                    $placement_models->update($data, array('id=?' => $id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/configuration-selection-process');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $placement_models->getRecords_selection_process();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function placementJobAnnouncementAction() {
        $this->view->action_name = 'placement';
        $this->view->sub_title_name = 'MasterJobAnnouncement';
        $this->accessConfig->setAccess('SA_ACAD_MASTER_JOB_ANNOUNCEMENT');
        $placement_models = new Application_Model_jobAnnouncement();
        $placement_form = new Application_Form_JobAnnouncement();


        $id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $placement_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();
                        $id = $data['job_announcement_id'];
                        if ($id) {


                            // $group_data = $placement_models->getValidateRegistrationNo($id);
                            //  $this->view->group_data = $group_data;
                            if (!empty($group_data)) {
                                $this->_flashMessenger->addMessage('This Registeration Number is Already Existed');
                                $this->_redirect('master/placement-job-announcement');
                            } else {

                                $placement_models->insert($data);

                                $this->_flashMessenger->addMessage('Details Added Successfully');

                                $this->_redirect('master/placement-job-announcement');
                            }
                        }
                    }
                }

                break;
            case 'edit':
                $result = $placement_models->getRecord($id);
                $placement_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($placement_form->isValid($this->getRequest()->getPost())) {
                        $data = $placement_form->getValues();

                        $placement_models->update($data, array('id=?' => $id));
                        $this->_flashMessenger->addMessage('Details Added Successfully');
                        $this->_redirect('master/placement-job-announcement');
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = Inactive;

                if ($id) {
                    $placement_models->update($data, array('id=?' => $id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/placement-job-announcement');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $placement_models->getRecords_selection_process();

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }

    public function jobannouncementAction() {
        $this->view->action_name = 'MasterSelectionProcess';
        $this->view->sub_title_name = 'MasterSelectionProcess';
        $placement_models = new Application_Model_jobAnnouncement();


        $messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
        $result = $placement_models->getRecords_selection_process_user_and_faculty();

        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $result
        );
        $this->view->paginator = $this->_act->pagination($paginator_data);
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
            //print_r($result);
            // die;
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
            echo json_encode($result);
            //===========================================================================
            //   $ProgramDesign_model = new Application_Model_Academic();
            //  $lastdate_record = $ProgramDesign_model->getlastdateRecord($short_id);
            // echo $val_my=json_encode($lastdate_record);
            // $this->view->$val_my = $val_my;
            //===========================================================================

            /* //echo '<option value="">Select</option>';
              foreach($result as $k => $val){
              echo $val['batch_code'];
              } */
        }die;
    }

    //==================================================Edited=============================================================
    public function ajaxGetProgramDesignAction() {
        //display_error(); die;
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $short_id = $this->_getParam("short_id");

            //print_r($short_code); die;
            $ProgramDesign_model = new Application_Model_ProgramMaster();
            $result = $ProgramDesign_model->getAcademic($short_id);

            /* //echo '<option value="">Select</option>';
              foreach($result as $k => $val){
              echo $val['batch_code'];
              } */
            echo json_encode($result);
        }die;
    }

    public function ajaxGetTermMaxDateAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_id = $this->_getParam("academic_year_id");
            //print_r($academic_year_id);die;
            $ProgramDesign_model = new Application_Model_ProgramMaster();
            $lastdate_record = $ProgramDesign_model->getlastdateRecord($academic_id);

            echo json_encode($lastdate_record);
        }die;
    }

    //==================================satyam 29-04-2019 for experiential learnng=============================================
    public function ajaxGetFirstLastDateAction() {
        // echo "dsfdsf:"; exit;
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $terms_id = $this->_getParam("terms_id");

            //print_r($terms_id);
            // print_r($academic_year_id);
            $experientiallearning_model = new Application_Model_ExperientialLearning();
            $first_last_date = $experientiallearning_model->getfirstlastdateRecord($academic_year_id, $terms_id);
            //print_r($first_last_date); die;
            echo json_encode($first_last_date);
        }die;
    }

    //=============================================================================
//===================================================================================================================
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

    public function ajaxGetCourseCatAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree_id = $this->_getParam("degree_id");
            //print_r($short_code); die;
            $courseCat_model = new Application_Model_Coursecategory();
            $result = $courseCat_model->getRecordByDegreeId($degree_id);


            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['cc_id'] . '" >' . $val['cc_name'] . '</option>';
            }
        }die;
    }

    public function ajaxGetDeptAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree_id = $this->_getParam("degree_id");
            //print_r($short_code); die;
            $department_model = new Application_Model_Department();
            $result = $department_model->getRecordByDegreeId($degree_id);

            echo '<option value="">Select</option>';
            //echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['department'] . '</option>';
            }
            echo '</select>';
            echo '</div></div>';
        }die;
    }

    public function ajaxGetDeptForBulkAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree_id = $this->_getParam("degree_id");
            //print_r($short_code); die;
            $department_model = new Application_Model_Department();
            $result = $department_model->getRecordByDegreeId($degree_id);

            echo '<div class="col-sm-3 employee_class course_class">';
            echo '<div class="form-group">';
            echo '<label class="control-label">Department</label>';
            echo '<select type="text" name="department[]" multiple  id="department" required class="form-control chosen-select seelct2">';
            //echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['department'] . '</option>';
            }
            echo '</select>';
            echo '</div></div>';
        }die;
    }

    //Added By:kedar :15 Oct 2020
    public function ajaxGetSessionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $year_id = $this->_getParam("year_id");
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
    public function ajaxGetExamDateAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $sem = $this->_getParam("sem");
            $academic_id = $this->_getParam("academic_id");
            //print_r($short_code); die;
            $exam_model = new Application_Model_ExamDateModel();
            $result = $exam_model->getDateInfoByAcadId($academic_id,$sem);
            //echo '<pre>'; print_r($result);
            echo '<div class="col-sm-3 employee_class course_class">';
            echo '<div class="form-group">';
            echo '<label class="control-label">Exam Date</label>';
            echo '<select type="text" name="exam_date"  id="exam_date" required class="form-control chosen-select">';
            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['exam_date'] . '</option>';
            }
        }die;
    }

    public function ajaxGetSectionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $term_id = $this->_getParam("term_id");
            //print_r($short_code); die;
            $req_model = new Application_Model_Section();
            $result = $req_model->getSection($term_id);

            //echo '<pre>'; print_r($result);
            echo '<div class="col-sm-3 employee_class course_class">';
            echo '<div class="form-group">';
            echo '<label class="control-label">Section</label>';
            echo '<select type="text" name="section"  id="section" required class="form-control chosen-select">';
            //echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['name'] . '</option>';
            }
            echo '</select>';
            echo '</div></div>';
        }die;
    }

    public function ajaxGetBatchBySessionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session");
            //print_r($short_code); die;
            $batch_model = new Application_Model_Academic();
            $result = $batch_model->getRecordBySessionId($session_id);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            //echo"<pre>";print_r($paginator_data);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function ajaxGetBatch1Action() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session");
            //print_r($session_id); die;
            $academic_model = new Application_Model_Academic();
            $result = $academic_model->getRecordBySessionId($session_id);

            // echo '<pre>'; print_r($result);
                $academic_id='';
            
            //echo '<option value="">Select Term</option>';
            foreach ($result as $k => $val) {
                  
                $academic_id.=$val['academic_id'] . ','; 

                //echo '<option value="' . $val['term_id'] .'_'.$val['cmn_terms']. '" >' . $val['term_description'] . '</option>';
            }
            $academic_id = trim($academic_id, ',');    // remove trailing comma

            echo $academic_id; 
        }die;
    }
    
     public function ajaxGetBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session");
            //print_r($session_id); die;
            $academic_model = new Application_Model_Academic();
            $result = $academic_model->getRecordBySessionId($session_id);

            // echo '<pre>'; print_r($result);
            echo '<option value="">Select Academic</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['academic_id'] . '" >' . $val['short_code'] . '</option>';
            }
        }die;
    }     
     public function ajaxGetTermAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("academic_id");
            //print_r($session_id); die;
            $academic_model = new Application_Model_TermMaster();
            $result = $academic_model->getRecordByAcademicId($session_id);

            // echo '<pre>'; print_r($result);
            echo '<option value="">Select Term</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['term_id'] .'_'.$val['cmn_terms']. '" >' . $val['term_description'] . '</option>';
            }
        }die;
    }
    
     public function ajaxGetTermSessionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session_id");
            $cmnterms = $this->_getParam("cmnterms");
            //print_r($session_id); die;
            $academic_model = new Application_Model_TermMaster();
            $result = $academic_model->getRecordBySessionId($session_id,$cmnterms);

          //   echo '<pre>'; print_r($result['term_id']); die();
             $term_id='';
            
            //echo '<option value="">Select Term</option>';
            foreach ($result as $k => $val) {
                  
                $term_id.=$val['term_id'] . ','; 

                //echo '<option value="' . $val['term_id'] .'_'.$val['cmn_terms']. '" >' . $val['term_description'] . '</option>';
            }
            $term_id = trim($term_id, ',');    // remove trailing comma

            echo $term_id; 
        }die;
    }
    
    
     public function ajaxGetDateAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session_id = $this->_getParam("session");
            $term_id = $this->_getParam("term_id");
            $batch_id = $this->_getParam("batch_id");
         //  $term=  explode('_',$term_id);
          // $term
            //print_r($session_id); die;
            $academic_model = new Application_Model_ExamDateModel();
            $result = $academic_model->getRecordBySessionType($session_id,$term_id,$batch_id);

            // echo '<pre>'; print_r($result);
            echo '<option value="">Select Exam Date</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['exam_date'] . '</option>';
            }
        }die;
    }


    public function ajaxGetAcademicOnStreamAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $stream = $this->_getParam("stream");
            $session = $this->_getParam("session");
            //print_r($session_id); die;
            $department_model = new Application_Model_Department();
            $getDepartment = $department_model->getByDepartmentType($stream);
            //echo '<pre>';print_r($getDepartment);exit;
            $academic_model = new Application_Model_Academic();
            $getAcademicId = $academic_model->getAcademicOnDept($getDepartment['did'], $session);
            //$result = $academic_model->getRecordBySessionId($session_id);
            //echo '<pre>'; print_r($getAcademicId);
            echo '<option value="">Select</option>';
            foreach ($getAcademicId as $k => $val) {

                echo '<option value="' . $val['academic_year_id'] . '" >' . $val['batch_code'] . '</option>';
            }
        }die;
    }

    public function ajaxGetDeptWithEmplAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree_id = $this->_getParam("degree_id");
            $empl_id = $this->_getParam("employee_id");
            //print_r($empl_id); die;
            $department_model = new Application_Model_Department();
            $result = $department_model->getRecordByDegreeIdEmpl($degree_id, $empl_id);
          //  echo '<pre>'; print_r($result);exit;

            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {
                //echo '<pre>'; print_r($val);exit;
                echo '<option value="' . $val['id'] . '" >' . $val['department'] . '</option>';
            }
        }die;
    }

    public function ajaxGetDepttypeAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $degree_id = $this->_getParam("degree_id");
            //print_r($short_code); die;
            $department_model = new Application_Model_DepartmentType();
            $result = $department_model->getRecordByDegreeId($degree_id);


            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {

                echo '<option value="' . $val['id'] . '" >' . $val['department_type'] . '</option>';
            }
        }die;
    }

    //End


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
        $this->accessConfig->setAccess('SA_ACAD_PROG_CAL_VIEW');
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
        $this->accessConfig->setAccess('SA_ACAD_TERM_VIEW');
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
                // echo "<pre>";print_r($result);die;
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
        $this->accessConfig->setAccess("SA_ACAD_EC_LEARN");
        $electivecourselearning_model = new Application_Model_ElectiveCourseLearning();
        $electivecourselearning_form = new Application_Form_ElectiveCourseLearning();
        $ecrl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $electivecourselearning_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($electivecourselearning_form->isValid($this->getRequest()->getPost())) {
                        $data = $electivecourselearning_form->getValues();
                        // echo '<pre>'; print_r($data); exit;
                        $insertData = array(
                            'academic_year_id' => $data['academic_year_id'],
                            'term_id' => $data['term_id'],
                            'course_category_id' => $data['course_category_id'],
                            'course_id' => $data['course_id'],
                            'credit_id' => $data['credit_id']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $electivecourselearning_model->insert($insertData);
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Successfully added');

                                $this->_redirect('master/electivecourselearning');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/electivecourselearning');
                            }
                        }
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
                        $updateData = array(
                            'academic_year_id' => $data['academic_year_id'],
                            'term_id' => $data['term_id'],
                            'course_category_id' => $data['course_category_id'],
                            'course_id' => $data['course_id'],
                            'credit_id' => $data['credit_id']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $electivecourselearning_model->update($updateData, array('ecrl_id=?' => $ecrl_id));
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/electivecourselearning');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/electivecourselearning');
                            }
                        }
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
        $this->accessConfig->setAccess("SA_ACAD_COURSE");
        $course_model = new Application_Model_Course();
        $course_form = new Application_Form_Course();
        $course_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $course_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($course_form->isValid($this->getRequest()->getPost())) {
                        $data = $course_form->getValues();
                        //echo '<pre>';  print_r($data); die;

                        $insertData = array(
                            'course_category_id' => $data['course_category_id'],
                            'ct_id' => $data['ct_id'],
                            'course_code' => $data['course_code'],
                            'course_name' => $data['course_name'],
                            'course_description' => $data['course_description']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $course_model->insert($insertData);
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Course Successfully added');

                                $this->_redirect('master/course');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/course');
                            }
                        }
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
                        $updateData = array(
                            'course_category_id' => $data['course_category_id'],
                            'ct_id' => $data['ct_id'],
                            'course_code' => $data['course_code'],
                            'course_name' => $data['course_name'],
                            'course_description' => $data['course_description']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $course_model->update($updateData, array('course_id=?' => $course_id));
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/course');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/course');
                            }
                        }
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
            //  print_r($result);
            //  die;
        }
    }

    //Experiential Learning Components Master	
    public function experientiallearningcomponentsAction() {
        $this->view->action_name = 'experientiallearningcomponents';
        $this->view->sub_title_name = 'experientiallearningcomponents';
        $this->accessConfig->setAccess('SA_ACAD_E_LEARN_C');
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
        $this->accessConfig->setAccess('SA_ACAD_E_LEARN');
        $ExperientialLearning_model = new Application_Model_ExperientialLearning();
        $ExperientialLearning_form = new Application_Form_ExperientialLearning();
        $el_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ExperientialLearning_form;

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($_POST) {
                        $data = $_POST;

                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
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
                    if ($_POST) {
                        $data = $_POST;
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
        $this->accessConfig->setAccess('SA_ACAD_E_LEARN_DESIGN_VIEW');
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
                        // echo '<pre>';
                        // print_r($courses);
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
        $this->accessConfig->setAccess('SA_ACAD_FACULTY_ALLOTMENT');
        $EmployeeAllotment_model = new Application_Model_EmployeeAllotment();
        $EmployeeAllocationItems_model = new Application_Model_EmployeeAllocationItems();
        $EmployeeAllotment_form = new Application_Form_EmployeeAllotment();
        $course_migration_form = new Application_Form_Coursemigration();
         $departmentModel = new Application_Model_Department();
        $termModel = new Application_Model_TermMaster();
        
        $ea_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        
        $this->view->form = $EmployeeAllotment_form;
        if($type == "bulkadd")
        $this->view->form = $course_migration_form;
        
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    $data = $this->getRequest()->getPost();
                    //print_r($data);die;
                    $insertMasterData = array(
                        'academic_year_id' => $data['academic_year_id'],
                        'term_id' => $data['term_id'],
                        'status' => 0
                    );
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                            $last_insert_id = $EmployeeAllotment_model->insert($insertMasterData);

                            $employee_allocation = $this->getRequest()->getPost('employee');
                            //print_r($employee_allocation);die;
                            foreach ($employee_allocation['term_id'] as $key => $term_id) {
                                $item_data['ea_id'] = $last_insert_id;
                                $item_data['term_id'] = $term_id;
                                $item_data['cc_id'] = $employee_allocation['cc_id'][$key];
                                $item_data['course_id'] = $employee_allocation['course_id'][$key];
                                $item_data['course_code'] = $employee_allocation['course_code'][$key];
                                $item_data['credit_id'] = $employee_allocation['credit_id'][$key];
                                $item_data['department_id'] = $employee_allocation['department_id'][$key];
                                $item_data['employee_id'] = $employee_allocation['employee_id'][$key];
                                $course_id = $item_data['course_id'];
                                $emp_ids = trim(implode(',', $employee_allocation['faculty_id'][$course_id]), ',');
                                //$emp_ids1 = trim(implode(',', $employee_allocation['visiting_faculty_id'][$course_id]), ',');
                                $item_data['faculty_id'] = $emp_ids;
                                $item_data['visiting_faculty_id'] = 'EMP-F-002,EMP-F-003,EMP-F-001';
                                $EmployeeAllocationItems_model->insert($item_data);

                                //print_r($item_data);die;
                            }
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Employee Successfully added');

                            $this->_redirect('master/employeeallotment');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/employeeallotment');
                        }
                    }
                }


                break;
                 case 'bulkadd':
          
                if ($this->getRequest()->isPost()) {
                    $data=$_POST;
                            $course_ids = $this->getRequest()->getPost('course_id');
                            $employee_allocation = $this->getRequest()->getPost('employee');
                          //  echo "<pre>";print_r($data["mig_academic_id"]);die;
                 foreach($data['mig_academic_id'] as $migkey => $migval){
                        $data['mig_academic_id']  = $migval;
                        $deptres = $departmentModel->getRecordbyAcademic($migval);
                        $dept_id = $deptres['department_id'];
                        foreach($data['mig_term_id'] as $migtermkey => $migtermval){
                        $term_res = $termModel->getTermRecordsbycmn($migval,$migtermval);   
                         if(!$term_res['term_id'])
                        continue;
                        
                            $checkExistedRecord=$EmployeeAllotment_model->getRecordByTermId($term_res['term_id']);
                            if(!empty($checkExistedRecord)){
                                
                                $EmployeeAllotment_model->trashmasterData($term_res['term_id']);
                                
                                $EmployeeAllocationItems_model->trashItemsByTermid($term_res['term_id']);
                                
                            }
                            //die;
                            $insertMasterData = array(
                                'academic_year_id' => $data['mig_academic_id'],
                                'term_id' => $term_res['term_id'],
                                'status' => 0
                            );
                          $last_insert_id = $EmployeeAllotment_model->insert($insertMasterData);
                           //$last_insert_id = $migval;
                          
                            foreach($data['course_id'][$dept_id][$migtermval] as $key => $courseid) {
                                  $course_id = $courseid;
                                $emp_ids = trim(implode(',', $employee_allocation[$dept_id][$migtermval]['faculty_id'][$course_id]), ',');
                                $item_data[] = array('ea_id' => $last_insert_id,
                                'term_id' => $term_res['term_id'],
                                'cc_id' => $employee_allocation[$dept_id][$migtermval]['cc_id'][$key],
                                'course_id' => $employee_allocation[$dept_id][$migtermval]['course_id'][$key],
                                'course_code' => $employee_allocation[$dept_id][$migtermval]['course_code'][$key],
                                'credit_id' => $employee_allocation[$dept_id][$migtermval]['credit_id'][$key],
                               'department_id' => $employee_allocation[$dept_id][$migtermval]['department_id'][$key],
                                'employee_id' => $employee_allocation[$dept_id][$migtermval]['employee_id'][$key],
                                'faculty_id' => $emp_ids,
                                'visiting_faculty_id' => 'EMP-F-002,EMP-F-003,EMP-F-001');
                                //$item_data['remarks'] = $employee_allocation['remarks'][$key];
                                //print_r($item_data['employee_id']);die;
                                //echo "<prE>";print_r($item_data);die;
                               // $error = $EmployeeAllocationItems_model->insert($item_data);


                                //print_r($item_data);die;
                            }
                }    
                
                 }
                 if($item_data){
                 $EmployeeAllocationItems_model->saveRows($item_data);
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Employee Successfully added');
                            $this->_redirect('master/employeeallotment');
                 }
                       
                    }
                
                break;
            case 'edit':
                $result = $EmployeeAllotment_model->getRecord($ea_id);
                $this->view->emp_allotment_id = $ea_id;
                $item_result = $EmployeeAllocationItems_model->getRecords($ea_id);
                //  echo"<pre>";print_r($item_result);die;
                $this->view->item_result = $item_result;
                $EmployeeAllotment_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    //echo"<pre>";print_r($_POST);die;
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
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
                                $item_data['course_code'] = $employee_allocation['course_code'][$key];
                                $item_data['credit_id'] = $employee_allocation['credit_id'][$key];
                                $item_data['department_id'] = $employee_allocation['department_id'][$key];
                                $item_data['employee_id'] = $employee_allocation['employee_id'][$key];
                                $course_id = $item_data['course_id'];
                                $emp_ids = trim(implode(',', $employee_allocation['faculty_id'][$course_id]), ',');
                                //$emp_ids1 = trim(implode(',', $employee_allocation['visiting_faculty_id'][$course_id]), ',');

                                $item_data['faculty_id'] = $emp_ids;
                                 $item_data['visiting_faculty_id'] = 'EMP-F-002,EMP-F-003,EMP-F-001';
                                //$item_data['remarks'] = $employee_allocation['remarks'][$key];
                                //print_r($item_data['employee_id']);die;
                                //echo "<prE>";print_r($item_data);die;
                                $error = $EmployeeAllocationItems_model->insert($item_data);


                                //print_r($item_data);die;
                            }
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('master/employeeallotment');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/employeeallotment');
                        }
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
                if ($this->login_storage->role_id != 2) {
                    $empl_id = $this->login_storage->empl_id;
                    $result = $EmployeeAllotment_model->getRecordsByEmplId($empl_id);
                    $page = $this->_getParam('page', 1);
                    $paginator_data = array(
                        'page' => $page,
                        'result' => $result
                    );
                    $this->view->paginator = $this->_act->pagination($paginator_data);
                    break;
                } else {
                    /* $result = $EmployeeAllotment_model->getRecords();
                      $page = $this->_getParam('page', 1);
                      $paginator_data = array(
                      'page' => $page,
                      'result' => $result
                      );
                      $this->view->paginator = $this->_act->pagination($paginator_data);

                     */
                    break;
                }
        }
    }

    public function ajaxGetFilterRecordAction() {
        $this->_helper->layout->disableLayout();
        $EmployeeAllotment_model = new Application_Model_EmployeeAllotment();
        $batch_id = $this->_getParam('batch');
        $result = $EmployeeAllotment_model->getRecordByAcadId($batch_id);
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $result
        );
        //echo '<pre>';print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
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

    public function check1($date, $course_id, $batch, $class, $term) {
        $class_alotment = new Application_Model_Classalotment();
        $result = $class_alotment->check($course_id, $date, $class, $batch, $term);
        return $result;
    }

    //refGrade
    public function ajaxGetRefgradeAction() {
        $this->_helper->layout->disableLayout();
        $ref_grade_item = new Application_Model_ReferenceGradeMasterItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $deg = $this->_getParam('deg');
            $num = $this->_getParam("num");
            $session = $this->_getParam("session");

            $letter_grade = $ref_grade_item->getRecordByNumGrade($num, $deg, $session);

            echo $letter_grade;
            die;
        }
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
    public function ajaxPreviousFacultyAllotmentAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam("term_id");
            
            
            $EmployeeMaster_model = new Application_Model_EmployeeAllotment();
            $EmployeeAllocationItems_model = new Application_Model_EmployeeAllocationItems();
         
            $eaid= $EmployeeMaster_model->getValidFacultyRecordall($academic_year_id,$term_id);
              
            $result=$EmployeeAllocationItems_model->getItemsRecords($eaid);
            
            //$result['academic_year_id']=$academic_year_id;
            $this->view->employee_result = $result;
            $this->view->acadId = $academic_year_id;
            $HRMModel_model = new Application_Model_HRMModel();
            $employee = $HRMModel_model->getOrgFacultyIds();
            
        //   echo '<pre>';print_r($employee);exit;
            $this->view->employee = $employee;

            $visitingemployee = $HRMModel_model->getVisitingEmployeeIds();
            
            $this->view->visitingemployees = $visitingemployee;
            
            
            
        }
    }
    //Employee Details View Ajax
    public function ajaxEmployeeDetailsViewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam("term_id");
            $emp_allotment = $this->_getParam("emp_allotment");
            $EmployeeAllocationItems_model = new Application_Model_EmployeeAllocationItems();
           
            if (!empty($emp_allotment)) {
                // echo $term_id;die;
 //echo '<pre>';print_r($result);exit;
                $item_result = $EmployeeAllocationItems_model->getItemsRecords($emp_allotment);

                $term_id = $item_result[0]['term_id'];
                $this->view->item_result = $item_result;
                $Corecourselearning_model = new Application_Model_Corecourselearning();

                $result = $Corecourselearning_model->getprogramByYearTerm($academic_year_id, $term_id);
                //echo '<pre>';print_r($result);exit;
                $this->view->employee_result = $result;
                //$HRMModel_model = new Application_Model_HRMModel();
                //$department = $HRMModel_model->getDepartments();
                //print_r($department);die;
                // $this->view->department = $department;
                $HRMModel_model = new Application_Model_HRMModel();
                $employee = $HRMModel_model->getOrgFacultyIds();
                //echo '<pre>';print_r($employee);exit;
                $this->view->employee = $employee;
$hoddetails = $HRMModel_model->getHodDetails();
$this->view->hod = $hoddetails;
                $visitingemployee = $HRMModel_model->getVisitingEmployeeIds();
                $this->view->visitingemployees = $visitingemployee;
            } else {
                // echo $term_id;die;
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
                    $employee = $HRMModel_model->getEmployeeIds1();
                    $hoddetails = $HRMModel_model->getHodDetails();
                    //print_r($department);die;
                    $this->view->employee = $employee;
                    $this->view->hod = $hoddetails;

                    $visitingemployee = $HRMModel_model->getVisitingEmployeeIds();
                    $this->view->visitingemployees = $visitingemployee;
                }
            }
        }
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

    //Term Master
    public function termmasterAction() {
        $this->view->action_name = 'Term';
        $this->view->sub_title_name = 'Termmaster';
        $this->accessConfig->setAccess('SA_ACAD_TERM_MASTER');
        $Term_model = new Application_Model_TermMaster();
        $Term_form = new Application_Form_TermMaster();
        //$Termdate_model = new Application_Model_Termdate();
        $term_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Term_form;
        //$getyearid = $Term_model->getYear_Master();
        //echo "<pre>";
        //print_r($result1);die;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":

                $this->view->type = $type;
                $this->view->form = $Term_form;

                if ($this->getRequest()->isPost()) {

                    if ($Term_form->isValid($this->getRequest()->getPost())) {
                        //  echo '<pre>';print_r($_POST);
                        $data = $Term_form->getValues();
                        //  echo '<pre>';print_r($data);die;
                        $term_name = $data['term_name'];
                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];

                        $insertData = array(
                            'academic_year' => $data['academic_year'],
                            'session' => $data['session'],
                            'academic_year_id' => $data['academic_year_id'],
                            'cmn_terms' => $data['cmn_terms'],
                            'term_name' => $data['term_name'],
                            'start_date' => $data['start_date'],
                            'end_date' => $data['end_date'],
                            'term_description' => $data['term_description'],
                            'year_id' => $data['year_id'],
                            'tot_no_of_credits' => $data['tot_no_of_credits'],
                            'start_date_type' => $data['start_date_type'],
                            'end_date_type' => $data['end_date_type']
                        );
                        $academic_model = new Application_Model_TermMaster();
                        $academic_result = $academic_model->getRecordByAcademicId($data['academic_year_id']);
                        //print_r($data); die; 


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

                            if (!empty($data['csrftoken'])) {
                                if ($data['csrftoken'] === $token) {
                                    $Term_model->insert($insertData);
                                    unset($_SESSION["token"]);
                                    $this->_flashMessenger->addMessage(' Added Successfully ');
                                    $this->_redirect('master/termmaster');
                                } else {
                                    $message = "Invalid Token";
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $this->_flashMessenger->addMessage($message);
                                    $this->_redirect('master/termmaster');
                                }
                            }
                        }
                    }
                }

                break;
            case "edit":
                $this->view->type = $type;
                $this->view->form = $Term_form;

                $result = $Term_model->getRecord($term_id);


                $this->view->result = $result;
                $Term_form->populate($result);


                if ($this->getRequest()->isPost()) {
                    if ($Term_form->isValid($this->getRequest()->getPost())) {
                        $data = $Term_form->getValues();
                        $start_date = explode('/', $data['start_date']);
                        $end_date = explode('/', $data['end_date']);
                        $data['start_date_type'] = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
                        $data['end_date_type'] = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
                        $data['electives_credits'] = $this->getRequest()->getPost('electives_credits');
                        $updateData = array(
                            'academic_year_id' => $data['academic_year_id'],
                            'cmn_terms' => $data['cmn_terms'],
                            'term_name' => $data['term_name'],
                            'start_date' => $data['start_date'],
                            'end_date' => $data['end_date'],
                            'term_description' => $data['term_description'],
                            'year_id' => $data['year_id'],
                            'tot_no_of_credits' => $data['tot_no_of_credits'],
                            'start_date_type' => $data['start_date_type'],
                            'end_date_type' => $data['end_date_type']
                        );

                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Term_model->update($updateData, array('term_id = ?' => $term_id));
                                unset($_SESSION["token"]);
                                $this->_flashMessenger->addMessage('Updated Successfully');
                                $this->_redirect('master/termmaster');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/termmaster');
                            }
                        }
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

    public function ajaxGetSemesterRecordAction() {
        $Term_model = new Application_Model_TermMaster();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $id = $this->_getParam('batch_id');
            $result = $Term_model->getRecordsByBatch($id);
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }

    public function checkGe($cmn_terms, $academic_year_id, $year_id, $ge_id) {
        $term_model = new Application_Model_TermMasterPwc();
        $ge_id = $ge_id;


        $id = $term_model->isTermExist($cmn_terms, $academic_year_id, $year_id, $ge_id);


        if ($id >= 1) {
            return false;
        } else {
            return true;
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

    //Credit Master
    public function creditmasterAction() {
        $this->view->action_name = 'Credit';
        $this->view->sub_title_name = 'Creditmaster';
        $this->accessConfig->setAccess("SA_ACAD_CREDIT");
        $Credit_model = new Application_Model_CreditMaster();
        $Credit_form = new Application_Form_CreditMaster();
        //$Termdate_model = new Application_Model_Termdate();
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

                $this->view->type = $type;
                $this->view->form = $Credit_form;

                if ($this->getRequest()->isPost()) {
                    //echo '<pre>';print_r($_POST);die;
                    if ($Credit_form->isValid($this->getRequest()->getPost())) {
                        $data = $Credit_form->getValues();
                        $credit_value = $data['credit_value'];
                        $insertData = array(
                            'credit_value' => $data['credit_value'],
                           // 'credit_name' => $data['credit_name'],
                            'credit_type' => $data['credit_type'],
                          //  'credit_desc' => $data['credit_desc']
                        );
                        //echo '<pre>';print_r($data);die;
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                if ($credit_value) {
                                    $Credit_model = new Application_Model_CreditMaster();
                                    $term_data = $Credit_model->getValidateCreditValue($credit_value);
                                    $this->view->term_data = $term_data;

                                    if (!empty($term_data)) {
                                        $_SESSION['message_class'] = 'alert-success';
                                        $this->_flashMessenger->addMessage('This Credit value is Already Existed');
                                        $this->_redirect('master/creditmaster');
                                    } else {

                                        $Credit_model->insert($insertData);
                                        unset($_SESSION["token"]);
                                        //print_r($data); die; 
                                        $_SESSION['message_class'] = 'alert-success';
                                        $this->_flashMessenger->addMessage(' Added Successfully ');
                                        $this->_redirect('master/creditmaster');
                                    }
                                }
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
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

                        $updateData = array(
                            'credit_value' => $data['credit_value'],
                            'credit_name' => $data['credit_name'],
                            'credit_type' => $data['credit_type'],
                            'credit_desc' => $data['credit_desc']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                //print_r($data);die;
                                $Credit_model->update($updateData, array('credit_id=?' => $credit_id));
                                unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage(' Updated Successfully');
                                $this->_redirect('master/creditmaster');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/creditmaster');
                            }
                        }
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
            $ct_id = $this->_getParam("ct_id");
            //$academic_year_id = $this->_getParam("academic_year_id");
            if ($cc_id) {
                $Course_model = new Application_Model_Course();
                $course_data = $Course_model->getCoursesDropDownList($cc_id,$ct_id);
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
                    echo '<option value="' . $val['course_id'] . '">' . $val['course_code'] .'-'. $val['course_name'] . '</option>';
                }
            }
        }die;
    }

    public function ajaxFacultyTermCoursesNewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $term_id = $this->_getParam('term_id');
            $employee_id = $this->_getParam("employee_id");
            $department_id = $this->_getParam('department_id');
            $course_model = new Application_Model_Course();
            $elective_course_data = $course_model->getRecords();


            $employeeAllotmentModel = new Application_Model_EmployeeAllotment();
            $emp_courses = $employeeAllotmentModel->getEmployeeTermsNew($department_id, $employee_id);
            $course_ids = array();
            foreach ($emp_courses as $row) {
                //echo '<pre>';print_r($row);DIE;
                $course_ids[] = $row['course_id'];
            }
            $filtered_emp_courses = array();
            foreach ($elective_course_data as $key => $row) {
                if (in_array($row['course_id'], $course_ids)) {
                    $filtered_emp_courses[] = $row;
                }
            }
            //echo '<pre>';print_r($filtered_emp_courses);DIE;
            echo '<option value="">Select</option>';
            foreach ($filtered_emp_courses as $k => $val) {
                echo '<option value="' . $val['course_id'] . '">' .$val['course_code'] .'--'.$val['course_name'] . '</option>';
            }
        }
        die;
    }

    public function ajaxGetCourseDataAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $cc_id = $this->_getParam("cc_id");
            $course_id = $this->_getParam("course_id");
            $term_id = $this->_getParam("term_id");
            $Corecourselearning_model = new Application_Model_Corecourselearning();
            $data = $Corecourselearning_model->getCourseRecord($academic_year_id, $cc_id, $course_id, $term_id);
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

//Reference Grade Master
    public function referenceGradeAction() {
        $this->view->action_name = 'Reference Grade Master';
        $this->view->sub_title_name = 'Reference Grade Master';
        $this->accessConfig->setAccess('SA_ACAD_REF_GRADE');
        $ReferenceGradeMaster_model = new Application_Model_ReferenceGradeMaster();
        $ReferenceGradeMaster_form = new Application_Form_ReferenceGradeMaster();
        $ReferenceGradeMasterItems_model = new Application_Model_ReferenceGradeMasterItems();
        $reference_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ReferenceGradeMaster_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($ReferenceGradeMaster_form->isValid($this->getRequest()->getPost())) {
                        $data = $ReferenceGradeMaster_form->getValues();
                        // echo '<pre>'; print_r($data); exit;
                        //$data['academic_year_id'] = 0; 
                        $insertData = array(
                            'degree_id' => $data['degree_id'],
                            'session' => $data['session'],
                            'academic_year_id' => 0,
                            'cc_id' => $data['cc_id']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                               //s $bool = $ReferenceGradeMaster_model->getExitstingRe($data['degree_id'], $data['session']);
                                if ($bool['cc_id'] == 0) {
                                    $last_insert_id = $ReferenceGradeMaster_model->insert($insertData);
                                    $grade = $this->getRequest()->getPost('grade');

                                    foreach (array_filter($grade['letter_grade']) as $k => $letter_grade) {
                                        $grade_data['reference_id'] = $last_insert_id;
                                        $grade_data['letter_grade'] = $letter_grade;
                                        $grade_data['number_grade'] = $grade['number_grade'][$k];
                                        $grade_data['marks_from'] = $grade['from_grade'][$k];
                                        $grade_data['marks_to'] = $grade['to_grade'][$k];

                                        $ReferenceGradeMasterItems_model->insert($grade_data);
                                        unset($_SESSION["token"]);
                                    }
                                    $_SESSION['message_class'] = 'alert-success';
                                    $this->_flashMessenger->addMessage('Grades Added Successfully ');
                                } else {
                                    $_SESSION['message_class'] = 'alert-success';
                                    $this->_flashMessenger->addMessage('Grades Added Already once');
                                }

                                $this->_redirect('master/reference-grade');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/reference-grade');
                            }
                        }
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
                        //$data['academic_year_id'] = 0; 
                        $updateData = array(
                            'degree_id' => $data['degree_id'],
                            'session' => $data['session'],
                            'academic_year_id' => 0,
                            'cc_id' => $data['cc_id']
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $ReferenceGradeMaster_model->update($updateData, array('reference_id=?' => $reference_id));
                                $grade = $this->getRequest()->getPost('grade');

                                $ReferenceGradeMasterItems_model->trashItems($reference_id);
                                foreach (array_filter($grade['letter_grade']) as $k => $letter_grade) {
                                    $grade_data['reference_id'] = $reference_id;
                                    $grade_data['letter_grade'] = $letter_grade;
                                    $grade_data['number_grade'] = $grade['number_grade'][$k];
                                    $grade_data['marks_from'] = $grade['from_grade'][$k];
                                    $grade_data['marks_to'] = $grade['to_grade'][$k];
                                    $ReferenceGradeMasterItems_model->insert($grade_data);
                                    unset($_SESSION["token"]);
                                }
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Grades Updated Successfully');
                                $this->_redirect('master/reference-grade');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/reference-grade');
                            }
                        }
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


                $degree_model = new Application_Model_Degree();
                foreach ($result as $key => $value) {
                    $result[$key]['degree_id'] = $degree_model->getRecord($value['degree_id'])['degree'];
                }

                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
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
            $TermMaster_modelss = new Application_Model_TermMaster();
            $term_result = $TermMaster_modelss->getTermDropDownList($academic_year_id);
            echo '<option value="">Select Semester</option>';
            foreach ($term_result as $k => $val) {
                echo '<option value="' . $k . '" >' . $val . '</option>';
            }
        }
        exit;
    }

    //developed by:kedar 25 Sept.
    public function ajaxGetNextTermsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $semester_id = $this->_getParam("semester_id");
            $TermMaster_modelss = new Application_Model_TermMaster();
            $term_result = $TermMaster_modelss->getNextTerm($semester_id);
            echo $term_result;
//            foreach ($term_result as $k => $val) {
//                echo '<option value="' . $k . '" >' . $val . '</option>';
//            }
        }
        exit;
    }

    //End 
    public function ajaxGetCreditValueAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $credit_id = $this->_getParam("credit_id");
            $CreditMaster_model = new Application_Model_CreditMaster();
            $data = $CreditMaster_model->getCourseCreditById($credit_id);
            echo '<option value="">Select </option>';
            foreach ($data as $k => $val) {
                echo '<option value="' . $val['credit_id'] . '" >' . $val['credit_value'] . '</option>';
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
            echo "<option value =''>--Select--</option>";
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

    public function ajaxGetExperientialLearningNewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            $ExperientialLearning_model = new Application_Model_ExperientialLearning();
            $el_result = $ExperientialLearning_model->getProgramNew();
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
                echo '<option value="' . $row['cmn_terms'] . '" >' . $row['term_name'] . '</option>';
            }
        }
        exit;
    }

    public function ajaxGetNonTermYearBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            $year_id = $this->_getParam("year_id");
            $Term_model = new Application_Model_TermMaster();
            $result = $Term_model->getNonTermRecordsByYear($batch_id, $year_id);
            echo '<option value="">Select Semester </option>';
            foreach ($result as $row) {
                echo '<option value="' . $row['cmn_terms'] . '" >' . $row['term_name'] . '</option>';
            }
        }
        exit;
    }

    public function ajaxGetNonpgTermYearBatchAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $batch_id = $this->_getParam("batch_id");
            $year_id = $this->_getParam("year_id");
            $Term_model = new Application_Model_TermMaster();
            $result = $Term_model->getNonpgTermRecordsByYear($batch_id, $year_id);
            echo '<option value="">Select Semester </option>';
            foreach ($result as $row) {
                echo '<option value="' . $row['cmn_terms'] . '" >' . $row['term_name'] . '</option>';
            }
        }
        exit;
    }

    //Added by kedar To Show Otp List with students Info DAte: 16 Nov. 2019
    public function otpManagerAction() {
        $this->view->action_name = 'settings';
        $this->view->sub_title_name = 'otp_info';
        $this->accessConfig->setAccess('SA_ACAD_OTP_INFO');
        $otpInfo_form = new Application_Form_Application();
        $this->view->form = $otpInfo_form;
        //$otpModel =  new Application_Model_OtpModel();
    }

    public function payManagerAction() {
        $this->view->action_name = 'settings';
        $this->view->sub_title_name = 'otp_info';
        $this->accessConfig->setAccess('SA_ACAD_OTP_INFO');
        $otpInfo_form = new Application_Form_PayManager();
        $this->view->form = $otpInfo_form;
        //$otpModel =  new Application_Model_OtpModel();
    }

    public function ajaxGetPayAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $otpModel = new Application_Model_OtpModel();
            $feeCollection = new Application_Model_FeesCollection();
            $tran_id = $this->_getParam("tran_id");
            $amount = $this->_getParam("amount");
            $paymentmode = $this->_getParam("paymode");
            $mer_id = $this->_getParam("mer_id");
            $mref = $this->_getParam("mref");
            $i = $this->_getParam("i");
            //$tran_id = 20091475371956;
            $mer_id = 302278;
            $tran_id_arr = $feeCollection->getPayRecordsBytxn($tran_id);
            if ($tran_id) {
                $url = "https://eazypay.icicibank.com/EazyPGVerify?ezpaytranid={$tran_id}&amount=$amount&paymentmode=$paymentmode&merchantid=$mer_id&trandate=&pgreferenceno=$mref";
                $curl = curl_init();
// Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                    CURLOPT_USERAGENT => 'abc'
                ]);
// Send the request & save response to $resp
                $resp = curl_exec($curl);
// Close request to clear up some resources
                curl_close($curl);
                $result = explode('&', $resp);
                //echo '<pre>'; print_r($result);die;
                $this->view->resultData = $result;
                $this->view->stu_data = $tran_id_arr;
                $this->view->i = $i + 1;
            } else {
                echo 0;
                die;
            }
        }
    }

    public function ajaxGetPaySingleAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $otpModel = new Application_Model_OtpModel();
            $feeCollection = new Application_Model_FeesCollection();
            $tran_id = $this->_getParam("tran_id");
            $amount = $this->_getParam("amount");
            $date = $this->_getParam("date");
            $paymentmode = $this->_getParam("paymode");
            $mer_id = $this->_getParam("mer_id");
            $mref = $this->_getParam("mref");
            if (!$tran_id)
                $tran_id = array();
            $mer_id = 302278;
            $tran_id_arr = $feeCollection->getPayRecordsByMerSingle($mer_id, $tran_id, $date);
            echo $tran_id_arr['mmp_txn'];
            die;
        }
    }

    public function ajaxGetOtpAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $otpModel = new Application_Model_OtpModel();
            $form_id = $this->_getParam("form_id");

            $result = $otpModel->getRecordById($form_id);
            $this->view->resultData = $result;
        }
    }

    public function updateMobileAction() {
        $this->view->action_name = 'settings';
        $this->view->sub_title_name = 'updateMobileNumber';
        $this->accessConfig->setAccess('SA_ACAD_NUMBER_UPDATE');
        $otpInfo_form = new Application_Form_Application();
        $this->view->form = $otpInfo_form;
        $student_model = new Application_Model_StudentPortal();
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $editId = $this->_getParam("id");
        //echo"<pre>";print_r($editId);die;

        if ($type) {
            switch ($type) {
                case "add":
                    if ($this->getRequest()->isPost()) {
                        
                    }
                    break;
                case "edit":
                    $result = $student_model->getRecord($editId);
                    //echo"<pre>";print_r($result);
                    $this->view->item_result = $result;


                    break;
                case 'delete':
                    $data['status'] = 2;
                    if ($reference_id) {
                        
                    }
                    break;
                default:

                    break;
            }
        }
    }

    //To update offline applicant roll number :Date:23 Jan 2020 :Kedar
    public function updateOfflineApplicantInfoAction() {
        $this->view->action_name = 'settings';
        $this->view->sub_title_name = 'updateOfflineNumber';
        $this->accessConfig->setAccess('SA_ACAD_NUMBER_UPDATE');
        $otpInfo_form = new Application_Form_Application();
        $this->view->form = $otpInfo_form;
        $student_model = new Application_Model_StudentPortal();
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $editId = $this->_getParam("id");
        //echo"<pre>";print_r($editId);die;

        if ($type) {
            switch ($type) {
                case "add":
                    if ($this->getRequest()->isPost()) {
                        
                    }
                    break;
                case "edit":
                    $payment_model = new Application_Model_ApplicantPaymentDetailModel();
                    $result = $payment_model->getRecordById($editId);
                    //echo"<pre>";print_r($result);exit;
                    $this->view->item_result = $result;
                    if ($this->getRequest()->isPost()) {
                        $data = $this->getRequest()->getPost();
                        //echo '<pre>';print_r($data) ;exit;  
                        $generateRoll = $payment_model->checkCourseForRoll($data['course']);

                        //echo '<pre>';print_r($generateRoll) ;exit;
                        if ($generateRoll) {
                            $insertData['roll_no'] = 1 + $generateRoll['roll_no'];
                            $insertData['challan_no'] = $data['challan'];
                            $insertData['payment_status'] = 1;
                            //echo '<pre>'; print_r($insertData);exit;
                            $upadateData = $payment_model->update($insertData, array('form_id=?' => $data['form_id']));
                        } else {
                            $insertData['roll_no'] = 1;
                            $insertData['challan_no'] = $data['challan'];
                            $insertData['payment_status'] = 1;
                            $upadateData = $payment_model->update($insertData, array('form_id=?' => $data['form_id']));
                        }
                        $_SESSION['update_message'] = "Roll number is generated ";
                        $this->_redirect('master/update-offline-applicant-info');
                    }
                    break;
                case 'delete':
                    $data['status'] = 2;
                    if ($reference_id) {
                        
                    }
                    break;
                default:

                    break;
            }
        }
    }

    public function ajaxGetStudentMobileInfoAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $student_model = new Application_Model_StudentPortal();
            $form_id = $this->_getParam("form_id");
            $result = $student_model->getRecordbyUid($form_id);
            $this->view->resultData = $result;
        }
    }

    public function ajaxGetApplicantInfoAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $payment_model = new Application_Model_ApplicantPaymentDetailModel();
            $form_id = $this->_getParam("form_id");
            $result = $payment_model->getRecordbyUid($form_id);
            $this->view->resultData = $result;
        }
    }

    public function ajaxUpdateStudentMobileInfoAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $student_model = new Application_Model_StudentPortal();
            $s_id = $this->_getParam("s_id");
            $stu_mobile = $this->_getParam("stu_mobile");
            $father_mobile = $this->_getParam("father_mobile");
            $student_email = $this->_getParam("student_email");
            $result = $student_model->UpdateMobileRecordbyId($s_id, $stu_mobile, $father_mobile, $student_email);
            //echo "<pre>"; print_r($result); exit;
        }die;
    }

    //End


    public function ajaxGetDatatableSettingsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $pathname = $this->_getParam("path_name_url");
            $pathname = explode('academic', $pathname);

            $dtset = new Application_Model_DtSet();
            $settings = $dtset->getSettings("/academic" . $pathname[1]);


            echo trim($settings);
            die;
        }
    }
public function addoncourselearningAction() {
        $this->view->action_name = 'addoncourselearning';
        $this->view->sub_title_name = 'addoncourselearning';
        $this->accessConfig->setAccess('SA_ACAD_CORE_COURSE');
        $addonmodel = new Application_Model_AddonLearningModel();
        //$Corecourselearning_model = new Application_Model_Addoncourselearning();
         $batchAttendance_form = new Application_Form_AddonCourses();
        $ccl_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $bulktype = $this->_getParam("bulktype");
        $this->view->type = $type;
        $this->view->bulktype = $bulktype;
        $this->view->form = $batchAttendance_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "bulkadd":
                if ($this->getRequest()->isPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            echo "<pre>";
                            print_r($data);
                            exit;

                            $data = $Corecourselearning_form->getValues();
                            $data = $_POST;
                            $data['re_credit'] = $this->getRequest()->getPost('re_credit');
                            //    unset($data['ge_id']);
                            unset($data['csrftoken']);
                            unset($data['academic_year']);
                            unset($data['tot_credit']);
                            $addonmodel->insert($data);
                            unset($_SESSION["token"]);
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('master/corecourselearning');
                        }
                    }
                }
                break;
            case "add":
                if ($this->getRequest()->isPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                           

                            //$data = $Corecourselearning_form->getValues();
                            $data = $_POST;
                            // echo "<pre>";print_r($data);exit;
                            //$data['re_credit'] = $this->getRequest()->getPost('re_credit');
                            //    unset($data['ge_id']);
                            unset($data['csrftoken']);
                            unset($data['tot_credit']);
                            $addonmodel->insert($data);
                            unset($_SESSION["token"]);
                            $this->_flashMessenger->addMessage('Details Added Successfully ');
                            $this->_redirect('master/addoncourselearning');
                        }
                    }
                }
                break;
            case 'edit':

                // echo "<pre>";print_r($data);exit;
                $result = $addonmodel->getRecord($ccl_id);
                $last_id = $ccl_id;
                $last_record_result = $addonmodel->getRecord($last_id);
               /// $Term_model = new Application_Model_TermMaster();
                //$data = $Term_model->getTermDropDownList($last_record_result['academic_year_id']);
                //print_r($data); die;
//                $Corecourselearning_form->getElement('term_id')->setAttrib('style', array("display", "initial"));
//                $employee_id = $Corecourselearning_form->createElement('select', 'term_id');
//                $employee_id->setAttrib('class', array('form-control', 'chosen-select'));
//                $employee_id->setAttrib('required', 'required');
//                //$employee_id->removeDecorator("htmlTag");
//                $employee_id->addMultiOptions(array('' => 'Select'));
//                $employee_id->setRegisterInArrayValidator(false);
//                $employee_id->addMultiOptions($data);
//                $Corecourselearning_form->addElement($employee_id);

                $this->view->last_result = $last_record_result;
                $batchAttendance_form->populate($result);
              
                
                $course_model = new Application_Model_AddonCourseMasterModel();
                $data = $course_model->getDropDownList();
                
                
                $course_model1 = new Application_Model_AddonCourseModel();
               
                
                $course_result = $course_model->getRecord($result['course_id']);
                $data[$result['course_id']] = $course_result['course_code'];
                
                
                $course_result = $course_model1->getRecord($result['addon_course_list']);
                $result['tot_credit'] = $course_result['tot_credit'];
                // ksort($data);
               // print_r($result);die();
                  $this->view->result = $result;

                if ($this->getRequest()->isPost()) {
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                            $data = $batchAttendance_form->getValues();

                            $data['re_credit'] = $this->getRequest()->getPost('re_credit');
                            $data = $_POST;
                            //echo '<pre>';print_r($data);exit;
                            unset($data['csrftoken']);
                            unset($data['academic_year']);
                            unset($data['tot_credit']);
                            $addonmodel->update($data, array('ccl_id=?' => $ccl_id));
                            unset($_SESSION["token"]);
                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('master/addoncourselearning');
                        }
                    }
                }

                break;
            case 'delete':
                $data['status'] = 2;
                if ($ccl_id) {
                    $Corecourselearning_model->update($data, array('ccl_id=?' => $ccl_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/addoncourselearning');
                }
                break;
            default:
               
                $this->view->form = $batchAttendance_form;
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                /* $result = $Corecourselearning_model->getRecords();
                  $page = $this->_getParam('page', 1);
                  $paginator_data = array(
                  'page' => $page,
                  'result' => $result
                  );
                  //echo "<pre>";print_r($paginator_data);die;
                  $this->view->paginator = $this->_act->pagination($paginator_data); */
                break;
        }
    }
    
    
    public function ajaxGetAddonAction() {
        $Aeccge_course = new Application_Model_AddonCourseMasterModel();
       
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $degree_id = $this->_getParam("degree_id");

         
            $result = $Aeccge_course->getRecordByDegree($degree_id);

            echo '<option value ="" label="Select">Select</optional>';
           
            foreach ($result as $key => $value) {
               
                    echo '<option value ="' . $value['course_id'] . '" label = "' . $value['course_name'] . '">' . $value['course_code'].'-'.$value['course_name'] . '</option>';
               
            }die;
        }
    }
    
    public function ajaxGetAddonCreditAction() {
        $Aeccge_course = new Application_Model_AddonCourseModel();
       
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $degree_id = $this->_getParam("degree_id");

         
            $result = $Aeccge_course->getRecordByID($degree_id);
            

            echo $result['tot_credit'];
           
            
        }die;
    }
    
     public function ajaxGetAddonReCreditAction() {
        $Aeccge_course = new Application_Model_AddonLearningModel();
       
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $degree_id = $this->_getParam("degree_id");

         
            $result = $Aeccge_course->getRecordByID($degree_id);
            

            echo $result['re_credit'];
           
            
        }die;
    }
     public function addoncourseAction() {
        $this->view->action_name = 'addoncourse';
        $this->view->sub_title_name = 'addoncourse';
        $this->accessConfig->setAccess("SA_ACAD_COURSE");
        $course_model = new Application_Model_AddonCourseMasterModel();
        $course_form = new Application_Form_AddonCourseMaster();
        $course_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $course_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($course_form->isValid($this->getRequest()->getPost())) {
                        $data = $course_form->getValues();
                       $data= $_POST;
                     $getcoursecode=  $course_model->getCourseCode($data['course_code']);
                     if($getcoursecode) {
                         $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage("Course Code Already Exists");
                                $this->_redirect('master/addoncourse');
                     }else {
                      
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                             unset($_SESSION["token"]);
                    echo count($data['course_code']);
                           for($i=0;$i<count($data['course_code']);$i++){
                               
                        $insertData = array(
                            'addon_course_id' => $data['addon_course_id'],
                            'course_code' => $data['course_code'][$i],
                            'course_name' => $data['course_name'][$i],
                            'course_description' => $data['course_description'][$i]
                        );
                     //  echo '<pre>';  print_r($insertData); die;
                                $course_model->insert($insertData);
                           }
                               
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Course Successfully added');

                                $this->_redirect('master/addoncourse');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/addoncourse');
                            }
                        }
                    }
                    }
                }


                break;
            case 'edit':
                $result = $course_model->getRecordByGroup($course_id);
                
                $result1['addon_course_id']=$course_id;
                 $result1['academic_year_id']=$result[0]['academic_year_id'];
                $course_form->populate($result1);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($course_form->isValid($this->getRequest()->getPost())) {
                        $data = $course_form->getValues();
                        $data= $_POST;
                        //print_r($data); die();
                        
                         for($i=0;$i<count($data['course_code']);$i++){
                               
                        $updateData = array(
                            'addon_course_id' => $data['addon_course_id'],
                            'course_code' => $data['course_code'][$i],
                            'course_name' => $data['course_name'][$i],
                            'course_description' => $data['course_description'][$i]
                        );
                     //  echo '<pre>';  print_r($insertData); die;
                                $course_model->update($updateData, array('addon_course_id=?' => $course_id));
                              
                           }
                        
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                  unset($_SESSION["token"]);
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/addoncourse');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/addoncourse');
                            }
                        }
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
    
     public function ajaxGetStudentByCourseAddonAction() {
        $Aeccge_course = new Application_Model_AddonLearningModel();
       
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $degree_id = $this->_getParam("degree_id");
            $academic_year = $this->_getParam("academic_year");

         
            $result = $Aeccge_course->getCourseCodeByCT($degree_id,$academic_year);

          $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
           
           
        }
    }
    
    
    
     public function addonemployeeallotmentAction() {
        $this->view->action_name = 'addonemployeeallotment';
        $this->view->sub_title_name = 'addonemployeeallotment';
        $this->accessConfig->setAccess('SA_ACAD_FACULTY_ALLOTMENT');
        $EmployeeAllotment_model = new Application_Model_AddonEmployeeAllotment();
        $EmployeeAllocationItems_model = new Application_Model_EmployeeAllocationItems();
        $EmployeeAllotment_form = new Application_Form_AddonEmployeeAllotment();

        $ea_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $EmployeeAllotment_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    
                    //$data = $this->getRequest()->getPost();
                    $data =$_POST;
                   // print_r($data);die;
                      foreach ($data['course_id'] as $key => $course) {
                          
                         $item_data['addon_course_id'] = $data['addon_course_id'];
                         $item_data['course_category'] = $data['course_category'];
                         $item_data['course_name'] = $data['course_name'][$key];
                         $item_data['course_id'] = $data['course_id'][$key];
                         $item_data['course_code'] = $data['course_code'][$key];
                         $item_data['employee_id'] = $data['employee_id'][$key];
                         $item_data['academic_year'] = $data['academic_year'];
                         $item_data['faculty_id'] = trim(implode(',', $data['faculty_id']));
                         $item_data['visiting_faculty_id'] = 'EMP-F-002,EMP-F-003,EMP-F-001';
                         $item_data['status'] = '0';
                         
                           $last_insert_id = $EmployeeAllotment_model->insert($item_data);
                      }
//                    $insertMasterData = array(
//                      
//                        'course_category' => $data['course_category'],
//                        'course_name'=>$data['course_name'],
//                        'course_id'=>$data['course_id'],
//                        'course_code'=>$data['course_code'],
//                        'employee_id'=>$data['employee_id'],
//                        'academic_year'=>$data['academic_year'],
//                        'faculty_id'=>trim(implode(',', $data['faculty_id'])),
//                        'visiting_faculty_id' => 'EMP-F-002,EMP-F-003,EMP-F-001',
//                        'status' => 0
//                    );
                    if (!empty($data['csrftoken'])) {
                        if ($data['csrftoken'] === $token) {
                           unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Employee Successfully added');

                            $this->_redirect('master/addonemployeeallotment');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/addonemployeeallotment');
                        }
                    }
                }


                break;
                 case 'bulkadd':
          
                if ($this->getRequest()->isPost()) {
                      $data=$_POST;
                      
                      //print_r($data); die();
                           
                            $checkExistedRecord=$EmployeeAllotment_model->getExistedDataByYear($data['mig_academic_year']);
                        
                           if(!empty($checkExistedRecord)) {
                               
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage('Employee Successfully added');
                            $this->_redirect('master/addonemployeeallotment');
                           } else {
                           foreach ($data['course_id'] as $key => $course)
                           {
                          
                            $item_data['addon_course_id'] = $data['addon_course_id'];
                            $item_data['course_category'] = $data['course_category'];
                            $item_data['course_name']     = $data['course_name'][$key];
                            $item_data['course_id']       = $data['course_id'][$key];
                            $item_data['course_code']     = $data['course_code'][$key];
                            $item_data['employee_id']     = $data['employee_id'][$key];
                            $item_data['academic_year']   = $data['mig_academic_year'];
                            $item_data['faculty_id']      = trim(implode(',', $data['faculty_id']));
                            $item_data['visiting_faculty_id'] = 'EMP-F-002,EMP-F-003,EMP-F-001';
                            $item_data['status'] = '0';
                         
                           $last_insert_id = $EmployeeAllotment_model->insert($item_data);
                            }
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Employee Successfully added');
                            $this->_redirect('master/addonemployeeallotment');
                            
                            
                           }
                       
                    }
                
                break;
            case 'edit':
                $result = $EmployeeAllotment_model->getRecord($ea_id);
                $this->view->emp_allotment_id = $ea_id;
                $this->view->item_result = $result;
                $EmployeeAllotment_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                  //  echo"<pre>";print_r($_POST);die;
                    
                     
                         $data=$_POST;
                    if (!empty($_POST['csrftoken'])) {
                        if ($_POST['csrftoken'] === $token) {
                         $EmployeeAllotment_model->trashItems($ea_id);
                         
                     // print_r($data);die();
                        foreach ($data['course_id'] as $key => $course) {
                          
                         $item_data['addon_course_id'] = $data['addon_course_id'];
                         $item_data['course_category'] = $data['course_category'];
                         $item_data['course_name'] = $data['course_name'][$key];
                         $item_data['course_id'] = $data['course_id'][$key];
                         $item_data['course_code'] = $data['course_code'][$key];
                         $item_data['employee_id'] = $data['employee_id'][$key];
                         $item_data['academic_year'] = $data['academic_year'];
                         $item_data['faculty_id'] = trim(implode(',', $data['faculty_id']));
                         $item_data['visiting_faculty_id'] = 'EMP-F-002,EMP-F-003,EMP-F-001';
                         $item_data['status'] = '0';
                         
                           $last_insert_id = $EmployeeAllotment_model->insert($item_data);
                      }
                           
                            unset($_SESSION["token"]);
                            $_SESSION['message_class'] = 'alert-success';
                            $this->_flashMessenger->addMessage('Details Updated Successfully');
                            $this->_redirect('master/addonemployeeallotment');
                        } else {
                            $message = "Invalid Token";
                            $_SESSION['message_class'] = 'alert-danger';
                            $this->_flashMessenger->addMessage($message);
                            $this->_redirect('master/addonemployeeallotment');
                        }
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
                if ($this->login_storage->role_id != 2) {
                    $empl_id = $this->login_storage->empl_id;
                    $result = $EmployeeAllotment_model->getRecordsByEmplId($empl_id);
                    $page = $this->_getParam('page', 1);
                    $paginator_data = array(
                        'page' => $page,
                        'result' => $result
                    );
                    $this->view->paginator = $this->_act->pagination($paginator_data);
                    break;
                } else {
                    /* $result = $EmployeeAllotment_model->getRecords();
                      $page = $this->_getParam('page', 1);
                      $paginator_data = array(
                      'page' => $page,
                      'result' => $result
                      );
                      $this->view->paginator = $this->_act->pagination($paginator_data);

                     */
                    break;
                }
        }
    }
    
    
    
     public function ajaxGetAddonCoursesAction() {
        $addon_course = new Application_Model_AddonCourseMasterModel();
        $EmployeeAllotment_model = new Application_Model_AddonEmployeeAllotment();
        $HRMModel_model = new Application_Model_HRMModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $addon_id = $this->_getParam("addon_id");
            
            $result1 = $EmployeeAllotment_model->getAllRecord($addon_id);
           
           $result = $addon_course->getRecordByDegree($addon_id);

          $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
           
            $employee = $HRMModel_model->getEmployeeIds1();
                    $hoddetails = $HRMModel_model->getHodDetails();
                    //print_r($department);die;
                    $this->view->employee = $employee;
                    $this->view->hod = $hoddetails;
                    $this->view->item_result = $result1;
                     
        }
    }
    
    
    public function ajaxGetAddonCoursesBySessionAction() {
        $addon_course = new Application_Model_AddonCourseModel();
        $HRMModel_model = new Application_Model_HRMModel();
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $academic_year = $this->_getParam("academic_year");
            
           $result = $addon_course->getAddonExcelDropDownListbysession($academic_year);
          
            
          
          echo '<option value ="" label="Select">Select</optional>';
           //================[comentd due to data is coming from addon excel]================================//
            // foreach ($result as $key=> $value) {
               
            //         echo '<option value ="' . $value['id'] . '" label = "' . $value['name'] . '">' . $value['name']. '</option>';
               
            // }
            
            
            foreach ($result as $key=> $value) {
               
                    echo '<option value ="' . $value['Course_Name'] . '" label = "' . $value['Course_Name'] . '">' . $value['Course_Name']. '</option>';
               
            }

        }die();
    }
    
    
        public function ajaxFacultyAddonCoursesNewAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
           
            $employee_id = $this->_getParam("employee_id");
            $course_type = $this->_getParam('course_type');
            $course_model = new Application_Model_Course();
            //$elective_course_data = $course_model->getRecords();


            $employeeAllotmentModel = new Application_Model_AddonEmployeeAllotment();
            $emp_courses = $employeeAllotmentModel->getEmployeeTermsNew($course_type, $employee_id);
             //echo '<pre>';print_r($emp_courses);die();
            
           
            echo '<option value="">Select</option>';
            foreach ($emp_courses as $k => $val) {
                echo '<option value="' . $val['course_id'] . '">' .$val['course_code'] .'--'.$val['course_name'] . '</option>';
            }
        }
        die;
    }
    
    
    
     public function addonCourseMigrationAction() {
        $this->view->action_name = 'corecourselearning';
        $this->view->sub_title_name = 'corecourselearning';
        $this->accessConfig->setAccess('SA_ACAD_CORE_COURSE');
        $addonmodel = new Application_Model_AddonLearningModel();
        $addon_form = new Application_Form_BulkAddonCourses();
        $this->view->type = $type;
        $this->view->bulktype = $bulktype;
        $this->view->form = $addon_form;
        $messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        if ($this->getRequest()->isPost()) {
            //echo "<pre>"; print_r($_POST);exit;
            if (!empty($_POST['csrftoken'])) {
                if ($_POST['csrftoken'] === $token) {

                    $data = $_POST;
//echo '<pre>'; print_r($data);exit;
                    unset($data['csrftoken']);
                    unset($data['academic_year']);
                    unset($data['tot_credit']);
                    $checkExistedData = $addonmodel->checkExistedData($data['mig_academic_year']);
                    //echo '<pre>'; print_r($checkExistedData);exit;
                    if (empty($checkExistedData)) {
                        foreach ($data['course_id'] as $key => $course) {
                            $migData = array(
                                'academic_year' => $data['mig_academic_year'],
                                'course_id' => $data['course_id'][$key],
                                'addon_course_list' => $data['addon_course_list'],
                                'credit_id' => $data['credit_id'],
                                're_credit' => $data['re_credit'][$key]
                            );
                          //  echo "<pre>";print_r($migData);exit;
                            $addonmodel->insert($migData);
                        }
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-success';
                        $this->_flashMessenger->addMessage('Details Added Successfully ');
                        $this->_redirect('master/addoncourselearning');
                    } else {
                        unset($_SESSION["token"]);
                        $_SESSION['message_class'] = 'alert-danger';
                        $this->_flashMessenger->addMessage('Deatils Already Exists! ');
                        $this->_redirect('master/addon-course-migration');
                    }
                }
            }
        }
    }
    
    
      public function ajaxGetStudentByCourseAddonBulkAction() {
        $Aeccge_course = new Application_Model_AddonLearningModel();
       
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $degree_id = $this->_getParam("degree_id");
            $academic_year = $this->_getParam("academic_year");
            $result = $Aeccge_course->getCourseCodeByCT($degree_id,$academic_year);
            $paginator_data = array(
                    'page' => $page,
                    'result' => $result
            );
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->paginator = $this->_act->pagination($paginator_data);
           
           
        }
    }
	
     public function ajaxGetYearlyRecordAction() {
        $Acad = new Application_Model_Academic();
       
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          
            $degree_id = $this->_getParam("batch_id");
           
            $result = $Acad->getRecord($degree_id);
            
                echo $result['frequency'];
                
           
           
        } die();
    }
    
    
     public function ajaxGetAddonRecordAction() {
        $this->_helper->layout->disableLayout();
        $EmployeeAllotment_model = new Application_Model_AddonEmployeeAllotment();
        $addon_id = $this->_getParam('addon_id');
        $academic_year = $this->_getParam('academic_year');
        $result = $EmployeeAllotment_model->getRecordByAddonId($addon_id,$academic_year);
        $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $result
        );
        //echo '<pre>';print_r($paginator_data);exit;
        $this->view->paginator = $this->_act->pagination($paginator_data);
    }
    
    
    public function addonReferenceGradeAction() {
        $this->view->action_name = 'addonreferencegrade';
        $this->view->sub_title_name = 'addonreferencegrade';
        $this->accessConfig->setAccess('SA_ACAD_REF_GRADE');
        $ReferenceGradeMaster_model = new Application_Model_AddonReferenceGrade();
        $ReferenceGradeMaster_form = new Application_Form_ReferenceGradeAddon();
        $ReferenceGradeMasterItems_model = new Application_Model_AddonReferenceGradeItems();
        $reference_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $ReferenceGradeMaster_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($ReferenceGradeMaster_form->isValid($this->getRequest()->getPost())) {
                        $data = $ReferenceGradeMaster_form->getValues();
                     // echo '<pre>'; print_r($data); exit;
                        //$data['academic_year_id'] = 0; 
                        
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $bool = $ReferenceGradeMaster_model->getExitstingRecord($data['flag']);
                                if ($bool['academic_count'] == 0) {
                                    $grade = $this->getRequest()->getPost('grade');

                                    foreach (array_filter($grade['letter_grade']) as $k => $letter_grade) {
                                        $grade_data['flag'] = $data['flag'];
                                        $grade_data['Grade'] = $letter_grade;
                                        $grade_data['Level of Performance'] = $grade['number_grade'][$k];
                                        $grade_data['Grading Scale (%)'] = $grade['from_grade'][$k]."-".$grade['to_grade'][$k];

                                        $ReferenceGradeMaster_model->insert($grade_data);
                                        unset($_SESSION["token"]);
                                    }
                                    $_SESSION['message_class'] = 'alert-success';
                                    $this->_flashMessenger->addMessage('Grades Added Successfully ');
                                } else {
                                    $_SESSION['message_class'] = 'alert-danger';
                                    $this->_flashMessenger->addMessage('Grades Added Already once');
                                }

                                $this->_redirect('master/addon-reference-grade');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/addon-reference-grade');
                            }
                        }
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
                        //$data['academic_year_id'] = 0; 
                        $updateData = array(
                            'academic_year' => $data['academic_year'],
                            'addon_course_list' => $data['addon_course_list'],
                            
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $ReferenceGradeMaster_model->update($updateData, array('reference_id=?' => $reference_id));
                                $grade = $this->getRequest()->getPost('grade');

                                $ReferenceGradeMasterItems_model->trashItems($reference_id);
                                foreach (array_filter($grade['letter_grade']) as $k => $letter_grade) {
                                    $grade_data['reference_id'] = $reference_id;
                                    $grade_data['letter_grade'] = $letter_grade;
                                    $grade_data['number_grade'] = $grade['number_grade'][$k];
                                    $grade_data['marks_from'] = $grade['from_grade'][$k];
                                    $grade_data['marks_to'] = $grade['to_grade'][$k];
                                    $ReferenceGradeMasterItems_model->insert($grade_data);
                                    unset($_SESSION["token"]);
                                }
                                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Grades Updated Successfully');
                                $this->_redirect('master/addon-reference-grade');
                            } else {
                                $message = "Invalid Token";
                                $_SESSION['message_class'] = 'alert-danger';
                                $this->_flashMessenger->addMessage($message);
                                $this->_redirect('master/addon-reference-grade');
                            }
                        }
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
    
    public function ajaxGetAddonRefgradeAction() {
        $this->_helper->layout->disableLayout();
        $ref_grade_item = new Application_Model_AddonReferenceGradeItems();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $deg = $this->_getParam('deg');
            $num = $this->_getParam("num");
            $addon_id = $this->_getParam("addon_id");

            $letter_grade = $ref_grade_item->getRecordByNumGrade($num, $deg, $addon_id);

            echo $letter_grade;
            die;
        }
    }
    
    public function ajaxGetAddonCourseCodeAction() {
        $this->_helper->layout->disableLayout();
        $ref_grade_item = new Application_Model_AddonCourseModel();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $addon_id = $this->_getParam('year');
            
            $addon = $ref_grade_item->getRecord($addon_id);

            echo $addon['code'];
            die;
        }
    }
  public function lastAttemptAction() {
        $this->view->action_name = 'Academic';
        $this->view->sub_title_name = 'Academic';
        $this->accessConfig->setAccess('SA_ACAD_BATCH');
        $Academic_model = new Application_Model_Examchecker();

        $Academic_form = new Application_Form_Attempt();
        $academic_year_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $Academic_form;
      //  $this->view->increment_id = $Academic_model->getIncrementID();
        $this->view->Academic_form = $Academic_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];

        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($Academic_form->isValid($this->getRequest()->getPost())) {
                        $data = $Academic_form->getValues();
                        $academic_year_id = $data['from_date'] . ' ' . '-' . ' ' . $data['to_date'];
                        //print_r($data);die;
                        $insertData = array(
                            'session' => $data['session'],
                            'sem' => $data['sem'],
                            'last_attempt_year' => $data['not_attempt_year'],
                            'academic_year' => $data['academic_year'],
                            
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                               
                                    $Academic_model->insert($insertData);
                                    unset($_SESSION["token"]);
                                    $this->_flashMessenger->addMessage('Details Added Successfully ');
                                    $this->_redirect('master//last-attempt/');
                                    // }
                                }
                            
                        } else {
                            $this->_flashMessenger->addMessage('Invalid Token ');
                            $this->_redirect('master/last-attempt/');
                        }
                    }
                }
                break;
            case 'edit':
                $result = $Academic_model->getRecord($academic_year_id);
                $result['not_attempt_year']=$result['last_attempt_year'];
                $Academic_form->populate($result);
                $this->view->result = $result;
                if ($this->getRequest()->isPost()) {
                    if ($Academic_form->isValid($this->getRequest()->getPost())) {
                        $data = $Academic_form->getValues();
                        $insertData = array(
                            'session' => $data['session'],
                            'sem' => $data['sem'],
                            'last_attempt_year' => $data['not_attempt_year'],
                            'academic_year' => $data['academic_year'],
                        );
                        if (!empty($data['csrftoken'])) {
                            if ($data['csrftoken'] === $token) {
                                $Academic_model->update($insertData, array('id=?' => $academic_year_id));
                                unset($_SESSION["token"]);
                                $this->_flashMessenger->addMessage('Details Updated Successfully');
                                $this->_redirect('master/last-attempt/');
                            }
                        } else {
                            $this->_flashMessenger->addMessage('Invalid Token');
                            $this->_redirect('master/last-attempt/');
                        }
                    } else {
                        
                    }
                }
                break;
            case 'delete':
                $data['status'] = 2;
                if ($academic_year_id) {
                    $Academic_model->update($data, array('academic_year_id=?' => $academic_year_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('master/last-attempt/');
                }
                break;
            default:

                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $Academic_model->getRecords();
                $session_model = new Application_Model_Session();
                foreach ($result as $key => $value) {
                    $sess_res = $session_model->getRecord($value['session']);
                    $result[$key]['session'] = $sess_res['session'];
                }


                $page = $this->_getParam('page', 1);
                $paginator_data = array(
                    'page' => $page,
                    'result' => $result
                );
                $this->view->paginator = $this->_act->pagination($paginator_data);
                break;
        }
    }
    
    public function addonListUpdationAction() {
        $this->view->action_name = 'addonupdation';
        $this->view->sub_title_name = 'addonupdation';
        $this->accessConfig->setAccess('SA_ACAD_FORMFEECOLL');
    }
    
        public function addonEditListAction() {
        $this->view->action_name = 'addonupdation';
        $this->view->sub_title_name = 'addonupdation';
        $this->accessConfig->setAccess('SA_ACAD_FORMFEECOLL');
    }
    
    
     public function ajaxGetAddonStuDetailsAction() {
        $this->_helper->layout->disableLayout();
      
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
                $addonmodel  = new Application_Model_AddonMarksheets();
            $addon_course_list = $this->_getParam('addon_course_list');
            $academic_year = $this->_getParam('academic_year');
            $studetails = $addonmodel->getRecordAcademicYear($academic_year,$addon_course_list);
         //   echo "<pre>"; print_r($studetails);exit;
            echo json_encode($studetails);die;
        
        }
    }
    
    
         public function ajaxGetAddonStuDetailsAllAction() {
        $this->_helper->layout->disableLayout();
      
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
                $addonmodel  = new Application_Model_AddonMarksheets();
            $addon_course_list = $this->_getParam('addon_course_list');
            $academic_year = $this->_getParam('academic_year');
            $studetails = $addonmodel->getRecordAcademicYearAll($academic_year,$addon_course_list);
         //   echo "<pre>"; print_r($studetails);exit;
            echo json_encode($studetails);die;
        
        }
    }
    
    
 public function ajaxGetAddonStuRecordAction() {
        $this->_helper->layout->disableLayout();
      
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $addon_course_list = $this->_getParam('stu_details');
            $refrence_grade = $this->_getParam('refrence_grade');
            $dept = $this->_getParam('dept');

        $addon = $addon_course_list;
      //  echo "<prE>";print_r($addon);exit;
            $page = $this->_getParam('page', 1);
        $paginator_data = array(
            'page' => $page,
            'result' => $addon
        );
        $this->view->items = $addon;
        $this->view->grades = $refrence_grade;
        $this->view->dept = $dept;
        $this->view->paginator = $this->_act->pagination($paginator_data);
        }
    }
    
    
public function ajaxGetAddonCoursesCodeAction() {
        $this->_helper->layout->disableLayout();
         $student_report_form = new Application_Model_AddonCourseModel();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $addon_course_list = $this->_getParam('academic_year');
            
            
            $addon = $student_report_form->getRecordByID($addon_course_list);
           // print_r($addon); die();
            echo $addon['code'];
            die;
        }
    }



public function ajaxUpdateAddonAction(){
       $this->_helper->layout->disableLayout();
         $addonmarks = new Application_Model_AddonMarksheets();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $data = $this->_getParam('studetails');
            $headers = $this->_getParam('headers');
            $id = $this->_getParam('id');
            $dataupdate = array();
           foreach($headers as $key => $value){
               if($value!='id')
               $dataupdate[$value] = $data[$key];
               else
               continue;
           }
          // echo "<pre>";print_r($dataupdate);exit;
            $addon = $addonmarks->update($dataupdate, array('id=?' => $id));
            if($addon){
                echo 1 ; die;
            }
            else
            {
                echo 0; die;
            }
        }
}
public function ajaxUpdateAddonRefgradeAction(){
       $this->_helper->layout->disableLayout();
         $addonmarks = new  Application_Model_AddonReferenceGrade();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $data = $this->_getParam('studetails');
            $id = $this->_getParam('id');
          $dataupdate = array(
              "Level of Performance"=> $data[1],
              "Grade"=>$data[2],
              "Grading Scale (%)"=>$data[3],
              "flag"=>$data[4]
              );
            $addon = $addonmarks->update($dataupdate, array('id=?' => $id));
            if($addon){
                echo 1 ; die;
            }
            else
            {
                echo 0; die;
            }
        }
}

}