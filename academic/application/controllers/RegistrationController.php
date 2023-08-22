<?php

class RegistrationController extends Zend_Controller_Action {

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
       $this->accessConfig->setAccess('SA_ACAD_ENTRANCE_EXAM_FORM');
       $this->accessConfig->setAccess('SA_ACAD_STUD');
        $entrance_form = new Application_Form_EntranceExam();
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        $courseModel = new Application_Model_ApplicantCourseDetailModel();
        $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
        $user_log = new Application_Model_UserLog();
        $examschedule = new Application_Model_EntranceExamScheduleModel();
        $this->view->form = $entrance_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        //echo '<pre>'; print_r($token);exit;
       
        
       
            if ($this->getRequest()->getPost()) {
            $data = $this->getRequest()->getPost();
            //echo '<pre>'; print_r($data);exit;
            if(!empty($data['csrftoken'])) {
                if($data['csrftoken']===$token ){
                  

                $loginData = array(
                    'application_no' => trim(strtoupper($data['applicant_no'])),
                    'password' => trim($data['password'])
                );
                 $check_login = $entrance_model->checkLogin($loginData);


                if (empty($check_login)) {
                    $this->view->invalid = 'Invalid';
                    $_SESSION['flash_message_error'] = "Invalid registration number or password. Please try again.";
                } else {
                    
                    

                    $applicatonNumber = trim(strtoupper($data['applicant_no']));

                    //Implement session
                    $storage = new Zend_Session_Namespace("user_login");
                    $user_detail['app_id'] = $applicatonNumber;
                    $storage->user_login = $user_detail;
                    $storage->unique_id = uniqid() . rand() . time(date("Y-m-d H:i:s"));
                    setcookie('user_login_status', md5($storage->unique_id), time() + (60 * $this->cookie_expire), "/; samesite=Lax", "", true, true);
                    $userdata['empl_id'] = $user_detail['app_id'];
                    $userdata['last_login'] = date("Y-m-d H:i:s");
                    $userdata['ip'] = $_SERVER['REMOTE_ADDR'];
                    $userdata['unique_id'] = $storage->unique_id;
                    $userdata['sess_vlue'] = $_COOKIE['PHPSESSID'];
                    // echo "<pre>";print_r($userdata);exit;
                    $user_log->insert($userdata);
                   
                    unset($_SESSION["token"]);
                    $this->_redirect("entrance-exam-form");
                    //End
                    //Check Form Status
                    $check_applicationStatus = $courseModel->check_form_status($applicatonNumber);
                    //Check Payment Status
                    $check_payment_status = $paymentModel->check_payment_status($applicatonNumber);

                    //echo '<pre>'; print_r($check_payment_status); exit;
                    
                    foreach ($check_payment_status as $pay) {
                        if ($pay['payment_status'] == 1) {
                            $this->_redirectJs("entrance-exam-form/document-dashboard/a_id/" . md5($data['applicant_no']));
                        }
                    }
                   
                    if ($check_applicationStatus['form_status'] === 'okey')
                    {
                    
                        $this->_redirectJs("multi-step-form/index/type/step4/a_id/" . md5($applicatonNumber));
                    } else 
                    {
                        $this->_redirectJs("multi-step-form/index/type/step1/a_id/" . md5($loginData['application_no']));
                    }
                    
                }
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
                $this->view->tokenInvalid = 'tokenInvalid';
                $_SESSION['flash_token_error'] = "Invalid Token";
                
            }
        }
    }
         
}
    //Registeration Form Action
    public function registerationAction() {
        
       
        
        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
        $this->accessConfig->setAccess('SA_ACAD_ENTRANCE_EXAM_FORM');
        $entrance_form = new Application_Form_EntranceExam();
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        $examschedule = new Application_Model_EntranceExamScheduleModel();
        $academic_year = new Application_Model_AcademicYear();
        $academic_master = new Application_Model_Academic();
         $this->view->course=$_GET['sub'];
        $this->view->degree=$_GET['deg'];
        $this->view->department=$_GET['department'];
        $this->view->form = $entrance_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        $acadYear = $academic_year->getAcadYearId();
        $acad_id = $acadYear['year_id'];
        
        //if(!$_GET['deg'] || !$_GET['department'])
       //     $this->_refresh(5,"https://pwcadmissions.in/",'*Please Enter Correct Url');
           
        // if($acad_id && $_GET['sub'])
        // $academic_details = $academic_master->getRecordByAcadyear($acad_id,$_GET['sub']);
        
        if(!$_GET['deg'] || !$_GET['department']) {
             $record = $examschedule->getFeeform();
        }
        else {
        $record = $examschedule->getFee(0,$_GET['deg'],$_GET['department']);
        }
        
    if(!$record['allow_reg']){
        $strdate = $record['feeForm_start_date'];
        $enddate = $record['feeForm_end_date'];
    }
    
    
        $curdate = date('Y-m-d');
        //if($curdate<$strdate)
        //          {
         //                 $this->_refresh(5,"https://pwcadmissions.in/",'*Entrance exam Schedule Not Start or End Date....');
           //         }else if($curdate>$enddate)
           //         {
            //               $this->_refresh(5,"https://pwcadmissions.in/",'*Entrance exam Schedule Not Start or End Date....');
            //        }else
             //       {
        //echo '<pre>'; print_r($token);exit;
        if ($this->getRequest()->getPost()) {
            $data = $this->getRequest()->getPost();
          //  echo '<pre>'; print_r($data);exit;
            if(!empty($data['csrftoken'])) {
                if($data['csrftoken']===$token ){
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                $data['applicant_name']  = strtoupper($data['applicant_name']);
                $data['ip'] = $ip;
                $data['status'] = 1;
                $data['acad_year_id'] = 6;
                unset($data['cnf_password'], $data['check_otp'], $data['csrftoken'],$data['applicant_no']);
                //echo '<pre>';print_r($data); exit;
                 $emailData = array(
                    'email_id' => trim(strtolower($data['email_id']))
                );
                $checkRegisterMail=$entrance_model->checkEmail($emailData);
                if(!empty($checkRegisterMail))
                   $this->_refresh(3,"/academic/entrance-exam-form/registeration",'*Email id is already registered with us....');
                
                $new_application_no = $entrance_model->getNextApplicationNo();
                $data['application_no'] = $new_application_no['nextid'];
                $insert_id = $entrance_model->insert($data);
                unset($_SESSION["token"]);
                //echo"<pre>";print_r($insert);exit; 
                //Insert or update Applicant field on the basis of email id in the database
                if ($insert_id) {

                
                    //echo '<pre>'; print_r($data['phone']);exit;
                    $to = array(strtolower($data['email_id']));
                    $from = array('support@finessewebtech.com', 'Patna Women\'s College');
                    $first_name = $data['applicant_name'];
                    $subject = "PWC Application Form 2023";
                    $application_no = $new_application_no['nextid'];


                    $message .= "Dear $first_name , <br/><br/> Your login credentials for next step is as follows: <br/> Application No : {$application_no} <br/> Password : {$data['password']} <br/>";
                    $message .= "<a href='https://pwcadmissions.in/academic/entrance-exam-form/login'>click here</a><span>&nbsp;for login</span>";


                    $this->sendmail($to,$message);


                    $mail = new Application_Model_MailSender($to, $from, $subject, $message);
                    //Login Details Information
                    $loginData = array(
                        'application_no' => $application_no
                    );
                    $upsert = $entrance_model->update($loginData, array('phone_number=?' => $data['phone_number'], 'email_id=?' => $data['email_id']));
                    $applicatonNumber = trim($application_no);
                    //echo '<pre>'; print_r($applicatonNumber); exit;
                    //Implement session
                    $this->_mail['user'] = "noreplypwcadmission@gmail.com";
                    $this->_mail['pass'] = "pwc@2022";
                    if ($mail->mail($this->_mail['user'], $this->_mail['pass'])) {
                        echo "Your login credentials for next step is sent on your email id.";
                        /* $storage = new Zend_Session_Namespace("user_login");
                          $user_detail['app_id'] = $applicatonNumber;
                          $storage->user_login = $user_detail;
                          $storage->unique_id = uniqid() . rand() . time(date("Y-m-d H:i:s"));
                          setcookie('user_login_status', '1', time() + (60 * 4), '/'); */
                        $this->_redirect("entrance-exam-form/welcome-page/a_id/" . md5($loginData['application_no']));
                    } else {
                        /* $storage = new Zend_Session_Namespace("user_login");
                          $user_detail['app_id'] = $applicatonNumber;
                          $storage->user_login = $user_detail;
                          $storage->unique_id = uniqid() . rand() . time(date("Y-m-d H:i:s"));
                          setcookie('user_login_status', '1', time() + (60 * 4), '/');
                          $this->_redirect("entrance-exam-form/welcome-page/a_id/".md5($loginData['application_no'])); */
                        echo 'Sent Failed';
                        $this->_redirect("entrance-exam-form/welcome-page/a_id/" . md5($loginData['application_no']));
                    }
                }
            
                }else{
                    //echo '<pre>';print_r('tokenInvalid');exit;
                    $_SESSION['flash_token_error'] = "Invalid Token";
                }
            }
        }
       //}
   // }
    }
	
	
 
    //End Registeration Form
    public function instructionAction() {
       
        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
        $this->view->course=$_GET['sub'];
        $this->view->degree=$_GET['deg'];
        $this->view->department=$_GET['department'];
        
    }

    public function usermanualAction() {
        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
    }

    public function welcomePageAction() {
        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
        $application_id = $this->_getParam("a_id");
        $this->view->a_id = $application_id;
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        if (!empty($application_id)) {
            $applicantLoginDetails = $entrance_model->getRecordByAppNo($application_id);
            //$paymentData = $paymentData->getsavedData($application_no);
            //echo"<pre>";print_r($paymentData);
            $this->view->paginator = $applicantLoginDetails;
        }
    }

    public function documentDashboardAction() {
        $allFormData = new Application_Model_ApplicantCourseDetailModel();
        $paymentData = new Application_Model_ApplicantPaymentDetailModel();
        $application_no = $this->_getParam("a_id");
        $this->view->a_id = $application_no;
        $paymentData = $paymentData->check_for_status($application_no);
        //echo '<pre>'; print_r($paymentData); exit;
        $this->view->payment_detail = $paymentData;
    }

    public function admitCardPreviewAction() {
        
        $allFormData = new Application_Model_ApplicantCourseDetailModel();
        $paymentData = new Application_Model_ApplicantPaymentDetailModel();
        $application_no = $this->_getParam("application_no");
        echo $application_no;
        die();
        $this->view->a_id = $application_no;
        if (!empty($application_no)) {
            $formFilledData = $allFormData->getAllFormFilledData($application_no);
            $paymentData = $paymentData->getsavedData($application_no);
          //  echo"<pre>";print_r($paymentData);
            $this->view->paginator = $formFilledData;
            $this->view->payment_detail = $paymentData;
        }
    }

    public function applicationFormPreviewAction() {
        // echo "hii"; die;
        $allFormData = new Application_Model_ApplicantCourseDetailModel();
        $paymentData = new Application_Model_ApplicantPaymentDetailModel();
        $application_no = $this->_getParam("application_no");
        $this->view->a_id = $application_no;
        if (!empty($application_no)) {
            $formFilledData = $allFormData->getAllFormFilledData($application_no);
            $paymentData = $paymentData->getsavedData($application_no);

            $this->view->paginator = $formFilledData;
            $this->view->payment_detail = $paymentData;
        }
    }

    public function casteCertifiatePreviewAction() {
        $allFormData = new Application_Model_ApplicantCourseDetailModel();
        $paymentData = new Application_Model_ApplicantPaymentDetailModel();
        $application_no = $this->_getParam("application_no");
        $this->view->a_id = $application_no;
        if ($application_no) {
            $formFilledData = $allFormData->getAllFormFilledData($application_no);
            $paymentData = $paymentData->getsavedData($application_no);
            //echo"<pre>";print_r($formFilledData);exit;
            $this->view->paginator = $formFilledData;
            $this->view->payment_detail = $paymentData;
        }
    }

    public function forgotPasswordAction() {
        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
        $this->accessConfig->setAccess('SA_ACAD_ENTRANCE_EXAM_FORM');
        $entrance_form = new Application_Form_EntranceExam();
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        $this->view->form = $entrance_form;
        if ($this->getRequest()->isPost()) {
           // if ($entrance_form->isValid($this->getRequest()->getPost())) {
                $data = $_POST;
                $emailData = array(
                    'email_id' => trim(strtolower($data['email_id']))
                );
                //echo "<pre>";print_r($data);exit;
                if ($emailData) {


                    $check_email = $entrance_model->checkEmail($emailData);
    //echo "<pre>"; print_r($check_email);exit;
                    if (empty($check_email)) {

                        $_SESSION['flash_message_error'] = "Please enter active and valid email-Id, which is registered with us.";
                    } else {
                        $to = array(strtolower(trim($check_email['email_id'])));
                        $from = array('support@finessewebtech.com', 'Patna Women\'s college');
                        $first_name = $check_email['applicant_name'];
                        $subject = "Forgot Password";

                        $message .= "Dear $first_name , <br/><br/> Your login credentials for next step is as follows: <br/> Application No : {$check_email['application_no']} <br/> Password : {$check_email['password']} <br/> Please find the link below for login.<br/><br/>";
                        $message .= "<a href='https://pwcadmissions.in/academic/entrance-exam-form/login'>https://pwcadmissions.in/academic/entrance-exam-form</a>";
                        $mail = new Application_Model_MailSender($to, $from, $subject, $message);
// More headers
//$headers .= "From: <$from>" . "\r\n";
                        //echo "<pre>"; print_r($message);exit;
                        //echo"<pre>";print_r($insertLoginData);exit;
                $this->_mail['user'] = "noreply@pwcadmissions.in";
                $this->_mail['pass'] = "Em@l20Pwc";
                        if ($mail->mail($this->_mail['user'], $this->_mail['pass'])) {
                            $_SESSION['flash_message_error'] = "Mail Sent.";
                        } else {
                            $_SESSION['flash_message_error'] = "Sending Failed.";
                        }
                    }
                }
           // }
        }
    }

    //Ajax Area
    //Get Academic on degree id

    public function ajaxVerifyOtpAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            //$phone = $this->_getParam("phone"); // Recipient mobile number
            $phone_no = $this->_getParam("phone");
            $email_id = $this->_getParam("email_id");
            $inputOtp = $this->_getParam("inputOtp");
            $entrance_model = new Application_Model_ApplicantRegisterationModel();
            $validateOtp = $entrance_model->validateOtp($phone_no, $email_id, $inputOtp);
            if ($validateOtp) {
                echo $otpDisplay = 1;
            } else {
                echo $otpDisplay = 0;
            }
        }die;
    }

    public function ajaxCheckDuplicateEmailAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            //$phone = $this->_getParam("phone"); // Recipient mobile number
            $email_id = trim($this->_getParam("email_id"));
            $entrance_model = new Application_Model_ApplicantRegisterationModel();
            $checkemail = $entrance_model->checkRowfor_email_exist($email_id);
            if ($checkemail) {
                echo $otpDisplay = 1;
            } else {
                echo $otpDisplay = 0;
            }
        }die;
    }

    public function ajaxSendOtpAction() {
        if ($this->_request->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            //$phone = $this->_getParam("phone"); // Recipient mobile number
            $recipient_no = trim($this->_getParam("phone"));
            $email_id = trim($this->_getParam("email_id"));
            $entrance_model = new Application_Model_ApplicantRegisterationModel();
            $rand_no = rand(10000, 99999);
            //Check previous entry
            $conditions = $recipient_no;
            $checkPrev = $entrance_model->checkRow1($email_id);

            //Insert or update otp in the database
            if ($checkPrev) {
                $otpData = $rand_no;
                //echo $conditions;
                $insert = $entrance_model->updateOtp($otpData, $conditions, $email_id);
                //echo $insert;exit;
            } else {
                $otpData = array(
                    'phone' => $recipient_no,
                    'email_id' => $email_id,
                    'otp' => $rand_no
                );
                //echo "<pre>"; print_r($otpData);exit;
                $insert = $entrance_model->insert($otpData);
            }

            if ($insert) {
                // Send otp to user via SMS

                if ($this->_sms['default'] == 0)
                    $recipient_no = $recipient_no;
                else {
                    $recipient_no = $this->_sms['default'];
                }
                $message = "Dear Applicant,<br/> <br/>OTP for mobile verification is: <br/> OTP No : $rand_no <br/>";
                $phoneMsg = "Dear Applicant,\n \n OTP for mobile verification is: \n OTP No : $rand_no \n";
                $message .= "<br/>Thanks";
                $send = $this->SMSSend($recipient_no, $phoneMsg);
                //Code to Send Otp On mail Date:20 Feb 2020
                $user = "noreply@pwcadmissions.in";
                $password = "Em@l20Pwc";
                $to = array(strtolower($email_id));
                $from = array('noreply@pwcadmissions.in', 'Patna Women\'s college');
                $subject = "Otp for mobile verification";


                $mail = new Application_Model_MailSender($to, $from, $subject, $message);


                if ($mail->mail($this->_mail['user'], $this->_mail['pass'])) {
                    
                } else {
                    
                }
                if ($send) {
                    echo $otpDisplay = 1;
                } else {
                    echo $otpDisplay = 0;
                }
            } else {
                echo $otpDisplay = 0;
            }
        } else {
            echo $otpDisplay = 0;
        }die;
    }

    public function SMSSend($phone, $msg, $debug = false) {
        $user = $this->_sms['user'];

        $password = $this->_sms['password'];

        $senderid = $this->_sms['senderid'];

        $smsurl = $this->_sms['smsurl'];

        $dnd = $this->_sms['dnd'];
        $priority = $this->_sms['priority'];

        $url = 'username=' . $user;
        $url .= '&password=' . $password;
        $url .= '&sender=' . $senderid;
        $url .= '&to=' . urlencode($phone);
        $url .= '&message=' . urlencode($msg);
        $url .= '&priority=' . $priority;
        $url .= '&dnd=' . $dnd;
        $url .= '&unicode=0';


        $urltouse = $smsurl . $url;
        if ($debug) {
            echo "Request: <br>$urltouse<br><br>";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urltouse);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //Open the URL to send the message
        //$response = httpRequest($urltouse);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($debug) {
            echo "Response: <br><pre>" .
            str_replace(array("<", ">"), array("&lt;", "&gt;"), $response) .
            "</pre><br>";
        }
        return($response);
    }

    public function developertestAction() {

        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
        $this->accessConfig->setAccess('SA_ACAD_ENTRANCE_EXAM_FORM');
        $entrance_form = new Application_Form_EntranceExam();
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        $courseModel = new Application_Model_ApplicantCourseDetailModel();
        $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
        $this->view->form = $entrance_form;

        if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->getPost()) {

                $data = $_POST;

                $loginData = array(
                    'application_no' => trim(strtoupper($data['applicant_no'])),
                    'password' => trim($data['password'])
                );



                $check_login = $entrance_model->checkLogin($loginData);


                if (empty($check_login)) {
                    $this->view->invalid = 'Invalid';
                    $_SESSION['flash_message_error'] = "Invalid application number or password. Please try again.";
                } else {
                    $applicatonNumber = trim(strtoupper($data['applicant_no']));
                    //Check Form Status
                    $check_applicationStatus = $courseModel->check_form_status($applicatonNumber);
                    //Check Payment Status
                    $check_payment_status = $paymentModel->check_payment_status($applicatonNumber);

                    // echo '<pre>'; print_r($check_payment_status); exit;
                    foreach ($check_payment_status as $pay) {
                        if ($pay['payment_status'] == 1) {
                            $this->_redirectJs("entrance-exam-form/document-dashboard/a_id/" . md5($data['applicant_no']));
                        }
                    }
                    if ($check_applicationStatus['form_status'] === 'okey') {
                        $this->_redirectJs("multi-step-form/index/type/step5/a_id/" . md5($applicatonNumber));
                    } else {
                        $this->_redirectJs("multi-step-form/index/type/step1/a_id/" . md5($loginData['application_no']));
                    }
                }
            }
        }
    }
