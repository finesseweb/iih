<?php

class FeeCollectionController extends Zend_Controller_Action {

	private $_siteurl = null;
    private $_db = null;
    private $_flashMessenger = null;
    private $_authontication = null;
    private $_agentsdata = null;
    private $_usersdata = null;
    private $_act = null;
    private $_adminsettings = null;
    Private $_unit_id = null;
    private $accessConfig =NULL;

    public function init() {

        $zendConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        require_once APPLICATION_PATH . '/configs/access_level.inc';

        $this->accessConfig = new accessLevel();
        $config = $zendConfig->mainconfig->toArray();
        $this->view->mainconfig = $config;
        $this->_action = $this->getRequest()->getActionName();
        $this->roleConfig = $config_role = $zendConfig->role_administrator->toArray();
        $this->view->administrator_role = $config_role;
        $storage = new Zend_Session_Namespace("admin_login");
        $this->login_storage = $data = $storage->admin_login;
        $this->view->login_storage = $data;
        
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

    	if($data->role_id == 0) {
    		$this->_redirect('student-portal/fee-status');
    	}

    	if (!$data && $this->_action != 'login' && $this->_action != 'forgot-password') {
    		$this->_redirect('index/login');
    		return;
    	}

    	if ($this->_action != 'forgot-password') {
    		$this->_authontication = $data;
    		$this->_agentsdata = $storage->agents_data;
    	}
    }

    public function indexAction() {
    	$this->view->action_name = 'Fees';
    	$this->view->sub_title_name = 'Fee Structure';
    	$this->accessConfig->setAccess("SA_ACAD_FEE_HEADS");

        $fee_collection_model = new Application_Model_FeeCollector();

        $get_all_students = $fee_collection_model->get_student_record();
        // echo "<pre>"; print_r($get_all_students); exit;

    	// $academic_year_model = new Application_Model_AcademicYear();
    	
    	// $FeeCollection_form = new Application_Form_FeeCollection();

    	// $this->view->form = $FeeCollection_form;

    	// $academic_year_dropdown = $academic_year_model->getDropDownList();
    }

    // public function ajaxGetStudents() {
    //     $this->_helper->layout->disableLayout();
    //     $Coursetype_model = new Application_Model_FeeCollection();
    //     if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
    //         $degree = $this->_getParam("session_id");
    //         $result = $Coursetype_model->getRecordByDegree($degree);
    //         $degree_model = new Application_Model_Degree();
    //         foreach ($result as $key => $value) {
    //             $result[$key]['degree_id'] = $degree_model->getRecord($value['degree_id'])['degree'];
    //         }
    //         $page = $this->_getParam('page', 1);
    //         $paginator_data = array(
    //             'page' => $page,
    //             'result' => $result
    //         );
    //         $this->view->paginator = $this->_act->pagination($paginator_data);
    //     }
    // }
}