<?php

class ContributionController extends Zend_Controller_Action {

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
    private $_sms = NULL;
    private $_mail = Null;
    private $cookie_expire = null;

    public function init() {
        $zendConfig = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        require_once APPLICATION_PATH . '/configs/access_level.inc';

        $this->accessConfig = new accessLevel();
        $config = $zendConfig->mainconfig->toArray();
        $this->view->mainconfig = $config;
         $this->_base_url = $config['host'];
        $this->_action = $this->getRequest()->getActionName();
        $this->cookie_expire = $zendConfig->loginexpiration;
        //access role id
        $this->roleConfig = $config_role = $zendConfig->role_administrator->toArray();
        $this->aeccConfig = $config_role = $zendConfig->aecc_course->toArray();
        $this->view->administrator_role = $config_role;
        $storage = new Zend_Session_Namespace("user_login");
        $this->login_storage = $data = $storage->user_login;
        $this->view->login_storage = $data;
        //echo '<pre>'; print_r($storage->user_login);exit;
        $user_log = new Application_Model_UserLog();
        //echo '<pre>'; print_r($storage->unique_id);exit;
        if (isset($data)) {
            $user_log_details = $user_log->getRecordByemplId($data['app_id'], $storage->unique_id);
            if ($user_log_details) {

                if (!isset($_COOKIE['user_login_status'])) {
                    $user_log->update(array("status" => 0), array("empl_id=?" => $storage->user_login->app_id, "unique_id=?" => $storage->unique_id, "status=?" => 1));
                    $storage->unsetAll();
                    setcookie('user_login_status', "", time() - (60 * $this->cookie_expire), "/", "", false);
                    $this->_redirect("entrance-exam-form");
                } else {
                    setcookie('user_login_status', "", time() - (60 * $this->cookie_expire), "/", "", false);
                    setcookie('user_login_status', md5($storage->unique_id), time() + (60 * $this->cookie_expire), "/; samesite=Lax", "", true, true);
                }
            } else {
                $storage->unsetAll();
                setcookie('user_login_status', "", time() - (60 * $this->cookie_expire), "/", "", false);
                $this->_redirect("entrance-exam-form");
            }
        }

        $this->_helper->layout->setLayout("entranceexamlayout");


        $this->_flashMessenger = $this->_helper->FlashMessenger;
        $this->authonticate();

        //$this->_act = new Application_Model_Adminactions();
        //$this->_db = Zend_Db_Table::getDefaultAdapter();
        //echo '<pre>';print_r($_SESSION);exit;
    }

    protected function authonticate() {
 
        $storage = new Zend_Session_Namespace("user_login");
        $this->login_storage = $data = $storage->user_login;
        $this->view->login_storage = $data;
        //echo '<pre>'; print_r($data);exit;
        if (!empty($data['app_id'])) {
            
             
            $courseModel = new Application_Model_ApplicantCourseDetailModel();
          
            $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
            $check_applicationStatus = $courseModel->check_form_status($data['app_id']);
            //Check Payment Status
            $check_payment_status = $paymentModel->check_payment_status($data['app_id']);

            //echo '<pre>'; print_r($check_applicationStatus); exit;
            foreach ($check_payment_status as $pay) {
               
                if ($pay['payment_status'] == 1) {
                 
                    $this->_redirectJs("multi-step-form/document-dashboard/a_id/" . md5($data['app_id']));
                }
          
            }
            

               
        
            if ($check_applicationStatus['form_status'] === 'okey') {
                $this->_redirectJs("multi-step-form/index/type/step4/a_id/" . md5($data['app_id']));
            } else {
            
              //  header("Location: https://pwcadmissions.in/academic/multi-step-form/status-dashboard/a_id/");
                //  $this->_refresh(5,"multi-step-form/status-dashboard/a_id/",'Opps fixing bugs !');
              $this->_redirectJs("multi-step-form/status-dashboard/a_id/" . md5($data['app_id']));
                //$this->_redirect("entrance-exam-form/welcome-page/a_id/".md5($data['app_id']));
            }
        }
    }