public function loginAction() {

        $this->view->action_name = 'application';
        $this->view->sub_title_name = 'entrance_exam_form';
       $this->accessConfig->setAccess('SA_ACAD_ENTRANCE_EXAM_FORM');
       $this->accessConfig->setAccess('SA_ACAD_STUD');
        $entrance_form = new Application_Form_EntranceExam();
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        $courseModel = new Application_Model_ApplicantCourseDetailModel();
        $paymentModel = new Application_Model_ApplicantPaymentDetailModel();
        $user_log = new Application_Model_UserLog();
        $examschedule = new Application_Model_EntranceExamScheduleModel();
        $this->view->form = $entrance_form;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        //echo '<pre>'; print_r($token);exit;
       
        
       
            if ($this->getRequest()->getPost()) {
            $data = $this->getRequest()->getPost();
            
            if(!empty($data['csrftoken'])) {
                if($data['csrftoken']===$token ){
                  

                $loginData = array(
                    'application_no' => trim(strtoupper($data['applicant_no'])),
                    'password' => trim($data['password'])
                );
                 $check_login = $entrance_model->checkLogin($loginData);
//echo '<pre>'; print_r($check_login);exit;

                if (empty($check_login)) {
                    $this->view->invalid = 'Invalid';
                    $_SESSION['flash_message_error'] = "Invalid registration number or password. Please try again.";
                } else {
                    
                    

                    $applicatonNumber = trim(strtoupper($data['applicant_no']));

                    //Implement session
                    $storage = new Zend_Session_Namespace("user_login");
                    $user_detail['app_id'] = $applicatonNumber;
                    $storage->user_login = $user_detail;
                    $storage->unique_id = uniqid() . rand() . time(date("Y-m-d H:i:s"));
                    setcookie('user_login_status', md5($storage->unique_id), time() + (60 * $this->cookie_expire), "/; samesite=Lax", "", true, true);
                    $userdata['empl_id'] = $user_detail['app_id'];
                    $userdata['last_login'] = date("Y-m-d H:i:s");
                    $userdata['ip'] = $_SERVER['REMOTE_ADDR'];
                    $userdata['unique_id'] = $storage->unique_id;
                    $userdata['sess_vlue'] = $_COOKIE['PHPSESSID'];
                    // echo "<pre>";print_r($userdata);exit;
                    $user_log->insert($userdata);
                   
                    unset($_SESSION["token"]);
                   $this->_redirect("entrance-exam-form");
                    //End
                    //Check Form Status
                    $check_applicationStatus = $courseModel->check_form_status($applicatonNumber);
                    //Check Payment Status
                    $check_payment_status = $paymentModel->check_payment_status($applicatonNumber);

                    //echo '<pre>'; print_r($check_payment_status); exit;
                    
                    foreach ($check_payment_status as $pay) {
                        if ($pay['payment_status'] == 1) {
                            $this->_redirectJs("entrance-exam-form/document-dashboard/a_id/" . md5($data['applicant_no']));
                        }
                    }
                   
                    if ($check_applicationStatus['form_status'] === 'okey')
                    {
                    
                        $this->_redirectJs("multi-step-form/index/type/step4/a_id/" . md5($applicatonNumber));
                    } else 
                    {
                        $this->_redirectJs("multi-step-form/index/type/step1/a_id/" . md5($loginData['application_no']));
                    }
                    
                }
            }else{
                //echo '<pre>';print_r('tokenInvalid');exit;
                $this->view->tokenInvalid = 'tokenInvalid';
                $_SESSION['flash_token_error'] = "Invalid Token";
                
            }
        }
    }
         
}
public function sendmail($to,$message){
    $to = $to[0];
$subject = "PWC Application Form 2023";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <support@finessewebtech.com>' . "\r\n";
    mail($to,$subject,$message,$headers);

    
    
}


	public function newregisterationAction() {
        $multi_step_entrance_form = new Application_Form_MultiStepEntranceExamForm();
        $Form_validation = new Application_Model_FormValidation();
        $this->view->form = $multi_step_entrance_form;
        $type = $this->_getParam("type");
        $application_id = $this->_getParam("a_id");
        $this->view->a_id = $application_id;
        $entrance_model = new Application_Model_ApplicantRegisterationModel();
        $applicantCourseDetailModel = new Application_Model_ApplicantCourseDetailModel();
        $applicantEducationalDetailModel = new Application_Model_ApplicantEducationalDetailModel();
        $applicantPersonalDetailModel = new Application_Model_ApplicantPersonalDetailModel();
        $applicantPaymentDetailModel = new Application_Model_ApplicantPaymentDetailModel();
          $examschedule = new Application_Model_EntranceExamScheduleModel();
        $this->view->type = $type;
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
      
        $token = $_SESSION['token']; 
        switch ($type) {
           
            case "step1":
                  $this->_helper->layout->setLayout("applicationlayout");
//                 $allrecords = $examschedule->getRecords();
//        foreach ($allrecords as $record)
//        $strdate = $record['feeForm_start_date'];
//        $enddate = $record['feeForm_end_date'];
//        $curdate = date('Y-m-d');
//        if($curdate<$strdate)
//                   {
//                     $this->_refresh(5,"https://pwcadmissions.in/",'*Entrance exam Schedule Not Start or End Date....');
//                    }else if($curdate>$enddate)
//                    {
//                           $this->_refresh(5,"https://pwcadmissions.in/",'*Entrance exam Schedule Not Start or End Date....');
//                    }else
//                    {
                //echo '<pre>'; print_r($_SESSION);exit;
                if($application_id){
                    $followUpData = $entrance_model->getRecordByAppNo($application_id);
                    $populateData = $applicantCourseDetailModel->getsavedData($application_id);
                   $this->view->degree = $followUpData['degree'];
                    $this->view->department = $followUpData['department'];
                    $this->view->course = $followUpData['course'];
                 //   echo '<pre>'; print_r($followUpData);exit;
                      $academic_model = new Application_Model_Academic();
                    $result = $academic_model->getSessionByCourseId($followUpData['degree']);
                    $this->view->session_id = $result[0]['session_id'];
                       //  echo '<pre>'; print_r($result[0]['session_id']);
                    if($populateData){
                        
                        $multi_step_entrance_form->populate($populateData);
                        
                        $this->view->paginator = $populateData;
                       
                    }
                    if ($this->getRequest()->getPost()) {
                        $data = $this->getRequest()->getPost();
                        //echo '<pre>'; print_r($data);exit;
                        if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                            if(empty($data['course']))
                                    $this->_refresh(3,$this->base_url."multi-step-form/index/type/step1/a_id/{$application_id}",'Course field is missing....');
                            if($data['degree_id'] == 1){

                                if(empty($data['firstChoice']))
                                    $this->_refresh(3,$this->base_url."multi-step-form/index/type/step1/a_id/{$application_id}",'Core Course field is missing....');
                                if(empty($data['geFirst']))
                                    $this->_refresh(3,$this->base_url."multi-step-form/index/type/step1/a_id/{$application_id}",'Generic Elective field is missing....');
                            }
                            //echo '<pre>'; print_r($data);exit;
                            if(empty($this->getRequest()->getPost('firstChoice'))){   
                                $data['firstChoice'] ='0';
                            }
                            if(empty($this->getRequest()->getPost('geFirst'))){   
                                $data['geFirst'] ='0';
                            }
                            if(empty($this->getRequest()->getPost('secondChoice'))){   
                                $data['secondChoice'] ='0';
                            }
                            if(empty($this->getRequest()->getPost('geSecond'))){   
                                $data['geSecond'] ='0';
                            }
                            if(empty($this->getRequest()->getPost('aecc2'))){   
                                $data['aecc2'] ='0';
                            }
                            //For User Id
                            if(isset($_SESSION['user_login']['user_login']))
                                $empl_id=$_SESSION['user_login']['user_login']['app_id'];
                            if(isset($_SESSION['admin_login']['admin_login']))
                                $empl_id=$_SESSION['admin_login']['admin_login']->user_id;
                            $applicantCourseData = array(
                               'application_no' => $followUpData['application_no'],
                               'applicant_name' => $followUpData['applicant_name'],
                               'email_id' => $followUpData['email_id'],
                               'phone' => $followUpData['phone_number'],
                               'degree_id' => $data['degree_id'],
                               'course' => $data['course'],
                               'session' => $data['session'],
                               'core_course1' =>$data['firstChoice'],
                               'ge1' =>$data['geFirst'],
                               'aecc1' => $data['aecc1'],
                               'core_course2' => $data['secondChoice'],
                               'ge2' => $data['geSecond'], 
                               'aecc2' => $data['aecc2'],
                               'comp_evs' => $data['evs1'],
                               'srutiny_flag'=>1,
                               'scrutiny_date'=> date('Y-m-d'),
                               'user_id'=>$empl_id,
                               'ip_address'=> $_SERVER['REMOTE_ADDR']
                            );
                        //    echo $data['degree_id'];die;
                            $entrance_model->update(array('degree'=>$data['degree_id'],'department' => $data['course'],'course' => ''),array('application_no=?' => $followUpData['application_no']));

                        $savedData = $applicantCourseDetailModel->getsavedData($application_id);
                        unset($_SESSION["token"]);
                        if($savedData){
                            //echo '<pre>'; print_r($applicantCourseData);exit;
                                $applicantCourseDetailModel->update($applicantCourseData,array('application_no=?' => $savedData['application_no']));
                                $paymentTableUpdateData = array(
                                    'course'=>$data['course'],
                                    'srutiny_flag'=>1,
                                    'scrutiny_date'=> date('Y-m-d')
                                );
                                //echo '<pre>'; print_r($savedData);exit;
                                $updatePaymentTable=$applicantPaymentDetailModel->update($paymentTableUpdateData,array('application_no=?' => $savedData['application_no']));
                                if($updatePaymentTable){
                                $this->_redirect("multi-step-form/index/type/step2/a_id/{$application_id}");
                                }else{
                                    echo 'Update Failed.';
                                    $this->_redirect("multi-step-form/index/type/step2/a_id/{$application_id}");
                                }

                        }else{
                            //echo '<pre>'; print_r($applicantCourseData);exit;
                            $applicantCourseDetailModel->insert($applicantCourseData);
                            if($applicantCourseDetailModel){
                                $this->_redirect("multi-step-form/index/type/step2/a_id/{$application_id}"); 

                            }else{
                                $this->_redirect("multi-step-form/index/type/step1/a_id/{$application_id}"); 
                            }
                        }
                }else{
                    $this->_refresh(3,$this->_base_url."multi-step-form/index/type/step1/a_id/{$application_id}",'Invalid Token ..');
                }
                }
            }
        }
                    //}
                
                break;
            case 'step2':
               $this->_helper->layout->setLayout("applicationlayout");
                $applicantPersonalDetailForm = new Application_Form_MultiStepExamFormStep2();
               
                $this->view->form = $applicantPersonalDetailForm;
                
                  //echo $application_id;
                if($application_id){
                    $followUpData = $entrance_model->getRecordByAppNo($application_id);
                   // echo '<pre>'; print_r($followUpData);exit;
                    $applicantPersonalDetailForm->populate($followUpData);
                    
                    $populatedData = $applicantPersonalDetailModel->getsavedData($application_id);
                  //  echo '<pre>'; print_r($populatedData);exit;
                    if(!empty($populatedData)){
                          //echo '<pre>'; print_r($populatedData);exit;
                          $this->view->p=$populatedData['p_postOffice'];
                          $this->view->b=$populatedData['p_homeTown'];
                          $this->view->d=$populatedData['p_district'];
                          $this->view->s=$populatedData['p_state'];
                          $this->view->c=$populatedData['oth_country'];
                          
                          $this->view->l_postOffice=$populatedData['l_postOffice'];
                          $this->view->l_homeTown=$populatedData['l_homeTown'];
                          $this->view->l_district=$populatedData['l_district'];
                          $this->view->l_state=$populatedData['l_state'];
                          $this->view->oth_country=$populatedData['oth_country'];
                           
                        $applicantPersonalDetailForm->populate($populatedData);
                   
                        $this->view->paginator = $populatedData;
                    }
                       
                        if ($this->getRequest()->getPost()) {
                        $data = $this->getRequest()->getPost();
                        //echo '<pre>'; print_r($data);exit;
                        if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                           
                            if($data['religion'] !== 'others'){
                                unset($data['others_religion']);
                            }
                           
                       $applicantPersonalData = array(
                               'application_no' => $followUpData['application_no'],
                               'applicant_name' => strtoupper($data['applicant_name']),
                               'email_id' =>$data['email_id'],
                               'phone_number' => $data['phone_number'],
                               'dob_date' => $data['dob_date'],
                               'gender' =>$data['gender'],
                               'aadhar_number' =>$data['aadhar_number'],
                               'nationality' => $data['nationality'],
                               'religion' => $data['religion'],
                               'others_religion' => $data['others_religion'],
                               'father_name' => strtoupper($data['father_name']), 
                               'father_qual' => $data['father_qual'],
                               'father_occup' => $data['father_occup'],
                               'mother_name' => strtoupper($data['mother_name']),
                               'mother_qual' => $data['mother_qual'],
                               'mother_occup' => $data['mother_occup'],
                               'guard_name' => strtoupper($data['guard_name']),
                               'guard_qual' => $data['guard_qual'],
                               'guard_occup' => $data['guard_occup'],
                               'guard_contact' =>$data['guard_contact'],
                               'father_contact' =>$data['father_contact'],
                               'mother_contact' =>$data['mother_contact'],
                               'p_address' =>$data['p_address'],
                               'p_homeTown' => $data['p_homeTown'],
                               'p_postOffice' => $data['p_postOffice'],
                               'p_policeSt' => $data['p_policeSt'], 
                               'p_district' => $data['p_district'],
                               'p_state' => $data['p_state'],
                               'p_code_number' =>$data['p_code_number'],
                               'same_address' =>$data['sameAddress'],
                               'l_address' =>$data['l_address'],
                               'l_homeTown' => $data['l_homeTown'],
                               'l_postOffice' => $data['l_postOffice'],
                               'l_policeSt' =>$data['l_policeSt'], 
                               'l_district' => $data['l_district'],
                               'l_state' => $data['l_state'],
                               'l_code_number' => $data['l_code_number'],
                               'blood_group' =>$data['blood_group'],
                               'country' => $data['country'],
                               'oth_country' => $data['oth_country'],
                               'i_country' =>$data['sameAddress']==1?$data['country']:((!empty($data['i_country']) && is_numeric($data['i_country']))?1:2),
                               'i_oth_country' => !empty($data['i_country']) && !is_numeric($data['i_country'])?ucwords($data['i_country']):$data['oth_country'],
                           );
                           
                         $savedData = $applicantPersonalDetailModel->getsavedData($application_id);
                         unset($_SESSION["token"]);
                         if($savedData){
                            
                            $applicantPersonalDetailModel->update($applicantPersonalData,array('application_no=?' => $savedData['application_no']));
                       
                             $this->_redirect("multi-step-form/index/type/step3/a_id/{$application_id}"); 
                        
                           
                    }else{
                             
                        $applicantPersonalDetailModel->insert($applicantPersonalData); 
                        if($applicantPersonalDetailModel){
                            $this->_redirect("multi-step-form/index/type/step3/a_id/{$application_id}"); 
                            $this->view->type = 'step3'; 
                        }else{
                            $this->_redirect("multi-step-form/index/type/step2/a_id/{$application_id}"); 
                        }
                    } 
                    
                }else{
                    $this->_refresh(3,$this->_base_url."multi-step-form/index/type/step2/a_id/{$application_id}",'Invalid Token ..');
                }
            }
        }
    }
                
                break;
            case 'step3':
                $this->_helper->layout->setLayout("applicationlayout");
                $applicantEducationalDetailForm = new Application_Form_MultiStepExamFormStep3();
                $this->view->form = $applicantEducationalDetailForm;
                if($application_id){
                    $followUpData = $applicantCourseDetailModel->getRecordByAppNo($application_id);
                    $this->view->followup = $followUpData;
                    //echo '<pre>'; print_r($followUpData); exit;
                    $app_number=$followUpData['application_no'];
                    $populatedData = $applicantEducationalDetailModel->getsavedData($application_id);
                    //echo '<pre>'; print_r($populatedData);exit;
                    if(!empty($populatedData)){
                        $applicantEducationalDetailForm->populate($populatedData);
                        $this->view->paginator = $populatedData;     
                    }
                       //echo '<pre>'; print_r($_POST); exit;
                       if ($this->getRequest()->getPost()) {
                        $data = $this->getRequest()->getPost();
                       // echo '<pre>'; print_r($data);exit;
                        if(!empty($data['csrftoken'])) {
                        if($data['csrftoken']===$token ){
                        //echo '<pre>'; print_r($data); exit;
                        $dirPath1 = realpath(APPLICATION_PATH . '/../public/images') .'/applicant_photo/';
                        $dirPath2 = realpath(APPLICATION_PATH . '/../public/images') .'/applicant_edu_certificate/';
                        $dirPath3 = realpath(APPLICATION_PATH . '/../public/images') .'/applicant_caste_certificate/';
                        $dirPath4 = realpath(APPLICATION_PATH . '/../public/images') .'/applicant_baptism/';

                        if (!file_exists($dirPath1)) {
                            mkdir($dirPath1, 755, true);
                        }
                        if (!file_exists($dirPath2)) {
                            mkdir($dirPath2, 755, true);
                        }
                        if (!file_exists($dirPath3)) {
                            mkdir($dirPath3, 755, true);
                        }
                        if (!file_exists($dirPath4)) {
                            mkdir($dirPath4, 755, true);
                        }
                            if(!empty($_FILES['casteCertificate']['name'])){
                                $caste_temp = explode(".", $_FILES["casteCertificate"]["name"]);
                                $casteCertificate = $app_number . '.' . end($caste_temp);
                                $cast_temp = $_FILES['casteCertificate']['tmp_name'];
                                //echo $_FILES["casteCertificate"]["name"];exit;
                            }
                            
                            if(!empty($_FILES['educertificate']['name'])){
                                $marks_temp = explode(".", $_FILES["educertificate"]["name"]);
                                $marks_sheet = $app_number . '.' . end($marks_temp);
                                $edu_temp = $_FILES['educertificate']['tmp_name'];
                            }
                            
                            if(!empty($_FILES['photo']['name'])){
                                $tem_name = $_FILES['photo']['tmp_name'];
                                $temp = explode(".",$_FILES["photo"]["name"]);
                                $photo = $app_number . '.' . end($temp);
                            }
                            
                            if(!empty($_FILES['baptism']['name'])){
                                $temp_baptism = explode(".", $_FILES["baptism"]["name"]);
                                $baptism = $app_number . '.' . end($temp_baptism);
                                $bapt_temp=$_FILES['baptism']['tmp_name'];
                            }
                            
                        //For Mime Type Check
                        $image_mime_edu = $this->getMimeType($edu_temp);    
                        $image_mime_caste = $this->getMimeType($cast_temp);    
                        $image_mime_photo = $this->getMimeType($tem_name);      
                        $image_mime_bapt = $this->getMimeType($bapt_temp);    
                            
                        //echo '<pre>'; print_r($image_mime_photo);exit;    
                        $EduFileextensionName = explode (".", $_FILES['educertificate']['name']); 
                        $CasteFileextensionName = explode (".", $_FILES['casteCertificate']['name']); 
                        $baptFileextensionName = explode (".", $_FILES['baptism']['name']); 
                        $photoFileextensionName = explode (".", $_FILES['photo']['name']); 
                        //echo '<pre>'; print_r($FileextensionName[1]);exit;
                        $array = array(
                            pdf => 'pdf', 
                            PDF =>'PDF',
                            jpg => 'jpg',
                            jpeg => 'jpeg', 
                            PNG => 'PNG',
                            JPG=>'JPG',
                            png=>'png'
                        );
                        $photoArray = array( 
                            jpg => 'jpg',
                            jpeg => 'jpeg', 
                            PNG => 'PNG',
                            JPG=>'JPG',
                            png=>'png'
                            
                        );
                        $eduCertValidate = array_search($EduFileextensionName[1],$array);
                        $casteCertValidate = array_search($CasteFileextensionName[1],$array);
                        $baptCertValidate = array_search($baptFileextensionName[1],$array);
                        $photoCertValidate = array_search($photoFileextensionName[1],$photoArray);
                        //echo '<pre>'; print_r($eduCertValidate);exit;
                        
                            if(file_exists($_FILES['casteCertificate']['tmp_name'])){
                                if(!empty($casteCertValidate) && !empty($image_mime_caste)){
                                move_uploaded_file($cast_temp, $dirPath3 . $casteCertificate);
                                }else{
                            $this->_refresh(3,$this->_base_url."multi-step-form/index/type/step3/a_id/{$application_id}",'Invalid Image Type ..');
                                 }
                            }
                            else{
                               move_uploaded_file($cast_temp, $dirPath3 . $casteCertificate);
                            }
                            
                                //echo '<pre>'; print_r($eduCertValidate);exit;
                        
                            if(file_exists($_FILES['educertificate']['tmp_name']) && !empty($image_mime_edu)){
                                
                                if(!empty($eduCertValidate)){
                                    move_uploaded_file($edu_temp, $dirPath2 . $marks_sheet);
                                } else{
                                    
                            $this->_refresh(3,$this->_base_url."multi-step-form/index/type/step3/a_id/{$application_id}",'Invalid Image Type ..');
                                }
                            }
                            else{
                                move_uploaded_file($edu_temp, $dirPath2 . $marks_sheet);
                            }
                        
                        
                            if(file_exists($_FILES['baptism']['tmp_name'])){
                                if(!empty($baptCertValidate) && !empty($image_mime_bapt)){
                                //move_uploaded_file($sign_temp, $dirPath4 . $baptism);
                                move_uploaded_file($bapt_temp, $dirPath4 . $baptism);
                                
                                }else{
                            $this->_refresh(3,$this->_base_url."multi-step-form/index/type/step3/a_id/{$application_id}",'Invalid Image Type ..');
                                }
                            }
                            else{
                                //move_uploaded_file($sign_temp, $dirPath4 . $baptism);
                                move_uploaded_file($bapt_temp, $dirPath4 . $baptism);
                            }
                        
                        
                            if(file_exists($_FILES['photo']['tmp_name'])){
                                if(!empty($photoCertValidate) && !empty($image_mime_photo)){
                                  // echo $dirPath1 . $photo; die;
                                  if (file_exists($dirPath1 . $photo)) {

                                        chmod($dirPath1 . $photo, 0644);
                                            unlink($dirPath1 . $photo);
                                        } 
                                    move_uploaded_file($tem_name, $dirPath1 . $photo);
                                }else{
                            $this->_refresh(3,$this->_base_url."multi-step-form/index/type/step3/a_id/{$application_id}",'Invalid Image Type ..');
                                }
                            }
                            else{
                                move_uploaded_file($tem_name, $dirPath1 . $photo);
                            }
                        

                        if(file_exists($_FILES['photo']['tmp_name'])){
                            if(!move_uploaded_file($tem_name, $dirPath1 . $photo))
                            { 
                                  switch ($_FILES['photo']['error']) {
                                    case 1:
                                        echo "Exceed File size limit ..Please Upload your photo size 50 to 100kb <br/><a href ='$this->base_url.multi-step-form/index/type/step3/a_id/{$application_id}'>Back</a>";
                                        header( "refresh:3;url=$this->base_url.multi-step-form/index/type/step3/a_id/{$application_id}" );die;
                                        break;
                                    default:
                                        continue;
                                    }
                                    
                                
                            }
                        }
                        else{
                            if(!move_uploaded_file($tem_name, $dirPath1 . $photo))
                            { 
                                switch ($_FILES['photo']['error']) {
                                    case 1:
                                        echo "Exceed File size limit ..Please Upload your photo size 50 to 100kb <br/><a href ='$this->base_url.multi-step-form/index/type/step3/a_id/{$application_id}'>Back</a>";
                                         header( "refresh:3;url=$this->base_url.multi-step-form/index/type/step3/a_id/{$application_id}" );die;
                                        break;
                                    default:
                                        continue;
                                    }
                                   
                                
                            }
                        }
                        
                          
                        $file_edu['educertificate'] = "public/images/applicant_edu_certificate/" .$marks_sheet;
                        $file_caste['casteCertificate'] = "public/images/applicant_caste_certificate/" .$casteCertificate;
                        $file_sign['baptism'] = "public/images/applicant_baptism/" .$baptism;
                        $file_photo['photo'] = "public/images/applicant_photo/" .$photo;
                        
                        $data['ExtraCurricularSelection']= implode(',',$data['ExtraCurricularSelection']);
                        $data['application_no'] =  $followUpData['application_no'];
                        $data['applicant_name'] =  $followUpData['applicant_name'];
                        $data['email_id'] =  $followUpData['email_id'];
                        $data['phone'] =  $followUpData['phone'];
                        
                        $data['educertificate'] = $file_edu['educertificate'];
                        $data['casteCertificate'] =$file_caste['casteCertificate'];
                        $data['photo'] = $file_photo['photo'];
                        $data['baptism'] = $file_sign['baptism'];
                        
                        $savedData = $applicantEducationalDetailModel->getsavedData($application_id);  
                        unset($_SESSION["token"]);
                        //echo '<pre>'; print_r($savedData); exit;
                        if($savedData){
                                //echo '<pre>'; print_r($_FILES);exit;
                                if(empty($_FILES['photo']['name'])){
                                    unset($data['photo']); 
                                }
                                if(empty($_FILES['baptism']['name'])){
                                    unset($data['baptism']);
                                }
                                if(empty($_FILES['educertificate']['name'])){
                                    unset($data['educertificate']); 
                                }
                                if(empty($_FILES['casteCertificate']['name'])){
                                    unset($data['casteCertificate']); 
                                }
                                if(empty($data['certificate_no'])){
                                    $data['certificate_no']='N/A';
                                }
                                if(empty($data['certificate_issued'])){
                                    $data['certificate_issued']='N/A';
                                }
                             //echo '<pre>'; print_r($data);exit;
                                unset($data['csrftoken']);
                                $applicantEducationalDetailModel->update($data,array('application_no=?' => $savedData['application_no']));
                            $this->_redirect("multi-step-form/index/type/step4/a_id/{$application_id}"); 
                           
                        }else{ 
                             //echo '<pre>'; print_r($data);exit;
                            if(empty($_FILES['baptism']['name'])){
                                unset($data['baptism']);
                            }
                            if(empty($_FILES['casteCertificate']['name'])){
                                unset($data['casteCertificate']); 
                            }
                            if(empty($_FILES['educertificate']['name'])){
                                unset($data['educertificate']); 
                            }
                             // echo '<pre>'; print_r($data);exit;
                                 unset($data['csrftoken']);
                                $insertData=$applicantEducationalDetailModel->insert($data);
                            
                             //echo '<pre>'; print_r($data.'sm');exit;
                            if($insertData){
                                $this->_redirect($this->base_url."multi-step-form/index/type/step4/a_id/{$application_id}"); 
                                $this->view->type = 'step4'; 
                            }else{
                                $this->_redirect($this->base_url."multi-step-form/index/type/step3/a_id/{$application_id}"); 
                            }
                        }
                    }else{
                    $this->_refresh(3,$this->base_url."multi-step-form/index/type/step3/a_id/{$application_id}",'Invalid Tokens..');
                    }
                }
            }
        }
                break;
                case 'step4':
                    $this->_helper->layout->setLayout("applicationlayout");
