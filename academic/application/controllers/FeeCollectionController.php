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
    	$this->view->action_name = 'Fees Collection';
    	$this->view->sub_title_name = 'Fee Collection';
    	$this->accessConfig->setAccess("SA_ACAD_FEE_HEADS");

        $fee_collection_model = new Application_Model_FeeCollector();
        $Form_validation = new Application_Model_FormValidation();
        $collector_form = new Application_Form_FeeCollector();

        $this->view->form = $collector_form;

        // $get_all_students = $fee_collection_model->get_student_record();
        // echo "<pre>"; print_r($get_all_students); exit;

    	// $academic_year_model = new Application_Model_AcademicYear();
        
    	// $FeeCollection_form = new Application_Form_FeeCollection();

    	// $this->view->form = $FeeCollection_form;

    	// $academic_year_dropdown = $academic_year_model->getDropDownList();
    }

    public function ajaxGetSessionAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $academic_year_id = $this->_getParam("academic_year_id");
            // echo $academic_year_id; die;
            $fee_collector_model = new Application_Model_FeeCollector();

            $result = $fee_collector_model->getSessionOnYear($academic_year_id);
            // echo "<pre>";print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {
                echo '<option value="' . $val['id'] . '" >' . $val['session'] . '</option>';
            }
        }die;
    }

    public function ajaxGetAcademicIdAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session = $this->_getParam("session");
            // echo $academic_year_id; die;
            $fee_collector_model = new Application_Model_FeeCollector();

            $result = $fee_collector_model->getAdacemicIdOnSession($session);
            // echo "<pre>";print_r($result);exit;
            echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {
                echo '<option value="' . $val['academic_year_id'] . '" >' . $val['short_code'] . '</option>';
            }
        }die;
    }

    public function ajaxGetStudentsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            // $degree = $this->_getParam("degree");
            $year = $this->_getParam("year");
            $session = $this->_getParam("session");
            $batch = $this->_getParam("batch");
            $fee_collector_model = new Application_Model_FeeCollector();

            $result = $fee_collector_model->get_student_record($year, $session, $batch);
            // echo "<pre>";print_r($result); exit;
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
            $this->view->paginator = $this->_act->pagination($paginator_data);
            // $result;
            // echo "<pre>";print_r($this->view->paginator);exit;
            // echo '<option value="">Select</option>';
            // foreach ($result as $k => $val) {
            //     echo '<option value="' . $val['academic_year_id'] . '" >' . $val['short_code'] . '</option>';
            // }
        }
    }

    public function payAction() {
        $this->view->action_name = 'Fees Collection';
        $this->view->sub_title_name = 'Fee Collection';
        $this->accessConfig->setAccess("SA_ACAD_FEE_HEADS");

        $this->view->stid = $_GET['stid'];
        $this->view->total = $_GET['total'];
    }

    public function ajaxGetFeeStructureAction() {

        $this->_helper->layout->disableLayout();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $academic_year_id = $this->_getParam("academic_year_id");

            $structure_id = $this->_getParam("structure_id");    
            $this->view->stid = $this->_getParam("stid");    
            $this->view->total = $this->_getParam("total");    
            $Academic_model = new Application_Model_Academic();
            $FeeCategory_model = new Application_Model_FeeCategory();
          // $academic_year_id = $Academic_model->getRecordsByDepartment($department)[0]['academic_year_id'];
            $FeeHeads_model = new Application_Model_FeeHeads();

            $FeeStructure_model = new Application_Model_FeeStructure();

            $StructureItems_model = new Application_Model_FeeStructureItems();

            $term_model = new Application_Model_TermMaster();

            $TermItems_model = new Application_Model_FeeStructureTermItems();
            $dept_details = new Application_Model_Department();
            $dept_type_details = new Application_Model_DepartmentType();

            $acad_details =  $Academic_model->getRecord($academic_year_id);

            $department = $acad_details['department'];
            $session = $acad_details['session'];
            $department = !empty($department)?$department:exit;

            $dept_type_id = $dept_details->getRecord($department)['department_type'];
            $dept_type_id = !empty($dept_type_id)?$dept_type_id:exit;
            
            
            if (!empty($structure_id)) {

             $result = $TermItems_model->getItemRecords($structure_id);

             $this->view->result = $result;

             $result1 = $StructureItems_model->getStructureRecords($structure_id);

             $this->view->result1 = $result1;
             $academic_id  = $TermItems_model->getAcademicId($structure_id);
             $terms_data = $term_model->getRecordByAcademicId($academic_year_id);

             $degree_id = $Academic_model->getAcademicDegree($academic_year_id);
             $this->view->term_data = $terms_data; 
             $this->view->structure_id = $structure_id;
             $Category_data = $FeeCategory_model->getCategory($degree_id['degree_id'],$session,$dept_type_id);

             $this->view->Category_data = $Category_data;

             $Feeheads_data = $FeeHeads_model->getFeeheads($degree_id['degree_id'],$session,$dept_type_id);



             $this->view->Feeheads_data = $Feeheads_data;

         } else {

            if (!empty($academic_year_id)) {

                    // $student_model = new Application_Model_StudentPortal();
                $degree_id = $Academic_model->getAcademicDegree($academic_year_id);
                $Category_data = $FeeCategory_model->getCategory($degree_id,$session,$dept_type_id);

                $this->view->Category_data = $Category_data;

                $Feeheads_data = $FeeHeads_model->getFeeheads($degree_id,$session,$dept_type_id);

                $terms_data = $term_model->getRecordByAcademicId($academic_year_id);

                $this->view->term_data = $terms_data; 

                $this->view->structure_id = 0;

                $this->view->Feeheads_data = $Feeheads_data;

                    // $Electivecourse_model = new Application_Model_ElectiveCourseLearning();

                    //  $electives = $Electivecourse_model->getDropDownList();

                      // echo "<pre>";  print_r($Category_data);

                 // echo "<pre>";  print_r($Feeheads_data);die;

                    //$this->view->electives = $electives;

            }

        }

    }
}

    function ajaxPayFeeStructureAction () {
        $this->_helper->layout->disableLayout();

        $stid = $_GET['stid'];
        $total = $_GET['total'];

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $fee_collector_model = new Application_Model_FeeCollector();
            $fee_collector_model->insert($_POST);
            $upd_data = array(
                "total_paid" => $_POST['total_paid'],
                "total_due" => $_POST['total_due']
            );
            // exit;
            $fee_collector_model->update($upd_data, array('student_id=?' => $_POST['student_id']));
            print_r($_POST); exit;
        }
    }
}