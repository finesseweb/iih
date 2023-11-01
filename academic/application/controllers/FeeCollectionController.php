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
	
	
	public function promotionAction() {
    	$this->view->action_name = 'Fees Collection';
    	$this->view->sub_title_name = 'Fee Collection';
    	$this->accessConfig->setAccess("SA_ACAD_FEE_HEADS");

        $fee_collection_model = new Application_Model_FeeCollector();
        $Form_validation = new Application_Model_FormValidation();
        $collector_form = new Application_Form_FeeCollector();
        $prometed_master_item = new Application_Model_PromotedMasterItem();
		$prometed_master = new Application_Model_PromotedMaster();
		
        $this->view->form = $collector_form;
		$type = $this->_getParam("type");
		$promo_id = $this->_getParam("id");
        $this->view->type = $type;
	   
		switch ($type) {
        case "add":
		
		if($_POST) {
		
		//echo "<pre>";  print_r($_POST); die();
		
		$inserdata= array(
		   
		   'prev_term'=>$_POST['semester'],
		   'next_term'=>$_POST['next_semester'],
		   'academic_id'=>$_POST['academic_id'],
		   'session'=>$_POST['session'],
		   'academic_year'=>$_POST['academic_year_list'],
		);
		  $last_id= $prometed_master->insert($inserdata); 
		   $itemdata=array();
		  if( $last_id) {
			  
			  for($i=0; $i<count($_POST['stu_name']); $i++){
				  
				  $itemdata['promoted_id']= $last_id;
				  $itemdata['stu_name']= $_POST['stu_name'][$i];
				  $itemdata['stu_id']= $_POST['stu_id'][$i];	
				  $itemdata['promoted_value']= $_POST['promoted_val'][$i];
				  
				  $last_id1= $prometed_master_item->insert($itemdata); 
			  }
			  
		  }
		
		$_SESSION['message_class'] = 'alert-success';
        $this->_flashMessenger->addMessage('Record Successfully added');
		$this->_redirect('fee-collection/promotion');
		}
		
		
        break;
		
		case 'edit':
		
		$result= $prometed_master->getRecordById($promo_id);
		
		$result['academic_year_list']=$result['academic_year'];
		$result['session']=$result['session'];
		$collector_form->populate($result);
		$this->view->result = $result;
		
		if($_POST) {
		
		
		
		$updatedata= array(
		   
		   'prev_term'=>$_POST['semester'],
		   'next_term'=>$_POST['next_term'],
		   'academic_id'=>$_POST['academic_id'],
		   'session'=>$_POST['session'],
		   'academic_year'=>$_POST['academic_year_list'],
		);
		//echo "<pre>";  print_r($promo_id); die();
		$last_id=$prometed_master->update($updatedata, array('promo_id=?' => $promo_id));
		
		if($promo_id){
			
			for($i=0; $i<count($_POST['stu_name']); $i++){
				  
				  $itemdata['promoted_id']= $promo_id;
				  $itemdata['stu_name']= $_POST['stu_name'][$i];
				  $itemdata['stu_id']= $_POST['stu_id'][$i];	
				  $itemdata['promoted_value']= $_POST['promoted_val'][$i];
				  
				  $last_id1= $prometed_master_item->update($itemdata,array('promoted_id=?'=>$promo_id,'stu_id=?'=>$_POST['stu_id'][$i])); 
			  }
			
			
			
			
		}
		$_SESSION['message_class'] = 'alert-success';
        $this->_flashMessenger->addMessage('Record Successfully added');
		$this->_redirect('fee-collection/promotion');
		
		
		}
		
		break;
        case 'default':
		
		  $messages = $this->_flashMessenger->getMessages();
          $this->view->messages = $messages;
		
		 break;
		}   
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
	
	
	
	public function ajaxGetSemesterAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $session = $this->_getParam("batch");
            // echo $academic_year_id; die;
            $fee_collector_model = new Application_Model_TermMaster();

            $result = $fee_collector_model->getRecordByAcademicId($session);
          echo '<option value="">Select</option>';
            foreach ($result as $k => $val) {
                echo '<option value="' . $val['term_id'] . '" >' . $val['term_name'] . '</option>';
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
			 $sem = $this->_getParam("sem");
			 $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
			$termmaster= new Application_Model_TermMaster();
			      $termdata=   $termmaster->getRecord($sem);
			
			 $strId = $feeStr->getStructIdAll($batch);
            // print_r($strId); die();
            $allTermFee = $feeStrItem->getStructureRecordsAll($strId);
			 	
			
            $semFee = array();
			
			foreach($allTermFee as $key => $value){
				if($termdata['cmn_terms']!='') {
                    switch ($termdata['cmn_terms']) {
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
						case "t7":
                            $semFee[$value['academic_id']]= $value['grand_term7_result'];
							  break;
						case "t8":
                            $semFee[$value['academic_id']]= $value['grand_term8_result'];
                            break;
                        default:
                            echo "n/a";
                    }
				}
				else {
				
				switch ($termdata['year_id']) {
                        case "1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
			     }
            }
			
			$yearcm= $termmaster->getYearcmterm($sem);
			
		
			
            $fee_collector_model = new Application_Model_FeeCollector();

            $result = $fee_collector_model->get_student_record1($year, $session, $batch,$sem,$yearcm);
           
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
			 
			$this->view->semester = $sem;
			$this->view->termdata= $termdata;
            $this->view->semFee = $semFee;
			 
			 //echo "<pre>";print_r($result);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            // $result;
            // echo "<pre>";print_r($this->view->paginator);exit;
            // echo '<option value="">Select</option>';
            // foreach ($result as $k => $val) {
            //     echo '<option value="' . $val['academic_year_id'] . '" >' . $val['short_code'] . '</option>';
            // }
        }
    }


public function ajaxGetPromotionStudentsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            // $degree = $this->_getParam("degree");
            $year = $this->_getParam("year");
            $session = $this->_getParam("session");
            $batch = $this->_getParam("batch");
			 $sem = $this->_getParam("sem");
			 $feeStr = new Application_Model_FeeStructure();
            $feeStrItem = new Application_Model_FeeStructureItems();
			$termmaster= new Application_Model_TermMaster();
			      $termdata=   $termmaster->getRecord($sem);
			
			 $strId = $feeStr->getStructIdAll($batch);
              
            $allTermFee = $feeStrItem->getStructureRecordsAll($strId);
			
			
            $semFee = array();
			
			foreach($allTermFee as $key => $value){
				if($termdata['cmn_terms']!='') {
                    switch ($termdata['cmn_terms']) {
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
						case "t7":
                            $semFee[$value['academic_id']]= $value['grand_term7_result'];
							  break;
						case "t8":
                            $semFee[$value['academic_id']]= $value['grand_term8_result'];
                            break;
                        default:
                            echo "n/a";
                    }
				}
				else {
				
				switch ($termdata['year_id']) {
                        case "1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
			     }
            }
			
			
			$yearcm= $termmaster->getYearcmterm($sem);
			
			//print_r($yearcm); die();
			
            $fee_collector_model = new Application_Model_FeeCollector();

            $result = $fee_collector_model->get_student_record($year, $session, $batch,$sem);
           
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
			 
			$this->view->semester = $sem;
			$this->view->termdata= $termdata;
            $this->view->semFee = $semFee;
			$this->view->yearcm = $yearcm;
			 
			 //echo "<pre>";print_r($result);exit;
            $this->view->paginator = $this->_act->pagination($paginator_data);
            // $result;
            // echo "<pre>";print_r($this->view->paginator);exit;
            // echo '<option value="">Select</option>';
            // foreach ($result as $k => $val) {
            //     echo '<option value="' . $val['academic_year_id'] . '" >' . $val['short_code'] . '</option>';
            // }
        }
    }

