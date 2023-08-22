<?php

/* 
    Author: Kedar Kumar
    Summary: This Form is used to handle The Batch Attendance
    Date: 03 Oct. 2019
*/
class Application_Form_EntranceExam extends Zend_Form
{
	public function init()
	{
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        $csrftoken = $this->createElement('hidden', 'csrftoken')
                ->removeDecorator('label')->setAttrib('class', array('form-control'))
                ->setAttrib('required', 'required')
                ->setRequired(true)
                ->setValue($token)
                ->removeDecorator("htmlTag");
        $this->addElement($csrftoken);
        
        $applicant_name = $this->createElement('text', 'applicant_name')
                ->removeDecorator('label')->setAttrib('class', array('form-control form-control-lg'))
                ->setAttrib('placeholder',' name')
                ->setAttrib('required','required')->setRequired(true)
                ->setAttrib('data-toggle', 'albphabets')
                //->setAttrib('autocomplete', 'off')
                ->removeDecorator("htmlTag");
        $this->addElement($applicant_name);
        $applicant_number = $this->createElement('text', 'applicant_no')
                ->removeDecorator('label')->setAttrib('class', array('form-control form-control-lg'))
                ->setAttrib('required','required')->setRequired(true)
                //->setAttrib('autocomplete', 'off')
                ->removeDecorator("htmlTag");
        $this->addElement($applicant_number);
        $email = $this->createElement('text', 'email_id')
                ->removeDecorator('label')->setAttrib('class', array('form-control form-control-lg'))
                ->setAttrib('placeholder','example@gmail.com')
                ->setAttrib('required','required')->setRequired(true)
                ->setAttrib('pattern', '^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-z]+$')
                ->setAttrib('title', 'example@gmail.com')
                ->setRequired(true)
                   
                ->removeDecorator("htmlTag");
        $this->addElement($email);
        $mibile_no = $this->createElement('text', 'phone_number')
                ->removeDecorator('label')->setAttrib('class', array('form-control form-control-lg'))
                ->setAttrib('required','required')->setRequired(true)
                ->setAttrib('placeholder','mobile number')
                ->setAttrib('data-toggle', 'number')
                //->setAttrib('autocomplete', 'off')
                ->setAttrib('data-toggle', 'number')
                ->removeDecorator("htmlTag");
        $this->addElement($mibile_no);
		
		
		$whatsapp = $this->createElement('text', 'whatsapp_number')
                ->removeDecorator('label')->setAttrib('class', array('form-control form-control-lg'))
               // ->setAttrib('required','required')->setRequired(true)
                ->setAttrib('placeholder','wahtsapp number')
                ->setAttrib('data-toggle', 'number')
                //->setAttrib('autocomplete', 'off')
                ->setAttrib('data-toggle', 'number')
                ->removeDecorator("htmlTag");
        $this->addElement($whatsapp);
        
        $password = $this->createElement('password', 'password')
                ->removeDecorator('label')->setAttrib('class', array('form-control form-control-lg'))
                ->setAttrib('required','required')->setRequired(true)
                //->setAttrib('autocomplete', 'off')
                ->removeDecorator("htmlTag");
        $this->addElement($password);
        //$cnf_password = $this->createElement('text', 'cnf_password')
        ///        ->removeDecorator('label')->setAttrib('class', array('form-control'))
        //        ->setAttrib('required','required')->setRequired(true)
         //       //->setAttrib('autocomplete', 'off')
            //    ->removeDecorator("htmlTag");
       // $this->addElement($cnf_password);
		
		
		$session_model = new Application_Model_Session();
		$data = $session_model->getDropDownList();
		$session_id = $this->createElement('Select','session')
							->removeDecorator('label')
							->setAttrib('class',array('form-control form-control-lg','chosen-select'))
                            //->setAttrib('required','required')
							->addMultiOptions(array('' => 'Select'))
							->addMultiOptions($data)
                            
                           
							->removeDecorator("htmlTag");
                $this->addElement($session_id);
        $degree_model = new Application_Model_Degree();
        $data = $degree_model->getDropDownListBED();
        $degree_id = $this->createElement('select', 'degree_id')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control form-control-lg','chosen-select'))
                ->addMultioptions(array(''=>'Select'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($degree_id);
        $department_type_model = new Application_Model_DepartmentType();
        $data = $department_type_model->getDepartmentType();
        $department_type = $this->createElement('select', 'course')
                ->removeDecorator('label')
                ->setAttrib('required', 'required')->setRequired(true)
                ->setAttrib('class', array('form-control form-control-lg','chosen-select'))
                ->addMultioptions(array(''=>'Select'))
                ->addMultioptions($data)
                ->removeDecorator('htmlTag');
        $this->addElement($department_type);
        //Added: 07 o1ct 2020
        $Academic_year_model = new Application_Model_AcademicYear();
		$data = $Academic_year_model->getDropDownList1();
		//print_r($data); die;
		$year_id = $this->createElement('select','academic_year_list')
                    ->removeDecorator('label')
                    ->setAttrib('class',array('form-control form-control-lg','chosen-select'))
                    ->setAttrib('required','required')->setRequired(true)

                    ->addMultiOptions(array('' => 'Select'))
                    ->addMultiOptions($data)
                    ->removeDecorator("htmlTag");
        $this->addElement($year_id);
		
		
    }    
	
}
?>