    public function indexAction() {

        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
      
       $this->accessConfig->setAccess('SS_ALUM_AR');
       
        $alumini_model = new Application_Model_Contribution();
         $transactionRequest = new Application_Model_TransactionRequest();
        $this->view->form = $entrance_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        //echo '<pre>'; print_r($token);exit;
       
        
       
            if ($this->getRequest()->getPost()) {
            $data = $this->getRequest()->getPost();
           
            $dirPath1 = realpath(APPLICATION_PATH . '/../public/alumini') .'/doc/';
              $extensions=array("jpeg","jpg","png","pdf");    
                $file_name = $_FILES['document']['name'];
                $file_size =$_FILES['document']['size'];
                $file_tmp =$_FILES['document']['tmp_name'];
                $file_type=$_FILES['document']['type'];
                $file_ext=explode('.',$_FILES['document']['name']);
                
                
                $file_name1 = $_FILES['pan_card']['name'];
                $file_size1 =$_FILES['pan_card']['size'];
                $file_tmp1 =$_FILES['pan_card']['tmp_name'];
                $file_type1=$_FILES['pan_card']['type'];
                $file_ext1=explode('.',$_FILES['pan_card']['name']);
                
                
                $file_name2 = $_FILES['adhar_doc']['name'];
                $file_size2 =$_FILES['adhar_doc']['size'];
                $file_tmp2 =$_FILES['adhar_doc']['tmp_name'];
                $file_type2=$_FILES['adhar_doc']['type'];
                $file_ext2=explode('.',$_FILES['adhar_doc']['name']);
               
              if(!empty($_FILES['document']['name']) && in_array($file_ext[1], $extensions)){
                  
                  move_uploaded_file($_FILES["document"]["tmp_name"], $dirPath1.$file_name) ;
                   
              }
              if(!empty($_FILES['pan_card']['name']) && in_array($file_ext1[1], $extensions)){
                  
                  move_uploaded_file($_FILES["pan_card"]["tmp_name"], $dirPath1.$file_name1) ;
                   
              }
              if(!empty($_FILES['adhar_doc']['name']) && in_array($file_ext2[1], $extensions)){
                  
                  move_uploaded_file($_FILES["adhar_doc"]["tmp_name"], $dirPath1.$file_name2) ;
                   
              }

        // die();
              if($data['pay_mode']!='Online'){
                  
                  $data['document'] = $file_name;
              }
               $data['pan_card'] = $file_name1;
               $data['adhar_doc'] = $file_name2;
               $data['create_date']=date('Y-m-d');
          //     echo "<pre>";print_r($data); die();
           $last_insert_id= $alumini_model->insert($data);
            
            $this->_flashMessenger->addMessage('Payment Successfully now You can Download your Admit Card');
            if($data['pay_mode']=='Online')  {   
            date_default_timezone_set('Asia/Calcutta');
                        $datenow = date("d/m/Y h:m:s");
                        $transactionDate = str_replace(" ", "%20", $datenow);

                        $transactionId = rand(1,1000000);
///$data['contri_amt']
                        //Setting all values here
                        $transactionRequest->setMode("live");
                        $transactionRequest->setLogin(53243);
                        $transactionRequest->setPassword("Patna@1234");
                        $transactionRequest->setProductId('ALUMNI_FUND');
                        $transactionRequest->setAmount($data['contri_amt']);
                        $transactionRequest->setTransactionCurrency("INR");
                        $transactionRequest->setTransactionAmount($data['contri_amt']);
                        $transactionRequest->setReturnUrl($this->_base_url  . 'contribution/response/?id='.$last_insert_id);
                        $transactionRequest->setClientCode(53243);
                        $transactionRequest->setTransactionId($transactionId);
                        $transactionRequest->setTransactionDate($transactionDate);
                        $transactionRequest->setCustomerName($_POST['name']);
                        $transactionRequest->setCustomerEmailId($_POST['email_id']);
                        $transactionRequest->setCustomerMobile($_POST['mobile']);
                        $transactionRequest->setCustomerBillingAddress($_POST['city']);
                        $transactionRequest->setCustomerId('Contribution');
                        $transactionRequest->setCustomerAccount("639827");
                        $transactionRequest->setReqHashKey("b338c08a991313f12c");

                        $url = $transactionRequest->getPGUrl();
                     
                        //$this->curlRedirect($url);
                        $this->_redirect($url);
            }
                      //$this->_redirect('application/admitcard');
                  
            if($last_insert_id) {
                $_SESSION['message_class'] = 'alert-success';
                                $this->_flashMessenger->addMessage('Details Added Successfully ');
                                 $this->_redirect('contribution/thankyou');
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
               $_SESSION['message_class'] = 'alert-danger';
               $this->_flashMessenger->addMessage('Not Insert ');
                
            }
        
    }
         
}
  
    
public function responseAction(){
    
    
   
    require_once APPLICATION_PATH . '/public/atompay/TransactionResponse.php';
        
            $alumini_model = new Application_Model_Aluminiassociation();
            $transactionResponse = new Application_Model_TransactionResponse();
          //  $transactionResponse = new Application_Model_TransactionResponse();
          
         $transactionResponse = new TransactionResponse();
            $transactionResponse->setRespHashKey("8b013258b7a4b89428");
            $check_arr['b4'][] = $_POST;
            $this->view->vaild_response = $transactionResponse->validateResponse($_POST);
            $check_arr['aftr'][] = $_POST;
         //  echo "<pre>"; print_r( $check_arr); die(); 
           if($_GET['id']=='')
              $this->_redirect ($this->_main_url);
            $id= $_GET['id'];
            $last_id = $id;
            $updatedata = array(
                'mmp_txn'=>$_POST['mmp_txn'],
                'mer_txn'=>$_POST['mer_txn'],
                'bank_txn'=>$_POST['bank_txn'],
                'bank_name'=>$_POST['bank_name'],
                'prod'=>$_POST['prod'],
                'date'=>$_POST['date'],
                'f_code'=>$_POST['f_code'],
                'clientcode'=>$_POST['clientcode'],
                'merchant_id'=>$_POST['merchant_id'],
                'status'=>1
            );
                
            if($_POST['f_code'] == 'Ok'){
                    $alumini_model->update($updatedata, array('id=?'=>$last_id));
                    $this->view->response_data = $_POST;
             }
         }
         
        //   public function thankyouAction(){
 
           
        //  }  
    
public function sendmail($to,$message){
    $to = $to[0];
$subject = "PWC Application Form 2022";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <support@finessewebtech.com>' . "\r\n";
    mail($to,$subject,$message,$headers);

    
    
}

}
 