public function ajaxGetPromotedStudentsAction() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            // $degree = $this->_getParam("degree");
            $year = $this->_getParam("year");
            $session = $this->_getParam("session");
            $batch = $this->_getParam("batch");
			 $sem = $this->_getParam("sem");
			$prometed_master_item = new Application_Model_PromotedMasterItem();
		    $prometed_master = new Application_Model_PromotedMaster();
			$termmaster= new Application_Model_TermMaster();
			$termdata=   $termmaster->getRecord($sem);
			
			
			
			$yearcm= $termmaster->getYearcmterm($sem);
			
			//print_r($yearcm); die();
			
            

            $result = $prometed_master->GetRecords($year, $session, $batch,$sem);
           
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
			 
			$this->view->semester = $sem;
			$this->view->termdata= $termdata;
            $this->view->semFee = $semFee;
			$this->view->yearcm = $yearcm;
			 
			 //echo "<pre>";print_r($result);exit;
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
		
        $fee_model= new Application_Model_FeeCollector();
		$fee_collection_items= new Application_Model_FeeCollectorItems();
		
		$feehostroy = new Application_Model_FeeHistroy();
			   
        $this->view->stid = $_GET['stid'];
        $this->view->academic = $_GET['academic'];
		$this->view->semester = $_GET['term'];
		$collection_id=$_GET['collection_id'];
	if($_POST) {
		
		//echo "<pre>";  print_r($_POST); die();
		if($collection_id)  {
			
			$getreords= $fee_model->getRecord($collection_id);
			
		for($i=0; $i<count($_POST['pay_amt']);$i++) {
			$totalpaid+=$_POST['pay_amt'][$i];
			
		      }
			 $totalpaid= $totalpaid+$getreords['total_paid'];
			  
		$totaldues= $_POST['terms_amt']-$totalpaid;
		
		$inserdata = array(
		
		'student_id'=>$_POST['student_id'],
		'total_fees'=>$_POST['terms_amt'],
		'total_paid'=>$totalpaid,
		'total_due'=>$totaldues,
		'sem_year'=>$_POST['term_id'],
		'academic_year_id'=>$_POST['academic_year_id'],
	    'discount'=>$_POST['discount']+$getreords['discount'],
		'extra_charges'=>$_POST['extra_charges']+$getreords['extra_charges'],
		);
		$last_insert_id= $fee_model->update($inserdata,array('id=?' => $collection_id));
		 $new_slip_no = $feehostroy->getNextSlipNo();
             
			 if($new_slip_no['nextslip']) 
			 {
				 $next_slip_no=$new_slip_no['nextslip']+1;
			 } else { $next_slip_no=1; }
		 $feehistory= array(
		     's_id'=>$_POST['student_id'],
			 'collect_id'=>$collection_id,
			 'slip_no'=>$next_slip_no,
			 'admin_id'=>$_POST['userid'],
			 'total_amount'=>$_POST['terms_amt'],
			 'duse'=>$_POST['terms_amt']-$_POST['sumtotal'],
			 'paid'=>$_POST['sumtotal'],
			 'fee'=>$_POST['sumtotal'],
			 'pay_status'=>$_POST['payment_mode'],
			 'txn_id'=>$_POST['transaction_id'],
			 'bank_id'=>$_POST['account_id'],
			 'paid_date'=>$_POST['paid_date'],
			 'check_dd'=>$_POST['check_dd'],
			 'remarks'=>$_POST['remarks'],
			 'discount'=>$_POST['discount'],
			 'extra_charges'=>$_POST['extra_charges'],
			 
		 
		 );
		 
		 $last_history_id= $feehostroy->insert($feehistory);
		 
		
		//print_r($last_insert_id); die();
		 for ($k = 0; $k < count($_POST['feehead_id']); $k++) {

            $terms_data['collector_id'] = $collection_id;
			$terms_data['t_history_id'] = $last_history_id;
            $terms_data['head_id'] = $_POST['feehead_id'][$k];
		    $terms_data['paid_amt'] = $_POST['pay_amt'][$k];
			$terms_data['dues_amt'] = $_POST['terms_dues_head'][$k]-$_POST['pay_amt'][$k];
			$terms_data['account_id']= $_POST['account_id'];	
            $terms_data['pay_mode']= $_POST['payment_mode'];		
            $terms_data['transaction_id']= $_POST['transaction_id'];							
			$last= $fee_collection_items->insert($terms_data);						
		 }	
			
		} 
		else {
		for($i=0; $i<count($_POST['pay_amt']);$i++) {
			$totalpaid+=$_POST['pay_amt'][$i];
			
		      }
		$totaldues= $_POST['terms_amt']-$totalpaid;
		
		$inserdata = array(
		
		'student_id'=>$_POST['student_id'],
		'total_fees'=>$_POST['terms_amt'],
		'total_paid'=>$totalpaid,
		'total_due'=>$totaldues,
		'sem_year'=>$_POST['term_id'],
		'academic_year_id'=>$_POST['academic_year_id'],
		'discount'=>$_POST['discount'],
		'extra_charges'=>$_POST['extra_charges'],
		);
		$last_insert_id= $fee_model->insert($inserdata);
		
		  $new_slip_no = $feehostroy->getNextSlipNo();
             
			 if($new_slip_no['nextslip']) 
			 {
				 $next_slip_no=$new_slip_no['nextslip']+1;
			 } else { $next_slip_no=1; }
		 $feehistory= array(
		     's_id'=>$_POST['student_id'],
			 'collect_id'=>$last_insert_id,
			 'slip_no'=>$next_slip_no,
			 'admin_id'=>$_POST['userid'],
			 'total_amount'=>$_POST['terms_amt'],
			 'duse'=>$_POST['terms_amt']-$_POST['sumtotal'],
			 'paid'=>$_POST['sumtotal'],
			 'fee'=>$_POST['sumtotal'],
			 'pay_status'=>$_POST['payment_mode'],
			 'txn_id'=>$_POST['transaction_id'],
			 'bank_id'=>$_POST['account_id'],
			 'paid_date'=>$_POST['paid_date'],
			 'check_dd'=>$_POST['check_dd'],
			 'remarks'=>$_POST['remarks'],
			 'discount'=>$_POST['discount'],
			 'extra_charges'=>$_POST['extra_charges'],
			 
		 
		 );
		 
		 $last_history_id= $feehostroy->insert($feehistory);
		
		 for ($k = 0; $k < count($_POST['feehead_id']); $k++) {

            $terms_data['collector_id'] = $last_insert_id;
			$terms_data['t_history_id'] = $last_history_id;
            $terms_data['head_id'] = $_POST['feehead_id'][$k];
		    $terms_data['paid_amt'] = $_POST['pay_amt'][$k];
			$terms_data['dues_amt'] = $_POST['terms_amt_head'][$k]-$_POST['pay_amt'][$k];
			$terms_data['account_id']= $_POST['account_id'];	
            $terms_data['pay_mode']= $_POST['payment_mode'];		
            $terms_data['transaction_id']= $_POST['transaction_id'];

			
			$last= $fee_collection_items->insert($terms_data);						
		 }
		 
		
		 
		}
		$_SESSION['message_class'] = 'alert-success';
        $this->_flashMessenger->addMessage('Fee Structure Successfully added');
		$this->_redirect('fee-collection/index');
	}
		
		
		
		 $this->view->collection=$collection_id;
		
		
		///$fee_form= new Application_Form_FeeCollector();
		//$this->view->form = $fee_form;
		
    }

