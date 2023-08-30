<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GlobalSettingsController
 *
 * @author w10
 */
class GlobalSettingsController extends Zend_Controller_Action {
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
    public $cur_datetime = NULL;
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
        $this->roleConfig = $config_role = $zendConfig->role_administrator->toArray();
        $this->view->administrator_role = $config_role;
        $storage = new Zend_Session_Namespace("admin_login");					
        $this->login_storage = $data = $storage->admin_login;
        $this->view->login_storage = $data;
        //print_r($data);exit;
        if( isset($data) ){
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
        $this->cur_datetime = date('Y-m-d H:i:s');

    }
    protected function authonticate() {
        $storage = new Zend_Session_Namespace("admin_login");
        $data = $storage->admin_login;
           if($data->role_id == 0)
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
    public function indexAction() {        
        $this->view->action_name = 'Global Settings';
        $this->view->sub_title_name = 'Global Settings';
        $this->accessConfig->setAccess('SA_ACAD_GLOBAL_SET');
        $GlobalSettings_model = new Application_Model_GlobalSettings();
        $GlobalSettings_form = new Application_Form_GlobalSettings();
        $setting_id = $this->_getParam("id");
        $type = $this->_getParam("type");
        $this->view->type = $type;
        $this->view->form = $GlobalSettings_form;
        $this->view->gs_category = $GlobalSettings_model->gs_category;
        switch ($type) {
            case "add":
                if ($this->getRequest()->isPost()) {
                    if ($GlobalSettings_form->isValid($this->getRequest()->getPost())) {
                        $data = $GlobalSettings_form->getValues();
                        $data['gs_content'] = trim($data['gs_content']);
                        $data['gs_added_date'] = $this->cur_datetime;
                        $data['gs_added_by'] = $this->login_storage->id;
                        
                        
                        unset($data['gs_default_time']);
                        unset($data['gs_min_time']);
                        unset($data['gs_max_time']);
                        
                        $GlobalSettings_model->insert($data);
                        $this->_flashMessenger->addMessage('Setting Successfully added');
                        $this->_redirect('global-settings/index');
                    }
                }
                
                break;
            case 'edit':
                $result = $GlobalSettings_model->getRecord($setting_id);
                //$this->view->result_grade = $result_grade;
                //echo '<pre>',print_r($result_grade);die;
                $GlobalSettings_form->getElement('gs_system_name')->setAttrib('readonly', 'readonly');
                $GlobalSettings_form->populate($result);
                $this->view->global_setting_id = $setting_id;
                if ($this->getRequest()->isPost()) {
                    if ($GlobalSettings_form->isValid($this->getRequest()->getPost())) {
                        $data = $GlobalSettings_form->getValues();
                        $data['gs_content'] = trim($data['gs_content']);
                        $data['gs_updated_date'] = $this->cur_datetime;
                        $data['gs_updated_by'] = $this->login_storage->id;
                        
                        
                        unset($data['gs_default_time']);
                        unset($data['gs_min_time']);
                        unset($data['gs_max_time']);
                        
                        
                        $GlobalSettings_model->update($data, array('global_setting_id=?' => $setting_id));
                        $this->_flashMessenger->addMessage('Setting Successfully upudated');
                        $this->_redirect('global-settings/index');
                    }
                    
                }
                
                break;
            break;
            case 'delete':
                $data['status'] = 2;
                if ($setting_id) {
                    $GlobalSettings_model->update($data, array('global_setting_id=?' => $setting_id));
                    $this->_flashMessenger->addMessage('Details Deleted Successfully');
                    $this->_redirect('global-settings/index');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $GlobalSettings_model->getRecords();
                $this->view->result = $result;
                break;
        }
        
    }
    public function adminUnlockAction() {        
        $this->view->action_name = 'settings';
        $this->view->sub_title_name = 'admin_setting';
        $this->accessConfig->setAccess('SA_ACAD_ADMIN_SET');
        $AdminSettings_model = new Application_Model_HRMUserModel();
        $setting_id = $this->_getParam("id");
        $update_id = $this->_getParam("update_id");
        //echo'<pre>';print_r($update_id);exit;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        switch ($type) {
            case "add":
             
                
                break;
            case 'edit':
                
                
                break;
       
            case 'delete':
               
                if ($update_id != 3) {
                    $data['attempts'] = 3;
                    //echo '<pre>'; print_r($data);exit;
                    $AdminSettings_model->update($data, array('id=?' => $setting_id));
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('global-settings/admin-unlock');
                }
                if($update_id == 3){
                    $data['attempts'] = 0;
                    $AdminSettings_model->update($data, array('id=?' => $setting_id));
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('global-settings/admin-unlock');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                $this->view->messages = $messages;
                $result = $AdminSettings_model->getRecords();
                
                $this->view->result = $result;
                break;
        }
        
    }
    
    
    public function datatableAction(){
        $this->view->action_name = 'data_settings';
        $this->view->sub_title_name = 'Data Settings';
        $GlobalSettings_form = new Application_Form_Datables();
        $dtset_model = new Application_Model_DtSet();
        $this->view->form = $GlobalSettings_form;
        $type = $this->_getParam("type");
        $this->view->type = $type;
        
          switch ($type) {
            case "add":
                if(isset($_POST) && count($_POST)!=0){
                $data['settings'] = json_encode($_POST);
              $dtset_model->update($data, array('id=?' => $_POST['url']));
                }
                break;
            case 'edit':
                
                
                break;
       
            case 'delete':
               
                if ($update_id != 3) {
                    $data['attempts'] = 3;
                    //echo '<pre>'; print_r($data);exit;
                    $AdminSettings_model->update($data, array('id=?' => $setting_id));
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('global-settings/admin-unlock');
                }
                if($update_id == 3){
                    $data['attempts'] = 0;
                    $AdminSettings_model->update($data, array('id=?' => $setting_id));
                    $this->_flashMessenger->addMessage('Details Updated Successfully');
                    $this->_redirect('global-settings/admin-unlock');
                }
                break;
            default:
                $messages = $this->_flashMessenger->getMessages();
                
                break;
        }
        
        
        
        
        
        
    }
    
    
    public function ajaxCheckSystemNameAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
             $gs_system_name = $this->_getParam("gs_system_name");
             $GlobalSettings_model = new Application_Model_GlobalSettings();
             $rs = $GlobalSettings_model->getDetailBySystemName($gs_system_name);
             if(is_array($rs) && !empty($rs)){
                 echo 1;
             }
             else{
                 echo 0;
             }
             exit;
        }
    }
    //Unlock Blocked Documents Entry : Kedar : 11 Aug 2020
    public function admDocUnlockAction(){
        $this->view->action_name = 'settings';
        $this->view->sub_title_name = 'admin_setting';
        $this->accessConfig->setAccess('SA_ACAD_ADMIN_DOCSET');
        
    }
    public function ajaxGetStudentInfoForDocumentUnlockAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
             $a_id = $this->_getParam("a_id");
             $reqModel = new Application_Model_AnnounceResultModel();
             $result = $reqModel->getDetailByAppId($a_id);
              
                //echo"<pre>";print_r($paginator_data);exit;
                $this->view->resultData =$result;
        }
    }
    public function ajaxDocumentUnlockAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
             $a_id = $this->_getParam("a_id");
             $reqModel = new Application_Model_AnnounceResultModel();
             $result = $reqModel->updateDocStatus($a_id);
             if($result){
                 
                 echo 'Unblocked';
             }die;
        }
    }
}