//                      $allrecords = $examschedule->getRecords();
//        foreach ($allrecords as $record)
//        $strdate = $record['feeForm_start_date'];
//        $enddate = $record['feeForm_end_date'];
//        $curdate = date('Y-m-d');
//        if($curdate<$strdate)
//                   {
//                     $this->_refresh(5,"https://pwcadmissions.in/",'*Entrance exam Schedule Not Start or End Date....');
//                    }else if($curdate>$enddate)
//                    {
//                           $this->_refresh(5,"https://pwcadmissions.in/",'*Entrance exam Schedule Not Start or End Date....');
//                    }else
//                    {
                    $allFormData = new Application_Model_ApplicantCourseDetailModel();
                    //echo $application_id; exit;
                    $application_no = $application_id;
                    if($application_no){
                        $formFilledData=$allFormData->getAllFormFilledData($application_no);         
                      //  echo"<pre>";print_r($formFilledData);exit;
                        $this->view->paginator = $formFilledData;
                    }
                    
                    break;
                case 'step5':
                    $this->_helper->layout->setLayout("applicationlayout");
                    $allFormData = new Application_Model_ApplicantCourseDetailModel();
                    $challanData= new Application_Model_ApplicantPaymentDetailModel();
                    $application_no = $application_id;
                    if($application_no){
                        $formFilledData=$allFormData->getAllFormFilledData($application_no);
                        $challan_no = $challanData->getChallan($application_no);
                        //echo"<pre>";print_r($formFilledData);exit;
                        $this->view->paymode = $this->_pay_mode;
                        $this->view->paginator = $formFilledData;
                        $this->view->challan = $challan_no;
                    }
                    break;
            default:
                break;
                
        }
    }


}
 