public function paycastAction() {
        $this->view->action_name = 'Fees Collection';
        $this->view->sub_title_name = 'Fee Collection';
        $this->accessConfig->setAccess("SA_ACAD_FEE_HEADS");
		
        $fee_model= new Application_Model_FeeCollector();
		$fee_collection_items= new Application_Model_FeeCollectorItems();
		$duesdate_model= new Application_Model_DuesDate();
		$feehostroy = new Application_Model_FeeHistroy();
			   
        $this->view->stid = $_GET['stid'];
        $this->view->academic = $_GET['academic'];
		$this->view->semester = $_GET['term'];
		$this->view->cast = $_GET['cast'];
		$collection_id=$_GET['collection_id'];
	if($_POST) {
		
		//echo "<pre>";  print_r($_POST); die();
		if($collection_id)  {
			
			$getreords= $fee_model->getRecord($collection_id);
			
		for($i=0; $i<count($_POST['pay_amt']);$i++) {
			$totalpaid+=$_POST['pay_amt'][$i];
			
		      }
			 $totalpaid= $totalpaid+$getreords['total_paid'];
			  
		$totaldues= $_POST['terms_amt']-$totalpaid;
		
		$inserdata = array(
		
		'student_id'=>$_POST['student_id'],
		'total_fees'=>$_POST['terms_amt'],
		'total_paid'=>$totalpaid,
		'total_due'=>$totaldues,
		'sem_year'=>$_POST['term_id'],
		'academic_year_id'=>$_POST['academic_year_id'],
	    'discount'=>$_POST['discount']+$getreords['discount'],
		'extra_charges'=>$_POST['extra_charges']+$getreords['extra_charges'],
		);
		$last_insert_id= $fee_model->update($inserdata,array('id=?' => $collection_id));
		 $new_slip_no = $feehostroy->getNextSlipNo();
             
			 if($new_slip_no['nextslip']) 
			 {
				 $next_slip_no=$new_slip_no['nextslip']+1;
			 } else { $next_slip_no=1; }
		 $feehistory= array(
		     's_id'=>$_POST['student_id'],
			 'collect_id'=>$collection_id,
			 'slip_no'=>$next_slip_no,
			 'admin_id'=>$_POST['userid'],
			 'total_amount'=>$_POST['terms_amt'],
			 'duse'=>$_POST['terms_amt']-$_POST['sumtotal'],
			 'paid'=>$_POST['sumtotal'],
			 'fee'=>$_POST['sumtotal'],
			 'pay_status'=>$_POST['payment_mode'],
			 'txn_id'=>$_POST['transaction_id'],
			 'bank_id'=>$_POST['account_id'],
			 'paid_date'=>$_POST['paid_date'],
			 'check_dd'=>$_POST['check_dd'],
			 'remarks'=>$_POST['remarks'],
			 'discount'=>$_POST['discount'],
			 'extra_charges'=>$_POST['extra_charges'],
			 
		 
		 );
		 
		 $last_history_id= $feehostroy->insert($feehistory);
		 
		
		//print_r($last_insert_id); die();
		 for ($k = 0; $k < count($_POST['feehead_id']); $k++) {

            $terms_data['collector_id'] = $collection_id;
			$terms_data['t_history_id'] = $last_history_id;
            $terms_data['head_id'] = $_POST['feehead_id'][$k];
		    $terms_data['paid_amt'] = $_POST['pay_amt'][$k];
			$terms_data['dues_amt'] = $_POST['terms_dues_head'][$k]-$_POST['pay_amt'][$k];
			$terms_data['account_id']= $_POST['account_id'];	
            $terms_data['pay_mode']= $_POST['payment_mode'];		
            $terms_data['transaction_id']= $_POST['transaction_id'];							
			$last= $fee_collection_items->insert($terms_data);						
		 }

         $upd_data = array(
                "dues_date" => $_POST['dues_date'],
				"stu_id"=>$_POST['student_id'],
				"academic_id"=>$_POST['academic_year_id'],
				"session"=>$_POST['session'],
				"term_id"=>$_POST['term_id'],
				"history_id"=>$last_history_id,
                
            );
			
			$upddata = array( "dues_date" => $_POST['dues_date'], "history_id"=>$last_history_id, );
			$chkrecords = $duesdate_model->getTotalpaidfeebystu($_POST['student_id'],$_POST['term_id'],$_POST['academic_year_id'],$_POST['session']);
			if(!empty($chkrecords)) {
			$up= $duesdate_model->update($upddata, array('stu_id=?' => $_POST['student_id'],'academic_id=?' => $_POST['academic_year_id'],'session=?' => $_POST['session'],'term_id=?' => $_POST['term_id']));
			}
			else {
		    $up= $duesdate_model->insert($upd_data);
			}

		 
			
		} 
		else {
		for($i=0; $i<count($_POST['pay_amt']);$i++) {
			$totalpaid+=$_POST['pay_amt'][$i];
			
		      }
		$totaldues= $_POST['terms_amt']-$totalpaid;
		
		$inserdata = array(
		
		'student_id'=>$_POST['student_id'],
		'total_fees'=>$_POST['terms_amt'],
		'total_paid'=>$totalpaid,
		'total_due'=>$totaldues,
		'sem_year'=>$_POST['term_id'],
		'academic_year_id'=>$_POST['academic_year_id'],
		'discount'=>$_POST['discount'],
		'extra_charges'=>$_POST['extra_charges']
		
		);
		$last_insert_id= $fee_model->insert($inserdata);
		
		  $new_slip_no = $feehostroy->getNextSlipNo();
             
			 if($new_slip_no['nextslip']) 
			 {
				 $next_slip_no=$new_slip_no['nextslip']+1;
			 } else { $next_slip_no=1; }
		 $feehistory= array(
		     's_id'=>$_POST['student_id'],
			 'collect_id'=>$last_insert_id,
			 'slip_no'=>$next_slip_no,
			 'admin_id'=>$_POST['userid'],
			 'total_amount'=>$_POST['terms_amt'],
			 'duse'=>$_POST['terms_amt']-$_POST['sumtotal'],
			 'paid'=>$_POST['sumtotal'],
			 'fee'=>$_POST['sumtotal'],
			 'pay_status'=>$_POST['payment_mode'],
			 'txn_id'=>$_POST['transaction_id'],
			 'bank_id'=>$_POST['account_id'],
			 'paid_date'=>$_POST['paid_date'],
			 'check_dd'=>$_POST['check_dd'],
			 'remarks'=>$_POST['remarks'],
			 'discount'=>$_POST['discount'],
			 'extra_charges'=>$_POST['extra_charges'],
			 
		 
		 );
		 
		 $last_history_id= $feehostroy->insert($feehistory);
		
		 for ($k = 0; $k < count($_POST['feehead_id']); $k++) {

            $terms_data['collector_id'] = $last_insert_id;
			$terms_data['t_history_id'] = $last_history_id;
            $terms_data['head_id'] = $_POST['feehead_id'][$k];
		    $terms_data['paid_amt'] = $_POST['pay_amt'][$k];
			$terms_data['dues_amt'] = $_POST['terms_amt_head'][$k]-$_POST['pay_amt'][$k];
			$terms_data['account_id']= $_POST['account_id'];	
            $terms_data['pay_mode']= $_POST['payment_mode'];		
            $terms_data['transaction_id']= $_POST['transaction_id'];

			
			$last= $fee_collection_items->insert($terms_data);						
		 }
		 
		 $upd_data = array(
                "dues_date" => $_POST['dues_date'],
				"stu_id"=>$_POST['student_id'],
				"academic_id"=>$_POST['academic_year_id'],
				"session"=>$_POST['session'],
				"term_id"=>$_POST['term_id'],
				"history_id"=>$last_history_id,
                
            );
			
			$upddata = array("dues_date" => $_POST['dues_date'] ,"history_id"=>$last_history_id,);
			$chkrecords = $duesdate_model->getTotalpaidfeebystu($_POST['student_id'],$_POST['term_id'],$_POST['academic_year_id'],$_POST['session']);
			if(!empty($chkrecords)) {
			$up= $duesdate_model->update($upddata, array('stu_id=?' => $_POST['student_id'],'academic_id=?' => $_POST['academic_year_id'],'session=?' => $_POST['session'],'term_id=?' => $_POST['term_id']));
			}
			else {
		    $up= $duesdate_model->insert($upd_data);
			}
		 
		}
		$_SESSION['message_class'] = 'alert-success';
        $this->_flashMessenger->addMessage('Fee Structure Successfully added');
		$this->_redirect('fee-collection/castwise');
	}
		
		$messages = $this->_flashMessenger->getMessages();
        $this->view->messages = $messages;
		
		 $this->view->collection=$collection_id;
		
		
		///$fee_form= new Application_Form_FeeCollector();
		//$this->view->form = $fee_form;
		
    }


    public function ajaxGetFeeStructure1Action() {

        $this->_helper->layout->disableLayout();
		
		$storage = new Zend_Session_Namespace("admin_login");
    	$data = $storage->admin_login;
			
			
				
            $Academic_model = new Application_Model_Academic();
            $FeeCategory_model = new Application_Model_FeeCategory();
            $FeeHeads_model = new Application_Model_FeeHeads();
            $FeeStructure_model = new Application_Model_FeeStructure();
			$FeeStructure_modelcast = new Application_Model_FeeStructureCast();
            $StructureItems_model = new Application_Model_FeeStructureItems();
            $term_model = new Application_Model_TermMaster();
            $TermItems_model = new Application_Model_FeeStructureTermItems();
            $dept_details = new Application_Model_Department();
            $dept_type_details = new Application_Model_DepartmentType();
			$fee_form= new Application_Form_FeeCollector();
			$feecollection =  new Application_Model_FeeCollector();
			$feecollectionitems =  new Application_Model_FeeCollectorItems();
			$feehostroy = new Application_Model_FeeHistroy();
		    $this->view->form = $fee_form;
			
		   $Erpstu = new Application_Model_StudentPortal();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $academic_year_id = $this->_getParam("academic_year_id");
            $this->view->stid = $this->_getParam("stid");    
            $this->view->term = $this->_getParam("term");    
			$term_id= $this->_getParam("term");
			$stuid = $this->_getParam("stid");
			$cast = $this->_getParam("cast");
			
			//$collectID = $this->_getParam("collect");
			///print_r($academic_year_id);	die();
			
			if($cast)
	        $strId = $FeeStructure_modelcast->getStructIdAll($academic_year_id,$cast);
		    else 
		   $strId = $FeeStructure_model->getStructIdAll($academic_year_id);
	   
            $studetials= $Erpstu->getStudenInfo($this->_getParam("stid"));
					 
			$getallfeesdetails=$feecollection->getTotalpaidfeebystu($stuid,$term_id,$academic_year_id);
		
		if($getallfeesdetails) {
			$getallpaidfee=$feecollectionitems->getTotalfee($getallfeesdetails);
			
		   $getallpaidfee1=$feecollectionitems->getTotalfee1($getallfeesdetails);
		}
			
            $acad_details =  $Academic_model->getRecord($academic_year_id);

            $department = $acad_details['department'];
            $session = $acad_details['session'];
            $department = !empty($department)?$department:exit;

            $dept_type_id = $dept_details->getRecord($department)['department_type'];
            $dept_type_id = !empty($dept_type_id)?$dept_type_id:exit;
              
			    
			
            
            if (!empty($strId)) {

             $result = $TermItems_model->getItemRecords1($strId,$term_id);
			
          
             $this->view->result = $result;

             $result1 = $StructureItems_model->getStructureRecords($strId);

             $this->view->result1 = $result1;
             $academic_id  = $TermItems_model->getAcademicId($strId);
             $terms_data = $term_model->getRecord($term_id);

             $degree_id = $Academic_model->getAcademicDegree($academic_year_id);
             $this->view->term_data = $terms_data; 
             $this->view->structure_id = $strId;
             $Category_data = $FeeCategory_model->getCategory($degree_id['degree_id'],$session,$dept_type_id);
        
             $this->view->Category_data = $Category_data;

             $Feeheads_data = $FeeHeads_model->getFeeheads($degree_id['degree_id'],$session,$dept_type_id);

             // echo "<pre>";  print_r($terms_data); die();
             $this->view->Feeheads_data = $Feeheads_data;
			 $this->view->accounts=$account;
			 $this->view->studetails=$studetials;
			 $this->view->acad_details=$acad_details;
			 $this->view->fee_acad_details=$getallpaidfee;
			 $this->view->discount= $getallfeesdetails[0]['discount'];
			 $this->view->extra_charges= $getallfeesdetails[0]['extra_charges'];
			 $this->view->userid=$data->empl_id;
			
			
			 

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
		
		   if($getallfeesdetails) {
			   
			 
            $allrecords= $feehostroy->getRecords($getallfeesdetails[0]['id']);
			  //echo "<pre>";  print_r($allrecords);die;
		    $this->view->allrecords = $allrecords;
			
			}
    }
}



 public function ajaxGetFeeStructureAction() {

        $this->_helper->layout->disableLayout();
		
		$storage = new Zend_Session_Namespace("admin_login");
    	$data = $storage->admin_login;
			
			//print_r($data->empl_id);	die();
				
            $Academic_model = new Application_Model_Academic();
            $FeeCategory_model = new Application_Model_FeeCategory();
            $FeeHeads_model = new Application_Model_FeeHeads();
            $FeeStructure_model = new Application_Model_FeeStructure();
            $StructureItems_model = new Application_Model_FeeStructureItems();
            $term_model = new Application_Model_TermMaster();
            $TermItems_model = new Application_Model_FeeStructureTermItems();
            $dept_details = new Application_Model_Department();
            $dept_type_details = new Application_Model_DepartmentType();
			$fee_form= new Application_Form_FeeCollector();
			$feecollection =  new Application_Model_FeeCollector();
			$feecollectionitems =  new Application_Model_FeeCollectorItems();
			$feehostroy = new Application_Model_FeeHistroy();
		    $this->view->form = $fee_form;
			
		   $Erpstu = new Application_Model_StudentPortal();

        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {

            $academic_year_id = $this->_getParam("academic_year_id");
            $this->view->stid = $this->_getParam("stid");    
            $this->view->term = $this->_getParam("total");    
			$term_id= $this->_getParam("term");
			$stuid = $this->_getParam("stid");
			//$collectID = $this->_getParam("collect");
	        $strId = $FeeStructure_model->getStructIdAll($academic_year_id);
            $studetials= $Erpstu->getStudenInfo($this->_getParam("stid"));
					 
			$getallfeesdetails=$feecollection->getTotalpaidfeebystu($stuid,$term_id,$academic_year_id);
		
		if($getallfeesdetails) {
			$getallpaidfee=$feecollectionitems->getTotalfee($getallfeesdetails);
			
		   $getallpaidfee1=$feecollectionitems->getTotalfee1($getallfeesdetails);
		}
			
            $acad_details =  $Academic_model->getRecord($academic_year_id);

            $department = $acad_details['department'];
            $session = $acad_details['session'];
            $department = !empty($department)?$department:exit;

            $dept_type_id = $dept_details->getRecord($department)['department_type'];
            $dept_type_id = !empty($dept_type_id)?$dept_type_id:exit;
              
			  
			  
            
            if (!empty($strId)) {

             $result = $TermItems_model->getItemRecords1($strId,$term_id);
			 
          
             $this->view->result = $result;

             $result1 = $StructureItems_model->getStructureRecords($strId);

             $this->view->result1 = $result1;
             $academic_id  = $TermItems_model->getAcademicId($strId);
             $terms_data = $term_model->getRecord($term_id);

             $degree_id = $Academic_model->getAcademicDegree($academic_year_id);
             $this->view->term_data = $terms_data; 
             $this->view->structure_id = $strId;
             $Category_data = $FeeCategory_model->getCategory($degree_id['degree_id'],$session,$dept_type_id);
        
             $this->view->Category_data = $Category_data;

             $Feeheads_data = $FeeHeads_model->getFeeheads($degree_id['degree_id'],$session,$dept_type_id);

               /// echo "<pre>";  print_r($result1);
             $this->view->Feeheads_data = $Feeheads_data;
			 $this->view->accounts=$account;
			 $this->view->studetails=$studetials;
			 $this->view->acad_details=$acad_details;
			 $this->view->fee_acad_details=$getallpaidfee;
			 $this->view->discount= $getallfeesdetails[0]['discount'];
			 $this->view->extra_charges= $getallfeesdetails[0]['extra_charges'];
			  $this->view->userid=$data->empl_id;
			
			
			 

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
		
		   if($getallfeesdetails) {
			   
			 
            $allrecords= $feehostroy->getRecords($getallfeesdetails[0]['id']);
			  //echo "<pre>";  print_r($allrecords);die;
		    $this->view->allrecords = $allrecords;
			
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
           // print_r($_POST); exit;
        }
    }
	
	
function printslipAction () {
        $this->_helper->layout->setLayout("applicationlayout");

        $s_id = $this->_getParam("stuid");
        $collect = $this->_getParam("collect");
		$hid = $this->_getParam("hid");
		
        $fee_collector_model = new Application_Model_FeeCollector();
        $allresult= $fee_collector_model->GetTransactionDetails($s_id,$collect,$hid);
		//print_r($allresult); die();
		$this->view->result=$allresult;
        
         
      
    }	
	public function castwiseAction() {
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
	
	public function ajaxGetStudents1Action() {
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            // $degree = $this->_getParam("degree");
            $year = $this->_getParam("year");
            $session = $this->_getParam("session");
            $batch = $this->_getParam("batch");
			$sem = $this->_getParam("sem");
			$cast = $this->_getParam("cast");
			 $feeStr = new Application_Model_FeeStructureCast();
            $feeStrItem = new Application_Model_FeeStructureItems();
			 $fee_collector_model = new Application_Model_FeeCollector();
			$termmaster= new Application_Model_TermMaster();
			      $termdata=   $termmaster->getRecord($sem);
			
		//	$strId = $feeStr->getStructIdAll($batch,$cast);
              
           // $allTermFee = $feeStrItem->getStructureRecordsAll1($strId);
			
			 $result = $fee_collector_model->get_student_record3($year, $session, $batch,$sem);
			  //echo "<pre>";print_r($result);exit;
			 
            $semFee = array();
			
			foreach($result as $key => $value){
				if($termdata['cmn_terms']!='') {
                    switch ($termdata['cmn_terms']) {
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
						case "t7":
                            $semFee[$value['academic_id']]= $value['grand_term7_result'];
							  break;
						case "t8":
                            $semFee[$value['academic_id']]= $value['grand_term8_result'];
                            break;
                        default:
                            echo "n/a";
                    }
				}
				else {
				
				switch ($termdata['year_id']) {
                        case "1":
                            $semFee[$value['academic_id']]= $value['grand_term1_result'];
                            break;
                        case "2":
                           $semFee[$value['academic_id']]= $value['grand_term2_result'];
                            break;
                        case "3":
                            $semFee[$value['academic_id']]= $value['grand_term3_result'];
                            break;
                        case "4":
                            $semFee[$value['academic_id']]= $value['grand_term4_result'];
                            break;
                        case "5":
                            $semFee[$value['academic_id']]= $value['grand_term5_result'];
                            break;
                        case "6":
                            $semFee[$value['academic_id']]= $value['grand_term6_result'];
                            break;
                        default:
                            echo "n/a";
                    }
			     }
            }
			
			$yearcm= $termmaster->getYearcmterm($sem);
			
			///print_r($yearcm); die();
			
           

            //$result = $fee_collector_model->get_student_record3($year, $session, $batch,$sem);
			
			if(empty($result)) {
				
				echo '0';
				
			}
			
           
            $page = $this->_getParam('page', 1);
            $paginator_data = array(
                'page' => $page,
                'result' => $result
            );
			 
			$this->view->semester = $sem;
			$this->view->termdata= $termdata;
            $this->view->semFee = $semFee;
			 
			
            $this->view->paginator = $this->_act->pagination($paginator_data);
            // $result;
            // echo "<pre>";print_r($this->view->paginator);exit;
            // echo '<option value="">Select</option>';
            // foreach ($result as $k => $val) {
            //     echo '<option value="' . $val['academic_year_id'] . '" >' . $val['short_code'] . '</option>';
            // }
        }
    }



function ajaxUpdateDuesDateAction () {
        $this->_helper->layout->disableLayout();
      if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            
            $duesdate = $this->_getParam("duessdate");
			$stuid = $this->_getParam("stuid");
			$termid = $this->_getParam("termid");
			$acadid = $this->_getParam("acadid");
			$sessionid = $this->_getParam("sessionid");
			
			$duesdate_model= new Application_Model_DuesDate();
			
            $fee_collector_model = new Application_Model_FeeCollector();
			
			
			
			
			
			
            $upd_data = array(
                "dues_date" => $duesdate,
				"stu_id"=>$stuid,
				"academic_id"=>$acadid,
				"session"=>$sessionid,
				"term_id"=>$termid,
                
            );
			
			$upddata = array(
                "dues_date" => $duesdate,
				
                
            );
			
            // exit;
			//print_r($upd_data); die();
			$chkrecords = $duesdate_model->getTotalpaidfeebystu($stuid,$termid,$acadid,$sessionid);
			
			if(!empty($chkrecords)) {
				
			 $up= $duesdate_model->update($upddata, array('stu_id=?' => $stuid,'academic_id=?' => $acadid,'session=?' => $sessionid,'term_id=?' => $termid));
			}
			else {
		    $up= $duesdate_model->insert($upd_data);
		 
			}
           //  $upd= $fee_collector_model->update($upd_data, array('student_id=?' => $stuid));
            echo $up;
           // print_r($_POST); exit;
        } die();
    }
	
}